-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql107.epizy.com
-- Tempo de geração: 16/11/2020 às 04:40
-- Versão do servidor: 5.6.48-88.0
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `epiz_26029625_db_upload_teste`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_adm`
--

CREATE TABLE `tb_adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nivel_acesso` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tb_adm`
--

INSERT INTO `tb_adm` (`id`, `nome`, `email`, `senha`, `nivel_acesso`) VALUES
(1, 'Rafael Lima', 'rafael@teste', '123', '2'),
(2, 'Conta Teste', 'email@teste', '1234', '1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_genero`
--

CREATE TABLE `tb_genero` (
  `id` int(11) NOT NULL,
  `genero` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tb_genero`
--

INSERT INTO `tb_genero` (`id`, `genero`) VALUES
(1, 'rap'),
(2, 'eletronica'),
(3, 'rock'),
(4, 'trap'),
(5, 'reggae'),
(6, 'anime'),
(7, 'meme'),
(8, 'remix');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_musicas`
--

CREATE TABLE `tb_musicas` (
  `id` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL,
  `musica` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `autor` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `arquivo` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tb_musicas`
--

INSERT INTO `tb_musicas` (`id`, `id_adm`, `id_genero`, `musica`, `autor`, `arquivo`) VALUES
(66, 1, 2, 'Esmaga', 'Leo Stronda', 'Esmaga-Leo Stronda.mp3'),
(67, 1, 2, 'Veneno', 'Leo Stronda', 'Veneno-Leo Stronda.mp3'),
(68, 2, 7, 'Sleep Away', 'Bob Acri', 'Sleep Away-Bob Acri.mp3'),
(69, 2, 4, 'Toquinho do piano', 'Não tem', 'Toquinho do piano-Não tem.mp3'),
(76, 1, 1, 'Mamba Negra', 'Chapeleiro', 'Mamba Negra-Chapeleiro.mp3'),
(71, 1, 1, 'All 4 U', 'Slider & Magnit', 'All 4 U-Slider & Magnit.mp3'),
(72, 1, 1, 'Rockstar', 'Chemical Surf', 'Rockstar-Chemical Surf.mp3'),
(73, 1, 1, 'Alors On Danse', 'Stromae', 'Alors On Danse-Stromae.mp3'),
(74, 1, 1, 'Sandstorm remix', 'Darude', 'Sandstorm remix-Darude.mp3'),
(75, 1, 1, 'Chakra', 'W&W x Vini Vici', 'Chakra-W&W x Vini Vici.mp3'),
(86, 1, 4, 'Ｃａｌｌ ｍｅ', '90sFlav', 'Ｃａｌｌ ｍｅ-90sFlav.mp3'),
(87, 1, 4, 'Eternal Youth', 'Rude', 'Eternal Youth-Rude.mp3'),
(88, 1, 4, 'oblivion  remix', 'Lily Potter', 'oblivion  remix-Lily Potter.mp3'),
(89, 1, 3, 'Pedi e Recebereis', 'Vagne Bittencourt', 'Pedi e Recebereis-Vagne Bittencourt.mp3'),
(90, 1, 3, 'Como é bom sentir', 'Padre Fábio de Melo', 'Como é bom sentir-Padre Fábio de Melo.mp3'),
(91, 1, 3, 'Hoje livre sou', 'Adoração e Vida', 'Hoje livre sou-Adoração e Vida.mp3'),
(92, 1, 3, 'Diante do rei ', 'Vida Reluz', 'Diante do rei -Vida Reluz.mp3'),
(93, 1, 3, 'Renova-Me', 'Aline Barros', 'Renova-Me-Aline Barros.mp3'),
(94, 1, 3, 'Noites Traiçoeiras', 'Anjos de Resgate', 'Noites Traiçoeiras-Anjos de Resgate.mp3'),
(95, 1, 6, 'Meu Exploit', 'Mc Hackudao', 'Meu Exploit-Mc Hackudao.mp3'),
(96, 1, 6, 'Ownanana (Dj Kali Linux)', 'Mc Hackudao', 'Ownanana (Dj Kali Linux)-Mc Hackudao.mp3'),
(97, 1, 6, 'Sites Ownados', 'Mc Hackudao ', 'Sites Ownados-Mc Hackudao .mp3'),
(98, 1, 6, 'So para os hackudos', 'Mc Hackudao ', 'So para os hackudos-Mc Hackudao .mp3'),
(99, 1, 6, 'Havijao ', 'Mc Hackudao ', 'Havijao -Mc Hackudao .mp3'),
(100, 1, 6, 'Então ataca', 'Mc Hackudao ', 'Então ataca-Mc Hackudao .mp3'),
(101, 1, 8, 'WITHOUT ME - VERSÃO BREGADEIRA', 'HALSEY ', 'WITHOUT ME - VERSÃO BREGADEIRA-HALSEY .mp3'),
(102, 1, 8, 'Summertime Sadness -VERSÃO FOR', 'Lana Del Rey', 'Summertime Sadness -VERSÃO FORRÓ-Lana Del Rey.mp3'),
(103, 1, 8, 'The Neighbourhood Forró', 'Sweater Weather', 'The Neighbourhood Forró-Sweater Weather.mp3'),
(104, 1, 8, 'ELAS GOSTAM DE GASOLINA ', 'ANDERSON ', 'ELAS GOSTAM DE GASOLINA -ANDERSON .mp3'),
(105, 1, 8, 'Letícia', 'Zé Vaqueiro', 'Letícia-Zé Vaqueiro.mp3'),
(106, 1, 8, 'Ela traiu', 'Forró do HF', 'Ela traiu-Forró do HF.mp3');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tb_adm`
--
ALTER TABLE `tb_adm`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_genero`
--
ALTER TABLE `tb_genero`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_musicas`
--
ALTER TABLE `tb_musicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_adm` (`id_adm`),
  ADD KEY `id_genero` (`id_genero`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tb_adm`
--
ALTER TABLE `tb_adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_genero`
--
ALTER TABLE `tb_genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_musicas`
--
ALTER TABLE `tb_musicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
