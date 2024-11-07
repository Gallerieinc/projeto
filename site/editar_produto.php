<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID do produto foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para obter os dados do produto
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit();
    }
}

// Atualiza o produto quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $marca = $_POST['marca'];
    $tamanho = $_POST['tamanho'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];
    
    // Para atualizar a imagem
    if (!empty($_FILES['imagem']['name'])) {
        $imagem = $_FILES['imagem']['name'];
        $caminhoImagem = "uploads/" . $imagem;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);
        
        $sql = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco', marca='$marca', tamanho='$tamanho', categoria='$categoria', estoque='$estoque', imagem='$caminhoImagem' WHERE id=$id";
    } else {
        $sql = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco', marca='$marca', tamanho='$tamanho', categoria='$categoria', estoque='$estoque' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        // Redireciona para o dashboard após atualização
        header("Location: dashboard.php");
        exit(); // Adiciona exit para garantir que o script pare após o redirecionamento
    } else {
        echo "Erro ao atualizar o produto: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
      
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-3 mt-4">Editar Produto</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $produto['nome']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $produto['descricao']; ?>" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" class="form-control" id="preco" name="preco" step="0.01" value="<?php echo $produto['preco']; ?>" required>
            </div>
            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $produto['marca']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tamanho">Tamanho</label>
                <input type="text" class="form-control" id="tamanho" name="tamanho" value="<?php echo $produto['tamanho']; ?>" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $produto['categoria']; ?>" required>
            </div>
            <div class="form-group">
                <label for="estoque">Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo $produto['estoque']; ?>" required>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem do Produto</label>
                <input type="file" class="form-control-file" id="imagem" name="imagem">
                <?php if (!empty($produto['imagem'])): ?>
                    <p>Imagem atual: <img src="<?php echo $produto['imagem']; ?>" alt="Imagem do Produto" style="width: 100px;"></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary mb-5">Salvar Alterações</button>
            <a href="dashboard.php" class="btn btn-danger mb-5">Cancelar</a>
        </form>
    </div>
</body>
</html>

