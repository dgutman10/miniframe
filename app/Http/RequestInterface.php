<?php


namespace App\Http;


interface RequestInterface
{
    /**
     * Handle the request
     * @return ResponseInterface
     */
    public function handle();
}