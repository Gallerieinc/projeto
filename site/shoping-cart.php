<?php
session_start();
include('conect.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
	header("Location: login.php");
	exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obter os itens do carrinho do banco de dados
$query = "SELECT c.id_produto, p.nome, p.preco, p.imagem, c.quantidade
          FROM carrinho_compra c
          INNER JOIN produtos p ON c.id_produto = p.id
          WHERE c.id_usuario = '$usuario_id'";
$result = mysqli_query($conn, $query);

// Armazenar os produtos em um array
$produtos_carrinho = [];
while ($row = mysqli_fetch_assoc($result)) {
	$produtos_carrinho[] = $row;
}

$total = 0; // Variável para calcular o total do carrinho
foreach ($produtos_carrinho as $produto) {
	$total += $produto['preco'] * $produto['quantidade'];
}

// Inserir o pedido na tabela pedidos
$date = date("Y-m-d H:i:s");
$status = 'pago'; // Pode ser alterado dependendo do fluxo
$query_pedido = "INSERT INTO pedidos (id_usuario, status, data_pedido) VALUES ('$usuario_id', '$status', '$date')";
mysqli_query($conn, $query_pedido);

// Obter o ID do pedido recém-criado
$id_pedido = mysqli_insert_id($conn);

// Associar os itens do carrinho ao pedido
foreach ($produtos_carrinho as $item) {
	$id_produto = $item['id_produto'];
	$quantidade = $item['quantidade'];
	$preco = $item['preco'];

	// Inserir os itens no pedido
	$query_item = "INSERT INTO pedidos_itens (id_pedido, id_produto, quantidade, preco) 
                   VALUES ('$id_pedido', '$id_produto', '$quantidade', '$preco')";
	mysqli_query($conn, $query_item);
}

// Após inserir os dados, redirecionar o usuário para a página de pedidos
//header("Location: pedido.php");
//exit;
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Carrinho</title>
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
						Frete grátis acima de R$100.00
					</div>

					<div class="right-top-bar flex-w h-full">


						<a href="profile.php" class="flex-c-m trans-04 p-lr-25">
							Minha conta
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							PT-BR
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							BRL
						</a>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">

					<!-- Logo desktop -->
					<a href="index.php" class="logo">
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

							<li>
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
				<a href="index.php"><img src="imgnew/20241104_012926303_iOS-removebg-preview.png" alt="IMG-LOGO"></a>
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
						Frete Grátis acima de R$100.00
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">

						<a href="profile.php" class="flex-c-m p-lr-10 trans-04">
							Minha conta
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							PT-BR
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							BRL
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Início</a>
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



	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Início
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Carrinho
			</span>
		</div>
	</div>




	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Produto</th>
									<th class="column-2">Nome</th>
									<th class="column-3">Preço</th>
									<th class="column-4" style="padding-right: 4rem;">Quantidade</th>
									<th class="column-5">Total</th>
								</tr>

								<?php
								// Exibir os produtos no carrinho
								$total = 0;
								foreach ($produtos_carrinho as $produto) {
									$total_produto = $produto['preco'] * $produto['quantidade'];
									$total += $total_produto;
									echo "<tr class='table_row'>
                                    <td class='column-1'>
                                        <div class='how-itemcart1'>
                                            <img src='{$produto['imagem']}' alt='{$produto['nome']}'>
                                        </div>
                                    </td>
                                    <td class='column-2'>{$produto['nome']}</td>
                                    <td class='column-3'>R$ {$produto['preco']}</td>
                                    <td class='column-4'>
                                        <div class=' flex-w m-l-auto m-r-0'>
                                            <input class='mtext-104 cl3 txt-center ' type='number' name='num-product[{$produto['id_produto']}]' value='{$produto['quantidade']}' min='1'>
                                        </div>
                                    </td>
                                    <td class='column-5'>R$ {$total_produto}</td>
                                </tr>";
								}
								?>

							</table>
						</div>

						<!-- Total do carrinho -->
						<div class="flex-w flex-t bor12 p-b-13">


						</div>

						<!-- Botões -->
						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
							<div class="size-208">
								<span class="stext-110 cl2">Subtotal:</span>
							</div>
							<div class="size-209">
								<span class="mtext-110 cl2">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Totais e botão de finalizar -->
				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Total do carrinho
						</h4>
						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">Total:</span>
							</div>
							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
							</div>
						</div>
						<button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
							id="pedido-carrinho">
							<a href="pedido.php" style="color: white;">Finalizar compra</a>
						</button>

					</div>
				</div>
			</div>
		</div>
	</form>






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
	<script src="js/main.js"></script>

</body>

</html>