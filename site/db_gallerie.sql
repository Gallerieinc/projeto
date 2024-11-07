-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 01:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gallerie`
--
CREATE DATABASE IF NOT EXISTS `db_gallerie` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_gallerie`;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
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
-- Table structure for table `avaliacoes`
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
-- Table structure for table `carrinho_compra`
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
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome_categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enderecos`
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
-- Table structure for table `funcionarios`
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
-- Table structure for table `lojas`
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
-- Table structure for table `pagamentos`
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
-- Table structure for table `pedidos`
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
-- Table structure for table `produtos`
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
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `marca`, `tamanho`, `categoria`, `estoque`, `id_loja`, `id_funcionario`, `id_categoria`, `imagem`) VALUES
(3, 'Blusa ', 'Blusa de frio de lÃ£ com capuz', '149.99', 'Marca C', 'G', 'Roupas', 20, 1, 1, 3, 'uploads/imagem_2024-11-06_211527248.png'),
(4, 'taffeta midi dress', 'Vestido de bolinhas de alta costura para ocasiÃµes formais.', '7965.00', 'Self-portrait', 'M', 'Roupas', 15, 1, 1, 4, 'uploads/vestido.jpg'),
(5, 'Saia Longa', 'Saia longa de tecido leve.', '499.00', 'Olympiah', 'G', 'Roupas', 25, 1, 1, 4, 'uploads/saia.jpg'),
(6, 'Short', 'Beach Wear', '250.00', 'Boss', 'P', 'Roupas', 10, 1, 1, 3, 'uploads/short.jpg'),
(7, 'TÃªnis Esportivo', 'TÃªnis esportivo para caminhada e corrida', '199.99', 'Marca G', '41', 'Calï¿½ados', 40, 1, 1, 5, 'uploads/tenis.jpg'),
(9, 'Blusa Polo', 'Blusa polo de algodÃ£o', '89.90', 'Marca I', 'P', 'Roupas', 35, 1, 1, 1, 'uploads/polo.jpg'),
(11, 'Shorts Feminino', 'Shorts feminino em denim, ideal para o verÃ£o', '49.90', 'Marca K', 'M', 'Roupas', 45, 1, 1, 4, 'uploads/shortfem.jpg'),
(12, 'CalÃ§a Jeans', 'calÃ§a bÃ¡sica', '199.90', 'Calvin Klein', 'XL', 'Roupas', 3, NULL, NULL, NULL, 'uploads/jeans.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
-- Dumping data for table `usuarios`
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
(20, 'Ryllary VictÃ³ria', 'ryllary@gmail.com', '$2y$10$tieOiuhtXXmUQ09qtKbhIeTXojgRxtr2OD/FCCHHskevMbraeWWI6', 'administrador', '2024-11-06 16:23:30'),
(22, 'Lucas', 'luscas@gmail.com', '$2y$10$hS5i1EzUJdej5iLPKZSgDOKgmC.u9hjvQPetMmJtCTIMB.DHZcWYW', 'administrador', '2024-11-06 16:48:55'),
(23, 'Natasha CaldeirÃ£o', 'natashacald@gmail.com', '$2y$10$Lb6Ha9XOtRe9EDup7R26o.6axR4L296HB21Ru.1AIUuEpJAt4hb2G', 'administrador', '2024-11-06 18:16:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `lojas`
--
ALTER TABLE `lojas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lojas`
--
ALTER TABLE `lojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
