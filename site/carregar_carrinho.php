<?php
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Erro: Usuário não logado.";
    exit;
}

// Obter o ID do usuário logado
$id_usuario = $_SESSION['usuario_id'];

$cart_items_html = '';

// Consulta os itens no carrinho do usuário
$sql = "SELECT c.id_produto, p.nome, p.preco, c.quantidade, p.imagem FROM carrinho_compra c JOIN produtos p ON c.id_produto = p.id WHERE c.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

//inicia com total produto = 0
$total = 0;

// Se houver produtos no carrinho, gera o HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calcula o total de cada item (quantidade * preço)
        $item_total = $row['quantidade'] * $row['preco'];
        $total += $item_total;  // Adiciona ao total geral


        $cart_items_html .= '<li class="header-cart-item flex-w flex-t m-b-12" data-id="' . $row['id_produto'] . '">';
        $cart_items_html .= '<div class="header-cart-item-img">';
        $cart_items_html .= '<img src="' . $row['imagem'] . '" alt="IMG" class="cart-item-img" />';
        $cart_items_html .= '<span class="remove-item" style="display:none;"><i class="zmdi zmdi-close"></i></span>';  // Ícone de excluir
        $cart_items_html .= '</div>';
        $cart_items_html .= '<div class="header-cart-item-txt p-t-8">';
        $cart_items_html .= '<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">' . $row['nome'] . '</a>';
        $cart_items_html .= '<span class="header-cart-item-info">' . $row['quantidade'] . ' x $' . number_format($row['preco'], 2) . '</span>';
        $cart_items_html .= '</div>';
        $cart_items_html .= '</li>';

    }
} else {
    echo "Carrinho vazio.";
}

// Exibe o total do carrinho

$cart_items_html .= '<li class="header-cart-total">Total: $' . number_format($total, 2) . '</li>';

echo $cart_items_html;
?>