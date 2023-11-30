<?php
session_start();
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //Conexão com o banco de dados

    $CATEGORIA_NOME = $_POST['CATEGORIA_NOME'];
    $CATEGORIA_DESC = $_POST['CATEGORIA_DESC'];
    $CATEGORIA_ATIVO = $_POST['CATEGORIA_ATIVO'];

    try {
        $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) VALUES (:CATEGORIA_NOME, :CATEGORIA_DESC, :CATEGORIA_ATIVO)";
        $stmt = $pdo->prepare($sql); // Preparação para não conter injeção de sql
        $stmt->bindParam(':CATEGORIA_NOME', $CATEGORIA_NOME, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_DESC', $CATEGORIA_DESC, PDO::PARAM_STR);
        $stmt->bindParam(':CATEGORIA_ATIVO', $CATEGORIA_ATIVO, PDO::PARAM_INT);
        $stmt->execute(); //executa os comandos

        echo "<div id='messagee'>Cadastrado com sucesso</div>";
    } catch (PDOException $erro) {
        echo "<div id='messagee'>Erro ao realizar o cadastro</div>" . $erro->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar categoria</title>
    <link rel="stylesheet" href="estilo_cadastrarCategoria.css">
</head>
<body>
    <p>
    <button>
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>

    <h2>Cadastrar Categoria</h2>

    <form method="post" action="">
        <label for="CATEGORIA_NOME">Nome da categoria </label>
        <input type="text" name="CATEGORIA_NOME" id="CATEGORIA_NOME" required>
  
        <label for="CATEGORIA_DESC">Descrição da categoria</label>
        <input type="text" name="CATEGORIA_DESC" id="CATEGORIA_DESC" required>
       
        <label for="CATEGORIA_ATIVO">Status</label>
        <select name="CATEGORIA_ATIVO" id="CATEGORIA_ATIVO">
            <option value="1">Ativo</option>
            <option value="0">Inativo</option>
        </select>
        <div class="alinha">
            <input type="submit" value="Cadastrar" class="cadastro">
        </div>
    </form>
</body>
</html>



                        
                       
