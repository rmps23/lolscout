-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql306.epizy.com
-- Tempo de geração: 31-Jan-2022 às 17:26
-- Versão do servidor: 10.3.27-MariaDB
-- versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `epiz_29539832_lolscout`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `apply`
--

CREATE TABLE `apply` (
  `idApply` int(250) NOT NULL,
  `idTeam` int(250) NOT NULL,
  `idTeamUser` int(250) NOT NULL,
  `idUser` int(250) NOT NULL,
  `idUserRole` int(250) NOT NULL,
  `accepted` int(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `errors`
--

CREATE TABLE `errors` (
  `idError` int(11) NOT NULL,
  `error` text NOT NULL,
  `message` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `errors`
--

INSERT INTO `errors` (`idError`, `error`, `message`) VALUES
(1, 'emptyfields', 'Empty fields!'),
(2, 'invalidemailusn', 'Invalid email or username!'),
(3, 'invalidemail', 'Invalid email!'),
(4, 'invalidusn', 'Invalid username!'),
(5, 'passwordcheck', 'Passwords don\'t match!'),
(6, 'usertaken', 'Username already taken!'),
(7, 'emailtaken', 'Email is already taken!'),
(8, 'wrongpwd', 'Email or password are incorrect!'),
(9, 'noemail', 'Email is not registered!'),
(10, 'invalidchar', 'Invalid characters!'),
(11, 'invalidteamname', 'Invalid team name!'),
(12, 'invalidtag', 'Invalid team TAG name!'),
(13, 'invalidtinfo', 'Invalid team information!'),
(14, 'invalidlink', 'Invalid link!'),
(15, 'filebig', 'File is too big!'),
(16, 'invfile', 'Invalid file!'),
(17, 'nocode', 'You need to insert the code inside LoL client!'),
(18, 'codematch', 'Code doesn\'t match with client verification code!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `favs`
--

CREATE TABLE `favs` (
  `idFav` int(11) NOT NULL,
  `idUser` int(250) NOT NULL,
  `idFavUser` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `favs`
--

INSERT INTO `favs` (`idFav`, `idUser`, `idFavUser`) VALUES
(1, 5, 4),
(2, 8, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `nation`
--

CREATE TABLE `nation` (
  `idNation` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `nation`
--

INSERT INTO `nation` (`idNation`, `name`, `image`) VALUES
(1, 'Albania', 'albania.png'),
(2, 'Andorra', 'andorra.png'),
(3, 'Austria', 'austria.png'),
(4, 'Belarus', 'belarus.png'),
(5, 'Belgium', 'belgium.png'),
(6, 'Bosnia', 'bosnia.png'),
(7, 'Bulgaria', 'bulgaria.png'),
(8, 'Croatia', 'croatia.png'),
(9, 'Cyprus', 'cyprus.png'),
(10, 'Czech Republic', 'czechia.png'),
(11, 'Denmark', 'denmark.png'),
(12, 'Estonia', 'estonia.png'),
(13, 'Faroe Islands', 'faroe-islands.png'),
(14, 'Finland', 'france.png'),
(15, 'Germany', 'germany.png'),
(16, 'Gibraltar', 'gibraltar.png'),
(17, 'Greece', 'greece.png'),
(18, 'Hungary', 'hungary.png'),
(19, 'Iceland', 'iceland.png'),
(20, 'Ireland', 'ireland.png'),
(21, 'Italy', 'italy.png'),
(22, 'Kosovo', 'kosovo.png'),
(23, 'Latvia', 'latvia.png'),
(24, 'Liechtenstein', 'liechtenstein.png'),
(25, 'Lithuania', 'lithuania.png'),
(26, 'Luxembourg', 'luxembourg.png'),
(27, 'malta', 'malta.png'),
(28, 'Moldova', 'moldova.png'),
(29, 'Monaco', 'monaco.png'),
(30, 'Montenegro', 'montenegro.png'),
(31, 'netherlands', 'netherlands.png'),
(32, 'Norway', 'norway.png'),
(33, 'Poland', 'poland.png'),
(34, 'Portugal', 'portugal.png'),
(35, 'Romania', 'romania.png'),
(36, 'Russia', 'russia.png'),
(37, 'San Marino', 'san-marino.png'),
(38, 'Serbia', 'serbia.png'),
(39, 'Slovakia', 'slovakia.png'),
(40, 'Slovenia', 'slovenia.png'),
(41, 'Spain', 'spain.png'),
(42, 'Sweden', 'sweden.png'),
(43, 'Switzerland', 'switzerland.png'),
(44, 'Turkey', 'turkey.png'),
(45, 'Ukraine', 'ukraine.png'),
(46, 'United Kingdom', 'uk.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pwdreset`
--

CREATE TABLE `pwdreset` (
  `idpwdreset` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pwdreset`
--

INSERT INTO `pwdreset` (`idpwdreset`, `email`, `code`, `timestamp`) VALUES
(6, 'rubensousa96@hotmail.com', '67405087', '2022-01-14 12:18:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ranks`
--

CREATE TABLE `ranks` (
  `idRank` int(11) NOT NULL,
  `rankname` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ranks`
--

INSERT INTO `ranks` (`idRank`, `rankname`, `image`) VALUES
(1, 'Challenger', 'CHALLENGER.png'),
(2, 'Grandmaster', 'GRANDMASTER.png'),
(3, 'Master', 'MASTER.png'),
(4, 'Diamond I', 'DIAMOND.png'),
(5, 'Diamond II', 'DIAMOND.png'),
(6, 'Diamond III', 'DIAMOND.png'),
(7, 'Diamond IV', 'DIAMOND.png'),
(8, 'Platinum I', 'PLATINUM.png'),
(9, 'Platinum II', 'PLATINUM.png'),
(10, 'Platinum III', 'PLATINUM.png'),
(11, 'Platinum IV', 'PLATINUM.png'),
(12, 'Gold I', 'GOLD.png'),
(13, 'Gold II', 'GOLD.png'),
(14, 'Gold III', 'GOLD.png'),
(15, 'Gold IV', 'GOLD.png'),
(16, 'Silver I', 'SILVER.png'),
(17, 'Silver II', 'SILVER.png'),
(18, 'Silver III', 'SILVER.png'),
(19, 'Silver IV', 'SILVER.png'),
(20, 'Bronze I', 'BRONZE.png'),
(21, 'Bronze II', 'BRONZE.png'),
(22, 'Bronze III', 'BRONZE.png'),
(23, 'Bronze IV', 'IRON.png'),
(24, 'Iron I', 'IRON.png'),
(25, 'Iron II', 'IRON.png'),
(26, 'Iron III', 'IRON.png'),
(27, 'Iron III', 'IRON.png'),
(28, 'Iron IV', 'IRON.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rankuser`
--

CREATE TABLE `rankuser` (
  `idRankuser` int(250) NOT NULL,
  `idUser` int(250) NOT NULL,
  `idRank` varchar(250) NOT NULL DEFAULT '0',
  `tier` varchar(250) NOT NULL DEFAULT '0',
  `ranks` varchar(250) NOT NULL DEFAULT '0',
  `sumname` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `LP` int(3) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `rankuser`
--

INSERT INTO `rankuser` (`idRankuser`, `idUser`, `idRank`, `tier`, `ranks`, `sumname`, `LP`) VALUES
(2, 2, '0', '0', '0', 'SEMIDE', 0),
(3, 3, '0', '0', '0', '0', 0),
(4, 4, '0', '0', '0', 'DEDEZINHO', 0),
(7, 7, '0', '0', '0', '0', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `riot`
--

CREATE TABLE `riot` (
  `idRiot` int(11) NOT NULL,
  `idUser` int(250) NOT NULL,
  `idAcc` varchar(250) NOT NULL,
  `opgg` varchar(250) NOT NULL,
  `profileImg` varchar(250) NOT NULL,
  `lastupdate` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `riot`
--

INSERT INTO `riot` (`idRiot`, `idUser`, `idAcc`, `opgg`, `profileImg`, `lastupdate`) VALUES
(1, 34, '7SwWseNUGYHE_nTVib8TStQSTkZxGd64MkXwNJ0ib2TGW8o', 'RÃ«zso', '3456', ''),
(2, 35, '7SwWseNUGYHE_nTVib8TStQSTkZxGd64MkXwNJ0ib2TGW8o', 'RÃ«zso', '3456', '1643613586');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `idRole` int(11) NOT NULL,
  `rolename` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`idRole`, `rolename`, `image`) VALUES
(0, 'Undefined', 'default.png'),
(1, 'Top Laner', 'top.png'),
(2, 'Jungler', 'jungler.png'),
(3, 'Mid Laner', 'mid.png'),
(4, 'Bot Laner', 'bot.png'),
(5, 'Support', 'support.png'),
(6, 'Coach', 'coach.png'),
(7, 'Analyst', 'analyst.png'),
(8, 'Manager', 'manager.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `socials`
--

CREATE TABLE `socials` (
  `idsocials` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  `facebook` varchar(250) NOT NULL DEFAULT '0',
  `twitter` varchar(250) NOT NULL DEFAULT '0',
  `instagram` varchar(250) NOT NULL DEFAULT '0',
  `twitch` varchar(250) NOT NULL DEFAULT '0',
  `youtube` varchar(250) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `socials`
--

INSERT INTO `socials` (`idsocials`, `idUsers`, `facebook`, `twitter`, `instagram`, `twitch`, `youtube`) VALUES
(22, 24, '0', '0', '0', '0', '0'),
(2, 2, '0', '0', '0', '0', '0'),
(3, 3, '0', '0', '0', '0', '0'),
(4, 4, '0', '0', '0', '0', '0'),
(7, 7, '0', '0', '0', '0', '0'),
(35, 35, '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teams`
--

CREATE TABLE `teams` (
  `idTeam` int(11) NOT NULL,
  `idUsers` int(230) NOT NULL,
  `TeamTag` varchar(4) NOT NULL,
  `TeamName` varchar(100) NOT NULL,
  `SearchRank` int(10) NOT NULL DEFAULT 30,
  `SearchPlayers` int(1) NOT NULL,
  `TeamLogo` varchar(200) NOT NULL,
  `TeamInfo` varchar(250) NOT NULL DEFAULT '0',
  `nation` varchar(250) NOT NULL DEFAULT '0',
  `idTop` int(11) NOT NULL DEFAULT 0,
  `idJungler` int(11) NOT NULL DEFAULT 0,
  `idMid` int(11) NOT NULL DEFAULT 0,
  `idBot` int(11) NOT NULL DEFAULT 0,
  `idSupport` int(11) NOT NULL DEFAULT 0,
  `idCoach` int(11) NOT NULL DEFAULT 0,
  `idAnalyst` int(11) NOT NULL DEFAULT 0,
  `idManager` int(11) NOT NULL DEFAULT 0,
  `inviteCode` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `teams`
--

INSERT INTO `teams` (`idTeam`, `idUsers`, `TeamTag`, `TeamName`, `SearchRank`, `SearchPlayers`, `TeamLogo`, `TeamInfo`, `nation`, `idTop`, `idJungler`, `idMid`, `idBot`, `idSupport`, `idCoach`, `idAnalyst`, `idManager`, `inviteCode`) VALUES
(1, 4, 'KLLC', 'KmickLovers League Club', 3, 1, '61cb7935e1fd27.07751027.jpg', 'KmickLoversLT Was created in Portugal in BEJA City With the purpose of be the best team in Europe! <br> Looking for: <br> ADC (2) <br> SUPP (Helena Santos) <br> MID (2) <br> JUNGLER (1) <br> TOP (O BRUNO CHEGA) <br>\r\nPSYCOLOGIST (HIRING ALL)', '34', 0, 0, 0, 0, 0, 4, 0, 0, '1661cb78f1df083');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tsocial`
--

CREATE TABLE `tsocial` (
  `idtSocial` int(11) NOT NULL,
  `idTeam` int(11) NOT NULL,
  `facebook` varchar(240) NOT NULL DEFAULT '0',
  `twitter` varchar(240) NOT NULL DEFAULT '0',
  `instagram` varchar(240) NOT NULL DEFAULT '0',
  `twitch` varchar(240) NOT NULL DEFAULT '0',
  `youtube` varchar(250) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tsocial`
--

INSERT INTO `tsocial` (`idtSocial`, `idTeam`, `facebook`, `twitter`, `instagram`, `twitch`, `youtube`) VALUES
(1, 1, '0', 'https://twitter.com/kmickmon', '0', '0', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `email` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `pwd` longtext COLLATE utf8_unicode_ci NOT NULL,
  `idRole` int(1) NOT NULL DEFAULT 0,
  `idNation` int(250) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`idUsers`, `email`, `pwd`, `idRole`, `idNation`) VALUES
(7, 'tonymarques422004@gmail.com', '$2y$10$zX02842os9chn8LKy33BVOC3VXSjP1k4/Vw/HwinT4QvL3M2jy3D6', 0, 0),
(2, 'semideft@gmail.com', '$2y$10$JB8LFpEaLARbSOt4Vym1heLa0s4u0Z59sWmkGdkQdef25jP5NO.1C', 2, 0),
(3, 'towhatpt22@gmail.com', '$2y$10$9YYJT0i/bdyCM54xzKVWfuf71AbFmCSwvBXVGVjcSoZzR00BeczqC', 0, 0),
(4, 'andre.21carvalho@gmail.com', '$2y$10$nHCfB6dOuT05Oi.dKTZlm.SLD.XwYM.RsmbUkPfYn.BDP2gnJoRdq', 6, 34),
(35, 'rubensousa96@hotmail.com', '$2y$10$O6BlC8RNQn9xRU1ArOB69Oh7lXfSInG2XBIuPZMb5On0t5r0Rlvsq', 4, 34);

-- --------------------------------------------------------

--
-- Estrutura da tabela `userteam`
--

CREATE TABLE `userteam` (
  `iduserteam` int(11) NOT NULL,
  `idUser` int(250) NOT NULL,
  `idTeam` int(250) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `userteam`
--

INSERT INTO `userteam` (`iduserteam`, `idUser`, `idTeam`) VALUES
(1, 34, 0),
(2, 35, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`idApply`);

--
-- Índices para tabela `errors`
--
ALTER TABLE `errors`
  ADD PRIMARY KEY (`idError`);

--
-- Índices para tabela `favs`
--
ALTER TABLE `favs`
  ADD PRIMARY KEY (`idFav`);

--
-- Índices para tabela `nation`
--
ALTER TABLE `nation`
  ADD PRIMARY KEY (`idNation`);

--
-- Índices para tabela `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`idpwdreset`);

--
-- Índices para tabela `ranks`
--
ALTER TABLE `ranks`
  ADD PRIMARY KEY (`idRank`);

--
-- Índices para tabela `rankuser`
--
ALTER TABLE `rankuser`
  ADD PRIMARY KEY (`idRankuser`);

--
-- Índices para tabela `riot`
--
ALTER TABLE `riot`
  ADD PRIMARY KEY (`idRiot`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Índices para tabela `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`idsocials`);

--
-- Índices para tabela `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`idTeam`);

--
-- Índices para tabela `tsocial`
--
ALTER TABLE `tsocial`
  ADD PRIMARY KEY (`idtSocial`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- Índices para tabela `userteam`
--
ALTER TABLE `userteam`
  ADD PRIMARY KEY (`iduserteam`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `apply`
--
ALTER TABLE `apply`
  MODIFY `idApply` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `errors`
--
ALTER TABLE `errors`
  MODIFY `idError` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `favs`
--
ALTER TABLE `favs`
  MODIFY `idFav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `nation`
--
ALTER TABLE `nation`
  MODIFY `idNation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `idpwdreset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ranks`
--
ALTER TABLE `ranks`
  MODIFY `idRank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `rankuser`
--
ALTER TABLE `rankuser`
  MODIFY `idRankuser` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `riot`
--
ALTER TABLE `riot`
  MODIFY `idRiot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `socials`
--
ALTER TABLE `socials`
  MODIFY `idsocials` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `teams`
--
ALTER TABLE `teams`
  MODIFY `idTeam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tsocial`
--
ALTER TABLE `tsocial`
  MODIFY `idtSocial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `userteam`
--
ALTER TABLE `userteam`
  MODIFY `iduserteam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
