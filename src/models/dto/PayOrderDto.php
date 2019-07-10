<?php

namespace src\models\dto;

use src\services\OrderService;

/**
 * DTO-объект оплаты заказа
 * @OA\Schema()
 */
class PayOrderDto
{
    /**
     * @var string
     * @OA\Property(
     *     format="guid",
     *     pattern="^[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}$"
     * )
     */
    public $order_id;

    /**
     * @var float
     * @OA\Property()
     */
    public $amount;

    /**
     * Устанавливает значения свойств объекта.
     */
    public function setValues(array $data)
    {
        if (isset($data['order_id'])) {
            $this->order_id = $data['order_id'];
        }
        if (isset($data['amount'])) {
            $this->amount = (float) $data['amount'];
        }
    }

    /**
     * Проверяет валидность данных.
     * 
     * @return string|true
     */
    public function validateData()
    {
        if (!preg_match(
            '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/i',
            $this->order_id
        )) {
            return 'Парвметр `order_id` должены быть строкой GUID';
        }

        if ($this->amount == 0) {
            return 'Сумма оплаты не не может равняться 0';
        }

        return true;
    }
}
