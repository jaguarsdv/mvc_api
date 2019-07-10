<?php

namespace src\repositories;

use src\models\entities\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function save(Product $product)
    {

    }

    public function addDefaultProducts()
    {
        $sql = <<<SQL
INSERT IGNORE INTO `product` (`id`, `name`, `price`, `create_date`, `update_date`)
VALUES
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143001', 'Товар1', 100.58, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143002', 'Товар2', 760.22, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143003', 'Товар3', 50, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143004', 'Товар4', 176.74, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143005', 'Товар5', 1520.99, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143006', 'Товар6', 999.99, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143007', 'Товар7', 777.77, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143008', 'Товар8', 104.75, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143009', 'Товар9', 220.90, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143010', 'Товар10', 86.44, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143011', 'Товар11', 1100.7, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143012', 'Товар12', 667.33, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143013', 'Товар13', 256.64, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143014', 'Товар14', 128.32, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143015', 'Товар15', 391.24, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143016', 'Товар16', 170.58, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143017', 'Товар17', 345.81, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143018', 'Товар18', 515.06, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143019', 'Товар19', 827.88, 1562493944, 1562493944),
    ('4DB203C0-6B6E-44D5-B2C9-95DB6B143020', 'Товар20', 305.35, 1562493944, 1562493944)
SQL;
        return $this->connection->executeUpdate($sql);
    }

    public function findById(string $id)
    {
        $sql = "SELECT * FROM `product` WHERE `id` = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $this->instantiate($stmt->fetch());
    }

    public function findByIds(array $ids)
    {
        $stmt = $this->connection->executeQuery(
            "SELECT * FROM `product` WHERE `id` IN (?)",
            [$ids],
            [\Doctrine\DBAL\Connection::PARAM_STR_ARRAY]
        );
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = $this->instantiate($row);
        }

        return $products;
    }

    public function getProductsList()
    {
        $stmt = $this->connection->query("SELECT * FROM `product`");
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] =$this->instantiate($row);
        }

        return $products;
    }

    public function getOrderProducts(string $order_id)
    {
        $sub_query = $this->connection->createQueryBuilder();
        $sub_query->select('`product_id`')
            ->from('`order_product`')
            ->where('`order_id` = :order_id');

        $query = $this->connection->createQueryBuilder();
        $query->select('*')
            ->from('`product`')
            ->where($query->expr()->in('`id`', $sub_query->getSQL()))
            ->setParameter(':order_id', $order_id);

        $stmt = $query->execute();
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = $this->instantiate($row);
        }

        return $products;
    }

    public function getOrderProductIds(string $order_id)
    {
        $product_ids = [];
        $query = $this->connection->createQueryBuilder()
            ->select('`product_id`')
            ->from('`order_product`')
            ->where('`order_id` = :order_id')
            ->setParameter(':order_id', $order_id)
            ->execute();

        while ($product_id = $query->fetchColumn()) {
            $product_ids[] = $product_id;
        }

        return $product_ids;
    }

    private function instantiate(array $props)
    {
        return new Product(
            $props['id'],
            $props['name'],
            $props['price'],
            (new \DateTimeImmutable())->setTimestamp($props['create_date']),
            (new \DateTimeImmutable())->setTimestamp($props['update_date'])
        );
    }
}
