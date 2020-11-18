<?php


namespace app\Http\Controllers\Api;


use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\ResponseInterface;

class CategoryController
{
    /**
     * @param Request $request
     * @return ResponseInterface
     */
    public function index(Request $request)
    {
        return JsonResponse::create("categories", 200);
    }
}