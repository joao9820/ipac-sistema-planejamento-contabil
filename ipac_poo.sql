-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 27-Mar-2019 às 13:04
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipac_poo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_atendimentos`
--

DROP TABLE IF EXISTS `adms_atendimentos`;
CREATE TABLE IF NOT EXISTS `adms_atendimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adms_demanda_id` int(11) NOT NULL,
  `adms_sits_atendimento_id` int(11) NOT NULL,
  `arquivado` int(11) NOT NULL DEFAULT '2',
  `descricao` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_usuario_id` int(11) NOT NULL,
  `cancelado_p_user` int(11) NOT NULL DEFAULT '2',
  `adms_empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `adms_funcionario_id` int(11) DEFAULT NULL,
  `adms_sits_atendimentos_funcionario_id` int(11) NOT NULL DEFAULT '1',
  `data_fatal` date DEFAULT NULL,
  `prioridade` int(11) NOT NULL DEFAULT '2',
  `arquivado_gerente` int(11) NOT NULL DEFAULT '2',
  `duracao_atendimento` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inicio_atendimento` datetime DEFAULT NULL,
  `fim_atendimento` datetime DEFAULT NULL,
  `at_iniciado` datetime DEFAULT NULL,
  `at_pausado` datetime DEFAULT NULL,
  `at_tempo_restante` time DEFAULT NULL,
  `at_tempo_excedido` time DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_atendimentos`
--

INSERT INTO `adms_atendimentos` (`id`, `adms_demanda_id`, `adms_sits_atendimento_id`, `arquivado`, `descricao`, `adms_usuario_id`, `cancelado_p_user`, `adms_empresa_id`, `created`, `adms_funcionario_id`, `adms_sits_atendimentos_funcionario_id`, `data_fatal`, `prioridade`, `arquivado_gerente`, `duracao_atendimento`, `inicio_atendimento`, `fim_atendimento`, `at_iniciado`, `at_pausado`, `at_tempo_restante`, `at_tempo_excedido`, `modified`) VALUES
(1, 1, 2, 2, 'Primeiro atendimento de teste.', 1, 2, 1, '2019-01-31 19:45:38', 44, 3, NULL, 1, 2, '03:00:00', '2019-02-20 13:43:11', NULL, '2019-03-18 16:47:55', '2019-03-18 16:47:58', '00:00:00', '00:22:35', '2019-03-25 16:42:21'),
(2, 1, 4, 1, 'AtualizaÃ§Ã£o urgente.', 1, 2, 1, '2019-01-31 19:46:45', 5, 1, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-02-20 15:08:39'),
(3, 1, 2, 2, 'Teste cliente', 46, 2, 1, '2019-02-03 16:51:16', 12, 4, '2019-03-28', 2, 2, '03:00:00', '2019-02-18 13:04:15', '2019-02-20 16:41:22', '2019-02-20 14:11:22', '2019-02-20 14:11:31', '00:00:00', '00:07:38', '2019-03-27 12:46:55'),
(4, 4, 4, 2, 'Novo teste', 1, 2, 2, '2019-02-12 15:51:28', 5, 4, NULL, 2, 2, '15:23:00', '2019-02-19 12:56:44', '2019-02-20 17:49:11', '2019-02-20 17:46:01', '2019-02-20 14:22:02', '14:20:42', NULL, '2019-02-21 14:08:37'),
(5, 4, 2, 2, 'Atendimento normal', 1, 2, 2, '2019-02-20 17:54:05', 5, 3, NULL, 2, 2, '09:17:00', '2019-02-21 16:56:48', NULL, '2019-03-26 15:21:35', '2019-03-26 15:26:19', '09:08:48', NULL, '2019-03-26 15:26:19'),
(6, 1, 4, 1, 'descriÃ§Ã£o', 1, 2, 1, '2019-02-21 12:58:25', 5, 4, NULL, 2, 2, '03:00:00', '2019-02-21 12:59:51', '2019-02-21 13:01:18', '2019-02-21 13:00:11', '2019-02-21 13:00:16', '02:59:40', NULL, '2019-03-25 17:56:27'),
(7, 1, 2, 2, 'NOvooo', 1, 2, 1, '2019-02-21 16:58:45', 5, 4, NULL, 2, 2, '04:00:00', '2019-02-21 16:59:06', '2019-03-26 14:10:21', '2019-03-26 14:10:17', '2019-02-22 11:44:24', '03:34:50', NULL, '2019-03-26 14:10:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_atividades`
--

DROP TABLE IF EXISTS `adms_atividades`;
CREATE TABLE IF NOT EXISTS `adms_atividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `duracao` time NOT NULL,
  `ordem` int(11) DEFAULT NULL,
  `adms_demanda_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_atividades`
--

INSERT INTO `adms_atividades` (`id`, `nome`, `descricao`, `duracao`, `ordem`, `adms_demanda_id`, `created`, `modified`) VALUES
(1, 'AtualizaÃ§Ã£o ContÃ¡bil', 'AtualizaÃ§Ã£o contÃ¡bil mensal dos lanÃ§amentos manuais', '01:15:00', 5, 1, '2019-01-28 00:00:00', '2019-02-18 12:26:57'),
(3, 'ReuniÃ£o De Analise SocietÃ¡ria', 'ReuniÃ£o entre o gestor empresarial e o contador para anÃ¡lise contÃ¡bil', '00:15:00', 2, 1, '2019-01-29 00:00:00', '2019-02-06 15:01:49'),
(5, 'ImportaÃ§Ã£o Dos Arquivos Do Folha', 'Referente a importaÃ§Ã£o dos arquivos do fiscal e da folha para p sistema contÃ¡bil.', '02:15:00', 3, 1, '2019-01-29 14:01:55', '2019-02-21 13:02:09'),
(17, 'Atividade 1', 'DescriÃ§Ã£o 2', '04:22:00', 1, 4, '2019-01-29 16:40:45', '2019-02-04 14:48:19'),
(9, 'ValidaÃ§Ã£o Gerencial Dos LanÃ§amento', 'Referente Ã  validaÃ§Ã£o gerencial dos registros contÃ¡beis mensais.', '00:15:00', 4, 1, '2019-01-29 16:13:23', '2019-02-06 15:01:27'),
(20, 'Teste atividade', 'DescriÃ§Ã£o de teste', '04:55:00', 2, 4, '2019-01-30 14:29:11', '2019-01-30 14:29:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cads_usuarios`
--

DROP TABLE IF EXISTS `adms_cads_usuarios`;
CREATE TABLE IF NOT EXISTS `adms_cads_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `env_email_conf` int(11) NOT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cads_usuarios`
--

