<?php

namespace src\views;

use src\models\entities\Product;

/**
 * Представление объекта Товар.
 * 
 * @OA\Schema(
 *    type="object",
 *    @OA\Property(
 *        property="id",
 *        type="string",
 *        description="Идентификатор",
 *    ),
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Наименование товара"
 *    ),
 *    @OA\Property(
 *        property="price",
 *        type="number",
 *        description="Цена товара"
 *    ),
 *    @OA\Property(
 *        property="create_date",
 *        type="string",
 *        description="Дата создания"
 *    ),
 *    @OA\Property(
 *        property="update_date",
 *        type="string",
 *        description="Дата обновления"
 *    ),
 * )
 */
class ProductView extends BaseView
{
    /**
     * @param Product|Product[]|null $product
     * @return array|null
     */
    public function render($work_type)
    {
        if ($work_type === null) {
            return null;
        }

        $properties = [
            Product::class => [
                'id',
                'name',
                'price' => function(Product $product) {
                    return (float) $product->price;
                },
                'create_date' => function(Product $product) {
                    return $product->create_date->format("Y-m-d H:i:s");
                },
                'update_date' => function(Product $product) {
                    return $product->update_date->format("Y-m-d H:i:s");
                },
            ],
        ];

        return $this->toArray($work_type, $properties);
    }
}
