<?php


namespace App\Http;


interface ResponseInterface
{
    /**
     * @param $data
     * @param $statusCode
     * @return mixed
     */
    static public function create($data, $statusCode);
}