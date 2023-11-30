<?php
session_start();

require_once('../administrador/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}


$categoria_id = $_GET['CATEGORIA_ID'];
 
// Busca as informações do produto.
$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA WHERE  CATEGORIA_ID = :categoria_id");
$stmt_categoria->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
$stmt_categoria->execute();
$categoria = $stmt_categoria->fetch(PDO::FETCH_ASSOC);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as informações do produto.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";
 
        try {
            $stmt_update_categoria = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :categoria_id");
            $stmt_update_categoria->bindParam(':nome', $nome);
            $stmt_update_categoria->bindParam(':descricao', $descricao);
            $stmt_update_categoria->bindParam(':ativo', $ativo);
            $stmt_update_categoria->bindParam(':categoria_id', $categoria_id);
            $stmt_update_categoria->execute();

            echo "<p style='color:green;'>Categoria atualizado com sucesso!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
        }
    } 
 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="./estilo_editarcategoria.css">
</head>
<body>
<h2>Editar Produto</h2>
    <button class="edit">
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>
<form action="" method="post" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= $categoria['CATEGORIA_NOME'] ?>" required>
    <p>
    <label for="descricao">Descrição:</label>
    <input type="text" name="descricao" id="descricao" value="<?= $categoria['CATEGORIA_DESC'] ?>" required>
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" <?= $categoria['CATEGORIA_ATIVO'] ? 'checked' : '' ?>>
    <p>
    <!-- Lista de imagens existentes -->
    <?php
    ?>
    <p>
    <button type="submit">Atualizar Categoria</button>
</form>
    <button class="edit">
        <a href="listar_produtos.php">Voltar ao Listar Produto</a>
    </button>
</body>
</html>