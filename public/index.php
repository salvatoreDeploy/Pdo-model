<?php
require '../vendor/autoload.php';

use app\database\Connection;
use app\database\models\Post;
use app\database\models\User;
use app\services\DumpSql;


/*Herança*/

//Estatico
//User::setConnection(Connection::getConnection());

//$users = User::all();
//$post = new Post();

/*foreach ($users as $user){
    print "<p>" . $user->firstName . "</p>";
}*/

//Não Estatico
/*$user = new User();
$userFound = $user->all();

dd($userFound);*/

/*Traits*/

/*$user = new User();
$userFound = $user->create();

dd($userFound);*/

/*Fazendo Trasações*/



try{
    Connection::open(true);

    $user = new User();

    //$user->delete(2);

    $user->create([
        'firstName' => 'Henrique',
        'lastName' => 'Araujo',
        'email' => 'liderhenrique@gmial.com',
        'password' => password_hash('1205', PASSWORD_BCRYPT)
    ]);

    $user->create([
        'firstName' => 'Jeniffer',
        'lastName' => 'Matos',
        'email' => 'jeh_matos@outlook.com',
        'password' => password_hash('7031', PASSWORD_BCRYPT)
    ]);

    Connection::close();
    DumpSql::get();
}catch(PDOException $e){
    //DumpSql::get();
    Connection::rollback($e);
}


