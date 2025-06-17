-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/06/2025 às 04:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_adocao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `adocoes`
--

CREATE TABLE `adocoes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_animal` int(11) DEFAULT NULL,
  `data_pedido` date DEFAULT NULL,
  `status` enum('pendente','aprovado','recusado') DEFAULT 'pendente',
  `respostas_formulario` text DEFAULT NULL,
  `mensagem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `adocoes`
--

INSERT INTO `adocoes` (`id`, `id_usuario`, `id_animal`, `data_pedido`, `status`, `respostas_formulario`, `mensagem`) VALUES
(18, 7, 3, '2025-06-17', 'pendente', '{\"Por que deseja adotar este animal?\":\"PQ SIM\",\"Voc\\u00ea tem outros animais de estima\\u00e7\\u00e3o?\":\"SIM\",\"Voc\\u00ea tem experi\\u00eancia em cuidar de animais?\":\"SIM\"}', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `animais`
--

CREATE TABLE `animais` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `especie` varchar(50) DEFAULT NULL,
  `raca` varchar(100) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `animais`
--

INSERT INTO `animais` (`id`, `nome`, `especie`, `raca`, `idade`, `descricao`, `foto`) VALUES
(2, 'lulu', 'Lulu da Pomerânia', NULL, 2, 'Lulu-da-pomerânia, também conhecida como spitz-alemão-anão, é a menor variedade da raça spitz alemão. É nativa da Pomerânia, região que engloba parte da Alemanha e Polônia na Europa Central', '68501f1e61dc1.jpg'),
(3, 'Felix', 'Persa', NULL, 2, 'Persa é uma raça de gato doméstico originária do Irã, antiga Pérsia. É conhecido por sua aparência chamativa, de muita pelagem e focinho achatado.', '6850432ed9cd3.jpg'),
(4, 'Bob', 'Golden retriever', NULL, 2, 'O golden retriever é uma raça canina do tipo retriever originária da Grã-bretanha, e foi desenvolvida para a caça de aves aquáticas.', '6850cf62364f1.jpeg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo_usuario` enum('adotante','admin') DEFAULT 'adotante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `data_nascimento`, `senha`, `tipo_usuario`) VALUES
(4, 'admin', 'admin@gmail.com', NULL, NULL, '$2y$10$8pyCQRKDcxteopled64DTOGGKa9DKo8Sc2ymRqkJs7xZIokvI1OQK', 'admin'),
(7, 'João Vitor', 'joaovitor@gmail.com', '130.138.529-84', '2005-07-21', '$2y$10$hbr5J/gnjLYj3vYLHQmMaebLyRxRo66RbVv9x8HDtPXZDOXbzfe/i', 'adotante');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `adocoes`
--
ALTER TABLE `adocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_animal` (`id_animal`);

--
-- Índices de tabela `animais`
--
ALTER TABLE `animais`
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
-- AUTO_INCREMENT de tabela `adocoes`
--
ALTER TABLE `adocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `animais`
--
ALTER TABLE `animais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `adocoes`
--
ALTER TABLE `adocoes`
  ADD CONSTRAINT `adocoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `adocoes_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
