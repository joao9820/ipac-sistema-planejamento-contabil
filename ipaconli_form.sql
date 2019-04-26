-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 01-Mar-2019 às 18:31
-- Versão do servidor: 10.2.21-MariaDB
-- versão do PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipaconli_form`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cads_usuarios`
--

CREATE TABLE `adms_cads_usuarios` (
  `id` int(11) NOT NULL,
  `env_email_conf` int(11) NOT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cads_usuarios`
--

INSERT INTO `adms_cads_usuarios` (`id`, `env_email_conf`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 2, 5, 3, '2018-06-23 00:00:00', '2018-06-29 22:24:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cors`
--

CREATE TABLE `adms_cors` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cors`
--

INSERT INTO `adms_cors` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Azul', 'primary', '2018-05-23 00:00:00', '2018-06-29 20:06:34'),
(2, 'Cinza', 'secondary', '2018-05-23 00:00:00', NULL),
(3, 'Verde', 'success', '2018-05-23 00:00:00', NULL),
(4, 'Vermelho', 'danger', '2018-05-23 00:00:00', NULL),
(5, 'Laranjado', 'warning', '2018-05-23 00:00:00', NULL),
(6, 'Azul claro', 'info', '2018-05-23 00:00:00', NULL),
(7, 'Claro', 'light', '2018-05-23 00:00:00', NULL),
(8, 'Cinza escuro', 'dark', '2018-05-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_grps_pgs`
--

CREATE TABLE `adms_grps_pgs` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_grps_pgs`
--

INSERT INTO `adms_grps_pgs` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Listar', 1, '2018-05-23 00:00:00', '2018-06-29 21:36:41'),
(2, 'Cadastrar', 2, '2018-05-23 00:00:00', '2018-06-29 22:30:06'),
(3, 'Editar', 3, '2018-05-23 00:00:00', '2018-06-29 22:30:06'),
(4, 'Apagar', 4, '2018-05-23 00:00:00', NULL),
(5, 'Visualizar', 5, '2018-05-23 00:00:00', NULL),
(6, 'Outros', 6, '2018-05-23 00:00:00', NULL),
(7, 'Acesso', 7, '2018-05-23 00:00:00', '2018-06-29 21:35:16'),
(8, 'Alterar Ordem', 8, '2018-06-23 00:00:00', '2018-06-29 21:35:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_menus`
--

CREATE TABLE `adms_menus` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_menus`
--

INSERT INTO `adms_menus` (`id`, `nome`, `icone`, `ordem`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', 1, 1, '2018-05-23 00:00:00', '2018-06-28 17:30:44'),
(2, 'UsuÃ¡rio', 'fas fa-user', 2, 1, '2018-05-23 00:00:00', '2018-06-28 17:30:46'),
(3, 'Sair', 'fas fa-sign-out-alt', 5, 1, '2018-06-23 00:00:00', '2019-02-17 22:57:07'),
(4, 'ConfiguraÃ§Ã£o', 'fas fa-cogs', 3, 1, '2018-06-23 00:00:00', '2018-06-28 17:30:47'),
(5, 'Site', 'fas fa-laptop', 4, 1, '2019-02-17 22:56:20', '2019-02-17 22:57:07'),
(6, 'Blog', 'fas fa-newspaper', 6, 1, '2019-02-26 16:17:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_nivacs_pgs`
--

CREATE TABLE `adms_nivacs_pgs` (
  `id` int(11) NOT NULL,
  `permissao` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `dropdown` int(11) NOT NULL DEFAULT 2,
  `lib_menu` int(11) NOT NULL DEFAULT 2,
  `adms_menu_id` int(11) NOT NULL DEFAULT 4,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_pagina_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_nivacs_pgs`
--

INSERT INTO `adms_nivacs_pgs` (`id`, `permissao`, `ordem`, `dropdown`, `lib_menu`, `adms_menu_id`, `adms_niveis_acesso_id`, `adms_pagina_id`, `created`, `modified`) VALUES
(1, 1, 1, 2, 1, 1, 1, 1, '2018-05-23 00:00:00', '2019-02-26 17:55:57'),
(2, 1, 2, 1, 1, 2, 1, 2, '2018-05-23 00:00:00', '2018-06-25 12:52:11'),
(3, 1, 4, 2, 1, 3, 1, 4, '2018-05-23 00:00:00', '2018-06-25 11:19:21'),
(4, 1, 5, 1, 2, 4, 1, 5, '2018-05-23 00:00:00', '2018-06-25 11:19:19'),
(5, 1, 6, 1, 2, 2, 1, 7, '2018-06-23 00:00:00', '2018-06-25 11:19:17'),
(6, 1, 7, 2, 2, 2, 1, 9, '2018-06-23 00:00:00', '2018-06-25 11:19:16'),
(7, 1, 8, 2, 2, 2, 1, 10, '2018-06-23 00:00:00', '2018-06-25 11:19:15'),
(8, 1, 9, 2, 2, 2, 1, 11, '2018-06-23 00:00:00', '2018-06-25 11:19:13'),
(9, 1, 10, 2, 2, 2, 1, 12, '2018-06-23 00:00:00', '2018-06-25 11:19:12'),
(10, 1, 11, 2, 2, 2, 1, 13, '2018-06-23 00:00:00', '2018-06-28 16:22:00'),
(11, 1, 12, 2, 2, 2, 1, 14, '2018-06-23 00:00:00', '2018-06-25 11:50:15'),
(12, 1, 13, 2, 2, 2, 1, 15, '2018-06-23 00:00:00', '2018-06-25 11:50:15'),
(13, 1, 15, 2, 2, 2, 1, 16, '2018-06-23 00:00:00', '2018-06-25 11:57:33'),
(576, 2, 74, 2, 2, 4, 6, 74, '2019-02-26 16:02:56', NULL),
(575, 2, 73, 2, 2, 4, 6, 73, '2019-02-26 16:02:56', NULL),
(574, 2, 72, 2, 2, 4, 6, 72, '2019-02-26 16:02:56', NULL),
(573, 2, 71, 2, 2, 4, 6, 71, '2019-02-26 16:02:56', NULL),
(572, 2, 70, 2, 2, 4, 6, 70, '2019-02-26 16:02:56', NULL),
(571, 2, 69, 2, 2, 4, 6, 69, '2019-02-26 16:02:56', NULL),
(570, 2, 68, 2, 2, 4, 6, 68, '2019-02-26 16:02:56', NULL),
(569, 2, 67, 2, 2, 4, 6, 67, '2019-02-26 16:02:56', NULL),
(568, 2, 66, 2, 2, 4, 6, 66, '2019-02-26 16:02:56', NULL),
(567, 2, 65, 2, 2, 4, 6, 65, '2019-02-26 16:02:56', NULL),
(566, 2, 64, 2, 2, 4, 6, 64, '2019-02-26 16:02:56', NULL),
(25, 1, 3, 1, 1, 2, 1, 17, '2018-06-23 00:00:00', '2018-06-28 16:17:58'),
(26, 1, 14, 2, 2, 2, 1, 18, '2018-06-23 00:00:00', '2018-06-25 11:57:33'),
(27, 1, 16, 2, 2, 2, 1, 19, '2018-06-23 00:00:00', NULL),
(28, 1, 17, 2, 2, 2, 1, 20, '2018-06-23 00:00:00', NULL),
(29, 1, 18, 2, 2, 2, 1, 21, '2018-06-23 00:00:00', NULL),
(30, 1, 19, 2, 2, 2, 1, 22, '2018-06-23 00:00:00', NULL),
(565, 2, 63, 2, 2, 4, 6, 63, '2019-02-26 16:02:56', NULL),
(564, 2, 62, 2, 2, 4, 6, 62, '2019-02-26 16:02:56', NULL),
(563, 2, 61, 2, 2, 4, 6, 61, '2019-02-26 16:02:56', NULL),
(562, 2, 60, 2, 2, 4, 6, 60, '2019-02-26 16:02:56', NULL),
(561, 2, 59, 2, 2, 4, 6, 59, '2019-02-26 16:02:56', NULL),
(560, 2, 58, 2, 2, 4, 6, 58, '2019-02-26 16:02:56', NULL),
(37, 1, 20, 1, 1, 4, 1, 23, '2018-06-23 00:00:00', NULL),
(38, 1, 21, 2, 2, 4, 1, 24, '2018-06-23 00:00:00', NULL),
(39, 1, 22, 2, 2, 4, 1, 25, '2018-06-22 14:25:21', NULL),
(559, 2, 57, 2, 2, 4, 6, 57, '2019-02-26 16:02:56', NULL),
(44, 1, 23, 2, 2, 4, 1, 26, '2018-06-22 14:43:47', NULL),
(558, 2, 56, 2, 2, 4, 6, 56, '2019-02-26 16:02:56', NULL),
(49, 1, 24, 2, 2, 4, 1, 27, '2018-06-22 19:17:43', NULL),
(557, 2, 55, 2, 2, 4, 6, 55, '2019-02-26 16:02:56', NULL),
(54, 1, 25, 2, 2, 4, 1, 28, '2018-06-24 11:59:53', NULL),
(556, 2, 54, 2, 2, 4, 6, 54, '2019-02-26 16:02:56', NULL),
(59, 1, 26, 2, 2, 4, 1, 29, '2018-06-24 12:52:42', NULL),
(555, 2, 53, 2, 2, 4, 6, 53, '2019-02-26 16:02:56', NULL),
(67, 1, 27, 2, 2, 4, 1, 30, '2018-06-25 09:48:29', NULL),
(554, 2, 52, 2, 2, 4, 6, 52, '2019-02-26 16:02:56', NULL),
(72, 1, 28, 2, 2, 4, 1, 31, '2018-06-25 10:24:39', NULL),
(553, 2, 51, 2, 2, 4, 6, 51, '2019-02-26 16:02:56', NULL),
(77, 1, 29, 2, 2, 4, 1, 32, '2018-06-25 10:56:36', NULL),
(552, 2, 50, 2, 2, 4, 6, 50, '2019-02-26 16:02:56', NULL),
(82, 1, 30, 2, 2, 4, 1, 33, '2018-06-26 12:23:37', NULL),
(551, 2, 49, 2, 2, 4, 6, 49, '2019-02-26 16:02:56', NULL),
(87, 1, 31, 2, 2, 4, 1, 3, '2018-06-26 13:10:37', NULL),
(88, 1, 32, 2, 2, 4, 1, 6, '2018-06-26 13:10:37', NULL),
(89, 1, 33, 2, 2, 4, 1, 8, '2018-06-26 13:10:37', NULL),
(550, 2, 48, 2, 2, 4, 6, 48, '2019-02-26 16:02:56', NULL),
(549, 2, 47, 2, 2, 4, 6, 47, '2019-02-26 16:02:56', NULL),
(548, 2, 46, 2, 2, 4, 6, 46, '2019-02-26 16:02:56', NULL),
(547, 2, 45, 2, 2, 4, 6, 45, '2019-02-26 16:02:56', NULL),
(546, 2, 44, 2, 2, 4, 6, 44, '2019-02-26 16:02:56', NULL),
(545, 2, 43, 2, 2, 4, 6, 43, '2019-02-26 16:02:56', NULL),
(544, 2, 42, 2, 2, 4, 6, 42, '2019-02-26 16:02:56', NULL),
(166, 1, 34, 2, 2, 4, 1, 34, '2018-06-28 16:11:35', NULL),
(543, 2, 41, 2, 2, 4, 6, 41, '2019-02-26 16:02:56', NULL),
(171, 1, 35, 1, 1, 4, 1, 35, '2018-06-28 16:40:32', '2018-06-28 17:21:17'),
(172, 1, 36, 2, 2, 4, 1, 36, '2018-06-28 16:40:32', NULL),
(173, 1, 37, 2, 2, 4, 1, 37, '2018-06-28 16:40:32', NULL),
(174, 1, 38, 2, 2, 4, 1, 38, '2018-06-28 16:40:32', NULL),
(175, 1, 39, 2, 2, 4, 1, 39, '2018-06-28 16:40:32', NULL),
(176, 1, 40, 2, 2, 4, 1, 40, '2018-06-28 16:40:32', NULL),
(542, 2, 40, 2, 2, 4, 6, 40, '2019-02-26 16:02:56', NULL),
(541, 2, 39, 2, 2, 4, 6, 39, '2019-02-26 16:02:56', NULL),
(540, 2, 38, 2, 2, 4, 6, 38, '2019-02-26 16:02:56', NULL),
(539, 2, 37, 2, 2, 4, 6, 37, '2019-02-26 16:02:56', NULL),
(538, 2, 36, 2, 2, 4, 6, 36, '2019-02-26 16:02:56', NULL),
(537, 2, 35, 2, 2, 4, 6, 35, '2019-02-26 16:02:56', NULL),
(201, 1, 41, 1, 1, 4, 1, 41, '2018-06-29 18:33:56', '2018-06-29 18:34:12'),
(536, 2, 34, 2, 2, 4, 6, 34, '2019-02-26 16:02:56', NULL),
(206, 1, 42, 1, 1, 4, 1, 42, '2018-06-29 18:56:15', '2018-06-29 18:56:30'),
(535, 2, 33, 2, 2, 4, 6, 33, '2019-02-26 16:02:56', NULL),
(211, 1, 43, 1, 1, 4, 1, 43, '2018-06-29 19:32:21', '2018-06-29 19:32:33'),
(534, 2, 32, 2, 2, 4, 6, 32, '2019-02-26 16:02:56', NULL),
(216, 1, 44, 2, 2, 4, 1, 44, '2018-06-29 19:50:19', NULL),
(533, 2, 31, 2, 2, 4, 6, 31, '2019-02-26 16:02:56', NULL),
(221, 1, 45, 2, 2, 4, 1, 45, '2018-06-29 19:59:53', NULL),
(532, 2, 30, 2, 2, 4, 6, 30, '2019-02-26 16:02:56', NULL),
(226, 1, 46, 2, 2, 4, 1, 46, '2018-06-29 20:09:35', NULL),
(531, 2, 29, 2, 2, 4, 6, 29, '2019-02-26 16:02:56', NULL),
(231, 1, 47, 2, 2, 4, 1, 47, '2018-06-29 20:17:36', NULL),
(530, 2, 28, 2, 2, 4, 6, 28, '2019-02-26 16:02:56', NULL),
(236, 1, 48, 1, 1, 4, 1, 48, '2018-06-29 20:29:31', '2018-06-29 20:29:45'),
(529, 2, 27, 2, 2, 4, 6, 27, '2019-02-26 16:02:56', NULL),
(241, 1, 49, 2, 2, 4, 1, 49, '2018-06-29 20:40:11', NULL),
(528, 2, 26, 2, 2, 4, 6, 26, '2019-02-26 16:02:56', NULL),
(246, 1, 50, 2, 2, 4, 1, 50, '2018-06-29 20:58:30', NULL),
(527, 2, 25, 2, 2, 4, 6, 25, '2019-02-26 16:02:56', NULL),
(251, 1, 51, 2, 2, 4, 1, 51, '2018-06-29 21:08:41', NULL),
(526, 2, 24, 2, 2, 4, 6, 24, '2019-02-26 16:02:56', NULL),
(256, 1, 52, 2, 2, 4, 1, 52, '2018-06-29 21:19:34', NULL),
(525, 2, 23, 2, 2, 4, 6, 23, '2019-02-26 16:02:56', NULL),
(261, 1, 53, 2, 2, 4, 1, 53, '2018-06-29 21:31:23', NULL),
(524, 2, 22, 2, 2, 4, 6, 22, '2019-02-26 16:02:56', NULL),
(620, 1, 118, 2, 2, 4, 6, 118, '2019-02-26 16:02:56', '2019-02-26 16:05:56'),
(266, 1, 54, 1, 1, 4, 1, 54, '2018-06-29 21:40:39', '2018-06-29 21:40:53'),
(523, 2, 21, 2, 2, 4, 6, 21, '2019-02-26 16:02:56', NULL),
(619, 1, 117, 2, 2, 4, 6, 117, '2019-02-26 16:02:56', '2019-02-26 16:05:52'),
(271, 1, 55, 2, 2, 4, 1, 55, '2018-06-29 21:50:13', NULL),
(522, 2, 20, 2, 2, 4, 6, 20, '2019-02-26 16:02:56', NULL),
(618, 1, 116, 2, 2, 4, 6, 116, '2019-02-26 16:02:56', '2019-02-26 16:05:50'),
(276, 1, 56, 2, 2, 4, 1, 56, '2018-06-29 22:13:11', NULL),
(521, 2, 19, 2, 2, 4, 6, 19, '2019-02-26 16:02:56', NULL),
(617, 2, 115, 2, 2, 4, 6, 115, '2019-02-26 16:02:56', '2019-02-26 16:05:45'),
(281, 1, 57, 2, 2, 4, 1, 57, '2018-06-29 22:21:25', NULL),
(520, 2, 18, 2, 2, 4, 6, 18, '2019-02-26 16:02:56', NULL),
(616, 1, 114, 2, 2, 4, 6, 114, '2019-02-26 16:02:56', '2019-02-26 16:05:38'),
(286, 1, 58, 2, 2, 4, 1, 58, '2018-06-29 22:26:52', NULL),
(519, 2, 17, 2, 2, 4, 6, 17, '2019-02-26 16:02:56', NULL),
(615, 2, 113, 2, 2, 4, 6, 113, '2019-02-26 16:02:56', NULL),
(291, 1, 59, 2, 2, 4, 1, 59, '2018-06-29 22:38:00', NULL),
(518, 2, 16, 2, 2, 4, 6, 16, '2019-02-26 16:02:56', NULL),
(614, 2, 112, 2, 2, 4, 6, 112, '2019-02-26 16:02:56', NULL),
(296, 1, 60, 1, 1, 4, 1, 60, '2018-06-29 22:48:28', '2018-06-29 22:53:30'),
(517, 2, 15, 2, 2, 4, 6, 15, '2019-02-26 16:02:56', NULL),
(613, 2, 111, 2, 2, 4, 6, 111, '2019-02-26 16:02:56', NULL),
(301, 1, 61, 2, 2, 4, 1, 61, '2018-06-29 23:04:17', NULL),
(516, 2, 14, 2, 2, 4, 6, 14, '2019-02-26 16:02:56', NULL),
(612, 2, 110, 2, 2, 4, 6, 110, '2019-02-26 16:02:56', NULL),
(306, 1, 62, 2, 2, 4, 1, 62, '2018-06-29 23:11:35', NULL),
(515, 1, 13, 2, 2, 4, 6, 13, '2019-02-26 16:02:56', '2019-02-26 16:03:33'),
(611, 2, 109, 2, 2, 4, 6, 109, '2019-02-26 16:02:56', NULL),
(311, 1, 63, 2, 2, 4, 1, 63, '2018-06-29 23:20:52', NULL),
(514, 2, 12, 2, 2, 4, 6, 12, '2019-02-26 16:02:56', NULL),
(610, 2, 108, 2, 2, 4, 6, 108, '2019-02-26 16:02:56', NULL),
(316, 1, 64, 2, 2, 4, 1, 64, '2018-06-29 23:27:34', NULL),
(513, 1, 11, 2, 2, 4, 6, 11, '2019-02-26 16:02:56', '2019-02-26 16:03:28'),
(609, 2, 107, 2, 2, 4, 6, 107, '2019-02-26 16:02:56', NULL),
(321, 1, 65, 1, 1, 4, 1, 65, '2018-06-29 23:44:50', '2018-06-29 23:45:00'),
(512, 1, 10, 2, 2, 4, 6, 10, '2019-02-26 16:02:56', '2019-02-26 16:03:21'),
(608, 2, 106, 2, 2, 4, 6, 106, '2019-02-26 16:02:56', NULL),
(326, 1, 66, 2, 2, 4, 1, 66, '2018-06-29 23:53:53', NULL),
(511, 1, 9, 2, 2, 4, 6, 9, '2019-02-26 16:02:56', '2019-02-26 16:03:19'),
(607, 2, 105, 2, 2, 4, 6, 105, '2019-02-26 16:02:56', NULL),
(331, 1, 67, 2, 2, 4, 1, 67, '2018-06-29 23:57:43', NULL),
(510, 1, 8, 2, 2, 4, 6, 8, '2019-02-26 16:02:56', NULL),
(606, 2, 104, 2, 2, 4, 6, 104, '2019-02-26 16:02:56', NULL),
(336, 1, 68, 2, 2, 4, 1, 68, '2018-06-30 00:03:44', NULL),
(509, 1, 7, 2, 2, 4, 6, 7, '2019-02-26 16:02:56', NULL),
(605, 2, 103, 2, 2, 4, 6, 103, '2019-02-26 16:02:56', NULL),
(341, 1, 69, 2, 2, 4, 1, 69, '2018-06-30 00:09:08', NULL),
(508, 1, 6, 2, 2, 4, 6, 6, '2019-02-26 16:02:56', NULL),
(604, 2, 102, 2, 2, 4, 6, 102, '2019-02-26 16:02:56', NULL),
(346, 1, 70, 1, 1, 4, 1, 70, '2018-06-30 00:22:52', '2018-06-30 00:23:08'),
(507, 1, 5, 2, 2, 4, 6, 5, '2019-02-26 16:02:56', NULL),
(603, 2, 101, 2, 2, 4, 6, 101, '2019-02-26 16:02:56', NULL),
(351, 1, 71, 2, 2, 4, 1, 71, '2018-06-30 00:35:47', NULL),
(506, 1, 4, 2, 2, 4, 6, 4, '2019-02-26 16:02:56', NULL),
(602, 2, 100, 2, 2, 4, 6, 100, '2019-02-26 16:02:56', NULL),
(356, 1, 72, 2, 2, 4, 1, 72, '2018-06-30 00:41:58', NULL),
(505, 1, 3, 2, 2, 4, 6, 3, '2019-02-26 16:02:56', NULL),
(601, 2, 99, 2, 2, 4, 6, 99, '2019-02-26 16:02:56', NULL),
(361, 1, 73, 2, 2, 4, 1, 73, '2018-06-30 00:47:33', NULL),
(504, 2, 2, 2, 2, 4, 6, 2, '2019-02-26 16:02:56', NULL),
(600, 2, 98, 2, 2, 4, 6, 98, '2019-02-26 16:02:56', NULL),
(366, 1, 74, 2, 2, 4, 1, 74, '2018-06-30 00:53:21', NULL),
(503, 1, 1, 2, 1, 1, 6, 1, '2019-02-26 16:02:56', '2019-02-26 17:56:36'),
(599, 2, 97, 2, 2, 4, 6, 97, '2019-02-26 16:02:56', NULL),
(371, 1, 75, 1, 1, 5, 1, 75, '2019-02-17 23:11:24', '2019-02-17 23:39:34'),
(502, 1, 118, 2, 2, 4, 1, 118, '2019-02-26 13:45:12', NULL),
(598, 1, 96, 2, 2, 4, 6, 96, '2019-02-26 16:02:56', '2019-02-26 16:05:07'),
(376, 1, 76, 2, 2, 4, 1, 76, '2019-02-18 00:30:10', NULL),
(501, 1, 117, 2, 2, 4, 1, 117, '2019-02-26 13:45:12', NULL),
(597, 1, 95, 2, 2, 4, 6, 95, '2019-02-26 16:02:56', '2019-02-26 16:05:03'),
(381, 1, 77, 2, 2, 4, 1, 77, '2019-02-18 00:32:28', NULL),
(500, 1, 116, 2, 2, 4, 1, 116, '2019-02-26 13:45:12', NULL),
(596, 1, 94, 2, 1, 6, 6, 94, '2019-02-26 16:02:56', '2019-02-26 16:30:10'),
(386, 1, 78, 2, 2, 4, 1, 78, '2019-02-18 00:33:20', NULL),
(499, 1, 115, 2, 2, 4, 1, 115, '2019-02-26 13:45:12', NULL),
(595, 2, 93, 2, 2, 4, 6, 93, '2019-02-26 16:02:56', NULL),
(391, 1, 79, 2, 2, 4, 1, 79, '2019-02-18 00:34:12', NULL),
(498, 1, 114, 2, 2, 4, 1, 114, '2019-02-26 13:45:12', NULL),
(594, 2, 92, 2, 2, 4, 6, 92, '2019-02-26 16:02:56', NULL),
(396, 1, 80, 2, 2, 4, 1, 80, '2019-02-18 00:43:39', NULL),
(497, 1, 113, 2, 2, 4, 1, 113, '2019-02-26 13:45:12', NULL),
(593, 2, 91, 2, 2, 4, 6, 91, '2019-02-26 16:02:56', NULL),
(401, 1, 81, 2, 2, 4, 1, 81, '2019-02-18 00:48:54', NULL),
(496, 1, 112, 2, 2, 4, 1, 112, '2019-02-26 13:45:12', NULL),
(592, 2, 90, 2, 2, 4, 6, 90, '2019-02-26 16:02:56', NULL),
(406, 1, 82, 1, 1, 5, 1, 82, '2019-02-18 00:59:06', '2019-02-18 01:04:28'),
(495, 1, 111, 2, 2, 4, 1, 111, '2019-02-26 13:45:12', NULL),
(591, 2, 89, 2, 2, 4, 6, 89, '2019-02-26 16:02:56', NULL),
(411, 1, 83, 1, 1, 5, 1, 83, '2019-02-18 09:30:15', '2019-02-18 09:30:37'),
(494, 1, 110, 2, 2, 4, 1, 110, '2019-02-26 13:45:12', NULL),
(590, 2, 88, 2, 2, 4, 6, 88, '2019-02-26 16:02:56', NULL),
(416, 1, 84, 1, 1, 5, 1, 84, '2019-02-18 09:43:20', '2019-02-18 09:45:03'),
(493, 1, 109, 2, 2, 4, 1, 109, '2019-02-26 13:45:12', NULL),
(589, 2, 87, 2, 2, 4, 6, 87, '2019-02-26 16:02:56', NULL),
(421, 1, 85, 2, 2, 4, 1, 85, '2019-02-18 09:49:22', '2019-02-18 09:49:37'),
(492, 1, 108, 2, 2, 4, 1, 108, '2019-02-26 13:45:12', NULL),
(588, 2, 86, 2, 2, 4, 6, 86, '2019-02-26 16:02:56', NULL),
(426, 1, 86, 2, 2, 4, 1, 86, '2019-02-18 09:54:46', NULL),
(491, 1, 107, 2, 2, 4, 1, 107, '2019-02-26 13:45:12', NULL),
(587, 2, 85, 2, 2, 4, 6, 85, '2019-02-26 16:02:56', NULL),
(431, 1, 87, 2, 2, 4, 1, 87, '2019-02-18 09:59:27', NULL),
(490, 1, 106, 2, 2, 4, 1, 106, '2019-02-26 13:45:12', NULL),
(586, 2, 84, 2, 2, 4, 6, 84, '2019-02-26 16:02:56', NULL),
(436, 1, 88, 2, 2, 4, 1, 88, '2019-02-18 10:04:13', NULL),
(489, 1, 105, 2, 2, 4, 1, 105, '2019-02-26 13:45:12', NULL),
(585, 2, 83, 2, 2, 4, 6, 83, '2019-02-26 16:02:56', NULL),
(441, 1, 89, 2, 2, 4, 1, 89, '2019-02-18 10:06:34', NULL),
(488, 1, 104, 2, 2, 4, 1, 104, '2019-02-26 13:45:12', NULL),
(584, 2, 82, 2, 2, 4, 6, 82, '2019-02-26 16:02:56', NULL),
(446, 1, 90, 2, 2, 4, 1, 90, '2019-02-18 10:09:22', NULL),
(487, 1, 103, 2, 2, 4, 1, 103, '2019-02-26 13:45:12', NULL),
(583, 2, 81, 2, 2, 4, 6, 81, '2019-02-26 16:02:56', NULL),
(451, 1, 91, 1, 1, 5, 1, 91, '2019-02-20 09:37:32', '2019-02-20 09:44:33'),
(486, 1, 102, 2, 2, 4, 1, 102, '2019-02-26 13:45:12', NULL),
(582, 2, 80, 2, 2, 4, 6, 80, '2019-02-26 16:02:56', NULL),
(456, 1, 92, 2, 2, 4, 1, 92, '2019-02-20 09:43:05', NULL),
(485, 1, 101, 2, 2, 4, 1, 101, '2019-02-26 13:45:12', NULL),
(581, 2, 79, 2, 2, 4, 6, 79, '2019-02-26 16:02:56', NULL),
(461, 1, 93, 2, 2, 4, 1, 93, '2019-02-20 09:44:02', NULL),
(484, 1, 100, 2, 2, 4, 1, 100, '2019-02-26 13:45:12', NULL),
(580, 2, 78, 2, 2, 4, 6, 78, '2019-02-26 16:02:56', NULL),
(466, 1, 94, 1, 1, 5, 1, 94, '2019-02-20 09:59:47', '2019-02-20 10:00:04'),
(483, 1, 99, 2, 2, 4, 1, 99, '2019-02-26 13:45:12', NULL),
(579, 2, 77, 2, 2, 4, 6, 77, '2019-02-26 16:02:56', NULL),
(471, 1, 95, 2, 2, 4, 1, 95, '2019-02-20 10:01:28', NULL),
(482, 1, 98, 2, 2, 4, 1, 98, '2019-02-26 13:45:12', NULL),
(578, 2, 76, 2, 2, 4, 6, 76, '2019-02-26 16:02:56', NULL),
(476, 1, 96, 2, 2, 4, 1, 96, '2019-02-25 17:29:05', '2019-02-26 12:19:12'),
(481, 1, 97, 2, 2, 4, 1, 97, '2019-02-26 13:45:12', NULL),
(577, 2, 75, 2, 2, 4, 6, 75, '2019-02-26 16:02:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_niveis_acessos`
--

CREATE TABLE `adms_niveis_acessos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_niveis_acessos`
--

INSERT INTO `adms_niveis_acessos` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Super Administrador', 1, '2018-05-23 00:00:00', '2018-06-20 19:16:20'),
(6, 'Administrador', 2, '2019-02-26 16:02:52', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_paginas`
--

CREATE TABLE `adms_paginas` (
  `id` int(11) NOT NULL,
  `controller` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `metodo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `menu_controller` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `menu_metodo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `nome_pagina` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  `lib_pub` int(11) NOT NULL DEFAULT 2,
  `icone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_grps_pg_id` int(11) NOT NULL,
  `adms_tps_pg_id` int(11) NOT NULL,
  `adms_sits_pg_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_paginas`
--

INSERT INTO `adms_paginas` (`id`, `controller`, `metodo`, `menu_controller`, `menu_metodo`, `nome_pagina`, `obs`, `lib_pub`, `icone`, `adms_grps_pg_id`, `adms_tps_pg_id`, `adms_sits_pg_id`, `created`, `modified`) VALUES
(1, 'Home', 'index', 'home', 'index', 'Dashboard', 'PÃ¡gina inicial do sistema administrativo             ', 2, 'fas fa-tachometer-alt', 1, 1, 1, '2018-05-23 00:00:00', '2018-06-25 11:27:06'),
(2, 'Usuarios', 'listar', 'usuarios', 'listar', 'UsuÃ¡rios', 'Pagina para listar os usuÃ¡rios                ', 2, 'fas fa-users', 1, 1, 1, '2018-05-23 00:00:00', '2018-06-25 11:29:02'),
(3, 'Login', 'acesso', 'login', 'acesso', 'Acesso', 'PÃ¡gina de login                ', 1, '', 7, 1, 1, '2018-05-23 00:00:00', '2018-06-25 11:29:15'),
(4, 'Login', 'logout', 'login', 'logout', 'Sair', 'PÃ¡gina para sair do administrativo                ', 1, '', 7, 1, 1, '2018-05-23 00:00:00', '2018-06-25 11:29:25'),
(5, 'NovoUsuario', 'novoUsuario', 'novo-usuario', 'novo-usuario', 'Novo UsuÃ¡rio', 'PÃ¡gina para cadastrar novo usuÃ¡rio na pagina de login                                                ', 1, '', 2, 1, 1, '2018-05-23 00:00:00', '2018-06-25 11:29:38'),
(6, 'Confirmar', 'confirmarEmail', 'confirmar', 'confirmar-email', 'Confirmar e-mail', 'PÃ¡gina para confirmar e-mail                ', 1, '', 7, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:29:56'),
(7, 'EsqueceuSenha', 'esqueceuSenha', 'esqueceu-senha', 'esqueceu-senha', 'Esqueceu a senha', 'PÃ¡gina para recuperar a senha                ', 1, '', 7, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:30:08'),
(8, 'AtualSenha', 'atualSenha', 'atual-senha', 'atual-senha', 'Atualizar a senha', 'PÃ¡gina para atualizar a senha                ', 1, '', 7, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:30:22'),
(9, 'VerPerfil', 'perfil', 'ver-perfil', 'perfil', 'Ver Perfil', 'PÃ¡gina para o usuÃ¡rio ver o seu perfil                ', 2, '', 5, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:33:03'),
(10, 'AlterarSenha', 'altSenha', 'alterar-senha', 'alt-senha', 'Alterar Senha', 'PÃ¡gina para o prÃ³prio usuÃ¡rio alterar a sua senha                ', 2, '', 3, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:32:45'),
(11, 'EditarPerfil', 'altPerfil', 'editar-perfil', 'alt-perfil', 'Editar Perfil', 'PÃ¡gina para o prÃ³prio usuÃ¡rio editar os dados do seu perfil                ', 2, '', 3, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:33:41'),
(12, 'VerUsuario', 'verUsuario', 'ver-usuario', 'ver-usuario', 'Ver UsuÃ¡rio', 'PÃ¡gina para ver detalhes do usuÃ¡rio                ', 2, '', 5, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:31:52'),
(13, 'EditarSenha', 'editSenha', 'editar-senha', 'edit-senha', 'Editar Senha', 'PÃ¡gina para o administrador altera a senha do usuÃ¡rio.                ', 2, '', 3, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:31:09'),
(14, 'EditarUsuario', 'editUsuario', 'editar-usuario', 'edit-usuario', 'Editar UsuÃ¡rio', 'PÃ¡gina para editar os dados do usuÃ¡rio                ', 2, '', 3, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:31:33'),
(15, 'CadastrarUsuario', 'cadUsuario', 'cadastrar-usuario', 'cad-usuario', 'Cadastrar UsuÃ¡rio', 'PÃ¡gina para cadastrar novo usuÃ¡rio                ', 2, '', 2, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:34:31'),
(16, 'ApagarUsuario', 'apagarUsuario', 'apagar-usuario', 'apagar-usuario', 'Apagar UsuÃ¡rio', 'PÃ¡gina para apagar usuÃ¡rio                ', 2, '', 4, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:34:49'),
(17, 'NivelAcesso', 'listar', 'nivel-acesso', 'listar', 'NÃ­vel de Acesso', 'PÃ¡gina para listar nÃ­vel de acesso                ', 2, 'fas fa-key', 1, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:35:16'),
(18, 'CadastrarNivAc', 'cadNivAc', 'cadastrar-niv-ac', 'cad-niv-ac', 'Cadastrar NÃ­vel de Acesso', 'PÃ¡gina para cadastrar nÃ­vel de acesso                ', 2, '', 2, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:35:40'),
(19, 'VerNivAc', 'VerNivAc', 'ver-niv-ac', 'ver-niv-ac', 'Detalhes do NÃ­vel de Acesso', 'PÃ¡gina para ver detalhes do nÃ­vel de acesso                ', 2, '', 5, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:36:05'),
(20, 'EditarNivAc', 'editNivAc', 'editar-niv-ac', 'edit-niv-ac', 'Editar NÃ­vel de Acesso', 'PÃ¡gina para editar nÃ­vel de acesso                ', 2, '', 3, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:36:30'),
(21, 'ApagarNivAc', 'apagarNivAc', 'apagar-niv-ac', 'apagar-niv-ac', 'Apagar NÃ­vel de Acesso', 'PÃ¡gina para apagar nÃ­vel de acesso                ', 2, '', 4, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:36:56'),
(22, 'AltOrdemNivAc', 'altOrdemNivAc', 'alt-ordem-niv-ac', 'alt-ordem-niv-ac', 'Alterar ordem nÃ­vel de acesso', 'PÃ¡gina para alterar ordem do nÃ­vel de acesso                ', 2, '', 8, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:37:24'),
(23, 'Pagina', 'listar', 'pagina', 'listar', 'Listar PÃ¡ginas', 'PÃ¡gina para listar as paginas do administrativo                ', 2, 'fas fa-file-alt', 1, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:37:43'),
(24, 'CadastrarPagina', 'cadPagina', 'cadastrar-pagina', 'cad-pagina', 'Cadastrar Pagina', 'FormulÃ¡rio para cadastrar pagina                ', 2, '', 2, 1, 1, '2018-06-23 00:00:00', '2018-06-25 11:37:59'),
(25, 'VerPagina', 'verPagina', 'ver-pagina', 'ver-pagina', 'Visualizar PÃ¡gina', 'PÃ¡gina para ver detalhes da pÃ¡gina', 2, '', 5, 1, 1, '2018-06-22 14:25:21', NULL),
(26, 'EditarPagina', 'editPagina', 'editar-pagina', 'edit-pagina', 'Editar PÃ¡gina', 'FormulÃ¡rio para editar a pÃ¡gina                                                                                ', 2, '', 3, 1, 1, '2018-06-22 14:43:47', '2018-06-22 15:40:01'),
(27, 'ApagarPagina', 'apagarPagina', 'apagar-pagina', 'apagar-pagina', 'Apagar PÃ¡gina', 'PÃ¡gina para apagar pÃ¡gina                ', 2, '', 4, 1, 1, '2018-06-22 19:17:43', NULL),
(28, 'Permissoes', 'listar', 'permissoes', 'listar', 'PermissÃ£o', 'PÃ¡gina para listar as permissÃµes do nÃ­vel de acesso                ', 2, '', 1, 1, 1, '2018-06-24 11:59:53', NULL),
(29, 'LibPermi', 'libPermi', 'lib-permi', 'lib-permi', 'Liberar PermissÃ£o', 'PÃ¡gina para liberar permissÃ£o                                ', 2, '', 3, 1, 1, '2018-06-24 12:52:42', '2018-06-24 12:54:14'),
(30, 'LibMenu', 'libMenu', 'lib-menu', 'lib-menu', 'Liberar no menu', 'PÃ¡gina para liberar ou bloquear a pÃ¡gina no menu                ', 2, '', 3, 1, 1, '2018-06-25 09:48:29', NULL),
(31, 'LibDropdown', 'libDropdown', 'lib-dropdown', 'lib-dropdown', 'Liberar Dropdown', 'PÃ¡gina para liberar ou bloquear a pÃ¡gina a ser apresentado como dropdown no menu                ', 2, '', 3, 1, 1, '2018-06-25 10:24:39', '2018-06-25 10:29:10'),
(32, 'AltOrdemMenu', 'altOrdemMenu', 'alt-ordem-menu', 'alt-ordem-menu', 'Alterar Ordem Menu', 'PÃ¡gina para alterar a ordem das pÃ¡ginas no menu                ', 2, '', 3, 1, 1, '2018-06-25 10:56:36', NULL),
(33, 'SincroPgNivAc', 'sincroPgNivAc', 'sincro-pg-niv-ac', 'sincro-pg-niv-ac', 'Sincronizar PermissÃµes', 'PÃ¡gina para sincronizar as permissÃµes de acesso a cada nÃ­vel de acesso para as pÃ¡ginas do sistema.                ', 2, '', 3, 1, 1, '2018-06-26 12:23:37', NULL),
(34, 'EditarNivAcPgMenu', 'editNivAcPgMenu', 'editar-niv-ac-pg-menu', 'edit-niv-ac-pg-menu', 'Editar Item de Menu da PÃ¡gina', 'FormulÃ¡rio para editar o item de menu que a pÃ¡gina pertence para um determinado nÃ­vel de acesso', 2, '', 3, 1, 1, '2018-06-28 16:11:35', NULL),
(35, 'Menu', 'listar', 'menu', 'listar', 'Itens de Menu', 'Listar os itens do menu', 2, 'fab fa-elementor', 1, 1, 1, '2018-06-28 01:05:34', NULL),
(36, 'CadastrarMenu', 'cadMenu', 'cadastrar-menu', 'cad-menu', 'Cadastrar Item de Menu', 'FormulÃ¡rio para cadastrar item de menu', 2, '', 2, 1, 1, '2018-06-28 01:20:26', NULL),
(37, 'VerMenu', 'verMenu', 'ver-menu', 'ver-menu', 'Ver item de menu', 'PÃ¡gina para ver detalhes do item de menu', 2, '', 5, 1, 1, '2018-06-28 01:23:25', NULL),
(38, 'EditarMenu', 'editMenu', 'editar-menu', 'edit-menu', 'Editar item de menu', 'FormulÃ¡rio para editar o item de menu', 2, '', 3, 1, 1, '2018-06-28 01:32:29', NULL),
(39, 'ApagarMenu', 'apagarMenu', 'apagar-menu', 'apagar-menu', 'Apagar Item de Menu', 'PÃ¡gina para apagar item de menu', 2, '', 4, 1, 1, '2018-06-28 01:44:13', NULL),
(40, 'AltOrdemItemMenu', 'altOrdemItemMenu', 'alt-ordem-item-menu', 'alt-ordem-item-menu', 'Alterar Ordem Item de Menu', 'PÃ¡gina para alterar a ordem do itens no menu', 2, '', 8, 1, 1, '2018-06-28 01:58:16', NULL),
(41, 'EditarFormCadUsuario', 'editFormCadUsuario', 'editar-form-cad-usuario', 'edit-form-cad-usuario', 'Cadastro de Login', 'FormulÃ¡rio para editar as informaÃ§Ãµes do formulÃ¡rio cadastrar usuÃ¡rio na pÃ¡gina de login                ', 2, 'fas fa-edit', 3, 1, 1, '2018-06-29 18:33:56', '2018-06-29 18:35:03'),
(42, 'EditarConfEmail', 'editConfEmail', 'editar-conf-email', 'edit-conf-email', 'ConfiguraÃ§Ã£o de E-mail', 'FormulÃ¡rio para editar as configuraÃ§Ã£o do servidor de envio de e-mail', 2, 'fas fa-at', 2, 1, 1, '2018-06-29 18:56:15', NULL),
(43, 'Cor', 'listar', 'cor', 'listar', 'Cores', 'Listar as cores dos botÃµes                                                                                ', 2, 'fas fa-tint', 1, 1, 1, '2018-06-29 19:32:21', '2018-06-29 19:45:56'),
(44, 'VerCor', 'verCor', 'ver-cor', 'ver-cor', 'Ver Cores', 'PÃ¡gina para ver detalhes da cor do botÃ£o', 2, '', 5, 1, 1, '2018-06-29 19:50:19', NULL),
(45, 'EditarCor', 'editCor', 'editar-cor', 'edit-cor', 'Editar a Cor', 'FormulÃ¡rio para editar as cores dos botÃµes', 2, '', 3, 1, 1, '2018-06-29 19:59:53', NULL),
(46, 'CadastrarCor', 'cadCor', 'cadastrar-cor', 'cad-cor', 'Cadastrar Cor', 'FormulÃ¡rio para cadastrar a cor do botÃ£o', 2, '', 2, 1, 1, '2018-06-29 20:09:35', NULL),
(47, 'ApagarCor', 'apagarCor', 'apagar-cor', 'apagar-cor', 'Apagar a Cor', 'PÃ¡gina para apagar a cor do botÃ£o', 2, '', 4, 1, 1, '2018-06-29 20:17:36', NULL),
(48, 'GrupoPg', 'listar', 'grupo-pg', 'listar', 'Grupo de PÃ¡gina', 'Listar os grupos das pÃ¡ginas', 2, 'fas fa-file-alt', 1, 1, 1, '2018-06-29 20:29:31', NULL),
(49, 'VerGrupoPg', 'verGrupoPg', 'ver-grupo-pg', 'ver-grupo-pg', 'Ver Grupo de PÃ¡gina', 'PÃ¡gina para ver detalhes do grupo de pÃ¡gina', 2, '', 5, 1, 1, '2018-06-29 20:40:11', NULL),
(50, 'CadastrarGrupoPg', 'cadGrupoPg', 'cadastrar-grupo-pg', 'cad-grupo-pg', 'Cadastro Grupo de PÃ¡gina', 'FormulÃ¡rio para cadastrar novo grupo de pÃ¡gina', 2, '', 2, 1, 1, '2018-06-29 20:58:30', NULL),
(51, 'EditarGrupoPg', 'editGrupoPg', 'editar-grupo-pg', 'edit-grupo-pg', 'Editar Grupo de PÃ¡gina', 'FormulÃ¡rio para editar os dados do grupo de pÃ¡gina', 2, '', 3, 1, 1, '2018-06-29 21:08:41', NULL),
(52, 'ApagarGrupoPg', 'apagarGrupoPg', 'apagar-grupo-pg', 'apagar-grupo-pg', 'Apagar Grupo de PÃ¡gina', 'PÃ¡gina para apagar grupo de pÃ¡gina', 2, '', 4, 1, 1, '2018-06-29 21:19:33', NULL),
(53, 'AltOrdemGrupoPg', 'altOrdemGrupoPg', 'alt-ordem-grupo-pg', 'alt-ordem-grupo-pg', 'Alterar Ordem Grupo Pg', 'Altera a ordem do grupo de pÃ¡gina', 2, '', 8, 1, 1, '2018-06-29 21:31:23', NULL),
(54, 'TipoPg', 'listar', 'tipo-pg', 'listar', 'Tipo de PÃ¡gina', 'Listar os tipos de pÃ¡ginas', 2, 'fas fa-list-ol', 1, 1, 1, '2018-06-29 21:40:39', NULL),
(55, 'CadastrarTipoPg', 'cadTipoPg', 'cadastrar-tipo-pg', 'cad-tipo-pg', 'Cadastrar Tipo de PÃ¡gina', 'FormulÃ¡rio para cadastrar o tipo de pÃ¡gina', 2, '', 2, 1, 1, '2018-06-29 21:50:13', NULL),
(56, 'EditarTipoPg', 'editTipoPg', 'editar-tipo-pg', 'edit-tipo-pg', 'Editar Tipo de PÃ¡gina', 'FormulÃ¡rio para editar o tipo de pÃ¡gina', 2, '', 3, 1, 1, '2018-06-29 22:13:11', NULL),
(57, 'VerTipoPg', 'verTipoPg', 'ver-tipo-pg', 'ver-tipo-pg', 'Ver Tipo de PÃ¡gina', 'PÃ¡gina para ver detalhes do tipo de pÃ¡gina', 2, '', 5, 1, 1, '2018-06-29 22:21:25', NULL),
(58, 'ApagarTipoPg', 'apagarTipoPg', 'apagar-tipo-pg', 'apagar-tipo-pg', 'Apagar Tipo de PÃ¡gina', 'PÃ¡gina para apagar o tipo de pÃ¡gina', 2, '', 4, 1, 1, '2018-06-29 22:26:52', NULL),
(59, 'AltOrdemTipoPg', 'altOrdemTipoPg', 'alt-ordem-tipo-pg', 'alt-ordem-tipo-pg', 'Alterar Ordem Tipo Pg', 'PÃ¡gina para alterar a ordem do tipo de pÃ¡ginas        ', 2, '', 8, 1, 1, '2018-06-29 22:38:00', NULL),
(60, 'Situacao', 'listar', 'situacao', 'listar', 'SituaÃ§Ã£o', 'PÃ¡gina para listar as situaÃ§Ãµes                ', 2, 'fas fa-exclamation-triangle', 1, 1, 1, '2018-06-29 22:48:28', '2018-06-29 22:53:17'),
(61, 'VerSit', 'verSit', 'ver-sit', 'ver-sit', 'Ver SituaÃ§Ã£o', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o', 2, '', 5, 1, 1, '2018-06-29 23:04:17', NULL),
(62, 'CadastrarSit', 'cadSit', 'cadastrar-sit', 'cad-sit', 'Cadastrar SituaÃ§Ã£o', 'FormulÃ¡rio para cadastrar situaÃ§Ã£o', 2, '', 2, 1, 1, '2018-06-29 23:11:35', NULL),
(63, 'EditarSit', 'editSit', 'editar-sit', 'edit-sit', 'Editar a situaÃ§Ã£o', 'FormulÃ¡rio para editar a situaÃ§Ã£o', 2, '', 3, 1, 1, '2018-06-29 23:20:52', NULL),
(64, 'ApagarSit', 'apagarSit', 'apagar-sit', 'apagar-sit', 'Apagar SituaÃ§Ã£o', 'PÃ¡gina para apagar situaÃ§Ã£o', 2, '', 3, 1, 1, '2018-06-29 23:27:34', NULL),
(65, 'SituacaoUser', 'listar', 'situacao-user', 'listar', 'SituaÃ§Ã£o dos UsuÃ¡rios', 'Listar as situaÃ§Ã£o de usuÃ¡rio                ', 2, 'far fa-id-badge', 1, 1, 1, '2018-06-29 23:44:50', '2018-06-29 23:46:55'),
(66, 'VerSitUser', 'verSitUser', 'ver-sit-user', 'ver-sit-user', 'Ver SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o de usuÃ¡rio', 2, '', 5, 1, 1, '2018-06-29 23:53:53', NULL),
(67, 'CadastrarSitUser', 'cadSitUser', 'cadastrar-sit-user', 'cad-sit-user', 'Cadastrar SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para cadastrar situaÃ§Ã£o de usuÃ¡rio', 2, '', 2, 1, 1, '2018-06-29 23:57:43', NULL),
(68, 'EditarSitUser', 'editSitUser', 'editar-sit-user', 'edit-sit-user', 'Editar SituaÃ§Ã£o de UsuÃ¡rio', 'FormulÃ¡rio para editar situaÃ§Ã£o de usuÃ¡rio', 2, '', 3, 1, 1, '2018-06-30 00:03:44', NULL),
(69, 'ApagarSitUser', 'apagarSitUser', 'apagar-sit-user', 'apagar-sit-user', 'Apagar SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para apagar situaÃ§Ã£o de usuÃ¡rio', 2, '', 4, 1, 1, '2018-06-30 00:09:08', NULL),
(70, 'SituacaoPg', 'listar', 'situacao-pg', 'listar', 'SituaÃ§Ã£o de PÃ¡gina', 'Listar as situaÃ§Ãµes de pÃ¡ginas                                ', 2, 'fas fa-exclamation', 1, 1, 1, '2018-06-30 00:22:52', '2018-06-30 00:29:39'),
(71, 'VerSitPg', 'verSitPg', 'ver-sit-pg', 'ver-sit-pg', 'Ver SituaÃ§Ã£o de PÃ¡gina', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o de pÃ¡gina      ', 2, '', 5, 1, 1, '2018-06-30 00:35:47', NULL),
(72, 'CadastrarSitPg', 'cadSitPg', 'cadastrar-sit-pg', 'cad-sit-pg', 'Cadastrar SituaÃ§Ã£o de PÃ¡gina', 'FormulÃ¡rio para cadastrar situaÃ§Ã£o de pÃ¡gina', 2, '', 2, 1, 1, '2018-06-30 00:41:58', NULL),
(73, 'EditarSitPg', 'editSitPg', 'editar-sit-pg', 'edit-sit-pg', 'Editar situaÃ§Ã£o de pÃ¡gina', 'FormulÃ¡rio para editar situaÃ§Ã£o de pÃ¡gina                ', 2, '', 3, 1, 1, '2018-06-30 00:47:33', '2018-06-30 00:47:57'),
(74, 'ApagarSitPg', 'apagarSitPg', 'apagar-sit-pg', 'apagar-sit-pg', 'Apagar SituaÃ§Ã£o de PÃ¡gina', 'PÃ¡gina para apagar situaÃ§Ã£o de pÃ¡gina', 2, '', 4, 1, 1, '2018-06-30 00:53:21', NULL),
(75, 'Carousel', 'listar', 'carousel', 'listar', 'Carousel', 'PÃ¡gina para listar o carousel.                ', 2, 'fas fa-sliders-h', 1, 5, 1, '2019-02-17 23:11:24', '2019-02-17 23:41:46'),
(76, 'VerCarousel', 'verCarousel', 'ver-carousel', 'ver-carousel', 'Ver Carousel', 'PÃ¡gina para ver carousel.', 2, '', 5, 5, 1, '2019-02-18 00:30:10', NULL),
(77, 'EditarCarousel', 'editCarousel', 'editar-carousel', 'edit-carousel', 'Editar Carousel', 'PÃ¡gina para editar carousel.', 2, '', 3, 5, 1, '2019-02-18 00:32:28', NULL),
(78, 'CadastrarCarousel', 'cadCarousel', 'cadastrar-carousel', 'cad-carousel', 'Cadastrar Carousel', 'PÃ¡gina para cadastrar carousel.', 2, '', 2, 5, 1, '2019-02-18 00:33:20', NULL),
(79, 'ApagarCarousel', 'apagarCarousel', 'apagar-carousel', 'apagar-carousel', 'Apagar Carousel', 'PÃ¡gina para apagar carousel.', 2, '', 4, 5, 1, '2019-02-18 00:34:12', NULL),
(80, 'AltSitCarousel', 'altSitCarousel', 'alt-sit-carousel', 'alt-sit-carousel', 'Alterar SituaÃ§Ã£o do Carousel', 'PÃ¡gina para alterar situaÃ§Ã£o do carousel.', 2, '', 6, 5, 1, '2019-02-18 00:43:39', NULL),
(81, 'AltOrdemCarousel', 'altOrdemCarousel', 'alt-ordem-carousel', 'alt-ordem-carousel', 'Alterar Ordem Carousel', 'PÃ¡gina para alterar a ordem do carousel.                ', 2, '', 8, 5, 1, '2019-02-18 00:48:54', NULL),
(82, 'EditarServico', 'editServico', 'editar-servico', 'edit-servico', 'Editar ServiÃ§o', 'PÃ¡gina para editar serviÃ§o                                ', 2, 'far fa-edit', 3, 5, 1, '2019-02-18 00:59:06', '2019-02-18 01:04:00'),
(83, 'EditarVideo', 'editVideo', 'editar-video', 'edit-video', 'Editar Video', 'PÃ¡gina para editar video do site.', 2, 'fas fa-film', 3, 5, 1, '2019-02-18 09:30:15', NULL),
(84, 'SobEmpresa', 'listar', 'sob-empresa', 'listar', 'Sobre Empresa', 'PÃ¡gina para listar o sobre empresa do site.                ', 2, 'fas fa-building', 1, 5, 1, '2019-02-18 09:43:20', '2019-02-18 09:44:45'),
(85, 'CadastrarSobEmpresa', 'cadSobEmpresa', 'cadastrar-sob-empresa', 'cad-sob-empresa', 'Cadastrar Sobre Empresa', 'PÃ¡gina para cadastrar sobre empresa do site.', 2, '', 2, 5, 1, '2019-02-18 09:49:22', NULL),
(86, 'EditarSobEmpresa', 'editSobEmpresa', 'editar-sob-empresa', 'edit-sob-empresa', 'Editar Sobre Empresa', 'PÃ¡gina para editar sobre empresa.', 2, '', 3, 5, 1, '2019-02-18 09:54:46', NULL),
(87, 'VerSobEmpresa', 'verSobEmpresa', 'ver-sob-empresa', 'ver-sob-empresa', 'Ver Sobre Empresa', 'PÃ¡gina para ver sobre empresa.', 2, '', 5, 5, 1, '2019-02-18 09:59:27', NULL),
(88, 'ApagarSobEmpresa', 'apagarSobEmpresa', 'apagar-sob-empresa', 'apagar-sob-empresa', 'Apagar Sobre Empresa', 'PÃ¡gina para apagar sobre empresa.', 2, '', 4, 5, 1, '2019-02-18 10:04:13', NULL),
(89, 'AltSitSobEmpresa', 'altSitSobEmpresa', 'alt-sit-sob-empresa', 'alt-sit-sob-empresa', 'Alterar SituaÃ§Ã£o do Sobre Empresa', 'PÃ¡gina para alterar situaÃ§Ã£o sobre empresa.', 2, '', 6, 5, 1, '2019-02-18 10:06:34', NULL),
(90, 'AltOrdemSobEmpresa', 'altOrdemSobEmpresa', 'alt-ordem-sob-empresa', 'alt-ordem-sob-empresa', 'Alterar Ordem Sobre Empresa', 'PÃ¡gina para alterar a ordem sobre empresa.                ', 2, '', 8, 5, 1, '2019-02-18 10:09:22', '2019-02-18 10:10:07'),
(91, 'Contato', 'listar', 'contato', 'listar', 'Contato', 'PÃ¡gina para ver os contatos enviado pelo site.', 2, 'fas fa-envelope', 1, 5, 1, '2019-02-20 09:37:32', NULL),
(92, 'VerContato', 'verContato', 'ver-contato', 'ver-contato', 'Ver Contato', 'PÃ¡gina para visualizar contato.', 2, '', 5, 5, 1, '2019-02-20 09:43:05', NULL),
(93, 'ApagarContato', 'apagarContato', 'apagar-contato', 'apagar-contato', 'Apagar Contato', 'PÃ¡gina para apagar o contato.', 2, '', 4, 5, 1, '2019-02-20 09:44:02', NULL),
(94, 'Artigo', 'listar', 'artigo', 'listar', 'Artigo', 'PÃ¡gina para listar artigos', 2, 'fas fa-newspaper', 1, 5, 1, '2019-02-20 09:59:47', NULL),
(95, 'CadastrarArtigo', 'cadArtigo', 'cadastrar-artigo', 'cad-artigo', 'Cadastrar Artigo', 'PÃ¡gina para cadastrar artigo.                ', 2, '', 2, 5, 1, '2019-02-20 10:01:28', NULL),
(96, 'Noticia', 'listar', 'noticia', 'listar', 'NotÃ­cia', 'PÃ¡gina para listar todas as notÃ­cias.                ', 2, 'fas fa-newspaper', 1, 5, 2, '2019-02-25 15:33:47', '2019-02-26 12:18:09'),
(97, 'EditarSobre', 'editSobre', 'editar-sobre', 'edit-sobre', 'Editar Sobre', 'Editar sobre na pÃ¡gina blog', 2, 'fas fa-user-circle', 3, 5, 1, '2018-07-04 13:13:52', NULL),
(98, 'Robots', 'listar', 'robots', 'listar', 'Robots', 'Listar robots das pÃ¡ginas', 2, 'fas fa-search', 1, 5, 1, '2018-07-04 14:01:38', NULL),
(99, 'VerRobots', 'verRobots', 'ver-robots', 'ver-robots', 'Ver Robots', 'PÃ¡gina para ver detalhes de Robots da PÃ¡gina', 2, '', 5, 5, 1, '2018-07-04 14:33:25', NULL),
(100, 'CadastrarRobots', 'cadRobots', 'cadastrar-robots', 'cad-robots', 'Cadastrar Robots', 'FormulÃ¡rio para cadastrar robots de pÃ¡gina', 2, '', 2, 5, 1, '2018-07-04 14:43:23', NULL),
(101, 'EditarRobots', 'editRobots', 'editar-robots', 'edit-robots', 'Editar Robots', 'FormulÃ¡rio para editar Robots de pÃ¡gina', 2, '', 3, 5, 1, '2018-07-04 15:04:06', NULL),
(102, 'ApagarRobots', 'apagarRobots', 'apagar-robots', 'apagar-robots', 'Apagar Robots', 'PÃ¡gina para apagar robots de pÃ¡gina', 2, '', 4, 5, 1, '2018-07-04 15:25:59', NULL),
(103, 'TpArtigo', 'listar', 'tp-artigo', 'listar', 'Tipo de Artigo', 'FormulÃ¡rio para cadastrar tipo de artigo                ', 2, 'far fa-clipboard', 2, 5, 1, '2018-07-04 15:40:34', '2018-07-04 15:44:58'),
(104, 'CadastrarTpArtigo', 'cadTpArtigo', 'cadastrar-tp-artigo', 'cad-tp-artigo', 'Cadastrar Tipo de Artigo', 'FormulÃ¡rio para editar tipo de artigo', 2, '', 2, 5, 1, '2018-07-04 15:54:01', NULL),
(105, 'VerTpArtigo', 'verTpArtigo', 'ver-tp-artigo', 'ver-tp-artigo', 'Ver tipo de artigo', 'PÃ¡gina para ver detalhes do tipo de artigo', 2, '', 5, 5, 1, '2018-07-04 16:02:08', NULL),
(106, 'EditarTpArtigo', 'editTpArtigo', 'editar-tp-artigo', 'edit-tp-artigo', 'Editar tipo de artigo', 'FormulÃ¡rio para editar tipo de artigo', 2, '', 3, 5, 1, '2018-07-04 16:07:23', NULL),
(107, 'ApagarTpArtigo', 'apagarTpArtigo', 'apagar-tp-artigo', 'apagar-tp-artigo', 'Apagar tipo de artigo', 'PÃ¡gina para apagar tipo de artigo', 2, '', 4, 5, 1, '2018-07-04 16:18:22', NULL),
(108, 'CatArtigo', 'listar', 'cat-artigo', 'listar', 'Categoria de Artigo', 'Listar as categorias de artigo', 2, 'fas fa-clipboard-list', 1, 5, 1, '2018-07-05 10:39:49', NULL),
(109, 'VerCatArtigo', 'verCatArtigo', 'ver-cat-artigo', 'ver-cat-artigo', 'Ver Categoria de Artigo', 'PÃ¡gina para ver detalhes da categoria de artigo', 2, '', 5, 5, 1, '2018-07-05 11:41:42', NULL),
(110, 'CadastrarCatArtigo', 'cadCatArtigo', 'cadastrar-cat-artigo', 'cad-cat-artigo', 'Cadastrar categoria de artigo', 'FormulÃ¡rio para cadastrar categoria  de artigo', 2, '', 2, 5, 1, '2018-07-05 11:50:52', NULL),
(111, 'EditarCatArtigo', 'editCatArtigo', 'editar-cat-artigo', 'edit-cat-artigo', 'Editar categoria de artigo', 'FormulÃ¡rio para editar categoria de artigo', 2, '', 3, 5, 1, '2018-07-05 11:59:25', NULL),
(112, 'ApagarCatArtigo', 'apagarCatArtigo', 'apagar-cat-artigo', 'apagar-cat-artigo', 'Apagar categoria de artigo', 'Apagar categoria de artigo', 2, '', 4, 5, 1, '2018-07-05 12:10:48', NULL),
(113, 'AltSitCatArtigo', 'altSitCatArtigo', 'alt-sit-cat-artigo', 'alt-sit-cat-artigo', 'Alterar SituaÃ§Ã£o Categoria Artigo', 'PÃ¡gina para alterar a situaÃ§Ã£o da categoria de artigo', 2, '', 3, 5, 1, '2018-07-05 12:19:32', NULL),
(114, 'VerArtigo', 'verArtigo', 'ver-artigo', 'ver-artigo', 'Ver Artigo', 'PÃ¡gina para ver detalhes do artigo   ', 2, '', 5, 5, 1, '2018-07-05 12:41:20', NULL),
(115, 'EditarAutorArtigo', 'editAutorArtigo', 'editar-autor-artigo', 'edit-autor-artigo', 'Editar Autor do Artigo', 'FormulÃ¡rio para editar autor do artigo', 2, '', 3, 5, 1, '2018-07-05 14:26:11', NULL),
(116, 'EditarArtigo', 'editArtigo', 'editar-artigo', 'edit-artigo', 'Editar Artigo', 'FormulÃ¡rio para editar artigo', 2, '', 3, 5, 1, '2018-07-05 14:47:02', NULL),
(117, 'ApagarArtigo', 'apagarArtigo', 'apagar-artigo', 'apagar-artigo', 'Apagar Artigo', 'PÃ¡gina para apagar o artigo', 2, '', 4, 5, 1, '2018-07-05 15:01:41', NULL),
(118, 'AltSitArtigo', 'altSitArtigo', 'alt-sit-artigo', 'alt-sit-artigo', 'Alterar situaÃ§Ã£o do artigo', 'Alterar a situaÃ§Ã£o do artigo', 2, '', 3, 5, 1, '2018-07-05 15:36:16', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_robots`
--

CREATE TABLE `adms_robots` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_robots`
--

INSERT INTO `adms_robots` (`id`, `nome`, `tipo`, `created`, `modified`) VALUES
(1, 'Indexar a pÃ¡gina e seguir os links', 'index,follow', '2018-02-23 00:00:00', NULL),
(2, 'NÃ£o indexar a pÃ¡gina mas seguir os links', 'noindex,follow', '2018-02-23 00:00:00', NULL),
(3, 'Indexar a pÃ¡gina mas nÃ£o seguir os links', 'index,nofollow', '2018-02-23 00:00:00', NULL),
(4, 'NÃ£o indexar a pÃ¡gina e nem seguir os links', 'noindex,nofollow', '2018-02-23 00:00:00', NULL),
(5, 'NÃ£o exibir a versÃ£o em cache da pÃ¡gina', 'noarchive', '2018-02-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits`
--

CREATE TABLE `adms_sits` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits`
--

INSERT INTO `adms_sits` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2018-05-23 00:00:00', NULL),
(2, 'Inativo', 4, '2018-05-23 00:00:00', NULL),
(3, 'Analise', 1, '2018-05-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_pgs`
--

CREATE TABLE `adms_sits_pgs` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_pgs`
--

INSERT INTO `adms_sits_pgs` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Ativo', 'success', '2018-03-23 00:00:00', NULL),
(2, 'Inativo', 'danger', '2018-03-23 00:00:00', NULL),
(3, 'Analise', 'primary', '2018-03-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_usuarios`
--

CREATE TABLE `adms_sits_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_usuarios`
--

INSERT INTO `adms_sits_usuarios` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2018-05-23 00:00:00', NULL),
(2, 'Inativo', 5, '2018-05-23 00:00:00', NULL),
(3, 'Aguardando confirmaÃ§Ã£o', 1, '2018-05-23 00:00:00', '2018-06-30 00:32:45'),
(4, 'Spam', 4, '2018-06-30 00:17:08', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_tps_pgs`
--

CREATE TABLE `adms_tps_pgs` (
  `id` int(11) NOT NULL,
  `tipo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_tps_pgs`
--

INSERT INTO `adms_tps_pgs` (`id`, `tipo`, `nome`, `obs`, `ordem`, `created`, `modified`) VALUES
(1, 'adms', 'Administrativo', 'Core do Administrativo', 1, '2018-05-23 00:00:00', '2018-06-29 22:41:45'),
(5, 'sts', 'Administrativo do Site', 'Projeto para administrar o site.                ', 2, '2019-02-17 22:59:29', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_usuarios`
--

CREATE TABLE `adms_usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `apelido` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chave_descadastro` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conf_email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_usuarios`
--

INSERT INTO `adms_usuarios` (`id`, `nome`, `apelido`, `email`, `usuario`, `senha`, `recuperar_senha`, `chave_descadastro`, `conf_email`, `imagem`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 'Dhemes Mota', 'Dhemes', 'dhemes.mota@gmail.com', 'dhemes.mota@gmail.com', '$2y$10$rCPl9/XlvsNALACdq089ce4K/PTXKOICEBcSmTKaq7iy/mf.r7qOy', '6776c7c5b1b4c592b5339b774d3147ca', 'bbe0d9883f909fb95ca46e8396fd7194', '2', 'dh.jpg', 1, 1, '2018-05-23 00:00:00', '2019-02-26 16:15:40'),
(14, 'JoÃ£o Victor', 'JoÃ£o', 'joaovictorv9820@gmail.com', 'joao9820', '$2y$10$k6YxSlU0Q7IA6PpNK9VcnOFxVoqkxGecVIfP9aug4VhDg3N5D5XPu', NULL, NULL, NULL, '', 6, 1, '2019-02-26 16:02:02', NULL),
(15, 'Admin', 'Admin', 'admin@admin.com', 'admin', '$2y$10$bxAI1LiknpyKpqBZ.8hC.OyuK0w4X1bAvswNhdbUn0i2hchBcO6sa', NULL, NULL, NULL, 'iclogo.jpg', 6, 1, '2019-02-26 16:12:54', NULL),
(16, 'IPAC', 'IPAC', 'ipac@ipaconline.com.br', 'ipaconline123', '$2y$10$ehS/IwBsrwF2VpK/tZRtnerGqsPXxzudBHvILRpRA4XG1qjD4V6GC', NULL, NULL, NULL, 'iclogo.jpg', 6, 1, '2019-03-01 13:29:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curriculo`
--

CREATE TABLE `curriculo` (
  `id` int(1) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `datan` date NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `cep` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `areadeinteresse` varchar(50) DEFAULT NULL,
  `formacao` varchar(50) NOT NULL,
  `disponibilidade` varchar(50) NOT NULL,
  `conhecimentolt` varchar(50) NOT NULL,
  `conhecimentoec` varchar(50) NOT NULL,
  `conhecimentodpessoal` varchar(50) NOT NULL,
  `conhecimentodprocesso` varchar(50) NOT NULL,
  `conhecimentoiacess` varchar(50) NOT NULL,
  `conhecimentoiexcel` varchar(50) NOT NULL,
  `conhecimentoidexion` varchar(50) NOT NULL,
  `conhecimentoc` varchar(50) NOT NULL,
  `conhecimentofolha` varchar(50) NOT NULL,
  `conhecimentoiws` varchar(50) NOT NULL,
  `nomeempresa` varchar(50) NOT NULL,
  `nomeempresa2` varchar(50) NOT NULL,
  `nomeempresa3` varchar(50) NOT NULL,
  `telempresa` varchar(50) NOT NULL,
  `telempresa2` varchar(50) NOT NULL,
  `telempresa3` varchar(50) NOT NULL,
  `tipoempresa` varchar(50) NOT NULL,
  `tipoempresa2` varchar(50) NOT NULL,
  `tipoempresa3` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `cargo2` varchar(50) NOT NULL,
  `cargo3` varchar(50) NOT NULL,
  `salario` varchar(50) NOT NULL,
  `salario2` varchar(50) NOT NULL,
  `salario3` varchar(50) NOT NULL,
  `periodoi` date NOT NULL,
  `periodoi2` date NOT NULL,
  `periodoi3` date NOT NULL,
  `periodof` varchar(50) NOT NULL,
  `periodof2` date NOT NULL,
  `periodof3` date NOT NULL,
  `areadeatuacao` varchar(50) NOT NULL,
  `areadeatuacao2` varchar(50) NOT NULL,
  `areadeatuacao3` varchar(50) NOT NULL,
  `rfult` varchar(50) NOT NULL,
  `rfult2` varchar(50) NOT NULL,
  `rfult3` varchar(50) NOT NULL,
  `motivosaida` varchar(50) DEFAULT NULL,
  `infoad` varchar(150) NOT NULL,
  `infoad2` varchar(150) NOT NULL,
  `infoad3` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `curriculo`
--

INSERT INTO `curriculo` (`id`, `nome`, `sexo`, `email`, `datan`, `telefone`, `endereco`, `cep`, `cidade`, `areadeinteresse`, `formacao`, `disponibilidade`, `conhecimentolt`, `conhecimentoec`, `conhecimentodpessoal`, `conhecimentodprocesso`, `conhecimentoiacess`, `conhecimentoiexcel`, `conhecimentoidexion`, `conhecimentoc`, `conhecimentofolha`, `conhecimentoiws`, `nomeempresa`, `nomeempresa2`, `nomeempresa3`, `telempresa`, `telempresa2`, `telempresa3`, `tipoempresa`, `tipoempresa2`, `tipoempresa3`, `cargo`, `cargo2`, `cargo3`, `salario`, `salario2`, `salario3`, `periodoi`, `periodoi2`, `periodoi3`, `periodof`, `periodof2`, `periodof3`, `areadeatuacao`, `areadeatuacao2`, `areadeatuacao3`, `rfult`, `rfult2`, `rfult3`, `motivosaida`, `infoad`, `infoad2`, `infoad3`) VALUES
(2, 'a', 'Masculino', 'a@aa.com', '0000-00-00', '', 'a', 'a', 'a', 'Outra', 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', 'a', '', '', 'a', '', '', 'tipoempresa3', '', '', 'a', '', '', 'a', '', '', '0001-02-15', '0000-00-00', '0000-00-00', '2222-02-22', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', 'a', '', '', 'a', 'a', '', ''),
(3, 'Davi', 'Masculino', 'daviqs.ti@gmail.com', '2011-11-11', '1999-02-15', 'QR 414 CONJUNTO 18 CASA 10', '72320225', 'Samambaia', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', '', '', '', ''),
(4, 'Davi', 'Masculino', 'daviqs.ti@gmail.com', '2011-11-11', '1999-02-15', 'QR 414 CONJUNTO 18 CASA 10', '72320225', 'Samambaia', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', '', '', '', ''),
(5, 'Davi', 'Masculino', 'daviqs.ti@gmail.com', '0000-00-00', '1999-02-15', 'QR 414 CONJUNTO 18 CASA 10', '72320225', 'Samambaia', NULL, 'formacao1', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', 'cc', '', '', 'cc', '', '', 'tipoempresa1', '', '', 'cc', '', '', 'cc', '', '', '1111-11-11', '0000-00-00', '0000-00-00', '3333-03-31', '0000-00-00', '0000-00-00', 'areadeatuacao3', '', '', '', '', '', '', 'cc', '', ''),
(6, 'd', 'Masculino', 'd@a', '0000-00-00', '1999-02-15', '111', '111', '111', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(7, 'd', 'Masculino', 'd@a', '0000-00-00', '1999-02-15', '111', '111', '111', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(8, 'd', 'Masculino', 'd@a', '0000-00-00', '1999-02-15', '111', '111', '111', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(9, 'ggg', 'Masculino', '555@41', '0000-00-00', '0555-05-15', '555', '555', '555', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(10, 'LUID PEREIRA TORRES', 'Masculino', 'luidtorres@gmail.com', '0000-00-00', '1970-09-12', 'Smpw Quadra 16 Conj 5 Lote 6, Casa G', '71741605', 'Brasília', NULL, 'formacao1', 'disponibilidade1', 'conhecimento2lt', 'conhecimento2ec', 'conhecimento4dpessoal', 'conhecimento2dprocesso', 'conhecimento2iacess', 'conhecimento2iexcel', 'conhecimento3idexion', 'conhecimento1c', 'conhecimento3folha', 'conhecimento1iws', '3 empresa', '', '', '', '', '', 'tipoempresa3', '', '', 'gerente', '', '', '3000', '', '', '1970-09-01', '0000-00-00', '0000-00-00', '1970-09-20', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', 'responsabilidade ne 3 empresa era', '', '', NULL, 'informações adicionais - 3 empresa', '', ''),
(11, 'LUID PEREIRA TORRES', 'Masculino', 'luidtorres@gmail.com', '0000-00-00', '1970-09-12', 'Smpw Quadra 16 Conj 5 Lote 6, Casa G', '71741605', 'Brasília', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(12, 'Regina Braga', 'Feminino', 'regima@rrrr', '0000-00-00', '2424-02-11', '333333', '545454', '545454', NULL, 'formacao1', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(13, 'Regina Braga', 'Feminino', 'regima@rrrr', '0000-00-00', '2424-02-11', '333333', '545454', '545454', NULL, 'formacao1', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(14, 'Regina Braga', 'Feminino', 'regima@rrrr', '0000-00-00', '2424-02-11', '333333', '545454', '545454', NULL, 'formacao1', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(15, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(16, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(17, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(18, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(19, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(20, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(21, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(22, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(23, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(24, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(25, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(26, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(27, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(28, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(29, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(30, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(31, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(32, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(33, 'Davi Queiroz dos Santos', 'Masculino', 'daviqs.ti@gmail.com', '0000-00-00', '2019-02-15', 'E', 'E', 'R', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(34, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(35, 'Borges', 'Masculino', 'regima@rrrr', '0000-00-00', '1111-11-11', '44444', '4141', '4141', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(36, 'Luid', 'Masculino', 'lll@gmail.com', '0000-00-00', '2019-02-07', 'Smp', '71', 'Brasilia', NULL, 'formacao1', 'disponibilidade2', 'conhecimento3lt', 'conhecimento3ec', 'conhecimento2dpessoal', 'conhecimento3dprocesso', 'conhecimento3iacess', 'conhecimento2iexcel', 'conhecimento2idexion', 'conhecimento2c', 'conhecimento2folha', 'conhecimento3iws', 'Bco', '', '', '', '', '', 'tipoempresa2', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao2', '', '', '', '', '', NULL, '', '', ''),
(37, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(38, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(39, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(40, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(41, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(42, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(43, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(44, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(45, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(46, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(47, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(48, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(49, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(50, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(51, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(52, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', ''),
(53, 'aaa', 'Masculino', 'aaaa@AAA', '0000-00-00', '12121-12-12', 'sasa', 'sasa', 'sasas', NULL, 'formacao3', 'disponibilidade4', 'conhecimento1lt', 'conhecimento4ec', 'conhecimento4dpessoal', 'conhecimento1dprocesso', 'conhecimento4iacess', 'conhecimento4iexcel', 'conhecimento4idexion', 'conhecimento4c', 'conhecimento4folha', 'conhecimento4iws', '', '', '', '', '', '', 'tipoempresa3', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', '0000-00-00', 'areadeatuacao5', '', '', '', '', '', NULL, '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_artigos`
--

CREATE TABLE `sts_artigos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `conteudo` text CHARACTER SET utf8 NOT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `resumo_publico` text COLLATE utf8_unicode_ci NOT NULL,
  `qnt_acesso` int(11) NOT NULL DEFAULT 0,
  `sts_robot_id` int(11) NOT NULL,
  `adms_usuario_id` int(11) NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `sts_tps_artigo_id` int(11) NOT NULL,
  `sts_cats_artigo_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_artigos`
--

INSERT INTO `sts_artigos` (`id`, `titulo`, `descricao`, `conteudo`, `imagem`, `slug`, `keywords`, `description`, `author`, `resumo_publico`, `qnt_acesso`, `sts_robot_id`, `adms_usuario_id`, `adms_sit_id`, `sts_tps_artigo_id`, `sts_cats_artigo_id`, `created`, `modified`) VALUES
(6, 'Foi liberado o programa gerador do imposto de renda 2019 ', '<p>A Receita Federal do Brasil disponibilizou o programa gerador do <strong>Imposto de Renda 2019</strong>, ano calendÃ¡rio 2018, para computadores (plataformas Windows, Mac, Linux e Solaris) e para celulares (Android e IOS).</p>', '<p>Foi liberado nesta segunda-feira, 25, o programa do IRPF 2019, ano calendÃ¡rio 2018, para computadores (plataformas Windows, Mac, Linux e Solaris) e para celulares (Android e IOS). Para download do IRPF 2019: <a href=\"http://receita.economia.gov.br/interface/cidadao/irpf/2019/download\">http://receita.economia.gov.br/interface/cidadao/irpf/2019/download</a></p><p>O programa Ã© o mesmo para as duas formas de declaraÃ§Ãµes (simplificada e completa) que, logo no inÃ­cio do preenchimento, sÃ£o apresentadas orientaÃ§Ãµes sobre a tributaÃ§Ã£o. Ao tÃ©rmino da declaraÃ§Ã£o o programa faz um comparativo entre as duas formas de declaraÃ§Ãµes para que o contribuinte possa escolher aquela que melhor se adequa Ã  sua realidade.</p><p>Ã‰ obrigado a apresentar a declaraÃ§Ã£o anual todo contribuinte que: - no ano-calendÃ¡rio de 2018, recebeu rendimentos tributÃ¡veis, sujeitos ao ajuste na declaraÃ§Ã£o, cuja soma foi superior a R$28.559,70 no ano (R$2.379,97 p/ mÃªs); e, - tenha recebido mais de R$40.000,00 referente a rendimentos isentos, nÃ£o tributÃ¡veis ou tributados exclusivamente na fonte.</p><p>Aqueles contribuintes que entregarem suas respectivas declaraÃ§Ãµes mais cedo, tambÃ©m receberÃ£o sua restituiÃ§Ã£o do IR mais cedo, considerando que os idosos, portadores de doenÃ§a grave, deficientes fÃ­sicos e deficientes mentais tÃªm prioridade no recebimento. As restituiÃ§Ãµes serÃ£o pagas em 17/06/19, 15/07/19, 15/08/19, 16/09/19, 15/10/19, 18/11/19 e 16/12/19.</p><p>O envio da declaraÃ§Ã£o somente poderÃ¡ ocorrer a partir das 8h do dia 07/03, quinta-feira, apÃ³s o Carnaval.</p><p>Para quem nÃ£o apresentar a declaraÃ§Ã£o do IRPF atÃ© Ã s 23h59 do dia 30/04/19, estarÃ¡ sujeito Ã  multa de, no mÃ­nimo, R$165,74 podendo chegar Ã  20% do imposto devido.</p><p>Uma das principais novidades para este ano Ã© que o contribuinte poderÃ¡ saber se sua declaraÃ§Ã£o caiu na malha-fina logo na sequÃªncia do envio (na noite em que encaminhou a declaraÃ§Ã£o ou no dia seguinte).</p><p>Outra novidade Ã© a exigÃªncia do CPF para todos os dependentes. AtÃ© o ano passado, era obrigatÃ³rio informar apenas o CPF para dependentes a partir de 8 anos.</p><p>IPAC Contabilidade, a assessoria que sua Empresa precisa.</p>', 'artigo.jpg', 'irpf-2019', 'artigo, irpf, receita federal', 'A Receita Federal do Brasil disponibilizou o programa gerador do Imposto de Renda 2019, ano calendÃ¡rio 2018...', 'Foi liberado o programa gerador do imposto de rend', '<p>Foi liberado nesta segunda-feira, 25, o programa do IRPF 2019, ano calendÃ¡rio 2018, para computadores (plataformas Windows, Mac, Linux e Solaris) e para celulares (Android e IOS). Para download do IRPF 2019: <a href=\"ï¿½?ï¿½http://receita.economia.gov.br/interface/cidadao/irpf/2019/downloadï¿½?ï¿½\">http://receita.economia.gov.br/interface/cidadao/irpf/2019/download</a></p>', 20, 1, 16, 1, 1, 2, '2018-02-23 00:00:00', '2019-03-01 13:30:15'),
(8, 'CalendÃ¡rio de ObrigaÃ§Ãµes - marÃ§o de 2019', '<p><strong>EmpresÃ¡rio</strong>, vocÃª conhece suas obrigaÃ§Ãµes para o mÃªs de marÃ§o?</p>', '<p>O mÃªs de marÃ§o/19 jÃ¡ comeÃ§a com compromissos legais logo apÃ³s a quarta-feira de cinzas. JÃ¡ na quinta-feira, dia 07/03, deverÃ¡ ser pago os salÃ¡rios dos empregados, o FGTS, a GFIP e o Simples DomÃ©stica. Dai entÃ£o, as obrigaÃ§Ãµes se concentram nos dias 15, 18, 20, 25 e 29.&nbsp;</p><p>&nbsp;</p>', 'ipac-calendario-de-obrigacoes-201903-v2.jpg', 'calendario-obrigacoes-201903', 'calendÃ¡rio de obrigaÃ§Ãµes, marÃ§o, 2019, impostos, FGTS, Simples DomÃ©stica, GFIP, DCTF WEB, EFD-Reinf, EFD ContribuiÃ§Ãµes, IRRF sobre a Folha, INSS, CSRF, IRRF, Simples Nacional, 	Difal, Bolsa UniversitÃ¡ria, Fitur, ', 'CalendÃ¡rio de obrigaÃ§Ãµes de marÃ§o de 2019', 'CalendÃ¡rio de ObrigaÃ§Ãµes - 201903', '<p><strong>EmpresÃ¡rio</strong>, conheÃ§a as obrigaÃ§Ãµes do mÃªs de marÃ§o de 2019.</p>', 0, 1, 16, 1, 1, 3, '2019-02-28 14:20:33', '2019-03-01 13:30:30'),
(5, 'IRPF 2019 - Divulgada as datas da restituiÃ§Ã£o do imposto sobre a renda da pessoa fÃ­sica', '<p>A Receita Federal do Brasil divulgou as datas da restituiÃ§Ã£o do Imposto sobre a Renda da Pessoa FÃ­sica (IRPF), referente ao exercÃ­cio de 2019, ano-calendÃ¡rio de 2018, conforme cronograma abaixo, que serÃ£o priorizadas pela ordem de entrega das DIRPF 2019.</p>', '<p>A Receita Federal do Brasil divulgou as datas da restituiÃ§Ã£o do Imposto sobre a Renda da Pessoa FÃ­sica (IRPF), referente ao exercÃ­cio de 2019, ano-calendÃ¡rio de 2018, conforme cronograma abaixo, que serÃ£o priorizadas pela ordem de entrega das IRPF 2019.</p><p>1Âº lote, em 17/06/19<br>2Âº lote, em 15/07/19<br>3Âº lote, em 15/08/19<br>4Âº lote, em 16/09/19<br>5Âº lote, em 15/10/19<br>6Âº lote, em 18/11/19<br>7Âº lote, em 16/12/19</p><p>Veja mais sobre o Ato DeclaratÃ³rio Executivo Corec 1/2019, da Receita Federal do Brasil, que regulamenta o cronograma de restituiÃ§Ãµes.</p><p><a href=\"http://www.normaslegais.com.br/legislacao/ato-declaratorio-executivo-corec-1-2019.htm?fbclid=IwAR0MvNcjGAU0FXYoemvtFJUHIld_SvKouYcc5prd7wdJKTZrme0nvAIQOHs\">(http://www.normaslegais.com.br/â€¦/ato-declaratorio-executivoâ€¦)</a></p><p>IPAC Contabilidade, a assessoria que sua Empresa precisa.</p>', 'ipac-irpf-2019-2018-v01.jpg', 'entrega-das-irpf-2019', 'irpf, restituiÃ§Ã£o, imposto pessoa fÃ­sica, renda pessoa fÃ­sica,', 'A Receita Federal do Brasil divulgou as datas da restituiÃ§Ã£o do Imposto sobre a Renda da Pessoa FÃ­sica (IRPF), referente ao exercÃ­cio de 2019', 'IRPF 2019 - Divulgada as datas da restituiÃ§Ã£o do', '<p>A Receita Federal do Brasil divulgou as datas da restituiÃ§Ã£o do Imposto sobre a Renda da Pessoa FÃ­sica (IRPF), referente ao exercÃ­cio de 2019, ano-calendÃ¡rio de 2018, conforme cronograma abaixo, que serÃ£o priorizadas pela ordem de entrega das DIRPF 2019.</p>', 0, 1, 14, 1, 1, 2, '2019-02-26 16:21:14', '2019-03-01 13:08:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_carousels`
--

CREATE TABLE `sts_carousels` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posicao_text` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titulo_botao` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordem` int(11) NOT NULL,
  `adms_cor_id` int(11) DEFAULT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_carousels`
--

INSERT INTO `sts_carousels` (`id`, `nome`, `imagem`, `titulo`, `descricao`, `posicao_text`, `titulo_botao`, `link`, `ordem`, `adms_cor_id`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Sobre Empresa', 'node-wallpaper.jpg', 'Sobre Empresa', 'Cras justo odio, dapibus ac facilisis in, engestas eget quam. Donec id elit non.Cras justo odio, dapibus ac facilisis in, engestas eget quam. Donec id elit non.', 'text-left', 'Mais detalhes', 'http://localhost/dhemes_PDO/sobre-empresa', 1, 1, 1, '2019-01-20 00:00:00', '2019-02-22 16:39:46'),
(2, 'Segundo Exemplo', 'imagem_dois.jpg', 'Examle headline2', 'Justo odio, dapibus ac facilisis in, engestas eget quam. Donec id elit non.\r\nCras justo odio, dapibus ac facilisis in, engestas eget quam. Donec id elit non.\r\n', 'text-center', 'Inscrever-se', 'https://dhemes.com.br/', 2, 5, 1, '2019-01-20 00:00:00', NULL),
(3, 'Terceiro Exemplo', 'imagem_tres.jpg', 'Examle headline3', 'Dapibus ac facilisis in, engestas eget quam. Donec id elit non.\r\nCras justo odio, dapibus ac facilisis in, engestas eget quam. Donec id elit non.\r\n', 'text-right', 'Comprar', 'https://dhemes.com.br/', 3, 3, 1, '2019-01-20 00:00:00', '2019-02-18 00:54:15'),
(5, 'Teste', 'about4-min.jpg', 'teste', 'teste', 'text-center', 'teste', 'testes', 4, 6, 1, '2019-02-22 17:37:51', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_cats_artigos`
--

CREATE TABLE `sts_cats_artigos` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `sts_situacoe_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_cats_artigos`
--

INSERT INTO `sts_cats_artigos` (`id`, `nome`, `sts_situacoe_id`, `created`, `modified`) VALUES
(1, 'Sem categoria', 1, '2018-02-23 00:00:00', NULL),
(2, 'IRPF 2019', 1, '2018-02-23 00:00:00', NULL),
(3, 'CalendÃ¡rio de ObrigaÃ§Ãµes', 1, '2018-02-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_confs_emails`
--

CREATE TABLE `sts_confs_emails` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `smtpsecure` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `porta` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sts_confs_emails`
--

INSERT INTO `sts_confs_emails` (`id`, `nome`, `email`, `host`, `usuario`, `senha`, `smtpsecure`, `porta`, `created`, `modified`) VALUES
(1, 'IPAC Contabilidade', 'contato@ipaconline.com.br', 'mail.ipaconline.com.br', 'contato@ipaconline.com.br', 'ipac123', 'ssl', 465, '2019-02-25 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_contatos`
--

CREATE TABLE `sts_contatos` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `assunto` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_contatos`
--

INSERT INTO `sts_contatos` (`id`, `nome`, `email`, `assunto`, `mensagem`, `created`, `modified`) VALUES
(1, 'Dhemes', 'dhemes@gmail.com', 'teste1', 'msg teste 1', '2019-01-24 09:48:04', NULL),
(2, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste', 'testes envio', '2019-01-24 21:45:11', NULL),
(3, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste', 'teste de envio', '2019-01-24 21:44:56', NULL),
(4, 'Teste 4', 'dhemes.mota@gmail.com', 'teste 4 assunto', 'teste de envio do teste 4', '2019-01-24 21:57:33', NULL),
(5, 'Teste 5', 'dhemes.mota@gmail.com', 'teste 5 assuntos', 'assunto 5', '2019-01-24 22:06:53', NULL),
(21, 'Allysson Carvalho', 'dhemes.mota@gmail.com', 'Criar um site comercial', 'OlÃ¡, tenho mÃ¡xima urgÃªncia em um desenvolvimento de um site comercial.', '2019-02-20 09:52:57', NULL),
(8, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 44 assunto', 'descriÃ§Ã£o', '2019-01-24 22:13:28', NULL),
(9, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste', 'testeeeee', '2019-01-24 22:20:17', NULL),
(10, 'Dhemes Mota outro', 'dhemes.mota@gmail.com', 'teste', 'testeeeee', '2019-01-24 22:22:27', NULL),
(11, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 4 assunto', 'hihihih', '2019-01-24 22:23:07', NULL),
(12, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 4 assunto', 'hihihih', '2019-01-24 22:30:51', NULL),
(13, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 4 assunto', 'hihihih', '2019-01-24 22:37:22', NULL),
(14, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 4 assunto', 'hihihih', '2019-01-24 22:38:07', NULL),
(17, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 55 assuntos', 'teste', '2019-01-25 09:08:35', NULL),
(18, 'Dhemes Mota', 'dhemes.mota@gmail.com', 'teste 55 assuntos', 'teste', '2019-01-25 09:20:42', NULL),
(19, 'Realizar Novo', 'dhemes.mota@gmail.com', 'teste', 'teste', '2019-01-25 22:16:25', NULL),
(20, 'Realizar Novo', 'dhemes.mota@gmail.com', 'teste', 'testeee', '2019-02-08 22:07:23', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_paginas`
--

CREATE TABLE `sts_paginas` (
  `id` int(11) NOT NULL,
  `controller` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `nome_pagina` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lib_bloq` int(11) NOT NULL DEFAULT 2,
  `ordem` int(11) NOT NULL,
  `sts_tps_pg_id` int(11) NOT NULL,
  `sts_robot_id` int(11) NOT NULL,
  `sts_situacaos_pg_id` int(11) NOT NULL DEFAULT 2,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_paginas`
--

INSERT INTO `sts_paginas` (`id`, `controller`, `endereco`, `nome_pagina`, `titulo`, `obs`, `keywords`, `description`, `author`, `imagem`, `lib_bloq`, `ordem`, `sts_tps_pg_id`, `sts_robot_id`, `sts_situacaos_pg_id`, `created`, `modified`) VALUES
(1, 'Home', 'home', 'Pagina Inicial', 'Home - IPAC', 'Pagina inicial do site do projeto sts', 'noticias , contabilidade, clt, etc.', 'Site de noticias sobre auditoria contabel.', 'Dhemes Mota', 'home.jpg', 1, 1, 1, 1, 1, '2019-02-17 00:00:00', NULL),
(2, 'SobreEmpresa', 'sobre-empresa', 'Sobre Empresa', 'Sobre Empresa', 'Pagina sobre empresa do site do projeto sts', 'sobre a empresa ', 'A empresa IPAC contabilidade', 'Dhemes Mota', 'sobre_empresa.jpg', 1, 2, 1, 1, 1, '2019-02-17 00:00:00', NULL),
(3, 'Blog', 'blog', 'Blog', 'Blog', 'Pagina blog do site do projeto sts', 'Ultimas noticias, noticias sobre...', 'Ultimas noticias sobre...', 'Dhemes Mota', 'noticia.jpg', 1, 3, 1, 1, 1, '2019-02-17 00:00:00', NULL),
(4, 'Artigo', 'artigo', 'Artigo', 'Artigo', 'Pagina para ver o artigo inteiro no site do projeto sts', 'Atualizacoes, contabilidade, informacoes', 'Informacoes', 'Dhemes Mota', 'artigo.jpg', 2, 4, 1, 1, 1, '2019-02-17 00:00:00', NULL),
(5, 'Contato', 'contato', 'Contato', 'Contato', 'Pagina contato no site do projeto sts', 'contato, contato com,...', 'Formulario de contato...', 'Dhemes Mota', 'contato.jpg', 1, 5, 1, 1, 1, '2019-02-17 00:00:00', NULL),
(6, 'Noticia', 'noticia', 'Notícia', 'Notícia', 'Pagina para ver a noticia inteiro no site do projeto sts', 'Atualizacoes, contabilidade, informacoes', 'Informacoes', 'Dhemes Mota', 'artigo.jpg', 2, 4, 1, 1, 1, '2019-02-17 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_robots`
--

CREATE TABLE `sts_robots` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_robots`
--

INSERT INTO `sts_robots` (`id`, `nome`, `tipo`, `created`, `modified`) VALUES
(1, 'Indexar a pÃ¡gina e seguir os links', 'index,follow', '2019-02-17 00:00:00', NULL),
(2, 'NÃ£o indexar a pÃ¡gina mas seguir os links', 'noindex,follow', '2019-02-17 00:00:00', NULL),
(3, 'Indexar a pÃ¡gina mas nÃ£o seguir os links', 'index,nofollow', '2019-02-17 00:00:00', NULL),
(4, 'NÃ£o indexar a pÃ¡gina e nem seguir os links', 'noindex,nofollow', '2019-02-17 00:00:00', NULL),
(5, 'NÃ£o exibir a versÃ£o em cache da pÃ¡gina', 'noarchive', '2019-02-17 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_seo`
--

CREATE TABLE `sts_seo` (
  `id` int(11) NOT NULL,
  `og_site_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `og_locale` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `fb_admins` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_site` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_seo`
--

INSERT INTO `sts_seo` (`id`, `og_site_name`, `og_locale`, `fb_admins`, `twitter_site`, `created`, `modified`) VALUES
(1, 'IPAC Contabilidade', 'pt_BR', '2002711386491498', '@ipaconline', '2019-02-17 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_servicos`
--

CREATE TABLE `sts_servicos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone_um` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nome_um` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `descricao_um` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone_dois` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nome_dois` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `descricao_dois` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone_tres` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nome_tres` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `descricao_tres` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_servicos`
--

INSERT INTO `sts_servicos` (`id`, `titulo`, `icone_um`, `nome_um`, `descricao_um`, `icone_dois`, `nome_dois`, `descricao_dois`, `icone_tres`, `nome_tres`, `descricao_tres`, `created`, `modified`) VALUES
(1, 'ServiÃ§os', 'ion-ios-camera-outline', 'Sites', 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.', 'ion-ios-film-outline', 'Sistemas', 'This card has supporting text below as a natural lead-in to additional content.', 'ion-ios-videocam-outline', 'Linguagens', 'This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.', '2019-01-23 00:00:00', '2019-02-18 01:05:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_situacaos_pgs`
--

CREATE TABLE `sts_situacaos_pgs` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_situacaos_pgs`
--

INSERT INTO `sts_situacaos_pgs` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2019-02-17 00:00:00', NULL),
(2, 'Inativo', 5, '2019-02-17 00:00:00', NULL),
(3, 'Analise', 1, '2019-02-17 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_sobres`
--

CREATE TABLE `sts_sobres` (
  `id` int(11) NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_sobres`
--

INSERT INTO `sts_sobres` (`id`, `titulo`, `descricao`, `imagem`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Sobre Autor', 'Nos Ãºltimos anos, com a expansÃ£o de tecnologias em geral, muitas empresas comeÃ§aram a investir na criaÃ§Ã£o de sites, aplicativos e softwares, tudo isso com a intenÃ§Ã£o de estreitar ainda mais o laÃ§o entre as marcas e os consumidores. Para facilitar essa aproximaÃ§Ã£o, foi necessÃ¡rio entender os inÃºmeros pontos que fazem parte de uma interaÃ§Ã£o positiva entre o consumidor e a empresa no meio digital.\r\n', 'dhemes.jpg', 1, '2019-02-16 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_sobs_emps`
--

CREATE TABLE `sts_sobs_emps` (
  `id` int(11) NOT NULL,
  `titulo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_sobs_emps`
--

INSERT INTO `sts_sobs_emps` (`id`, `titulo`, `descricao`, `imagem`, `ordem`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Sobre empresa um', 'Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.                                                            ', 'empresa.jpg', 1, 1, '2019-01-24 00:00:00', '2019-02-18 10:01:12'),
(2, 'Sobre empresa dois.', 'Descricao sobre empresa 2 Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.', 'empresa.jpg', 2, 1, '2019-01-24 00:00:00', NULL),
(3, 'Sobre empresa tres.', 'Descricao sobre empresa 3 Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.', 'empresa.jpg', 3, 1, '2019-01-24 00:00:00', '2019-02-18 10:11:34'),
(4, 'Sobre empresa quatro.', 'Descricao sobre empresa 4 Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.', 'empresa.jpg', 4, 1, '2019-01-24 00:00:00', '2019-02-18 10:12:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_tps_artigos`
--

CREATE TABLE `sts_tps_artigos` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_tps_artigos`
--

INSERT INTO `sts_tps_artigos` (`id`, `nome`, `created`, `modified`) VALUES
(1, 'Publico', '2018-02-23 00:00:00', NULL),
(2, 'Privado', '2018-02-23 00:00:00', NULL),
(3, 'Privado com resumo publico', '2018-02-23 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_tps_pgs`
--

CREATE TABLE `sts_tps_pgs` (
  `id` int(11) NOT NULL,
  `tipo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_tps_pgs`
--

INSERT INTO `sts_tps_pgs` (`id`, `tipo`, `nome`, `obs`, `ordem`, `created`, `modified`) VALUES
(1, 'sts', 'Site Principal', 'Core do site principal', 1, '2019-02-17 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sts_videos`
--

CREATE TABLE `sts_videos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `sts_videos`
--

INSERT INTO `sts_videos` (`id`, `titulo`, `descricao`, `video`, `created`, `modified`) VALUES
(1, 'VÃ­deo', 'This is a wider card with supporting text below as a natural lead-in to additional content!', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Ofktsne-utM\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-01-24 00:00:00', '2019-02-18 09:36:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adms_cads_usuarios`
--
ALTER TABLE `adms_cads_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_cors`
--
ALTER TABLE `adms_cors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_grps_pgs`
--
ALTER TABLE `adms_grps_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_menus`
--
ALTER TABLE `adms_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_nivacs_pgs`
--
ALTER TABLE `adms_nivacs_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_niveis_acessos`
--
ALTER TABLE `adms_niveis_acessos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_paginas`
--
ALTER TABLE `adms_paginas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_robots`
--
ALTER TABLE `adms_robots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits`
--
ALTER TABLE `adms_sits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits_pgs`
--
ALTER TABLE `adms_sits_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_sits_usuarios`
--
ALTER TABLE `adms_sits_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_tps_pgs`
--
ALTER TABLE `adms_tps_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adms_usuarios`
--
ALTER TABLE `adms_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curriculo`
--
ALTER TABLE `curriculo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_artigos`
--
ALTER TABLE `sts_artigos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_carousels`
--
ALTER TABLE `sts_carousels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_cats_artigos`
--
ALTER TABLE `sts_cats_artigos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_confs_emails`
--
ALTER TABLE `sts_confs_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_contatos`
--
ALTER TABLE `sts_contatos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_paginas`
--
ALTER TABLE `sts_paginas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_robots`
--
ALTER TABLE `sts_robots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_seo`
--
ALTER TABLE `sts_seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_servicos`
--
ALTER TABLE `sts_servicos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_situacaos_pgs`
--
ALTER TABLE `sts_situacaos_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_sobres`
--
ALTER TABLE `sts_sobres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_sobs_emps`
--
ALTER TABLE `sts_sobs_emps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_tps_artigos`
--
ALTER TABLE `sts_tps_artigos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_tps_pgs`
--
ALTER TABLE `sts_tps_pgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sts_videos`
--
ALTER TABLE `sts_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adms_cads_usuarios`
--
ALTER TABLE `adms_cads_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adms_cors`
--
ALTER TABLE `adms_cors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `adms_grps_pgs`
--
ALTER TABLE `adms_grps_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `adms_menus`
--
ALTER TABLE `adms_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `adms_nivacs_pgs`
--
ALTER TABLE `adms_nivacs_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=621;

--
-- AUTO_INCREMENT for table `adms_niveis_acessos`
--
ALTER TABLE `adms_niveis_acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `adms_paginas`
--
ALTER TABLE `adms_paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `adms_sits`
--
ALTER TABLE `adms_sits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `adms_sits_pgs`
--
ALTER TABLE `adms_sits_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `adms_sits_usuarios`
--
ALTER TABLE `adms_sits_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `adms_tps_pgs`
--
ALTER TABLE `adms_tps_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `adms_usuarios`
--
ALTER TABLE `adms_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `curriculo`
--
ALTER TABLE `curriculo`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `sts_artigos`
--
ALTER TABLE `sts_artigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sts_carousels`
--
ALTER TABLE `sts_carousels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sts_confs_emails`
--
ALTER TABLE `sts_confs_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sts_contatos`
--
ALTER TABLE `sts_contatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sts_paginas`
--
ALTER TABLE `sts_paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sts_robots`
--
ALTER TABLE `sts_robots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sts_seo`
--
ALTER TABLE `sts_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sts_servicos`
--
ALTER TABLE `sts_servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sts_situacaos_pgs`
--
ALTER TABLE `sts_situacaos_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sts_sobres`
--
ALTER TABLE `sts_sobres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sts_sobs_emps`
--
ALTER TABLE `sts_sobs_emps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sts_tps_pgs`
--
ALTER TABLE `sts_tps_pgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sts_videos`
--
ALTER TABLE `sts_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
