<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();
 
//configuração de conexão com o banco de dados.
require_once('../administrador/conexao.php');
 
// Verifica se o administrador está logado.
try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    echo "<div id='messagee'>Erro ao buscar categoria " . $erro->getMessage() . "</div>";
}
//será executado apenas quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $status = $_POST['ativo'];
    $imagens = isset($_POST['imagem_url']) ? $_POST['imagem_url'] : [];

    try {
        $sql_produto = "INSERT INTO PRODUTO
            (
                PRODUTO_NOME, 
                PRODUTO_DESC, 
                PRODUTO_PRECO,
                PRODUTO_DESCONTO,
                CATEGORIA_ID,
                PRODUTO_ATIVO
            ) VALUES (
                :nome,
                :descricao, 
                :preco, 
                :desconto, 
                :categoria_id, 
                :ativo
            )";

        // Preparando e executando a inserção na tabela PRODUTO.
        $stmt_produto = $pdo->prepare($sql_produto);
        $stmt_produto->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_produto->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt_produto->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt_produto->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt_produto->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt_produto->bindParam(':ativo', $status, PDO::PARAM_INT);
        $stmt_produto->execute();

        //Pegando o ID do produto inserido.
        $produto_id = $pdo->lastInsertId();



        // Inserindo imagens no banco, se houver imagens.
        if (!empty($imagens)) {
            foreach ($imagens as $ordem => $url_imagem) {
                //código para inserir as imagens
            }
        }

        // Inserindo estoque.
        $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE 
            (
                PRODUTO_ID,
                PRODUTO_QTD
            ) VALUES (
                :produto_id,
                :quantidade
            )";

        $stmt_estoque = $pdo->prepare($sql_estoque);
        $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt_estoque->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt_estoque->execute();

        echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar produto: " . $e->getMessage() . "</p>";
    }
}

?>
 
<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Cadastro de Produtoss</title>
<link rel="stylesheet" href="estilo_cadastro.css">
<script>
        // Adiciona um novo campo de imagem URL.
        function adicionarImagem() {
            const containerImagens = document.getElementById('containerImagens');
            const novoInput = document.createElement('input');
            novoInput.type = 'text';
            novoInput.name = 'imagem_url[]';
            containerImagens.appendChild(novoInput);
        }
</script>
</head>
<body>
    <p>
<button><a href="painel_admin.php">Voltar ao Painel do Administrador</a></button>
<h2>Cadastrar Produto</h2>
<form action="" method="post" enctype="multipart/form-data">
<!-- Campos do formulário para inserir informações do produto -->
<label for="nome">Nome:</label>
<input type="text" name="nome" id="nome" required>
<p>
<label for="descricao">Descrição:</label>
<textarea name="descricao" id="descricao" required></textarea>
<p>
<label for="preco">Preço:</label>
<input type="number" name="preco" id="preco" step="0.01" required>
<p>
<label for="desconto">Desconto:</label>
<input type="number" name="desconto" id="desconto" step="0.01" required>
<p>
<label for="quantidade">Quantidade:</label>
<input type="number" name="quantidade" id="quantidade" required>
<p>
<label for="categoria_id">Categoria:</label>
<select name="categoria_id" id="categoria_id" required>
    <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria['CATEGORIA_ID'] ?>"><?= $categoria['CATEGORIA_NOME'] ?></option>
    <?php endforeach; ?>
</select>

<p>
<label for="ativo">Ativo:</label>
<input type="checkbox" name="ativo" id="ativo" value="1" checked>
<p>
<!-- Área para adicionar URLs de imagens. -->
<label for="imagem">Imagem URL:</label>
<div id="containerImagens">
<input type="text" name="imagem_url[]" required>
</div>
<button type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>
<p>
<button type="submit">Cadastrar Produto</button>

</form>
</body>
</html>