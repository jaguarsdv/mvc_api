<?php

namespace src\models\dto;

/**
 * DTO-объект создания заказа
 * @OA\Schema()
 */
class CreateOrderDto
{
    /**
     * @var array
     * @OA\Property(@OA\Items(type="string"))
     */
    public $product_ids;

    /**
     * @var int
     */
    public $user_id;

     /**
     * Устанавливает значения свойств объекта.
     */
    public function setValues(array $data)
    {
        if (isset($data['product_ids'])) {
            $this->product_ids = $data['product_ids'];
        }
        if (isset($data['user_id'])) {
            $this->user_id = $data['user_id'];
        }
    }

    /**
     * Проверяет валидность данных.
     * 
     * @return string|true
     */
    public function validateData()
    {
        if (!is_array($this->product_ids)) {
            return 'Параметр `product_ids` должен быть массивом';
        }

        foreach ($this->product_ids as $product_id) {
            if (!preg_match(
                '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/i',
                $product_id
            )) {
                return 'Элементы массива `product_ids` должены быть строкой GUID';
            }
        }

        if (!is_int($this->user_id)) {
            return 'Идентификатор пользователя должены быть целым числом';
        }

        return true;
    }
}
