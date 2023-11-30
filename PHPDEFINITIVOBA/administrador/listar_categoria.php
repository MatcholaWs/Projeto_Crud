<?php
// Inicia a sessão para gerenciar variáveis de sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    // Se não estiver, redireciona para a página de login e encerra o script
    header("Location:login.php");
    exit();
}

// Exibe uma mensagem de sucesso se a atualização foi bem-sucedida
if (isset($_GET['update']) && $_GET['update'] === 'success') {
    echo "<div id='messagee'>Categoria atualizada com sucesso!</div>";
}

try {
    // Prepara e executa uma consulta SQL para obter as categorias
    $stmt = $pdo->prepare("SELECT 
        CATEGORIA_ID,
        CATEGORIA_NOME,
        CATEGORIA_DESC,
        CATEGORIA_ATIVO 
        FROM CATEGORIA
    ");
    $stmt->execute();
    // Obtém todas as categorias como um array associativo
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    // Em caso de erro, exibe uma mensagem de erro
    echo "Erro " . $erro->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar categoria</title>
    <link rel="stylesheet" href="./estilo_listarcategoria.css">
</head>
<body>

    <h2>Listar Categoria</h2>
    <button>
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ativo</th>
            <th>Editar</th>
            <th>Opções</th>
        </tr>
        <?php foreach ($categorias as $categoria) { ?>
            <tr>
                <td><?php echo $categoria['CATEGORIA_ID']; ?></td>
                <td><?php echo $categoria['CATEGORIA_NOME']; ?></td>
                <td><?php echo $categoria['CATEGORIA_DESC']; ?></td>
                <td>
                    <?php
                    // Exibe "Ativo" se a categoria estiver ativa, senão exibe "Inativo"
                    echo ($categoria['CATEGORIA_ATIVO'] == 0) ? 'Inativo' : 'Ativo';
                    ?>
                </td>
                <td>
                    <div class="alinha">
                        <button>
                            <a href="editar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn" data-toggle="tooltip" data-original-title="Edit user">
                                Editar
                            </a>
                        </button>
                    </div>
                </td>
                <td>
                    <div class="alinha">
                        <?php if ($categoria['CATEGORIA_ATIVO'] == 0): ?>
                            <button>
                                <a href="ativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Ativar</a>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="alinha">
                        <?php if ($categoria['CATEGORIA_ATIVO'] == 1): ?>
                            <button>
                                <a href="desativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Desativar</a>
                            </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>

    <button>
        <a href="painel_admin.php" class="btn">Voltar ao Painel do Administrador</a>
    </button>
</body>
</html>
