<?php
session_start();
include 'conect.php';
// Conexão com o banco de dados
$servername = "localhost"; // Altere para o seu servidor
$username = "root"; // Altere para o seu usuário
$password = ""; // Altere para sua senha
$dbname = "db_gallerie";

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando conexão
if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}

// Query para selecionar todos os produtos
$sql = "SELECT id, nome, imagem, descricao, preco FROM produtos";
$result = $conn->query($sql);
$conn->close();


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Início - GallerieInc</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="imgnew/20241104_012926303_iOS-removebg-preview.png" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css" />
  <link rel="stylesheet" type="text/css" href="css/main.css" />
  <!--===============================================================================================-->
</head>

<body class="animsition">
  <!-- Header -->
  <header class="header-v3">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
      <div class="wrap-menu-desktop">
        <nav class="limiter-menu-desktop p-l-45">
          <!-- Logo desktop -->
          <a href="#" class="logo">
            <img src="imgnew/20241104_012926303_iOS-removebg-preview.png" alt="IMG-LOGO" />
          </a>

          <!-- Menu desktop -->
          <div class="menu-desktop">
            <ul class="main-menu">
              <li>
                <a href="home-03.html">Início</a>
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

          <!-- Icon header -->
          <div class="wrap-icon-header flex-w flex-r-m h-full">
            <div class="flex-c-m h-full p-r-25 bor6">
              <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
              </div>
            </div>

            <div class="flex-c-m h-full p-lr-19">
              <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                <i class="zmdi zmdi-menu"></i>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
      <!-- Logo moblie -->
      <div class="logo-mobile">
        <a href="index.html"><img src="imgnew/20241104_012926303_iOS-removebg-preview.png" alt="IMG-LOGO" /></a>
      </div>

      <!-- Icon header -->
      <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
        <div class="flex-c-m h-full p-r-5">
          <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
            <i class="zmdi zmdi-shopping-cart"></i>
          </div>
        </div>
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
      <ul class="main-menu-m">
        <li>
          <a href="index.html">Início</a>
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

        <li>
          <a href="profile.php">Minha Conta</a>
        </li>
      </ul>
    </div>

    <!-- Modal Search -->

  </header>


  <!-- Sidebar -->
  <aside class="wrap-sidebar js-sidebar">
    <div class="s-full js-hide-sidebar"></div>

    <div class="sidebar flex-col-l p-t-22 p-b-25">
      <div class="flex-r w-full p-b-30 p-r-27">
        <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
          <i class="zmdi zmdi-close"></i>
        </div>
      </div>

      <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
        <ul class="sidebar-link w-full">
          <li class="p-b-13">
            <a href="index.php" class="stext-102 cl2 hov-cl1 trans-04">
              Início
            </a>
          </li>

          <li class="p-b-13">
            <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
              Favoritos
            </a>
          </li>


          <li class="p-b-13">
            <a href="profile.php" class="stext-102 cl2 hov-cl1 trans-04">Minha Conta</a>
          </li>
          <li class="p-b-13">
            <a href="logout.php" class="stext-102 cl2 hov-cl1 trans-04">Sair</a>
          </li>
          <li class="p-b-13">
            <a href="#" class="stext-102 cl2 hov-cl1 trans-04"> Pedidos </a>
          </li>

          <li class="p-b-13">
            <a href="#" class="stext-102 cl2 hov-cl1 trans-04"> Reembolso </a>
          </li>

          <li class="p-b-13">
            <a href="#" class="stext-102 cl2 hov-cl1 trans-04"> Ajuda </a>
          </li>
        </ul>

        <div class="sidebar-gallery w-full p-tb-30">
          <span class="mtext-101 cl5"> @ GallerieInc </span>

          <div class="flex-w flex-sb p-t-36 gallery-lb">
            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/gallery-01.png" data-lightbox="gallery"
                style="background-image: url('images/gallery-01.png')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g2.jpg" data-lightbox="gallery"
                style="background-image: url('images/g2.jpg')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g3.png" data-lightbox="gallery"
                style="background-image: url('images/g3.png')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g4.jpg" data-lightbox="gallery"
                style="background-image: url('images/g4.jpg')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g5.jpg" data-lightbox="gallery"
                style="background-image: url('images/g5.jpg')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g6.jpg" data-lightbox="gallery"
                style="background-image: url('images/g6.jpg')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g7.jpg" data-lightbox="gallery"
                style="background-image: url('images/g7.jpg')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g8.webp" data-lightbox="gallery"
                style="background-image: url('images/g8.webp')"></a>
            </div>

            <!-- item gallery sidebar -->
            <div class="wrap-item-gallery m-b-10">
              <a class="item-gallery bg-img1" href="images/g8.jpeg" data-lightbox="gallery"
                style="background-image: url('images/g8.jpeg')"></a>
            </div>
          </div>
        </div>

        <div class="sidebar-gallery w-full">
          <span class="mtext-101 cl5"> Sobre </span>

          <p class="stext-108 cl6 p-t-27">
            Com sede em São Paulo, a Gallerie se consolidou ao longo dos anos como uma plataforma de referência para os
            amantes da moda de luxo, trazendo as últimas coleções das mais renomadas casas de design internacional e
            marcas emergentes de alto nível. Acreditamos que a moda não é apenas sobre roupas, mas sobre expressão,
            identidade e cultura.
          </p>
        </div>
      </div>
    </div>
  </aside>


  <!-- Cart -->
  <div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
      <div class="header-cart-title flex-w flex-sb-m p-b-8">
        <span class="mtext-103 cl2">Carrinho</span>

        <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
          <i class="zmdi zmdi-close"></i>
        </div>
      </div>

      <div class="header-cart-content flex-w js-pscroll">
        <ul class="header-cart-wrapitem w-full">
          <li class="header-cart-item flex-w flex-t m-b-12">
            <div class="header-cart-item-img">
              <img src="images/item-cart-01.jpg" alt="IMG" />
            </div>

            <div class="header-cart-item-txt p-t-8">
              <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                White Shirt Pleat
              </a>

              <span class="header-cart-item-info"> 1 x $19.00 </span>
            </div>
          </li>

          <li class="header-cart-item flex-w flex-t m-b-12">
            <div class="header-cart-item-img">
              <img src="images/item-cart-02.jpg" alt="IMG" />
            </div>

            <div class="header-cart-item-txt p-t-8">
              <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                Converse All Star
              </a>

              <span class="header-cart-item-info"> 1 x $39.00 </span>
            </div>
          </li>

          <li class="header-cart-item flex-w flex-t m-b-12">
            <div class="header-cart-item-img">
              <img src="images/item-cart-03.jpg" alt="IMG" />
            </div>

            <div class="header-cart-item-txt p-t-8">
              <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                Nixon Porter Leather
              </a>

              <span class="header-cart-item-info"> 1 x $17.00 </span>
            </div>
          </li>
        </ul>

        <div class="w-full">
          <div class="header-cart-total w-full p-tb-40">Total: $75.00</div>

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

  <!-- Slider -->
  <section class="section-slide">
    <div class="wrap-slick1 rs2-slick1">
      <div class="slick1">
        <div class="item-slick1 bg-overlay1" style="background-image: url(images/bg-01.png)"
          data-thumb="images/bg-01.png" data-caption="Moda Feminina">
          <div class="container h-full">
            <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
              <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                <span class="ltext-202 txt-center cl0 respon2">
                  Coleção Primavera 2024
                </span>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                  Lançamentos
                </h2>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                  Compre agora
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="item-slick1 bg-overlay1" style="background-image: url(images/bg.png)" data-thumb="images/bg.png"
          data-caption="Moda Masculina">
          <div class="container h-full">
            <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
              <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                <span class="ltext-202 txt-center cl0 respon2">
                  SPFW 2024
                </span>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                  Jaquetas e Moletons
                </h2>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                  Compre agora
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="item-slick1 bg-overlay1" style="background-image: url(images/bg02.jpg)" data-thumb="images/bg02.jpg"
          data-caption="Moda Infantil">
          <div class="container h-full">
            <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
              <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                <span class="ltext-202 txt-center cl0 respon2">
                  Coleção Infantil 2025
                </span>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                  NOVA COLEÇÃO
                </h2>
              </div>

              <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                  Compre agora
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="wrap-slick1-dots p-lr-10"></div>
    </div>
  </section>

  <!-- Banner -->
  <div class="sec-banner bg0 p-t-95 p-b-55">
    <div class="container">
      <div class="row">
        <div class="col-md-6 p-b-30 m-lr-auto">
          <!-- Block1 -->
          <div class="block1 wrap-pic-w round-box">
            <img src="images/banner-04.jpg" alt="IMG-BANNER" />

            <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
              <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                  Mulher
                </span>

                <span class="block1-info stext-102 trans-04">
                  Tendências
                </span>
              </div>

              <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                  Compre agora
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-6 p-b-30 m-lr-auto">
          <!-- Block1 -->
          <div class="block1 wrap-pic-w round-box">
            <img src="images/banner-05.jpg" alt="IMG-BANNER" />

            <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
              <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                  Homem
                </span>

                <span class="block1-info stext-102 trans-04">
                  Tendências
                </span>
              </div>

              <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                  Compre agora
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
          <!-- Block1 -->
          <div class="block1 wrap-pic-w round-box">
            <img src="images/banner-07.jpg" alt="IMG-BANNER" />

            <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
              <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                  Relógios
                </span>

                <span class="block1-info stext-102 trans-04">
                  Primavera 2024
                </span>
              </div>

              <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                  Compre Agora
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
          <!-- Block1 -->
          <div class="block1 wrap-pic-w round-box">
            <img src="images/banner-08.jpg" alt="IMG-BANNER" />

            <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
              <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                  Bolsas
                </span>

                <span class="block1-info stext-102 trans-04">
                  Primavera 2024
                </span>
              </div>

              <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                  Compre agora
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-lg-4 p-b-30 m-lr-auto">
          <!-- Block1 -->
          <div class="block1 wrap-pic-w round-box">
            <img src="images/banner-09.jpg" alt="IMG-BANNER" />

            <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
              <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                  Accessórios
                </span>

                <span class="block1-info stext-102 trans-04">
                  Primavera 2024
                </span>
              </div>

              <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                  Compre agora
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Product -->
  <section class="bg0 p-t-23 p-b-130">
    <div class="container">
      <div class="p-b-10">
        <h3 class="ltext-103 cl5">Ver produtos</h3>
      </div>

      <div class="flex-w flex-sb-m p-b-52">
        <div class="flex-w flex-l-m filter-tope-group m-tb-10">
          <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
            Todos os produtos
          </button>
        </div>

        <div class="flex-w flex-c-m m-tb-10">

          <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
            <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
            <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
            Pesquisar
          </div>
        </div>

        <!-- Search product -->
        <div class="dis-none panel-search w-full p-t-10 p-b-15">
          <div class="bor8 dis-flex p-l-15">
            <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
              <i class="zmdi zmdi-search"></i>
            </button>

            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search" />
          </div>
        </div>
      </div>

      <div class="row isotope-grid">
        <?php if ($result->num_rows > 0) {
          // Exibindo cada produto
          while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
              <!-- Block2 -->
              <div class="block2">
                <div class="block2-pic hov-img0">
                  <img src="<?php echo $row['imagem']; ?>" alt="IMG-PRODUCT" />

                  <a href="javascript:void(0);"
                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 wrap-item-gallery"
                    data-img="<?php echo $row['imagem']; ?>" onclick="openModal(this)">
                    Ampliar
                  </a>
                </div>

                <div class="block2-txt flex-w flex-t p-t-14">
                  <div class="block2-txt-child1 flex-col-l">
                    <a href="product-detail.php?nome=<?php echo urlencode($row['nome']); ?>"
                      class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                      <?php echo $row['nome']; ?>
                    </a>

                    <span class="stext-105 cl3"> R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></span>
                  </div>


                </div>
              </div>
            </div>
            <?php
          }
        } else {
          echo "Nenhum produto encontrado.";
        }
        ?>

        <!-- Modal para ampliar a imagem -->
        <div id="imageModal" class="modal" style="display:none;">
          <span class="close-btn" onclick="closeModal()">&times;</span>
          <img class="modal-content" id="imgModal">
        </div>

        <!-- Adicionar os scripts para o Modal -->
        <script>
          function openModal(element) {
            // Obtém a URL da imagem que foi clicada
            var imgSrc = element.getAttribute('data-img');

            // Define a imagem do modal
            document.getElementById("imgModal").src = imgSrc;

            // Exibe o modal
            document.getElementById("imageModal").style.display = "block";
          }

          function closeModal() {
            // Fecha o modal
            document.getElementById("imageModal").style.display = "none";
          }
        </script>

        <!-- Estilos para o modal -->
        <style>
          /* Estilo do modal */
          .modal {
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            padding-top: 10%
          }

          /* Imagem do modal */
          .modal-content {
            max-width: 90%;
            max-height: 80%;
            margin: auto;
          }

          /* Estilo do botão de fechar */
          .close-btn {
            position: absolute;
            top: 10px;
            right: 25px;
            color: #fff;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
          }

          .close-btn:hover,
          .close-btn:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
          }
        </style>
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
        dropdownParent: $(this).next(".dropDownSelect2"),
      });
    });
  </script>
  <!--===============================================================================================-->
  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/slick/slick.min.js"></script>
  <script src="js/slick-custom.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/parallax100/parallax100.js"></script>
  <script>
    $(".parallax100").parallax100();
  </script>
  <!--===============================================================================================-->
  <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
  <script>
    $(".gallery-lb").each(function () {
      // the containers for all your galleries
      $(this).magnificPopup({
        delegate: "a", // the selector for gallery item
        type: "image",
        gallery: {
          enabled: true,
        },
        mainClass: "mfp-fade",
      });
    });
  </script>
  <!--===============================================================================================-->
  <script src="vendor/isotope/isotope.pkgd.min.js"></script>
  <!--===============================================================================================-->
  <script src="vendor/sweetalert/sweetalert.min.js"></script>
  <script>
    $(".js-addwish-b2").on("click", function (e) {
      e.preventDefault();
    });

    $(".js-addwish-b2").each(function () {
      var nameProduct = $(this).parent().parent().find(".js-name-b2").html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-b2");
        $(this).off("click");
      });
    });

    $(".js-addwish-detail").each(function () {
      var nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();

      $(this).on("click", function () {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass("js-addedwish-detail");
        $(this).off("click");
      });
    });

    /*---------------------------------------------*/

    $(".js-addcart-detail").each(function () {
      var nameProduct = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".js-name-detail")
        .html();
      $(this).on("click", function () {
        swal(nameProduct, "is added to cart !", "success");
      });
    });
  </script>
  <!--===============================================================================================-->
  <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script>
    $(".js-pscroll").each(function () {
      $(this).css("position", "relative");
      $(this).css("overflow", "hidden");
      var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
      });

      $(window).on("resize", function () {
        ps.update();
      });
    });
  </script>
  <!--===============================================================================================-->
  <script src="js/main.js"></script>
</body>

</html>