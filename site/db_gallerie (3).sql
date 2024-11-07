-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/11/2024 às 05:29
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_gallerie`
--
CREATE DATABASE IF NOT EXISTS `db_gallerie` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_gallerie`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `acao` varchar(255) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `data_acao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL CHECK (`nota` >= 1 and `nota` <= 5),
  `comentario` text DEFAULT NULL,
  `data_avaliacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho_compra`
--

CREATE TABLE `carrinho_compra` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome_categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `data_contratacao` datetime DEFAULT current_timestamp(),
  `status` enum('ativo','inativo') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lojas`
--

CREATE TABLE `lojas` (
  `id` int(11) NOT NULL,
  `nome_loja` varchar(100) DEFAULT NULL,
  `email_loja` varchar(100) DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `data_parceria` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `tipo_pagamento` enum('cartao','boleto','paypal') DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data_pagamento` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_loja` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pendente','pago','enviado','entregue') DEFAULT 'pendente',
  `data_pedido` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `estoque` int(11) DEFAULT NULL,
  `id_loja` int(11) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `marca`, `tamanho`, `categoria`, `estoque`, `id_loja`, `id_funcionario`, `id_categoria`, `imagem`) VALUES
(3, 'Blusa ', 'Blusa de frio de lã com capô', 149.99, 'Marca C', 'G', 'Roupas', 20, 1, 1, 3, 'uploads/imagem_2024-11-06_211527248.png'),
(4, 'Vestido Floral', 'Vestido feminino floral, ideal para ocasiões informais', 120.00, 'Marca D', 'M', 'Roupas', 15, 1, 1, 4, NULL),
(5, 'Saia Longa', 'Saia longa de tecido leve e confortável', 79.90, 'Marca E', 'G', 'Roupas', 25, 1, 1, 4, NULL),
(6, 'Jaqueta de Couro', 'Jaqueta de couro sintético, modelo slim fit', 250.00, 'Marca F', 'P', 'Roupas', 10, 1, 1, 3, NULL),
(7, 'Tênis Esportivo', 'Tênis esportivo para caminhada e corrida', 199.99, 'Marca G', '41', 'Calçados', 40, 1, 1, 5, NULL),
(8, 'Bermuda Masculina', 'Bermuda masculina casual, ideal para o verão', 59.90, 'Marca H', 'M', 'Roupas', 60, 1, 1, 2, NULL),
(9, 'Blusa Polo', 'Blusa polo de algodão, disponível em várias cores', 89.90, 'Marca I', 'P', 'Roupas', 35, 1, 1, 1, NULL),
(10, 'Sutiã Confortável', 'Sutiã feminino de tecido confortável, com alças ajustáveis', 39.90, 'Marca J', 'P', 'Roupas', 100, 1, 1, 6, NULL),
(11, 'Shorts Feminino', 'Shorts feminino em denim, ideal para o verão', 49.90, 'Marca K', 'M', 'Roupas', 45, 1, 1, 4, 'uploads/calça.jpg'),
(12, 'Calça Jeans', 'calça preta básica', 199.90, 'Calvin Klein', 'XL', 'Roupas', 3, NULL, NULL, NULL, 'calça.jpg'),
(13, 'Moletom', 'Moletom preto com capuz', 200.00, 'Montserrat', 'G', 'Roupas', 50, NULL, NULL, NULL, 'uploads/blusa.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo_usuario` enum('cliente','administrador') DEFAULT 'cliente',
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`) VALUES
(1, 'Murilo Bezerra', 'murisud15@gmail.com', '1234', 'administrador', '2024-11-04 07:53:27'),
(2, 'Alice Silva', 'alice.silva@example.com', 'senha123', 'cliente', '2024-11-04 07:55:01'),
(3, 'Bruno Oliveira', 'bruno.oliveira@example.com', 'senha456', 'cliente', '2024-11-04 07:55:01'),
(4, 'Carlos Pereira', 'carlos.pereira@example.com', 'senha789', 'cliente', '2024-11-04 07:55:01'),
(5, 'Diana Costa', 'diana.costa@example.com', 'senha101', 'administrador', '2024-11-04 07:55:01'),
(6, 'Eduardo Santos', 'eduardo.santos@example.com', 'senha202', 'cliente', '2024-11-04 07:55:01'),
(7, 'Fernanda Lima', 'fernanda.lima@example.com', 'senha303', 'cliente', '2024-11-04 07:55:01'),
(8, 'Gabriel Rocha', 'gabriel.rocha@example.com', 'senha404', 'cliente', '2024-11-04 07:55:01'),
(9, 'Helena Martins', 'helena.martins@example.com', 'senha505', 'administrador', '2024-11-04 07:55:01'),
(10, 'Igor Almeida', 'igor.almeida@example.com', 'senha606', 'cliente', '2024-11-04 07:55:01'),
(11, 'Juliana Mendes', 'juliana.mendes@example.com', 'senha707', 'cliente', '2024-11-04 07:55:01'),
(12, 'Lucas Fernandes', 'lucas.fernandes@example.com', 'senha808', 'cliente', '2024-11-04 07:55:01'),
(14, 'Taylor Swift', 'taylorswift13@gmail.com', '$2y$10$1pKemy4gxbSPM7Pm3suMLur/8nzv0Xi1HXRI219cXCKSpbU8465tG', 'administrador', '2024-11-04 08:58:57'),
(15, 'Nicolas Lima', 'nicolas.lima@gmail.com', '$2y$10$W0v/rvEcYRNxQeoH6aCatOk6.XPIICu6nt69LfAJlANaqW39aG5lm', 'cliente', '2024-11-04 09:02:19'),
(16, 'Ariana Grande', 'arianagrande@gmail.com', '$2y$10$km3cteA9ZJGNbW5ymDuiaObIMfT84fWgCTL68MfyZVIxxo.npld/W', 'cliente', '2024-11-06 16:06:05'),
(18, 'Ariel', 'ariel@gmail.com', '$2y$10$snOjKxVKYgOaKz7YgtRhBeH9XeSmx97/qtsJ.Bs6GlR/LQcHqnPJS', 'cliente', '2024-11-06 16:17:12'),
(19, 'Maria', 'maria@gmail.com', '$2y$10$sB/9MFgrh1dnI27giyJ24.ded2P.T5IV85P.hE8Bli2XmBvkhyjTG', 'cliente', '2024-11-06 16:20:42'),
(20, 'Ryllary Victória', 'ryllary@gmail.com', '$2y$10$tieOiuhtXXmUQ09qtKbhIeTXojgRxtr2OD/FCCHHskevMbraeWWI6', 'administrador', '2024-11-06 16:23:30'),
(22, 'Lucas', 'luscas@gmail.com', '$2y$10$hS5i1EzUJdej5iLPKZSgDOKgmC.u9hjvQPetMmJtCTIMB.DHZcWYW', 'administrador', '2024-11-06 16:48:55'),
(23, 'Natasha Caldeirão', 'natashacald@gmail.com', '$2y$10$Lb6Ha9XOtRe9EDup7R26o.6axR4L296HB21Ru.1AIUuEpJAt4hb2G', 'administrador', '2024-11-06 18:16:12');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `lojas`
--
ALTER TABLE `lojas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lojas`
--
ALTER TABLE `lojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
