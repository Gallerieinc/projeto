<?php
// Iniciar sessão e verificar se o usuário está logado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Conectar ao banco de dados
include("conect.php");

// Obter o ID do pedido
$id_pedido = $_GET['id'];

// Obter os dados do pedido
$query = "SELECT * FROM pedidos WHERE id = '$id_pedido' AND id_usuario = '{$_SESSION['usuario_id']}'";
$result = mysqli_query($conn, $query);
$pedido = mysqli_fetch_assoc($result);

// Verificar se o pedido existe
if (!$pedido) {
    echo "Pedido não encontrado.";
    exit;
}

// Obter os itens do pedido, incluindo o nome do produto da tabela 'produtos'
$query_itens = "SELECT pi.quantidade, pi.preco, p.nome AS nome_produto 
                FROM pedidos_itens pi
                INNER JOIN produtos p ON pi.id_produto = p.id
                WHERE pi.id_pedido = '$id_pedido'";
$result_itens = mysqli_query($conn, $query_itens);
?>

<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <h4 class="mtext-105 cl2 p-b-30">Detalhes do Pedido #<?= $pedido['id'] ?></h4>

        <p>Status: <?= $pedido['status'] ?></p>
        <p>Data do Pedido: <?= date("d/m/Y H:i", strtotime($pedido['data_pedido'])) ?></p>

        <h5>Itens do Pedido:</h5>
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
                        <td><?= $item['nome_produto'] ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>