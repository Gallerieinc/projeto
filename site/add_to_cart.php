<?php
session_start();
include 'conect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Erro: Usuário não logado.";
    exit;
}

$id_produto = $_POST['id_produto'];  // Produto que está sendo adicionado
$id_usuario = $_SESSION['usuario_id'];  // ID do usuário que está logado
$quantidade = 1;  // A quantidade que será adicionada

// Verifica se o produto já está no carrinho
$checkCart = "SELECT * FROM carrinho_compra WHERE id_usuario = ? AND id_produto = ?";
$stmt = $conn->prepare($checkCart);
$stmt->bind_param("ii", $id_usuario, $id_produto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se o produto já estiver no carrinho, apenas atualiza a quantidade
    $updateCart = "UPDATE carrinho_compra SET quantidade = quantidade + 1 WHERE id_usuario = ? AND id_produto = ?";
    $stmt = $conn->prepare($updateCart);
    $stmt->bind_param("ii", $id_usuario, $id_produto);
    $stmt->execute();
} else {
    // Se o produto não estiver no carrinho, insere um novo item
    $addCart = "INSERT INTO carrinho_compra (id_usuario, id_produto, quantidade, data_adicionado) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($addCart);
    $stmt->bind_param("iii", $id_usuario, $id_produto, $quantidade);
    $stmt->execute();
}

// Carrega os itens atualizados do carrinho para resposta AJAX
include 'carregar_carrinho.php';

?>