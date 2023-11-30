<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

//configuração de conexão com o banco de dados.
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}


// Bloco será executado apenas quando o formulario for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = $_POST['ativo'];
    $avatar = $_POST['avatar'];


    // Inserindo produto no banco.
    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM) VALUES (:nome, :email, :senha, :ativo, :avatar)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);

        $stmt->execute();

        echo "<p style='color:green;'>Administrador cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar o administrador: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo_cadastro2.css">
    <title>Cadastro de Admin</title>
    <script>
        // Adiciona um novo campo de imagem URL.
        function adicionarImagem() {
            const containerImagens = document.getElementById('containerImagens');
            const novoInput = document.createElement('input');
            novoInput.type = 'text';
            novoInput.name = 'avatar';
            containerImagens.appendChild(novoInput);
        }
    </script>
</head>
<body>
    <p>
<button><a href="painel_admin.php">Voltar ao Painel do Administrador</a></button>
<h2> Cadastrar Administrador</h2>
<form action="" method="post" enctype="multipart/form-data">
    <!-- Campos do formulário para inserir informações do produto -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>
    <p>
    <label for="descricao">Email:</label>
    <textarea name="email" id="email" required></textarea>
    <p>
    <label for="preco">Senha:</label>
    <input type="text" name="senha" id="senha" required>
    <p>
    <label for="ativo">Ativo:</label>
    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
    <p>
    <!-- Área para adicionar URLs de imagens. -->
    <label for="imagem">Imagem URL:</label>
    <div id="containerImagens">
        <input type="text" name="avatar" id="avatar">
    </div>
    <p>
    <button type="submit">Cadastrar Produto</button>
</form>
</body>
</html>