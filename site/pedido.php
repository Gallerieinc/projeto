<?php
session_start();
include 'conect.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

$query = "SELECT * FROM pedidos WHERE id_usuario = '$usuario_id' ORDER BY data_pedido DESC";
$result = mysqli_query($conn, $query);

// Selecionar o banco de dados
mysqli_select_db($conn, 'db_gallerie');

// Consultar os dados do usuário com prepared statement
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Consulta o endereço do usuário
$sql_endereco = "SELECT endereco, cidade, estado, cep FROM enderecos WHERE id_usuario = ?";
$stmt_endereco = $conn->prepare($sql_endereco);
$stmt_endereco->bind_param("i", $usuario_id);
$stmt_endereco->execute();
$result_endereco = $stmt_endereco->get_result();
$endereco = $result_endereco->fetch_assoc();

// Consulta o endereço do usuário
$sql_endereco = "SELECT endereco, cidade, estado, cep FROM enderecos WHERE id_usuario = ?";
$stmt_endereco = $conn->prepare($sql_endereco);
$stmt_endereco->bind_param("i", $usuario_id);
$stmt_endereco->execute();
$result_endereco = $stmt_endereco->get_result();

// Verifica se o endereço foi encontrado
$endereco = $result_endereco->fetch_assoc();

if ($endereco) {
    $formulario_endereco = false;
} else {
    $formulario_endereco = true;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // Atualizar o perfil
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $genero = $_POST['genero']; // Adiciona o campo de gênero
        $imagem = $user['imagem']; // Inicializa com a imagem atual do usuário

        // Verificar se o campo de imagem foi enviado corretamente
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            // Se a imagem foi carregada
            $imagem = $_FILES['imagem']['name']; // Nome do arquivo de imagem
            $imagem_tmp = $_FILES['imagem']['tmp_name']; // Caminho temporário da imagem
            $imagem_path = "uploads/" . basename($imagem); // Caminho final da imagem

            // Tenta mover a imagem para a pasta de uploads
            if (move_uploaded_file($imagem_tmp, $imagem_path)) {
                // A imagem foi carregada com sucesso, agora atualiza o perfil
                $update_query = "UPDATE usuarios SET nome = ?, email = ?, genero = ?, imagem = ? WHERE id = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'ssssi', $nome, $email, $genero, $imagem, $usuario_id);
            } else {
                echo "Erro ao fazer upload da imagem.";
                exit; // Interrompe se houver erro no upload
            }
        } else {
            // Se não houver imagem, mantém a imagem atual
            $update_query = "UPDATE usuarios SET nome = ?, email = ?, genero = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'sssi', $nome, $email, $genero, $usuario_id);
        }

        // Executa a query de atualização
        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: profile.php");
            exit;
        } else {
            echo "Erro ao atualizar perfil.";
        }
    } elseif (isset($_POST['delete'])) {
        // Deletar a conta
        $delete_query = "DELETE FROM usuarios WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, 'i', $usuario_id);
        mysqli_stmt_execute($delete_stmt);

        session_destroy(); // Destroi a sessão
        header("Location: index.php?message=deleted");
        exit;
    }


}

