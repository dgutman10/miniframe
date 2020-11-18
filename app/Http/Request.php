<?php


namespace App\Http;


use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

class Request implements RequestInterface
{
    /**
     * @var array|false
     */
    private $headers;

    /**
     * @var array|false
     */
    private $params;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->headers = getallheaders();
        $this->params = array_merge($_POST, $_GET);
    }

    /**
     * @param $name
     * @return string|null
     */
    public function header($name) {
        return (array_key_exists($name, $this->headers))
            ? $this->headers[$name]
            : null;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return (array_key_exists($key, $this->params))
            ? $this->params[$key]
            : null;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        switch (true) {
            case (preg_match("/catalog\/products\/*/", $_SERVER['REQUEST_URI'])  && $_SERVER['REQUEST_METHOD'] == "GET"):
                return app()->make(ProductController::class)->index($this);
            case ($_SERVER['REQUEST_URI'] == "/catalog/products/create" && $_SERVER['REQUEST_METHOD'] == "POST"):
                return app()->make(ProductController::class)->create($this);
            case ($_SERVER['REQUEST_URI'] == "/catalog/categories" && $_SERVER['REQUEST_METHOD'] == "GET"):
                return app()->make(CategoryController::class)->index($this);
            default:
                JsonResponse::create("not found", 404);
        }
    }
}