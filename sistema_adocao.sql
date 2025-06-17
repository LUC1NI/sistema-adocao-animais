-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 17-Jun-2025 às 23:18
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.12

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
-- Estrutura da tabela `adocoes`
--

CREATE TABLE `adocoes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_animal` int(11) DEFAULT NULL,
  `data_pedido` date DEFAULT NULL,
  `status` enum('pendente','aprovado','recusado') DEFAULT 'pendente',
  `respostas_formulario` text DEFAULT NULL,
  `mensagem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `adocoes`
--

INSERT INTO `adocoes` (`id`, `id_usuario`, `id_animal`, `data_pedido`, `status`, `respostas_formulario`, `mensagem`) VALUES
(18, 7, 3, '2025-06-17', 'pendente', '{\"Por que deseja adotar este animal?\":\"PQ SIM\",\"Voc\\u00ea tem outros animais de estima\\u00e7\\u00e3o?\":\"SIM\",\"Voc\\u00ea tem experi\\u00eancia em cuidar de animais?\":\"SIM\"}', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `animais`
--

CREATE TABLE `animais` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `especie` varchar(50) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `animais`
--

INSERT INTO `animais` (`id`, `nome`, `especie`, `idade`, `descricao`, `foto`) VALUES
(2, 'lulu', 'Lulu da Pomerânia', 2, 'Lulu-da-pomerânia, também conhecida como spitz-alemão-anão, é a menor variedade da raça spitz alemão. É nativa da Pomerânia, região que engloba parte da Alemanha e Polônia na Europa Central', '68501f1e61dc1.jpg'),
(3, 'Felix', 'Persa', 2, 'Persa é uma raça de gato doméstico originária do Irã, antiga Pérsia. É conhecido por sua aparência chamativa, de muita pelagem e focinho achatado.', '6850432ed9cd3.jpg'),
(4, 'Bob', 'Golden retriever', 2, 'O golden retriever é uma raça canina do tipo retriever originária da Grã-bretanha, e foi desenvolvida para a caça de aves aquáticas.', '6850cf62364f1.jpeg'),
(5, 'spyke', 'Buldogue francês', 3, 'O buldogue francês é uma raça de cão de companhia, do tipo buldogue, de pequeno porte, oriunda da França.', '6851d97e4e133.jpeg'),
(6, 'jerry', 'Ragdoll', 1, 'Ragdoll, comumente chamados Filhos de Josephine ou Filhos da Ann, é uma raça de gato desenvolvida nos Estados Unidos, mas especificamente no estado da Califórnia, durante a década de 1960. Com seu porte gigante, temperamento dependente, dócil e uma pelagem cheia, é um animal de características marcantes.', '6851d9eb51f98.jpeg'),
(7, 'big', 'Maine Coon', 4, 'Maine Coon é uma raça de gato originária do nordeste dos Estados Unidos. É considerada a raça de pelo mais antiga, além de ser a maior de todas as raças de gato do mundo. Foi reconhecida como raça oficial no estado norte-americano do Maine, onde era famoso pela sua capacidade de caçar ratos e tolerar climas rigorosos.', '6851dac43f5c0.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo_usuario` enum('adotante','admin') DEFAULT 'adotante'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `data_nascimento`, `senha`, `tipo_usuario`) VALUES
(4, 'admin', 'admin@gmail.com', NULL, NULL, '$2y$10$8pyCQRKDcxteopled64DTOGGKa9DKo8Sc2ymRqkJs7xZIokvI1OQK', 'admin'),
(7, 'João Vitor', 'joaovitor@gmail.com', '130.138.529-84', '2005-07-21', '$2y$10$hbr5J/gnjLYj3vYLHQmMaebLyRxRo66RbVv9x8HDtPXZDOXbzfe/i', 'adotante');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adocoes`
--
ALTER TABLE `adocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_animal` (`id_animal`);

--
-- Índices para tabela `animais`
--
ALTER TABLE `animais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `adocoes`
--
ALTER TABLE `adocoes`
  ADD CONSTRAINT `adocoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `adocoes_ibfk_2` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
