<?php

namespace src\entities;

/**
 * @property string $id
 * @property \DateTimeImmutable $create_time
 * @property \DateTimeImmutable $update_time
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

    public function __construct(string $name, float $price)
    {
        parent::__construct(BaseEntity::TYPE_GUID_STR_36);
        $this->name = $name;
        $this->price = $price;
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
}
