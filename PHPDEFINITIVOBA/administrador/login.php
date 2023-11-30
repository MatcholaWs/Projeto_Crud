<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Login ADM</title>
    <link rel="stylesheet" href="estilo_login.css">
</head>
<body>
    <img src="../img/charlie-logo.png" alt="">
    <form action="processa_login.php" method="post" class="formu">
        <div class="form-content">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <p></p>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <p></p>
        </div>
        <input type="submit" value="Entrar" class="btn">
        <?php
        if(isset($_GET['erro'])){
            echo '<p style="color:red;">Nome de usuario ou senha incorretos!</p>';
        }
        ?>
    </form>
</body>
</html>