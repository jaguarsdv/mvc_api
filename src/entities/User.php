<?php

namespace src\entities;

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
    public function __construct(int $id, string $login, string $password)
    {
        parent::__construct(BaseEntity::TYPE_INT);
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
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
