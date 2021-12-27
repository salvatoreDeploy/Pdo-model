<?php


namespace app\database;

use app\services\DumpSql;
use PDO;
use Exception;

final class Connection
{
    private static $conn = null;
    private static bool $isTransaction = false;

    private function __construct()
    {
    }

    public static function getConnection(){
        if(!self::$conn){
            self::$conn = new PDO("mysql:host=localhost;dbname=pdo_dev", "root", "", [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }

        return self::$conn;
    }

    public static function open(bool $isTransaction = false ){
        if(!self::$conn){
            self::$conn = new PDO("mysql:host=localhost;dbname=pdo_dev", "root", "", [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }

        if($isTransaction){
            self::$conn->beginTransaction();
            self::$isTransaction = true;
        }
        return self::$conn;
    }

    public static function getConnectionTransaction()
    {
        if(self::$conn){
            return self::$conn;
        }
    }

    public static function close()
    {

        if(self::$isTransaction){
            self::$conn->commit();
        }
        self::$conn = null;
    }

    public static function rollback($e)
    {
        //dd(self::$conn);
        if(self::$isTransaction){
            self::$conn->rollBack();
        }

        print $e->getMessage();

        DumpSql::get();
    }
}