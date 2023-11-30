<?php
session_start();

require_once('../administrador/conexao.php');                       //requerir uma vez//

$nome = $_POST['nome'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM ADMINISTRADOR 
WHERE ADM_NOME = :nome 
AND ADM_SENHA = :senha
AND ADM_ATIVO = 1";

$query = $pdo->prepare($sql);
$query->bindParam(':nome', $nome, PDO::PARAM_STR);           //prepare verifica erros//
$query->bindParam(':senha', $senha, PDO::PARAM_STR);         //bindparam = vincular os parametros    PDO::PARAM_STR = verifica string
$query->execute();

if($query->rowCount() > 0){
$_SESSION['admin_logado'] = true;
header('Location: painel_admin.php');
}else{
    header('Location: login.php?erro');
}
?>