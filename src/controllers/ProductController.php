<?php

namespace src\controllers;

use src\repositories\ProductRepository;
use src\services\ProductService;
use src\views\ProductView;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/product/get-list",
     *     summary="Получить список товаров",
     *     operationId="get-list",
     *     tags={"product"},
     *     @OA\Response(
     *         response=200,
     *         description="Результат выполнения операции",
     *         @OA\JsonContent( 
     *             type="object",
     *             @OA\Property(property="success", type="integer"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProductView")
     *             ),
     *         ),
     *     )
     * )
     */
    public function getList()
    {
        $product_service = new ProductService(
            new ProductRepository($this->db)
        );
        $products = $product_service->getAllProducts();
        $view = new ProductView;
        $response = new JsonResponse([
            "success" => 1,
            'products' => $view->render($products)
        ]);

        $response->send();
    }

    /**
     * @OA\Get(
     *     path="/product/fill-table",
     *     summary="Заполнить таблицу `product` дефолтными товарами",
     *     operationId="fill-table",
     *     tags={"product"},
     *     @OA\Response(
     *         response=200,
     *         description="Результат выполнения операции",
     *         @OA\JsonContent( 
     *             type="object",
     *             @OA\Property(property="success", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         ),
     *     ),
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
