<?php


namespace app\services;


use Exception;

class DumpSql
{
    private static array $sqls = [];

    public static function add(string $sql)
    {
        self::$sqls[] = $sql;
    }

    public  static function get()
    {
        if(empty(self::$sqls)){
            throw new Exception("Nenhuma query sendo criada");
        }

        dd(self::$sqls);
    }
}