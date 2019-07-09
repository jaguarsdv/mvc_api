<?php

namespace src\controllers;

use src\repositories\ProductRepository;
use src\services\ProductService;
use src\views\ProductView;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/product/get-list",
     *     summary="Получить список товаров",
     *     operationId="get-list",
     *     tags={"product"},
     *     @OA\Response(
     *         response=200,
     *         description="Результат расчета",
     *         @OA\JsonContent(ref="#/components/schemas/CalculateResult"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function getList()
    {
        $product_service = new ProductService(
            new ProductRepository($this->db)
        );
        $product = $product_service->findProduct('4DB203C0-6B6E-44D5-B2C9-95DB6B143012');
        $products = $product_service->getAllProducts();
        $view = new ProductView;
        $response = new JsonResponse([
            "success" => 1,
            'products' => $view->render($product)
        ]);

        $response->send();
    }

    /**
     * @OA\Post(
     *     path="/product/fill-table",
     *     summary="Заполнить таблицу `product` дефолтными товарами",
     *     operationId="fill-table",
     *     tags={"product"},
     *     @OA\Response(
     *         response=200,
     *         description="Результат выполнения операции",
     *         @OA\JsonContent(ref="#/components/schemas/CalculateResult"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function fillProductTable()
    {
        $product_service = new ProductService(
            new ProductRepository($this->db)
        );

        $rows_added_count = $product_service->addDefaultProducts();
        $response = new JsonResponse([
            "success" => 1,
            'message' => "В таблицу `product` добавлено {$rows_added_count} строк"
        ]);

        $response->send();
    }
}
