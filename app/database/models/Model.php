<?php


namespace app\database\models;

use app\database\Connection;
use app\services\DumpSql;
use PDO;

abstract class Model
{
    private static $conn;

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    //Estatico
    public static function find($id){
        try{
            //dd("select * from " . static::$table ." where id = $id");
            //$user = self::$conn->query("select * from " . static::$table . " where id = $id");
            $sql = "select * from " . static::$table . " where id = $id";

            DumpSql::add($sql);

            $user = self::$conn->query($sql);
            return $user->fetchObject(get_called_class());
        }catch(\Throwable $th){
            print $th->getMessage();
        }
    }

    //Não Estatico
    public function all(){
        try{
            $conn = Connection::getConnection();
            //$user = $conn->query("select * from " . $this->tableNormal);

            $sql = "select * from " . $this->tableNormal;

            DumpSql::add($sql);

            $user = $conn->query($sql);

            return $user->fetchAll(PDO::FETCH_CLASS, get_called_class());
        }catch(\Throwable $th){
            print $th->getMessage();
        }
    }

    public function create(array $data)
    {
        $conn = Connection::getConnectionTransaction();
        $sql = "insert into ".$this->tableNormal."(".implode(',', array_keys($data)).")values(:".implode(',:', array_keys($data)).")";
        DumpSql::add($sql);
        $prepare = $conn->prepare($sql);
        return $prepare->execute($data);
    }

    public function delete(int $id)
    {
        $conn = Connection::getConnectionTransaction();
        $sql = "delete from ".$this->tableNormal. " where id = :id";
        DumpSql::add($sql);
        $prepare = $conn->prepare($sql);
        return $prepare->execute(['id' => $id]);
    }
}