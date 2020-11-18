<?php


namespace app\Http\Controllers\Api;


use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\ResponseInterface;
use App\Model\Category;

class CategoryController
{
    /**
     * @param Request $request
     * @return ResponseInterface
     */
    public function index(Request $request)
    {
        /** @var Category $categories */
        $categories = app()->make(Category::class);

        return JsonResponse::create($categories->getAll(), 200);
    }
}