<?php

namespace Core;

use PDO;

/**
 * A thin wrapper around PHP's PDO (PHP Data Objects) for MySQL queries.
 *
 * PDO is PHP's built-in database abstraction layer. This class simplifies
 * the prepare → execute → fetch cycle into a chainable API:
 *
 *   $db->query("SELECT * FROM plants WHERE user_id = :user_id", [
 *       "user_id" => 1,
 *   ])->get();
 *
 * All queries use prepared statements — parameter values are sent
 * separately from the SQL, so the database never interprets user
 * input as executable code. This prevents SQL injection.
 */
class Database
{
    /** @var PDO The underlying PDO connection. */
    public $connection;

    /** @var \PDOStatement|null The most recently prepared/executed statement. */
    public $statement;

    /**
     * Open a database connection.
     *
     * @param  array  $config    Connection parameters (host, port, dbname, charset).
     * @param  string $username  Database username.
     * @param  string $password  Database password.
     */
    public function __construct($config, $username = "root", $password = "")
    {
        // Build a DSN (Data Source Name) string like:
        //   "mysql:host=localhost;port=3306;dbname=rooted;charset=utf8mb4"
        // http_build_query normally creates "key=value&key=value" for URLs,
        // but passing ";" as the separator repurposes it for DSN format.
        $dsn = "mysql:" . http_build_query($config, "", ";");

        $this->connection = new PDO($dsn, $username, $password, [
            // Return rows as associative arrays (["id" => 1, "name" => "..."])
            // instead of the default mixed numeric + named arrays.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            // Throw exceptions on database errors instead of failing silently.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    /**
     * Prepare and execute a SQL query with optional parameters.
     *
     * Returns $this so you can chain ->get(), ->find(), or ->findOrFail().
     *
     * @param  string $query   SQL with named placeholders (e.g. ":user_id").
     * @param  array  $params  Values for the placeholders (e.g. ["user_id" => 1]).
     * @return $this
     */
    public function query($query, $params = []): self
    {
        // prepare() parses the SQL and returns a PDOStatement.
        // execute() binds the parameters and runs the query.
        // Splitting these two steps is what makes prepared statements safe —
        // the database knows which parts are SQL and which are data.
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    /**
     * Fetch all matching rows as an array of associative arrays.
     *
     * @return array  e.g. [["id" => 1, "name" => "Basil"], ["id" => 2, ...]]
     */
    public function get()
    {
        return $this->statement->fetchAll();
    }

    /**
     * Fetch the first matching row, or false if none found.
     *
     * @return array|false  A single row as an associative array, or false.
     */
    public function find(): array|false
    {
        return $this->statement->fetch();
    }

    /**
     * Fetch the first matching row, or abort with a 404 if none found.
     *
     * @return array  A single row as an associative array.
     */
    public function findOrFail(): array
    {
        $result = $this->find();

        if (!$result) {
            abort();
        }

        return $result;
    }

    /**
     * Get the ID of the last inserted row.
     *
     * Useful after an INSERT to retrieve the auto-increment ID.
     *
     * @return string  The last insert ID (as a string, per PDO convention).
     */
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
