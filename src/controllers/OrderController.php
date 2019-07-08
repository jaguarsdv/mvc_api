<?php

namespace src\controllers;

class OrderController
{
/**
     * @OA\Post(
     *     path="/order/create",
     *     summary="Создание заказа",
     *     operationId="create",
     *     tags={"order"},
     *     @OA\RequestBody(
     *         description="Данные для расчета стоимости",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CalcRequest")
     *     ),
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
    public function create()
    {

    }
}
