<?php


namespace App\Repository;


use App\Database\MysqlConnector;

class Repository implements RepositoryInterface
{
    /**
     * @var MysqlConnector
     */
    private $connector;

    public function __construct(MysqlConnector $mysqlConnector)
    {
        $this->connector = $mysqlConnector;
    }

    /**
     * @inheritDoc
     */
    public function find($table, array $fields = [], $id, $class = false)
    {
        $sql = "select {$this->stringifyFields($fields)} from {$table} where id = {$id};";

        return $this->connector->query($sql, [], $class);
    }

    /**
     * @inheritDoc
     */
    public function findAll($table, array $fields = [], array $filters = [], $class = false)
    {
        $sql = "select {$this->stringifyFields($fields)} from {$table} {$this->stringifyFilters($filters)}";

        return $this->connector->query($sql, [], $class);
    }

    /**
     * @inheritDoc
     */
    public function save($table, array $attributes, $class)
    {
        $fields = implode(",", array_keys($attributes));
        $values = implode(",:$fields", array_values($attributes));
        $sql = "insert into {$table} ({$fields}) values ({$values})";

        return $this->connector->query($sql, $attributes, $class);
    }

    /**
     * @param array $fields
     * @return string
     */
    public function stringifyFields(array $fields)
    {
        return (count($fields) > 0)
            ? implode(" ", $fields)
            : "*";
    }

    /**
     * @param array $filters
     * @return string
     */
    public function stringifyFilters(array $filters)
    {
        $string = "";

        if (count($filters) == 0) {
            return $string;
        }

        $string = "where";
        $keys = array_keys($filters);
        for ($i=0; $i<count($filters); $i++) {
            $string .= " {$keys[$i]}='{$filters[$keys[$i]]}' ";
            if ($i+1 < count($filters)) {
                $string .= " and ";
            }
        }

        return $string;
    }
}