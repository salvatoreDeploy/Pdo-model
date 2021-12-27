<?php


namespace app\database\models;

use app\traits\Create;
use app\traits\Find;

class User extends Model
{
    //use Find, Create;

    protected static $table = 'users';

    protected $tableNormal = 'users';

    public function teste()
    {
        return "teste";
    }
}