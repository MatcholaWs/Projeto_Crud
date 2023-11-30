<?php
// Inicia a sessão para gerenciar variáveis de sessão
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_logado'])) {
    // Se não estiver, redireciona para a página de login e encerra o script
    header('Location: login.php');
    exit();
}

// Inclui o arquivo de conexão com o banco de dados
require_once('../administrador/conexao.php');

$mensagem = '';

// Verifica se a requisição é do tipo GET e se o parâmetro 'id' está definido
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id']; // Corrigindo a atribuição do ID da categoria
    $novoEstado = 1; // Define o estado como ativo (1)

    try {
        // Prepara e executa a consulta SQL para atualizar o estado da categoria
        $stmt = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_ATIVO = :novoEstado WHERE CATEGORIA_ID = :id");
        $stmt->bindParam(':novoEstado', $novoEstado, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Categoria ativada com sucesso!";
        } else {
            $mensagem = "Não foi possível ativar a Categoria.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Redireciona para a página de listar categorias
header("Location: listar_categoria.php?mensagem=" . urlencode($mensagem));
exit();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Ativar Categoria</title>
    <link rel="stylesheet" href="./estilo_excluir.css">
</head>
<body>
    <h2 class="text">Ativar Categoria</h2>
    <p class="text"><?php echo $mensagem; ?></p>
    <button>
        <a href="listar_produtos.php">Voltar à Lista de Produtos</a>
    </button>

    <!-- Exibe uma mensagem adicional caso a ativação não seja bem-sucedida -->
    <?php if ($mensagem !== "Categoria ativada com sucesso!") { ?>
        <h2>Não foi possível ativar a categoria</h2>
    <?php } ?>
</body>
</html>
