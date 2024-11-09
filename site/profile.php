<?php
session_start();
include 'conect.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

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
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Perfil</title>
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
                                <a href="product.html">Compre</a>
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

                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="2">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>

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
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>

                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                    data-notify="2">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>

                <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                    data-notify="0">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
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
                    <a href="index.html">Início</a>
                    <span class="arrow-main-menu-m">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                </li>

                <li>
                    <a href="product.html">Compre</a>
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

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Carrinho
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-01.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Camiseta Branca
                            </a>

                            <span class="header-cart-item-info">
                                1 x R$19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-02.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x R$39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-03.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x R$17.00
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            Ver carrinho
                        </a>

                        <a href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Finalizar compra
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92 container-banner"
        style="background: linear-gradient(to right, #159A9C, #002333)">
        <h2 class="ltext-105 cl0 txt-center">
            Perfil
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr container-form">
                <!-- Formulário de Conta -->
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">

                    <h4 class="mtext-105 cl2 p-b-30">
                        Sua conta
                    </h4>

                    <!-- Nome do Usuário -->
                    <h3 class="mtext-106 cl2 p-b-10">
                        Nome completo
                    </h3>
                    <div class="bor8 m-b-20 how-pos4-parent">
                        <h3 class="m-t-15 m-b-15 p-l-20 stext-106"><?= htmlspecialchars($user['nome']) ?></h3>
                    </div>

                    <!-- Email do Usuário -->
                    <h3 class="mtext-106 cl2 p-b-10">
                        Email
                    </h3>
                    <div class="bor8 m-b-20 how-pos4-parent">
                        <h3 class="m-t-15 m-b-15 p-l-20 stext-106"><?= htmlspecialchars($user['email']) ?></h3>
                    </div>

                    <!-- Sexo do Usuário -->
                    <h3 class="mtext-106 cl2 p-b-10">
                        Sexo
                    </h3>
                    <div class="bor8 m-b-20 how-pos4-parent">
                        <h3 class="m-t-15 m-b-15 p-l-20 stext-106"><?= htmlspecialchars($user['genero']) ?></h3>
                    </div>




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