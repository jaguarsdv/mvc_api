<?php

namespace src\models\entities;

/**
 * @property string $id
 * @property \DateTimeImmutable $create_date
 * @property \DateTimeImmutable $update_date
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
     * @var \DateTimeImmutable
     */
    protected $create_date;

    /**
     * @var \DateTimeImmutable
     */

     protected $update_date;
    /**
     * @property User $user
     * @property Product[] $products
     */
    public function __construct(
        string $id,
        User $user,
        \DateTimeImmutable $create_date,
        array $products = [],
        \DateTimeImmutable $update_date = null,
        int $status_id = null
    ) {
        parent::__construct($id, BaseEntity::TYPE_GUID_STR_36);
        $this->user = $user;
        $this->products = $products;
        $this->create_date = $create_date;
        if ($update_date) {
            $this->update_date = $update_date;
        } else {
            $this->update_date = $this->create_date;
        }
        if ($status_id) {
            $this->status_id = $status_id;
        } else {
            $this->status_id = self::STATUS_NEW;
        }
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

        return round($this->sum, 2);
    }

    public function getCreate_date()
    {
        return $this->create_date;
    }

    public function getUpdate_date()
    {
        return $this->update_date;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
        if ($this->sum) {
            $this->sum = $product->price;
        }
        $this->update_date = new \DateTimeImmutable;
    }

    /**
     * @throws \DomainException
     */
    public function changeStatus(int $status)
    {
        if (empty($this->products)) {
            throw new \DomainException('Пустой заказ не может быть оплачен');
        }

        $this->status_id = self::STATUS_PAID;
        $this->update_date = new \DateTimeImmutable;
    }
}
