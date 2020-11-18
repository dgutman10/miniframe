<?php


namespace App\Database;


use PDO;
use PDOException;

class MysqlConnector
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct()
    {
        $host = config("database.host");
        $port = config("database.port");
        $dbname = config("database.dbname");
        $user = config("database.user");
        $passwd = config("database.passwd");

        $this->connection = new PDO("mysql:dbname={$dbname};host={$host};port={$port}", $user, $passwd);
    }

    public function query($sql, $binds, $className = false)
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($binds);

        return ($className)
            ? $statement->fetchAll(PDO::FETCH_CLASS, $className)
            : $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql)
    {
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $this->connection->exec($sql);
        } catch (PDOException $exception) {
            var_dump($exception->getMessage());
        }

    }

}