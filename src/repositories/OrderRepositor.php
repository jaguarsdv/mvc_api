<?php

namespace src\repositories;

use src\entities\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getById(string $id)
    {
        $sql = $this->query_builder
            ->select('*')
            ->from('order')
            ->where('id = ?')
            ->setParameter(0, $id);

        $stmt = $this->connection->executeQuery($sql);
        die(var_dump($stmt));
    }

    public function save(Order $order)
    {
        $sql = $this->query_builder
            ->insert('order')
            ->values([
                'id' => $order->id,
                'user_id' => $order->user->id,
                'sum' => $order->sum,
                'create_date' => $order->create_time->getTimestamp(),
                'update_date' => $order->update_time->getTimestamp(),
            ]);
        $this->connection->prepare($sql)->execute();

        $order_product_values = [];
        foreach ($order->products as  $product) {
            $product_values[] = [
                'order_id' => $order->id,
                'product_id' => $product->id,
            ];
        }

        $sql = $this->query_builder
            ->insert('order_product')
            ->values($order_product_values);
        $this->connection->prepare($sql)->execute();
    }
}
