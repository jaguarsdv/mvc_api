<?php

namespace src\models\entities;

/**
 * @property string $id
 * @property \DateTimeImmutable $create_date
 * @property \DateTimeImmutable $update_date
 */
class Product extends BaseEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTimeImmutable
     */
    private $create_date;

    /**
     * @var \DateTimeImmutable
     */
    private $update_date;

    public function __construct(
        string $id,
        string $name,
        float $price,
        \DateTimeImmutable $create_date,
        \DateTimeImmutable $update_date = null
    ) {
        parent::__construct($id, BaseEntity::TYPE_GUID_STR_36);
        $this->name = $name;
        $this->price = $price;
        $this->create_date = $create_date;
        if ($update_date) {
            $this->update_date = $update_date;
        } else {
            $this->update_date = $this->create_date;
        }
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getCreate_date()
    {
        return $this->create_date;
    }

    public function getUpdate_date()
    {
        return $this->update_date;
    }
}
