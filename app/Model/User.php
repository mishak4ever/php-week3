<?php

namespace App\Model;

use Base\AbstractModel;
use Base\Db;

class User extends AbstractModel
{

    private $id;
    private $name;
    private $password;
    private $created_at;
    private $email;
    private $ava;

    public function __construct($data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->ava = $data['ava'] ?? "";
            $this->created_at = $data['created_at'];
        }
    }

    public static function getTable()
    {
        return 'users';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setAva(string $ava)
    {
        $this->ava = $ava;
        return $this;
    }

    public function getAva()
    {
        $path = '/images/no_image.png';
        if ($this->ava && file_exists(PROJECT_ROOT_DIR . '/images/' . $this->ava)) {
            $path = '/images/' . $this->ava;
        }
        return $path;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function isAdmin(): bool
    {
        return ($this->id == ADMIN_USER_ID);
    }

    public function save()
    {
        $db = Db::getInstance();
        $table = $this->getTable();
        $insert = "INSERT INTO {$table} (`name`, `password`, `email`) VALUES (
            :name, :password, :email
        )";
        $db->exec($insert, __METHOD__, [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password,
        ]);

        $id = $db->lastInsertId();
        $this->id = $id;

        return $id;
    }

    public function update()
    {
        $db = Db::getInstance();
        $table = $this->getTable();
        $insert = "UPDATE {$table} SET `name`=:name, `password`=:password, `email`=:email, `ava`=:ava WHERE id=:id";
        $res = $db->exec($insert, __METHOD__, [
            ':id' => $this->id,
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password,
            ':ava' => $this->ava,
        ]);

        return $res;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $table = self::getTable();
        $select = "SELECT * FROM {$table} WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if (!$data) {
            return null;
        }

        return new self($data);
    }

    public static function getByEmail(string $email): ?self
    {
        $db = Db::getInstance();
        $table = self::getTable();
        $select = "SELECT * FROM {$table} WHERE `email` = :email";
        $data = $db->fetchOne($select, __METHOD__, [
            ':email' => $email
        ]);

        if (!$data) {
            return null;
        }

        return new self($data);
    }

    public static function getPasswordHash(string $password)
    {
        return sha1(';blabla' . $password);
    }

}
