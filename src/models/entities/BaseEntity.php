<?php

namespace src\models\entities;

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

    public function __construct($id, string $type)
    {
        $valid = false;
        switch ($type) {
            case self::TYPE_GUID_STR_36:
                if (preg_match(
                    '/^[\da-f]{8}-[\da-f]{4}-[\da-f]{4}-[\da-f]{4}-[\da-f]{12}$/i',
                    $id
                )) {
                    $valid = true;
                }
                break;
            case self::TYPE_INT:
                if (!is_string($id) && (is_int($id))) {
                    $valid = true;
                }
                break;
            default:
                throw new \DomainException(
                    'Попытка создания идентификатора неизвестного типа.'
                );
        }

        if (!$valid) {
            throw new \DomainException(
                'Значение идентификатора не соответствует типу.'
            );
        }
        $this->type = $type;
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
    }

    public static function generateGuid()
    {
        if (function_exists('com_create_guid') === true) {
            $guid = trim(com_create_guid(), '{}');
        } else {
            $guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(16384, 20479),
                mt_rand(32768, 49151),
                mt_rand(0, 65535),
                mt_rand(0, 65535),
                mt_rand(0, 65535)
            );
        }

        return $guid;
    }
}
