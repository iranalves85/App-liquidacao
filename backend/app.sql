-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 18-Abr-2018 às 19:19
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
  `local_range` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` varchar(300) NOT NULL,
  `website` varchar(300) NOT NULL,
  `period` date NOT NULL,
  `photo` varchar(300) NOT NULL,
  `comment_id` varchar(300) NOT NULL,
  `category_id` int(11) NOT NULL,
  `products_id` varchar(300) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `business`
--

INSERT INTO `business` (`ID`, `local_range`, `name`, `description`, `website`, `period`, `photo`, `comment_id`, `category_id`, `products_id`, `date_created`) VALUES
(1, '-23.4409030,-46.7495050', 'PC Eletrônicas', 'Peças e componentes eletrônicos para pc''s e mac''s.', 'http://pceletronicas.com.br', '2015-06-08', '1.jpg', '1', 1, '1', '2015-06-08');

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
-- Estrutura da tabela `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `latxlong` varchar(300) NOT NULL,
  `name` varchar(300) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `period` date NOT NULL,
  `photos` varchar(300) NOT NULL,
  `description` varchar(300) NOT NULL,
  `visibility` tinyint(1) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coments_id` varchar(300) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `product`
--

INSERT INTO `product` (`ID`, `latxlong`, `name`, `price`, `period`, `photos`, `description`, `visibility`, `category_id`, `user_id`, `coments_id`, `date_created`) VALUES
(1, '-23.4409008', 'Calcinhas', '5', '2014-12-03', '1.jpg', 'Esse produto superou todas as minhas expectativas.', 1, 1, 1, '2', '2015-06-08'),
(2, '-23.0000000', 'Camiseta', '30', '2015-07-22', '2.jpg', 'Muito Legal', 2, 1, 1, '1', '2015-07-16'),
(9, '-12.0000000', 'Camiseta Obrigado Manchete', '10', '2015-09-15', '3.jpg', 'Camisa de homenagem', 1, 1, 1, '0', '2015-09-15'),
(11, '0.0000000', 'Shorts Fogo Fatuo', '10', '2015-09-15', '3.jpg', 'Shorts undergrounds', 1, 1, 1, '0', '2015-09-15'),
(12, '0.0000000', 'Casa para alugar', '500', '0000-00-00', 'casa.jpg', 'Uma casa para aluguel muito barata', 1, 1, 1, '', '2015-09-15'),
(13, '0.0000000', 'Camiseta Esse é o Jovem Nerd', '49', '2015-09-16', 'eventos.jpg', 'Camiseta lisa, feita de algodão anti-alérgico.', 1, 1, 1, '', '2015-09-15'),
(14, '0.0000000', 'Cachorro', '1', '2015-09-16', 'http://clubeparacachorros.com.br/wp-content/uploads/2015/05/mitos-e-verdades-sobre-os-cachorros.jpg', 'cachorro a venda', 1, 1, 0, '', '2015-09-15'),
(16, '-10.0000000', 'Camiseta Obrigado Manchete', '49', '2015-09-16', 'eventos.jpg', 'Camiseta lisa, feita de algodão anti-alérgico.', 1, 2, 1, '', '2015-09-16'),
(17, '-5.0000000', 'Camisa', '50', '2015-09-16', 'fotos.jpg', 'camisa lisa', 2, 1, 1, '', '2015-09-13'),
(18, '-5.0000000', 'CD do Depeche Mode', '50', '2015-09-16', 'fotos.jpg', 'Mídia zerada, sem nenhum risco.', 1, 1, 1, '', '2015-09-13');

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
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` smallint(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
