<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_gallerie";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $marca = $_POST['marca'];
    $tamanho = $_POST['tamanho'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];

    // Processa a imagem
    $imagem = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];
    $imagem_path = "uploads/" . basename($imagem); // Pasta "uploads" para armazenar as imagens

    // Move a imagem para a pasta de uploads
    if (move_uploaded_file($imagem_tmp, $imagem_path)) {
        // Insere o produto no banco de dados com o caminho da imagem
        $sql = "INSERT INTO produtos (nome, descricao, preco, marca, tamanho, categoria, estoque, imagem) 
                VALUES ('$nome', '$descricao', '$preco', '$marca', '$tamanho', '$categoria', '$estoque', '$imagem')";

        if ($conn->query($sql) === TRUE) {
            echo "Produto adicionado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" />
</head>
<body>

    <div class="container">
        <h2 class="mt-4 mb-3">Adicionar Novo Produto</h2>

        <?php if (isset($mensagem)): ?>
            <div class="alert alert-<?= $mensagem_tipo ?>"><?= $mensagem ?></div>
        <?php endif; ?>

        <form action="adicionar_produto.php" method="POST" enctype="multipart/form-data">
    <div class="form-group mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>
    <div class="form-group mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao" required>
    </div>
    <div class="form-group mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
    </div>
    <div class="form-group mb-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" class="form-control" id="marca" name="marca" required>
    </div>
    <div class="form-group mb-3">
        <label for="tamanho" class="form-label">Tamanho</label>
        <input type="text" class="form-control" id="tamanho" name="tamanho" required>
    </div>
    <div class="form-group mb-3">
        <label for="categoria" class="form-label">Categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria" required>
    </div>
    <div class="form-group mb-3">
        <label for="estoque" class="form-label">Estoque</label>
        <input type="number" class="form-control" id="estoque" name="estoque" required>
    </div>
    <div class="form-group mb-3">
        <label for="imagem" class="form-label">Imagem</label>
        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success mb-5">Adicionar Produto</button>
    <a href="dashboard.php" class="btn btn-secondary mb-5">Cancelar</a>
</form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

