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
    public static function connect(
        array $config,
        bool $withDatabase = true,
    ): PDO {
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
        $placeholders = implode(
            ", ",
            array_fill(0, count(self::REQUIRED_TABLES), "?"),
        );

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

        $statements = self::sqlStatements(
            file_get_contents(base_path("database/001-schema.sql")),
        );

        // The dump declares some foreign keys before the referenced table
        // exists (e.g. garden_media → garden_plants), so disable checks
        // while creating tables.
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

        try {
            foreach ($statements as $statement) {
                // Already handled above for the configured database name.
                if (preg_match("/^(CREATE\s+DATABASE|USE)\b/i", $statement)) {
                    continue;
                }

                $pdo->exec($statement);
            }
        } finally {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        }
    }

    /**
     * Check whether demo/seed data is already present (used to refuse a
     * second "Load Demo Data" run).
     *
     * Any existing plants or tags also count: the seed's plant_tag /
     * plant_meta rows assume plant and tag IDs start at 1, so loading it
     * on top of real content would mis-link rows.
     */
    public static function demoDataExists(PDO $pdo): bool
    {
        $demoUser = $pdo
            ->query(
                "SELECT COUNT(*) FROM users WHERE email = 'admin@rooted.local'",
            )
            ->fetchColumn();

        $content = $pdo
            ->query(
                "SELECT (SELECT COUNT(*) FROM plants) + (SELECT COUNT(*) FROM tags)",
            )
            ->fetchColumn();

        return (int) $demoUser > 0 || (int) $content > 0;
    }

    /**
     * Load database/002-seed.sql into the given (already selected) database.
     *
     * Runs inside a transaction so a failure leaves the database unchanged.
     * Skipped statements:
     *   - USE          (the connection already targets the configured DB)
     *   - settings     (preserve the admin's configured SMTP/app settings)
     *
     * @throws PDOException on any SQL failure (after rollback).
     */
    public static function runSeed(PDO $pdo): void
    {
        $statements = self::sqlStatements(
            file_get_contents(base_path("database/002-seed.sql")),
        );

        $pdo->beginTransaction();

        try {
            foreach ($statements as $statement) {
                if (
                    preg_match(
                        "/^(USE\b|INSERT\s+INTO\s+`?settings`?)/i",
                        $statement,
                    )
                ) {
                    continue;
                }

                $pdo->exec($statement);
            }

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();

            throw $e;
        }
    }

    /** Strip "--" comment lines and split a dump into single statements. */
    private static function sqlStatements(string $sql): array
    {
        $sql = preg_replace('/^\s*--.*$/m', "", $sql);

        return array_filter(array_map("trim", explode(";", $sql)));
    }
}
