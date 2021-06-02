-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Fev-2021 às 00:11
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `project-a`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `teams`
--

CREATE TABLE `teams` (
  `idTeam` int(11) NOT NULL,
  `idUsers` int(230) NOT NULL,
  `TeamTag` varchar(3) NOT NULL,
  `TeamName` varchar(100) NOT NULL,
  `NumPlayers` int(100) NOT NULL,
  `SearchPlayers` int(1) NOT NULL,
  `TeamLogo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `teams`
--

INSERT INTO `teams` (`idTeam`, `idUsers`, `TeamTag`, `TeamName`, `NumPlayers`, `SearchPlayers`, `TeamLogo`) VALUES
(4, 6, 'TSS', 'test', 0, 0, 'default-team.png'),
(5, 6, 'ASD', 'asdasdasda', 0, 0, 'default-team.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `username` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `pwd` longtext NOT NULL,
  `profileImg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idUsers`, `username`, `email`, `pwd`, `profileImg`) VALUES
(1, 'teste', 'teste@hotmail.com', '$2y$10$q4lIVjQvDWBksaJwWsAi6u9qjTzvsx3.bWdzLfpM66ECA4DCaaEJu', ''),
(2, 'ya', 't@gmail.com', '$2y$10$8dROUXvSCjBfUm9ncXObOug1CJNCuwPBxtLjo385E8MUa7Pd7niXO', ''),
(3, 'ya123', 'ya123@gmail.com', '$2y$10$j.UhnEuUZoJEWyytb3hLP.56vZORUqcr7oXnQYLPaZ6IqZ70MZIuy', ''),
(4, 'test', 'test321@gmail.com', '$2y$10$4HlNAfWKXUsEMsXERO3YcOvy7CSzFX2DFItOs2cR4TZ4iSQOPkWka', ''),
(5, 'drayden', '838@gmail.com', '$2y$10$Z6xQbTSm71nr58sFghfm9.H.sF1Qi7huGmsE6ajDJ1kxCQQv6PwAO', ''),
(6, 'piss23', 'piss23@gmail.com', '$2y$10$uFIjQoLnZRfj3FkaE7KaL.PcRL8rCpgc6e9cvRPkw2i/yK1LWByJW', '60189a5799d921.51044841.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`idTeam`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `teams`
--
ALTER TABLE `teams`
  MODIFY `idTeam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
