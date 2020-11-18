<?php


namespace App\Repository;


interface RepositoryInterface
{
    /**
     * @param $table
     * @param array $fields
     * @param $id
     * @param $class
     * @return mixed
     */
    public function find($table, array $fields, $id, $class);

    /**
     * @param $table
     * @param array $fields
     * @param array $filters
     * @param $class
     * @return mixed
     */
    public function findAll($table, array $fields, array $filters, $class);

    /**
     * @param $table
     * @param array $attributes
     * @param $class
     * @return mixed
     */
    public function save($table, array $attributes, $class);
}