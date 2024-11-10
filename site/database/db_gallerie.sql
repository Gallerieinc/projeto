-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/11/2024 às 02:11
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
-- Estrutura para tabela `carrinho_compra`
--

CREATE TABLE `carrinho_compra` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrinho_compra`
--

INSERT INTO `carrinho_compra` (`id`, `id_usuario`, `id_produto`, `quantidade`, `data_adicionado`) VALUES
(1, 24, 4, 6, '2024-11-09 17:21:25'),
(2, 24, 6, 7, '2024-11-09 17:21:36'),
(3, 24, 5, 8, '2024-11-09 17:28:29'),
(4, 24, 7, 11, '2024-11-09 17:32:02'),
(5, NULL, 5, 1, '2024-11-09 17:42:32'),
(6, NULL, 5, 1, '2024-11-09 17:47:27'),
(7, 24, 12, 1, '2024-11-09 18:15:12'),
(8, 24, 25, 1, '2024-11-09 18:20:18'),
(9, 24, 11, 3, '2024-11-09 18:28:40'),
(10, 24, 21, 1, '2024-11-09 18:36:17');

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

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `id_usuario`, `endereco`, `cidade`, `estado`, `cep`) VALUES
(2, 19, 'Rua Juazeiro, 170 Quarta Divisão', 'Ribeirão Pires', 'São Paulo', '09434-530'),
(3, 19, '', '', '', ''),
(4, 14, 'DIsney', 'Orlando', 'SP', '09434-530'),
(5, 24, 'DIsney', 'Ribeirão Pires', 'SP', '09434-530');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `status` enum('pendente','pago','enviado','entregue') DEFAULT 'pago',
  `data_pedido` datetime DEFAULT current_timestamp(),
  `id_carrinho_compra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `status`, `data_pedido`, `id_carrinho_compra`) VALUES
