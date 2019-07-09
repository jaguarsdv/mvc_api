<?php

namespace src\models\dto;

use src\services\OrderService;

/**
 * DTO-объект оплаты заказа
 */
class PayOrderDto
{
    /**
     * @var string
     */
    public $order_id;

    /**
     * @var float
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
            $this->amount = $data['amount'];
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

        if (!is_float($this->amount)) {
            return 'Сумма оплаты должена быть вещественным числом';
        }

        return true;
    }
}