// Obter os pedidos do usuário
$userId = $_SESSION['usuario_id'];
$query = "SELECT * FROM pedidos WHERE id_usuario = '$userId' ORDER BY data_pedido DESC";
$result = mysqli_query($conn, $query);


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Pedidos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="imgnew/20241104_012926303_iOS-removebg-preview.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body class="animsition">

    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        Olá, <?= htmlspecialchars($user['nome']) ?>!
                    </div>

                    <div class="right-top-bar flex-w h-full">
                        <a href="logout.php" class="flex-c-m trans-04 p-lr-25">
                            SAIR
                        </a>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop how-shadow1">
                <nav class="limiter-menu-desktop container">

                    <!-- Logo desktop -->
                    <a href="#" class="logo">
                        <img src="imgnew/20241104_012926303_iOS-removebg-preview.png" alt="IMG-LOGO">
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li>
                                <a href="index.php">Início</a>
                            </li>

                            <li>
                                <a href="index.php#produtos">Compre</a>
                            </li>



                            <li>
                                <a href="about.html">Sobre</a>
                            </li>

                            <li class="active-menu">
                                <a href="contact.html">Contato</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">



                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">

            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <li>
                    <div class="left-top-bar">
                        Olá, <?= htmlspecialchars($user['nome']) ?>!
                    </div>
                </li>

                <li>
                    <div class="right-top-bar flex-w h-full">

                        <a href="logout.php" class="flex-c-m p-lr-10 trans-04">
                            SAIR
                        </a>
                    </div>
                </li>
            </ul>

            <ul class="main-menu-m">
                <li>
                    <a href="index.php">Início</a>
                    <span class="arrow-main-menu-m">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                </li>

                <li>
                    <a href="index.php#produtos">Compre</a>
                </li>



                <li>
                    <a href="about.html">Sobre</a>
                </li>

                <li>
                    <a href="contact.html">Contato</a>
                </li>
            </ul>
        </div>


    </header>


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92 container-banner"
        style="background: linear-gradient(to right, #159A9C, #002333)">
        <h2 class="ltext-105 cl0 txt-center">
            Pedidos
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr container-form">

                <!-- Formulário de Conta -->
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                    <h4 class="mtext-105 cl2 p-b-30">Seus pedidos</h4>

                    <?php
                    $query_pedidos = "SELECT p.id, p.data_pedido, p.status 
                      FROM pedidos p 
                      WHERE p.id_usuario = '{$_SESSION['usuario_id']}' 
                      ORDER BY p.data_pedido DESC";
                    $result_pedidos = mysqli_query($conn, $query_pedidos);

                    if (mysqli_num_rows($result_pedidos) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Data do Pedido</th>
                                    <th>Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pedido = mysqli_fetch_assoc($result_pedidos)): ?>
                                    <tr>
                                        <td><?= $pedido['id'] ?></td>
                                        <td><?= htmlspecialchars($pedido['status']) ?></td>
                                        <td><?= date("d/m/Y H:i", strtotime($pedido['data_pedido'])) ?></td>
                                        <td>
                                            <a href="?id=<?= $pedido['id'] ?>">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Você ainda não fez nenhum pedido.</p>
                    <?php endif; ?>

                    <?php
                    // Verificar se o ID do pedido foi passado
                    if (isset($_GET['id'])):
                        $id_pedido = $_GET['id'];
                        $query_pedido = "SELECT * FROM pedidos 
                        WHERE id = '$id_pedido' AND id_usuario = '{$_SESSION['usuario_id']}'";
                        $result_pedido = mysqli_query($conn, $query_pedido);
                        $pedido = mysqli_fetch_assoc($result_pedido);

                        if ($pedido): ?>
                            <div class="detalhes-pedido m-t-30">
                                <h5 class="mtext-104 cl2">Detalhes do Pedido #<?= $pedido['id'] ?></h5>
                                <p>Status: <?= htmlspecialchars($pedido['status']) ?></p>
                                <p>Data do Pedido: <?= date("d/m/Y H:i", strtotime($pedido['data_pedido'])) ?></p>

                                <h6>Itens do Pedido:</h6>
                                <?php
                                $query_itens = "SELECT pi.quantidade, pi.preco, p.nome AS nome_produto 
                                FROM pedidos_itens pi
                                INNER JOIN produtos p ON pi.id_produto = p.id 
                                WHERE pi.id_pedido = '$id_pedido'";
                                $result_itens = mysqli_query($conn, $query_itens);
                                ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Preço</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($item = mysqli_fetch_assoc($result_itens)): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($item['nome_produto']) ?></td>
                                                <td><?= $item['quantidade'] ?></td>
                                                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p>Pedido não encontrado.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>



                <!-- Lado Direito: Endereço e Imagem de Perfil -->
                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">


                    <!-- Endereço Existente -->
                    <div class="w-full p-b-42">
                        <form action="salvar_endereco.php" method="POST">
                            <input type="hidden" name="id_usuario" value="<?= $usuario_id; ?>">



                            <h4 class="mtext-105 cl2 p-b-10 p-t-20">Seu endereço</h4>
                            <?php if ($endereco): ?>
                                <p class="m-t-15 m-b-15 stext-106"><strong></strong> <?= $endereco['endereco']; ?></p>
                                <p class="m-t-15 m-b-15 stext-106"><strong>Cidade:</strong> <?= $endereco['cidade']; ?></p>
                                <p class="m-t-15 m-b-15 stext-106"><strong>Estado:</strong> <?= $endereco['estado']; ?></p>
                                <p class="m-t-15 m-b-15 stext-106"><strong>CEP:</strong> <?= $endereco['cep']; ?></p>
                            <?php else: ?>
                                <p>Você ainda não cadastrou um endereço.</p>
                            <?php endif; ?>

                            <?php if ($formulario_endereco): ?>
                                <div id="cadastre-endereco">
                                    <h4 class="mtext-105 cl2 p-b-10 p-t-20">Cadastro endereço</h4>
                                    <div class="form-group mtext-106 cl2 p-b-10">
                                        <label>Endereço:</label>
                                        <input type="text" class="form-control" name="endereco"
                                            placeholder="Digite o endereço">
                                    </div>

                                    <div class="form-group mtext-106 cl2 p-b-10">
                                        <label>Cidade:</label>
                                        <input type="text" class="form-control" name="cidade" placeholder="Digite a cidade">
                                    </div>

                                    <div class="form-group mtext-106 cl2 p-b-10">
                                        <label>Estado:</label>
                                        <input type="text" class="form-control" name="estado" placeholder="Digite o estado">
                                    </div>

                                    <div class="form-group mtext-106 cl2 p-b-10">
                                        <label>CEP:</label>
                                        <input type="text" class="form-control" name="cep" placeholder="Digite o CEP">
                                    </div>

                                    <div class="p-t-18 p-lr-105">
                                        <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 trans-04"
                                            type="submit">
                                            Cadastrar
                                        </button>
                                    </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <p class="m-t-15 m-b-15 stext-106">Você já possui um endereço cadastrado.</p>
                    <?php endif; ?>


                </div>
            </div>
        </div>
        </div>
    </section>







    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">Categorias</h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04"> Mulheres </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04"> Homens </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04"> Crianças </a>
                        </li>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">Ajuda</h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Pedidos
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04"> Reembolso </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Entrega
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04"> Perguntas</a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">PEÇA E RETIRE</h4>

                    <p class="stext-107 cl7 size-201">
                        Não quer esperar para receber em casa? Retire em uma de nossas lojas parceiras.
                    </p>

                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">novidades</h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
                                placeholder="email@example.com" />
                            <div class="focus-input1 trans-04"></div>
                        </div>

                        <div class="p-t-18">
                            <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Inscrever-se
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-01.png" alt="ICON-PAY" />
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-02.png" alt="ICON-PAY" />
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-03.png" alt="ICON-PAY" />
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-04.png" alt="ICON-PAY" />
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-05.png" alt="ICON-PAY" />
                    </a>
                </div>

                <p class="stext-107 cl6 txt-center">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    All rights reserved | Made with
                    <i class="fa fa-heart-o" aria-hidden="true"></i> by
                    <a target="_blank">GallerieInc</a> &amp;
                    developed by
                    <a target="_blank">2°C</a>
                </p>
            </div>
        </div>
    </footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function () {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function () {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function () {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
    <script src="js/map-custom.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>