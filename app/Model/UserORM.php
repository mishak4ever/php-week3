<?php

namespace App\Model;

class UserORM extends \Illuminate\Database\Eloquent\Model
{

    public $table = "users";
    protected $primaryKey = 'id';
    protected $connection = 'default';
    protected $guarded = ['id']; //запрещено редактировать только это, все остальное разрешено
    public $timestamps = false;

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public static function getPasswordHash(string $password)
    {
        return sha1(';blabla' . $password);
    }

}
