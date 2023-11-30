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
    // Prepara a consulta SQL para buscar os produtos, suas categorias, imagens e o estoque de cada produto
    $sql = ("SELECT
        p.PRODUTO_ID,
        p.PRODUTO_NOME, 
        p.PRODUTO_DESC, 
        p.PRODUTO_PRECO,
        p.PRODUTO_DESCONTO,
        p.CATEGORIA_ID,
        p.PRODUTO_ATIVO,
        c.CATEGORIA_NOME,
        pe.PRODUTO_QTD,
        img.IMAGEM_URL
        FROM PRODUTO AS p
        LEFT JOIN CATEGORIA AS c ON c.CATEGORIA_ID = p.CATEGORIA_ID
        LEFT JOIN PRODUTO_ESTOQUE as pe ON pe.PRODUTO_ID = p.PRODUTO_ID 
        INNER JOIN PRODUTO_IMAGEM AS img ON img.PRODUTO_ID = p.PRODUTO_ID
    ");
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    // Em caso de erro na consulta, exibe uma mensagem de erro
    echo "Erro: " . $erro->getMessage();
}
?>
 
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="estilo_listar.css">
</head>
<body>
    <h2>Produtos Cadastrados</h2>
    <button><a href="painel_admin.php">Voltar ao Painel do Administrador</a></button>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ativo</th>
            <th>Desconto</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        <?php foreach($produtos as $produto): ?>
            <tr>
                <td><?php echo $produto['PRODUTO_ID']; ?></td>
                <td><?php echo $produto['PRODUTO_NOME']; ?></td>
                <td><?php echo $produto['PRODUTO_QTD']; ?></td>
                <td><?php echo $produto['PRODUTO_DESC']; ?></td>
                <td><?php echo $produto['PRODUTO_PRECO']; ?></td>
                <td><?php echo $produto['CATEGORIA_NOME']; ?></td>
                <td><?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                <td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
                <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50"></td>
                <td>
                    <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn">Editar</a>
                    <?php if ($produto['PRODUTO_ATIVO'] == 1): ?>
                        <a href="desativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Desativar</a>
                    <?php endif; ?>
                    <?php if ($produto['PRODUTO_ATIVO'] == 0): ?>
                        <a href="ativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Ativar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p></p>
</body>
</html>
