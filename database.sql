
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `tb_adm` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nivel_acesso` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tb_adm`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tb_adm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO 
  `tb_adm` (`id`, `nome`, `email`, `senha`, `nivel_acesso`) 
VALUES
  (1, 'Rafael Lima', 'rafael@teste', '$2y$10$7Ne4dc8tb5MXj7IO0FbDNeOeOd..fWLN7K1Xc5O//kdWl64OdhUw6', '2');



CREATE TABLE `tb_genero` (
  `id` int(11) NOT NULL,
  `genero` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tb_genero`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `tb_genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `tb_genero` (`id`, `genero`) VALUES
(1, 'eletrônica'),
(2, 'rap'),
(3, 'evangelica'),
(4, 'para estudar'),
(5, 'reggae'),
(6, 'para programar'),
(7, 'anime'),
(8, 'forró');



CREATE TABLE `tb_musicas` (
  `id` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL,
  `musica` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `autor` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `arquivo` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tb_musicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_adm` (`id_adm`),
  ADD KEY `id_genero` (`id_genero`);

ALTER TABLE `tb_musicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;
