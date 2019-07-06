<?php

namespace src\entities;

class BaseEntity
{
    const TYPE_GUID_STR_36 = 'guid_string_36';
    const TYPE_INT = 'integer';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var \DateTimeImmutable
     */
    protected $create_date;

    /**
     * @var \DateTimeImmutable
     */
    protected $update_date;

    public function __construct(string $type)
    {
        if (!in_array($type, [
            self::TYPE_GUID_STR_36,
            self::TYPE_INT,
        ])) {
            throw new \DomainException(
                'Попытка создания идентификатора неизвестного типа.'
            );
        }    
        $this->type = $type;
        $this->create_date = new \DateTimeImmutable;
        $this->update_date = new \DateTimeImmutable;
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new \BadMethodCallException('Setting read-only property: '
                . get_class($this) . '::' . $name
            );
        } else {
            throw new \Exception('Setting unknown property: '
                . get_class($this) . '::' . $name
            );
        }
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new \BadMethodCallException('Getting write-only property: '
                . get_class($this) . '::' . $name
            );
        }

        throw new \Exception('Getting unknown property: '
            . get_class($this) . '::' . $name
        );
    }

    public function setId($value)
    {
        $valid = false;
        switch ($this->type) {
            case 'guid_string_36':
                if (is_string($value) && preg_match(
                    '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/i',
                    $value
                )) {
                    $valid = true;
                }
                break;

            case 'integer':
                if (is_int($value)) {
                    $valid = true;
                }
        }

        if ($valid) {
            $this->id = $value;
        } else {
            throw new \DomainException(
                'Неверный тип идентификатора.'
            );
        }
    }

    public function getId()
    {
        return $this->id;
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