(1, 24, 'pago', '2024-11-10 01:32:07', NULL),
(2, 24, 'pago', '2024-11-10 01:32:42', NULL),
(3, 24, 'pago', '2024-11-10 01:33:28', NULL),
(4, 24, 'pago', '2024-11-10 01:34:09', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos_itens`
--

CREATE TABLE `pedidos_itens` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos_itens`
--

INSERT INTO `pedidos_itens` (`id`, `id_pedido`, `id_produto`, `quantidade`, `preco`) VALUES
(1, 2, 4, 6, 0.00),
(2, 2, 6, 7, 0.00),
(3, 2, 5, 8, 0.00),
(4, 2, 7, 11, 0.00),
(5, 2, 12, 1, 0.00),
(6, 2, 25, 1, 0.00),
(7, 2, 11, 3, 0.00),
(8, 2, 21, 1, 0.00),
(9, 3, 4, 6, 0.00),
(10, 3, 6, 7, 0.00),
(11, 3, 5, 8, 0.00),
(12, 3, 7, 11, 0.00),
(13, 3, 12, 1, 0.00),
(14, 3, 25, 1, 0.00),
(15, 3, 11, 3, 0.00),
(16, 3, 21, 1, 0.00),
(17, 4, 4, 6, 0.00),
(18, 4, 6, 7, 0.00),
(19, 4, 5, 8, 0.00),
(20, 4, 7, 11, 0.00),
(21, 4, 12, 1, 0.00),
(22, 4, 25, 1, 0.00),
(23, 4, 11, 3, 0.00),
(24, 4, 21, 1, 0.00);

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
  `imagem` varchar(255) DEFAULT NULL,
  `cor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `marca`, `tamanho`, `categoria`, `estoque`, `id_loja`, `id_funcionario`, `id_categoria`, `imagem`, `cor`) VALUES
(4, 'taffeta midi dress', 'Vestido de bolinhas de alta costura para ocasioes formais.', 7965.00, 'Self-portrait', 'M', 'Roupas', 15, 1, 1, 4, 'uploads/vestido.jpg', NULL),
(5, 'Saia Longa', 'Saia longa de tecido leve.', 499.00, 'Olympiah', 'G', 'Roupas', 25, 1, 1, 4, 'uploads/saia.jpg', NULL),
(6, 'Short', 'Beach Wear', 250.00, 'Boss', 'P', 'Roupas', 10, 1, 1, 3, 'uploads/short.jpg', NULL),
(7, 'Tenis Esportivo', 'Tenis esportivo para caminhada e corrida', 199.99, 'Marca G', '41', 'Calï¿½ados', 40, 1, 1, 5, 'uploads/tenis.jpg', NULL),
(9, 'Blusa Polo', 'Blusa polo de algodao', 89.90, 'Marca I', 'P', 'Roupas', 35, 1, 1, 1, 'uploads/polo.jpg', NULL),
(11, 'Shorts Feminino', 'Shorts feminino em denim, ideal para o verao', 49.90, 'Marca K', 'M', 'Roupas', 45, 1, 1, 4, 'uploads/shortfem.jpg', NULL),
(12, ' Jeans', 'jeans basica', 199.90, 'Calvin Klein', 'XL', 'Roupas', 3, NULL, NULL, NULL, 'uploads/jeans.jpg', NULL),
(21, 'Vestido preto', 'Moda Ideal para festas', 10999.00, 'Ivy Saint-Laurent', 'P', 'Roupas', 10, NULL, NULL, NULL, 'uploads/product-01.jpg', NULL),
(22, 'Vestido vermelho com decote', 'Alta costura francesa, ideal para eventos formais.', 5600.00, 'Self-portrait', 'M', 'Roupas', 35, NULL, NULL, NULL, 'uploads/product-02.jpg', NULL),
(23, 'Casaco bege', 'Ideal para o inverno, compre com desconto.', 4000.00, 'Burberry', 'G', 'Roupas', 70, NULL, NULL, NULL, 'uploads/product-04.jpg', NULL),
(24, 'Relogio de prata e diamante', 'Banhado a ouro e com pedras cravejadas a mao por artesaos.', 50000.00, 'Rolex', 'N/A', 'Acessorios', 10, NULL, NULL, NULL, 'uploads/product-06.jpg', NULL),
(25, 'Vestido florido', 'Vestido florido para primavera/verao, ideal para eventos casuais', 7500.00, 'Prada', 'M', 'Roupas', 15, NULL, NULL, NULL, 'uploads/product-14.jpg', NULL);

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
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `genero` enum('Feminino','Masculino','Prefiro não dizer') NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo_usuario`, `data_cadastro`, `genero`, `imagem`) VALUES
(1, 'Murilo Bezerra', 'murisud15@gmail.com', '1234', 'administrador', '2024-11-04 07:53:27', 'Masculino', NULL),
(2, 'Alice Silva', 'alice.silva@example.com', 'senha123', 'cliente', '2024-11-04 07:55:01', 'Prefiro não dizer', NULL),
(3, 'Bruno Oliveira', 'bruno.oliveira@example.com', 'senha456', 'administrador', '2024-11-04 07:55:01', 'Masculino', NULL),
(4, 'Carlos Pereira', 'carlos.pereira@example.com', 'senha789', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(5, 'Diana Costa', 'diana.costa@example.com', 'senha101', 'administrador', '2024-11-04 07:55:01', 'Feminino', NULL),
(6, 'Eduardo Santos', 'eduardo.santos@example.com', 'senha202', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(7, 'Fernanda Lima', 'fernanda.lima@example.com', 'senha303', 'cliente', '2024-11-04 07:55:01', 'Feminino', NULL),
(8, 'Gabriel Rocha', 'gabriel.rocha@example.com', 'senha404', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(9, 'Helena Martins', 'helena.martins@example.com', 'senha505', 'administrador', '2024-11-04 07:55:01', 'Feminino', NULL),
(10, 'Igor Almeida', 'igor.almeida@example.com', 'senha606', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(11, 'Juliana Mendes', 'juliana.mendes@example.com', 'senha707', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(12, 'Lucas Fernandes', 'lucas.fernandes@example.com', 'senha808', 'cliente', '2024-11-04 07:55:01', 'Masculino', NULL),
(14, 'Taylor Swift', 'taylorswift13@gmail.com', '$2y$10$1pKemy4gxbSPM7Pm3suMLur/8nzv0Xi1HXRI219cXCKSpbU8465tG', 'administrador', '2024-11-04 08:58:57', 'Feminino', NULL),
(15, 'Nicolas Lima', 'nicolas.lima@gmail.com', '$2y$10$W0v/rvEcYRNxQeoH6aCatOk6.XPIICu6nt69LfAJlANaqW39aG5lm', 'cliente', '2024-11-04 09:02:19', 'Prefiro não dizer', NULL),
(16, 'Ariana Grande', 'arianagrande@gmail.com', '$2y$10$km3cteA9ZJGNbW5ymDuiaObIMfT84fWgCTL68MfyZVIxxo.npld/W', 'cliente', '2024-11-06 16:06:05', 'Feminino', NULL),
(18, 'Ariel', 'ariel@gmail.com', '$2y$10$snOjKxVKYgOaKz7YgtRhBeH9XeSmx97/qtsJ.Bs6GlR/LQcHqnPJS', 'cliente', '2024-11-06 16:17:12', 'Prefiro não dizer', NULL),
(19, 'Maria', 'maria@gmail.com', '$2y$10$sB/9MFgrh1dnI27giyJ24.ded2P.T5IV85P.hE8Bli2XmBvkhyjTG', 'cliente', '2024-11-06 16:20:42', 'Feminino', NULL),
(20, 'Ryllary VictÃ³ria', 'ryllary@gmail.com', '$2y$10$tieOiuhtXXmUQ09qtKbhIeTXojgRxtr2OD/FCCHHskevMbraeWWI6', 'administrador', '2024-11-06 16:23:30', 'Prefiro não dizer', NULL),
(22, 'Lucas', 'luscas@gmail.com', '$2y$10$hS5i1EzUJdej5iLPKZSgDOKgmC.u9hjvQPetMmJtCTIMB.DHZcWYW', 'administrador', '2024-11-06 16:48:55', 'Prefiro não dizer', NULL),
(23, 'Natasha CaldeirÃ£o', 'natashacald@gmail.com', '$2y$10$Lb6Ha9XOtRe9EDup7R26o.6axR4L296HB21Ru.1AIUuEpJAt4hb2G', 'administrador', '2024-11-06 18:16:12', 'Feminino', NULL),
(24, 'Giovanna', 'giovanna@gmail.com', '$2y$10$8fNConWoqYpcSDxixV03lORdAxJjGChVWJNKh4rZxtw17MGl6/jC6', 'cliente', '2024-11-07 17:09:40', 'Feminino', NULL),
(25, 'Patrícia Bezerra', 'patisud22@gmail.com', '$2y$10$2lge.l6LjLkFSiKIEqKnUulJUGKlHRWY4JG4RDY4pJrhBK75GxG0G', 'cliente', '2024-11-08 19:35:43', 'Feminino', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_carrinho_compra` (`id_carrinho_compra`);

--
-- Índices de tabela `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_produto` (`id_produto`);

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
-- AUTO_INCREMENT de tabela `carrinho_compra`
--
ALTER TABLE `carrinho_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_id_carrinho_compra` FOREIGN KEY (`id_carrinho_compra`) REFERENCES `carrinho_compra` (`id`);

--
-- Restrições para tabelas `pedidos_itens`
--
ALTER TABLE `pedidos_itens`
  ADD CONSTRAINT `pedidos_itens_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pedidos_itens_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
