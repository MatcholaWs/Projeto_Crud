<?php
// Inicia a sessão para gerenciar variáveis de sessão
session_start();
// Inclui o arquivo de conexão com o banco de dados
require_once('../administrador/conexao.php');

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_logado'])) {
    // Se não estiver, redireciona para a página de login e encerra o script
    header("Location:login.php");
    exit();
}

try {
    // Prepara e executa uma consulta SQL para obter todos os dados da tabela ADMINISTRADOR
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*, ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM 
                           FROM ADMINISTRADOR ");
    $stmt->execute();
    // Obtém todos os resultados da consulta como um array associativo
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Em caso de erro, exibe uma mensagem de erro em vermelho
    echo "<p style='color:red;'>Erro ao listar Administrador: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>
    <link rel="stylesheet" href="./estilo_listaradm.css">
</head>
<body>
    <h2>Listar Administradores</h2>
    <button>
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Ativo</th>
            <th>Avatar</th>
            <th>Ações</th>
        </tr>
        <?php foreach($administrador as $adm): ?>
            <tr>
                <!-- Células com dados do administrador -->
                <td><?php echo $adm['ADM_ID']; ?></td>
                <td><?php echo $adm['ADM_NOME']; ?></td>
                <td><?php echo $adm['ADM_EMAIL']; ?></td>
                <td><?php echo $adm['ADM_SENHA']; ?></td>
                <td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                <td><img src="<?php echo $adm['ADM_IMAGEM']; ?>" alt="<?php echo "A imagem do Administrador " . $adm['ADM_NOME'] . " não pode ser carregada"; ?>" width="50"></td>
                <td>
                    <div class="editar">
                        <a href="editar_adm.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p></p>
    <button>
        <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
    </button>
</body>
</html>
