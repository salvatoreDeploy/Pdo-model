<?php


namespace app\traits;


use app\database\Connection;

trait Find
{
    private static $conn;

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    public static function find($id){
        try{
            //dd("select * from " . static::$table ." where id = $id");
            $user = self::$conn->query("select * from " . static::$table . " where id = $id");
            return $user->fetchObject(get_called_class());
        }catch(\Throwable $th){
            print $th->getMessage();
        }
    }

    //Não Estatico
    public function all(){
        try{
            $conn = Connection::getConnection();
            $user = $conn->query("select * from " . $this->tableNormal);
            return $user->fetchAll(PDO::FETCH_CLASS, get_called_class());
        }catch(\Throwable $th){
            print $th->getMessage();
        }
    }
}