<?php

namespace App\Http;


class JsonResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    static public function create($data, $statusCode)
    {
        http_response_code($statusCode);

        echo json_encode($data);
    }
}