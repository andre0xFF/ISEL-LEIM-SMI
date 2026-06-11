<?php

namespace Core;

use PDO;
use PDOException;

/**
 * First-run installer state detector.
 *
 * Inspects the configured database and reports which installation step
 * (if any) is still pending:
 *
 *   - "db_unavailable"  → can't reach the MySQL server with current config
 *   - "schema_missing"  → server reachable, but database/tables missing
 *   - "admin_missing"   → schema exists, but no admin user yet
 *   - "ready"           → fully installed, proceed normally
 */
class Installer
{
    /** Tables that must exist for the schema to be considered installed. */
    public const REQUIRED_TABLES = ["users", "settings", "plants", "tags"];

    /** Load the effective config (including any local override). */
    public static function config(): array
    {
        return require base_path("config.php");
    }

    /** Path where /install/database saves the local config override. */
    public static function localConfigPath(): string
    {
        return base_path("storage/config.local.php");
    }

    /**
     * Determine the current first-run state.
     *
     * @return string  One of: db_unavailable, schema_missing, admin_missing, ready.
     */
    public static function state(): string
    {
        $config = self::config();

        try {
            $pdo = self::connect($config, true);
        } catch (PDOException) {
            // The database itself may simply not exist yet — try a
            // server-level connection (no dbname) before giving up.
            try {
                self::connect($config, false);

                return "schema_missing";
            } catch (PDOException) {
                return "db_unavailable";
            }
        }

        if (!self::schemaExists($pdo, $config["database"]["dbname"])) {
            return "schema_missing";
        }

        try {
            $count = $pdo
                ->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")
                ->fetchColumn();
        } catch (PDOException) {
            return "schema_missing";
        }

        return ((int) $count) === 0 ? "admin_missing" : "ready";
    }

    /**
     * Open a temporary PDO connection for the given config array.
     *
     * @param array $config        Same shape as config.php.
     * @param bool  $withDatabase  Include dbname in the DSN or connect server-level only.
     */
    public static function connect(array $config, bool $withDatabase = true): PDO
    {
        $db = $config["database"];

        $dsn = "mysql:host={$db["host"]};port={$db["port"]};charset={$db["charset"]}";

        if ($withDatabase) {
            $dsn .= ";dbname={$db["dbname"]}";
        }

        return new PDO($dsn, $config["username"], $config["password"], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 3,
        ]);
    }

    /** Check that all REQUIRED_TABLES exist in the given database. */
    public static function schemaExists(PDO $pdo, string $dbname): bool
    {
        $placeholders = implode(", ", array_fill(0, count(self::REQUIRED_TABLES), "?"));

        $statement = $pdo->prepare(
            "SELECT COUNT(*) FROM information_schema.tables
             WHERE table_schema = ? AND table_name IN ({$placeholders})",
        );

        $statement->execute([$dbname, ...self::REQUIRED_TABLES]);

        return (int) $statement->fetchColumn() === count(self::REQUIRED_TABLES);
    }

    /**
     * Create the configured database (if needed) and run database/001-schema.sql.
     *
     * The dump hardcodes `CREATE DATABASE rooted` / `USE rooted`, so those
     * statements are skipped and replaced by equivalents targeting the
     * configured database name. 002-seed.sql is intentionally NOT run.
     *
     * @throws PDOException on any SQL failure.
     */
    public static function runSchema(array $config): void
    {
        $pdo = self::connect($config, false);

        $dbname = str_replace("`", "``", $config["database"]["dbname"]);

        $pdo->exec(
            "CREATE DATABASE IF NOT EXISTS `{$dbname}`
             CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
        );
        $pdo->exec("USE `{$dbname}`");

        $sql = file_get_contents(base_path("database/001-schema.sql"));

        // Strip "--" comment lines, then split into individual statements.
        $sql = preg_replace('/^\s*--.*$/m', "", $sql);
        $statements = array_filter(array_map("trim", explode(";", $sql)));

        // The dump declares some foreign keys before the referenced table
        // exists (e.g. garden_media → garden_plants), so disable checks
        // while creating tables.
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

        try {
            foreach ($statements as $statement) {
                // Already handled above for the configured database name.
                if (preg_match('/^(CREATE\s+DATABASE|USE)\b/i', $statement)) {
                    continue;
                }

                $pdo->exec($statement);
            }
        } finally {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        }
    }
}
