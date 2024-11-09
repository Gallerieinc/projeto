<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = (int) $_GET['id']; // Fazendo o ID ser um número inteiro para segurança

    // Consulta para obter os dados do usuário
    $sql = "SELECT id, nome, email, genero, tipo_usuario, imagem FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // Bind para evitar SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado!";
        exit();
    }
} else {
    echo "ID não fornecido ou inválido!";
    exit();
}

// Atualiza os dados do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $genero = $_POST['genero'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Inicializa a variável de imagem com o valor atual do banco de dados
    $imagem = $user['imagem'];

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['imagem']['name'])) {
        // Gera um nome único para a imagem para evitar conflitos
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $novo_nome_imagem = uniqid() . "." . $extensao;
        $caminhoImagem = "uploads/" . $novo_nome_imagem;

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            // Atualiza a variável $imagem para o novo nome
            $imagem = $novo_nome_imagem;
        } else {
            echo "Erro ao mover a imagem para o diretório.";
            exit();
        }
    }

    // Atualiza os dados no banco de dados
    $sql_update = "UPDATE usuarios SET nome = ?, email = ?, genero = ?, tipo_usuario = ?, imagem = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssi", $nome, $email, $genero, $tipo_usuario, $imagem, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro ao atualizar usuário: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}



?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="imgnew/20241104_012926303_iOS-removebg-preview.png" />
</head>

<body>

    <div class="container">
        <h2 class="mt-4">Editar Usuário</h2>
        <form action="editar_usuario.php?id=<?php echo $user['id']; ?>" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user['nome']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="genero">Sexo</label>
                <select class="form-control" id="genero" name="genero" required>
                    <option value="Feminino" <?php if ($user['genero'] == 'Feminino')
                        echo 'selected'; ?>>Feminino
                    </option>
                    <option value="Masculino" <?php if ($user['genero'] == 'Masculino')
                        echo 'selected'; ?>>Masculino
                    </option>
                    <option value="Prefiro não dizer" <?php if ($user['genero'] == 'Prefiro não dizer')
                        echo 'selected'; ?>>Prefiro não dizer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuário</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="cliente" <?php if ($user['tipo_usuario'] == 'cliente')
                        echo 'selected'; ?>>Cliente
                    </option>
                    <option value="administrador" <?php if ($user['tipo_usuario'] == 'administrador')
                        echo 'selected'; ?>>
                        Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>