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

// Consultas para obter os dados
$clientes = $conn->query("SELECT * FROM usuarios WHERE tipo_usuario = 'cliente'");
$funcionarios = $conn->query("SELECT * FROM usuarios WHERE tipo_usuario = 'administrador'");
$produtos = $conn->query("SELECT * FROM produtos");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gallerie Inc</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos básicos para o menu lateral */
        .sidebar {
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .sidebar .nav-item {
            padding: 10px;
        }

        .table-section {
            display: none; /* Esconde todas as seções por padrão */
        }

        /* Adiciona um pouco de espaço no topo do conteúdo */
        main {
            margin-left: 270px;
            padding: 20px;
        }

        .logout-btn {
            position: fixed;
            top: 10px;
            right: 10px;
        }

        .btn-primary{
            width: 75px;
            margin-bottom: 5px;
        }

        .btn-danger{
            width: 75px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Menu lateral -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" onclick="showTable('clientes')">
                            Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showTable('funcionarios')">
                            Funcionários
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showTable('produtos')">
                            Produtos
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>

        <!-- Conteúdo principal -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2 class="text-center">Bem-vindo ao Dashboard</h2>
            <p class="text-center">Aqui você pode gerenciar os usuários, funcionários e produtos.</p>

            <!-- Botão de Logout -->
            <a href="logout.php" class="btn btn-danger logout-btn">Sair</a>

            <!-- Tabelas Dinâmicas -->
            <div id="clientes" class="table-section">
                <h3>Clientes</h3>
                <a href="adicionar_usuario.php" class="btn btn-success mb-3">Adicionar Cliente</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cliente = $clientes->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $cliente['id']; ?></td>
                                <td><?php echo $cliente['nome']; ?></td>
                                <td><?php echo $cliente['email']; ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo $cliente['id']; ?>" class="btn btn-primary">Editar</a>
                                    <a href="deletar_usuario.php?id=<?php echo $cliente['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="funcionarios" class="table-section">
                <h3>Funcionários</h3>
                <a href="adicionar_usuario.php" class="btn btn-success mb-3">Adicionar Funcionário</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($funcionario = $funcionarios->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $funcionario['id']; ?></td>
                                <td><?php echo $funcionario['nome']; ?></td>
                                <td><?php echo $funcionario['email']; ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo $funcionario['id']; ?>" class="btn btn-primary">Editar</a>
                                    <a href="deletar_usuario.php?id=<?php echo $funcionario['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="produtos" class="table-section">
    <h3>Produtos</h3>
    <a href="adicionar_produto.php" class="btn btn-success mb-3">Adicionar Produto</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Marca</th>
                <th>Tamanho</th>
                <th>Categoria</th>
                <th>Estoque</th>
                <th>Imagem</th> <!-- Coluna para mostrar a imagem -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consultar os produtos do banco de dados
            $produtos = $conn->query("SELECT * FROM produtos");

            if ($produtos->num_rows > 0) {
                while ($produto = $produtos->fetch_assoc()) {
                    echo "<tr>
                            <td>{$produto['id']}</td>
                            <td>{$produto['nome']}</td>
                            <td>{$produto['descricao']}</td>
                            <td>{$produto['preco']}</td>
                            <td>{$produto['marca']}</td>
                            <td>{$produto['tamanho']}</td>
                            <td>{$produto['categoria']}</td>
                            <td>{$produto['estoque']}</td>
                            <td><img src='uploads/{$produto['imagem']}' width='100' height='100'></td> <!-- Exibe a imagem -->
                            <td>
                                <a href='editar_produto.php?id={$produto['id']}' class='btn btn-primary'>Editar</a>
                                <a href='deletar_produto.php?id={$produto['id']}' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Nenhum produto encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

        </main>
    </div>
</div>

<script>
    // Função para mostrar a tabela selecionada e esconder as outras
    function showTable(tableId) {
        // Esconde todas as tabelas
        var sections = document.querySelectorAll('.table-section');
        sections.forEach(function(section) {
            section.style.display = 'none';
        });

        // Mostra a tabela selecionada
        var table = document.getElementById(tableId);
        if (table) {
            table.style.display = 'block';
        }
    }

    // Mostrar a tabela de clientes por padrão
    showTable('clientes');
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
