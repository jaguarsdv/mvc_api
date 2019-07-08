<?php

namespace src\entities;

/**
 * @property string $id
 * @property \DateTimeImmutable $create_time
 * @property \DateTimeImmutable $update_time
 */
class Order extends BaseEntity
{
    const STATUS_NEW = 0;
    const STATUS_PAID = 1;

    /**
     * @var array
     */
    private $products;

    /**
     * @var float
     */
    private $sum;

    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $status_id;

    /**
     * @property User $user
     * @property Product[] $products
     */
    public function __construct(User $user, array $products = [])
    {
        parent::__construct(BaseEntity::TYPE_GUID_STR_36);
        $this->user = $user;
        $this->products = $products;
        $this->status_id = self::STATUS_NEW;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return integer
     */
    public function getStatus_id()
    {
        return $this->status_id;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        if (!$this->sum) {
            $this->sum = 0;
            foreach ($this->products as $product)
            {
                $this->sum += $product->price;
            }
        }

        return $this->sum;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
        if ($this->sum) {
            $this->sum = $product->price;
        }
    }

    /**
     * @throws \DomainException
     */
    public function setStatusPaid()
    {
        if (empty($this->products)) {
            throw new \DomainException('Пустой заказ не может быть оплачен');
        }

        $this->status_id = self::STATUS_PAID;
    }
}
