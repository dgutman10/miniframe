<?php


namespace App\Model;

use App\Repository\Repository;
use App\Repository\RepositoryInterface;

abstract class Model
{
    protected $table;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct()
    {
        $this->setRepository(app()->make(Repository::class));
    }

    protected function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $fields = [], array $filters = [])
    {
        return $this->repository->findAll($this->table, $fields, $filters, get_called_class());
    }

    /**
     * @param $attributes
     * @return array|mixed
     * @throws \Exception
     */
    public function findOrCreate($attributes)
    {
        $results = $this->getAll([], $attributes);

        if (count($results) > 0) {
            throw new \Exception("ya existe el producto!");
        }

        return $this->repository->save($this->table, $attributes, get_called_class());
    }
}