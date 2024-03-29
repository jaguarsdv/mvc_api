<?php

namespace src\controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use src\models\dto\CreateOrderDto;
use src\repositories\OrderRepository;
use src\services\OrderService;
use src\repositories\ProductRepository;
use src\repositories\UserRepository;
use src\models\dto\PayOrderDto;

class OrderController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/order/create",
     *     summary="Создание заказа",
     *     operationId="create",
     *     tags={"order"},
     *     @OA\RequestBody(
     *         description="Данные для создания заказа",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateOrderDto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Результат выполнения операции",
     *         @OA\JsonContent( 
     *             type="object",
     *             @OA\Property(property="success", type="integer"),
     *             @OA\Property(property="order_id", type="string")
     *         ),
     *     )
     * )
     */
    public function create()
    {
        $data = json_decode($this->request->getContent(), true);

        $dto = new CreateOrderDto;
        $dto->setValues($data);
        $dto->user_id = 1;

        $validation_result = $dto->validateData();
        if ($validation_result !== true) {
            $response = new JsonResponse([
                "success" => 0,
                'error' => $validation_result
            ]);
        } else {
            $order_service = new OrderService(
                new UserRepository($this->db),
                new ProductRepository($this->db),
                new OrderRepository($this->db)
            );
            try {
                $order = $order_service->create($dto);
                $response = new JsonResponse([
                    "success" => 1,
                    'order_id' => $order->id
                ]);
            } catch (\Throwable $e) {
                $response = new JsonResponse([
                    "success" => 0,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $response->send();
    }

    /**
     * @OA\Post(
     *     path="/order/pay",
     *     summary="Оплатить заказа",
     *     operationId="pay",
     *     tags={"order"},
     *     @OA\RequestBody(
     *         description="Данные для оплаты",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PayOrderDto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Результат выполнения операции",
     *         @OA\JsonContent( 
     *             type="object",
     *             @OA\Property(property="success", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         ),
     *     )
     * )
     */
    public function pay()
    {
        $data = json_decode($this->request->getContent(), true);

        $dto = new PayOrderDto;
        $dto->setValues($data);
        $dto->user_id = 1;

        $validation_result = $dto->validateData();
        if ($validation_result !== true) {
            $response = new JsonResponse([
                "success" => 0,
                'error' => $validation_result
            ]);
        } else {
            $order_service = new OrderService(
                new UserRepository($this->db),
                new ProductRepository($this->db),
                new OrderRepository($this->db)
            );
            try {
                $order_service->pay($dto);
                $response = new JsonResponse([
                    "success" => 1,
                    'message' => 'Операция прошла успешно'
                ]);
            } catch (\Throwable $e) {
                $response = new JsonResponse([
                    "success" => 0,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $response->send();
    }
}
