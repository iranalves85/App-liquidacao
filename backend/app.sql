-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25-Abr-2018 às 05:05
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `badge`
--

CREATE TABLE `badge` (
  `ID` tinyint(4) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` tinyint(4) NOT NULL,
  `image` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `badge`
--

INSERT INTO `badge` (`ID`, `name`, `value`, `image`) VALUES
(1, 'Iniciante', 10, 'iniciante.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `business`
--

CREATE TABLE `business` (
  `ID` int(11) NOT NULL,
  `latitude` varchar(300) NOT NULL,
  `longitude` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` varchar(300) NOT NULL,
  `website` varchar(300) NOT NULL,
  `period` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `business`
--

INSERT INTO `business` (`ID`, `latitude`, `longitude`, `name`, `description`, `website`, `period`, `category_id`, `date_created`) VALUES
(1, '-23.4409030,-46.7495050', '', 'PC Eletrônicas', 'Peças e componentes eletrônicos para pc''s e mac''s.', 'http://pceletronicas.com.br', '2015-06-08', 1, '2015-06-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `category`
--

INSERT INTO `category` (`ID`, `name`) VALUES
(1, 'Camisetas'),
(2, 'Shorts');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comment`
--

CREATE TABLE `comment` (
  `ID` int(11) NOT NULL,
  `value` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comment`
--

INSERT INTO `comment` (`ID`, `value`, `user_id`, `product_id`, `date_created`) VALUES
(1, 'Atendentes simpaticos e prestativos. Recomendo os pendrives de bichinhos, são lindos.', 1, 1, '2015-06-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `heat_level`
--

CREATE TABLE `heat_level` (
  `ID` tinyint(4) NOT NULL,
  `level` smallint(6) NOT NULL DEFAULT '5',
  `product_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `photos`
--

CREATE TABLE `photos` (
  `ID` tinyint(4) NOT NULL,
  `value` varchar(300) NOT NULL,
  `product_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `latitude` varchar(300) NOT NULL,
  `longitude` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `period` date NOT NULL,
  `description` varchar(300) NOT NULL,
  `visibility_id` tinyint(1) NOT NULL,
  `category_id` int(11) NOT NULL,
  `business_id` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `product`
--

INSERT INTO `product` (`ID`, `latitude`, `longitude`, `name`, `price`, `period`, `description`, `visibility_id`, `category_id`, `business_id`, `user_id`, `date_created`) VALUES
(1, '-23.4409008', '0', 'Calcinhas', '5', '2014-12-03', 'Esse produto superou todas as minhas expectativas.', 1, 1, 1, 1, '2015-06-08'),
(2, '-23.0000000', '0', 'Camiseta', '30', '2015-07-22', 'Muito Legal', 2, 1, 0, 1, '2015-07-16'),
(9, '-12.0000000', '0', 'Camiseta Obrigado Manchete', '10', '2015-09-15', 'Camisa de homenagem', 1, 1, 0, 1, '2015-09-15'),
(11, '0.0000000', '0', 'Shorts Fogo Fatuo', '10', '2015-09-15', 'Shorts undergrounds', 1, 1, 0, 1, '2015-09-15'),
(12, '0.0000000', '0', 'Casa para alugar', '500', '0000-00-00', 'Uma casa para aluguel muito barata', 1, 1, 0, 1, '2015-09-15'),
(13, '0.0000000', '0', 'Camiseta Esse é o Jovem Nerd', '49', '2015-09-16', 'Camiseta lisa, feita de algodão anti-alérgico.', 1, 1, 0, 1, '2015-09-15'),
(14, '0.0000000', '0', 'Cachorro', '1', '2015-09-16', 'cachorro a venda', 1, 1, 0, 0, '2015-09-15'),
(16, '-10.0000000', '0', 'Camiseta Obrigado Manchete', '49', '2015-09-16', 'Camiseta lisa, feita de algodão anti-alérgico.', 1, 2, 0, 1, '2015-09-16'),
(17, '-5.0000000', '0', 'Camisa', '50', '2015-09-16', 'camisa lisa', 2, 1, 0, 1, '2015-09-13'),
(18, '-5.0000000', '0', 'CD do Depeche Mode', '50', '2015-09-16', 'Mídia zerada, sem nenhum risco.', 1, 1, 0, 1, '2015-09-13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `ID` smallint(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `nickname` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `address` varchar(300) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `date_created` date NOT NULL,
  `category_select` varchar(1000) NOT NULL,
  `badges` varchar(300) NOT NULL,
  `friends` varchar(1000) NOT NULL,
  `config_local_range` double NOT NULL,
  `config_notify` tinyint(1) NOT NULL,
  `config_sound` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`ID`, `name`, `nickname`, `password`, `age`, `address`, `photo`, `date_created`, `category_select`, `badges`, `friends`, `config_local_range`, `config_notify`, `config_sound`) VALUES
(1, 'Iran José Alves', 'iranalves85', 'Depeche0', 30, 'Av.: Alexios Jafet, 1811. Jd. Ipanema - São Paulo', '3x4.jpg', '2015-06-08', '1,2', '0', '0', -23.440903, 1, 1),
(2, 'Reginaldo Silva', 'regis_silva', '475927', 22, 'Rua Alexios Jafet 1280', 'img-.jpg', '2015-06-10', '1,2,3', '1,2,3', '1,2,3', -30, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `visibility`
--

CREATE TABLE `visibility` (
  `ID` int(11) NOT NULL,
  `name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `visibility`
--

INSERT INTO `visibility` (`ID`, `name`) VALUES
(1, 'private'),
(2, 'public');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `badge`
--
ALTER TABLE `badge`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `perfil` (`user_id`);

--
-- Indexes for table `heat_level`
--
ALTER TABLE `heat_level`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `visibility`
--
ALTER TABLE `visibility`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `badge`
--
ALTER TABLE `badge`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `heat_level`
--
ALTER TABLE `heat_level`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` smallint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `visibility`
--
ALTER TABLE `visibility`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
