<?php
session_start();

// Verificar se o carrinho foi enviado
if (isset($_POST['carrinho'])) {
    // Converter o carrinho do JSON para array
    $_SESSION['carrinho'] = json_decode($_POST['carrinho'], true);
    echo "Carrinho enviado com sucesso!";
} else {
    echo "Erro ao enviar carrinho.";
}
?>