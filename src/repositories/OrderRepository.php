<?php

namespace src\repositories;

use src\models\entities\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * Возвращает объект заказа по идентификатору.
     * 
     * @return Order
     */
    public function findById(string $id)
    {
        $sql = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->getSQL();

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $data = $stmt->fetch();

        $user_repository = new UserRepository($this->connection);
        $user = $user_repository->findById($data['user_id']);

        $product_repository = new ProductRepository($this->connection);
        $products = $product_repository->getOrderProducts($data['id']);

        return new Order(
            $data['id'],
            $user,
            (new \DateTimeImmutable())->setTimestamp($data['create_date']),
            $products,
            (new \DateTimeImmutable())->setTimestamp($data['update_date']),
            $data['status_id']
        );
    }

    /**
     * Сохраняет данные заказа в БД
     * 
     * @param Order $order
     * @throws \Throwable
     */
    public function save(Order $order)
    {
        $this->connection->beginTransaction();
        try{
            $sql = $this->connection->createQueryBuilder()
                ->insert('`order`')
                ->values([
                    '`id`' => ':id',
                    '`user_id`' => ':user_id',
                    '`sum`' => ':sum',
                    '`create_date`' => ':create_date',
                    '`update_date`' => ':update_date',
                ])
                ->setParameters([
                    ':id' => $order->id,
                    ':user_id' => $order->user->id,
                    ':sum' => $order->sum,
                    ':create_date' => $order->create_date->getTimestamp(),
                    ':update_date' => $order->update_date->getTimestamp(),
                ]);
            $sql->execute();

            $order_product_values = [];
            $placeholders = [];
            foreach ($order->products as  $product) {
                $order_product_values[] = $order->id;
                $order_product_values[] = $product->id;
                $placeholders[] = '(?, ?)';
            }

            $this->connection->executeUpdate(
                'INSERT INTO `order_product` (`order_id`, `product_id`) VALUES '. implode(', ', $placeholders),
                $order_product_values,
                [\Doctrine\DBAL\Connection::ARRAY_PARAM_OFFSET]
            );
            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    /**
     * Обновляет статус заказа.
     * 
     * @param Order $order
     */
    public function updateStatus(string $order_id, int $status_id)
    {
        $this->connection->createQueryBuilder()
            ->update('`order`')
            ->set('`status_id`', $status_id)
            ->where('`id` = :order_id')
            ->setParameter(':order_id', $order_id)
            ->execute();
    }
}
