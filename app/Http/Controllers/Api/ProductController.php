<?php


namespace app\Http\Controllers\Api;


use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\ResponseInterface;
use App\Model\Product;

class ProductController
{
    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function index(Request $request)
    {
        /** @var Product $product */
        $product = app()->make(Product::class);

        $filters = [];

        if ($request->get('sku')) {
            $filters['sku'] = $request->get('sku');
        }

        return JsonResponse::create($product->getAll([], $filters), 200);
    }

    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function create(Request $request)
    {
        /** @var Product $product */
        $product = app()->make(Product::class);

        try {
            $product->findOrCreate(['nombre' => 'dasd', 'categoria'=>'1', 'precio'=>'10.50', 'imagen_url'=>'dasdsadas', 'sku'=>'dasdsa']);
        } catch (\Exception $exception) {
            return JsonResponse::create($exception->getMessage(), 200);
        }

        return JsonResponse::create($product->getAll([], ["sku" =>"dasdsa", "nombre" => "dasd", "precio" => "10.5"]), 200);
    }
}