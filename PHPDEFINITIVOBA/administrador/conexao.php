<?php

//configurações do banco de dados//
$host = '144.22.157.228';
$db = 'Charlie';
$user = 'Charlie';
$pass = 'Charlie';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

//criando a conexão com o banco de dados atraves do pdo
try{
$pdo = new PDO($dsn, $user, $pass);

}catch (PDOException $e){
    echo "Erro ao tentar conectar com o banco de dados <p>".$e;
}

echo "conexão funcionando";

?>