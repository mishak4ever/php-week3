<?php

namespace App\Model;

use Base\AbstractModel;
use App\Model\User;
use Base\Db;

class Message extends AbstractModel
{

    protected $id;
    protected $text;
    protected $user_id;
    protected $image;
    protected $created_at;

    public function __construct($user_id = "", $text = "", $image = "")
    {
        if ($user_id)
            $this->user_id = $user_id;
        if ($text)
            $this->text = $text;
        if ($image)
            $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser(): ?User
    {
        return User::getById($this->user_id);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public static function getTable()
    {
        return 'messages';
    }

    /**
     * Получить модель из набора данных
     * @param mixed $data
     * @return \App\Model\Message
     */
    public static function loadModel(array $data): Message
    {
        $model = new self;
        $model->id = $data['id'];
        $model->text = $data['text'];
        $model->user_id = $data['user_id'];
        $model->image = $data['image'];
        $model->created_at = $data['created_at'];
        return $model;
    }

    public function save()
    {
        $db = Db::getInstance();
        $table = self::getTable();
        $insert = "INSERT INTO $table (user_id, `text`,image)
          VALUES(:user_id, :text,:image)";

        return $db->exec($insert, __METHOD__, [
                    ':text' => $this->text,
                    ':user_id' => $this->user_id,
                    ':image' => $this->image]
        );
    }

    /**
     * Получить список сообщений
     * @param int $limit
     * @param int $offset
     * @return @result \App\Model\Message[]
     */
    public static function getList(int $limit = 20, int $offset = 0): array
    {
        $db = Db::getInstance();
        $table = self::getTable();
        $result = [];

        $select = "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $data = $db->fetchAll($select, __METHOD__);

        if ($data) {
            foreach ($data as $mess) {
                $result[$mess['id']] = self::loadModel($mess);
            }
        }

        return $result;
    }

    /**
     * Получить список сообщений по пользователю
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return @result \App\Model\Message[]
     */
    public static function getListByUser(int $user_id, int $limit = 0, int $offset = 0): array
    {
        $db = Db::getInstance();
        $table = self::getTable();
        $result = [];

        $select = "SELECT * FROM {$table} WHERE user_id=:user_id ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
        $data = $db->fetchAll($select, __METHOD__, [
            ':user_id' => $user_id,
        ]);

        return $data;
    }

    /**
     * Удалить сообщение
     * @param int $id
     * @return @result bool
     */
    public static function deleteById(int $id): bool
    {
        $db = Db::getInstance();
        $table = self::getTable();

        $delete = "DELETE FROM {$table} WHERE id=:id";
        return $db->exec($delete, __METHOD__, [
                    ':id' => $id,]
        );
    }

    /**
     * Получить сообщение по id
     * @param int $id
     * @return @result bool
     */
    public static function getById(int $id): ?Message
    {
        $db = Db::getInstance();
        $table = self::getTable();

        $select = "SELECT * FROM {$table}  WHERE id=:id";
        $data = $db->fetchOne($select, __METHOD__, [
            ':id' => $id,]);

        if ($data) {
            return self::loadModel($data);
        }

        return false;
    }

}
