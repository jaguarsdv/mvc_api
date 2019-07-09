<?php

namespace src\models\entities;

/**
 * @property string $id
 * @property \DateTimeImmutable $create_time
 * @property \DateTimeImmutable $update_time
 */
class User extends BaseEntity
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @property integer $id
     * @property string $login
     * @property string $password
     */
    public function __construct(int $id, string $login, string $password = null)
    {
        parent::__construct($id, BaseEntity::TYPE_INT);
        $this->id = $id;
        $this->login = $login;
        if ($password) {
            $this->password = $password;
        } else {
            $this->password = (string) mt_rand(1000, 9999);
        }
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
