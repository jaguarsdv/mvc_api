<?php

namespace src\repositories;

use src\models\entities\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * 
     */
    public function getById(string $id)
    {
        $sql = $this->query_builder
            ->select('*')
            ->from('`order`')
            ->where('`id` = ?')
            ->getSQL();

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1, $id, \Doctrine\DBAL\ParameterType::STRING);
        $stmt->execute();
        $data = $stmt->fetch();

        $user_repository = new UserRepository;
        $user = $user_repository->findById($data['user_id']);
        return new Order(
            $data['id'],
            $user,
            (new \DateTimeImmutable())->setTimestamp($props['create_date']),
            (new \DateTimeImmutable())->setTimestamp($props['update_date'])
            $data['']
            $data['']
            $data['']
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
            $sql = $this->query_builder
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

    public function update(Order $order)
    {
        $this->connection->beginTransaction();
        try{
            $sql = $this->query_builder
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
}