INSERT INTO `adms_cads_usuarios` (`id`, `env_email_conf`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 1, 4, 3, '2019-01-22 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cargos`
--

DROP TABLE IF EXISTS `adms_cargos`;
CREATE TABLE IF NOT EXISTS `adms_cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cargo` (`cargo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cargos`
--

INSERT INTO `adms_cargos` (`id`, `cargo`, `descricao`, `created`, `modified`) VALUES
(1, 'EstagiÃ¡rio', NULL, '2019-03-21 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_confs_emails`
--

DROP TABLE IF EXISTS `adms_confs_emails`;
CREATE TABLE IF NOT EXISTS `adms_confs_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `smtpsecure` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `porta` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_confs_emails`
--

INSERT INTO `adms_confs_emails` (`id`, `nome`, `email`, `host`, `usuario`, `senha`, `smtpsecure`, `porta`, `created`, `modified`) VALUES
(1, 'IPAC Contabilidade', 'contato@ipaconline.com.br', 'mail.ipaconline.com.br', 'contato@ipaconline.com.br', 'ipac123', 'ssl', 465, '2019-01-22 00:00:00', '2019-02-03 13:44:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_cors`
--

DROP TABLE IF EXISTS `adms_cors`;
CREATE TABLE IF NOT EXISTS `adms_cors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_cors`
--

INSERT INTO `adms_cors` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Azul', 'primary', '2019-01-21 00:00:00', NULL),
(2, 'Cinza', 'secondary', '2019-01-21 00:00:00', NULL),
(3, 'Verde', 'success', '2019-01-21 00:00:00', NULL),
(4, 'Vermelho', 'danger', '2019-01-21 00:00:00', NULL),
(5, 'Laranjado', 'warning', '2019-01-21 00:00:00', NULL),
(6, 'Azul claro', 'info', '2019-01-21 00:00:00', NULL),
(7, 'Claro', 'light', '2019-01-21 00:00:00', NULL),
(8, 'Cinza escuro', 'dark', '2019-01-21 00:00:00', '2019-02-03 15:23:02');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_demandas`
--

DROP TABLE IF EXISTS `adms_demandas`;
CREATE TABLE IF NOT EXISTS `adms_demandas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_usuario_id` int(11) NOT NULL,
  `duracao_total` time DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_demandas`
--

INSERT INTO `adms_demandas` (`id`, `nome`, `descricao`, `adms_usuario_id`, `duracao_total`, `created`, `modified`) VALUES
(1, 'AtualizaÃ§Ã£o ContÃ¡bil Mensal', 'Referente Ã  atualizaÃ§Ã£o dos registros contÃ¡beis da empresa de um determinado mÃªs.', 1, NULL, '2019-01-28 00:00:00', '2019-01-30 15:03:21'),
(4, 'Teste Demanda Exemplo', 'Terceiro teste de cadastro de tipos de demandas. Agora com AcentuaÃ§Ã£o e caracteres especiais.', 1, NULL, '2019-01-28 14:17:46', '2019-02-04 14:48:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_departamentos`
--

DROP TABLE IF EXISTS `adms_departamentos`;
CREATE TABLE IF NOT EXISTS `adms_departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descricao` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_departamentos`
--

INSERT INTO `adms_departamentos` (`id`, `nome`, `icon`, `descricao`, `created`, `modified`) VALUES
(1, 'ContÃ¡bil\r\n', 'fas fa-calculator', NULL, '2019-03-21 00:00:00', NULL),
(2, 'Fiscal', 'fas fa-money-bill-alt', NULL, '2019-03-21 00:00:00', NULL),
(3, 'Folha', 'far fa-copy', NULL, '2019-03-21 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_empresas`
--

DROP TABLE IF EXISTS `adms_empresas`;
CREATE TABLE IF NOT EXISTS `adms_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `fantasia` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cnpj` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chave_descadastro` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conf_email` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_tps_empresa_id` int(11) NOT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_empresa_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_empresas`
--

INSERT INTO `adms_empresas` (`id`, `nome`, `fantasia`, `cnpj`, `email`, `usuario`, `senha`, `recuperar_senha`, `chave_descadastro`, `conf_email`, `imagem`, `adms_tps_empresa_id`, `adms_niveis_acesso_id`, `adms_sits_empresa_id`, `created`, `modified`) VALUES
(1, 'IPAC CONTABILIDADE', 'IPAC', '98123456000122', 'ipac@ipaconline.com.br', 'ipac@ipaconline.com.br', '123', NULL, NULL, NULL, NULL, 1, 1, 1, '2019-01-27 00:00:00', NULL),
(2, 'EMPRESA TESTE', 'TESTE EP', '12123456123478', 'empresateste@gmail.com', 'empresateste@gmail.com', '123', NULL, NULL, NULL, NULL, 2, 1, 1, '2019-01-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_grps_pgs`
--

DROP TABLE IF EXISTS `adms_grps_pgs`;
CREATE TABLE IF NOT EXISTS `adms_grps_pgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_grps_pgs`
--

INSERT INTO `adms_grps_pgs` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Listar', 1, '2019-01-21 00:00:00', NULL),
(2, 'Cadastrar', 2, '2019-01-21 00:00:00', NULL),
(3, 'Editar', 3, '2019-01-21 00:00:00', NULL),
(4, 'Apagar', 4, '2019-01-21 00:00:00', NULL),
(5, 'Visualizar', 5, '2019-01-21 00:00:00', NULL),
(6, 'Outros', 6, '2019-01-21 00:00:00', NULL),
(7, 'Acesso', 7, '2019-01-21 00:00:00', '2019-02-03 15:37:07'),
(8, 'Alterar Ordem', 8, '2019-01-28 00:00:00', '2019-02-03 15:37:07'),
(10, 'Cancelar', 9, '2019-02-04 12:19:51', NULL),
(11, 'Arquivar', 10, '2019-02-05 12:27:08', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_logs_atendimentos`
--

DROP TABLE IF EXISTS `adms_logs_atendimentos`;
CREATE TABLE IF NOT EXISTS `adms_logs_atendimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_log` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `adms_atendimento_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=376 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_logs_atendimentos`
--

INSERT INTO `adms_logs_atendimentos` (`id`, `status_log`, `adms_atendimento_id`, `created`, `modified`) VALUES
(1, 'Iniciado', 4, '2019-02-15 16:49:50', NULL),
(2, 'Iniciado', 3, '2019-02-15 16:49:59', NULL),
(3, 'Iniciado', 3, '2019-02-15 16:52:28', NULL),
(4, 'Iniciado', 3, '2019-02-15 16:52:33', NULL),
(5, 'Iniciado', 4, '2019-02-15 17:09:47', NULL),
(6, 'Iniciado', 4, '2019-02-15 17:11:23', NULL),
(7, 'Iniciado', 4, '2019-02-15 17:12:32', NULL),
(8, 'Iniciado', 4, '2019-02-15 17:13:42', NULL),
(9, 'Iniciado', 4, '2019-02-15 17:14:05', NULL),
(10, 'Pausado', 4, '2019-02-15 17:19:04', NULL),
(11, 'Iniciado', 4, '2019-02-15 17:19:19', NULL),
(12, 'Pausado', 4, '2019-02-15 17:19:21', NULL),
(13, 'Iniciado', 4, '2019-02-15 17:19:25', NULL),
(14, 'Pausado', 4, '2019-02-15 17:19:29', NULL),
(15, 'Iniciado', 4, '2019-02-15 17:22:59', NULL),
(16, 'Pausado', 4, '2019-02-15 17:41:44', NULL),
(17, 'Iniciado', 3, '2019-02-15 17:41:46', NULL),
(18, 'Pausado', 3, '2019-02-15 17:41:54', NULL),
(19, 'Iniciado', 4, '2019-02-15 17:41:55', NULL),
(20, 'Pausado', 4, '2019-02-15 17:42:41', NULL),
(21, 'Iniciado', 4, '2019-02-15 17:42:43', NULL),
(22, 'Pausado', 4, '2019-02-15 17:42:45', NULL),
(23, 'Iniciado', 1, '2019-02-15 17:42:48', NULL),
(24, 'Pausado', 1, '2019-02-15 17:42:56', NULL),
(25, 'Iniciado', 4, '2019-02-15 17:42:57', NULL),
(26, 'Pausado', 4, '2019-02-15 17:50:26', NULL),
(27, 'Iniciado', 4, '2019-02-15 17:50:39', NULL),
(28, 'Pausado', 4, '2019-02-18 12:15:45', NULL),
(29, 'Iniciado', 3, '2019-02-18 12:15:47', NULL),
(30, 'Iniciado', 3, '2019-02-18 12:16:15', NULL),
(31, 'Iniciado', 3, '2019-02-18 12:18:09', NULL),
(32, 'Iniciado', 3, '2019-02-18 12:18:29', NULL),
(33, 'Iniciado', 3, '2019-02-18 12:22:38', NULL),
(34, 'Iniciado', 3, '2019-02-18 12:22:57', NULL),
(35, 'Iniciado', 3, '2019-02-18 12:22:58', NULL),
(36, 'Iniciado', 3, '2019-02-18 12:22:59', NULL),
(37, 'Iniciado', 3, '2019-02-18 12:22:59', NULL),
(38, 'Iniciado', 3, '2019-02-18 12:22:59', NULL),
(39, 'Iniciado', 3, '2019-02-18 12:22:59', NULL),
(40, 'Iniciado', 3, '2019-02-18 12:22:59', NULL),
(41, 'Iniciado', 3, '2019-02-18 12:23:00', NULL),
(42, 'Iniciado', 3, '2019-02-18 12:23:00', NULL),
(43, 'Iniciado', 3, '2019-02-18 12:23:33', NULL),
(44, 'Iniciado', 3, '2019-02-18 12:24:04', NULL),
(45, 'Iniciado', 3, '2019-02-18 12:24:06', NULL),
(46, 'Iniciado', 3, '2019-02-18 12:24:06', NULL),
(47, 'Iniciado', 3, '2019-02-18 12:24:23', NULL),
(48, 'Iniciado', 3, '2019-02-18 12:24:34', NULL),
(49, 'Iniciado', 3, '2019-02-18 12:24:45', NULL),
(50, 'Iniciado', 3, '2019-02-18 12:25:08', NULL),
(51, 'Iniciado', 3, '2019-02-18 12:25:14', NULL),
(52, 'Iniciado', 3, '2019-02-18 12:25:58', NULL),
(53, 'Iniciado', 3, '2019-02-18 12:27:00', NULL),
(54, 'Iniciado', 3, '2019-02-18 12:33:37', NULL),
(55, 'Iniciado', 3, '2019-02-18 12:37:36', NULL),
(56, 'Iniciado', 3, '2019-02-18 12:38:52', NULL),
(57, 'Pausado', 3, '2019-02-18 12:39:21', NULL),
(58, 'Iniciado', 4, '2019-02-18 12:39:25', NULL),
(59, 'Pausado', 4, '2019-02-18 12:39:27', NULL),
(60, 'Iniciado', 3, '2019-02-18 13:04:15', NULL),
(61, 'Pausado', 3, '2019-02-18 13:36:18', NULL),
(62, 'Iniciado', 3, '2019-02-18 13:53:00', NULL),
(63, 'Pausado', 3, '2019-02-18 15:27:56', NULL),
(64, 'Pausado', 3, '2019-02-18 15:29:34', NULL),
(65, 'Pausado', 3, '2019-02-18 15:30:24', NULL),
(66, 'Pausado', 3, '2019-02-18 15:32:07', NULL),
(67, 'Pausado', 3, '2019-02-18 15:34:41', NULL),
(68, 'Pausado', 3, '2019-02-18 15:37:35', NULL),
(69, 'Pausado', 3, '2019-02-18 15:37:38', NULL),
(70, 'Pausado', 3, '2019-02-18 15:37:39', NULL),
(71, 'Pausado', 3, '2019-02-18 15:37:40', NULL),
(72, 'Pausado', 3, '2019-02-18 15:37:41', NULL),
(73, 'Pausado', 3, '2019-02-18 15:40:35', NULL),
(74, 'Pausado', 3, '2019-02-18 15:41:15', NULL),
(75, 'Pausado', 3, '2019-02-18 15:41:16', NULL),
(76, 'Pausado', 3, '2019-02-18 15:42:03', NULL),
(77, 'Pausado', 3, '2019-02-18 15:42:03', NULL),
(78, 'Pausado', 3, '2019-02-18 15:44:02', NULL),
(79, 'Pausado', 3, '2019-02-18 15:45:40', NULL),
(80, 'Pausado', 3, '2019-02-18 15:51:33', NULL),
(81, 'Pausado', 3, '2019-02-18 15:52:25', NULL),
(82, 'Pausado', 3, '2019-02-18 15:52:26', NULL),
(83, 'Pausado', 3, '2019-02-18 15:52:27', NULL),
(84, 'Pausado', 3, '2019-02-18 15:52:27', NULL),
(85, 'Pausado', 3, '2019-02-18 15:52:27', NULL),
(86, 'Pausado', 3, '2019-02-18 15:52:28', NULL),
(87, 'Pausado', 3, '2019-02-18 15:52:28', NULL),
(88, 'Pausado', 3, '2019-02-18 15:52:28', NULL),
(89, 'Pausado', 3, '2019-02-18 15:52:28', NULL),
(90, 'Pausado', 3, '2019-02-18 15:52:28', NULL),
(91, 'Pausado', 3, '2019-02-18 15:52:29', NULL),
(92, 'Pausado', 3, '2019-02-18 15:52:29', NULL),
(93, 'Pausado', 3, '2019-02-18 15:53:36', NULL),
(94, 'Pausado', 3, '2019-02-18 15:54:05', NULL),
(95, 'Pausado', 3, '2019-02-18 15:54:55', NULL),
(96, 'Pausado', 3, '2019-02-18 15:55:16', NULL),
(97, 'Pausado', 3, '2019-02-18 15:56:37', NULL),
(98, 'Pausado', 3, '2019-02-18 15:56:45', NULL),
(99, 'Pausado', 3, '2019-02-18 15:56:46', NULL),
(100, 'Pausado', 3, '2019-02-18 15:56:47', NULL),
(101, 'Pausado', 3, '2019-02-18 15:56:50', NULL),
(102, 'Pausado', 3, '2019-02-18 15:56:50', NULL),
(103, 'Pausado', 3, '2019-02-18 15:56:51', NULL),
(104, 'Pausado', 3, '2019-02-18 15:56:52', NULL),
(105, 'Pausado', 3, '2019-02-18 15:58:14', NULL),
(106, 'Pausado', 3, '2019-02-18 15:59:50', NULL),
(107, 'Pausado', 3, '2019-02-18 16:02:54', NULL),
(108, 'Pausado', 3, '2019-02-18 16:04:20', NULL),
(109, 'Pausado', 3, '2019-02-18 16:07:07', NULL),
(110, 'Iniciado', 3, '2019-02-18 16:11:05', NULL),
(111, 'Pausado', 3, '2019-02-18 16:12:07', NULL),
(112, 'Iniciado', 1, '2019-02-18 16:25:07', NULL),
(113, 'Pausado', 1, '2019-02-18 16:25:53', NULL),
(114, 'Iniciado', 1, '2019-02-18 16:26:09', NULL),
(115, 'Pausado', 1, '2019-02-18 16:27:08', NULL),
(116, 'Iniciado', 3, '2019-02-18 16:27:46', NULL),
(117, 'Pausado', 3, '2019-02-18 16:27:57', NULL),
(118, 'Iniciado', 3, '2019-02-18 16:43:06', NULL),
(119, 'Pausado', 3, '2019-02-18 16:46:30', NULL),
(120, 'Iniciado', 3, '2019-02-18 16:48:26', NULL),
(121, 'Pausado', 3, '2019-02-18 16:48:36', NULL),
(122, 'Iniciado', 1, '2019-02-18 16:49:09', NULL),
(123, 'Pausado', 1, '2019-02-18 16:50:07', NULL),
(124, 'Iniciado', 3, '2019-02-18 17:18:51', NULL),
(125, 'Pausado', 3, '2019-02-18 17:20:08', NULL),
(126, 'Iniciado', 3, '2019-02-18 17:22:06', NULL),
(127, 'Pausado', 3, '2019-02-18 17:38:49', NULL),
(128, 'Iniciado', 3, '2019-02-18 17:40:29', NULL),
(129, 'Pausado', 3, '2019-02-18 17:45:09', NULL),
(130, 'Iniciado', 3, '2019-02-18 17:46:50', NULL),
(131, 'Pausado', 3, '2019-02-18 17:49:52', NULL),
(132, 'Iniciado', 3, '2019-02-18 17:50:05', NULL),
(133, 'Pausado', 3, '2019-02-18 17:50:12', NULL),
(134, 'Iniciado', 3, '2019-02-19 12:25:19', NULL),
(135, 'Pausado', 3, '2019-02-19 12:29:26', NULL),
(136, 'Pausado', 3, '2019-02-19 12:30:37', NULL),
(137, 'Pausado', 3, '2019-02-19 12:30:43', NULL),
(138, 'Pausado', 3, '2019-02-19 12:31:32', NULL),
(139, 'Pausado', 3, '2019-02-19 12:31:38', NULL),
(140, 'Pausado', 3, '2019-02-19 12:31:41', NULL),
(141, 'Pausado', 3, '2019-02-19 12:32:17', NULL),
(142, 'Pausado', 3, '2019-02-19 12:32:54', NULL),
(143, 'Pausado', 3, '2019-02-19 12:32:56', NULL),
(144, 'Pausado', 3, '2019-02-19 12:33:27', NULL),
(145, 'Pausado', 3, '2019-02-19 12:34:14', NULL),
(146, 'Pausado', 3, '2019-02-19 12:34:25', NULL),
(147, 'Pausado', 3, '2019-02-19 12:34:28', NULL),
(148, 'Pausado', 3, '2019-02-19 12:37:56', NULL),
(149, 'Pausado', 3, '2019-02-19 12:38:26', NULL),
(150, 'Pausado', 3, '2019-02-19 12:39:09', NULL),
(151, 'Pausado', 3, '2019-02-19 12:39:16', NULL),
(152, 'Pausado', 3, '2019-02-19 12:39:18', NULL),
(153, 'Pausado', 3, '2019-02-19 12:39:49', NULL),
(154, 'Pausado', 3, '2019-02-19 12:40:13', NULL),
(155, 'Iniciado', 3, '2019-02-19 12:41:07', NULL),
(156, 'Pausado', 3, '2019-02-19 12:41:14', NULL),
(157, 'Iniciado', 3, '2019-02-19 12:51:05', NULL),
(158, 'Pausado', 3, '2019-02-19 12:53:00', NULL),
(159, 'Iniciado', 1, '2019-02-19 12:55:06', NULL),
(160, 'Pausado', 1, '2019-02-19 12:55:14', NULL),
(161, 'Iniciado', 4, '2019-02-19 12:56:44', NULL),
(162, 'Pausado', 4, '2019-02-19 12:57:02', NULL),
(163, 'Iniciado', 4, '2019-02-19 13:01:59', NULL),
(164, 'Pausado', 4, '2019-02-19 13:02:06', NULL),
(165, 'Iniciado', 1, '2019-02-19 13:02:09', NULL),
(166, 'Pausado', 1, '2019-02-19 13:02:16', NULL),
(167, 'Iniciado', 3, '2019-02-19 13:12:08', NULL),
(168, 'Pausado', 3, '2019-02-19 13:12:48', NULL),
(169, 'Iniciado', 3, '2019-02-19 13:12:54', NULL),
(170, 'Pausado', 3, '2019-02-19 13:12:58', NULL),
(171, 'Iniciado', 3, '2019-02-19 13:14:42', NULL),
(172, 'Pausado', 3, '2019-02-19 13:15:00', NULL),
(173, 'Iniciado', 4, '2019-02-19 13:15:10', NULL),
(174, 'Pausado', 4, '2019-02-19 13:15:28', NULL),
(175, 'Iniciado', 3, '2019-02-19 13:15:31', NULL),
(176, 'Pausado', 3, '2019-02-19 13:15:37', NULL),
(177, 'Iniciado', 1, '2019-02-19 13:17:20', NULL),
(178, 'Pausado', 1, '2019-02-19 13:19:08', NULL),
(179, 'Iniciado', 3, '2019-02-19 13:19:25', NULL),
(180, 'Pausado', 3, '2019-02-19 13:19:31', NULL),
(181, 'Iniciado', 3, '2019-02-19 13:23:43', NULL),
(182, 'Pausado', 3, '2019-02-19 13:23:57', NULL),
(183, 'Iniciado', 4, '2019-02-19 13:56:59', NULL),
(184, 'Pausado', 4, '2019-02-19 13:57:18', NULL),
(185, 'Iniciado', 4, '2019-02-19 13:59:17', NULL),
(186, 'Pausado', 4, '2019-02-19 13:59:44', NULL),
(187, 'Iniciado', 4, '2019-02-19 14:02:37', NULL),
(188, 'Pausado', 4, '2019-02-19 14:02:55', NULL),
(189, 'Iniciado', 4, '2019-02-19 14:03:29', NULL),
(190, 'Pausado', 4, '2019-02-19 14:03:43', NULL),
(191, 'Iniciado', 4, '2019-02-19 14:04:26', NULL),
(192, 'Pausado', 4, '2019-02-19 14:04:35', NULL),
(193, 'Iniciado', 4, '2019-02-19 14:07:25', NULL),
(194, 'Pausado', 4, '2019-02-19 14:07:34', NULL),
(195, 'Iniciado', 4, '2019-02-19 14:08:17', NULL),
(196, 'Pausado', 4, '2019-02-19 14:08:19', NULL),
(197, 'Iniciado', 4, '2019-02-19 14:08:23', NULL),
(198, 'Pausado', 4, '2019-02-19 14:08:46', NULL),
(199, 'Iniciado', 3, '2019-02-19 14:12:32', NULL),
(200, 'Pausado', 3, '2019-02-19 14:34:54', NULL),
(201, 'Iniciado', 3, '2019-02-19 14:35:52', NULL),
(202, 'Pausado', 3, '2019-02-19 14:36:59', NULL),
(203, 'Iniciado', 3, '2019-02-19 15:24:16', NULL),
(204, 'Pausado', 3, '2019-02-19 15:25:13', NULL),
(205, 'Iniciado', 4, '2019-02-19 15:44:43', NULL),
(206, 'Pausado', 4, '2019-02-19 16:03:30', NULL),
(207, 'Iniciado', 4, '2019-02-19 16:12:24', NULL),
(208, 'Pausado', 4, '2019-02-19 16:17:24', NULL),
(209, 'Iniciado', 3, '2019-02-19 16:17:27', NULL),
(210, 'Pausado', 3, '2019-02-19 16:17:32', NULL),
(211, 'Iniciado', 3, '2019-02-19 16:17:57', NULL),
(212, 'Pausado', 3, '2019-02-19 16:18:05', NULL),
(213, 'Iniciado', 4, '2019-02-19 16:18:07', NULL),
(214, 'Pausado', 4, '2019-02-19 16:18:54', NULL),
(215, 'Iniciado', 4, '2019-02-19 16:18:57', NULL),
(216, 'Pausado', 4, '2019-02-19 16:19:44', NULL),
(217, 'Iniciado', 4, '2019-02-19 16:20:09', NULL),
(218, 'Pausado', 4, '2019-02-19 16:20:49', NULL),
(219, 'Iniciado', 4, '2019-02-19 16:21:59', NULL),
(220, 'Pausado', 4, '2019-02-19 16:22:27', NULL),
(221, 'Iniciado', 4, '2019-02-19 16:22:32', NULL),
(222, 'Pausado', 4, '2019-02-19 16:22:42', NULL),
(223, 'Iniciado', 3, '2019-02-19 16:45:47', NULL),
(224, 'Pausado', 3, '2019-02-19 16:48:18', NULL),
(225, 'Iniciado', 3, '2019-02-19 16:51:29', NULL),
(226, 'Pausado', 3, '2019-02-19 16:54:25', NULL),
(227, 'Iniciado', 4, '2019-02-19 16:54:30', NULL),
(228, 'Pausado', 4, '2019-02-19 16:55:30', NULL),
(229, 'Iniciado', 3, '2019-02-19 17:45:57', NULL),
(230, 'Pausado', 3, '2019-02-19 17:46:12', NULL),
(231, 'Iniciado', 4, '2019-02-20 12:53:36', NULL),
(232, 'Pausado', 4, '2019-02-20 12:55:03', NULL),
(233, 'Iniciado', 4, '2019-02-20 13:01:06', NULL),
(234, 'Pausado', 4, '2019-02-20 13:01:09', NULL),
(235, 'Iniciado', 4, '2019-02-20 13:01:29', NULL),
(236, 'Pausado', 4, '2019-02-20 13:01:32', NULL),
(237, 'Iniciado', 4, '2019-02-20 13:04:55', NULL),
(238, 'Pausado', 4, '2019-02-20 13:07:37', NULL),
(239, 'Iniciado', 1, '2019-02-20 13:07:40', NULL),
(240, 'Pausado', 1, '2019-02-20 13:08:03', NULL),
(241, 'Iniciado', 4, '2019-02-20 13:13:38', NULL),
(242, 'Pausado', 4, '2019-02-20 13:13:48', NULL),
(243, 'Iniciado', 1, '2019-02-20 13:13:57', NULL),
(244, 'Pausado', 1, '2019-02-20 13:14:01', NULL),
(245, 'Iniciado', 4, '2019-02-20 13:21:07', NULL),
(246, 'Pausado', 4, '2019-02-20 13:31:51', NULL),
(247, 'Iniciado', 4, '2019-02-20 13:31:58', NULL),
(248, 'Pausado', 4, '2019-02-20 13:32:13', NULL),
(249, 'Iniciado', 4, '2019-02-20 13:35:08', NULL),
(250, 'Pausado', 4, '2019-02-20 13:35:26', NULL),
(251, 'Iniciado', 4, '2019-02-20 13:35:28', NULL),
(252, 'Pausado', 4, '2019-02-20 13:35:45', NULL),
(253, 'Iniciado', 4, '2019-02-20 13:35:47', NULL),
(254, 'Pausado', 4, '2019-02-20 13:43:06', NULL),
(255, 'Iniciado', 1, '2019-02-20 13:43:11', NULL),
(256, 'Pausado', 1, '2019-02-20 13:43:20', NULL),
(257, 'Iniciado', 4, '2019-02-20 13:47:13', NULL),
(258, 'Pausado', 4, '2019-02-20 13:47:20', NULL),
(259, 'Iniciado', 1, '2019-02-20 13:47:25', NULL),
(260, 'Pausado', 1, '2019-02-20 13:47:41', NULL),
(261, 'Iniciado', 3, '2019-02-20 13:51:06', NULL),
(262, 'Pausado', 3, '2019-02-20 13:51:15', NULL),
(263, 'Iniciado', 3, '2019-02-20 13:51:37', NULL),
(264, 'Pausado', 3, '2019-02-20 13:51:52', NULL),
(265, 'Iniciado', 4, '2019-02-20 13:51:59', NULL),
(266, 'Pausado', 4, '2019-02-20 13:52:07', NULL),
(267, 'Iniciado', 3, '2019-02-20 13:52:13', NULL),
(268, 'Pausado', 3, '2019-02-20 13:52:19', NULL),
(269, 'Iniciado', 4, '2019-02-20 13:54:18', NULL),
(270, 'Pausado', 4, '2019-02-20 13:59:03', NULL),
(271, 'Iniciado', 3, '2019-02-20 14:11:22', NULL),
(272, 'Pausado', 3, '2019-02-20 14:11:31', NULL),
(273, 'Iniciado', 4, '2019-02-20 14:21:59', NULL),
(274, 'Pausado', 4, '2019-02-20 14:22:02', NULL),
(275, 'Iniciado', 4, '2019-02-20 15:48:11', NULL),
(276, 'Iniciado', 4, '2019-02-20 17:44:57', NULL),
(277, 'Iniciado', 4, '2019-02-20 17:46:01', NULL),
(278, 'Iniciado', 6, '2019-02-21 12:59:51', NULL),
(279, 'Pausado', 6, '2019-02-21 13:00:06', NULL),
(280, 'Iniciado', 6, '2019-02-21 13:00:11', NULL),
(281, 'Pausado', 6, '2019-02-21 13:00:16', NULL),
(282, 'Iniciado', 1, '2019-02-21 13:19:01', NULL),
(283, 'Pausado', 1, '2019-02-21 13:19:55', NULL),
(284, 'Iniciado', 1, '2019-02-21 13:20:39', NULL),
(285, 'Pausado', 1, '2019-02-21 13:22:01', NULL),
(286, 'Iniciado', 1, '2019-02-21 13:22:14', NULL),
(287, 'Pausado', 1, '2019-02-21 13:22:18', NULL),
(288, 'Iniciado', 1, '2019-02-21 15:26:10', NULL),
(289, 'Pausado', 1, '2019-02-21 15:26:58', NULL),
(290, 'Iniciado', 1, '2019-02-21 16:08:10', NULL),
(291, 'Pausado', 1, '2019-02-21 16:27:46', NULL),
(292, 'Iniciado', 1, '2019-02-21 16:36:49', NULL),
(293, 'Pausado', 1, '2019-02-21 16:36:55', NULL),
(294, 'Iniciado', 5, '2019-02-21 16:56:48', NULL),
(295, 'Pausado', 5, '2019-02-21 16:57:29', NULL),
(296, 'Iniciado', 5, '2019-02-21 16:57:35', NULL),
(297, 'Pausado', 5, '2019-02-21 16:57:53', NULL),
(298, 'Iniciado', 5, '2019-02-21 16:58:11', NULL),
(299, 'Pausado', 5, '2019-02-21 16:58:19', NULL),
(300, 'Iniciado', 1, '2019-02-21 16:58:24', NULL),
(301, 'Pausado', 1, '2019-02-21 16:58:29', NULL),
(302, 'Iniciado', 7, '2019-02-21 16:59:06', NULL),
(303, 'Pausado', 7, '2019-02-21 16:59:22', NULL),
(304, 'Iniciado', 7, '2019-02-21 17:02:24', NULL),
(305, 'Pausado', 7, '2019-02-21 17:02:35', NULL),
(306, 'Iniciado', 5, '2019-02-21 17:02:38', NULL),
(307, 'Pausado', 5, '2019-02-21 17:02:44', NULL),
(308, 'Iniciado', 7, '2019-02-21 17:03:43', NULL),
(309, 'Pausado', 7, '2019-02-21 17:06:37', NULL),
(310, 'Iniciado', 5, '2019-02-21 17:06:40', NULL),
(311, 'Pausado', 5, '2019-02-21 17:06:42', NULL),
(312, 'Iniciado', 7, '2019-02-21 17:07:41', NULL),
(313, 'Pausado', 7, '2019-02-21 17:07:44', NULL),
(314, 'Iniciado', 7, '2019-02-21 17:08:24', NULL),
(315, 'Pausado', 7, '2019-02-21 17:08:36', NULL),
(316, 'Iniciado', 7, '2019-02-21 17:09:35', NULL),
(317, 'Pausado', 7, '2019-02-21 17:09:42', NULL),
(318, 'Iniciado', 7, '2019-02-21 17:18:16', NULL),
(319, 'Pausado', 7, '2019-02-21 17:18:51', NULL),
(320, 'Iniciado', 5, '2019-02-21 17:19:26', NULL),
(321, 'Pausado', 5, '2019-02-21 17:19:31', NULL),
(322, 'Pausado', 7, '2019-02-21 17:25:27', NULL),
(323, 'Iniciado', 7, '2019-02-21 17:25:30', NULL),
(324, 'Pausado', 7, '2019-02-21 17:27:04', NULL),
(325, 'Iniciado', 7, '2019-02-21 17:28:33', NULL),
(326, 'Pausado', 7, '2019-02-21 17:29:41', NULL),
(327, 'Iniciado', 1, '2019-02-21 17:33:39', NULL),
(328, 'Pausado', 1, '2019-02-21 17:33:47', NULL),
(329, 'Iniciado', 1, '2019-02-21 17:33:59', NULL),
(330, 'Pausado', 1, '2019-02-21 17:34:06', NULL),
(331, 'Iniciado', 7, '2019-02-21 17:34:09', NULL),
(332, 'Pausado', 7, '2019-02-21 17:34:16', NULL),
(333, 'Iniciado', 1, '2019-02-21 17:35:21', NULL),
(334, 'Pausado', 1, '2019-02-21 17:35:26', NULL),
(335, 'Iniciado', 7, '2019-02-21 17:35:29', NULL),
(336, 'Pausado', 7, '2019-02-21 17:41:59', NULL),
(337, 'Iniciado', 7, '2019-02-21 17:42:02', NULL),
(338, 'Pausado', 7, '2019-02-21 17:44:07', NULL),
(339, 'Iniciado', 1, '2019-02-21 17:44:10', NULL),
(340, 'Pausado', 1, '2019-02-21 17:44:16', NULL),
(341, 'Iniciado', 7, '2019-02-21 17:44:19', NULL),
(342, 'Pausado', 7, '2019-02-21 17:44:28', NULL),
(343, 'Iniciado', 7, '2019-02-21 17:44:53', NULL),
(344, 'Pausado', 7, '2019-02-21 17:45:29', NULL),
(345, 'Iniciado', 1, '2019-02-21 17:45:32', NULL),
(346, 'Pausado', 1, '2019-02-21 17:45:50', NULL),
(347, 'Iniciado', 7, '2019-02-21 17:45:53', NULL),
(348, 'Pausado', 7, '2019-02-21 17:46:17', NULL),
(349, 'Iniciado', 1, '2019-02-21 17:46:24', NULL),
(350, 'Pausado', 1, '2019-02-21 17:46:34', NULL),
(351, 'Iniciado', 1, '2019-02-21 17:48:48', NULL),
(352, 'Pausado', 1, '2019-02-21 17:48:53', NULL),
(353, 'Iniciado', 1, '2019-02-21 17:48:59', NULL),
(354, 'Pausado', 1, '2019-02-21 17:49:03', NULL),
(355, 'Iniciado', 7, '2019-02-21 17:49:06', NULL),
(356, 'Pausado', 7, '2019-02-21 17:49:19', NULL),
(357, 'Iniciado', 7, '2019-02-21 17:50:44', NULL),
(358, 'Pausado', 7, '2019-02-21 17:51:25', NULL),
(359, 'Iniciado', 1, '2019-02-21 17:51:29', NULL),
(360, 'Pausado', 1, '2019-02-21 17:51:34', NULL),
(361, 'Iniciado', 1, '2019-02-21 17:56:48', NULL),
(362, 'Pausado', 1, '2019-02-21 17:56:52', NULL),
(363, 'Iniciado', 7, '2019-02-21 17:56:55', NULL),
(364, 'Pausado', 7, '2019-02-21 17:57:00', NULL),
(365, 'Iniciado', 7, '2019-02-22 11:44:19', NULL),
(366, 'Pausado', 7, '2019-02-22 11:44:24', NULL),
(367, 'Iniciado', 1, '2019-03-18 16:47:54', NULL),
(368, 'Pausado', 1, '2019-03-18 16:47:58', NULL),
(369, 'Iniciado', 7, '2019-03-26 14:10:17', NULL),
(370, 'Iniciado', 5, '2019-03-26 14:41:19', NULL),
(371, 'Pausado', 5, '2019-03-26 14:43:17', NULL),
(372, 'Iniciado', 5, '2019-03-26 14:53:33', NULL),
(373, 'Pausado', 5, '2019-03-26 14:53:43', NULL),
(374, 'Iniciado', 5, '2019-03-26 15:21:35', NULL),
(375, 'Pausado', 5, '2019-03-26 15:26:19', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_menus`
--

DROP TABLE IF EXISTS `adms_menus`;
CREATE TABLE IF NOT EXISTS `adms_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `icone` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `adms_sit_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_menus`
--

INSERT INTO `adms_menus` (`id`, `nome`, `icone`, `ordem`, `adms_sit_id`, `created`, `modified`) VALUES
(1, 'Dashboard', 'fas fa-tachometer-alt', 1, 1, '2019-01-21 00:00:00', NULL),
(2, 'Controle', 'fas fa-user-lock', 6, 1, '2019-01-21 00:00:00', '2019-02-12 15:35:30'),
(3, 'Sair', 'fas fa-sign-out-alt', 11, 1, '2019-01-24 00:00:00', '2019-03-21 13:01:41'),
(4, 'ConfiguraÃ§Ã£o', 'fas fa-cogs', 7, 1, '2019-01-24 00:00:00', '2019-02-12 15:35:28'),
(5, 'Gerente', 'fas fa-pencil-alt', 5, 1, '2019-01-27 00:00:00', '2019-02-12 15:35:32'),
(6, 'Atendimento', 'fas fa-user-plus', 3, 1, '2019-01-30 00:00:00', '2019-02-12 15:35:36'),
(9, 'Visualizar', 'fas fa-eye', 9, 1, '2019-02-03 17:45:25', '2019-02-21 13:04:14'),
(10, 'Atendimentos', 'fas fa-user-edit', 8, 1, '2019-02-03 19:34:51', '2019-02-12 15:35:26'),
(11, 'FuncionÃ¡rio', 'fas fa-tasks', 4, 1, '2019-02-12 15:20:01', '2019-02-12 15:35:34'),
(12, 'Cliente', 'fas fa-user-circle', 2, 1, '2019-02-12 15:35:03', '2019-02-12 15:35:36'),
(13, 'Gerenciar FuncionÃ¡rios', 'fas fa-user-clock', 10, 1, '2019-03-21 13:01:09', '2019-03-21 15:00:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_nivacs_pgs`
--

DROP TABLE IF EXISTS `adms_nivacs_pgs`;
CREATE TABLE IF NOT EXISTS `adms_nivacs_pgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissao` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  `dropdown` int(11) NOT NULL DEFAULT '2',
  `lib_menu` int(11) NOT NULL DEFAULT '2',
  `adms_menu_id` int(11) NOT NULL DEFAULT '4',
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_pagina_id` int(11) NOT NULL,
  `adms_tps_empresa_id` int(11) DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=823 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_nivacs_pgs`
--

INSERT INTO `adms_nivacs_pgs` (`id`, `permissao`, `ordem`, `dropdown`, `lib_menu`, `adms_menu_id`, `adms_niveis_acesso_id`, `adms_pagina_id`, `adms_tps_empresa_id`, `created`, `modified`) VALUES
(1, 1, 1, 2, 1, 1, 1, 1, 1, '2019-01-21 00:00:00', '2019-02-01 22:30:37'),
(2, 1, 3, 1, 1, 2, 1, 2, 1, '2019-01-21 00:00:00', '2019-02-01 22:32:22'),
(3, 1, 4, 2, 1, 3, 1, 4, 1, '2019-01-21 00:00:00', '2019-02-01 22:32:17'),
(4, 1, 5, 2, 2, 2, 1, 9, 1, '2019-01-24 00:00:00', '2019-02-01 22:32:14'),
(5, 1, 6, 2, 2, 2, 1, 10, 1, '2019-01-27 00:00:00', '2019-02-01 22:32:10'),
(6, 1, 7, 2, 2, 2, 1, 11, 1, '2019-01-24 00:00:00', '2019-02-01 22:32:07'),
(7, 1, 8, 2, 2, 2, 1, 12, 1, '2019-01-26 00:00:00', '2019-02-01 22:32:05'),
(8, 1, 9, 2, 2, 2, 1, 13, 1, '2019-01-26 00:00:00', '2019-02-01 22:32:03'),
(9, 1, 10, 2, 2, 2, 1, 14, 1, '2019-01-26 00:00:00', '2019-02-01 22:32:01'),
(10, 1, 11, 2, 2, 2, 1, 15, 1, '2019-01-26 00:00:00', '2019-02-01 22:31:50'),
(11, 1, 12, 2, 2, 2, 1, 16, 1, '2019-01-27 00:00:00', '2019-02-01 22:31:47'),
(12, 1, 13, 1, 1, 5, 1, 17, 1, '2019-01-27 00:00:00', '2019-02-01 22:31:27'),
(13, 1, 2, 1, 1, 2, 1, 18, 1, '2019-01-27 00:00:00', '2019-02-01 22:32:22'),
(14, 1, 14, 2, 2, 2, 1, 19, 1, '2018-06-23 00:00:00', NULL),
(15, 1, 15, 2, 2, 2, 1, 20, 1, '2018-06-23 00:00:00', NULL),
(16, 1, 16, 2, 2, 2, 1, 21, 1, '2018-06-23 00:00:00', NULL),
(17, 1, 17, 2, 2, 2, 1, 22, 1, '2018-06-23 00:00:00', NULL),
(18, 1, 18, 2, 2, 2, 1, 23, 1, '2018-06-23 00:00:00', NULL),
(19, 1, 19, 1, 1, 4, 1, 24, 1, '2019-01-28 14:25:21', NULL),
(20, 1, 20, 2, 2, 4, 1, 25, 1, '2019-01-28 14:25:21', '2019-02-01 21:24:04'),
(21, 1, 21, 2, 2, 4, 1, 26, 1, '2019-01-28 14:43:47', NULL),
(22, 1, 22, 2, 2, 4, 1, 27, 1, '2019-01-28 19:17:43', NULL),
(23, 1, 23, 2, 2, 4, 1, 28, 1, '2019-01-28 00:00:00', NULL),
(24, 1, 1, 2, 1, 1, 2, 1, 1, '2019-01-27 00:00:00', NULL),
(25, 1, 2, 2, 2, 2, 2, 9, 1, '2019-01-27 00:00:00', NULL),
(26, 1, 3, 2, 2, 2, 2, 10, 1, '2019-01-27 00:00:00', NULL),
(27, 1, 4, 2, 2, 2, 2, 11, 1, '2019-01-27 00:00:00', NULL),
(28, 1, 5, 1, 1, 4, 2, 2, 1, '2019-01-27 00:00:00', '2019-02-03 17:39:34'),
(29, 1, 6, 2, 2, 2, 2, 12, 1, '2019-01-27 00:00:00', NULL),
(30, 1, 7, 2, 2, 2, 2, 13, 1, '2019-01-27 00:00:00', NULL),
(31, 1, 8, 2, 2, 2, 2, 14, 1, '2019-01-27 00:00:00', NULL),
(32, 1, 9, 2, 2, 2, 2, 15, 1, '2019-01-27 00:00:00', NULL),
(111, 1, 38, 2, 2, 4, 1, 45, 1, '2019-02-02 20:10:32', NULL),
(34, 1, 10, 2, 1, 3, 2, 4, 1, '2019-01-27 00:00:00', '2019-02-02 19:29:19'),
(35, 1, 11, 1, 1, 4, 2, 18, 1, '2018-06-23 00:00:00', '2019-02-03 00:10:54'),
(36, 2, 12, 2, 2, 2, 2, 19, 1, '2018-06-23 00:00:00', '2019-02-03 00:12:42'),
(37, 2, 13, 2, 2, 2, 2, 20, 1, '2018-06-23 00:00:00', '2019-02-03 19:07:48'),
(38, 2, 14, 2, 2, 2, 2, 21, 1, '2018-06-23 00:00:00', '2019-02-03 00:18:02'),
(39, 2, 15, 2, 2, 2, 2, 22, 1, '2018-06-23 00:00:00', '2019-02-03 00:14:20'),
(40, 1, 16, 2, 2, 2, 2, 23, 1, '2018-06-23 00:00:00', '2019-02-02 19:29:35'),
(41, 2, 17, 2, 2, 4, 2, 25, 1, '2019-01-28 14:25:21', '2019-02-02 19:29:36'),
(42, 2, 18, 2, 2, 4, 2, 26, 1, '2019-01-28 14:43:47', '2019-02-02 19:29:38'),
(43, 2, 19, 2, 2, 4, 2, 27, 1, '2019-01-28 19:17:43', '2019-02-03 19:01:35'),
(44, 1, 1, 2, 1, 1, 3, 1, 1, '2019-01-28 00:00:00', NULL),
(55, 1, 20, 1, 1, 5, 2, 17, 1, '2019-01-28 00:00:00', '2019-02-02 19:29:43'),
(56, 1, 24, 2, 2, 5, 1, 30, 1, '2019-01-28 00:00:00', NULL),
(57, 1, 25, 2, 2, 5, 1, 31, 1, '2019-01-28 00:00:00', NULL),
(58, 1, 26, 2, 2, 5, 1, 32, 1, '2019-01-28 00:00:00', NULL),
(59, 1, 27, 2, 2, 5, 1, 33, 1, '2019-01-28 00:00:00', NULL),
(60, 1, 28, 2, 2, 5, 1, 34, 1, '2019-01-29 00:00:00', NULL),
(61, 1, 29, 2, 2, 5, 1, 35, 1, '2019-01-29 00:00:00', NULL),
(62, 1, 30, 2, 2, 5, 1, 36, 1, '2019-01-29 00:00:00', NULL),
(63, 1, 21, 2, 2, 2, 2, 30, 1, '2018-06-23 00:00:00', '2019-02-02 19:43:44'),
(64, 1, 22, 2, 2, 2, 2, 31, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:45'),
(65, 1, 23, 2, 2, 2, 2, 32, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:46'),
(66, 1, 24, 2, 2, 2, 2, 33, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:47'),
(67, 1, 25, 2, 2, 2, 2, 34, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:48'),
(68, 1, 26, 2, 2, 2, 2, 35, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:48'),
(69, 1, 27, 2, 2, 2, 2, 36, 1, '2019-01-29 00:00:00', '2019-02-02 19:43:49'),
(70, 1, 1, 2, 1, 1, 4, 1, 1, '2019-01-21 00:00:00', NULL),
(71, 1, 2, 1, 1, 9, 4, 17, 1, '2019-01-30 00:00:00', '2019-02-03 17:46:44'),
(72, 1, 3, 2, 2, 5, 4, 31, 1, '2019-01-30 00:00:00', '2019-02-03 17:42:54'),
(73, 1, 28, 2, 2, 2, 2, 16, 1, '2019-01-30 00:00:00', '2019-02-02 19:43:51'),
(74, 1, 31, 1, 1, 12, 1, 37, 1, '2019-01-30 18:42:17', '2019-02-12 15:36:05'),
(75, 1, 29, 2, 1, 6, 2, 37, 1, '2019-01-30 18:42:17', '2019-02-03 00:16:09'),
(76, 1, 2, 2, 1, 6, 3, 37, 1, '2019-01-30 18:42:17', '2019-02-03 19:21:08'),
(77, 2, 4, 0, 0, 0, 4, 37, 1, '2019-01-30 18:42:17', NULL),
(78, 2, 1, 0, 0, 0, 5, 37, 1, '2019-01-30 18:42:17', NULL),
(79, 1, 32, 2, 2, 6, 1, 38, 1, '2019-01-31 00:00:00', NULL),
(80, 1, 30, 2, 2, 6, 2, 38, 1, '2019-01-31 00:00:00', '2019-02-03 00:16:11'),
(81, 1, 33, 2, 2, 4, 1, 39, 1, '2019-02-01 01:01:00', NULL),
(82, 1, 31, 2, 2, 4, 2, 39, 1, '2019-02-01 01:01:00', '2019-02-02 19:44:01'),
(83, 2, 3, 2, 2, 4, 3, 39, 1, '2019-02-01 01:01:00', '2019-02-01 18:51:55'),
(84, 2, 5, 2, 2, 4, 4, 39, 1, '2019-02-01 01:01:00', NULL),
(85, 2, 2, 2, 2, 4, 5, 39, 1, '2019-02-01 01:01:00', NULL),
(95, 2, 3, 2, 2, 4, 5, 41, 1, '2019-02-01 18:49:17', NULL),
(94, 2, 6, 2, 2, 4, 4, 41, 1, '2019-02-01 18:49:17', NULL),
(93, 2, 4, 2, 2, 4, 3, 41, 1, '2019-02-01 18:49:17', NULL),
(92, 2, 32, 2, 2, 4, 2, 41, 1, '2019-02-01 18:49:17', '2019-02-03 18:55:06'),
(91, 1, 34, 2, 2, 4, 1, 41, 1, '2019-02-01 18:49:17', NULL),
(96, 1, 35, 2, 2, 4, 1, 42, 1, '2019-02-01 18:50:02', NULL),
(97, 2, 33, 2, 2, 4, 2, 42, 1, '2019-02-01 18:50:02', '2019-02-02 19:44:03'),
(98, 2, 5, 2, 2, 4, 3, 42, 1, '2019-02-01 18:50:02', NULL),
(99, 2, 7, 2, 2, 4, 4, 42, 1, '2019-02-01 18:50:02', NULL),
(100, 2, 4, 2, 2, 4, 5, 42, 1, '2019-02-01 18:50:02', NULL),
(101, 1, 36, 2, 2, 4, 1, 43, 1, '2019-02-01 18:50:45', NULL),
(102, 2, 34, 2, 2, 4, 2, 43, 1, '2019-02-01 18:50:45', '2019-02-02 19:44:03'),
(103, 2, 6, 2, 2, 4, 3, 43, 1, '2019-02-01 18:50:45', NULL),
(104, 2, 8, 2, 2, 4, 4, 43, 1, '2019-02-01 18:50:45', NULL),
(105, 2, 5, 2, 2, 4, 5, 43, 1, '2019-02-01 18:50:45', NULL),
(106, 1, 37, 2, 2, 4, 1, 44, 1, '2019-02-01 22:13:43', '2019-02-02 18:55:54'),
(107, 2, 35, 2, 2, 4, 2, 44, 1, '2019-02-01 22:13:43', '2019-02-02 19:44:04'),
(108, 2, 7, 2, 2, 4, 3, 44, 1, '2019-02-01 22:13:43', NULL),
(109, 2, 9, 2, 2, 4, 4, 44, 1, '2019-02-01 22:13:43', NULL),
(110, 2, 6, 2, 2, 4, 5, 44, 1, '2019-02-01 22:13:43', NULL),
(112, 2, 36, 2, 2, 4, 2, 45, 1, '2019-02-02 20:10:32', NULL),
(113, 2, 8, 2, 2, 4, 3, 45, 1, '2019-02-02 20:10:32', NULL),
(114, 2, 10, 2, 2, 4, 4, 45, 1, '2019-02-02 20:10:32', NULL),
(115, 2, 7, 2, 2, 4, 5, 45, 1, '2019-02-02 20:10:32', NULL),
(116, 1, 39, 2, 2, 4, 1, 3, 1, '2019-02-02 20:23:09', NULL),
(117, 1, 40, 2, 2, 4, 1, 5, 1, '2019-02-02 20:23:09', NULL),
(118, 1, 41, 2, 2, 4, 1, 6, 1, '2019-02-02 20:23:09', NULL),
(119, 1, 42, 2, 2, 4, 1, 7, 1, '2019-02-02 20:23:09', NULL),
(120, 1, 43, 2, 2, 4, 1, 8, 1, '2019-02-02 20:23:09', NULL),
(121, 1, 37, 2, 2, 4, 2, 3, 1, '2019-02-02 20:23:09', NULL),
(122, 1, 38, 2, 2, 4, 2, 5, 1, '2019-02-02 20:23:09', NULL),
(123, 1, 39, 2, 2, 4, 2, 6, 1, '2019-02-02 20:23:09', NULL),
(124, 1, 40, 2, 2, 4, 2, 7, 1, '2019-02-02 20:23:09', NULL),
(125, 1, 41, 2, 2, 4, 2, 8, 1, '2019-02-02 20:23:09', NULL),
(126, 2, 42, 2, 2, 4, 2, 24, 1, '2019-02-02 20:23:09', NULL),
(127, 2, 43, 2, 2, 4, 2, 28, 1, '2019-02-02 20:23:09', NULL),
(128, 1, 9, 1, 1, 5, 3, 2, 1, '2019-02-02 20:23:09', '2019-02-03 16:56:56'),
(129, 1, 10, 2, 2, 4, 3, 3, 1, '2019-02-02 20:23:09', NULL),
(130, 1, 11, 2, 1, 3, 3, 4, 1, '2019-02-02 20:23:09', '2019-02-02 21:51:45'),
(131, 1, 12, 2, 2, 4, 3, 5, 1, '2019-02-02 20:23:09', NULL),
(132, 1, 13, 2, 2, 4, 3, 6, 1, '2019-02-02 20:23:09', NULL),
(133, 1, 14, 2, 2, 4, 3, 7, 1, '2019-02-02 20:23:09', NULL),
(134, 1, 15, 2, 2, 4, 3, 8, 1, '2019-02-02 20:23:09', NULL),
(135, 1, 16, 2, 2, 2, 3, 9, 1, '2019-02-02 20:23:09', '2019-02-02 21:52:00'),
(136, 1, 17, 2, 2, 2, 3, 10, 1, '2019-02-02 20:23:09', '2019-02-02 21:52:08'),
(137, 1, 18, 2, 2, 2, 3, 11, 1, '2019-02-02 20:23:09', '2019-02-02 21:52:15'),
(138, 1, 19, 2, 2, 2, 3, 12, 1, '2019-02-02 20:23:09', '2019-02-03 16:55:31'),
(139, 1, 20, 2, 2, 2, 3, 13, 1, '2019-02-02 20:23:09', '2019-02-02 21:53:19'),
(140, 1, 21, 2, 2, 2, 3, 14, 1, '2019-02-02 20:23:09', '2019-02-02 21:54:50'),
(141, 1, 22, 2, 2, 2, 3, 15, 1, '2019-02-02 20:23:09', '2019-02-02 21:54:56'),
(142, 1, 23, 2, 2, 4, 3, 16, 1, '2019-02-02 20:23:09', '2019-02-03 18:31:23'),
(143, 1, 24, 1, 1, 5, 3, 17, 1, '2019-02-02 20:23:09', '2019-02-02 22:23:58'),
(144, 2, 25, 2, 2, 4, 3, 18, 1, '2019-02-02 20:23:09', NULL),
(145, 2, 26, 2, 2, 4, 3, 19, 1, '2019-02-02 20:23:09', NULL),
(146, 2, 27, 2, 2, 4, 3, 20, 1, '2019-02-02 20:23:09', NULL),
(147, 2, 28, 2, 2, 4, 3, 21, 1, '2019-02-02 20:23:09', NULL),
(148, 2, 29, 2, 2, 4, 3, 22, 1, '2019-02-02 20:23:09', NULL),
(149, 2, 30, 2, 2, 4, 3, 23, 1, '2019-02-02 20:23:09', NULL),
(150, 2, 31, 2, 2, 4, 3, 24, 1, '2019-02-02 20:23:09', NULL),
(151, 2, 32, 2, 2, 4, 3, 25, 1, '2019-02-02 20:23:09', NULL),
(152, 2, 33, 2, 2, 4, 3, 26, 1, '2019-02-02 20:23:09', NULL),
(153, 2, 34, 2, 2, 4, 3, 27, 1, '2019-02-02 20:23:09', NULL),
(154, 2, 35, 2, 2, 4, 3, 28, 1, '2019-02-02 20:23:09', NULL),
(155, 1, 36, 2, 2, 5, 3, 30, 1, '2019-02-02 20:23:09', '2019-02-02 22:24:31'),
(156, 1, 37, 2, 2, 5, 3, 31, 1, '2019-02-02 20:23:09', '2019-02-02 22:24:43'),
(157, 1, 38, 2, 2, 5, 3, 32, 1, '2019-02-02 20:23:09', '2019-02-02 22:24:50'),
(158, 1, 39, 2, 2, 5, 3, 33, 1, '2019-02-02 20:23:09', '2019-02-02 22:25:01'),
(159, 1, 40, 2, 2, 5, 3, 34, 1, '2019-02-02 20:23:09', '2019-02-02 22:26:00'),
(160, 1, 41, 2, 2, 5, 3, 35, 1, '2019-02-02 20:23:09', '2019-02-02 22:26:11'),
(161, 1, 42, 2, 2, 5, 3, 36, 1, '2019-02-02 20:23:09', '2019-02-02 22:27:11'),
(162, 1, 43, 2, 2, 6, 3, 38, 1, '2019-02-02 20:23:09', '2019-02-02 22:27:05'),
(163, 2, 11, 2, 2, 4, 4, 2, 1, '2019-02-02 20:23:09', NULL),
(164, 1, 12, 2, 2, 4, 4, 3, 1, '2019-02-02 20:23:09', NULL),
(165, 1, 13, 2, 1, 3, 4, 4, 1, '2019-02-02 20:23:09', '2019-02-02 21:49:34'),
(166, 1, 14, 2, 2, 4, 4, 5, 1, '2019-02-02 20:23:09', NULL),
(167, 1, 15, 2, 2, 4, 4, 6, 1, '2019-02-02 20:23:09', NULL),
(168, 1, 16, 2, 2, 4, 4, 7, 1, '2019-02-02 20:23:09', NULL),
(169, 1, 17, 2, 2, 4, 4, 8, 1, '2019-02-02 20:23:09', NULL),
(170, 1, 18, 2, 2, 2, 4, 9, 1, '2019-02-02 20:23:09', '2019-02-02 21:48:46'),
(171, 1, 19, 2, 2, 2, 4, 10, 1, '2019-02-02 20:23:09', '2019-02-02 21:48:55'),
(172, 1, 20, 2, 2, 2, 4, 11, 1, '2019-02-02 20:23:09', '2019-02-02 21:49:03'),
(173, 2, 21, 2, 2, 4, 4, 12, 1, '2019-02-02 20:23:09', NULL),
(174, 2, 22, 2, 2, 4, 4, 13, 1, '2019-02-02 20:23:09', NULL),
(175, 2, 23, 2, 2, 4, 4, 14, 1, '2019-02-02 20:23:09', NULL),
(176, 2, 24, 2, 2, 4, 4, 15, 1, '2019-02-02 20:23:09', NULL),
(177, 2, 25, 2, 2, 4, 4, 16, 1, '2019-02-02 20:23:09', NULL),
(178, 2, 26, 2, 2, 4, 4, 18, 1, '2019-02-02 20:23:09', NULL),
(179, 2, 27, 2, 2, 4, 4, 19, 1, '2019-02-02 20:23:09', NULL),
(180, 2, 28, 2, 2, 4, 4, 20, 1, '2019-02-02 20:23:09', NULL),
(181, 2, 29, 2, 2, 4, 4, 21, 1, '2019-02-02 20:23:09', NULL),
(182, 2, 30, 2, 2, 4, 4, 22, 1, '2019-02-02 20:23:09', NULL),
(183, 2, 31, 2, 2, 4, 4, 23, 1, '2019-02-02 20:23:09', NULL),
(184, 2, 32, 2, 2, 4, 4, 24, 1, '2019-02-02 20:23:09', NULL),
(185, 2, 33, 2, 2, 4, 4, 25, 1, '2019-02-02 20:23:09', NULL),
(186, 2, 34, 2, 2, 4, 4, 26, 1, '2019-02-02 20:23:09', NULL),
(187, 2, 35, 2, 2, 4, 4, 27, 1, '2019-02-02 20:23:09', NULL),
(188, 2, 36, 2, 2, 4, 4, 28, 1, '2019-02-02 20:23:09', NULL),
(189, 2, 37, 2, 2, 4, 4, 30, 1, '2019-02-02 20:23:09', NULL),
(190, 2, 38, 2, 2, 4, 4, 32, 1, '2019-02-02 20:23:09', NULL),
(191, 2, 39, 2, 2, 4, 4, 33, 1, '2019-02-02 20:23:09', NULL),
(192, 2, 40, 2, 2, 4, 4, 34, 1, '2019-02-02 20:23:09', NULL),
(193, 2, 41, 2, 2, 4, 4, 35, 1, '2019-02-02 20:23:09', NULL),
(194, 2, 42, 2, 2, 4, 4, 36, 1, '2019-02-02 20:23:09', NULL),
(195, 2, 43, 2, 2, 4, 4, 38, 1, '2019-02-02 20:23:09', NULL),
(196, 1, 8, 2, 1, 1, 5, 1, 1, '2019-02-02 20:23:09', '2019-02-02 21:39:14'),
(197, 2, 9, 2, 2, 4, 5, 2, 1, '2019-02-02 20:23:09', NULL),
(198, 1, 10, 2, 2, 4, 5, 3, 1, '2019-02-02 20:23:09', NULL),
(199, 1, 11, 2, 1, 3, 5, 4, 1, '2019-02-02 20:23:09', '2019-02-02 21:37:37'),
(200, 1, 12, 2, 2, 4, 5, 5, 1, '2019-02-02 20:23:09', NULL),
(201, 1, 13, 2, 2, 4, 5, 6, 1, '2019-02-02 20:23:09', NULL),
(202, 1, 14, 2, 2, 4, 5, 7, 1, '2019-02-02 20:23:09', NULL),
(203, 1, 15, 2, 2, 4, 5, 8, 1, '2019-02-02 20:23:09', NULL),
(204, 1, 16, 2, 2, 2, 5, 9, 1, '2019-02-02 20:23:09', '2019-02-02 21:45:01'),
(205, 1, 17, 2, 2, 2, 5, 10, 1, '2019-02-02 20:23:09', '2019-02-02 21:45:15'),
(206, 1, 18, 2, 2, 2, 5, 11, 1, '2019-02-02 20:23:09', '2019-02-02 21:45:20'),
(207, 2, 19, 2, 2, 4, 5, 12, 1, '2019-02-02 20:23:09', NULL),
(208, 2, 20, 2, 2, 4, 5, 13, 1, '2019-02-02 20:23:09', NULL),
(209, 2, 21, 2, 2, 4, 5, 14, 1, '2019-02-02 20:23:09', NULL),
(210, 2, 22, 2, 2, 4, 5, 15, 1, '2019-02-02 20:23:09', NULL),
(211, 2, 23, 2, 2, 4, 5, 16, 1, '2019-02-02 20:23:09', NULL),
(212, 2, 24, 2, 2, 4, 5, 17, 1, '2019-02-02 20:23:09', NULL),
(213, 2, 25, 2, 2, 4, 5, 18, 1, '2019-02-02 20:23:09', NULL),
(214, 2, 26, 2, 2, 4, 5, 19, 1, '2019-02-02 20:23:09', NULL),
(215, 2, 27, 2, 2, 4, 5, 20, 1, '2019-02-02 20:23:09', NULL),
(216, 2, 28, 2, 2, 4, 5, 21, 1, '2019-02-02 20:23:09', NULL),
(217, 2, 29, 2, 2, 4, 5, 22, 1, '2019-02-02 20:23:09', NULL),
(218, 2, 30, 2, 2, 4, 5, 23, 1, '2019-02-02 20:23:09', NULL),
(219, 2, 31, 2, 2, 4, 5, 24, 1, '2019-02-02 20:23:09', NULL),
(220, 2, 32, 2, 2, 4, 5, 25, 1, '2019-02-02 20:23:09', NULL),
(221, 2, 33, 2, 2, 4, 5, 26, 1, '2019-02-02 20:23:09', NULL),
(222, 2, 34, 2, 2, 4, 5, 27, 1, '2019-02-02 20:23:09', NULL),
(223, 2, 35, 2, 2, 4, 5, 28, 1, '2019-02-02 20:23:09', NULL),
(224, 2, 36, 2, 2, 4, 5, 30, 1, '2019-02-02 20:23:09', NULL),
(225, 2, 37, 2, 2, 4, 5, 31, 1, '2019-02-02 20:23:09', NULL),
(226, 2, 38, 2, 2, 4, 5, 32, 1, '2019-02-02 20:23:09', NULL),
(227, 2, 39, 2, 2, 4, 5, 33, 1, '2019-02-02 20:23:09', NULL),
(228, 2, 40, 2, 2, 4, 5, 34, 1, '2019-02-02 20:23:09', NULL),
(229, 2, 41, 2, 2, 4, 5, 35, 1, '2019-02-02 20:23:09', NULL),
(230, 2, 42, 2, 2, 4, 5, 36, 1, '2019-02-02 20:23:09', NULL),
(231, 2, 43, 2, 2, 4, 5, 38, 1, '2019-02-02 20:23:09', NULL),
(232, 1, 1, 2, 1, 1, 6, 1, 1, '2019-02-02 20:29:47', '2019-02-02 21:35:12'),
(233, 2, 2, 2, 2, 4, 6, 2, 1, '2019-02-02 20:29:47', NULL),
(234, 1, 3, 2, 2, 4, 6, 3, 1, '2019-02-02 20:29:47', NULL),
(235, 1, 4, 2, 1, 3, 6, 4, 1, '2019-02-02 20:29:47', '2019-02-02 21:34:26'),
(236, 1, 5, 2, 2, 4, 6, 5, 1, '2019-02-02 20:29:47', NULL),
(237, 1, 6, 2, 2, 4, 6, 6, 1, '2019-02-02 20:29:47', NULL),
(238, 1, 7, 2, 2, 4, 6, 7, 1, '2019-02-02 20:29:47', NULL),
(239, 1, 8, 2, 2, 4, 6, 8, 1, '2019-02-02 20:29:47', NULL),
(240, 1, 9, 2, 2, 2, 6, 9, 1, '2019-02-02 20:29:47', '2019-02-02 21:38:08'),
(241, 1, 10, 2, 2, 2, 6, 10, 1, '2019-02-02 20:29:47', '2019-02-02 21:38:21'),
(242, 1, 11, 2, 2, 2, 6, 11, 1, '2019-02-02 20:29:47', '2019-02-02 21:38:32'),
(243, 2, 12, 2, 2, 4, 6, 12, 1, '2019-02-02 20:29:47', NULL),
(244, 2, 13, 2, 2, 4, 6, 13, 1, '2019-02-02 20:29:47', NULL),
(245, 2, 14, 2, 2, 4, 6, 14, 1, '2019-02-02 20:29:47', NULL),
(246, 2, 15, 2, 2, 4, 6, 15, 1, '2019-02-02 20:29:47', NULL),
(247, 2, 16, 2, 2, 4, 6, 16, 1, '2019-02-02 20:29:47', NULL),
(248, 2, 17, 2, 2, 4, 6, 17, 1, '2019-02-02 20:29:47', NULL),
(249, 2, 18, 2, 2, 4, 6, 18, 1, '2019-02-02 20:29:47', NULL),
(250, 2, 19, 2, 2, 4, 6, 19, 1, '2019-02-02 20:29:47', NULL),
(251, 2, 20, 2, 2, 4, 6, 20, 1, '2019-02-02 20:29:47', NULL),
(252, 2, 21, 2, 2, 4, 6, 21, 1, '2019-02-02 20:29:47', NULL),
(253, 2, 22, 2, 2, 4, 6, 22, 1, '2019-02-02 20:29:47', NULL),
(254, 2, 23, 2, 2, 4, 6, 23, 1, '2019-02-02 20:29:47', NULL),
(255, 2, 24, 2, 2, 4, 6, 24, 1, '2019-02-02 20:29:47', NULL),
(256, 2, 25, 2, 2, 4, 6, 25, 1, '2019-02-02 20:29:47', NULL),
(257, 2, 26, 2, 2, 4, 6, 26, 1, '2019-02-02 20:29:47', NULL),
(258, 2, 27, 2, 2, 4, 6, 27, 1, '2019-02-02 20:29:47', NULL),
(259, 2, 28, 2, 2, 4, 6, 28, 1, '2019-02-02 20:29:47', NULL),
(260, 2, 29, 2, 2, 4, 6, 30, 1, '2019-02-02 20:29:47', NULL),
(261, 2, 30, 2, 2, 4, 6, 31, 1, '2019-02-02 20:29:47', NULL),
(262, 2, 31, 2, 2, 4, 6, 32, 1, '2019-02-02 20:29:47', NULL),
(263, 2, 32, 2, 2, 4, 6, 33, 1, '2019-02-02 20:29:47', NULL),
(264, 2, 33, 2, 2, 4, 6, 34, 1, '2019-02-02 20:29:47', NULL),
(265, 2, 34, 2, 2, 4, 6, 35, 1, '2019-02-02 20:29:47', NULL),
(266, 2, 35, 2, 2, 4, 6, 36, 1, '2019-02-02 20:29:47', NULL),
(267, 1, 36, 2, 1, 6, 6, 37, 1, '2019-02-02 20:29:47', '2019-02-02 21:35:46'),
(268, 1, 37, 2, 2, 6, 6, 38, 1, '2019-02-02 20:29:47', '2019-02-02 21:36:11'),
(269, 2, 38, 2, 2, 4, 6, 39, 1, '2019-02-02 20:29:47', NULL),
(270, 2, 39, 2, 2, 4, 6, 41, 1, '2019-02-02 20:29:47', NULL),
(271, 2, 40, 2, 2, 4, 6, 42, 1, '2019-02-02 20:29:47', NULL),
(272, 2, 41, 2, 2, 4, 6, 43, 1, '2019-02-02 20:29:47', NULL),
(273, 2, 42, 2, 2, 4, 6, 44, 1, '2019-02-02 20:29:47', NULL),
(274, 2, 43, 2, 2, 4, 6, 45, 1, '2019-02-02 20:29:47', NULL),
(360, 1, 51, 1, 1, 4, 1, 53, 1, '2019-02-03 12:24:41', '2019-02-03 13:19:53'),
(359, 2, 50, 2, 2, 4, 6, 52, 1, '2019-02-03 01:28:18', NULL),
(358, 2, 50, 2, 2, 4, 5, 52, 1, '2019-02-03 01:28:18', NULL),
(357, 2, 50, 2, 2, 4, 4, 52, 1, '2019-02-03 01:28:18', NULL),
(356, 2, 50, 2, 2, 4, 3, 52, 1, '2019-02-03 01:28:18', NULL),
(355, 2, 50, 2, 2, 4, 2, 52, 1, '2019-02-03 01:28:18', NULL),
(354, 1, 50, 2, 2, 4, 1, 52, 1, '2019-02-03 01:28:18', NULL),
(353, 2, 49, 2, 2, 4, 6, 51, 1, '2019-02-03 01:22:45', NULL),
(352, 2, 49, 2, 2, 4, 5, 51, 1, '2019-02-03 01:22:45', NULL),
(351, 2, 49, 2, 2, 4, 4, 51, 1, '2019-02-03 01:22:45', NULL),
(350, 2, 49, 2, 2, 4, 3, 51, 1, '2019-02-03 01:22:45', NULL),
(349, 2, 49, 2, 2, 4, 2, 51, 1, '2019-02-03 01:22:45', NULL),
(348, 1, 49, 2, 2, 4, 1, 51, 1, '2019-02-03 01:22:45', NULL),
(347, 2, 48, 2, 2, 4, 6, 50, 1, '2019-02-03 01:08:43', NULL),
(346, 2, 48, 2, 2, 4, 5, 50, 1, '2019-02-03 01:08:43', NULL),
(345, 2, 48, 2, 2, 4, 4, 50, 1, '2019-02-03 01:08:43', NULL),
(344, 2, 48, 2, 2, 4, 3, 50, 1, '2019-02-03 01:08:43', NULL),
(343, 2, 48, 2, 2, 4, 2, 50, 1, '2019-02-03 01:08:43', NULL),
(342, 1, 48, 2, 2, 4, 1, 50, 1, '2019-02-03 01:08:43', NULL),
(341, 2, 47, 2, 2, 4, 6, 49, 1, '2019-02-03 01:03:34', NULL),
(340, 2, 47, 2, 2, 4, 5, 49, 1, '2019-02-03 01:03:34', NULL),
(339, 2, 47, 2, 2, 4, 4, 49, 1, '2019-02-03 01:03:34', NULL),
(338, 2, 47, 2, 2, 4, 3, 49, 1, '2019-02-03 01:03:34', NULL),
(337, 2, 47, 2, 2, 4, 2, 49, 1, '2019-02-03 01:03:34', NULL),
(336, 1, 47, 2, 2, 4, 1, 49, 1, '2019-02-03 01:03:34', NULL),
(335, 2, 46, 2, 2, 4, 6, 48, 1, '2019-02-03 00:43:40', NULL),
(334, 2, 46, 2, 2, 4, 5, 48, 1, '2019-02-03 00:43:40', NULL),
(333, 2, 46, 2, 2, 4, 4, 48, 1, '2019-02-03 00:43:40', NULL),
(332, 2, 46, 2, 2, 4, 3, 48, 1, '2019-02-03 00:43:40', NULL),
(331, 2, 46, 2, 2, 4, 2, 48, 1, '2019-02-03 00:43:40', NULL),
(330, 1, 46, 2, 2, 4, 1, 48, 1, '2019-02-03 00:43:40', NULL),
(329, 2, 45, 2, 2, 4, 6, 47, 1, '2019-02-03 00:28:37', NULL),
(328, 2, 45, 2, 2, 4, 5, 47, 1, '2019-02-03 00:28:37', NULL),
(327, 2, 45, 2, 2, 4, 4, 47, 1, '2019-02-03 00:28:37', NULL),
(326, 2, 45, 2, 2, 4, 3, 47, 1, '2019-02-03 00:28:37', NULL),
(325, 2, 45, 2, 2, 4, 2, 47, 1, '2019-02-03 00:28:37', '2019-02-03 19:05:57'),
(324, 1, 45, 1, 1, 4, 1, 47, 1, '2019-02-03 00:28:37', '2019-02-03 00:30:58'),
(323, 2, 44, 2, 2, 4, 6, 46, 1, '2019-02-02 21:16:48', NULL),
(322, 2, 44, 2, 2, 4, 5, 46, 1, '2019-02-02 21:16:48', NULL),
(321, 2, 44, 2, 2, 4, 4, 46, 1, '2019-02-02 21:16:48', NULL),
(320, 2, 44, 2, 2, 4, 3, 46, 1, '2019-02-02 21:16:48', NULL),
(319, 2, 44, 2, 2, 4, 2, 46, 1, '2019-02-02 21:16:48', '2019-02-03 19:05:17'),
(318, 1, 44, 2, 2, 4, 1, 46, 1, '2019-02-02 21:16:48', NULL),
(361, 2, 51, 2, 2, 4, 2, 53, 1, '2019-02-03 12:24:41', NULL),
(362, 2, 51, 2, 2, 4, 3, 53, 1, '2019-02-03 12:24:41', NULL),
(363, 2, 51, 2, 2, 4, 4, 53, 1, '2019-02-03 12:24:41', NULL),
(364, 2, 51, 2, 2, 4, 5, 53, 1, '2019-02-03 12:24:41', NULL),
(365, 2, 51, 2, 2, 4, 6, 53, 1, '2019-02-03 12:24:41', NULL),
(366, 1, 52, 1, 1, 4, 1, 54, 1, '2019-02-03 12:26:50', '2019-02-03 13:20:50'),
(367, 2, 52, 2, 2, 4, 2, 54, 1, '2019-02-03 12:26:50', NULL),
(368, 2, 52, 2, 2, 4, 3, 54, 1, '2019-02-03 12:26:50', NULL),
(369, 2, 52, 2, 2, 4, 4, 54, 1, '2019-02-03 12:26:50', NULL),
(370, 2, 52, 2, 2, 4, 5, 54, 1, '2019-02-03 12:26:50', NULL),
(371, 2, 52, 2, 2, 4, 6, 54, 1, '2019-02-03 12:26:50', NULL),
(372, 1, 53, 1, 1, 4, 1, 55, 1, '2019-02-03 12:30:11', '2019-02-03 13:21:16'),
(373, 2, 53, 2, 2, 4, 2, 55, 1, '2019-02-03 12:30:11', NULL),
(374, 2, 53, 2, 2, 4, 3, 55, 1, '2019-02-03 12:30:11', NULL),
(375, 2, 53, 2, 2, 4, 4, 55, 1, '2019-02-03 12:30:11', NULL),
(376, 2, 53, 2, 2, 4, 5, 55, 1, '2019-02-03 12:30:11', NULL),
(377, 2, 53, 2, 2, 4, 6, 55, 1, '2019-02-03 12:30:11', NULL),
(378, 1, 54, 2, 2, 4, 1, 56, 1, '2019-02-03 12:32:23', NULL),
(379, 2, 54, 2, 2, 4, 2, 56, 1, '2019-02-03 12:32:23', NULL),
(380, 2, 54, 2, 2, 4, 3, 56, 1, '2019-02-03 12:32:23', NULL),
(381, 2, 54, 2, 2, 4, 4, 56, 1, '2019-02-03 12:32:23', NULL),
(382, 2, 54, 2, 2, 4, 5, 56, 1, '2019-02-03 12:32:23', NULL),
(383, 2, 54, 2, 2, 4, 6, 56, 1, '2019-02-03 12:32:23', NULL),
(384, 1, 55, 2, 2, 4, 1, 57, 1, '2019-02-03 12:34:11', NULL),
(385, 2, 55, 2, 2, 4, 2, 57, 1, '2019-02-03 12:34:11', NULL),
(386, 2, 55, 2, 2, 4, 3, 57, 1, '2019-02-03 12:34:11', NULL),
(387, 2, 55, 2, 2, 4, 4, 57, 1, '2019-02-03 12:34:11', NULL),
(388, 2, 55, 2, 2, 4, 5, 57, 1, '2019-02-03 12:34:11', NULL),
(389, 2, 55, 2, 2, 4, 6, 57, 1, '2019-02-03 12:34:11', NULL),
(390, 1, 56, 2, 2, 4, 1, 58, 1, '2019-02-03 12:35:41', NULL),
(391, 2, 56, 2, 2, 4, 2, 58, 1, '2019-02-03 12:35:41', NULL),
(392, 2, 56, 2, 2, 4, 3, 58, 1, '2019-02-03 12:35:41', NULL),
(393, 2, 56, 2, 2, 4, 4, 58, 1, '2019-02-03 12:35:41', NULL),
(394, 2, 56, 2, 2, 4, 5, 58, 1, '2019-02-03 12:35:41', NULL),
(395, 2, 56, 2, 2, 4, 6, 58, 1, '2019-02-03 12:35:41', NULL),
(396, 1, 57, 2, 2, 4, 1, 59, 1, '2019-02-03 12:36:44', NULL),
(397, 2, 57, 2, 2, 4, 2, 59, 1, '2019-02-03 12:36:44', NULL),
(398, 2, 57, 2, 2, 4, 3, 59, 1, '2019-02-03 12:36:44', NULL),
(399, 2, 57, 2, 2, 4, 4, 59, 1, '2019-02-03 12:36:44', NULL),
(400, 2, 57, 2, 2, 4, 5, 59, 1, '2019-02-03 12:36:44', NULL),
(401, 2, 57, 2, 2, 4, 6, 59, 1, '2019-02-03 12:36:44', NULL),
(402, 1, 58, 1, 1, 4, 1, 60, 1, '2019-02-03 12:37:58', '2019-02-03 13:21:42'),
(403, 2, 58, 2, 2, 4, 2, 60, 1, '2019-02-03 12:37:58', NULL),
(404, 2, 58, 2, 2, 4, 3, 60, 1, '2019-02-03 12:37:58', NULL),
(405, 2, 58, 2, 2, 4, 4, 60, 1, '2019-02-03 12:37:58', NULL),
(406, 2, 58, 2, 2, 4, 5, 60, 1, '2019-02-03 12:37:58', NULL),
(407, 2, 58, 2, 2, 4, 6, 60, 1, '2019-02-03 12:37:58', NULL),
(408, 1, 59, 2, 2, 4, 1, 61, 1, '2019-02-03 12:39:05', NULL),
(409, 2, 59, 2, 2, 4, 2, 61, 1, '2019-02-03 12:39:05', NULL),
(410, 2, 59, 2, 2, 4, 3, 61, 1, '2019-02-03 12:39:05', NULL),
(411, 2, 59, 2, 2, 4, 4, 61, 1, '2019-02-03 12:39:05', NULL),
(412, 2, 59, 2, 2, 4, 5, 61, 1, '2019-02-03 12:39:05', NULL),
(413, 2, 59, 2, 2, 4, 6, 61, 1, '2019-02-03 12:39:05', NULL),
(414, 1, 60, 2, 2, 4, 1, 62, 1, '2019-02-03 12:40:22', NULL),
(415, 2, 60, 2, 2, 4, 2, 62, 1, '2019-02-03 12:40:22', NULL),
(416, 2, 60, 2, 2, 4, 3, 62, 1, '2019-02-03 12:40:22', NULL),
(417, 2, 60, 2, 2, 4, 4, 62, 1, '2019-02-03 12:40:22', NULL),
(418, 2, 60, 2, 2, 4, 5, 62, 1, '2019-02-03 12:40:22', NULL),
(419, 2, 60, 2, 2, 4, 6, 62, 1, '2019-02-03 12:40:22', NULL),
(420, 1, 61, 2, 2, 4, 1, 63, 1, '2019-02-03 12:41:36', NULL),
(421, 2, 61, 2, 2, 4, 2, 63, 1, '2019-02-03 12:41:36', NULL),
(422, 2, 61, 2, 2, 4, 3, 63, 1, '2019-02-03 12:41:36', NULL),
(423, 2, 61, 2, 2, 4, 4, 63, 1, '2019-02-03 12:41:36', NULL),
(424, 2, 61, 2, 2, 4, 5, 63, 1, '2019-02-03 12:41:36', NULL),
(425, 2, 61, 2, 2, 4, 6, 63, 1, '2019-02-03 12:41:36', NULL),
(426, 1, 62, 2, 2, 4, 1, 64, 1, '2019-02-03 12:42:40', NULL),
(427, 2, 62, 2, 2, 4, 2, 64, 1, '2019-02-03 12:42:40', NULL),
(428, 2, 62, 2, 2, 4, 3, 64, 1, '2019-02-03 12:42:40', NULL),
(429, 2, 62, 2, 2, 4, 4, 64, 1, '2019-02-03 12:42:40', NULL),
(430, 2, 62, 2, 2, 4, 5, 64, 1, '2019-02-03 12:42:40', NULL),
(431, 2, 62, 2, 2, 4, 6, 64, 1, '2019-02-03 12:42:40', NULL),
(432, 1, 63, 2, 2, 4, 1, 65, 1, '2019-02-03 12:45:49', NULL),
(433, 2, 63, 2, 2, 4, 2, 65, 1, '2019-02-03 12:45:49', NULL),
(434, 2, 63, 2, 2, 4, 3, 65, 1, '2019-02-03 12:45:49', NULL),
(435, 2, 63, 2, 2, 4, 4, 65, 1, '2019-02-03 12:45:49', NULL),
(436, 2, 63, 2, 2, 4, 5, 65, 1, '2019-02-03 12:45:49', NULL),
(437, 2, 63, 2, 2, 4, 6, 65, 1, '2019-02-03 12:45:49', NULL),
(438, 1, 64, 1, 1, 4, 1, 66, 1, '2019-02-03 12:47:29', '2019-02-03 13:22:22'),
(439, 2, 64, 2, 2, 4, 2, 66, 1, '2019-02-03 12:47:29', NULL),
(440, 2, 64, 2, 2, 4, 3, 66, 1, '2019-02-03 12:47:29', NULL),
(441, 2, 64, 2, 2, 4, 4, 66, 1, '2019-02-03 12:47:29', NULL),
(442, 2, 64, 2, 2, 4, 5, 66, 1, '2019-02-03 12:47:29', NULL),
(443, 2, 64, 2, 2, 4, 6, 66, 1, '2019-02-03 12:47:29', NULL),
(444, 1, 65, 2, 2, 4, 1, 67, 1, '2019-02-03 12:54:22', NULL),
(445, 2, 65, 2, 2, 4, 2, 67, 1, '2019-02-03 12:54:22', NULL),
(446, 2, 65, 2, 2, 4, 3, 67, 1, '2019-02-03 12:54:22', NULL),
(447, 2, 65, 2, 2, 4, 4, 67, 1, '2019-02-03 12:54:22', NULL),
(448, 2, 65, 2, 2, 4, 5, 67, 1, '2019-02-03 12:54:22', NULL),
(449, 2, 65, 2, 2, 4, 6, 67, 1, '2019-02-03 12:54:22', NULL),
(450, 1, 66, 2, 2, 4, 1, 68, 1, '2019-02-03 12:55:21', NULL),
(451, 2, 66, 2, 2, 4, 2, 68, 1, '2019-02-03 12:55:21', NULL),
(452, 2, 66, 2, 2, 4, 3, 68, 1, '2019-02-03 12:55:21', NULL),
(453, 2, 66, 2, 2, 4, 4, 68, 1, '2019-02-03 12:55:21', NULL),
(454, 2, 66, 2, 2, 4, 5, 68, 1, '2019-02-03 12:55:21', NULL),
(455, 2, 66, 2, 2, 4, 6, 68, 1, '2019-02-03 12:55:21', NULL),
(456, 1, 67, 2, 2, 4, 1, 69, 1, '2019-02-03 13:13:18', NULL),
(457, 1, 68, 2, 2, 4, 1, 70, 1, '2019-02-03 13:13:18', NULL),
(458, 1, 69, 2, 2, 4, 1, 71, 1, '2019-02-03 13:13:18', NULL),
(459, 1, 70, 1, 1, 4, 1, 72, 1, '2019-02-03 13:13:18', '2019-02-03 13:27:46'),
(460, 1, 71, 2, 2, 4, 1, 73, 1, '2019-02-03 13:13:18', NULL),
(461, 1, 72, 2, 2, 4, 1, 74, 1, '2019-02-03 13:13:18', NULL),
(462, 1, 73, 2, 2, 4, 1, 75, 1, '2019-02-03 13:13:18', NULL),
(463, 1, 74, 2, 2, 4, 1, 76, 1, '2019-02-03 13:13:18', NULL),
(464, 1, 75, 1, 1, 4, 1, 77, 1, '2019-02-03 13:13:18', '2019-02-03 13:28:11'),
(465, 1, 76, 2, 2, 4, 1, 78, 1, '2019-02-03 13:13:18', NULL),
(466, 1, 77, 2, 2, 4, 1, 79, 1, '2019-02-03 13:13:18', NULL),
(467, 1, 78, 2, 2, 4, 1, 80, 1, '2019-02-03 13:13:18', NULL),
(468, 1, 79, 2, 2, 4, 1, 81, 1, '2019-02-03 13:13:18', NULL),
(469, 1, 80, 1, 1, 4, 1, 82, 1, '2019-02-03 13:13:18', '2019-02-03 13:28:23'),
(470, 1, 81, 2, 2, 4, 1, 83, 1, '2019-02-03 13:13:18', NULL),
(471, 1, 82, 2, 2, 4, 1, 84, 1, '2019-02-03 13:13:18', NULL),
(472, 1, 83, 2, 2, 4, 1, 85, 1, '2019-02-03 13:13:18', NULL),
(473, 1, 84, 2, 2, 4, 1, 86, 1, '2019-02-03 13:13:18', NULL),
(474, 2, 67, 2, 2, 4, 2, 69, 1, '2019-02-03 13:13:18', NULL),
(475, 2, 68, 2, 2, 4, 2, 70, 1, '2019-02-03 13:13:19', NULL),
(476, 2, 69, 2, 2, 4, 2, 71, 1, '2019-02-03 13:13:19', NULL),
(477, 2, 70, 2, 2, 4, 2, 72, 1, '2019-02-03 13:13:19', NULL),
(478, 2, 71, 2, 2, 4, 2, 73, 1, '2019-02-03 13:13:19', NULL),
(479, 2, 72, 2, 2, 4, 2, 74, 1, '2019-02-03 13:13:19', NULL),
(480, 2, 73, 2, 2, 4, 2, 75, 1, '2019-02-03 13:13:19', NULL),
(481, 2, 74, 2, 2, 4, 2, 76, 1, '2019-02-03 13:13:19', NULL),
(482, 2, 75, 2, 2, 4, 2, 77, 1, '2019-02-03 13:13:19', NULL),
(483, 2, 76, 2, 2, 4, 2, 78, 1, '2019-02-03 13:13:19', NULL),
(484, 2, 77, 2, 2, 4, 2, 79, 1, '2019-02-03 13:13:19', NULL),
(485, 2, 78, 2, 2, 4, 2, 80, 1, '2019-02-03 13:13:19', NULL),
(486, 2, 79, 2, 2, 4, 2, 81, 1, '2019-02-03 13:13:19', NULL),
(487, 2, 80, 2, 2, 4, 2, 82, 1, '2019-02-03 13:13:19', NULL),
(488, 2, 81, 2, 2, 4, 2, 83, 1, '2019-02-03 13:13:19', NULL),
(489, 2, 82, 2, 2, 4, 2, 84, 1, '2019-02-03 13:13:19', NULL),
(490, 2, 83, 2, 2, 4, 2, 85, 1, '2019-02-03 13:13:19', NULL),
(491, 2, 84, 2, 2, 4, 2, 86, 1, '2019-02-03 13:13:19', NULL),
(492, 2, 67, 2, 2, 4, 3, 69, 1, '2019-02-03 13:13:19', NULL),
(493, 2, 68, 2, 2, 4, 3, 70, 1, '2019-02-03 13:13:19', NULL),
(494, 2, 69, 2, 2, 4, 3, 71, 1, '2019-02-03 13:13:19', NULL),
(495, 2, 70, 2, 2, 4, 3, 72, 1, '2019-02-03 13:13:19', NULL),
(496, 2, 71, 2, 2, 4, 3, 73, 1, '2019-02-03 13:13:19', NULL),
(497, 2, 72, 2, 2, 4, 3, 74, 1, '2019-02-03 13:13:19', NULL),
(498, 2, 73, 2, 2, 4, 3, 75, 1, '2019-02-03 13:13:19', NULL),
(499, 2, 74, 2, 2, 4, 3, 76, 1, '2019-02-03 13:13:19', NULL),
(500, 2, 75, 2, 2, 4, 3, 77, 1, '2019-02-03 13:13:19', NULL),
(501, 2, 76, 2, 2, 4, 3, 78, 1, '2019-02-03 13:13:19', NULL),
(502, 2, 77, 2, 2, 4, 3, 79, 1, '2019-02-03 13:13:19', NULL),
(503, 2, 78, 2, 2, 4, 3, 80, 1, '2019-02-03 13:13:19', NULL),
(504, 2, 79, 2, 2, 4, 3, 81, 1, '2019-02-03 13:13:19', NULL),
(505, 2, 80, 2, 2, 4, 3, 82, 1, '2019-02-03 13:13:19', NULL),
(506, 2, 81, 2, 2, 4, 3, 83, 1, '2019-02-03 13:13:19', NULL),
(507, 2, 82, 2, 2, 4, 3, 84, 1, '2019-02-03 13:13:19', NULL),
(508, 2, 83, 2, 2, 4, 3, 85, 1, '2019-02-03 13:13:19', NULL),
(509, 2, 84, 2, 2, 4, 3, 86, 1, '2019-02-03 13:13:19', NULL),
(510, 2, 67, 2, 2, 4, 4, 69, 1, '2019-02-03 13:13:19', NULL),
(511, 2, 68, 2, 2, 4, 4, 70, 1, '2019-02-03 13:13:19', NULL),
(512, 2, 69, 2, 2, 4, 4, 71, 1, '2019-02-03 13:13:19', NULL),
(513, 2, 70, 2, 2, 4, 4, 72, 1, '2019-02-03 13:13:19', NULL),
(514, 2, 71, 2, 2, 4, 4, 73, 1, '2019-02-03 13:13:19', NULL),
(515, 2, 72, 2, 2, 4, 4, 74, 1, '2019-02-03 13:13:19', NULL),
(516, 2, 73, 2, 2, 4, 4, 75, 1, '2019-02-03 13:13:19', NULL),
(517, 2, 74, 2, 2, 4, 4, 76, 1, '2019-02-03 13:13:19', NULL),
(518, 2, 75, 2, 2, 4, 4, 77, 1, '2019-02-03 13:13:19', NULL),
(519, 2, 76, 2, 2, 4, 4, 78, 1, '2019-02-03 13:13:19', NULL),
(520, 2, 77, 2, 2, 4, 4, 79, 1, '2019-02-03 13:13:19', NULL),
(521, 2, 78, 2, 2, 4, 4, 80, 1, '2019-02-03 13:13:19', NULL),
(522, 2, 79, 2, 2, 4, 4, 81, 1, '2019-02-03 13:13:19', NULL),
(523, 2, 80, 2, 2, 4, 4, 82, 1, '2019-02-03 13:13:19', NULL),
(524, 2, 81, 2, 2, 4, 4, 83, 1, '2019-02-03 13:13:19', NULL),
(525, 2, 82, 2, 2, 4, 4, 84, 1, '2019-02-03 13:13:19', NULL),
(526, 2, 83, 2, 2, 4, 4, 85, 1, '2019-02-03 13:13:19', NULL),
(527, 2, 84, 2, 2, 4, 4, 86, 1, '2019-02-03 13:13:19', NULL),
(528, 2, 67, 2, 2, 4, 5, 69, 1, '2019-02-03 13:13:19', NULL),
(529, 2, 68, 2, 2, 4, 5, 70, 1, '2019-02-03 13:13:19', NULL),
(530, 2, 69, 2, 2, 4, 5, 71, 1, '2019-02-03 13:13:19', NULL),
(531, 2, 70, 2, 2, 4, 5, 72, 1, '2019-02-03 13:13:19', NULL),
(532, 2, 71, 2, 2, 4, 5, 73, 1, '2019-02-03 13:13:19', NULL),
(533, 2, 72, 2, 2, 4, 5, 74, 1, '2019-02-03 13:13:19', NULL),
(534, 2, 73, 2, 2, 4, 5, 75, 1, '2019-02-03 13:13:19', NULL),
(535, 2, 74, 2, 2, 4, 5, 76, 1, '2019-02-03 13:13:19', NULL),
(536, 2, 75, 2, 2, 4, 5, 77, 1, '2019-02-03 13:13:19', NULL),
(537, 2, 76, 2, 2, 4, 5, 78, 1, '2019-02-03 13:13:19', NULL),
(538, 2, 77, 2, 2, 4, 5, 79, 1, '2019-02-03 13:13:19', NULL),
(539, 2, 78, 2, 2, 4, 5, 80, 1, '2019-02-03 13:13:19', NULL),
(540, 2, 79, 2, 2, 4, 5, 81, 1, '2019-02-03 13:13:19', NULL),
(541, 2, 80, 2, 2, 4, 5, 82, 1, '2019-02-03 13:13:19', NULL),
(542, 2, 81, 2, 2, 4, 5, 83, 1, '2019-02-03 13:13:19', NULL),
(543, 2, 82, 2, 2, 4, 5, 84, 1, '2019-02-03 13:13:19', NULL),
(544, 2, 83, 2, 2, 4, 5, 85, 1, '2019-02-03 13:13:19', NULL),
(545, 2, 84, 2, 2, 4, 5, 86, 1, '2019-02-03 13:13:19', NULL),
(546, 2, 67, 2, 2, 4, 6, 69, 1, '2019-02-03 13:13:19', NULL),
(547, 2, 68, 2, 2, 4, 6, 70, 1, '2019-02-03 13:13:19', NULL),
(548, 2, 69, 2, 2, 4, 6, 71, 1, '2019-02-03 13:13:19', NULL),
(549, 2, 70, 2, 2, 4, 6, 72, 1, '2019-02-03 13:13:19', NULL),
(550, 2, 71, 2, 2, 4, 6, 73, 1, '2019-02-03 13:13:19', NULL),
(551, 2, 72, 2, 2, 4, 6, 74, 1, '2019-02-03 13:13:19', NULL),
(552, 2, 73, 2, 2, 4, 6, 75, 1, '2019-02-03 13:13:19', NULL),
(553, 2, 74, 2, 2, 4, 6, 76, 1, '2019-02-03 13:13:19', NULL),
(554, 2, 75, 2, 2, 4, 6, 77, 1, '2019-02-03 13:13:19', NULL),
(555, 2, 76, 2, 2, 4, 6, 78, 1, '2019-02-03 13:13:19', NULL),
(556, 2, 77, 2, 2, 4, 6, 79, 1, '2019-02-03 13:13:19', NULL),
(557, 2, 78, 2, 2, 4, 6, 80, 1, '2019-02-03 13:13:19', NULL),
(558, 2, 79, 2, 2, 4, 6, 81, 1, '2019-02-03 13:13:19', NULL),
(559, 2, 80, 2, 2, 4, 6, 82, 1, '2019-02-03 13:13:19', NULL),
(560, 2, 81, 2, 2, 4, 6, 83, 1, '2019-02-03 13:13:19', NULL),
(561, 2, 82, 2, 2, 4, 6, 84, 1, '2019-02-03 13:13:19', NULL),
(562, 2, 83, 2, 2, 4, 6, 85, 1, '2019-02-03 13:13:19', NULL),
(563, 2, 84, 2, 2, 4, 6, 86, 1, '2019-02-03 13:13:19', NULL),
(564, 1, 85, 2, 1, 11, 1, 87, 1, '2019-02-03 18:09:17', '2019-03-25 17:36:12'),
(565, 1, 85, 2, 1, 11, 2, 87, 1, '2019-02-03 18:09:17', '2019-03-25 17:37:14'),
(566, 1, 85, 2, 1, 11, 3, 87, 1, '2019-02-03 18:09:17', '2019-03-25 17:37:30'),
(567, 1, 85, 2, 1, 10, 4, 87, 1, '2019-02-03 18:09:17', '2019-03-25 17:38:54'),
(568, 2, 85, 2, 2, 4, 5, 87, 1, '2019-02-03 18:09:17', NULL),
(569, 2, 85, 2, 2, 4, 6, 87, 1, '2019-02-03 18:09:17', NULL),
(570, 1, 86, 2, 2, 11, 1, 88, 1, '2019-02-03 18:14:33', '2019-02-14 14:43:05'),
(571, 2, 86, 2, 2, 4, 2, 88, 1, '2019-02-03 18:14:33', '2019-02-03 19:16:48'),
(572, 2, 86, 2, 2, 4, 3, 88, 1, '2019-02-03 18:14:33', NULL),
(573, 2, 86, 1, 2, 10, 4, 88, 1, '2019-02-03 18:14:33', '2019-03-25 17:38:35'),
(574, 2, 86, 2, 2, 4, 5, 88, 1, '2019-02-03 18:14:33', NULL),
(575, 2, 86, 2, 2, 4, 6, 88, 1, '2019-02-03 18:14:33', NULL),
(576, 1, 87, 1, 2, 11, 1, 89, 1, '2019-02-03 18:18:40', '2019-03-25 17:36:20'),
(577, 2, 87, 2, 2, 4, 2, 89, 1, '2019-02-03 18:18:40', NULL),
(578, 2, 87, 2, 2, 4, 3, 89, 1, '2019-02-03 18:18:40', NULL),
(579, 1, 87, 1, 2, 10, 4, 89, 1, '2019-02-03 18:18:40', '2019-03-25 17:38:42'),
(580, 2, 87, 2, 2, 4, 5, 89, 1, '2019-02-03 18:18:40', NULL),
(581, 2, 87, 2, 2, 4, 6, 89, 1, '2019-02-03 18:18:40', NULL),
(582, 1, 88, 1, 1, 5, 1, 90, 1, '2019-02-03 18:40:08', '2019-02-04 13:12:46'),
(583, 1, 88, 1, 1, 5, 2, 90, 1, '2019-02-03 18:40:08', '2019-02-03 19:17:12'),
(584, 1, 88, 1, 1, 5, 3, 90, 1, '2019-02-03 18:40:08', '2019-02-03 18:41:26'),
(585, 2, 88, 2, 2, 4, 4, 90, 1, '2019-02-03 18:40:08', NULL),
(586, 2, 88, 2, 2, 4, 5, 90, 1, '2019-02-03 18:40:08', NULL),
(587, 2, 88, 2, 2, 4, 6, 90, 1, '2019-02-03 18:40:08', NULL),
(588, 1, 89, 2, 2, 4, 1, 91, 1, '2019-02-04 12:20:04', NULL),
(589, 2, 89, 2, 2, 4, 2, 91, 1, '2019-02-04 12:20:04', NULL),
(590, 1, 89, 2, 2, 4, 3, 91, 1, '2019-02-04 12:20:04', '2019-02-07 12:35:04'),
(591, 2, 89, 2, 2, 4, 4, 91, 1, '2019-02-04 12:20:04', NULL),
(592, 2, 89, 2, 2, 4, 5, 91, 1, '2019-02-04 12:20:04', NULL),
(593, 1, 89, 2, 2, 4, 6, 91, 1, '2019-02-04 12:20:04', '2019-02-04 13:14:06'),
(594, 1, 90, 2, 2, 4, 1, 92, 1, '2019-02-04 15:33:16', NULL),
(595, 1, 90, 2, 2, 4, 2, 92, 1, '2019-02-04 15:33:16', '2019-02-04 15:34:49'),
(596, 1, 90, 2, 2, 4, 3, 92, 1, '2019-02-04 15:33:16', '2019-02-04 15:34:59'),
(597, 2, 90, 2, 2, 4, 4, 92, 1, '2019-02-04 15:33:16', NULL),
(598, 2, 90, 2, 2, 4, 5, 92, 1, '2019-02-04 15:33:16', NULL),
(599, 2, 90, 2, 2, 4, 6, 92, 1, '2019-02-04 15:33:16', NULL),
(600, 1, 91, 2, 2, 4, 1, 93, 1, '2019-02-04 15:36:35', NULL),
(601, 1, 91, 2, 2, 4, 2, 93, 1, '2019-02-04 15:36:35', '2019-02-04 15:36:49'),
(602, 1, 91, 2, 2, 4, 3, 93, 1, '2019-02-04 15:36:35', '2019-02-04 15:36:42'),
(603, 2, 91, 2, 2, 4, 4, 93, 1, '2019-02-04 15:36:35', NULL),
(604, 2, 91, 2, 2, 4, 5, 93, 1, '2019-02-04 15:36:35', NULL),
(605, 2, 91, 2, 2, 4, 6, 93, 1, '2019-02-04 15:36:35', NULL),
(606, 1, 92, 2, 2, 4, 1, 94, 1, '2019-02-04 15:37:56', NULL),
(607, 1, 92, 2, 2, 4, 2, 94, 1, '2019-02-04 15:37:56', '2019-02-04 15:38:09'),
(608, 1, 92, 2, 2, 4, 3, 94, 1, '2019-02-04 15:37:56', '2019-02-04 15:38:03'),
(609, 2, 92, 2, 2, 4, 4, 94, 1, '2019-02-04 15:37:56', NULL),
(610, 2, 92, 2, 2, 4, 5, 94, 1, '2019-02-04 15:37:56', NULL),
(611, 2, 92, 2, 2, 4, 6, 94, 1, '2019-02-04 15:37:56', NULL),
(612, 1, 93, 2, 2, 4, 1, 95, 1, '2019-02-05 12:26:53', NULL),
(613, 1, 93, 2, 2, 4, 2, 95, 1, '2019-02-05 12:26:53', '2019-02-05 12:29:23'),
(614, 1, 93, 2, 2, 4, 3, 95, 1, '2019-02-05 12:26:53', '2019-02-05 12:29:31'),
(615, 2, 93, 2, 2, 4, 4, 95, 1, '2019-02-05 12:26:53', NULL),
(616, 2, 93, 2, 2, 4, 5, 95, 1, '2019-02-05 12:26:53', NULL),
(617, 1, 93, 2, 2, 4, 6, 95, 1, '2019-02-05 12:26:53', '2019-02-05 12:29:43'),
(618, 1, 94, 2, 2, 4, 1, 96, 1, '2019-02-05 12:53:22', NULL),
(619, 1, 94, 2, 2, 4, 2, 96, 1, '2019-02-05 12:53:22', '2019-02-05 12:53:30'),
(620, 1, 94, 2, 2, 4, 3, 96, 1, '2019-02-05 12:53:22', '2019-02-05 12:54:02'),
(621, 2, 94, 2, 2, 4, 4, 96, 1, '2019-02-05 12:53:22', NULL),
(622, 2, 94, 2, 2, 4, 5, 96, 1, '2019-02-05 12:53:22', NULL),
(623, 1, 94, 2, 2, 4, 6, 96, 1, '2019-02-05 12:53:22', '2019-02-05 12:54:20'),
(624, 1, 95, 2, 2, 4, 1, 97, 1, '2019-02-05 13:05:42', NULL),
(625, 1, 95, 2, 2, 4, 2, 97, 1, '2019-02-05 13:05:42', '2019-02-05 13:06:03'),
(626, 1, 95, 2, 2, 4, 3, 97, 1, '2019-02-05 13:05:42', '2019-02-05 13:05:56'),
(627, 2, 95, 2, 2, 4, 4, 97, 1, '2019-02-05 13:05:42', NULL),
(628, 2, 95, 2, 2, 4, 5, 97, 1, '2019-02-05 13:05:42', NULL),
(629, 1, 95, 2, 2, 4, 6, 97, 1, '2019-02-05 13:05:42', '2019-02-05 13:05:48'),
(630, 1, 96, 2, 2, 4, 1, 98, 1, '2019-02-05 14:19:18', NULL),
(631, 1, 96, 2, 2, 4, 2, 98, 1, '2019-02-05 14:19:18', '2019-02-05 14:20:55'),
(632, 1, 96, 2, 2, 4, 3, 98, 1, '2019-02-05 14:19:18', '2019-02-05 14:21:41'),
(633, 2, 96, 2, 2, 4, 4, 98, 1, '2019-02-05 14:19:18', NULL),
(634, 2, 96, 2, 2, 4, 5, 98, 1, '2019-02-05 14:19:18', NULL),
(635, 2, 96, 2, 2, 4, 6, 98, 1, '2019-02-05 14:19:18', NULL),
(636, 1, 97, 2, 2, 4, 1, 99, 1, '2019-02-05 14:45:01', NULL),
(637, 1, 97, 2, 2, 4, 2, 99, 1, '2019-02-05 14:45:01', '2019-02-05 14:47:25'),
(638, 1, 97, 2, 2, 4, 3, 99, 1, '2019-02-05 14:45:01', '2019-02-05 14:47:30'),
(639, 2, 97, 2, 2, 4, 4, 99, 1, '2019-02-05 14:45:01', NULL),
(640, 2, 97, 2, 2, 4, 5, 99, 1, '2019-02-05 14:45:01', NULL),
(641, 2, 97, 2, 2, 4, 6, 99, 1, '2019-02-05 14:45:01', NULL),
(642, 1, 98, 2, 2, 4, 1, 100, 1, '2019-02-05 17:45:16', NULL),
(643, 1, 98, 2, 2, 4, 2, 100, 1, '2019-02-05 17:45:16', '2019-02-06 16:26:25'),
(644, 1, 98, 2, 2, 4, 3, 100, 1, '2019-02-05 17:45:16', '2019-02-06 16:26:15'),
(645, 2, 98, 2, 2, 4, 4, 100, 1, '2019-02-05 17:45:16', NULL),
(646, 2, 98, 2, 2, 4, 5, 100, 1, '2019-02-05 17:45:16', NULL),
(647, 2, 98, 2, 2, 4, 6, 100, 1, '2019-02-05 17:45:16', NULL),
(648, 1, 1, 2, 1, 1, 7, 1, 1, '2019-02-07 16:16:39', '2019-02-07 16:24:36'),
(649, 2, 2, 2, 2, 4, 7, 2, 1, '2019-02-07 16:16:39', '2019-02-07 16:25:03'),
(650, 1, 3, 2, 2, 4, 7, 3, 1, '2019-02-07 16:16:39', NULL),
(651, 1, 4, 2, 1, 3, 7, 4, 1, '2019-02-07 16:16:39', '2019-02-07 16:25:17'),
(652, 1, 5, 2, 2, 4, 7, 5, 1, '2019-02-07 16:16:39', NULL),
(653, 1, 6, 2, 2, 4, 7, 6, 1, '2019-02-07 16:16:39', NULL),
(654, 1, 7, 2, 2, 4, 7, 7, 1, '2019-02-07 16:16:39', NULL),
(655, 1, 8, 2, 2, 4, 7, 8, 1, '2019-02-07 16:16:39', NULL),
(656, 1, 9, 2, 2, 4, 7, 9, 1, '2019-02-07 16:16:39', '2019-02-07 16:19:59'),
(657, 1, 10, 2, 2, 4, 7, 10, 1, '2019-02-07 16:16:39', '2019-02-07 16:20:01'),
(658, 1, 11, 2, 2, 4, 7, 11, 1, '2019-02-07 16:16:39', '2019-02-07 16:21:06'),
(659, 1, 12, 2, 2, 4, 7, 12, 1, '2019-02-07 16:16:39', '2019-02-07 16:21:40'),
(660, 1, 13, 2, 2, 4, 7, 13, 1, '2019-02-07 16:16:39', '2019-02-07 16:21:19'),
(661, 2, 14, 2, 2, 4, 7, 14, 1, '2019-02-07 16:16:39', NULL),
(662, 2, 15, 2, 2, 4, 7, 15, 1, '2019-02-07 16:16:39', NULL),
(663, 2, 16, 2, 2, 4, 7, 16, 1, '2019-02-07 16:16:39', NULL),
(664, 1, 17, 1, 1, 9, 7, 17, 1, '2019-02-07 16:16:39', '2019-02-07 16:26:15'),
(665, 1, 18, 1, 1, 9, 7, 18, 1, '2019-02-07 16:16:39', '2019-02-07 16:26:27'),
(666, 2, 19, 2, 2, 4, 7, 19, 1, '2019-02-07 16:16:39', NULL),
(667, 2, 20, 2, 2, 4, 7, 20, 1, '2019-02-07 16:16:39', NULL),
(668, 2, 21, 2, 2, 4, 7, 21, 1, '2019-02-07 16:16:39', NULL),
(669, 2, 22, 2, 2, 4, 7, 22, 1, '2019-02-07 16:16:39', NULL),
(670, 2, 23, 2, 2, 4, 7, 23, 1, '2019-02-07 16:16:39', NULL),
(671, 2, 24, 2, 2, 4, 7, 24, 1, '2019-02-07 16:16:39', NULL),
(672, 2, 25, 2, 2, 4, 7, 25, 1, '2019-02-07 16:16:39', NULL),
(673, 2, 26, 2, 2, 4, 7, 26, 1, '2019-02-07 16:16:39', NULL),
(674, 2, 27, 2, 2, 4, 7, 27, 1, '2019-02-07 16:16:39', NULL),
(675, 2, 28, 2, 2, 4, 7, 28, 1, '2019-02-07 16:16:39', NULL),
(676, 2, 29, 2, 2, 4, 7, 30, 1, '2019-02-07 16:16:39', NULL),
(677, 1, 30, 2, 2, 4, 7, 31, 1, '2019-02-07 16:16:39', '2019-02-07 16:23:04'),
(678, 2, 31, 2, 2, 4, 7, 32, 1, '2019-02-07 16:16:39', NULL),
(679, 2, 32, 2, 2, 4, 7, 33, 1, '2019-02-07 16:16:39', NULL),
(680, 2, 33, 2, 2, 4, 7, 34, 1, '2019-02-07 16:16:39', NULL),
(681, 2, 34, 2, 2, 4, 7, 35, 1, '2019-02-07 16:16:39', NULL),
(682, 2, 35, 2, 2, 4, 7, 36, 1, '2019-02-07 16:16:39', NULL),
(683, 1, 36, 2, 1, 6, 7, 37, 1, '2019-02-07 16:16:39', '2019-02-07 16:28:46'),
(684, 1, 37, 2, 2, 6, 7, 38, 1, '2019-02-07 16:16:39', '2019-02-07 16:29:28'),
(685, 2, 38, 2, 2, 4, 7, 39, 1, '2019-02-07 16:16:39', NULL),
(686, 2, 39, 2, 2, 4, 7, 41, 1, '2019-02-07 16:16:39', NULL),
(687, 2, 40, 2, 2, 4, 7, 42, 1, '2019-02-07 16:16:39', NULL),
(688, 2, 41, 2, 2, 4, 7, 43, 1, '2019-02-07 16:16:39', NULL),
(689, 2, 42, 2, 2, 4, 7, 44, 1, '2019-02-07 16:16:39', NULL),
(690, 2, 43, 2, 2, 4, 7, 45, 1, '2019-02-07 16:16:39', NULL),
(691, 2, 44, 2, 2, 4, 7, 46, 1, '2019-02-07 16:16:39', '2019-02-07 16:31:14'),
(692, 2, 45, 2, 2, 4, 7, 47, 1, '2019-02-07 16:16:39', '2019-02-07 16:31:13'),
(693, 2, 46, 2, 2, 4, 7, 48, 1, '2019-02-07 16:16:39', NULL),
(694, 2, 47, 2, 2, 4, 7, 49, 1, '2019-02-07 16:16:39', NULL),
(695, 2, 48, 2, 2, 4, 7, 50, 1, '2019-02-07 16:16:39', NULL),
(696, 2, 49, 2, 2, 4, 7, 51, 1, '2019-02-07 16:16:39', NULL),
(697, 2, 50, 2, 2, 4, 7, 52, 1, '2019-02-07 16:16:39', NULL),
(698, 2, 51, 2, 2, 4, 7, 53, 1, '2019-02-07 16:16:39', NULL),
(699, 2, 52, 2, 2, 4, 7, 54, 1, '2019-02-07 16:16:39', NULL),
(700, 2, 53, 2, 2, 4, 7, 55, 1, '2019-02-07 16:16:39', NULL),
(701, 2, 54, 2, 2, 4, 7, 56, 1, '2019-02-07 16:16:39', NULL),
(702, 2, 55, 2, 2, 4, 7, 57, 1, '2019-02-07 16:16:39', NULL),
(703, 2, 56, 2, 2, 4, 7, 58, 1, '2019-02-07 16:16:39', NULL),
(704, 2, 57, 2, 2, 4, 7, 59, 1, '2019-02-07 16:16:39', NULL),
(705, 2, 58, 2, 2, 4, 7, 60, 1, '2019-02-07 16:16:39', NULL),
(706, 2, 59, 2, 2, 4, 7, 61, 1, '2019-02-07 16:16:39', NULL),
(707, 2, 60, 2, 2, 4, 7, 62, 1, '2019-02-07 16:16:39', NULL),
(708, 2, 61, 2, 2, 4, 7, 63, 1, '2019-02-07 16:16:39', NULL),
(709, 2, 62, 2, 2, 4, 7, 64, 1, '2019-02-07 16:16:39', NULL),
(710, 2, 63, 2, 2, 4, 7, 65, 1, '2019-02-07 16:16:39', NULL),
(711, 2, 64, 2, 2, 4, 7, 66, 1, '2019-02-07 16:16:39', NULL),
(712, 2, 65, 2, 2, 4, 7, 67, 1, '2019-02-07 16:16:39', NULL),
(713, 2, 66, 2, 2, 4, 7, 68, 1, '2019-02-07 16:16:39', NULL),
(714, 2, 67, 2, 2, 4, 7, 69, 1, '2019-02-07 16:16:39', NULL),
(715, 2, 68, 2, 2, 4, 7, 70, 1, '2019-02-07 16:16:39', NULL),
(716, 2, 69, 2, 2, 4, 7, 71, 1, '2019-02-07 16:16:39', NULL),
(717, 2, 70, 2, 2, 4, 7, 72, 1, '2019-02-07 16:16:39', NULL),
(718, 2, 71, 2, 2, 4, 7, 73, 1, '2019-02-07 16:16:39', NULL),
(719, 2, 72, 2, 2, 4, 7, 74, 1, '2019-02-07 16:16:39', NULL),
(720, 2, 73, 2, 2, 4, 7, 75, 1, '2019-02-07 16:16:39', NULL),
(721, 2, 74, 2, 2, 4, 7, 76, 1, '2019-02-07 16:16:39', NULL),
(722, 2, 75, 2, 2, 4, 7, 77, 1, '2019-02-07 16:16:39', NULL),
(723, 2, 76, 2, 2, 4, 7, 78, 1, '2019-02-07 16:16:39', NULL),
(724, 2, 77, 2, 2, 4, 7, 79, 1, '2019-02-07 16:16:39', NULL),
(725, 2, 78, 2, 2, 4, 7, 80, 1, '2019-02-07 16:16:39', NULL),
(726, 2, 79, 2, 2, 4, 7, 81, 1, '2019-02-07 16:16:39', NULL),
(727, 2, 80, 2, 2, 4, 7, 82, 1, '2019-02-07 16:16:39', NULL),
(728, 2, 81, 2, 2, 4, 7, 83, 1, '2019-02-07 16:16:39', NULL),
(729, 2, 82, 2, 2, 4, 7, 84, 1, '2019-02-07 16:16:39', NULL),
(730, 2, 83, 2, 2, 4, 7, 85, 1, '2019-02-07 16:16:39', NULL),
(731, 2, 84, 2, 2, 4, 7, 86, 1, '2019-02-07 16:16:39', NULL),
(732, 1, 85, 2, 2, 4, 7, 87, 1, '2019-02-07 16:16:39', '2019-02-07 16:33:20'),
(733, 1, 86, 2, 2, 4, 7, 88, 1, '2019-02-07 16:16:39', '2019-02-07 16:33:52'),
(734, 1, 87, 2, 2, 4, 7, 89, 1, '2019-02-07 16:16:39', '2019-02-07 16:33:59'),
(735, 1, 88, 1, 1, 9, 7, 90, 1, '2019-02-07 16:16:39', '2019-02-07 16:34:47'),
(736, 2, 89, 2, 2, 4, 7, 91, 1, '2019-02-07 16:16:39', NULL),
(737, 1, 90, 2, 2, 4, 7, 92, 1, '2019-02-07 16:16:39', '2019-02-07 16:38:20'),
(738, 2, 91, 2, 2, 4, 7, 93, 1, '2019-02-07 16:16:39', NULL),
(739, 2, 92, 2, 2, 4, 7, 94, 1, '2019-02-07 16:16:39', NULL),
(740, 1, 93, 2, 2, 4, 7, 95, 1, '2019-02-07 16:16:39', '2019-02-07 16:37:29'),
(741, 1, 94, 2, 2, 4, 7, 96, 1, '2019-02-07 16:16:39', '2019-02-07 16:35:51'),
(742, 2, 95, 2, 2, 4, 7, 97, 1, '2019-02-07 16:16:39', NULL),
(743, 1, 96, 2, 2, 4, 7, 98, 1, '2019-02-07 16:16:39', '2019-02-07 16:37:02'),
(744, 2, 97, 2, 2, 4, 7, 99, 1, '2019-02-07 16:16:39', NULL),
(745, 2, 98, 2, 2, 4, 7, 100, 1, '2019-02-07 16:16:39', NULL),
(746, 1, 99, 2, 2, 4, 1, 101, 1, '2019-02-11 13:29:45', NULL),
(747, 1, 99, 2, 2, 4, 2, 101, 1, '2019-02-11 13:29:45', '2019-02-11 17:41:56'),
(748, 1, 99, 2, 2, 4, 3, 101, 1, '2019-02-11 13:29:45', '2019-02-11 17:42:11'),
(749, 2, 99, 2, 2, 4, 4, 101, 1, '2019-02-11 13:29:45', NULL),
(750, 2, 99, 2, 2, 4, 5, 101, 1, '2019-02-11 13:29:45', NULL),
(751, 2, 99, 2, 2, 4, 6, 101, 1, '2019-02-11 13:29:45', NULL),
(752, 2, 99, 2, 2, 4, 7, 101, 1, '2019-02-11 13:29:45', NULL),
(753, 1, 100, 2, 2, 4, 1, 102, 1, '2019-02-11 17:41:21', NULL),
(754, 1, 100, 2, 2, 4, 2, 102, 1, '2019-02-11 17:41:21', '2019-02-11 17:41:57'),
(755, 1, 100, 2, 2, 4, 3, 102, 1, '2019-02-11 17:41:21', '2019-02-11 17:42:12'),
(756, 2, 100, 2, 2, 4, 4, 102, 1, '2019-02-11 17:41:21', NULL),
(757, 2, 100, 2, 2, 4, 5, 102, 1, '2019-02-11 17:41:21', NULL),
(758, 2, 100, 2, 2, 4, 6, 102, 1, '2019-02-11 17:41:21', NULL),
(759, 2, 100, 2, 2, 4, 7, 102, 1, '2019-02-11 17:41:21', NULL),
(760, 1, 101, 2, 2, 4, 1, 103, 1, '2019-02-12 17:13:05', NULL),
(761, 1, 101, 2, 2, 4, 2, 103, 1, '2019-02-12 17:13:05', '2019-02-12 17:13:18'),
(762, 1, 101, 2, 2, 4, 3, 103, 1, '2019-02-12 17:13:05', '2019-02-12 17:13:25'),
(763, 2, 101, 2, 2, 4, 4, 103, 1, '2019-02-12 17:13:05', NULL),
(764, 2, 101, 2, 2, 4, 5, 103, 1, '2019-02-12 17:13:05', NULL),
(765, 2, 101, 2, 2, 4, 6, 103, 1, '2019-02-12 17:13:05', NULL),
(766, 1, 101, 2, 2, 4, 7, 103, 1, '2019-02-12 17:13:05', '2019-02-12 17:14:05'),
(767, 1, 102, 2, 2, 4, 1, 104, 1, '2019-02-14 12:16:03', NULL),
(768, 2, 102, 2, 2, 4, 2, 104, 1, '2019-02-14 12:16:03', NULL),
(769, 2, 102, 2, 2, 4, 3, 104, 1, '2019-02-14 12:16:03', NULL),
(770, 1, 102, 2, 2, 4, 4, 104, 1, '2019-02-14 12:16:03', '2019-02-14 12:18:00'),
(771, 2, 102, 2, 2, 4, 5, 104, 1, '2019-02-14 12:16:03', NULL),
(772, 2, 102, 2, 2, 4, 6, 104, 1, '2019-02-14 12:16:03', NULL),
(773, 2, 102, 2, 2, 4, 7, 104, 1, '2019-02-14 12:16:03', NULL),
(774, 1, 103, 2, 2, 4, 1, 105, 1, '2019-02-15 16:03:30', NULL),
(775, 2, 103, 2, 2, 4, 2, 105, 1, '2019-02-15 16:03:30', NULL),
(776, 2, 103, 2, 2, 4, 3, 105, 1, '2019-02-15 16:03:30', NULL),
(777, 1, 103, 2, 2, 4, 4, 105, 1, '2019-02-15 16:03:30', '2019-02-15 16:03:44'),
(778, 2, 103, 2, 2, 4, 5, 105, 1, '2019-02-15 16:03:30', NULL),
(779, 2, 103, 2, 2, 4, 6, 105, 1, '2019-02-15 16:03:30', NULL),
(780, 2, 103, 2, 2, 4, 7, 105, 1, '2019-02-15 16:03:30', NULL),
(781, 1, 104, 2, 2, 4, 1, 106, 1, '2019-02-18 17:29:44', NULL),
(782, 2, 104, 2, 2, 4, 2, 106, 1, '2019-02-18 17:29:44', NULL),
(783, 2, 104, 2, 2, 4, 3, 106, 1, '2019-02-18 17:29:44', NULL),
(784, 1, 104, 2, 2, 4, 4, 106, 1, '2019-02-18 17:29:44', '2019-02-18 17:30:06'),
(785, 2, 104, 2, 2, 4, 5, 106, 1, '2019-02-18 17:29:44', NULL),
(786, 2, 104, 2, 2, 4, 6, 106, 1, '2019-02-18 17:29:44', NULL),
(787, 2, 104, 2, 2, 4, 7, 106, 1, '2019-02-18 17:29:44', NULL),
(788, 1, 105, 2, 2, 4, 1, 107, 1, '2019-02-19 17:12:36', NULL),
(789, 1, 105, 2, 2, 4, 2, 107, 1, '2019-02-19 17:12:36', '2019-02-19 17:13:06'),
(790, 1, 105, 2, 2, 4, 3, 107, 1, '2019-02-19 17:12:36', '2019-02-19 17:13:12'),
(791, 2, 105, 2, 2, 4, 4, 107, 1, '2019-02-19 17:12:36', NULL),
(792, 2, 105, 2, 2, 4, 5, 107, 1, '2019-02-19 17:12:36', NULL),
(793, 2, 105, 2, 2, 4, 6, 107, 1, '2019-02-19 17:12:36', NULL),
(794, 2, 105, 2, 2, 4, 7, 107, 1, '2019-02-19 17:12:36', NULL),
(795, 1, 106, 2, 2, 4, 1, 108, 1, '2019-02-22 14:06:13', NULL),
(796, 1, 106, 2, 2, 4, 2, 108, 1, '2019-02-22 14:06:13', '2019-03-21 13:02:58'),
(797, 1, 106, 2, 2, 4, 3, 108, 1, '2019-02-22 14:06:13', '2019-03-21 13:03:44'),
(798, 2, 106, 2, 2, 4, 4, 108, 1, '2019-02-22 14:06:13', NULL),
(799, 2, 106, 2, 2, 4, 5, 108, 1, '2019-02-22 14:06:13', NULL),
(800, 2, 106, 2, 2, 4, 6, 108, 1, '2019-02-22 14:06:13', NULL),
(801, 2, 106, 2, 2, 4, 7, 108, 1, '2019-02-22 14:06:13', NULL),
(802, 1, 107, 1, 1, 13, 1, 109, 1, '2019-03-21 12:59:20', '2019-03-25 12:55:00'),
(803, 1, 107, 1, 1, 13, 2, 109, 1, '2019-03-21 12:59:20', '2019-03-25 12:57:13'),
(804, 1, 107, 1, 1, 13, 3, 109, 1, '2019-03-21 12:59:20', '2019-03-25 12:57:30'),
(805, 2, 107, 2, 2, 4, 4, 109, 1, '2019-03-21 12:59:20', NULL),
(806, 2, 107, 2, 2, 4, 5, 109, 1, '2019-03-21 12:59:20', NULL),
(807, 2, 107, 2, 2, 4, 6, 109, 1, '2019-03-21 12:59:20', NULL),
(808, 2, 107, 2, 2, 4, 7, 109, 1, '2019-03-21 12:59:20', NULL),
(809, 1, 108, 2, 2, 4, 1, 110, 1, '2019-03-21 13:41:42', NULL),
(810, 1, 108, 2, 2, 4, 2, 110, 1, '2019-03-21 13:41:42', '2019-03-21 13:42:07'),
(811, 1, 108, 2, 2, 4, 3, 110, 1, '2019-03-21 13:41:42', '2019-03-21 13:42:14'),
(812, 2, 108, 2, 2, 4, 4, 110, 1, '2019-03-21 13:41:42', NULL),
(813, 2, 108, 2, 2, 4, 5, 110, 1, '2019-03-21 13:41:42', NULL),
(814, 2, 108, 2, 2, 4, 6, 110, 1, '2019-03-21 13:41:42', NULL),
(815, 2, 108, 2, 2, 4, 7, 110, 1, '2019-03-21 13:41:42', NULL),
(816, 1, 109, 1, 1, 13, 1, 111, 1, '2019-03-25 12:15:18', '2019-03-25 12:54:53'),
(817, 1, 109, 1, 1, 13, 2, 111, 1, '2019-03-25 12:15:18', '2019-03-25 12:57:05'),
(818, 1, 109, 1, 1, 13, 3, 111, 1, '2019-03-25 12:15:18', '2019-03-25 12:57:34'),
(819, 2, 109, 2, 2, 4, 4, 111, 1, '2019-03-25 12:15:18', NULL),
(820, 2, 109, 2, 2, 4, 5, 111, 1, '2019-03-25 12:15:18', NULL),
(821, 2, 109, 2, 2, 4, 6, 111, 1, '2019-03-25 12:15:18', NULL),
(822, 2, 109, 2, 2, 4, 7, 111, 1, '2019-03-25 12:15:18', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_niveis_acessos`
--

DROP TABLE IF EXISTS `adms_niveis_acessos`;
CREATE TABLE IF NOT EXISTS `adms_niveis_acessos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_niveis_acessos`
--

INSERT INTO `adms_niveis_acessos` (`id`, `nome`, `ordem`, `created`, `modified`) VALUES
(1, 'Super Administrador', 1, '2011-01-21 00:00:00', NULL),
(2, 'Administrador', 2, '2011-01-21 00:00:00', '2019-01-28 17:56:09'),
(3, 'Gerente', 3, '2011-01-21 00:00:00', '2019-01-28 17:56:09'),
(4, 'FuncionÃ¡rio', 4, '2011-01-21 00:00:00', '2019-01-28 16:46:10'),
(5, 'EstagiÃ¡rio', 5, '2011-01-21 00:00:00', '2019-01-28 16:46:10'),
(6, 'Cliente', 6, '2019-02-02 20:29:24', NULL),
(7, 'Visualizador', 7, '2019-02-07 16:16:15', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_paginas`
--

DROP TABLE IF EXISTS `adms_paginas`;
CREATE TABLE IF NOT EXISTS `adms_paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `metodo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `menu_controller` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `menu_metodo` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `nome_pagina` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  `lib_pub` int(11) NOT NULL DEFAULT '2',
  `icone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_grps_pg_id` int(11) NOT NULL,
  `adms_tps_pg_id` int(11) NOT NULL,
  `adms_sits_pg_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_paginas`
--

INSERT INTO `adms_paginas` (`id`, `controller`, `metodo`, `menu_controller`, `menu_metodo`, `nome_pagina`, `obs`, `lib_pub`, `icone`, `adms_grps_pg_id`, `adms_tps_pg_id`, `adms_sits_pg_id`, `created`, `modified`) VALUES
(1, 'Home', 'index', 'home', 'index', 'Dashboard', 'Pagina inicial', 2, 'fas fa-tachometer-alt', 1, 1, 1, '2019-01-21 00:00:00', NULL),
(2, 'Usuarios', 'listar', 'usuarios', 'listar', 'Usuarios', 'Pagina para listar os usuarios', 2, 'fas fa-users', 1, 1, 1, '2019-01-21 00:00:00', NULL),
(3, 'Login', 'acesso', 'login', 'acesso', 'Acesso', 'Pagina de login', 1, NULL, 7, 1, 1, '2019-01-21 00:00:00', NULL),
(4, 'Login', 'logout', 'login', 'logout', 'Sair', 'Pagina para sair', 1, NULL, 7, 1, 1, '2019-01-21 00:00:00', NULL),
(5, 'NovoUsuario', 'novoUsuario', 'novo-usuario', 'novo-usuario', 'Novo Usuario', 'Pagina para cadastrar novo usuario na pagina de login', 1, NULL, 2, 1, 1, '2019-01-22 00:00:00', NULL),
(6, 'Confirmar', 'confirmarEmail', 'confirmar', 'confirmar-email', 'Confirmar E-mail', 'Pagina para confirmar E-mail', 1, NULL, 7, 1, 1, '2019-01-22 00:00:00', NULL),
(7, 'EsqueceuSenha', 'esqueceuSenha', 'esqueceu-senha', 'esqueceu-senha', 'Esqueceu a senha', 'Pagina para recuperar a senha', 1, NULL, 7, 1, 1, '2019-01-23 00:00:00', NULL),
(8, 'AtualSenha', 'atualSenha', 'atual-senha', 'atual-senha', 'Atualizar a senha', 'Pagina para atualizar a senha', 1, '', 7, 1, 1, '2019-01-23 00:00:00', NULL),
(9, 'VerPerfil', 'perfil', 'ver-perfil', 'perfil', 'Ver Perfil', 'Página para ver perfil', 2, NULL, 5, 1, 1, '2019-01-24 00:00:00', NULL),
(10, 'AlterarSenha', 'altSenha', 'alterar-senha', 'alt-senha', 'Alterar Senha', 'Pagina para alterar senha', 2, NULL, 3, 1, 1, '2019-01-24 00:00:00', NULL),
(11, 'EditarPerfil', 'altPerfil', 'editar-perfil', 'alt-perfil', 'Editar Perfil', 'Pagina para Editar Perfil', 2, NULL, 3, 1, 1, '2019-01-24 00:00:00', NULL),
(12, 'VerUsuario', 'verUsuario', 'ver-usuario', 'ver-usuario', 'Ver Usuario', 'Pagina para ver detalhes do usuario', 2, NULL, 5, 1, 1, '2019-01-26 00:00:00', NULL),
(13, 'EditarSenha', 'editSenha', 'editar-senha', 'edit-senha', 'Editar Senha', 'Pagina para o administrador ou gerente editar a senha do usuario.', 2, NULL, 3, 1, 1, '2019-01-26 00:00:00', NULL),
(14, 'EditarUsuario', 'editUsuario', 'editar-usuario', 'edit-usuario', 'Editar Usuario', 'Pagina para o administrador ou gerente editar os dados do usuario.', 2, NULL, 3, 1, 1, '2019-01-26 00:00:00', NULL),
(15, 'CadastrarUsuario', 'cadUsuario', 'cadastrar-usuario', 'cad-usuario', 'Cadastrar Usuario', 'Pagina para o administrador cadastrar usuario.', 2, NULL, 2, 1, 1, '2019-01-26 00:00:00', NULL),
(16, 'ApagarUsuario', 'apagarUsuario', 'apagar-usuario', 'apagar-usuario', 'Apagar Usuario', 'Pagina para apagar usuario.', 2, NULL, 4, 1, 1, '2019-01-27 00:00:00', NULL),
(17, 'Demandas', 'listar', 'demandas', 'listar', 'Demandas', 'Listar todas as demandas.', 2, 'fas fa-list-ul', 1, 1, 1, '2019-01-27 00:00:00', NULL),
(18, 'NivelAcesso', 'listar', 'nivel-acesso', 'listar', 'Nivel de Acesso', 'Pagina para gerenciar o nivel de acesso.', 2, 'fas fa-key', 1, 1, 1, '2019-01-27 00:00:00', NULL),
(19, 'CadastrarNivAc', 'cadNivAc', 'cadastrar-niv-ac', 'cad-niv-ac', 'Cadastrar Nivel de Acesso', 'Pagina para Cadastrar Nivel de Acesso', 2, NULL, 2, 1, 1, '2019-01-27 00:00:00', NULL),
(20, 'VerNivAc', 'VerNivAc', 'ver-niv-ac', 'ver-niv-ac', 'Detalhes do Nivel de Acesso', 'Pagina para ver detalhes do Nivel de Acesso', 2, NULL, 5, 1, 1, '2019-01-27 00:00:00', NULL),
(21, 'EditarNivAc', 'editNivAc', 'editar-niv-ac', 'edit-niv-ac', 'Editar Nivel de Acesso', 'Pagina para Editar Nivel de Acesso', 2, NULL, 3, 1, 1, '2019-01-27 00:00:00', NULL),
(22, 'ApagarNivAc', 'apagarNivAc', 'apagar-niv-ac', 'apagar-niv-ac', 'Apagar Nivel de Acesso', 'Pagina para Apagar Nivel de Acesso', 2, NULL, 4, 1, 1, '2019-01-27 00:00:00', NULL),
(23, 'AltOrdemNivAc', 'altOrdemNivAc', 'alt-ordem-niv-ac', 'alt-ordem-niv-ac', 'Alterar ordem nivel de acesso', 'Pagina para alterar ordem nivel de acesso', 2, NULL, 8, 1, 1, '2019-01-27 00:00:00', NULL),
(24, 'Pagina', 'listar', 'pagina', 'listar', 'Listar Paginas', 'Pagina para listar as paginas do administrativo', 2, 'fas fa-file', 1, 1, 1, '2019-01-28 00:00:00', '2019-01-28 01:11:47'),
(25, 'CadastrarPagina', 'cadPagina', 'cadastrar-pagina', 'cad-pagina', 'Cadastrar Pagina', 'Formulario para cadastrar pagina', 2, NULL, 2, 1, 1, '2019-01-28 00:00:00', NULL),
(26, 'VerPagina', 'verPagina', 'ver-pagina', 'ver-pagina', 'Visualizar PÃ¡gina', 'PÃ¡gina para ver detalhes da pÃ¡gina', 2, '', 5, 1, 1, '2019-01-28 14:25:21', NULL),
(27, 'EditarPagina', 'editPagina', 'editar-pagina', 'edit-pagina', 'Editar PÃ¡gina', 'FormulÃ¡rio para editar a pÃ¡gina', 2, '', 3, 1, 1, '2019-01-28 14:43:47', '2019-01-28 15:40:01'),
(28, 'ApagarPagina', 'apagarPagina', 'apagar-pagina', 'apagar-pagina', 'Apagar PÃ¡gina', 'PÃ¡gina para apagar pÃ¡gina.', 2, '', 4, 1, 1, '2019-01-28 01:44:52', '2019-01-28 01:47:03'),
(30, 'CadastrarDemanda', 'cadDemanda', 'cadastrar-demanda', 'cad-demanda', 'Cadastrar Demanda', 'Pagina de cadastro de demanda', 2, '', 2, 1, 1, '2019-01-28 13:21:00', NULL),
(31, 'VerDemanda', 'verDemanda', 'ver-demanda', 'ver-demanda', 'Ver Demanda', 'PÃ¡gina para ver os detalhes da demanda, como listar as atividades cadastradas.', 2, '', 5, 1, 1, '2019-01-28 14:30:51', NULL),
(32, 'EditarDemanda', 'editDemanda', 'editar-demanda', 'edit-demanda', 'Editar Demanda', 'PÃ¡gina para editar a demanda.', 2, '', 3, 1, 1, '2019-01-28 15:25:33', NULL),
(33, 'ApagarDemanda', 'apagarDemanda', 'apagar-demanda', 'apagar-demanda', 'Apagar Demanda', 'PÃ¡gina para apagar demanda e todas as atividades da demanda', 2, '', 4, 1, 1, '2019-01-28 17:11:48', NULL),
(34, 'CadastrarAtividade', 'cadAtividade', 'cadastrar-atividade', 'cad-atividade', 'Cadastrar Atividade', 'PÃ¡gina para cadastra atividades da demanda.', 2, '', 2, 1, 1, '2019-01-29 11:49:17', NULL),
(35, 'EditarAtividade', 'editAtividade', 'editar-atividade', 'edit-atividade', 'Editar Atividade', 'PÃ¡gina para editar atividade.', 2, '', 3, 1, 1, '2019-01-29 14:29:39', NULL),
(36, 'ApagarAtividade', 'apagarAtividade', 'apagar-atividade', 'apagar-atividade', 'Apagar Atividade', 'PÃ¡gina para apagar atividade da demanda.', 2, '', 4, 1, 1, '2019-01-29 16:23:16', NULL),
(37, 'Atendimento', 'listar', 'atendimento', 'listar', 'Atendimento', 'PÃ¡gina para listar atendimentos jÃ¡ realizados', 2, 'fas fa-clock', 1, 1, 1, '2019-01-30 18:42:17', NULL),
(38, 'NovoAtendimento', 'novo', 'novo-atendimento', 'novo', 'Novo Atendimento', 'PÃ¡gina para abrir um atendimento.', 2, 'fas fa-plus-circle', 2, 1, 1, '2019-01-31 14:52:36', NULL),
(39, 'Permissoes', 'listar', 'permissoes', 'listar', 'PermissÃ£o', 'PÃ¡gina para listar as permissÃµes do nÃ­vel de acesso.', 2, '', 1, 1, 1, '2019-02-01 01:01:00', NULL),
(41, 'LibPermi', 'libPermi', 'lib-permi', 'lib-permi', 'LibPermi', 'PÃ¡gina para liberar permissÃ£o.', 2, '', 2, 1, 1, '2019-02-01 18:49:17', NULL),
(42, 'LibMenu', 'libMenu', 'lib-menu', 'lib-menu', 'LibMenu', 'PÃ¡gina para liberar menu.', 2, '', 2, 1, 1, '2019-02-01 18:50:02', NULL),
(43, 'LibDropdown', 'libDropdown', 'lib-dropdown', 'lib-dropdown', 'LibDropdown', 'PÃ¡gina para liberar dropdown.', 2, '', 2, 1, 1, '2019-02-01 18:50:45', NULL),
(44, 'AltOrdemMenu', 'altOrdemMenu', 'alt-ordem-menu', 'alt-ordem-menu', 'Alterar Ordem Menu', 'Alterar a ordem do menu.', 2, '', 8, 1, 1, '2019-02-01 22:13:43', NULL),
(45, 'SincroPgNivAc', 'sincroPgNivAc', 'sincro-pg-niv-ac', 'sincro-pg-niv-ac', 'Sincronizar NÃ­vel de Acesso', 'PÃ¡gina para sincronizar o nÃ­vel de acesso das paginas com o nÃ­vel de acesso dos usuÃ¡rios.', 2, '', 2, 1, 1, '2019-02-02 20:10:32', NULL),
(46, 'EditarNivAcPgMenu', 'editNivAcPgMenu', 'editar-niv-ac-pg-menu', 'edit-niv-ac-pg-menu', 'Editar Item de Menu da PÃ¡gina', 'Editar nÃ­vel de acesso menu.                ', 1, '', 3, 1, 1, '2019-02-02 21:16:48', '2019-02-02 21:30:00'),
(47, 'Menu', 'listar', 'menu', 'listar', 'Itens de Menu', 'Listar itens de menu.                ', 1, 'fas fa-sitemap', 1, 1, 1, '2019-02-03 00:28:37', '2019-02-03 00:32:33'),
(48, 'CadastrarMenu', 'cadMenu', 'cadastrar-menu', 'cad-menu', 'Cadastrar Item de Menu', 'PÃ¡gina para cadastrar item de menu.', 2, '', 2, 1, 1, '2019-02-03 00:43:40', NULL),
(49, 'VerMenu', 'verMenu', 'ver-menu', 'ver-menu', 'Ver Item de Menu', 'Ver item de menu.', 2, '', 5, 1, 1, '2019-02-03 01:03:34', NULL),
(50, 'EditarMenu', 'editMenu', 'editar-menu', 'edit-menu', 'Editar Item de Menu', 'Editar item de menu.', 2, '', 3, 1, 1, '2019-02-03 01:08:43', NULL),
(51, 'ApagarMenu', 'apagarMenu', 'apagar-menu', 'apagar-menu', 'Apagar Item de Menu', 'Apagar item de menu.', 2, '', 4, 1, 1, '2019-02-03 01:22:44', NULL),
(52, 'AltOrdemItemMenu', 'altOrdemItemMenu', 'alt-ordem-item-menu', 'alt-ordem-item-menu', 'Alterar a Ordem do Item de Menu', 'Alterar a ordem do item de menu.', 2, '', 8, 1, 1, '2019-02-03 01:28:18', NULL),
(53, 'EditarFormCadUsuario', 'editFormCadUsuario', 'editar-form-cad-usuario', 'edit-form-cad-usuario', 'Cadastro de Login', 'FormulÃ¡rio para editar as informaÃ§Ãµes do formulÃ¡rio cadastrar usuÃ¡rio na pÃ¡gina de login.', 2, 'fas fa-edit', 3, 1, 1, '2019-02-03 12:24:41', NULL),
(54, 'EditarConfEmail', 'editConfEmail', 'editar-conf-email', 'edit-conf-email', 'ConfiguraÃ§Ã£o de E-mail', 'FormulÃ¡rio para editar as configuraÃ§Ãµes do servidor de envio de e-mail.', 2, 'fas fa-at', 3, 1, 1, '2019-02-03 12:26:50', NULL),
(55, 'Cor', 'listar', 'cor', 'listar', 'Cores', 'Listar as cores dos botÃµes.                ', 2, 'fas fa-palette', 1, 1, 1, '2019-02-03 12:30:11', '2019-02-03 19:25:16'),
(56, 'VerCor', 'verCor', 'ver-cor', 'ver-cor', 'Ver Cores', 'PÃ¡gina para ver detalhes da cor do botÃ£o.', 2, '', 5, 1, 1, '2019-02-03 12:32:23', NULL),
(57, 'EditarCor', 'editCor', 'editar-cor', 'edit-cor', 'Editar a Cor', 'FormulÃ¡rio para editar as cores dos botÃµes.', 2, '', 3, 1, 1, '2019-02-03 12:34:11', NULL),
(58, 'CadastrarCor', 'cadCor', 'cadastrar-cor', 'cad-cor', 'Cadastrar Cor', 'FormulÃ¡rio para cadastrar a cor do botÃ£o', 2, '', 2, 1, 1, '2019-02-03 12:35:41', NULL),
(59, 'ApagarCor', 'apagarCor', 'apagar-cor', 'apagar-cor', 'Apagar a Cor', 'PÃ¡gina para apagar a cor do botÃ£o', 2, '', 4, 1, 1, '2019-02-03 12:36:44', NULL),
(60, 'GrupoPg', 'listar', 'grupo-pg', 'listar', 'Grupo de PÃ¡gina', 'Listar os grupos das pÃ¡ginas', 2, 'fas fa-file-alt', 1, 1, 1, '2019-02-03 12:37:58', NULL),
(61, 'VerGrupoPg', 'verGrupoPg', 'ver-grupo-pg', 'ver-grupo-pg', 'Ver Grupo de PÃ¡gina', 'PÃ¡gina para ver detalhes do grupo de pÃ¡gina', 2, '', 5, 1, 1, '2019-02-03 12:39:05', NULL),
(62, 'CadastrarGrupoPg', 'cadGrupoPg', 'cadastrar-grupo-pg', 'cad-grupo-pg', 'Cadastro Grupo de PÃ¡gina', 'FormulÃ¡rio para cadastrar novo grupo de pÃ¡gina', 2, '', 2, 1, 1, '2019-02-03 12:40:22', NULL),
(63, 'EditarGrupoPg', 'editGrupoPg', 'editar-grupo-pg', 'edit-grupo-pg', 'Editar Grupo de PÃ¡gina', 'FormulÃ¡rio para editar os dados do grupo de pÃ¡gina', 2, '', 3, 1, 1, '2019-02-03 12:41:36', NULL),
(64, 'ApagarGrupoPg', 'apagarGrupoPg', 'apagar-grupo-pg', 'apagar-grupo-pg', 'Apagar Grupo de PÃ¡gina', 'PÃ¡gina para apagar grupo de pÃ¡gina', 2, '', 4, 1, 1, '2019-02-03 12:42:40', NULL),
(65, 'AltOrdemGrupoPg', 'altOrdemGrupoPg', 'alt-ordem-grupo-pg', 'alt-ordem-grupo-pg', 'Alterar Ordem Grupo Pg', 'Altera a ordem do grupo de pÃ¡gina', 2, '', 8, 1, 1, '2019-02-03 12:45:49', NULL),
(66, 'TipoPg', 'listar', 'tipo-pg', 'listar', 'Tipo de PÃ¡gina', 'Listar os tipos de pÃ¡ginas                ', 2, 'fas fa-list', 1, 1, 1, '2019-02-03 12:47:29', '2019-02-03 13:27:20'),
(67, 'CadastrarTipoPg', 'cadTipoPg', 'cadastrar-tipo-pg', 'cad-tipo-pg', 'Cadastrar Tipo de PÃ¡gina', 'FormulÃ¡rio para cadastrar o tipo de pÃ¡gina', 2, '', 2, 1, 1, '2019-02-03 12:54:22', NULL),
(68, 'EditarTipoPg', 'editTipoPg', 'editar-tipo-pg', 'edit-tipo-pg', 'Editar Tipo de PÃ¡gina', 'FormulÃ¡rio para editar o tipo de pÃ¡gina', 2, '', 3, 1, 1, '2019-02-03 12:55:21', NULL),
(69, 'VerTipoPg', 'verTipoPg', 'ver-tipo-pg', 'ver-tipo-pg', 'Ver Tipo de PÃ¡gina', 'PÃ¡gina para ver detalhes do tipo de pÃ¡gina', 2, '', 5, 1, 1, '2019-02-03 10:21:25', NULL),
(70, 'ApagarTipoPg', 'apagarTipoPg', 'apagar-tipo-pg', 'apagar-tipo-pg', 'Apagar Tipo de PÃ¡gina', 'PÃ¡gina para apagar o tipo de pÃ¡gina', 2, '', 4, 1, 1, '2019-02-03 10:21:25', NULL),
(71, 'AltOrdemTipoPg', 'altOrdemTipoPg', 'alt-ordem-tipo-pg', 'alt-ordem-tipo-pg', 'Alterar Ordem Tipo Pg', 'PÃ¡gina para alterar a ordem do tipo de pÃ¡ginas        ', 2, '', 8, 1, 1, '2019-02-03 10:21:25', NULL),
(72, 'Situacao', 'listar', 'situacao', 'listar', 'SituaÃ§Ã£o', 'PÃ¡gina para listar as situaÃ§Ãµes                ', 2, 'fas fa-exclamation-triangle', 1, 1, 1, '2019-02-03 10:21:25', '2019-02-03 10:21:25'),
(73, 'VerSit', 'verSit', 'ver-sit', 'ver-sit', 'Ver SituaÃ§Ã£o', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o', 2, '', 5, 1, 1, '2019-02-03 10:21:25', NULL),
(74, 'CadastrarSit', 'cadSit', 'cadastrar-sit', 'cad-sit', 'Cadastrar SituaÃ§Ã£o', 'FormulÃ¡rio para cadastrar situaÃ§Ã£o', 2, '', 2, 1, 1, '2019-02-03 10:21:25', NULL),
(75, 'EditarSit', 'editSit', 'editar-sit', 'edit-sit', 'Editar a situaÃ§Ã£o', 'FormulÃ¡rio para editar a situaÃ§Ã£o', 2, '', 3, 1, 1, '2019-02-03 10:21:25', NULL),
(76, 'ApagarSit', 'apagarSit', 'apagar-sit', 'apagar-sit', 'Apagar SituaÃ§Ã£o', 'PÃ¡gina para apagar situaÃ§Ã£o', 2, '', 3, 1, 1, '2019-02-03 10:21:25', NULL),
(77, 'SituacaoUser', 'listar', 'situacao-user', 'listar', 'SituaÃ§Ã£o dos UsuÃ¡rios', 'Listar as situaÃ§Ã£o de usuÃ¡rio', 2, 'far fa-id-badge', 1, 1, 1, '2019-02-03 10:21:25', '2019-02-03 10:21:25'),
(78, 'VerSitUser', 'verSitUser', 'ver-sit-user', 'ver-sit-user', 'Ver SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o de usuÃ¡rio', 2, '', 5, 1, 1, '2019-02-03 10:21:25', NULL),
(79, 'CadastrarSitUser', 'cadSitUser', 'cadastrar-sit-user', 'cad-sit-user', 'Cadastrar SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para cadastrar situaÃ§Ã£o de usuÃ¡rio', 2, '', 2, 1, 1, '2019-02-03 10:21:25', NULL),
(80, 'EditarSitUser', 'editSitUser', 'editar-sit-user', 'edit-sit-user', 'Editar SituaÃ§Ã£o de UsuÃ¡rio', 'FormulÃ¡rio para editar situaÃ§Ã£o de usuÃ¡rio', 2, '', 3, 1, 1, '2019-02-03 10:21:25', NULL),
(81, 'ApagarSitUser', 'apagarSitUser', 'apagar-sit-user', 'apagar-sit-user', 'Apagar SituaÃ§Ã£o de UsuÃ¡rio', 'PÃ¡gina para apagar situaÃ§Ã£o de usuÃ¡rio', 2, '', 4, 1, 1, '2019-02-03 10:21:25', NULL),
(82, 'SituacaoPg', 'listar', 'situacao-pg', 'listar', 'SituaÃ§Ã£o de PÃ¡gina', 'Listar as situaÃ§Ãµes de pÃ¡ginas', 2, 'fas fa-exclamation', 1, 1, 1, '2019-02-03 10:21:25', '2019-02-03 10:21:25'),
(83, 'VerSitPg', 'verSitPg', 'ver-sit-pg', 'ver-sit-pg', 'Ver SituaÃ§Ã£o de PÃ¡gina', 'PÃ¡gina para ver detalhes da situaÃ§Ã£o de pÃ¡gina', 2, '', 5, 1, 1, '2019-02-03 10:21:25', NULL),
(84, 'CadastrarSitPg', 'cadSitPg', 'cadastrar-sit-pg', 'cad-sit-pg', 'Cadastrar SituaÃ§Ã£o de PÃ¡gina', 'FormulÃ¡rio para cadastrar situaÃ§Ã£o de pÃ¡gina', 2, '', 2, 1, 1, '2019-02-03 10:21:25', NULL),
(85, 'EditarSitPg', 'editSitPg', 'editar-sit-pg', 'edit-sit-pg', 'Editar situaÃ§Ã£o de pÃ¡gina', 'FormulÃ¡rio para editar situaÃ§Ã£o de pÃ¡gina', 2, '', 3, 1, 1, '2019-02-03 10:21:25', '2019-02-03 10:21:25'),
(86, 'ApagarSitPg', 'apagarSitPg', 'apagar-sit-pg', 'apagar-sit-pg', 'Apagar SituaÃ§Ã£o de PÃ¡gina', 'PÃ¡gina para apagar situaÃ§Ã£o de pÃ¡gina', 2, '', 4, 1, 1, '2019-02-03 10:21:25', NULL),
(87, 'AtendimentoPendente', 'listar', 'atendimento-pendente', 'listar', 'Atendimento Pendente Func', 'PÃ¡gina para os funcionÃ¡rios visualizar os atendimentos pendente.                                                                                ', 2, 'fas fa-exclamation-circle', 1, 1, 1, '2019-02-03 18:09:17', '2019-03-25 17:34:46'),
(88, 'AtendimentoEmAndamento', 'listar', 'atendimento-em-andamento', 'listar', 'Em Andamento', 'PÃ¡gina para listar os atendimentos em andamento.                                ', 2, 'fas fa-hourglass-half', 1, 1, 1, '2019-02-03 18:14:33', '2019-02-03 18:46:08'),
(89, 'AtendimentoConcluido', 'listar', 'atendimento-concluido', 'listar', 'ConcluÃ­do', 'PÃ¡gina para listar todos os atendimentos concluÃ­do.                ', 2, 'fas fa-clipboard-check', 1, 1, 1, '2019-02-03 18:18:40', '2019-02-03 18:24:39'),
(90, 'GerenciarAtendimento', 'listar', 'gerenciar-atendimento', 'listar', 'Atendimentos', 'PÃ¡gina para o gerente administrar todos os atendimentos, definindo a qual funcionÃ¡rio ele serÃ¡ encaminhado.                ', 2, 'fas fa-id-badge', 1, 1, 1, '2019-02-03 18:40:08', '2019-02-03 18:44:46'),
(91, 'CancelarAtendimento', 'cancelar', 'cancelar-atendimento', 'cancelar', 'Cancelar Atendimento', 'PÃ¡gina para cancelar atendimento antes que ele seja iniciado.                ', 2, '', 10, 1, 1, '2019-02-04 12:20:04', '2019-02-04 12:20:10'),
(92, 'AtendimentoGerente', 'ver', 'atendimento-gerente', 'ver', 'Atendimentos Visualizar', 'PÃ¡gina para ver detalhes do atendimento.                ', 2, '', 5, 1, 1, '2019-02-04 15:33:16', '2019-02-04 15:34:13'),
(93, 'AtendimentoGerente', 'editar', 'atendimento-gerente', 'editar', 'Atendimento Editar', 'PÃ¡gina para editar o atendimento.', 2, '', 3, 1, 1, '2019-02-04 15:36:35', NULL),
(94, 'AtendimentoGerente', 'apagar', 'atendimento-gerente', 'apagar', 'Atendimento Apagar', 'PÃ¡gina para apagar atendimento.', 2, '', 4, 1, 1, '2019-02-04 15:37:56', NULL),
(95, 'ArquivarAtendimento', 'arquivar', 'arquivar-atendimento', 'arquivar', 'Arquivar Atendimento', 'PÃ¡gina para arquivar atendimento.                ', 2, '', 11, 1, 1, '2019-02-05 12:26:53', '2019-02-05 12:27:20'),
(96, 'Atendimento', 'arquivado', 'atendimento', 'arquivado', 'Atendimento Arquivado Usuarios', 'PÃ¡gina para listar todos os atendimentos arquivados.                                ', 2, 'fas fa-archive', 1, 1, 1, '2019-02-05 12:53:22', '2019-02-05 14:20:06'),
(97, 'DesarquivarAtendimento', 'aten', 'desarquivar-atendimento', 'aten', 'Desarquivar Atendimento', 'PÃ¡gina para desarquivar atendimento.', 2, '', 11, 1, 1, '2019-02-05 13:05:42', NULL),
(98, 'GerenciarAtendimento', 'arquivado', 'gerenciar-atendimento', 'arquivado', 'Arquivado', 'PÃ¡gina para listar para o gerente todos os atendimentos arquivados.', 2, 'fas fa-archive', 1, 1, 1, '2019-02-05 14:19:18', NULL),
(99, 'AtendimentoGerente', 'arquivar', 'atendimento-gerente', 'arquivar', 'Atendimento Gerente Arquivar', 'PÃ¡gina para o gerente arquivar ', 2, '', 11, 1, 1, '2019-02-05 14:45:01', NULL),
(100, 'AtendimentoGerente', 'desarquivar', 'atendimento-gerente', 'desarquivar', 'Desarquivar', 'PÃ¡gina para o gerente desarquivar atendimentos.', 2, '', 6, 1, 1, '2019-02-05 17:45:16', NULL),
(101, 'PesqUsuarios', 'listar', 'pesq-usuarios', 'listar', 'Pesquisar UsuÃ¡rios', 'PÃ¡gina para pesquisar usuÃ¡rios', 2, '', 1, 1, 1, '2019-02-11 13:29:45', NULL),
(102, 'verUsuarioModal', 'verUsuario', 'ver-usuario-modal', 'ver-usuario', 'Ver UsuÃ¡rio Modal', 'PÃ¡gina para ver usuario', 2, '', 5, 1, 1, '2019-02-11 17:41:21', NULL),
(103, 'VerAtendimentoModal', 'verAtendimento', 'ver-atendimento-modal', 'ver-atendimento', 'Ver Atendimento Modal', 'PÃ¡gina para ver atendimento modal.', 2, '', 5, 1, 1, '2019-02-12 17:13:05', NULL),
(104, 'FuncionarioVerAtendimento', 'ver', 'funcionario-ver-atendimento', 'ver', 'FuncionÃ¡rio Ver Atendimento', 'PÃ¡gina para o funcionÃ¡rio visualizar o atendimento ao qual ele Ã© responsÃ¡vel em atender.', 2, '', 5, 1, 1, '2019-02-14 12:16:03', NULL),
(105, 'AtendimentoStatus', 'alterar', 'atendimento-status', 'alterar', 'Atendimento Status', 'Alterar status do atendimento. Pelo funcionÃ¡rio', 2, '', 3, 1, 1, '2019-02-15 16:03:30', NULL),
(106, 'FuncConcluirAtendimento', 'concluir', 'func-concluir-atendimento', 'concluir', 'FuncionÃ¡rio Concluir Atendimento', 'PÃ¡gina para o funcionÃ¡rio finalizar o atendimento.', 2, '', 3, 1, 1, '2019-02-18 17:29:44', NULL),
(107, 'LogsAtendimento', 'listar', 'logs-atendimento', 'listar', 'HistÃ³rico do Atendimento', 'PÃ¡gina para ver o histÃ³rico de atividade do atendimento.', 2, '', 1, 1, 1, '2019-02-19 17:12:36', NULL),
(108, 'Error', 'erro404', 'error', 'erro-404', 'PÃ¡gina de erro 404', 'PÃ¡gina para informar que a pÃ¡gina nÃ£o foi encontrada.', 1, '', 6, 1, 1, '2019-02-22 14:06:13', NULL),
(109, 'JornadaDeTrabalho', 'listar', 'jornada-de-trabalho', 'listar', 'Jornada de Trabalho FuncionÃ¡rios', 'PÃ¡gina para definir a jornada de trabalho dos funcionÃ¡rios                ', 2, 'fas fa-briefcase', 1, 1, 1, '2019-03-21 12:59:20', '2019-03-21 13:08:56'),
(110, 'EditarJornadaDeTrabalho', 'editar', 'editar-jornada-de-trabalho', 'editar', 'Editar Jornada de Trabalho do FuncinÃ¡rio', 'Editar a jornada de trabalho do funcionÃ¡rio                ', 2, '', 3, 1, 1, '2019-03-21 13:41:42', '2019-03-21 14:56:39'),
(111, 'Departamentos', 'listar', 'departamentos', 'listar', 'Departamentos', 'PÃ¡gina para listar todos os departamentos.', 2, 'fas fa-table', 1, 1, 1, '2019-03-25 12:15:18', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits`
--

DROP TABLE IF EXISTS `adms_sits`;
CREATE TABLE IF NOT EXISTS `adms_sits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits`
--

INSERT INTO `adms_sits` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2019-01-21 00:00:00', NULL),
(2, 'Inativo', 4, '2019-01-21 00:00:00', NULL),
(3, 'Analise', 1, '2019-01-21 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_atendimentos`
--

DROP TABLE IF EXISTS `adms_sits_atendimentos`;
CREATE TABLE IF NOT EXISTS `adms_sits_atendimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_atendimentos`
--

INSERT INTO `adms_sits_atendimentos` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Pendente', 5, '2019-01-31 00:00:00', NULL),
(2, 'Em andamento', 1, '2019-01-31 00:00:00', NULL),
(3, 'ConcluÃ­do', 3, '2019-01-31 00:00:00', NULL),
(4, 'Cancelado', 4, '2019-01-31 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_atendimentos_funcionario`
--

DROP TABLE IF EXISTS `adms_sits_atendimentos_funcionario`;
CREATE TABLE IF NOT EXISTS `adms_sits_atendimentos_funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_atendimentos_funcionario`
--

INSERT INTO `adms_sits_atendimentos_funcionario` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'NÃ£o iniciado', 2, '2019-02-15 00:00:00', NULL),
(2, 'Iniciado', 1, '2019-02-15 00:00:00', NULL),
(3, 'Pausado', 5, '2019-02-15 00:00:00', NULL),
(4, 'Finalizado', 3, '2019-02-15 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_empresas`
--

DROP TABLE IF EXISTS `adms_sits_empresas`;
CREATE TABLE IF NOT EXISTS `adms_sits_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_empresas`
--

INSERT INTO `adms_sits_empresas` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativa', 3, '2019-01-27 00:00:00', NULL),
(2, 'Inativa', 5, '2019-01-27 00:00:00', NULL),
(3, 'Aguardando Confirmacao', 1, '2019-01-27 00:00:00', NULL),
(4, 'Span', 4, '2019-01-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_pgs`
--

DROP TABLE IF EXISTS `adms_sits_pgs`;
CREATE TABLE IF NOT EXISTS `adms_sits_pgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_pgs`
--

INSERT INTO `adms_sits_pgs` (`id`, `nome`, `cor`, `created`, `modified`) VALUES
(1, 'Ativo', 'success', '2019-01-21 00:00:00', NULL),
(2, 'Inativo', 'danger', '2019-01-21 00:00:00', NULL),
(3, 'Analise', 'dark', '2019-01-21 00:00:00', '2019-02-03 16:42:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_usuarios`
--

DROP TABLE IF EXISTS `adms_sits_usuarios`;
CREATE TABLE IF NOT EXISTS `adms_sits_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `adms_cor_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_usuarios`
--

INSERT INTO `adms_sits_usuarios` (`id`, `nome`, `adms_cor_id`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '2019-01-21 00:00:00', NULL),
(2, 'Inativo', 5, '2019-01-21 00:00:00', NULL),
(3, 'Aguardando confirmaÃ§Ã£o', 6, '2019-01-21 00:00:00', '2019-02-03 16:46:22'),
(4, 'Spam', 4, '2019-01-21 00:00:00', NULL),
(5, 'Bloqueado', 4, '2019-02-02 00:00:00', NULL),
(6, 'Em anÃ¡lise', 8, '2019-02-03 16:25:28', '2019-02-03 16:29:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_tps_empresas`
--

DROP TABLE IF EXISTS `adms_tps_empresas`;
CREATE TABLE IF NOT EXISTS `adms_tps_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `obs` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_tps_empresas`
--

INSERT INTO `adms_tps_empresas` (`id`, `tipo`, `obs`, `ordem`, `created`, `modified`) VALUES
(1, 'Administradora', 'Empresa prestadora de servico.', 1, '2019-01-27 00:00:00', NULL),
(2, 'Cliente', 'Empresa cliente', 2, '2019-01-27 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_tps_pgs`
--

DROP TABLE IF EXISTS `adms_tps_pgs`;
CREATE TABLE IF NOT EXISTS `adms_tps_pgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_tps_pgs`
--

INSERT INTO `adms_tps_pgs` (`id`, `tipo`, `nome`, `obs`, `ordem`, `created`, `modified`) VALUES
(1, 'adms', 'Administrativo', 'Core do Administrativo', 1, '2019-01-21 00:00:00', '2019-02-03 16:02:32'),
(2, 'sts', 'Site', 'Core do Site                            ', 2, '2019-02-03 15:45:21', '2019-02-03 16:02:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_usuarios`
--

DROP TABLE IF EXISTS `adms_usuarios`;
CREATE TABLE IF NOT EXISTS `adms_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `apelido` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `recuperar_senha` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chave_descadastro` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `conf_email` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagem` varchar(220) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adms_departamento_id` int(11) DEFAULT NULL,
  `adms_cargo_id` int(11) DEFAULT NULL,
  `jornada_de_trabalho` time DEFAULT NULL,
  `hora_extra` time DEFAULT NULL,
  `adms_empresa_id` int(11) DEFAULT NULL,
  `adms_niveis_acesso_id` int(11) NOT NULL,
  `adms_sits_usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `adms_usuarios`
--

INSERT INTO `adms_usuarios` (`id`, `nome`, `apelido`, `email`, `usuario`, `senha`, `recuperar_senha`, `chave_descadastro`, `conf_email`, `imagem`, `adms_departamento_id`, `adms_cargo_id`, `jornada_de_trabalho`, `hora_extra`, `adms_empresa_id`, `adms_niveis_acesso_id`, `adms_sits_usuario_id`, `created`, `modified`) VALUES
(1, 'Dhemes Mota', 'Dhemes', 'dhemes.mota@gmail.com', 'dhemes.mota@gmail.com', '$2y$10$zUfJ362RhXWrT7NxmP3CoewTjbHAdi8QitJgsi.Wc6YEUJ288XkAq', '2ea5c30c4086dad96aa3ed06796246d1', NULL, NULL, 'socios.png', NULL, NULL, NULL, '05:00:00', 1, 1, 1, '2019-01-21 00:00:00', '2019-03-21 12:46:00'),
(2, 'Keliane Barbosa Silva', 'Kelly', 'kelly@gmail.com', 'kelly@gmail.com', '$2y$10$9QEwRvlnsfnvhitgQtuxIeXwEMrtuvYhTEE2/jWrQYL408lQNRmHm', 'c0deabfeb011a559fdb86c6d171f2aa2', NULL, NULL, 'familia.jpg', NULL, NULL, NULL, NULL, 2, 1, 1, '2019-01-21 00:00:00', '2019-01-27 00:58:44'),
(3, 'Dhemes Ipac', 'Ipac', 'dhemes.ipacti@gmail.com', 'dhemes.ipacti@gmail.com', '$2y$10$Lnq0DTdl8nrF3rMIRo2R.eviCsFfD09dwh3vNcfzQFlmH8mWWlUIS', 'a30df274760ac31c510c18e4498629ad', NULL, NULL, 'familia-.jpg', 1, 1, '06:00:00', NULL, 1, 4, 1, '2019-01-22 19:38:18', '2019-03-21 17:34:28'),
(38, 'Administrador', 'Admin', 'admin@admin.com', 'admin', '$2y$10$NGAQ2iZISFV77GqeTy0I2uqYGDoH7bmOUy5xv23fMv/t9RJwcC6lu', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 2, 1, '2019-01-29 16:45:34', NULL),
(30, 'Novo teste', 'Novo teste', 'novoteste@gmail.com', 'novoteste@gmail.com', '$2y$10$KZJqsML7CqowU3oD78X0r.s1XW7P/2PGbJCLtKb.syy7botIg/iki', NULL, NULL, NULL, '30aef3a5c265e557591a4da196da87b4.jpg', NULL, NULL, NULL, NULL, 2, 5, 1, '2019-01-27 19:08:54', NULL),
(29, 'Teste Usuario foto', 'Teste Usuario foto', 'testeusuario@gmail.com', 'testeusuario@gmail.com', '$2y$10$MGGTHAJz6XpJ/QBoBH6aBOAPXsZH6yvntv/b7Iwb5Z0XEjdrSNOC2', NULL, NULL, NULL, 'ux-787980-1280.jpg', NULL, NULL, NULL, '05:00:00', 2, 2, 1, '2019-01-27 19:06:13', NULL),
(8, 'Ana', 'Maria', 'maria@gmail.com', 'maria@gmail.com', '$2y$10$3dYmL4HnDtRNoOZVUAIASO9I6o28r4ovwTrCqMPXQtzAZ88GWmjkC', NULL, NULL, 'deb8634f6f9a64caa8789a11004e3d3f', NULL, 3, 1, '08:00:00', NULL, 1, 4, 1, '2019-01-25 23:34:06', '2019-03-25 14:34:31'),
(10, 'Miriam', 'Suellen', 'miram@gmail.com', 'miriam@gmail.com', '$2y$10$lvNk4TKtWcFbji7xQofKd.vXuI2NIVN8cUSrh7d3Mr8hlcITmuLya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 5, 2, '2019-01-27 00:53:34', '2019-01-27 17:30:43'),
(11, 'Dhemes12', 'Cezar', 'dhemes12@gmail.com', 'dhemes12@gmail.com', '$2y$10$1kcZHkZbPijpodrKL2J8kOweRFMZeAWtjKk3dqPFOCfm5Gtzo1s1e', NULL, NULL, NULL, '7c0eb1f9dcde785b32d79c361ee69a78.jpg', NULL, NULL, NULL, NULL, 2, 1, 1, '2019-01-27 00:55:50', '2019-01-27 15:36:27'),
(12, 'Dhemes14', 'dhemes14', 'dhemes14@gmail.com', 'dhemes14@gmail.com', '$2y$10$b0bfhh659BQlWHjV0O9mN.blbo4ZMpome666d1.svH7tBIkgzXDFm', NULL, NULL, NULL, 'pexels-photo-247791.png', 1, 1, '06:00:00', NULL, 1, 4, 5, '2019-01-27 01:07:35', '2019-03-21 17:33:40'),
(31, 'Realizar Novo ep 2', 'Realizar Novo ep 2', 'novoep2@gmail.com', 'novoep2@gmail.com', '$2y$10$S9/LHhbD0Du0VD2GOngGjOK7tCSt3Yf3645DvFxrn8D583/1y5ZsO', NULL, NULL, NULL, '71260232331b19a491dc646a22fa3eee.jpg', NULL, NULL, NULL, NULL, 2, 5, 1, '2019-01-27 19:19:55', NULL),
(17, 'Dhemes44', 'Dhemes44', 'dhemes44@gmail.com', 'dhemes44@gmail.com', '$2y$10$/Cz8IXgzC5OQ5d4PmqVyMeltV6SWj.yLAVazJR.nTKgqIwF0ze3US', NULL, NULL, NULL, 'bem-no-trabalho.jpg', NULL, NULL, NULL, NULL, 1, 2, 2, '2019-01-27 01:32:23', '2019-01-28 16:44:57'),
(21, 'Miriam Mota', 'miriam', 'miriamsuellen.mota@gmail.com', 'miriamsuellen.mota@gmail.com', '$2y$10$CffqNx7Wx6f2x9k5xt.UW.ARcJXBCbX2X8ixx0.7jL9DSFyN7GH0m', NULL, NULL, NULL, '30aef3a5c265e557591a4da196da87b4.jpg', NULL, NULL, NULL, '05:00:00', 2, 2, 1, '2019-01-27 01:48:44', '2019-01-27 19:40:55'),
(27, 'Maria Empresa 2', 'Maria', 'mariaep2@gmail.com', 'mariaep2@gmail.com', '$2y$10$XHs0LHqO2O7AoGWYGvUdcewtsdWQ6MTspt2gFfSgt9ZHjX35iMmu2', NULL, NULL, NULL, 'air240-airflow-w.png', NULL, NULL, NULL, NULL, 2, 3, 3, '2019-01-27 18:46:59', '2019-01-27 18:48:12'),
(28, 'Teste ep 2', 'Teste 2', 'testeep2@gmail.com', 'testeep2@gmail.com', '$2y$10$CCirQwfNeG3cJO4dQibQPea4ECPIRhUbg9CR.TBccYuj4.fugTJ8W', NULL, NULL, '0f7c521ca19b751ce981cd8dd6d38fda', '71260232331b19a491dc646a22fa3eee.jpg', NULL, NULL, NULL, NULL, 2, 3, 1, '2019-01-27 18:49:15', '2019-01-27 22:35:48'),
(32, 'Realizar Novo ep 3', 'Realizar Novo ep 3', 'novoep3@gmail.com', 'novoep3@gmail.com', '$2y$10$YEAJ4XF9D6HbJe/VYj2yj.YCQpiqPo3v6ZyiJgaDSbDqnAHxdVCxy', NULL, NULL, NULL, 'business-cellphone-codes-92904.jpg', NULL, NULL, NULL, NULL, 2, 5, 1, '2019-01-27 19:21:36', NULL),
(33, 'Realizar Novo ep 4', 'Realizar Novo ep 4', 'novoep4@gmail.com', 'novoep4@gmail.com', '$2y$10$8SBmZkEMdILfAHdrweOEkeRrTl.tgqMMe7ZA2oI4nLL3jPdsSbPJu', NULL, NULL, NULL, 'familia.jpg', NULL, NULL, NULL, NULL, 2, 4, 1, '2019-01-27 19:25:59', NULL),
(34, 'Realizar Novo ep 5', 'Realizar Novo ep 5', 'novoep5@gmail.com', 'novoep5@gmail.com', '$2y$10$5qsPdUJLhVXHX70PE7GEE.K1elg5H5S4Ria36Plb8ZSMCDV/ZWrKG', NULL, NULL, NULL, 'cd172ed1dd9f567fb573ee31777a6bb6.jpg', NULL, NULL, NULL, NULL, 2, 4, 1, '2019-01-27 19:29:15', NULL),
(35, 'Realizar Novo ep 6', 'Realizar Novo ep 6', 'novoep6@gmail.com', 'novoep6@gmail.com', '$2y$10$/Pue.1Ifkbef1ujoLpLZxuF5Jf7lrV4K2ILjDF6C5O2abt3Z7jMbu', NULL, NULL, NULL, '71260232331b19a491dc646a22fa3eee.jpg', NULL, NULL, NULL, NULL, 2, 4, 1, '2019-01-27 19:34:59', NULL),
(36, 'Realizar Novo ep 7', 'Realizar Novo ep 7', 'novoep7@gmail.com', 'novoep7@gmail.com', '$2y$10$d0wDOn9WfLXFmYo33ClLKuM86nGW4UCCzcsDhLJ66UAGeTtWk2a0O', NULL, NULL, NULL, 'familia-22.jpg', NULL, NULL, NULL, NULL, 2, 4, 1, '2019-01-27 19:38:30', '2019-01-27 19:41:10'),
(37, 'Realizar Novo ep 8', 'Realizar Novo ep 8', 'novoep8@gmail.com', 'novoep8@gmail.com', '$2y$10$.VPehMvqpQiUt9GpQNoS3eekLFRrLGJ0MRQ27TPxPg9AWEKVQZauy', NULL, NULL, NULL, '71260232331b19a491dc646a22fa3eee.jpg', NULL, NULL, NULL, NULL, 2, 3, 1, '2019-01-27 19:40:29', NULL),
(43, 'Gerente', 'gerente', 'gerente@gmail.com', 'gerente@gmail.com', '$2y$10$SxHxlE1xBtewUtcQQzzYI.Cd/.cHk..v5k1Ac3Z.n6YK4AW3whFNO', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 1, 3, 1, '2019-02-02 20:43:18', NULL),
(44, 'FuncionÃ¡rio', 'FuncionÃ¡rio', 'funcionario@gmail.com', 'funcionario@gmail.com', '$2y$10$h.UGiYzaMMcv3dsuoeqhkOQhT1UJDaiWAaioDe32ImAmDpnvL6QBS', NULL, NULL, NULL, '', 2, 1, '08:00:00', NULL, 1, 4, 1, '2019-02-02 20:44:00', NULL),
(46, 'Cliente', 'Cliente', 'cliente@gmail.com', 'cliente@gmail.com', '$2y$10$gF3l/JRopJiwPvIqRMlIN.qkfeRrAYuSl3uSVWXxE2FSxrkYGvcbq', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 2, 6, 1, '2019-02-02 20:45:35', NULL),
(47, 'JoÃ£o', 'joÃ£o', 'joao@gmail.com', 'joao999', '$2y$10$49FRMXaQCsbN4rGCRISg9Os0kwD/XGre60mtS5H5C8rGEo0fVAPdu', NULL, NULL, NULL, '', 1, 1, '09:00:00', NULL, 1, 4, 1, '2019-03-21 17:35:24', '2019-03-25 14:34:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;