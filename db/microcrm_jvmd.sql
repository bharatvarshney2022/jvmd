-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2021 at 07:53 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microcrm_jvmd`
--

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_account`
--

DROP TABLE IF EXISTS `jvm_accounting_account`;
CREATE TABLE `jvm_accounting_account` (
  `rowid` bigint(20) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_pcg_version` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pcg_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `account_parent` int(11) DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `labelshort` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_accounting_category` int(11) DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `reconcilable` tinyint(4) NOT NULL DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_bookkeeping`
--

DROP TABLE IF EXISTS `jvm_accounting_bookkeeping`;
CREATE TABLE `jvm_accounting_bookkeeping` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `piece_num` int(11) NOT NULL,
  `doc_date` date NOT NULL,
  `doc_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `doc_ref` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `fk_doc` int(11) NOT NULL,
  `fk_docdet` int(11) NOT NULL,
  `thirdparty_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subledger_account` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subledger_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_compte` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label_compte` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label_operation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit` double(24,8) NOT NULL,
  `credit` double(24,8) NOT NULL,
  `montant` double(24,8) NOT NULL,
  `sens` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_amount` double(24,8) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lettering_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_lettering` datetime DEFAULT NULL,
  `date_lim_reglement` datetime DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user` int(11) DEFAULT NULL,
  `code_journal` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `journal_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_validated` datetime DEFAULT NULL,
  `date_export` datetime DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_bookkeeping_tmp`
--

DROP TABLE IF EXISTS `jvm_accounting_bookkeeping_tmp`;
CREATE TABLE `jvm_accounting_bookkeeping_tmp` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `doc_date` date NOT NULL,
  `doc_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `doc_ref` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `fk_doc` int(11) NOT NULL,
  `fk_docdet` int(11) NOT NULL,
  `thirdparty_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subledger_account` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subledger_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_compte` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label_compte` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label_operation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `debit` double(24,8) NOT NULL,
  `credit` double(24,8) NOT NULL,
  `montant` double(24,8) NOT NULL,
  `sens` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_amount` double(24,8) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lettering_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_lettering` datetime DEFAULT NULL,
  `date_lim_reglement` datetime DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user` int(11) DEFAULT NULL,
  `code_journal` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `journal_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `piece_num` int(11) NOT NULL,
  `date_validated` datetime DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_fiscalyear`
--

DROP TABLE IF EXISTS `jvm_accounting_fiscalyear`;
CREATE TABLE `jvm_accounting_fiscalyear` (
  `rowid` int(11) NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT '0',
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_journal`
--

DROP TABLE IF EXISTS `jvm_accounting_journal`;
CREATE TABLE `jvm_accounting_journal` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `nature` smallint(6) NOT NULL DEFAULT '1',
  `active` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_accounting_journal`
--

INSERT INTO `jvm_accounting_journal` (`rowid`, `entity`, `code`, `label`, `nature`, `active`) VALUES
(1, 1, 'VT', 'ACCOUNTING_SELL_JOURNAL', 2, 1),
(2, 1, 'AC', 'ACCOUNTING_PURCHASE_JOURNAL', 3, 1),
(3, 1, 'BQ', 'FinanceJournal', 4, 1),
(4, 1, 'OD', 'ACCOUNTING_MISCELLANEOUS_JOURNAL', 1, 1),
(5, 1, 'AN', 'ACCOUNTING_HAS_NEW_JOURNAL', 9, 1),
(6, 1, 'ER', 'ExpenseReportsJournal', 5, 1),
(7, 1, 'INV', 'InventoryJournal', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_accounting_system`
--

DROP TABLE IF EXISTS `jvm_accounting_system`;
CREATE TABLE `jvm_accounting_system` (
  `rowid` int(11) NOT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `pcg_version` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_accounting_system`
--

INSERT INTO `jvm_accounting_system` (`rowid`, `fk_country`, `pcg_version`, `label`, `active`) VALUES
(1, 1, 'PCG99-ABREGE', 'The simple accountancy french plan', 1),
(2, 1, 'PCG99-BASE', 'The base accountancy french plan', 1),
(3, 1, 'PCG14-DEV', 'The developed accountancy french plan 2014', 1),
(4, 1, 'PCG18-ASSOC', 'French foundation chart of accounts 2018', 1),
(5, 1, 'PCGAFR14-DEV', 'The developed farm accountancy french plan 2014', 1),
(6, 2, 'PCMN-BASE', 'The base accountancy belgium plan', 1),
(7, 4, 'PCG08-PYME', 'The PYME accountancy spanish plan', 1),
(8, 5, 'SKR03', 'Standardkontenrahmen SKR 03', 1),
(9, 5, 'SKR04', 'Standardkontenrahmen SKR 04', 1),
(10, 6, 'PCG_SUISSE', 'Switzerland plan', 1),
(11, 7, 'ENG-BASE', 'England plan', 1),
(12, 10, 'PCT', 'The Tunisia plan', 1),
(13, 12, 'PCG', 'The Moroccan chart of accounts', 1),
(14, 13, 'NSCF', 'Nouveau système comptable financier', 1),
(15, 17, 'NL-VERKORT', 'Verkort rekeningschema', 1),
(16, 20, 'BAS-K1-MINI', 'The Swedish mini chart of accounts', 1),
(17, 41, 'AT-BASE', 'Plan Austria', 1),
(18, 67, 'PC-MIPYME', 'The PYME accountancy Chile plan', 1),
(19, 80, 'DK-STD', 'Standardkontoplan fra SKAT', 1),
(20, 84, 'EC-SUPERCIAS', 'Plan de cuentas Ecuador', 1),
(21, 140, 'PCN-LUXEMBURG', 'Plan comptable normalisé Luxembourgeois', 1),
(22, 188, 'RO-BASE', 'Plan de conturi romanesc', 1),
(23, 49, 'SYSCOHADA-BJ', 'Plan comptable Ouest-Africain', 1),
(24, 60, 'SYSCOHADA-BF', 'Plan comptable Ouest-Africain', 1),
(25, 73, 'SYSCOHADA-CD', 'Plan comptable Ouest-Africain', 1),
(26, 65, 'SYSCOHADA-CF', 'Plan comptable Ouest-Africain', 1),
(27, 72, 'SYSCOHADA-CG', 'Plan comptable Ouest-Africain', 1),
(28, 21, 'SYSCOHADA-CI', 'Plan comptable Ouest-Africain', 1),
(29, 24, 'SYSCOHADA-CM', 'Plan comptable Ouest-Africain', 1),
(30, 16, 'SYSCOHADA-GA', 'Plan comptable Ouest-Africain', 1),
(31, 87, 'SYSCOHADA-GQ', 'Plan comptable Ouest-Africain', 1),
(32, 71, 'SYSCOHADA-KM', 'Plan comptable Ouest-Africain', 1),
(33, 147, 'SYSCOHADA-ML', 'Plan comptable Ouest-Africain', 1),
(34, 168, 'SYSCOHADA-NE', 'Plan comptable Ouest-Africain', 1),
(35, 22, 'SYSCOHADA-SN', 'Plan comptable Ouest-Africain', 1),
(36, 66, 'SYSCOHADA-TD', 'Plan comptable Ouest-Africain', 1),
(37, 15, 'SYSCOHADA-TG', 'Plan comptable Ouest-Africain', 1),
(38, 11, 'US-BASE', 'USA basic chart of accounts', 1),
(39, 14, 'CA-ENG-BASE', 'Canadian basic chart of accounts - English', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_actioncomm`
--

DROP TABLE IF EXISTS `jvm_actioncomm`;
CREATE TABLE `jvm_actioncomm` (
  `id` int(11) NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datep` datetime DEFAULT NULL,
  `datep2` datetime DEFAULT NULL,
  `fk_action` int(11) DEFAULT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_parent` int(11) NOT NULL DEFAULT '0',
  `fk_user_action` int(11) DEFAULT NULL,
  `fk_user_done` int(11) DEFAULT NULL,
  `transparency` int(11) DEFAULT NULL,
  `priority` smallint(6) DEFAULT NULL,
  `visibility` varchar(12) COLLATE utf8_unicode_ci DEFAULT 'default',
  `fulldayevent` smallint(6) NOT NULL DEFAULT '0',
  `percent` smallint(6) NOT NULL DEFAULT '0',
  `location` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `durationp` double DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `calling_duration` int(11) DEFAULT NULL,
  `email_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_msgid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_sender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_tocc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_tobcc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `errors_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reply_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recurid` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recurrule` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recurdateend` datetime DEFAULT NULL,
  `fk_element` int(11) DEFAULT NULL,
  `elementtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_actioncomm_extrafields`
--

DROP TABLE IF EXISTS `jvm_actioncomm_extrafields`;
CREATE TABLE `jvm_actioncomm_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_actioncomm_reminder`
--

DROP TABLE IF EXISTS `jvm_actioncomm_reminder`;
CREATE TABLE `jvm_actioncomm_reminder` (
  `rowid` int(11) NOT NULL,
  `dateremind` datetime NOT NULL,
  `typeremind` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fk_user` int(11) NOT NULL,
  `offsetvalue` int(11) NOT NULL,
  `offsetunit` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `lasterror` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_actioncomm` int(11) NOT NULL,
  `fk_email_template` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_actioncomm_resources`
--

DROP TABLE IF EXISTS `jvm_actioncomm_resources`;
CREATE TABLE `jvm_actioncomm_resources` (
  `rowid` int(11) NOT NULL,
  `fk_actioncomm` int(11) NOT NULL,
  `element_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fk_element` int(11) NOT NULL,
  `answer_status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mandatory` smallint(6) DEFAULT NULL,
  `transparency` smallint(6) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_adherent`
--

DROP TABLE IF EXISTS `jvm_adherent`;
CREATE TABLE `jvm_adherent` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civility` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_crypted` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_adherent_type` int(11) NOT NULL,
  `morphy` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `societe` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `zip` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `socialnetworks` text COLLATE utf8_unicode_ci,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `snapchat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_perso` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `public` smallint(6) NOT NULL DEFAULT '0',
  `datefin` datetime DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datevalid` datetime DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `canvas` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_adherent_extrafields`
--

DROP TABLE IF EXISTS `jvm_adherent_extrafields`;
CREATE TABLE `jvm_adherent_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_adherent_type`
--

DROP TABLE IF EXISTS `jvm_adherent_type`;
CREATE TABLE `jvm_adherent_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `morphy` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `duration` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscription` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `vote` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `mail_valid` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_adherent_type_extrafields`
--

DROP TABLE IF EXISTS `jvm_adherent_type_extrafields`;
CREATE TABLE `jvm_adherent_type_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_adherent_type_lang`
--

DROP TABLE IF EXISTS `jvm_adherent_type_lang`;
CREATE TABLE `jvm_adherent_type_lang` (
  `rowid` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_advtargetemailing`
--

DROP TABLE IF EXISTS `jvm_advtargetemailing`;
CREATE TABLE `jvm_advtargetemailing` (
  `rowid` int(11) NOT NULL,
  `name` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_element` int(11) NOT NULL,
  `type_element` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `filtervalue` text COLLATE utf8_unicode_ci,
  `fk_user_author` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `fk_user_mod` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_asset`
--

DROP TABLE IF EXISTS `jvm_asset`;
CREATE TABLE `jvm_asset` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_ht` double(24,8) DEFAULT NULL,
  `amount_vat` double(24,8) DEFAULT NULL,
  `fk_asset_type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_asset_extrafields`
--

DROP TABLE IF EXISTS `jvm_asset_extrafields`;
CREATE TABLE `jvm_asset_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_asset_type`
--

DROP TABLE IF EXISTS `jvm_asset_type`;
CREATE TABLE `jvm_asset_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `accountancy_code_asset` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_depreciation_asset` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_depreciation_expense` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_asset_type_extrafields`
--

DROP TABLE IF EXISTS `jvm_asset_type_extrafields`;
CREATE TABLE `jvm_asset_type_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank`
--

DROP TABLE IF EXISTS `jvm_bank`;
CREATE TABLE `jvm_bank` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datev` date DEFAULT NULL,
  `dateo` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_rappro` int(11) DEFAULT NULL,
  `fk_type` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_releve` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_chq` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_compte` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rappro` tinyint(4) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  `fk_bordereau` int(11) DEFAULT '0',
  `banque` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emetteur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `origin_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank_account`
--

DROP TABLE IF EXISTS `jvm_bank_account`;
CREATE TABLE `jvm_bank_account` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ref` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `bank` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_banque` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_guichet` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_rib` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bic` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iban_prefix` varchar(34) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_iban` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_iban` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domiciliation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL,
  `proprio` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courant` smallint(6) NOT NULL DEFAULT '0',
  `clos` smallint(6) NOT NULL DEFAULT '0',
  `rappro` smallint(6) DEFAULT '1',
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_accountancy_journal` int(11) DEFAULT NULL,
  `currency_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `min_allowed` int(11) DEFAULT '0',
  `min_desired` int(11) DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank_account_extrafields`
--

DROP TABLE IF EXISTS `jvm_bank_account_extrafields`;
CREATE TABLE `jvm_bank_account_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank_categ`
--

DROP TABLE IF EXISTS `jvm_bank_categ`;
CREATE TABLE `jvm_bank_categ` (
  `rowid` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank_class`
--

DROP TABLE IF EXISTS `jvm_bank_class`;
CREATE TABLE `jvm_bank_class` (
  `lineid` int(11) NOT NULL,
  `fk_categ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bank_url`
--

DROP TABLE IF EXISTS `jvm_bank_url`;
CREATE TABLE `jvm_bank_url` (
  `rowid` int(11) NOT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `url_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(24) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_blockedlog`
--

DROP TABLE IF EXISTS `jvm_blockedlog`;
CREATE TABLE `jvm_blockedlog` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amounts` double(24,8) NOT NULL,
  `element` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `user_fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_object` int(11) DEFAULT NULL,
  `ref_object` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_object` datetime DEFAULT NULL,
  `signature` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `signature_line` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `object_data` mediumtext COLLATE utf8_unicode_ci,
  `object_version` varchar(32) COLLATE utf8_unicode_ci DEFAULT '',
  `certified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_blockedlog_authority`
--

DROP TABLE IF EXISTS `jvm_blockedlog_authority`;
CREATE TABLE `jvm_blockedlog_authority` (
  `rowid` int(11) NOT NULL,
  `blockchain` longtext COLLATE utf8_unicode_ci NOT NULL,
  `signature` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bom_bom`
--

DROP TABLE IF EXISTS `jvm_bom_bom`;
CREATE TABLE `jvm_bom_bom` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bomtype` int(11) DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `fk_warehouse` int(11) DEFAULT NULL,
  `qty` double(24,8) DEFAULT NULL,
  `efficiency` double(24,8) DEFAULT '1.00000000',
  `duration` double(24,8) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bom_bomline`
--

DROP TABLE IF EXISTS `jvm_bom_bomline`;
CREATE TABLE `jvm_bom_bomline` (
  `rowid` int(11) NOT NULL,
  `fk_bom` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `fk_bom_child` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double(24,8) NOT NULL,
  `qty_frozen` smallint(6) DEFAULT '0',
  `disable_stock_change` smallint(6) DEFAULT '0',
  `efficiency` double(24,8) NOT NULL DEFAULT '1.00000000',
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bom_bomline_extrafields`
--

DROP TABLE IF EXISTS `jvm_bom_bomline_extrafields`;
CREATE TABLE `jvm_bom_bomline_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bom_bom_extrafields`
--

DROP TABLE IF EXISTS `jvm_bom_bom_extrafields`;
CREATE TABLE `jvm_bom_bom_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bookmark`
--

DROP TABLE IF EXISTS `jvm_bookmark`;
CREATE TABLE `jvm_bookmark` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `dateb` datetime DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `target` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `favicon` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_bordereau_cheque`
--

DROP TABLE IF EXISTS `jvm_bordereau_cheque`;
CREATE TABLE `jvm_bordereau_cheque` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime NOT NULL,
  `date_bordereau` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL,
  `nbcheque` smallint(6) NOT NULL,
  `fk_bank_account` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text COLLATE utf8_unicode_ci,
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_boxes`
--

DROP TABLE IF EXISTS `jvm_boxes`;
CREATE TABLE `jvm_boxes` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `box_id` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  `box_order` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `fk_user` int(11) NOT NULL DEFAULT '0',
  `maxline` int(11) DEFAULT NULL,
  `params` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_boxes`
--

INSERT INTO `jvm_boxes` (`rowid`, `entity`, `box_id`, `position`, `box_order`, `fk_user`, `maxline`, `params`) VALUES
(1, 1, 1, 0, 'B04', 0, NULL, NULL),
(2, 1, 2, 0, 'A13', 0, NULL, NULL),
(3, 1, 3, 0, 'B30', 0, NULL, NULL),
(4, 1, 4, 0, 'B14', 0, NULL, NULL),
(5, 1, 5, 0, 'A31', 0, NULL, NULL),
(6, 1, 6, 0, 'A15', 0, NULL, NULL),
(7, 1, 7, 0, 'B32', 0, NULL, NULL),
(8, 1, 8, 0, 'B16', 0, NULL, NULL),
(9, 1, 9, 0, 'A17', 0, NULL, NULL),
(10, 1, 10, 0, 'B34', 0, NULL, NULL),
(11, 1, 11, 0, 'B18', 0, NULL, NULL),
(12, 1, 12, 0, 'A35', 0, NULL, NULL),
(13, 1, 13, 0, 'A19', 0, NULL, NULL),
(14, 1, 14, 0, 'B36', 0, NULL, NULL),
(15, 1, 15, 0, 'B20', 0, NULL, NULL),
(16, 1, 16, 0, 'A37', 0, NULL, NULL),
(17, 1, 17, 0, 'A29', 0, NULL, NULL),
(18, 1, 18, 0, 'B12', 0, NULL, NULL),
(19, 1, 19, 0, 'A21', 0, NULL, NULL),
(20, 1, 20, 0, 'A05', 0, NULL, NULL),
(21, 1, 21, 0, 'B22', 0, NULL, NULL),
(22, 1, 22, 0, 'B06', 0, NULL, NULL),
(23, 1, 23, 0, 'A23', 0, NULL, NULL),
(24, 1, 24, 0, 'A07', 0, NULL, NULL),
(25, 1, 25, 0, 'B24', 0, NULL, NULL),
(26, 1, 26, 0, 'B08', 0, NULL, NULL),
(27, 1, 26, 27, 'B38', 0, NULL, NULL),
(28, 1, 27, 0, 'A25', 0, NULL, NULL),
(29, 1, 28, 0, 'A09', 0, NULL, NULL),
(30, 1, 29, 0, 'B26', 0, NULL, NULL),
(31, 1, 30, 0, 'B10', 0, NULL, NULL),
(32, 1, 31, 0, 'A27', 0, NULL, NULL),
(33, 1, 32, 0, 'A11', 0, NULL, NULL),
(34, 1, 33, 0, 'B28', 0, NULL, NULL),
(35, 1, 34, 0, 'A33', 0, NULL, NULL),
(38, 1, 37, 0, 'A03', 0, NULL, NULL),
(39, 1, 38, 0, 'B02', 0, NULL, NULL),
(40, 1, 39, 0, 'A01', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_boxes_def`
--

DROP TABLE IF EXISTS `jvm_boxes_def`;
CREATE TABLE `jvm_boxes_def` (
  `rowid` int(11) NOT NULL,
  `file` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` varchar(130) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_boxes_def`
--

INSERT INTO `jvm_boxes_def` (`rowid`, `file`, `entity`, `tms`, `note`) VALUES
(1, 'box_lastlogin.php', 1, '2021-01-22 06:42:34', NULL),
(2, 'box_birthdays.php', 1, '2021-01-22 06:42:34', NULL),
(3, 'box_members.php', 1, '2021-01-22 06:43:52', NULL),
(4, 'box_birthdays_members.php', 1, '2021-01-22 06:43:52', NULL),
(5, 'box_clients.php', 1, '2021-01-22 06:44:00', NULL),
(6, 'box_prospect.php', 1, '2021-01-22 06:44:00', NULL),
(7, 'box_contacts.php', 1, '2021-01-22 06:44:00', NULL),
(8, 'box_activity.php', 1, '2021-01-22 06:44:00', '(WarningUsingThisBoxSlowDown)'),
(9, 'box_goodcustomers.php', 1, '2021-01-22 06:44:00', '(WarningUsingThisBoxSlowDown)'),
(10, 'box_graph_propales_permonth.php', 1, '2021-01-22 06:44:22', NULL),
(11, 'box_propales.php', 1, '2021-01-22 06:44:22', NULL),
(12, 'box_commandes.php', 1, '2021-01-22 06:44:27', NULL),
(13, 'box_graph_orders_permonth.php', 1, '2021-01-22 06:44:27', NULL),
(14, 'box_graph_invoices_supplier_permonth.php', 1, '2021-01-22 06:44:36', NULL),
(15, 'box_graph_orders_supplier_permonth.php', 1, '2021-01-22 06:44:36', NULL),
(16, 'box_fournisseurs.php', 1, '2021-01-22 06:44:36', NULL),
(17, 'box_factures_fourn_imp.php', 1, '2021-01-22 06:44:36', NULL),
(18, 'box_factures_fourn.php', 1, '2021-01-22 06:44:36', NULL),
(19, 'box_supplier_orders.php', 1, '2021-01-22 06:44:36', NULL),
(20, 'box_supplier_orders_awaiting_reception.php', 1, '2021-01-22 06:44:36', NULL),
(21, 'box_factures_imp.php', 1, '2021-01-22 06:45:00', NULL),
(22, 'box_factures.php', 1, '2021-01-22 06:45:00', NULL),
(23, 'box_graph_invoices_permonth.php', 1, '2021-01-22 06:45:00', NULL),
(24, 'box_customers_outstanding_bill_reached.php', 1, '2021-01-22 06:45:00', NULL),
(25, 'box_produits.php', 1, '2021-01-22 06:45:21', NULL),
(26, 'box_produits_alerte_stock.php', 1, '2021-01-22 06:45:21', NULL),
(27, 'box_graph_product_distribution.php', 1, '2021-01-22 06:45:21', NULL),
(28, 'box_services_contracts.php', 1, '2021-01-22 06:45:32', NULL),
(29, 'box_shipments.php', 1, '2021-01-22 06:45:46', NULL),
(30, 'box_project.php', 1, '2021-01-22 06:45:55', NULL),
(31, 'box_task.php', 1, '2021-01-22 06:45:55', NULL),
(32, 'box_validated_projects.php', 1, '2021-01-22 06:45:55', NULL),
(33, 'box_funnel_of_prospection.php', 1, '2021-01-22 06:45:55', NULL),
(34, 'box_scheduled_jobs.php', 1, '2021-01-22 07:34:26', NULL),
(37, 'box_actions.php', 1, '2021-01-25 07:32:08', NULL),
(38, 'box_last_ticket.php', 1, '2021-01-25 07:32:31', NULL),
(39, 'box_last_modified_ticket.php', 1, '2021-01-25 07:32:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_budget`
--

DROP TABLE IF EXISTS `jvm_budget`;
CREATE TABLE `jvm_budget` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_budget_lines`
--

DROP TABLE IF EXISTS `jvm_budget_lines`;
CREATE TABLE `jvm_budget_lines` (
  `rowid` int(11) NOT NULL,
  `fk_budget` int(11) NOT NULL,
  `fk_project_ids` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `amount` double(24,8) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie`
--

DROP TABLE IF EXISTS `jvm_categorie`;
CREATE TABLE `jvm_categorie` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_parent` int(11) NOT NULL DEFAULT '0',
  `label` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_unicode_ci,
  `color` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categories_extrafields`
--

DROP TABLE IF EXISTS `jvm_categories_extrafields`;
CREATE TABLE `jvm_categories_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_account`
--

DROP TABLE IF EXISTS `jvm_categorie_account`;
CREATE TABLE `jvm_categorie_account` (
  `fk_categorie` int(11) NOT NULL,
  `fk_account` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_actioncomm`
--

DROP TABLE IF EXISTS `jvm_categorie_actioncomm`;
CREATE TABLE `jvm_categorie_actioncomm` (
  `fk_categorie` int(11) NOT NULL,
  `fk_actioncomm` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_contact`
--

DROP TABLE IF EXISTS `jvm_categorie_contact`;
CREATE TABLE `jvm_categorie_contact` (
  `fk_categorie` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_fournisseur`
--

DROP TABLE IF EXISTS `jvm_categorie_fournisseur`;
CREATE TABLE `jvm_categorie_fournisseur` (
  `fk_categorie` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_lang`
--

DROP TABLE IF EXISTS `jvm_categorie_lang`;
CREATE TABLE `jvm_categorie_lang` (
  `rowid` int(11) NOT NULL,
  `fk_category` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_member`
--

DROP TABLE IF EXISTS `jvm_categorie_member`;
CREATE TABLE `jvm_categorie_member` (
  `fk_categorie` int(11) NOT NULL,
  `fk_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_product`
--

DROP TABLE IF EXISTS `jvm_categorie_product`;
CREATE TABLE `jvm_categorie_product` (
  `fk_categorie` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_project`
--

DROP TABLE IF EXISTS `jvm_categorie_project`;
CREATE TABLE `jvm_categorie_project` (
  `fk_categorie` int(11) NOT NULL,
  `fk_project` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_societe`
--

DROP TABLE IF EXISTS `jvm_categorie_societe`;
CREATE TABLE `jvm_categorie_societe` (
  `fk_categorie` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_user`
--

DROP TABLE IF EXISTS `jvm_categorie_user`;
CREATE TABLE `jvm_categorie_user` (
  `fk_categorie` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_warehouse`
--

DROP TABLE IF EXISTS `jvm_categorie_warehouse`;
CREATE TABLE `jvm_categorie_warehouse` (
  `fk_categorie` int(11) NOT NULL,
  `fk_warehouse` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_categorie_website_page`
--

DROP TABLE IF EXISTS `jvm_categorie_website_page`;
CREATE TABLE `jvm_categorie_website_page` (
  `fk_categorie` int(11) NOT NULL,
  `fk_website_page` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_chargesociales`
--

DROP TABLE IF EXISTS `jvm_chargesociales`;
CREATE TABLE `jvm_chargesociales` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_ech` datetime NOT NULL,
  `libelle` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_type` int(11) NOT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `paye` smallint(6) NOT NULL DEFAULT '0',
  `periode` date DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande`
--

DROP TABLE IF EXISTS `jvm_commande`;
CREATE TABLE `jvm_commande` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_client` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `source` smallint(6) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `amount_ht` double(24,8) DEFAULT '0.00000000',
  `remise_percent` double DEFAULT '0',
  `remise_absolue` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_source` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_source` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facture` tinyint(4) DEFAULT '0',
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_availability` int(11) DEFAULT NULL,
  `fk_input_reason` int(11) DEFAULT NULL,
  `fk_delivery_address` int(11) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commandedet`
--

DROP TABLE IF EXISTS `jvm_commandedet`;
CREATE TABLE `jvm_commandedet` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `fk_remise_except` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_commandefourndet` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commandedet_extrafields`
--

DROP TABLE IF EXISTS `jvm_commandedet_extrafields`;
CREATE TABLE `jvm_commandedet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_extrafields`
--

DROP TABLE IF EXISTS `jvm_commande_extrafields`;
CREATE TABLE `jvm_commande_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseur`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseur`;
CREATE TABLE `jvm_commande_fournisseur` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_supplier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT '0',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `date_approve2` datetime DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_approve` int(11) DEFAULT NULL,
  `fk_user_approve2` int(11) DEFAULT NULL,
  `source` smallint(6) NOT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `billed` smallint(6) DEFAULT '0',
  `amount_ht` double(24,8) DEFAULT '0.00000000',
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `fk_input_method` int(11) DEFAULT '0',
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseurdet`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseurdet`;
CREATE TABLE `jvm_commande_fournisseurdet` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT '0.000',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `subprice` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseurdet_extrafields`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseurdet_extrafields`;
CREATE TABLE `jvm_commande_fournisseurdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseur_dispatch`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseur_dispatch`;
CREATE TABLE `jvm_commande_fournisseur_dispatch` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `fk_commandefourndet` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_reception` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `fk_entrepot` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseur_dispatch_extrafields`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseur_dispatch_extrafields`;
CREATE TABLE `jvm_commande_fournisseur_dispatch_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseur_extrafields`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseur_extrafields`;
CREATE TABLE `jvm_commande_fournisseur_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_commande_fournisseur_log`
--

DROP TABLE IF EXISTS `jvm_commande_fournisseur_log`;
CREATE TABLE `jvm_commande_fournisseur_log` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datelog` datetime NOT NULL,
  `fk_commande` int(11) NOT NULL,
  `fk_statut` smallint(6) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_comment`
--

DROP TABLE IF EXISTS `jvm_comment`;
CREATE TABLE `jvm_comment` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_element` int(11) DEFAULT NULL,
  `element_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) DEFAULT '1',
  `import_key` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_const`
--

DROP TABLE IF EXISTS `jvm_const`;
CREATE TABLE `jvm_const` (
  `rowid` int(11) NOT NULL,
  `name` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'string',
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_const`
--

INSERT INTO `jvm_const` (`rowid`, `name`, `entity`, `value`, `type`, `visible`, `note`, `tms`) VALUES
(2, 'MAIN_FEATURES_LEVEL', 0, '0', 'chaine', 1, 'Level of features to show: -1=stable+deprecated, 0=stable only (default), 1=stable+experimental, 2=stable+experimental+development', '2021-01-22 06:42:01'),
(3, 'MAILING_LIMIT_SENDBYWEB', 0, '25', 'chaine', 1, 'Number of targets to defined packet size when sending mass email', '2021-01-22 06:42:01'),
(4, 'MAIN_ENABLE_LOG_TO_HTML', 0, '0', 'chaine', 1, 'If this option is set to 1, it is possible to see log output at end of HTML sources by adding paramater logtohtml=1 on URL. Module log must also be enabled.', '2021-01-22 06:42:01'),
(9, 'MAIN_UPLOAD_DOC', 0, '2048', 'chaine', 0, 'Max size for file upload (0 means no upload allowed)', '2021-01-22 06:42:01'),
(10, 'MAIN_ENABLE_OVERWRITE_TRANSLATION', 1, '1', 'chaine', 0, 'Enable translation overwrite', '2021-01-22 06:42:01'),
(11, 'MAIN_ENABLE_DEFAULT_VALUES', 1, '1', 'chaine', 0, 'Enable default value overwrite', '2021-01-22 06:42:01'),
(16, 'MAIN_SIZE_LISTE_LIMIT', 0, '25', 'chaine', 0, 'Maximum length of lists', '2021-01-22 06:42:01'),
(17, 'MAIN_SIZE_SHORTLIST_LIMIT', 0, '3', 'chaine', 0, 'Maximum length of short lists', '2021-01-22 06:42:01'),
(18, 'MAIN_MENU_STANDARD', 0, 'eldy_menu.php', 'chaine', 0, 'Menu manager for internal users', '2021-01-22 06:42:01'),
(19, 'MAIN_MENUFRONT_STANDARD', 0, 'eldy_menu.php', 'chaine', 0, 'Menu manager for external users', '2021-01-22 06:42:01'),
(20, 'MAIN_MENU_SMARTPHONE', 0, 'eldy_menu.php', 'chaine', 0, 'Menu manager for internal users using smartphones', '2021-01-22 06:42:01'),
(21, 'MAIN_MENUFRONT_SMARTPHONE', 0, 'eldy_menu.php', 'chaine', 0, 'Menu manager for external users using smartphones', '2021-01-22 06:42:01'),
(22, 'MAIN_DELAY_ACTIONS_TODO', 1, '7', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur actions planifiées non réalisées', '2021-01-22 06:42:01'),
(23, 'MAIN_DELAY_ORDERS_TO_PROCESS', 1, '2', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur commandes clients non traitées', '2021-01-22 06:42:01'),
(24, 'MAIN_DELAY_SUPPLIER_ORDERS_TO_PROCESS', 1, '7', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur commandes fournisseurs non traitées', '2021-01-22 06:42:01'),
(25, 'MAIN_DELAY_PROPALS_TO_CLOSE', 1, '31', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur propales à cloturer', '2021-01-22 06:42:01'),
(26, 'MAIN_DELAY_PROPALS_TO_BILL', 1, '7', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur propales non facturées', '2021-01-22 06:42:01'),
(27, 'MAIN_DELAY_CUSTOMER_BILLS_UNPAYED', 1, '31', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur factures client impayées', '2021-01-22 06:42:01'),
(28, 'MAIN_DELAY_SUPPLIER_BILLS_TO_PAY', 1, '2', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur factures fournisseur impayées', '2021-01-22 06:42:01'),
(29, 'MAIN_DELAY_NOT_ACTIVATED_SERVICES', 1, '0', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur services à activer', '2021-01-22 06:42:01'),
(30, 'MAIN_DELAY_RUNNING_SERVICES', 1, '0', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur services expirés', '2021-01-22 06:42:01'),
(31, 'MAIN_DELAY_MEMBERS', 1, '31', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur cotisations adhérent en retard', '2021-01-22 06:42:01'),
(32, 'MAIN_DELAY_TRANSACTIONS_TO_CONCILIATE', 1, '62', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur rapprochements bancaires à faire', '2021-01-22 06:42:01'),
(33, 'MAIN_DELAY_EXPENSEREPORTS_TO_PAY', 1, '31', 'chaine', 0, 'Tolérance de retard avant alerte (en jours) sur les notes de frais impayées', '2021-01-22 06:42:01'),
(35, 'MAILING_EMAIL_FROM', 1, 'dolibarr@domain.com', 'chaine', 0, 'EMail emmetteur pour les envois d emailings', '2021-01-22 06:42:01'),
(36, 'PRODUCT_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/products', 'chaine', 0, NULL, '2021-01-22 06:42:01'),
(37, 'CONTRACT_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/contracts', 'chaine', 0, NULL, '2021-01-22 06:42:01'),
(38, 'USERGROUP_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/usergroups', 'chaine', 0, NULL, '2021-01-22 06:42:01'),
(39, 'USER_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/users', 'chaine', 0, NULL, '2021-01-22 06:42:01'),
(40, 'PRODUCT_PRICE_BASE_TYPE', 0, 'HT', 'string', 0, NULL, '2021-01-22 06:42:01'),
(41, 'MAIN_MODULE_USER', 0, '1', 'string', 0, '{\"authorid\":0,\"ip\":\"183.83.43.30\"}', '2021-01-22 06:42:34'),
(42, 'DATABASE_PWD_ENCRYPTED', 1, '1', 'chaine', 0, '', '2021-01-22 06:42:34'),
(43, 'MAIN_SECURITY_SALT', 0, '20210122064234', 'chaine', 0, '', '2021-01-22 06:42:34'),
(44, 'MAIN_SECURITY_HASH_ALGO', 0, 'password_hash', 'chaine', 0, '', '2021-01-22 06:42:34'),
(45, 'MAIN_VERSION_FIRST_INSTALL', 0, '13.0.0', 'chaine', 0, 'Dolibarr version when first install', '2021-01-22 06:42:34'),
(46, 'MAIN_VERSION_LAST_INSTALL', 0, '13.0.0', 'chaine', 0, 'Dolibarr version when last install', '2021-01-22 06:42:34'),
(48, 'MAIN_MODULE_ADHERENT', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:43:52'),
(49, 'ADHERENT_ADDON_PDF', 1, 'standard', 'chaine', 0, 'Name of PDF model of member', '2021-01-22 06:43:52'),
(50, 'ADHERENT_MAIL_FROM', 1, '', 'chaine', 0, 'From des mails', '2021-01-22 06:43:52'),
(51, 'ADHERENT_EMAIL_TEMPLATE_AUTOREGISTER', 1, '(SendingEmailOnAutoSubscription)', 'emailtemplate:member', 0, NULL, '2021-01-22 06:43:52'),
(52, 'ADHERENT_EMAIL_TEMPLATE_SUBSCRIPTION', 1, '(SendingEmailOnNewSubscription)', 'emailtemplate:member', 0, NULL, '2021-01-22 06:43:52'),
(53, 'ADHERENT_EMAIL_TEMPLATE_REMIND_EXPIRATION', 1, '(SendingReminderForExpiredSubscription)', 'emailtemplate:member', 0, NULL, '2021-01-22 06:43:52'),
(54, 'ADHERENT_EMAIL_TEMPLATE_CANCELATION', 1, '(SendingEmailOnCancelation)', 'emailtemplate:member', 0, NULL, '2021-01-22 06:43:52'),
(55, 'ADHERENT_CARD_HEADER_TEXT', 1, '__YEAR__', 'chaine', 0, 'Texte imprimé sur le haut de la carte adhérent', '2021-01-22 06:43:52'),
(56, 'ADHERENT_CARD_FOOTER_TEXT', 1, '__COMPANY__', 'chaine', 0, 'Texte imprimé sur le bas de la carte adhérent', '2021-01-22 06:43:52'),
(57, 'ADHERENT_CARD_TEXT', 1, '__FULLNAME__\r\nID: __ID__\r\n__EMAIL__\r\n__ADDRESS__\r\n__ZIP__ __TOWN__\r\n__COUNTRY__', 'texte', 0, 'Text to print on member cards', '2021-01-22 06:43:52'),
(58, 'ADHERENT_MAILMAN_ADMINPW', 1, '', 'chaine', 0, 'Mot de passe Admin des liste mailman', '2021-01-22 06:43:52'),
(59, 'ADHERENT_ETIQUETTE_TYPE', 1, 'L7163', 'chaine', 0, 'Type of address sheets', '2021-01-22 06:43:52'),
(60, 'ADHERENT_ETIQUETTE_TEXT', 1, '__FULLNAME__\n__ADDRESS__\n__ZIP__ __TOWN__\n__COUNTRY%', 'texte', 0, 'Text to print on member address sheets', '2021-01-22 06:43:52'),
(61, 'ADHERENT_BANK_ACCOUNT', 1, '', 'chaine', 0, 'ID of bank account to use', '2021-01-22 06:43:52'),
(62, 'ADHERENT_BANK_CATEGORIE', 1, '', 'chaine', 0, 'ID of bank transaction category to use', '2021-01-22 06:43:52'),
(63, 'MEMBER_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/members', 'chaine', 0, NULL, '2021-01-22 06:43:52'),
(64, 'MAIN_MODULE_SOCIETE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:44:00'),
(65, 'SOCIETE_CODECLIENT_ADDON', 1, 'mod_codeclient_monkey', 'chaine', 0, 'Module to control third parties codes', '2021-01-22 06:44:00'),
(66, 'SOCIETE_CODECOMPTA_ADDON', 1, 'mod_codecompta_panicum', 'chaine', 0, 'Module to control third parties codes', '2021-01-22 06:44:00'),
(68, 'COMPANY_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/thirdparties', 'chaine', 0, NULL, '2021-01-22 06:44:00'),
(69, 'SOCIETE_ADD_REF_IN_LIST', 1, '0', 'yesno', 0, 'Display customer ref into select list', '2021-01-22 06:44:00'),
(70, 'MAIN_MODULE_PROPALE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:44:22'),
(71, 'PROPALE_ADDON_PDF', 1, 'azur', 'chaine', 0, 'Name of the proposal generation manager in PDF format', '2021-01-22 06:44:22'),
(72, 'PROPALE_ADDON', 1, 'mod_propale_marbre', 'chaine', 0, 'Name of proposal numbering manager', '2021-01-22 06:44:22'),
(73, 'PROPALE_VALIDITY_DURATION', 1, '15', 'chaine', 0, 'Duration of validity of business proposals', '2021-01-22 06:44:22'),
(74, 'PROPALE_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/proposals', 'chaine', 0, NULL, '2021-01-22 06:44:22'),
(75, 'MAIN_MODULE_COMMANDE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:44:27'),
(76, 'COMMANDE_ADDON_PDF', 1, 'einstein', 'chaine', 0, 'Name of PDF model of order', '2021-01-22 06:44:27'),
(77, 'COMMANDE_ADDON', 1, 'mod_commande_marbre', 'chaine', 0, 'Name of numbering numerotation rules of order', '2021-01-22 06:44:27'),
(78, 'COMMANDE_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/orders', 'chaine', 0, NULL, '2021-01-22 06:44:27'),
(79, 'MAIN_MODULE_FOURNISSEUR', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:44:36'),
(80, 'COMMANDE_SUPPLIER_ADDON_PDF', 1, 'muscadet', 'chaine', 0, 'Nom du gestionnaire de generation des bons de commande en PDF', '2021-01-22 06:44:36'),
(81, 'COMMANDE_SUPPLIER_ADDON_NUMBER', 1, 'mod_commande_fournisseur_muguet', 'chaine', 0, 'Nom du gestionnaire de numerotation des commandes fournisseur', '2021-01-22 06:44:36'),
(82, 'INVOICE_SUPPLIER_ADDON_NUMBER', 1, 'mod_facture_fournisseur_cactus', 'chaine', 0, 'Nom du gestionnaire de numerotation des factures fournisseur', '2021-01-22 06:44:36'),
(83, 'SUPPLIER_ORDER_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/supplier_orders', 'chaine', 0, NULL, '2021-01-22 06:44:36'),
(84, 'MAIN_MODULE_SUPPLIERPROPOSAL', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:44:43'),
(85, 'SUPPLIER_PROPOSAL_ADDON_PDF', 1, 'aurore', 'chaine', 0, 'Name of submodule to generate PDF for supplier quotation request', '2021-01-22 06:44:43'),
(86, 'SUPPLIER_PROPOSAL_ADDON', 1, 'mod_supplier_proposal_marbre', 'chaine', 0, 'Name of submodule to number supplier quotation request', '2021-01-22 06:44:43'),
(87, 'SUPPLIER_PROPOSAL_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/supplier_proposals', 'chaine', 0, NULL, '2021-01-22 06:44:43'),
(88, 'MAIN_MODULE_FACTURE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:00'),
(89, 'FACTURE_ADDON', 1, 'mod_facture_terre', 'chaine', 0, 'Name of numbering numerotation rules of invoice', '2021-01-22 06:45:00'),
(90, 'FACTURE_ADDON_PDF', 1, 'crabe', 'chaine', 0, 'Name of PDF model of invoice', '2021-01-22 06:45:00'),
(91, 'FACTURE_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/invoices', 'chaine', 0, NULL, '2021-01-22 06:45:00'),
(92, 'MAIN_MODULE_TAX', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:07'),
(93, 'MAIN_MODULE_PRODUCT', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:21'),
(94, 'PRODUCT_CODEPRODUCT_ADDON', 1, 'mod_codeproduct_leopard', 'chaine', 0, 'Module to control product codes', '2021-01-22 06:45:21'),
(95, 'PRODUCT_PRICE_UNIQ', 1, '1', 'chaine', 0, 'pricing rule by default', '2021-01-22 06:45:21'),
(96, 'MAIN_MODULE_SERVICE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:32'),
(97, 'MAIN_MODULE_STOCK', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:37'),
(99, 'STOCK_ADDON_PDF', 1, 'standard', 'chaine', 0, 'Name of PDF model of stock', '2021-01-22 06:45:37'),
(100, 'MOUVEMENT_ADDON_PDF', 1, 'stdmovement', 'chaine', 0, 'Name of PDF model of stock mouvement', '2021-01-22 06:45:37'),
(101, 'STOCK_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/stocks', 'chaine', 0, NULL, '2021-01-22 06:45:37'),
(102, 'MOUVEMENT_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/stocks/mouvements', 'chaine', 0, NULL, '2021-01-22 06:45:37'),
(103, 'MAIN_MODULE_PRODUCTBATCH', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:46'),
(104, 'MAIN_MODULE_EXPEDITION', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:46'),
(105, 'EXPEDITION_ADDON_PDF', 1, 'rouget', 'chaine', 0, 'Nom du gestionnaire de generation des bons expeditions en PDF', '2021-01-22 06:45:46'),
(106, 'EXPEDITION_ADDON_NUMBER', 1, 'mod_expedition_safor', 'chaine', 0, 'Name for numbering manager for shipments', '2021-01-22 06:45:46'),
(107, 'EXPEDITION_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/shipments', 'chaine', 0, NULL, '2021-01-22 06:45:46'),
(108, 'DELIVERY_ADDON_PDF', 1, 'typhon', 'chaine', 0, 'Nom du gestionnaire de generation des bons de reception en PDF', '2021-01-22 06:45:46'),
(109, 'DELIVERY_ADDON_NUMBER', 1, 'mod_delivery_jade', 'chaine', 0, 'Nom du gestionnaire de numerotation des bons de reception', '2021-01-22 06:45:46'),
(110, 'DELIVERY_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/deliveries', 'chaine', 0, NULL, '2021-01-22 06:45:46'),
(111, 'MAIN_SUBMODULE_EXPEDITION', 1, '1', 'chaine', 0, 'Enable delivery receipts', '2021-01-22 06:45:46'),
(112, 'MAIN_MODULE_PROJET', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:45:55'),
(113, 'PROJECT_ADDON_PDF', 1, 'baleine', 'chaine', 0, 'Name of PDF/ODT project manager class', '2021-01-22 06:45:55'),
(114, 'PROJECT_ADDON', 1, 'mod_project_simple', 'chaine', 0, 'Name of Numbering Rule project manager class', '2021-01-22 06:45:55'),
(115, 'PROJECT_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/projects', 'chaine', 0, NULL, '2021-01-22 06:45:55'),
(116, 'PROJECT_TASK_ADDON_PDF', 1, '', 'chaine', 0, 'Name of PDF/ODT tasks manager class', '2021-01-22 06:45:55'),
(117, 'PROJECT_TASK_ADDON', 1, 'mod_task_simple', 'chaine', 0, 'Name of Numbering Rule task manager class', '2021-01-22 06:45:55'),
(118, 'PROJECT_TASK_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/tasks', 'chaine', 0, NULL, '2021-01-22 06:45:55'),
(119, 'PROJECT_USE_OPPORTUNITIES', 1, '1', 'chaine', 0, NULL, '2021-01-22 06:45:55'),
(120, 'MAIN_DELAY_PROJECT_TO_CLOSE', 1, '7', 'chaine', 0, NULL, '2021-01-22 06:45:55'),
(121, 'MAIN_DELAY_TASKS_TODO', 1, '7', 'chaine', 0, NULL, '2021-01-22 06:45:55'),
(122, 'MAIN_MODULE_CATEGORIE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:06'),
(123, 'CATEGORIE_RECURSIV_ADD', 1, '0', 'yesno', 0, 'Affect parent categories', '2021-01-22 06:46:06'),
(124, 'MAIN_MODULE_FCKEDITOR', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:10'),
(125, 'FCKEDITOR_ENABLE_SOCIETE', 1, '1', 'yesno', 0, 'WYSIWIG for description and note (except products/services)', '2021-01-22 06:46:10'),
(126, 'FCKEDITOR_ENABLE_PRODUCTDESC', 1, '1', 'yesno', 0, 'WYSIWIG for products/services description and note', '2021-01-22 06:46:10'),
(127, 'FCKEDITOR_ENABLE_MAILING', 1, '1', 'yesno', 0, 'WYSIWIG for mass emailings', '2021-01-22 06:46:10'),
(128, 'FCKEDITOR_ENABLE_DETAILS', 1, '1', 'yesno', 0, 'WYSIWIG for products details lines for all entities', '2021-01-22 06:46:10'),
(129, 'FCKEDITOR_ENABLE_USERSIGN', 1, '1', 'yesno', 0, 'WYSIWIG for user signature', '2021-01-22 06:46:10'),
(130, 'FCKEDITOR_ENABLE_MAIL', 1, '1', 'yesno', 0, 'WYSIWIG for products details lines for all entities', '2021-01-22 06:46:10'),
(131, 'FCKEDITOR_SKIN', 1, 'moono-lisa', 'string', 0, 'Skin by default for fckeditor', '2021-01-22 06:46:10'),
(132, 'MAIN_MODULE_BARCODE', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:18'),
(133, 'MAIN_MODULE_IMPORT', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:26'),
(134, 'MAIN_MODULE_EXPORT', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:30'),
(135, 'MAIN_MODULE_MAILING', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:40'),
(136, 'MAIN_MODULE_PRINTING', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.43.30\"}', '2021-01-22 06:46:50'),
(156, 'MAIN_INFO_SOCIETE_COUNTRY', 1, '117:IN:India', 'chaine', 0, '', '2021-01-22 07:32:50'),
(157, 'MAIN_INFO_SOCIETE_STATE', 1, '1015:RJ:Rajasthan', 'chaine', 0, '', '2021-01-22 07:32:50'),
(158, 'MAIN_INFO_SOCIETE_NOM', 1, 'JVMD', 'chaine', 0, '', '2021-01-22 07:32:50'),
(159, 'MAIN_INFO_SOCIETE_ADDRESS', 1, 'Jaipur', 'chaine', 0, '', '2021-01-22 07:32:50'),
(160, 'MAIN_INFO_SOCIETE_TOWN', 1, 'Jaipur', 'chaine', 0, '', '2021-01-22 07:32:50'),
(161, 'MAIN_INFO_SOCIETE_ZIP', 1, '302019', 'chaine', 0, '', '2021-01-22 07:32:50'),
(162, 'MAIN_MONNAIE', 1, 'INR', 'chaine', 0, '', '2021-01-22 07:32:50'),
(163, 'MAIN_INFO_SOCIETE_TEL', 1, '9462045321', 'chaine', 0, '', '2021-01-22 07:32:50'),
(164, 'MAIN_INFO_SOCIETE_MAIL', 1, 'support@microcrm.in', 'chaine', 0, '', '2021-01-22 07:32:50'),
(165, 'MAIN_INFO_SOCIETE_WEB', 1, 'http://www.microcrm.in', 'chaine', 0, '', '2021-01-22 07:32:50'),
(166, 'MAIN_INFO_SOCIETE_NOTE', 1, 'JVMD', 'chaine', 0, '', '2021-01-22 07:32:50'),
(167, 'MAIN_INFO_SOCIETE_LOGO', 1, 'blue-star-limited-logo-vector.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(168, 'MAIN_INFO_SOCIETE_LOGO_SMALL', 1, 'blue-star-limited-logo-vector_small.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(169, 'MAIN_INFO_SOCIETE_LOGO_MINI', 1, 'blue-star-limited-logo-vector_mini.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(170, 'MAIN_INFO_SOCIETE_LOGO_SQUARRED', 1, 'blue-star-limited-logo-vector.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(171, 'MAIN_INFO_SOCIETE_LOGO_SQUARRED_SMALL', 1, 'blue-star-limited-logo-vector_small.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(172, 'MAIN_INFO_SOCIETE_LOGO_SQUARRED_MINI', 1, 'blue-star-limited-logo-vector_mini.png', 'chaine', 0, '', '2021-01-22 07:32:50'),
(173, 'MAIN_INFO_SOCIETE_MANAGERS', 1, 'Dileep', 'chaine', 0, '', '2021-01-22 07:32:50'),
(174, 'MAIN_INFO_SOCIETE_FORME_JURIDIQUE', 1, '0', 'chaine', 0, '', '2021-01-22 07:32:50'),
(175, 'SOCIETE_FISCAL_MONTH_START', 1, '4', 'chaine', 0, '', '2021-01-22 07:32:50'),
(176, 'FACTURE_TVAOPTION', 1, '1', 'chaine', 0, '', '2021-01-22 07:32:50'),
(177, 'FACTURE_LOCAL_TAX1_OPTION', 1, 'localtax1off', 'chaine', 0, '', '2021-01-22 07:32:50'),
(178, 'FACTURE_LOCAL_TAX2_OPTION', 1, 'localtax2off', 'chaine', 0, '', '2021-01-22 07:32:50'),
(179, 'MAIN_MODULE_CRON', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.176.10\"}', '2021-01-22 07:34:26'),
(180, 'CRON_KEY', 0, '', 'chaine', 0, 'CRON KEY', '2021-01-22 07:34:26'),
(181, 'MAIN_MODULE_SYSLOG', 0, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.176.10\"}', '2021-01-22 07:34:31'),
(182, 'MAIN_MODULE_DEBUGBAR', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.176.10\"}', '2021-01-22 07:34:35'),
(183, 'MAIN_MODULE_DEBUGBAR_MODULEFOREXTERNAL', 1, '0', 'chaine', 0, NULL, '2021-01-22 07:34:35'),
(187, 'SYSLOG_LEVEL', 0, '7', 'chaine', 0, '', '2021-01-22 07:35:44'),
(188, 'SYSLOG_FILE', 0, 'DOL_DATA_ROOT/dolibarr.log', 'chaine', 0, '', '2021-01-22 07:35:48'),
(189, 'SYSLOG_FACILITY', 0, 'DOL_DATA_ROOT/dolibarr.log', 'chaine', 0, '', '2021-01-22 07:35:48'),
(190, 'SYSLOG_HANDLERS', 0, '[\"mod_syslog_file\"]', 'chaine', 0, '', '2021-01-22 07:35:48'),
(191, 'MAIN_SHOW_LOGO', 1, '1', 'chaine', 0, '', '2021-01-22 07:42:54'),
(246, 'MAIN_MULTILANGS', 1, '1', 'chaine', 0, '', '2021-01-22 07:46:19'),
(247, 'MAIN_LAST_PING_KO_DATE', 1, '20210122074802', 'gmt', 0, '', '2021-01-22 07:48:02'),
(248, 'MAIN_INFO_OPENINGHOURS_MONDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(249, 'MAIN_INFO_OPENINGHOURS_TUESDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(250, 'MAIN_INFO_OPENINGHOURS_WEDNESDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(251, 'MAIN_INFO_OPENINGHOURS_THURSDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(252, 'MAIN_INFO_OPENINGHOURS_FRIDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(253, 'MAIN_INFO_OPENINGHOURS_SATURDAY', 1, '10 AM - 7 PM', 'chaine', 0, '', '2021-01-22 07:49:59'),
(254, 'MAIN_SECURITY_ENABLECAPTCHA', 1, '1', 'chaine', 0, '', '2021-01-22 07:52:57'),
(255, 'MAIN_SESSION_TIMEOUT', 1, '1440', 'chaine', 0, '', '2021-01-22 07:53:04'),
(256, 'USER_PASSWORD_PATTERN', 1, '10;1;1;1;3;1', 'chaine', 0, '', '2021-01-22 07:53:35'),
(258, 'USER_PASSWORD_GENERATED', 1, 'standard', 'chaine', 0, '', '2021-01-22 07:53:59'),
(259, 'MAIN_PDF_FORMAT', 1, 'EUA4', 'chaine', 0, '', '2021-01-22 07:55:37'),
(260, 'MAIN_PDF_MARGIN_LEFT', 1, '10', 'chaine', 0, '', '2021-01-22 07:55:37'),
(261, 'MAIN_PDF_MARGIN_RIGHT', 1, '10', 'chaine', 0, '', '2021-01-22 07:55:37'),
(262, 'MAIN_PDF_MARGIN_BOTTOM', 1, '10', 'chaine', 0, '', '2021-01-22 07:55:37'),
(263, 'MAIN_PROFID1_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(264, 'MAIN_PROFID2_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(265, 'MAIN_PROFID3_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(266, 'MAIN_PROFID4_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(267, 'MAIN_PROFID5_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(268, 'MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(269, 'MAIN_TVAINTRA_NOT_IN_ADDRESS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(270, 'MAIN_GENERATE_DOCUMENTS_HIDE_DETAILS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(271, 'MAIN_GENERATE_DOCUMENTS_HIDE_DESC', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(272, 'MAIN_GENERATE_DOCUMENTS_HIDE_REF', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(273, 'MAIN_DOCUMENTS_LOGO_HEIGHT', 1, '20', 'chaine', 0, '', '2021-01-22 07:55:37'),
(274, 'MAIN_INVERT_SENDER_RECIPIENT', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(275, 'MAIN_PDF_USE_ISO_LOCATION', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(276, 'MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(277, 'MAIN_PDF_MAIN_HIDE_SECOND_TAX', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(278, 'MAIN_PDF_MAIN_HIDE_THIRD_TAX', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(279, 'PDF_USE_ALSO_LANGUAGE_CODE', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(280, 'SHOW_SUBPRODUCT_REF_IN_PDF', 1, '0', 'chaine', 0, '', '2021-01-22 07:55:37'),
(281, 'MAIN_SECURITY_CSRF_WITH_TOKEN', 0, '1', 'chaine', 1, 'If this option is set to 1, a CSRF protection using an antiCSRF token is added.', '2021-01-22 07:57:18'),
(282, 'MAIN_FIX_FOR_BUGGED_MTA', 1, '1', 'chaine', 1, 'Set constant to fix email ending from PHP with some linux ike system', '2021-01-22 07:57:32'),
(283, 'STOCK_ALLOW_NEGATIVE_TRANSFER', 1, '0', 'chaine', 1, '', '2021-01-22 07:57:32'),
(284, 'MAIN_DISABLE_ALL_MAILS', 1, '0', 'chaine', 0, '', '2021-01-22 14:38:16'),
(285, 'MAIN_MAIL_FORCE_SENDTO', 1, 'support@microcrm.in', 'chaine', 0, '', '2021-01-22 14:38:16'),
(286, 'MAIN_MAIL_ENABLED_USER_DEST_SELECT', 1, '0', 'chaine', 0, '', '2021-01-22 14:38:16'),
(287, 'MAIN_MAIL_SENDMODE', 1, 'swiftmailer', 'chaine', 0, '', '2021-01-22 14:38:16'),
(288, 'MAIN_MAIL_SMTP_PORT', 1, '465', 'chaine', 0, '', '2021-01-22 14:38:16'),
(289, 'MAIN_MAIL_SMTP_SERVER', 1, 'mail.microcrm.in', 'chaine', 0, '', '2021-01-22 14:38:16'),
(290, 'MAIN_MAIL_SMTPS_PW', 1, 'supportmicrocrm@123456', 'chaine', 0, '', '2021-01-22 14:38:16'),
(291, 'MAIN_MAIL_EMAIL_TLS', 1, '0', 'chaine', 0, '', '2021-01-22 14:38:16'),
(292, 'MAIN_MAIL_EMAIL_STARTTLS', 1, '1', 'chaine', 0, '', '2021-01-22 14:38:16'),
(293, 'MAIN_MAIL_EMAIL_SMTP_ALLOW_SELF_SIGNED', 1, '1', 'chaine', 0, '', '2021-01-22 14:38:16'),
(294, 'MAIN_MAIL_EMAIL_DKIM_ENABLED', 1, '1', 'chaine', 0, '', '2021-01-22 14:38:16'),
(295, 'MAIN_MAIL_EMAIL_FROM', 1, 'support@microcrm.in', 'chaine', 0, '', '2021-01-22 14:38:16'),
(296, 'MAIN_MAIL_ERRORS_TO', 1, 'support@microcrm.in', 'chaine', 0, '', '2021-01-22 14:38:16'),
(297, 'MAIN_MAIL_AUTOCOPY_TO', 1, 'support@microcrm.in', 'chaine', 0, '', '2021-01-22 14:38:16'),
(298, 'MAIN_MAIL_DEFAULT_FROMTYPE', 1, 'company', 'chaine', 0, '', '2021-01-22 14:38:16'),
(299, 'MAIN_MENU_HIDE_UNAUTHORIZED', 1, '1', 'chaine', 0, '', '2021-01-23 13:56:41'),
(300, 'MAIN_BUTTON_HIDE_UNAUTHORIZED', 1, '1', 'chaine', 0, '', '2021-01-23 13:56:47'),
(305, 'TICKET_ENABLE_PUBLIC_INTERFACE', 1, '0', 'chaine', 0, 'Enable ticket public interface', '2021-01-25 07:32:08'),
(306, 'TICKET_ADDON', 1, 'mod_ticket_simple', 'chaine', 0, 'Ticket ref module', '2021-01-25 07:32:08'),
(307, 'TICKET_ADDON_PDF_ODT_PATH', 1, 'DOL_DATA_ROOT/doctemplates/tickets', 'chaine', 0, 'Ticket templates ODT/ODS directory for templates', '2021-01-25 07:32:08'),
(308, 'MAIN_MODULE_AGENDA', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.176.10\"}', '2021-01-25 07:32:08'),
(309, 'MAIN_AGENDA_ACTIONAUTO_COMPANY_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(310, 'MAIN_AGENDA_ACTIONAUTO_COMPANY_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(311, 'MAIN_AGENDA_ACTIONAUTO_COMPANY_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(312, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(313, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_CLOSE_SIGNED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(314, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_CLOSE_REFUSED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(315, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_CLASSIFY_BILLED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(316, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(317, 'MAIN_AGENDA_ACTIONAUTO_PROPAL_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(318, 'MAIN_AGENDA_ACTIONAUTO_ORDER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(319, 'MAIN_AGENDA_ACTIONAUTO_ORDER_CLOSE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(320, 'MAIN_AGENDA_ACTIONAUTO_ORDER_CLASSIFY_BILLED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(321, 'MAIN_AGENDA_ACTIONAUTO_ORDER_CANCEL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(322, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(323, 'MAIN_AGENDA_ACTIONAUTO_ORDER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(324, 'MAIN_AGENDA_ACTIONAUTO_BILL_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(325, 'MAIN_AGENDA_ACTIONAUTO_BILL_PAYED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(326, 'MAIN_AGENDA_ACTIONAUTO_BILL_CANCEL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(327, 'MAIN_AGENDA_ACTIONAUTO_BILL_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(328, 'MAIN_AGENDA_ACTIONAUTO_BILL_UNVALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(329, 'MAIN_AGENDA_ACTIONAUTO_BILL_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(330, 'MAIN_AGENDA_ACTIONAUTO_PROPOSAL_SUPPLIER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(331, 'MAIN_AGENDA_ACTIONAUTO_PROPOSAL_SUPPLIER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(332, 'MAIN_AGENDA_ACTIONAUTO_PROPOSAL_SUPPLIER_CLOSE_SIGNED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(333, 'MAIN_AGENDA_ACTIONAUTO_PROPOSAL_SUPPLIER_CLOSE_REFUSED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(334, 'MAIN_AGENDA_ACTIONAUTO_PROPOSAL_SUPPLIER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(335, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(336, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_APPROVE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(337, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_SUBMIT', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(338, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_RECEIVE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(339, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_REFUSE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(340, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(341, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_CLASSIFY_BILLED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(342, 'MAIN_AGENDA_ACTIONAUTO_ORDER_SUPPLIER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(343, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(344, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_UNVALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(345, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_PAYED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(346, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(347, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_CANCELED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(348, 'MAIN_AGENDA_ACTIONAUTO_BILL_SUPPLIER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(349, 'MAIN_AGENDA_ACTIONAUTO_CONTRACT_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(350, 'MAIN_AGENDA_ACTIONAUTO_CONTRACT_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(351, 'MAIN_AGENDA_ACTIONAUTO_CONTRACT_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(352, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(353, 'MAIN_AGENDA_ACTIONAUTO_SHIPPING_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(354, 'MAIN_AGENDA_ACTIONAUTO_SHIPPING_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(355, 'MAIN_AGENDA_ACTIONAUTO_SHIPPING_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(356, 'MAIN_AGENDA_ACTIONAUTO_RECEPTION_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(357, 'MAIN_AGENDA_ACTIONAUTO_RECEPTION_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(358, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(359, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(360, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(361, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_SUBSCRIPTION_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(362, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_SUBSCRIPTION_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(363, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_SUBSCRIPTION_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(364, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_RESILIATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(365, 'MAIN_AGENDA_ACTIONAUTO_MEMBER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(366, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(367, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_CLASSIFY_BILLED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(368, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_CLASSIFY_UNBILLED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(369, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_REOPEN', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(370, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(371, 'MAIN_AGENDA_ACTIONAUTO_FICHINTER_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(372, 'MAIN_AGENDA_ACTIONAUTO_PRODUCT_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(373, 'MAIN_AGENDA_ACTIONAUTO_PRODUCT_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(374, 'MAIN_AGENDA_ACTIONAUTO_PRODUCT_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(375, 'MAIN_AGENDA_ACTIONAUTO_CONTACT_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(376, 'MAIN_AGENDA_ACTIONAUTO_CONTACT_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(377, 'MAIN_AGENDA_ACTIONAUTO_CONTACT_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(378, 'MAIN_AGENDA_ACTIONAUTO_PROJECT_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(379, 'MAIN_AGENDA_ACTIONAUTO_PROJECT_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(380, 'MAIN_AGENDA_ACTIONAUTO_PROJECT_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(381, 'MAIN_AGENDA_ACTIONAUTO_PROJECT_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(382, 'MAIN_AGENDA_ACTIONAUTO_TICKET_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(383, 'MAIN_AGENDA_ACTIONAUTO_TICKET_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(384, 'MAIN_AGENDA_ACTIONAUTO_TICKET_ASSIGNED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(385, 'MAIN_AGENDA_ACTIONAUTO_TICKET_CLOSE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(386, 'MAIN_AGENDA_ACTIONAUTO_TICKET_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(387, 'MAIN_AGENDA_ACTIONAUTO_TICKET_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(388, 'MAIN_AGENDA_ACTIONAUTO_EXPENSE_REPORT_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(389, 'MAIN_AGENDA_ACTIONAUTO_EXPENSE_REPORT_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(390, 'MAIN_AGENDA_ACTIONAUTO_EXPENSE_REPORT_APPROVE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(391, 'MAIN_AGENDA_ACTIONAUTO_EXPENSE_REPORT_PAYED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(392, 'MAIN_AGENDA_ACTIONAUTO_EXPENSE_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(393, 'MAIN_AGENDA_ACTIONAUTO_HOLIDAY_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(394, 'MAIN_AGENDA_ACTIONAUTO_HOLIDAY_APPROVE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(395, 'MAIN_AGENDA_ACTIONAUTO_USER_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(396, 'MAIN_AGENDA_ACTIONAUTO_BOM_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(397, 'MAIN_AGENDA_ACTIONAUTO_BOM_UNVALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(398, 'MAIN_AGENDA_ACTIONAUTO_BOM_CLOSE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(399, 'MAIN_AGENDA_ACTIONAUTO_BOM_REOPEN', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(400, 'MAIN_AGENDA_ACTIONAUTO_BOM_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(401, 'MAIN_AGENDA_ACTIONAUTO_MRP_MO_VALIDATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(402, 'MAIN_AGENDA_ACTIONAUTO_MRP_MO_PRODUCED', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(403, 'MAIN_AGENDA_ACTIONAUTO_MRP_MO_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(404, 'MAIN_AGENDA_ACTIONAUTO_MRP_MO_CANCEL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(405, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTJOBPOSITION_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(406, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTJOBPOSITION_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(407, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTJOBPOSITION_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(408, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTJOBPOSITION_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(409, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTCANDIDATURE_CREATE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(410, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTCANDIDATURE_MODIFY', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(411, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTCANDIDATURE_SENTBYMAIL', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(412, 'MAIN_AGENDA_ACTIONAUTO_RECRUITMENTCANDIDATURE_DELETE', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:08'),
(413, 'MAIN_MODULE_TICKET', 1, '1', 'string', 0, '{\"authorid\":\"1\",\"ip\":\"183.83.176.10\"}', '2021-01-25 07:32:31'),
(414, 'MAIN_MODULE_TICKET_TABS_0', 1, 'thirdparty:+ticket:Tickets:@ticket:$user->rights->ticket->read:/ticket/list.php?socid=__ID__', 'chaine', 0, NULL, '2021-01-25 07:32:31'),
(415, 'MAIN_MODULE_TICKET_TABS_1', 1, 'project:+ticket:Tickets:@ticket:$user->rights->ticket->read:/ticket/list.php?projectid=__ID__', 'chaine', 0, NULL, '2021-01-25 07:32:31'),
(416, 'MAIN_MODULE_TICKET_TRIGGERS', 1, '1', 'chaine', 0, NULL, '2021-01-25 07:32:31'),
(417, 'MAIN_HELPCENTER_DISABLELINK', 1, '1', 'chaine', 0, '', '2021-01-25 14:13:42'),
(418, 'MAIN_LANG_DEFAULT', 1, 'auto', 'chaine', 0, '', '2021-01-25 14:13:45'),
(419, 'MAIN_IHM_PARAMS_REV', 1, '7', 'chaine', 0, '', '2021-01-25 14:13:45'),
(420, 'MAIN_THEME', 1, 'eldy', 'chaine', 0, '', '2021-01-25 14:13:45'),
(421, 'MAIN_SIZE_LISTE_LIMIT', 1, '25', 'chaine', 0, '', '2021-01-25 14:13:45'),
(422, 'MAIN_SIZE_SHORTLIST_LIMIT', 1, '3', 'chaine', 0, '', '2021-01-25 14:13:45'),
(423, 'MAIN_START_WEEK', 1, '1', 'chaine', 0, '', '2021-01-25 14:13:45'),
(424, 'MAIN_DEFAULT_WORKING_DAYS', 1, '1-5', 'chaine', 0, '', '2021-01-25 14:13:45'),
(425, 'MAIN_DEFAULT_WORKING_HOURS', 1, '9-18', 'chaine', 0, '', '2021-01-25 14:13:45'),
(426, 'MAIN_FIRSTNAME_NAME_POSITION', 1, '0', 'chaine', 0, '', '2021-01-25 14:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `jvm_contrat`
--

DROP TABLE IF EXISTS `jvm_contrat`;
CREATE TABLE `jvm_contrat` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_customer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_supplier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `date_contrat` datetime DEFAULT NULL,
  `statut` smallint(6) DEFAULT '0',
  `fin_validite` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_commercial_signature` int(11) DEFAULT NULL,
  `fk_commercial_suivi` int(11) DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL DEFAULT '0',
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_contratdet`
--

DROP TABLE IF EXISTS `jvm_contratdet`;
CREATE TABLE `jvm_contratdet` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_contrat` int(11) NOT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `statut` smallint(6) DEFAULT '0',
  `label` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `fk_remise_except` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `date_ouverture_prevue` datetime DEFAULT NULL,
  `date_ouverture` datetime DEFAULT NULL,
  `date_fin_validite` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT '0.000',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double NOT NULL,
  `remise_percent` double DEFAULT '0',
  `subprice` double(24,8) DEFAULT '0.00000000',
  `price_ht` double DEFAULT NULL,
  `remise` double DEFAULT '0',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `product_type` int(11) DEFAULT '1',
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT NULL,
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL DEFAULT '0',
  `fk_user_ouverture` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `commentaire` text COLLATE utf8_unicode_ci,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_contratdet_extrafields`
--

DROP TABLE IF EXISTS `jvm_contratdet_extrafields`;
CREATE TABLE `jvm_contratdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_contratdet_log`
--

DROP TABLE IF EXISTS `jvm_contratdet_log`;
CREATE TABLE `jvm_contratdet_log` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_contratdet` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `statut` smallint(6) NOT NULL,
  `fk_user_author` int(11) NOT NULL,
  `commentaire` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_contrat_extrafields`
--

DROP TABLE IF EXISTS `jvm_contrat_extrafields`;
CREATE TABLE `jvm_contrat_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_cronjob`
--

DROP TABLE IF EXISTS `jvm_cronjob`;
CREATE TABLE `jvm_cronjob` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `jobtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `label` text COLLATE utf8_unicode_ci NOT NULL,
  `command` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classesname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objectname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `methodename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `params` text COLLATE utf8_unicode_ci,
  `md5params` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT '0',
  `datelastrun` datetime DEFAULT NULL,
  `datenextrun` datetime DEFAULT NULL,
  `datestart` datetime DEFAULT NULL,
  `dateend` datetime DEFAULT NULL,
  `datelastresult` datetime DEFAULT NULL,
  `lastresult` text COLLATE utf8_unicode_ci,
  `lastoutput` text COLLATE utf8_unicode_ci,
  `unitfrequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '3600',
  `frequency` int(11) NOT NULL DEFAULT '0',
  `maxrun` int(11) NOT NULL DEFAULT '0',
  `nbrun` int(11) DEFAULT NULL,
  `autodelete` int(11) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `processing` int(11) NOT NULL DEFAULT '0',
  `test` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `fk_mailing` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `libname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_cronjob`
--

INSERT INTO `jvm_cronjob` (`rowid`, `tms`, `datec`, `jobtype`, `label`, `command`, `classesname`, `objectname`, `methodename`, `params`, `md5params`, `module_name`, `priority`, `datelastrun`, `datenextrun`, `datestart`, `dateend`, `datelastresult`, `lastresult`, `lastoutput`, `unitfrequency`, `frequency`, `maxrun`, `nbrun`, `autodelete`, `status`, `processing`, `test`, `fk_user_author`, `fk_user_mod`, `fk_mailing`, `note`, `libname`, `entity`) VALUES
(1, '2021-01-22 06:43:52', '2021-01-22 06:43:52', 'method', 'SendReminderForExpiredSubscriptionTitle', NULL, 'adherents/class/adherent.class.php', 'Adherent', 'sendReminderForExpiredSubscription', '10;0', NULL, 'adherent', 50, NULL, NULL, '2021-01-22 22:00:00', NULL, NULL, NULL, NULL, '86400', 1, 0, NULL, 0, 1, 0, '$conf->adherent->enabled', NULL, NULL, NULL, 'SendReminderForExpiredSubscription', NULL, 1),
(2, '2021-01-22 06:45:00', '2021-01-22 06:45:00', 'method', 'RecurringInvoices', NULL, 'compta/facture/class/facture-rec.class.php', 'FactureRec', 'createRecurringInvoices', NULL, NULL, 'facture', 50, NULL, NULL, '2021-01-22 23:00:00', NULL, NULL, NULL, NULL, '86400', 1, 0, NULL, 0, 1, 0, '$conf->facture->enabled', NULL, NULL, NULL, 'Generate recurring invoices', NULL, 1),
(3, '2021-01-22 07:34:26', '2021-01-22 07:34:26', 'method', 'PurgeDeleteTemporaryFilesShort', NULL, 'core/class/utils.class.php', 'Utils', 'purgeFiles', NULL, NULL, 'cron', 50, NULL, NULL, '2021-01-22 07:34:26', NULL, NULL, NULL, NULL, '604800', 2, 0, NULL, 0, 1, 0, '1', NULL, NULL, NULL, 'PurgeDeleteTemporaryFiles', NULL, 0),
(4, '2021-01-22 07:34:26', '2021-01-22 07:34:26', 'method', 'MakeLocalDatabaseDumpShort', NULL, 'core/class/utils.class.php', 'Utils', 'dumpDatabase', 'none,auto,1,auto,10', NULL, 'cron', 90, NULL, NULL, '2021-01-22 07:34:26', NULL, NULL, NULL, NULL, '604800', 1, 0, NULL, 0, 0, 0, '1', NULL, NULL, NULL, 'MakeLocalDatabaseDump', NULL, 0),
(5, '2021-01-22 07:37:59', '2021-01-22 07:34:31', 'method', 'CompressSyslogs', '', 'core/class/utils.class.php', 'Utils', 'compressSyslogs', '', '', 'syslog', 50, '2021-01-22 07:37:59', '2021-01-23 07:34:00', '2021-01-22 07:34:00', NULL, '2021-01-22 07:37:59', '0', 'Archive log files (keeping last SYSLOG_FILE_SAVES=10 files) done.', '86400', 1, 0, 1, 0, 1, 0, '1', NULL, 1, NULL, 'Compress and archive log files. The number of versions to keep is defined into the setup of module. Warning: Main application cron script must be run with same account than your web server to avoid to get log files with different owner than required by web server. Another solution is to set web server Operating System group as the group of directory documents and set GROUP permission \"rws\" on this directory so log files will always have the group and permissions of the web server Operating System group.', NULL, 1),
(6, '2021-01-25 07:32:08', '2021-01-25 07:32:08', 'method', 'SendEmailsReminders', NULL, 'comm/action/class/actioncomm.class.php', 'ActionComm', 'sendEmailsReminder', NULL, NULL, 'agenda', 10, NULL, NULL, '2021-01-25 07:32:08', NULL, NULL, NULL, NULL, '60', 5, 0, NULL, 0, 1, 0, '$conf->agenda->enabled', NULL, NULL, NULL, 'SendEMailsReminder', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_accounting_category`
--

DROP TABLE IF EXISTS `jvm_c_accounting_category`;
CREATE TABLE `jvm_c_accounting_category` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `range_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sens` tinyint(4) NOT NULL DEFAULT '0',
  `category_type` tinyint(4) NOT NULL DEFAULT '0',
  `formula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) DEFAULT '0',
  `fk_country` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_accounting_category`
--

INSERT INTO `jvm_c_accounting_category` (`rowid`, `entity`, `code`, `label`, `range_account`, `sens`, `category_type`, `formula`, `position`, `fk_country`, `active`) VALUES
(1, 1, 'INCOMES', 'Income of products/services', 'Example: 7xxxxx', 0, 0, '', 10, 0, 1),
(2, 1, 'EXPENSES', 'Expenses of products/services', 'Example: 6xxxxx', 0, 0, '', 20, 0, 1),
(3, 1, 'PROFIT', 'Balance', '', 0, 1, 'INCOMES+EXPENSES', 30, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_actioncomm`
--

DROP TABLE IF EXISTS `jvm_c_actioncomm`;
CREATE TABLE `jvm_c_actioncomm` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'system',
  `libelle` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `todo` tinyint(4) DEFAULT NULL,
  `color` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picto` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_actioncomm`
--

INSERT INTO `jvm_c_actioncomm` (`id`, `code`, `type`, `libelle`, `module`, `active`, `todo`, `color`, `picto`, `position`) VALUES
(1, 'AC_TEL', 'system', 'Phone call', NULL, 1, NULL, NULL, NULL, 2),
(2, 'AC_FAX', 'system', 'Send Fax', NULL, 1, NULL, NULL, NULL, 3),
(4, 'AC_EMAIL', 'system', 'Send Email', NULL, 1, NULL, NULL, NULL, 4),
(5, 'AC_RDV', 'system', 'Rendez-vous', NULL, 1, NULL, NULL, NULL, 1),
(6, 'AC_EMAIL_IN', 'system', 'reception Email', NULL, 1, NULL, NULL, NULL, 4),
(11, 'AC_INT', 'system', 'Intervention on site', NULL, 1, NULL, NULL, NULL, 4),
(40, 'AC_OTH_AUTO', 'systemauto', 'Other (automatically inserted events)', NULL, 1, NULL, NULL, NULL, 20),
(50, 'AC_OTH', 'system', 'Other (manually inserted events)', NULL, 1, NULL, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_action_trigger`
--

DROP TABLE IF EXISTS `jvm_c_action_trigger`;
CREATE TABLE `jvm_c_action_trigger` (
  `rowid` int(11) NOT NULL,
  `elementtype` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_action_trigger`
--

INSERT INTO `jvm_c_action_trigger` (`rowid`, `elementtype`, `code`, `label`, `description`, `rang`) VALUES
(1, 'societe', 'COMPANY_CREATE', 'Third party created', 'Executed when a third party is created', 1),
(2, 'societe', 'COMPANY_SENTBYMAIL', 'Mails sent from third party card', 'Executed when you send email from third party card', 1),
(3, 'societe', 'COMPANY_DELETE', 'Third party deleted', 'Executed when you delete third party', 1),
(4, 'propal', 'PROPAL_VALIDATE', 'Customer proposal validated', 'Executed when a commercial proposal is validated', 2),
(5, 'propal', 'PROPAL_SENTBYMAIL', 'Commercial proposal sent by mail', 'Executed when a commercial proposal is sent by mail', 3),
(6, 'propal', 'PROPAL_CLOSE_SIGNED', 'Customer proposal closed signed', 'Executed when a customer proposal is closed signed', 2),
(7, 'propal', 'PROPAL_CLOSE_REFUSED', 'Customer proposal closed refused', 'Executed when a customer proposal is closed refused', 2),
(8, 'propal', 'PROPAL_CLASSIFY_BILLED', 'Customer proposal set billed', 'Executed when a customer proposal is set to billed', 2),
(9, 'propal', 'PROPAL_DELETE', 'Customer proposal deleted', 'Executed when a customer proposal is deleted', 2),
(10, 'commande', 'ORDER_VALIDATE', 'Customer order validate', 'Executed when a customer order is validated', 4),
(11, 'commande', 'ORDER_CLOSE', 'Customer order classify delivered', 'Executed when a customer order is set delivered', 5),
(12, 'commande', 'ORDER_CLASSIFY_BILLED', 'Customer order classify billed', 'Executed when a customer order is set to billed', 5),
(13, 'commande', 'ORDER_CANCEL', 'Customer order canceled', 'Executed when a customer order is canceled', 5),
(14, 'commande', 'ORDER_SENTBYMAIL', 'Customer order sent by mail', 'Executed when a customer order is sent by mail ', 5),
(15, 'commande', 'ORDER_DELETE', 'Customer order deleted', 'Executed when a customer order is deleted', 5),
(16, 'facture', 'BILL_VALIDATE', 'Customer invoice validated', 'Executed when a customer invoice is approved', 6),
(17, 'facture', 'BILL_PAYED', 'Customer invoice payed', 'Executed when a customer invoice is payed', 7),
(18, 'facture', 'BILL_CANCEL', 'Customer invoice canceled', 'Executed when a customer invoice is conceled', 8),
(19, 'facture', 'BILL_SENTBYMAIL', 'Customer invoice sent by mail', 'Executed when a customer invoice is sent by mail', 9),
(20, 'facture', 'BILL_UNVALIDATE', 'Customer invoice unvalidated', 'Executed when a customer invoice status set back to draft', 9),
(21, 'facture', 'BILL_DELETE', 'Customer invoice deleted', 'Executed when a customer invoice is deleted', 9),
(22, 'proposal_supplier', 'PROPOSAL_SUPPLIER_VALIDATE', 'Price request validated', 'Executed when a commercial proposal is validated', 10),
(23, 'proposal_supplier', 'PROPOSAL_SUPPLIER_SENTBYMAIL', 'Price request sent by mail', 'Executed when a commercial proposal is sent by mail', 10),
(24, 'proposal_supplier', 'PROPOSAL_SUPPLIER_CLOSE_SIGNED', 'Price request closed signed', 'Executed when a customer proposal is closed signed', 10),
(25, 'proposal_supplier', 'PROPOSAL_SUPPLIER_CLOSE_REFUSED', 'Price request closed refused', 'Executed when a customer proposal is closed refused', 10),
(26, 'proposal_supplier', 'PROPOSAL_SUPPLIER_DELETE', 'Price request deleted', 'Executed when a customer proposal delete', 10),
(27, 'order_supplier', 'ORDER_SUPPLIER_VALIDATE', 'Supplier order validated', 'Executed when a supplier order is validated', 12),
(28, 'order_supplier', 'ORDER_SUPPLIER_APPROVE', 'Supplier order request approved', 'Executed when a supplier order is approved', 13),
(29, 'order_supplier', 'ORDER_SUPPLIER_SUBMIT', 'Supplier order request submited', 'Executed when a supplier order is approved', 13),
(30, 'order_supplier', 'ORDER_SUPPLIER_RECEIVE', 'Supplier order request received', 'Executed when a supplier order is received', 13),
(31, 'order_supplier', 'ORDER_SUPPLIER_REFUSE', 'Supplier order request refused', 'Executed when a supplier order is refused', 13),
(32, 'order_supplier', 'ORDER_SUPPLIER_SENTBYMAIL', 'Supplier order sent by mail', 'Executed when a supplier order is sent by mail', 14),
(33, 'order_supplier', 'ORDER_SUPPLIER_CLASSIFY_BILLED', 'Supplier order set billed', 'Executed when a supplier order is set as billed', 14),
(34, 'order_supplier', 'ORDER_SUPPLIER_DELETE', 'Supplier order deleted', 'Executed when a supplier order is deleted', 14),
(35, 'invoice_supplier', 'BILL_SUPPLIER_VALIDATE', 'Supplier invoice validated', 'Executed when a supplier invoice is validated', 15),
(36, 'invoice_supplier', 'BILL_SUPPLIER_UNVALIDATE', 'Supplier invoice unvalidated', 'Executed when a supplier invoice status is set back to draft', 15),
(37, 'invoice_supplier', 'BILL_SUPPLIER_PAYED', 'Supplier invoice payed', 'Executed when a supplier invoice is payed', 16),
(38, 'invoice_supplier', 'BILL_SUPPLIER_SENTBYMAIL', 'Supplier invoice sent by mail', 'Executed when a supplier invoice is sent by mail', 17),
(39, 'invoice_supplier', 'BILL_SUPPLIER_CANCELED', 'Supplier invoice cancelled', 'Executed when a supplier invoice is cancelled', 17),
(40, 'invoice_supplier', 'BILL_SUPPLIER_DELETE', 'Supplier invoice deleted', 'Executed when a supplier invoice is deleted', 17),
(41, 'contrat', 'CONTRACT_VALIDATE', 'Contract validated', 'Executed when a contract is validated', 18),
(42, 'contrat', 'CONTRACT_SENTBYMAIL', 'Contract sent by mail', 'Executed when a contract is sent by mail', 18),
(43, 'contrat', 'CONTRACT_DELETE', 'Contract deleted', 'Executed when a contract is deleted', 18),
(44, 'shipping', 'SHIPPING_VALIDATE', 'Shipping validated', 'Executed when a shipping is validated', 20),
(45, 'shipping', 'SHIPPING_SENTBYMAIL', 'Shipping sent by mail', 'Executed when a shipping is sent by mail', 21),
(46, 'shipping', 'SHIPPING_DELETE', 'Shipping sent is deleted', 'Executed when a shipping is deleted', 21),
(47, 'reception', 'RECEPTION_VALIDATE', 'Reception validated', 'Executed when a reception is validated', 22),
(48, 'reception', 'RECEPTION_SENTBYMAIL', 'Reception sent by mail', 'Executed when a reception is sent by mail', 22),
(49, 'member', 'MEMBER_VALIDATE', 'Member validated', 'Executed when a member is validated', 22),
(50, 'member', 'MEMBER_SENTBYMAIL', 'Mails sent from member card', 'Executed when you send email from member card', 23),
(51, 'member', 'MEMBER_SUBSCRIPTION_CREATE', 'Member subscribtion recorded', 'Executed when a member subscribtion is deleted', 24),
(52, 'member', 'MEMBER_SUBSCRIPTION_MODIFY', 'Member subscribtion modified', 'Executed when a member subscribtion is modified', 24),
(53, 'member', 'MEMBER_SUBSCRIPTION_DELETE', 'Member subscribtion deleted', 'Executed when a member subscribtion is deleted', 24),
(54, 'member', 'MEMBER_RESILIATE', 'Member resiliated', 'Executed when a member is resiliated', 25),
(55, 'member', 'MEMBER_DELETE', 'Member deleted', 'Executed when a member is deleted', 26),
(56, 'ficheinter', 'FICHINTER_VALIDATE', 'Intervention validated', 'Executed when a intervention is validated', 30),
(57, 'ficheinter', 'FICHINTER_CLASSIFY_BILLED', 'Intervention set billed', 'Executed when a intervention is set to billed (when option FICHINTER_CLASSIFY_BILLED is set)', 32),
(58, 'ficheinter', 'FICHINTER_CLASSIFY_UNBILLED', 'Intervention set unbilled', 'Executed when a intervention is set to unbilled (when option FICHINTER_CLASSIFY_BILLED is set)', 33),
(59, 'ficheinter', 'FICHINTER_REOPEN', 'Intervention opened', 'Executed when a intervention is re-opened', 34),
(60, 'ficheinter', 'FICHINTER_SENTBYMAIL', 'Intervention sent by mail', 'Executed when a intervention is sent by mail', 35),
(61, 'ficheinter', 'FICHINTER_DELETE', 'Intervention is deleted', 'Executed when a intervention is deleted', 35),
(62, 'product', 'PRODUCT_CREATE', 'Product or service created', 'Executed when a product or sevice is created', 40),
(63, 'product', 'PRODUCT_DELETE', 'Product or service deleted', 'Executed when a product or sevice is deleted', 42),
(64, 'expensereport', 'EXPENSE_REPORT_CREATE', 'Expense report created', 'Executed when an expense report is created', 201),
(65, 'expensereport', 'EXPENSE_REPORT_VALIDATE', 'Expense report validated', 'Executed when an expense report is validated', 202),
(66, 'expensereport', 'EXPENSE_REPORT_APPROVE', 'Expense report approved', 'Executed when an expense report is approved', 203),
(67, 'expensereport', 'EXPENSE_REPORT_PAYED', 'Expense report billed', 'Executed when an expense report is set as billed', 204),
(68, 'expensereport', 'EXPENSE_DELETE', 'Expense report deleted', 'Executed when an expense report is deleted', 205),
(69, 'expensereport', 'HOLIDAY_VALIDATE', 'Expense report validated', 'Executed when an expense report is validated', 211),
(70, 'expensereport', 'HOLIDAY_APPROVE', 'Expense report approved', 'Executed when an expense report is approved', 212),
(71, 'project', 'PROJECT_VALIDATE', 'Project validation', 'Executed when a project is validated', 141),
(72, 'project', 'PROJECT_DELETE', 'Project deleted', 'Executed when a project is deleted', 143),
(73, 'ticket', 'TICKET_CREATE', 'Ticket created', 'Executed when a ticket is created', 161),
(74, 'ticket', 'TICKET_MODIFY', 'Ticket modified', 'Executed when a ticket is modified', 163),
(75, 'ticket', 'TICKET_ASSIGNED', 'Ticket assigned', 'Executed when a ticket is modified', 164),
(76, 'ticket', 'TICKET_CLOSE', 'Ticket closed', 'Executed when a ticket is closed', 165),
(77, 'ticket', 'TICKET_SENTBYMAIL', 'Ticket message sent by email', 'Executed when a message is sent from the ticket record', 166),
(78, 'ticket', 'TICKET_DELETE', 'Ticket deleted', 'Executed when a ticket is deleted', 167),
(79, 'user', 'USER_SENTBYMAIL', 'Email sent', 'Executed when an email is sent from user card', 300),
(80, 'product', 'PRODUCT_MODIFY', 'Product or service modified', 'Executed when a product or sevice is modified', 41),
(81, 'member', 'MEMBER_MODIFY', 'Member modified', 'Executed when a member is modified', 23),
(82, 'ficheinter', 'FICHINTER_MODIFY', 'Intervention modified', 'Executed when a intervention is modified', 19),
(83, 'project', 'PROJECT_CREATE', 'Project creation', 'Executed when a project is created', 140),
(84, 'project', 'PROJECT_MODIFY', 'Project modified', 'Executed when a project is modified', 142),
(85, 'bom', 'BOM_VALIDATE', 'BOM validated', 'Executed when a BOM is validated', 650),
(86, 'bom', 'BOM_UNVALIDATE', 'BOM unvalidated', 'Executed when a BOM is unvalidated', 651),
(87, 'bom', 'BOM_CLOSE', 'BOM disabled', 'Executed when a BOM is disabled', 652),
(88, 'bom', 'BOM_REOPEN', 'BOM reopen', 'Executed when a BOM is re-open', 653),
(89, 'bom', 'BOM_DELETE', 'BOM deleted', 'Executed when a BOM deleted', 654),
(90, 'mrp', 'MRP_MO_VALIDATE', 'MO validated', 'Executed when a MO is validated', 660),
(91, 'mrp', 'MRP_MO_PRODUCED', 'MO produced', 'Executed when a MO is produced', 661),
(92, 'mrp', 'MRP_MO_DELETE', 'MO deleted', 'Executed when a MO is deleted', 662),
(93, 'mrp', 'MRP_MO_CANCEL', 'MO canceled', 'Executed when a MO is canceled', 663),
(94, 'contact', 'CONTACT_CREATE', 'Contact address created', 'Executed when a contact is created', 50),
(95, 'contact', 'CONTACT_SENTBYMAIL', 'Mails sent from third party card', 'Executed when you send email from contact address record', 51),
(96, 'contact', 'CONTACT_DELETE', 'Contact address deleted', 'Executed when a contact is deleted', 52),
(97, 'recruitment', 'RECRUITMENTJOBPOSITION_CREATE', 'Job created', 'Executed when a job is created', 7500),
(98, 'recruitment', 'RECRUITMENTJOBPOSITION_MODIFY', 'Job modified', 'Executed when a job is modified', 7502),
(99, 'recruitment', 'RECRUITMENTJOBPOSITION_SENTBYMAIL', 'Mails sent from job record', 'Executed when you send email from job record', 7504),
(100, 'recruitment', 'RECRUITMENTJOBPOSITION_DELETE', 'Job deleted', 'Executed when a job is deleted', 7506),
(101, 'recruitment', 'RECRUITMENTCANDIDATURE_CREATE', 'Candidature created', 'Executed when a candidature is created', 7510),
(102, 'recruitment', 'RECRUITMENTCANDIDATURE_MODIFY', 'Candidature modified', 'Executed when a candidature is modified', 7512),
(103, 'recruitment', 'RECRUITMENTCANDIDATURE_SENTBYMAIL', 'Mails sent from candidature record', 'Executed when you send email from candidature record', 7514),
(104, 'recruitment', 'RECRUITMENTCANDIDATURE_DELETE', 'Candidature deleted', 'Executed when a candidature is deleted', 7516),
(105, 'project', 'TASK_CREATE', 'Task created', 'Executed when a project task is created', 150),
(106, 'project', 'TASK_MODIFY', 'Task modified', 'Executed when a project task is modified', 151),
(107, 'project', 'TASK_DELETE', 'Task deleted', 'Executed when a project task is deleted', 152);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_availability`
--

DROP TABLE IF EXISTS `jvm_c_availability`;
CREATE TABLE `jvm_c_availability` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_availability`
--

INSERT INTO `jvm_c_availability` (`rowid`, `code`, `label`, `active`) VALUES
(1, 'AV_NOW', 'Immediate', 1),
(2, 'AV_1W', '1 week', 1),
(3, 'AV_2W', '2 weeks', 1),
(4, 'AV_3W', '3 weeks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_barcode_type`
--

DROP TABLE IF EXISTS `jvm_c_barcode_type`;
CREATE TABLE `jvm_c_barcode_type` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `coder` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `example` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_barcode_type`
--

INSERT INTO `jvm_c_barcode_type` (`rowid`, `code`, `entity`, `libelle`, `coder`, `example`) VALUES
(1, 'EAN8', 1, 'EAN8', '0', '1234567'),
(2, 'EAN13', 1, 'EAN13', '0', '123456789012'),
(3, 'UPC', 1, 'UPC', '0', '123456789012'),
(4, 'ISBN', 1, 'ISBN', '0', '123456789'),
(5, 'C39', 1, 'Code 39', '0', '1234567890'),
(6, 'C128', 1, 'Code 128', 'tcpdfbarcode', 'ABCD1234567890'),
(7, 'DATAMATRIX', 1, 'Datamatrix', '0', '1234567xyz'),
(8, 'QRCODE', 1, 'Qr Code', 'tcpdfbarcode', 'www.dolibarr.org');

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_chargesociales`
--

DROP TABLE IF EXISTS `jvm_c_chargesociales`;
CREATE TABLE `jvm_c_chargesociales` (
  `id` int(11) NOT NULL,
  `libelle` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deductible` smallint(6) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `accountancy_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_pays` int(11) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_chargesociales`
--

INSERT INTO `jvm_c_chargesociales` (`id`, `libelle`, `deductible`, `active`, `code`, `accountancy_code`, `fk_pays`, `module`) VALUES
(1, 'Allocations familiales', 1, 1, 'TAXFAM', NULL, 1, NULL),
(2, 'CSG Deductible', 1, 1, 'TAXCSGD', NULL, 1, NULL),
(3, 'CSG/CRDS NON Deductible', 0, 1, 'TAXCSGND', NULL, 1, NULL),
(10, 'Taxe apprentissage', 0, 1, 'TAXAPP', NULL, 1, NULL),
(11, 'Taxe professionnelle', 0, 1, 'TAXPRO', NULL, 1, NULL),
(12, 'Cotisation fonciere des entreprises', 0, 1, 'TAXCFE', NULL, 1, NULL),
(13, 'Cotisation sur la valeur ajoutee des entreprises', 0, 1, 'TAXCVAE', NULL, 1, NULL),
(20, 'Impots locaux/fonciers', 0, 1, 'TAXFON', NULL, 1, NULL),
(25, 'Impots revenus', 0, 1, 'TAXREV', NULL, 1, NULL),
(30, 'Assurance Sante', 0, 1, 'TAXSECU', NULL, 1, NULL),
(40, 'Mutuelle', 0, 1, 'TAXMUT', NULL, 1, NULL),
(50, 'Assurance vieillesse', 0, 1, 'TAXRET', NULL, 1, NULL),
(60, 'Assurance Chomage', 0, 1, 'TAXCHOM', NULL, 1, NULL),
(201, 'ONSS', 1, 1, 'TAXBEONSS', NULL, 2, NULL),
(210, 'Precompte professionnel', 1, 1, 'TAXBEPREPRO', NULL, 2, NULL),
(220, 'Prime existence', 1, 1, 'TAXBEPRIEXI', NULL, 2, NULL),
(230, 'Precompte immobilier', 1, 1, 'TAXBEPREIMMO', NULL, 2, NULL),
(4101, 'Krankenversicherung', 1, 1, 'TAXATKV', NULL, 41, NULL),
(4102, 'Unfallversicherung', 1, 1, 'TAXATUV', NULL, 41, NULL),
(4103, 'Pensionsversicherung', 1, 1, 'TAXATPV', NULL, 41, NULL),
(4104, 'Arbeitslosenversicherung', 1, 1, 'TAXATAV', NULL, 41, NULL),
(4105, 'Insolvenzentgeltsicherungsfond', 1, 1, 'TAXATIESG', NULL, 41, NULL),
(4106, 'Wohnbauförderung', 1, 1, 'TAXATWF', NULL, 41, NULL),
(4107, 'Arbeiterkammerumlage', 1, 1, 'TAXATAK', NULL, 41, NULL),
(4108, 'Mitarbeitervorsorgekasse', 1, 1, 'TAXATMVK', NULL, 41, NULL),
(4109, 'Familienlastenausgleichsfond', 1, 1, 'TAXATFLAF', NULL, 41, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_cities`
--

DROP TABLE IF EXISTS `jvm_c_cities`;
CREATE TABLE `jvm_c_cities` (
  `rowid` int(11) NOT NULL,
  `code_city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fk_state` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_cities`
--

INSERT INTO `jvm_c_cities` (`rowid`, `code_city`, `fk_state`, `nom`, `active`) VALUES
(1, 'JP', 1015, 'Jaipur', 1),
(2, 'AWR', 1015, 'Alwar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_civility`
--

DROP TABLE IF EXISTS `jvm_c_civility`;
CREATE TABLE `jvm_c_civility` (
  `rowid` int(11) NOT NULL,
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_civility`
--

INSERT INTO `jvm_c_civility` (`rowid`, `code`, `label`, `active`, `module`) VALUES
(1, 'MME', 'Madame', 1, NULL),
(3, 'MR', 'Monsieur', 1, NULL),
(5, 'MLE', 'Mademoiselle', 1, NULL),
(7, 'MTRE', 'Maître', 1, NULL),
(8, 'DR', 'Docteur', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_country`
--

DROP TABLE IF EXISTS `jvm_c_country`;
CREATE TABLE `jvm_c_country` (
  `rowid` int(11) NOT NULL,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `code_iso` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `eec` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `favorite` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_country`
--

INSERT INTO `jvm_c_country` (`rowid`, `code`, `code_iso`, `label`, `eec`, `active`, `favorite`) VALUES
(0, '', NULL, '-', NULL, 1, 1),
(117, 'IN', 'IND', 'India', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_currencies`
--

DROP TABLE IF EXISTS `jvm_c_currencies`;
CREATE TABLE `jvm_c_currencies` (
  `code_iso` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `unicode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_currencies`
--

INSERT INTO `jvm_c_currencies` (`code_iso`, `label`, `unicode`, `active`) VALUES
('INR', 'India Rupee', '[8377]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_departements`
--

DROP TABLE IF EXISTS `jvm_c_departements`;
CREATE TABLE `jvm_c_departements` (
  `rowid` int(11) NOT NULL,
  `code_departement` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `fk_region` int(11) DEFAULT NULL,
  `cheflieu` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tncc` int(11) DEFAULT NULL,
  `ncc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_departements`
--

INSERT INTO `jvm_c_departements` (`rowid`, `code_departement`, `fk_region`, `cheflieu`, `tncc`, `ncc`, `nom`, `active`) VALUES
(1, '0', 0, '0', 0, '-', '-', 1),
(987, 'AN', 11701, NULL, 0, 'AN', 'Andaman & Nicobar', 1),
(988, 'AP', 11701, NULL, 0, 'AP', 'Andhra Pradesh', 1),
(989, 'AR', 11701, NULL, 0, 'AR', 'Arunachal Pradesh', 1),
(990, 'AS', 11701, NULL, 0, 'AS', 'Assam', 1),
(991, 'BR', 11701, NULL, 0, 'BR', 'Bihar', 1),
(992, 'CG', 11701, NULL, 0, 'CG', 'Chattisgarh', 1),
(993, 'CH', 11701, NULL, 0, 'CH', 'Chandigarh', 1),
(994, 'DD', 11701, NULL, 0, 'DD', 'Daman & Diu', 1),
(995, 'DL', 11701, NULL, 0, 'DL', 'Delhi', 1),
(996, 'DN', 11701, NULL, 0, 'DN', 'Dadra and Nagar Haveli', 1),
(997, 'GA', 11701, NULL, 0, 'GA', 'Goa', 1),
(998, 'GJ', 11701, NULL, 0, 'GJ', 'Gujarat', 1),
(999, 'HP', 11701, NULL, 0, 'HP', 'Himachal Pradesh', 1),
(1000, 'HR', 11701, NULL, 0, 'HR', 'Haryana', 1),
(1001, 'JH', 11701, NULL, 0, 'JH', 'Jharkhand', 1),
(1002, 'JK', 11701, NULL, 0, 'JK', 'Jammu & Kashmir', 1),
(1003, 'KA', 11701, NULL, 0, 'KA', 'Karnataka', 1),
(1004, 'KL', 11701, NULL, 0, 'KL', 'Kerala', 1),
(1005, 'LD', 11701, NULL, 0, 'LD', 'Lakshadweep', 1),
(1006, 'MH', 11701, NULL, 0, 'MH', 'Maharashtra', 1),
(1007, 'ML', 11701, NULL, 0, 'ML', 'Meghalaya', 1),
(1008, 'MN', 11701, NULL, 0, 'MN', 'Manipur', 1),
(1009, 'MP', 11701, NULL, 0, 'MP', 'Madhya Pradesh', 1),
(1010, 'MZ', 11701, NULL, 0, 'MZ', 'Mizoram', 1),
(1011, 'NL', 11701, NULL, 0, 'NL', 'Nagaland', 1),
(1012, 'OR', 11701, NULL, 0, 'OR', 'Orissa', 1),
(1013, 'PB', 11701, NULL, 0, 'PB', 'Punjab', 1),
(1014, 'PY', 11701, NULL, 0, 'PY', 'Puducherry', 1),
(1015, 'RJ', 11701, NULL, 0, 'RJ', 'Rajasthan', 1),
(1016, 'SK', 11701, NULL, 0, 'SK', 'Sikkim', 1),
(1017, 'TE', 11701, NULL, 0, 'TE', 'Telangana', 1),
(1018, 'TN', 11701, NULL, 0, 'TN', 'Tamil Nadu', 1),
(1019, 'TR', 11701, NULL, 0, 'TR', 'Tripura', 1),
(1020, 'UL', 11701, NULL, 0, 'UL', 'Uttarakhand', 1),
(1021, 'UP', 11701, NULL, 0, 'UP', 'Uttar Pradesh', 1),
(1022, 'WB', 11701, NULL, 0, 'WB', 'West Bengal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ecotaxe`
--

DROP TABLE IF EXISTS `jvm_c_ecotaxe`;
CREATE TABLE `jvm_c_ecotaxe` (
  `rowid` int(11) NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `organization` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_pays` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_ecotaxe`
--

INSERT INTO `jvm_c_ecotaxe` (`rowid`, `code`, `label`, `price`, `organization`, `fk_pays`, `active`) VALUES
(1, '25040', 'PETIT APPAREILS MENAGERS', 0.25000000, 'Eco-systèmes', 1, 1),
(2, '25050', 'TRES PETIT APPAREILS MENAGERS', 0.08000000, 'Eco-systèmes', 1, 1),
(3, '32070', 'ECRAN POIDS < 5 KG', 2.08000000, 'Eco-systèmes', 1, 1),
(4, '32080', 'ECRAN POIDS > 5 KG', 1.25000000, 'Eco-systèmes', 1, 1),
(5, '32051', 'ORDINATEUR PORTABLE', 0.42000000, 'Eco-systèmes', 1, 1),
(6, '32061', 'TABLETTE INFORMATIQUE', 0.84000000, 'Eco-systèmes', 1, 1),
(7, '36011', 'ORDINATEUR FIXE (UC)', 1.15000000, 'Eco-systèmes', 1, 1),
(8, '36021', 'IMPRIMANTES', 0.83000000, 'Eco-systèmes', 1, 1),
(9, '36030', 'IT (INFORMATIQUE ET TELECOMS)', 0.83000000, 'Eco-systèmes', 1, 1),
(10, '36040', 'PETIT IT (CLAVIERS / SOURIS)', 0.08000000, 'Eco-systèmes', 1, 1),
(11, '36050', 'TELEPHONIE MOBILE', 0.02000000, 'Eco-systèmes', 1, 1),
(12, '36060', 'CONNECTIQUE CABLES', 0.02000000, 'Eco-systèmes', 1, 1),
(13, '45010', 'GROS MATERIEL GRAND PUBLIC (TELEAGRANDISSEURS)', 1.67000000, 'Eco-systèmes', 1, 1),
(14, '45020', 'MOYEN MATERIEL GRAND PUBLIC (LOUPES ELECTRONIQUES)', 0.42000000, 'Eco-systèmes', 1, 1),
(15, '45030', 'PETIT MATERIEL GRAND PUBLIC (VIE QUOTIDIENNE)', 0.08000000, 'Eco-systèmes', 1, 1),
(16, '75030', 'JOUETS < 0,5 KG', 0.08000000, 'Eco-systèmes', 1, 1),
(17, '75040', 'JOUETS ENTRE 0,5 KG ET 10 KG', 0.17000000, 'Eco-systèmes', 1, 1),
(18, '74050', 'JOUETS > 10 KG', 1.67000000, 'Eco-systèmes', 1, 1),
(19, '85010', 'EQUIPEMENT MEDICAL < 0,5 KG', 0.08000000, 'Eco-systèmes', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_effectif`
--

DROP TABLE IF EXISTS `jvm_c_effectif`;
CREATE TABLE `jvm_c_effectif` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_effectif`
--

INSERT INTO `jvm_c_effectif` (`id`, `code`, `libelle`, `active`, `module`) VALUES
(0, 'EF0', '-', 1, NULL),
(1, 'EF1-5', '1 - 5', 1, NULL),
(2, 'EF6-10', '6 - 10', 1, NULL),
(3, 'EF11-50', '11 - 50', 1, NULL),
(4, 'EF51-100', '51 - 100', 1, NULL),
(5, 'EF100-500', '100 - 500', 1, NULL),
(6, 'EF500-', '> 500', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_email_senderprofile`
--

DROP TABLE IF EXISTS `jvm_c_email_senderprofile`;
CREATE TABLE `jvm_c_email_senderprofile` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `private` smallint(6) NOT NULL DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signature` text COLLATE utf8_unicode_ci,
  `position` smallint(6) DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_email_templates`
--

DROP TABLE IF EXISTS `jvm_c_email_templates`;
CREATE TABLE `jvm_c_email_templates` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_template` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(6) COLLATE utf8_unicode_ci DEFAULT '',
  `private` smallint(6) NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  `enabled` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `topic` text COLLATE utf8_unicode_ci,
  `joinfiles` text COLLATE utf8_unicode_ci,
  `content` mediumtext COLLATE utf8_unicode_ci,
  `content_lines` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_email_templates`
--

INSERT INTO `jvm_c_email_templates` (`rowid`, `entity`, `module`, `type_template`, `lang`, `private`, `fk_user`, `datec`, `tms`, `label`, `position`, `enabled`, `active`, `topic`, `joinfiles`, `content`, `content_lines`) VALUES
(1, 0, 'banque', 'thirdparty', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(YourSEPAMandate)', 1, '$conf->societe->enabled && $conf->banque->enabled && $conf->prelevement->enabled', 0, '__(YourSEPAMandate)__', NULL, '__(Hello)__,<br><br>\n\n__(FindYourSEPAMandate)__ :<br>\n__MYCOMPANY_NAME__<br>\n__MYCOMPANY_FULLADDRESS__<br><br>\n__(Sincerely)__<br>\n__USER_SIGNATURE__', NULL),
(2, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingEmailOnAutoSubscription)', 10, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(YourMembershipRequestWasReceived)__', '0', '__(Hello)__ __MEMBER_FULLNAME__,<br><br>\n\n__(ThisIsContentOfYourMembershipRequestWasReceived)__<br>\n<br>__ONLINE_PAYMENT_TEXT_AND_URL__<br>\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(3, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingEmailOnMemberValidation)', 20, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(YourMembershipWasValidated)__', '0', '__(Hello)__ __MEMBER_FULLNAME__,<br><br>\n\n__(ThisIsContentOfYourMembershipWasValidated)__<br>__(FirstName)__ : __MEMBER_FIRSTNAME__<br>__(LastName)__ : __MEMBER_LASTNAME__<br>__(ID)__ : __MEMBER_ID__<br>\n<br>__ONLINE_PAYMENT_TEXT_AND_URL__<br>\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(4, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingEmailOnNewSubscription)', 30, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(YourSubscriptionWasRecorded)__', '1', '__(Hello)__ __MEMBER_FULLNAME__,<br><br>\n\n__(ThisIsContentOfYourSubscriptionWasRecorded)__<br>\n\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(5, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingReminderForExpiredSubscription)', 40, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(SubscriptionReminderEmail)__', '0', '__(Hello)__ __MEMBER_FULLNAME__,<br><br>\n\n__(ThisIsContentOfSubscriptionReminderEmail)__<br>\n<br>__ONLINE_PAYMENT_TEXT_AND_URL__<br>\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(6, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingEmailOnCancelation)', 50, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(YourMembershipWasCanceled)__', '0', '__(Hello)__ __MEMBER_FULLNAME__,<br><br>\n\n__(YourMembershipWasCanceled)__<br>\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(7, 0, 'adherent', 'member', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(SendingAnEMailToMember)', 60, '$conf->adherent->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(CardContent)__', '0', '__(Hello)__,<br><br>\n\n__(ThisIsContentOfYourCard)__<br>\n__(ID)__ : __ID__<br>\n__(Civiliyty)__ : __MEMBER_CIVILITY__<br>\n__(Firstname)__ : __MEMBER_FIRSTNAME__<br>\n__(Lastname)__ : __MEMBER_LASTNAME__<br>\n__(Fullname)__ : __MEMBER_FULLNAME__<br>\n__(Company)__ : __MEMBER_COMPANY__<br>\n__(Address)__ : __MEMBER_ADDRESS__<br>\n__(Zip)__ : __MEMBER_ZIP__<br>\n__(Town)__ : __MEMBER_TOWN__<br>\n__(Country)__ : __MEMBER_COUNTRY__<br>\n__(Email)__ : __MEMBER_EMAIL__<br>\n__(Birthday)__ : __MEMBER_BIRTH__<br>\n__(Photo)__ : __MEMBER_PHOTO__<br>\n__(Login)__ : __MEMBER_LOGIN__<br>\n__(Password)__ : __MEMBER_PASSWORD__<br>\n__(Phone)__ : __MEMBER_PHONE__<br>\n__(PhonePerso)__ : __MEMBER_PHONEPRO__<br>\n__(PhoneMobile)__ : __MEMBER_PHONEMOBILE__<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL),
(8, 0, 'recruitment', 'recruitmentcandidature_send', '', 0, NULL, NULL, '2021-01-22 06:42:00', '(AnswerCandidature)', 100, '$conf->recruitment->enabled', 1, '[__[MAIN_INFO_SOCIETE_NOM]__] __(YourCandidature)__', '0', '__(Hello)__ __CANDIDATE_FULLNAME__,<br><br>\n\n__(YourCandidatureAnswerMessage)__<br>__ONLINE_INTERVIEW_SCHEDULER_TEXT_AND_URL__\n<br><br>\n__(Sincerely)__<br>__USER_SIGNATURE__', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_exp_tax_cat`
--

DROP TABLE IF EXISTS `jvm_c_exp_tax_cat`;
CREATE TABLE `jvm_c_exp_tax_cat` (
  `rowid` int(11) NOT NULL,
  `label` varchar(48) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_exp_tax_cat`
--

INSERT INTO `jvm_c_exp_tax_cat` (`rowid`, `label`, `entity`, `active`) VALUES
(1, 'ExpAutoCat', 1, 0),
(2, 'ExpCycloCat', 1, 0),
(3, 'ExpMotoCat', 1, 0),
(4, 'ExpAuto3CV', 1, 1),
(5, 'ExpAuto4CV', 1, 1),
(6, 'ExpAuto5CV', 1, 1),
(7, 'ExpAuto6CV', 1, 1),
(8, 'ExpAuto7CV', 1, 1),
(9, 'ExpAuto8CV', 1, 1),
(10, 'ExpAuto9CV', 1, 0),
(11, 'ExpAuto10CV', 1, 0),
(12, 'ExpAuto11CV', 1, 0),
(13, 'ExpAuto12CV', 1, 0),
(14, 'ExpAuto3PCV', 1, 0),
(15, 'ExpAuto4PCV', 1, 0),
(16, 'ExpAuto5PCV', 1, 0),
(17, 'ExpAuto6PCV', 1, 0),
(18, 'ExpAuto7PCV', 1, 0),
(19, 'ExpAuto8PCV', 1, 0),
(20, 'ExpAuto9PCV', 1, 0),
(21, 'ExpAuto10PCV', 1, 0),
(22, 'ExpAuto11PCV', 1, 0),
(23, 'ExpAuto12PCV', 1, 0),
(24, 'ExpAuto13PCV', 1, 0),
(25, 'ExpCyclo', 1, 0),
(26, 'ExpMoto12CV', 1, 0),
(27, 'ExpMoto345CV', 1, 0),
(28, 'ExpMoto5PCV', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_exp_tax_range`
--

DROP TABLE IF EXISTS `jvm_c_exp_tax_range`;
CREATE TABLE `jvm_c_exp_tax_range` (
  `rowid` int(11) NOT NULL,
  `fk_c_exp_tax_cat` int(11) NOT NULL DEFAULT '1',
  `range_ik` double NOT NULL DEFAULT '0',
  `entity` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_exp_tax_range`
--

INSERT INTO `jvm_c_exp_tax_range` (`rowid`, `fk_c_exp_tax_cat`, `range_ik`, `entity`, `active`) VALUES
(1, 4, 0, 1, 1),
(2, 4, 5000, 1, 1),
(3, 4, 20000, 1, 1),
(4, 5, 0, 1, 1),
(5, 5, 5000, 1, 1),
(6, 5, 20000, 1, 1),
(7, 6, 0, 1, 1),
(8, 6, 5000, 1, 1),
(9, 6, 20000, 1, 1),
(10, 7, 0, 1, 1),
(11, 7, 5000, 1, 1),
(12, 7, 20000, 1, 1),
(13, 8, 0, 1, 1),
(14, 8, 5000, 1, 1),
(15, 8, 20000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_field_list`
--

DROP TABLE IF EXISTS `jvm_c_field_list`;
CREATE TABLE `jvm_c_field_list` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `element` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `align` varchar(6) COLLATE utf8_unicode_ci DEFAULT 'left',
  `sort` tinyint(4) NOT NULL DEFAULT '1',
  `search` tinyint(4) NOT NULL DEFAULT '0',
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `enabled` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_format_cards`
--

DROP TABLE IF EXISTS `jvm_c_format_cards`;
CREATE TABLE `jvm_c_format_cards` (
  `rowid` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `paper_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `orientation` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `metric` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `leftmargin` double(24,8) NOT NULL,
  `topmargin` double(24,8) NOT NULL,
  `nx` int(11) NOT NULL,
  `ny` int(11) NOT NULL,
  `spacex` double(24,8) NOT NULL,
  `spacey` double(24,8) NOT NULL,
  `width` double(24,8) NOT NULL,
  `height` double(24,8) NOT NULL,
  `font_size` int(11) NOT NULL,
  `custom_x` double(24,8) NOT NULL,
  `custom_y` double(24,8) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_format_cards`
--

INSERT INTO `jvm_c_format_cards` (`rowid`, `code`, `name`, `paper_size`, `orientation`, `metric`, `leftmargin`, `topmargin`, `nx`, `ny`, `spacex`, `spacey`, `width`, `height`, `font_size`, `custom_x`, `custom_y`, `active`) VALUES
(1, '5160', 'Avery-5160, WL-875WX', 'letter', 'P', 'mm', 5.58165000, 12.70000000, 3, 10, 3.55600000, 0.00000000, 65.87490000, 25.40000000, 7, 0.00000000, 0.00000000, 1),
(2, '5161', 'Avery-5161, WL-75WX', 'letter', 'P', 'mm', 4.44500000, 12.70000000, 2, 10, 3.96800000, 0.00000000, 101.60000000, 25.40000000, 7, 0.00000000, 0.00000000, 1),
(3, '5162', 'Avery-5162, WL-100WX', 'letter', 'P', 'mm', 3.87350000, 22.35200000, 2, 7, 4.95400000, 0.00000000, 101.60000000, 33.78100000, 8, 0.00000000, 0.00000000, 1),
(4, '5163', 'Avery-5163, WL-125WX', 'letter', 'P', 'mm', 4.57200000, 12.70000000, 2, 5, 3.55600000, 0.00000000, 101.60000000, 50.80000000, 10, 0.00000000, 0.00000000, 1),
(5, '5164', '5164 (Letter)', 'letter', 'P', 'in', 0.14800000, 0.50000000, 2, 3, 0.20310000, 0.00000000, 4.00000000, 3.33000000, 12, 0.00000000, 0.00000000, 0),
(6, '8600', 'Avery-8600', 'letter', 'P', 'mm', 7.10000000, 19.00000000, 3, 10, 9.50000000, 3.10000000, 66.60000000, 25.40000000, 7, 0.00000000, 0.00000000, 1),
(7, '99012', 'DYMO 99012 89*36mm', 'custom', 'L', 'mm', 1.00000000, 1.00000000, 1, 1, 0.00000000, 0.00000000, 36.00000000, 89.00000000, 10, 36.00000000, 89.00000000, 1),
(8, '99014', 'DYMO 99014 101*54mm', 'custom', 'L', 'mm', 1.00000000, 1.00000000, 1, 1, 0.00000000, 0.00000000, 54.00000000, 101.00000000, 10, 54.00000000, 101.00000000, 1),
(9, 'AVERYC32010', 'Avery-C32010', 'A4', 'P', 'mm', 15.00000000, 13.00000000, 2, 5, 10.00000000, 0.00000000, 85.00000000, 54.00000000, 10, 0.00000000, 0.00000000, 1),
(10, 'CARD', 'Dolibarr Business cards', 'A4', 'P', 'mm', 15.00000000, 15.00000000, 2, 5, 0.00000000, 0.00000000, 85.00000000, 54.00000000, 10, 0.00000000, 0.00000000, 1),
(11, 'L7163', 'Avery-L7163', 'A4', 'P', 'mm', 5.00000000, 15.00000000, 2, 7, 2.50000000, 0.00000000, 99.10000000, 38.10000000, 8, 0.00000000, 0.00000000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_forme_juridique`
--

DROP TABLE IF EXISTS `jvm_c_forme_juridique`;
CREATE TABLE `jvm_c_forme_juridique` (
  `rowid` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isvatexempted` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_forme_juridique`
--

INSERT INTO `jvm_c_forme_juridique` (`rowid`, `code`, `fk_pays`, `libelle`, `isvatexempted`, `active`, `module`, `position`) VALUES
(1, 0, 0, '-', 0, 1, NULL, 0),
(2, 2301, 23, 'Monotributista', 0, 1, NULL, 0),
(3, 2302, 23, 'Sociedad Civil', 0, 1, NULL, 0),
(4, 2303, 23, 'Sociedades Comerciales', 0, 1, NULL, 0),
(5, 2304, 23, 'Sociedades de Hecho', 0, 1, NULL, 0),
(6, 2305, 23, 'Sociedades Irregulares', 0, 1, NULL, 0),
(7, 2306, 23, 'Sociedad Colectiva', 0, 1, NULL, 0),
(8, 2307, 23, 'Sociedad en Comandita Simple', 0, 1, NULL, 0),
(9, 2308, 23, 'Sociedad de Capital e Industria', 0, 1, NULL, 0),
(10, 2309, 23, 'Sociedad Accidental o en participación', 0, 1, NULL, 0),
(11, 2310, 23, 'Sociedad de Responsabilidad Limitada', 0, 1, NULL, 0),
(12, 2311, 23, 'Sociedad Anónima', 0, 1, NULL, 0),
(13, 2312, 23, 'Sociedad Anónima con Participación Estatal Mayoritaria', 0, 1, NULL, 0),
(14, 2313, 23, 'Sociedad en Comandita por Acciones (arts. 315 a 324, LSC)', 0, 1, NULL, 0),
(15, 4100, 41, 'GmbH - Gesellschaft mit beschränkter Haftung', 0, 1, NULL, 0),
(16, 4101, 41, 'GesmbH - Gesellschaft mit beschränkter Haftung', 0, 1, NULL, 0),
(17, 4102, 41, 'AG - Aktiengesellschaft', 0, 1, NULL, 0),
(18, 4103, 41, 'EWIV - Europäische wirtschaftliche Interessenvereinigung', 0, 1, NULL, 0),
(19, 4104, 41, 'KEG - Kommanditerwerbsgesellschaft', 0, 1, NULL, 0),
(20, 4105, 41, 'OEG - Offene Erwerbsgesellschaft', 0, 1, NULL, 0),
(21, 4106, 41, 'OHG - Offene Handelsgesellschaft', 0, 1, NULL, 0),
(22, 4107, 41, 'AG & Co KG - Kommanditgesellschaft', 0, 1, NULL, 0),
(23, 4108, 41, 'GmbH & Co KG - Kommanditgesellschaft', 0, 1, NULL, 0),
(24, 4109, 41, 'KG - Kommanditgesellschaft', 0, 1, NULL, 0),
(25, 4110, 41, 'OG - Offene Gesellschaft', 0, 1, NULL, 0),
(26, 4111, 41, 'GbR - Gesellschaft nach bürgerlichem Recht', 0, 1, NULL, 0),
(27, 4112, 41, 'GesbR - Gesellschaft nach bürgerlichem Recht', 0, 1, NULL, 0),
(28, 4113, 41, 'GesnbR - Gesellschaft nach bürgerlichem Recht', 0, 1, NULL, 0),
(29, 4114, 41, 'e.U. - eingetragener Einzelunternehmer', 0, 1, NULL, 0),
(30, 11, 1, 'Artisan Commerçant (EI)', 0, 1, NULL, 0),
(31, 12, 1, 'Commerçant (EI)', 0, 1, NULL, 0),
(32, 13, 1, 'Artisan (EI)', 0, 1, NULL, 0),
(33, 14, 1, 'Officier public ou ministériel', 0, 1, NULL, 0),
(34, 15, 1, 'Profession libérale (EI)', 0, 1, NULL, 0),
(35, 16, 1, 'Exploitant agricole', 0, 1, NULL, 0),
(36, 17, 1, 'Agent commercial', 0, 1, NULL, 0),
(37, 18, 1, 'Associé Gérant de société', 0, 1, NULL, 0),
(38, 19, 1, 'Personne physique', 0, 1, NULL, 0),
(39, 21, 1, 'Indivision', 0, 1, NULL, 0),
(40, 22, 1, 'Société créée de fait', 0, 1, NULL, 0),
(41, 23, 1, 'Société en participation', 0, 1, NULL, 0),
(42, 24, 1, 'Société coopérative d\'interet collectif (SCIC)', 0, 1, NULL, 0),
(43, 25, 1, 'Société coopérative de production à responsabilité limitée (SCOP)', 0, 1, NULL, 0),
(44, 27, 1, 'Paroisse hors zone concordataire', 0, 1, NULL, 0),
(45, 29, 1, 'Groupement de droit privé non doté de la personnalité morale', 0, 1, NULL, 0),
(46, 31, 1, 'Personne morale de droit étranger, immatriculée au RCS', 0, 1, NULL, 0),
(47, 32, 1, 'Personne morale de droit étranger, non immatriculée au RCS', 0, 1, NULL, 0),
(48, 35, 1, 'Régime auto-entrepreneur', 0, 1, NULL, 0),
(49, 41, 1, 'Etablissement public ou régie à caractère industriel ou commercial', 0, 1, NULL, 0),
(50, 51, 1, 'Société coopérative commerciale particulière', 0, 1, NULL, 0),
(51, 52, 1, 'Société en nom collectif', 0, 1, NULL, 0),
(52, 53, 1, 'Société en commandite', 0, 1, NULL, 0),
(53, 54, 1, 'Société à responsabilité limitée (SARL)', 0, 1, NULL, 0),
(54, 55, 1, 'Société anonyme à conseil d administration', 0, 1, NULL, 0),
(55, 56, 1, 'Société anonyme à directoire', 0, 1, NULL, 0),
(56, 57, 1, 'Société par actions simplifiée (SAS)', 0, 1, NULL, 0),
(57, 58, 1, 'Entreprise Unipersonnelle à Responsabilité Limitée (EURL)', 0, 1, NULL, 0),
(58, 59, 1, 'Société par actions simplifiée unipersonnelle (SASU)', 0, 1, NULL, 0),
(59, 60, 1, 'Entreprise Individuelle à Responsabilité Limitée (EIRL)', 0, 1, NULL, 0),
(60, 61, 1, 'Caisse d\'épargne et de prévoyance', 0, 1, NULL, 0),
(61, 62, 1, 'Groupement d\'intérêt économique (GIE)', 0, 1, NULL, 0),
(62, 63, 1, 'Société coopérative agricole', 0, 1, NULL, 0),
(63, 64, 1, 'Société non commerciale d assurances', 0, 1, NULL, 0),
(64, 65, 1, 'Société civile', 0, 1, NULL, 0),
(65, 69, 1, 'Personnes de droit privé inscrites au RCS', 0, 1, NULL, 0),
(66, 71, 1, 'Administration de l état', 0, 1, NULL, 0),
(67, 72, 1, 'Collectivité territoriale', 0, 1, NULL, 0),
(68, 73, 1, 'Etablissement public administratif', 0, 1, NULL, 0),
(69, 74, 1, 'Personne morale de droit public administratif', 0, 1, NULL, 0),
(70, 81, 1, 'Organisme gérant régime de protection social à adhésion obligatoire', 0, 1, NULL, 0),
(71, 82, 1, 'Organisme mutualiste', 0, 1, NULL, 0),
(72, 83, 1, 'Comité d entreprise', 0, 1, NULL, 0),
(73, 84, 1, 'Organisme professionnel', 0, 1, NULL, 0),
(74, 85, 1, 'Organisme de retraite à adhésion non obligatoire', 0, 1, NULL, 0),
(75, 91, 1, 'Syndicat de propriétaires', 0, 1, NULL, 0),
(76, 92, 1, 'Association loi 1901 ou assimilé', 0, 1, NULL, 0),
(77, 93, 1, 'Fondation', 0, 1, NULL, 0),
(78, 99, 1, 'Personne morale de droit privé', 0, 1, NULL, 0),
(79, 200, 2, 'Indépendant', 0, 1, NULL, 0),
(80, 201, 2, 'SRL - Société à responsabilité limitée', 0, 1, NULL, 0),
(81, 202, 2, 'SA   - Société Anonyme', 0, 1, NULL, 0),
(82, 203, 2, 'SCRL - Société coopérative à responsabilité limitée', 0, 1, NULL, 0),
(83, 204, 2, 'ASBL - Association sans but Lucratif', 0, 1, NULL, 0),
(84, 205, 2, 'SCRI - Société coopérative à responsabilité illimitée', 0, 1, NULL, 0),
(85, 206, 2, 'SCS  - Société en commandite simple', 0, 1, NULL, 0),
(86, 207, 2, 'SCA  - Société en commandite par action', 0, 1, NULL, 0),
(87, 208, 2, 'SNC  - Société en nom collectif', 0, 1, NULL, 0),
(88, 209, 2, 'GIE  - Groupement d intérêt économique', 0, 1, NULL, 0),
(89, 210, 2, 'GEIE - Groupement européen d intérêt économique', 0, 1, NULL, 0),
(90, 220, 2, 'Eenmanszaak', 0, 1, NULL, 0),
(91, 221, 2, 'BVBA - Besloten vennootschap met beperkte aansprakelijkheid', 0, 1, NULL, 0),
(92, 222, 2, 'NV   - Naamloze Vennootschap', 0, 1, NULL, 0),
(93, 223, 2, 'CVBA - Coöperatieve vennootschap met beperkte aansprakelijkheid', 0, 1, NULL, 0),
(94, 224, 2, 'VZW  - Vereniging zonder winstoogmerk', 0, 1, NULL, 0),
(95, 225, 2, 'CVOA - Coöperatieve vennootschap met onbeperkte aansprakelijkheid ', 0, 1, NULL, 0),
(96, 226, 2, 'GCV  - Gewone commanditaire vennootschap', 0, 1, NULL, 0),
(97, 227, 2, 'Comm.VA - Commanditaire vennootschap op aandelen', 0, 1, NULL, 0),
(98, 228, 2, 'VOF  - Vennootschap onder firma', 0, 1, NULL, 0),
(99, 229, 2, 'VS0  - Vennootschap met sociaal oogmerk', 0, 1, NULL, 0),
(100, 500, 5, 'GmbH - Gesellschaft mit beschränkter Haftung', 0, 1, NULL, 0),
(101, 501, 5, 'AG - Aktiengesellschaft ', 0, 1, NULL, 0),
(102, 502, 5, 'GmbH&Co. KG - Gesellschaft mit beschränkter Haftung & Compagnie Kommanditgesellschaft', 0, 1, NULL, 0),
(103, 503, 5, 'Gewerbe - Personengesellschaft', 0, 1, NULL, 0),
(104, 504, 5, 'UG - Unternehmergesellschaft -haftungsbeschränkt-', 0, 1, NULL, 0),
(105, 505, 5, 'GbR - Gesellschaft des bürgerlichen Rechts', 0, 1, NULL, 0),
(106, 506, 5, 'KG - Kommanditgesellschaft', 0, 1, NULL, 0),
(107, 507, 5, 'Ltd. - Limited Company', 0, 1, NULL, 0),
(108, 508, 5, 'OHG - Offene Handelsgesellschaft', 0, 1, NULL, 0),
(109, 8001, 80, 'Aktieselvskab A/S', 0, 1, NULL, 0),
(110, 8002, 80, 'Anparts Selvskab ApS', 0, 1, NULL, 0),
(111, 8003, 80, 'Personlig ejet selvskab', 0, 1, NULL, 0),
(112, 8004, 80, 'Iværksætterselvskab IVS', 0, 1, NULL, 0),
(113, 8005, 80, 'Interessentskab I/S', 0, 1, NULL, 0),
(114, 8006, 80, 'Holdingselskab', 0, 1, NULL, 0),
(115, 8007, 80, 'Selskab Med Begrænset Hæftelse SMBA', 0, 1, NULL, 0),
(116, 8008, 80, 'Kommanditselskab K/S', 0, 1, NULL, 0),
(117, 8009, 80, 'SPE-selskab', 0, 1, NULL, 0),
(118, 10201, 102, 'Ατομική επιχείρηση', 0, 1, NULL, 0),
(119, 10202, 102, 'Εταιρική  επιχείρηση', 0, 1, NULL, 0),
(120, 10203, 102, 'Ομόρρυθμη Εταιρεία Ο.Ε', 0, 1, NULL, 0),
(121, 10204, 102, 'Ετερόρρυθμη Εταιρεία Ε.Ε', 0, 1, NULL, 0),
(122, 10205, 102, 'Εταιρεία Περιορισμένης Ευθύνης Ε.Π.Ε', 0, 1, NULL, 0),
(123, 10206, 102, 'Ανώνυμη Εταιρεία Α.Ε', 0, 1, NULL, 0),
(124, 10207, 102, 'Ανώνυμη ναυτιλιακή εταιρεία Α.Ν.Ε', 0, 1, NULL, 0),
(125, 10208, 102, 'Συνεταιρισμός', 0, 1, NULL, 0),
(126, 10209, 102, 'Συμπλοιοκτησία', 0, 1, NULL, 0),
(127, 301, 3, 'Società semplice', 0, 1, NULL, 0),
(128, 302, 3, 'Società in nome collettivo s.n.c.', 0, 1, NULL, 0),
(129, 303, 3, 'Società in accomandita semplice s.a.s.', 0, 1, NULL, 0),
(130, 304, 3, 'Società per azioni s.p.a.', 0, 1, NULL, 0),
(131, 305, 3, 'Società a responsabilità limitata s.r.l.', 0, 1, NULL, 0),
(132, 306, 3, 'Società in accomandita per azioni s.a.p.a.', 0, 1, NULL, 0),
(133, 307, 3, 'Società cooperativa a r.l.', 0, 1, NULL, 0),
(134, 308, 3, 'Società consortile', 0, 1, NULL, 0),
(135, 309, 3, 'Società europea', 0, 1, NULL, 0),
(136, 310, 3, 'Società cooperativa europea', 0, 1, NULL, 0),
(137, 311, 3, 'Società unipersonale', 0, 1, NULL, 0),
(138, 312, 3, 'Società di professionisti', 0, 1, NULL, 0),
(139, 313, 3, 'Società di fatto', 0, 1, NULL, 0),
(140, 315, 3, 'Società apparente', 0, 1, NULL, 0),
(141, 316, 3, 'Impresa individuale ', 0, 1, NULL, 0),
(142, 317, 3, 'Impresa coniugale', 0, 1, NULL, 0),
(143, 318, 3, 'Impresa familiare', 0, 1, NULL, 0),
(144, 319, 3, 'Consorzio cooperativo', 0, 1, NULL, 0),
(145, 320, 3, 'Società cooperativa sociale', 0, 1, NULL, 0),
(146, 321, 3, 'Società cooperativa di consumo', 0, 1, NULL, 0),
(147, 322, 3, 'Società cooperativa agricola', 0, 1, NULL, 0),
(148, 323, 3, 'A.T.I. Associazione temporanea di imprese', 0, 1, NULL, 0),
(149, 324, 3, 'R.T.I. Raggruppamento temporaneo di imprese', 0, 1, NULL, 0),
(150, 325, 3, 'Studio associato', 0, 1, NULL, 0),
(151, 600, 6, 'Raison Individuelle', 0, 1, NULL, 0),
(152, 601, 6, 'Société Simple', 0, 1, NULL, 0),
(153, 602, 6, 'Société en nom collectif', 0, 1, NULL, 0),
(154, 603, 6, 'Société en commandite', 0, 1, NULL, 0),
(155, 604, 6, 'Société anonyme (SA)', 0, 1, NULL, 0),
(156, 605, 6, 'Société en commandite par actions', 0, 1, NULL, 0),
(157, 606, 6, 'Société à responsabilité limitée (SARL)', 0, 1, NULL, 0),
(158, 607, 6, 'Société coopérative', 0, 1, NULL, 0),
(159, 608, 6, 'Association', 0, 1, NULL, 0),
(160, 609, 6, 'Fondation', 0, 1, NULL, 0),
(161, 700, 7, 'Sole Trader', 0, 1, NULL, 0),
(162, 701, 7, 'Partnership', 0, 1, NULL, 0),
(163, 702, 7, 'Private Limited Company by shares (LTD)', 0, 1, NULL, 0),
(164, 703, 7, 'Public Limited Company', 0, 1, NULL, 0),
(165, 704, 7, 'Workers Cooperative', 0, 1, NULL, 0),
(166, 705, 7, 'Limited Liability Partnership', 0, 1, NULL, 0),
(167, 706, 7, 'Franchise', 0, 1, NULL, 0),
(168, 1000, 10, 'Société à responsabilité limitée (SARL)', 0, 1, NULL, 0),
(169, 1001, 10, 'Société en Nom Collectif (SNC)', 0, 1, NULL, 0),
(170, 1002, 10, 'Société en Commandite Simple (SCS)', 0, 1, NULL, 0),
(171, 1003, 10, 'société en participation', 0, 1, NULL, 0),
(172, 1004, 10, 'Société Anonyme (SA)', 0, 1, NULL, 0),
(173, 1005, 10, 'Société Unipersonnelle à Responsabilité Limitée (SUARL)', 0, 1, NULL, 0),
(174, 1006, 10, 'Groupement d\'intérêt économique (GEI)', 0, 1, NULL, 0),
(175, 1007, 10, 'Groupe de sociétés', 0, 1, NULL, 0),
(176, 1701, 17, 'Eenmanszaak', 0, 1, NULL, 0),
(177, 1702, 17, 'Maatschap', 0, 1, NULL, 0),
(178, 1703, 17, 'Vennootschap onder firma', 0, 1, NULL, 0),
(179, 1704, 17, 'Commanditaire vennootschap', 0, 1, NULL, 0),
(180, 1705, 17, 'Besloten vennootschap (BV)', 0, 1, NULL, 0),
(181, 1706, 17, 'Naamloze Vennootschap (NV)', 0, 1, NULL, 0),
(182, 1707, 17, 'Vereniging', 0, 1, NULL, 0),
(183, 1708, 17, 'Stichting', 0, 1, NULL, 0),
(184, 1709, 17, 'Coöperatie met beperkte aansprakelijkheid (BA)', 0, 1, NULL, 0),
(185, 1710, 17, 'Coöperatie met uitgesloten aansprakelijkheid (UA)', 0, 1, NULL, 0),
(186, 1711, 17, 'Coöperatie met wettelijke aansprakelijkheid (WA)', 0, 1, NULL, 0),
(187, 1712, 17, 'Onderlinge waarborgmaatschappij', 0, 1, NULL, 0),
(188, 401, 4, 'Empresario Individual', 0, 1, NULL, 0),
(189, 402, 4, 'Comunidad de Bienes', 0, 1, NULL, 0),
(190, 403, 4, 'Sociedad Civil', 0, 1, NULL, 0),
(191, 404, 4, 'Sociedad Colectiva', 0, 1, NULL, 0),
(192, 405, 4, 'Sociedad Limitada', 0, 1, NULL, 0),
(193, 406, 4, 'Sociedad Anónima', 0, 1, NULL, 0),
(194, 407, 4, 'Sociedad Comanditaria por Acciones', 0, 1, NULL, 0),
(195, 408, 4, 'Sociedad Comanditaria Simple', 0, 1, NULL, 0),
(196, 409, 4, 'Sociedad Laboral', 0, 1, NULL, 0),
(197, 410, 4, 'Sociedad Cooperativa', 0, 1, NULL, 0),
(198, 411, 4, 'Sociedad de Garantía Recíproca', 0, 1, NULL, 0),
(199, 412, 4, 'Entidad de Capital-Riesgo', 0, 1, NULL, 0),
(200, 413, 4, 'Agrupación de Interés Económico', 0, 1, NULL, 0),
(201, 414, 4, 'Sociedad de Inversión Mobiliaria', 0, 1, NULL, 0),
(202, 415, 4, 'Agrupación sin Ánimo de Lucro', 0, 1, NULL, 0),
(203, 15201, 152, 'Mauritius Private Company Limited By Shares', 0, 1, NULL, 0),
(204, 15202, 152, 'Mauritius Company Limited By Guarantee', 0, 1, NULL, 0),
(205, 15203, 152, 'Mauritius Public Company Limited By Shares', 0, 1, NULL, 0),
(206, 15204, 152, 'Mauritius Foreign Company', 0, 1, NULL, 0),
(207, 15205, 152, 'Mauritius GBC1 (Offshore Company)', 0, 1, NULL, 0),
(208, 15206, 152, 'Mauritius GBC2 (International Company)', 0, 1, NULL, 0),
(209, 15207, 152, 'Mauritius General Partnership', 0, 1, NULL, 0),
(210, 15208, 152, 'Mauritius Limited Partnership', 0, 1, NULL, 0),
(211, 15209, 152, 'Mauritius Sole Proprietorship', 0, 1, NULL, 0),
(212, 15210, 152, 'Mauritius Trusts', 0, 1, NULL, 0),
(213, 15401, 154, 'Sociedad en nombre colectivo', 0, 1, NULL, 0),
(214, 15402, 154, 'Sociedad en comandita simple', 0, 1, NULL, 0),
(215, 15403, 154, 'Sociedad de responsabilidad limitada', 0, 1, NULL, 0),
(216, 15404, 154, 'Sociedad anónima', 0, 1, NULL, 0),
(217, 15405, 154, 'Sociedad en comandita por acciones', 0, 1, NULL, 0),
(218, 15406, 154, 'Sociedad cooperativa', 0, 1, NULL, 0),
(219, 14001, 140, 'Entreprise individuelle', 0, 1, NULL, 0),
(220, 14002, 140, 'Société en nom collectif (SENC)', 0, 1, NULL, 0),
(221, 14003, 140, 'Société en commandite simple (SECS)', 0, 1, NULL, 0),
(222, 14004, 140, 'Société en commandite par actions (SECA)', 0, 1, NULL, 0),
(223, 14005, 140, 'Société à responsabilité limitée (SARL)', 0, 1, NULL, 0),
(224, 14006, 140, 'Société anonyme (SA)', 0, 1, NULL, 0),
(225, 14007, 140, 'Société coopérative (SC)', 0, 1, NULL, 0),
(226, 14008, 140, 'Société européenne (SE)', 0, 1, NULL, 0),
(227, 18801, 188, 'AFJ - Alte forme juridice', 0, 1, NULL, 0),
(228, 18802, 188, 'ASF - Asociatie familialã', 0, 1, NULL, 0),
(229, 18803, 188, 'CON - Concesiune', 0, 1, NULL, 0),
(230, 18804, 188, 'CRL - Soc civilã profesionala cu pers. juridica si rãspundere limitata (SPRL)', 0, 1, NULL, 0),
(231, 18805, 188, 'INC - Închiriere', 0, 1, NULL, 0),
(232, 18806, 188, 'LOC - Locaţie de gestiune', 0, 1, NULL, 0),
(233, 18807, 188, 'OC1 - Organizaţie cooperatistã meşteşugãreascã', 0, 1, NULL, 0),
(234, 18808, 188, 'OC2 - Organizaţie cooperatistã de consum', 0, 1, NULL, 0),
(235, 18809, 188, 'OC3 - Organizaţie cooperatistã de credit', 0, 1, NULL, 0),
(236, 18810, 188, 'PFA - Persoanã fizicã independentã', 0, 1, NULL, 0),
(237, 18811, 188, 'RA - Regie autonomã', 0, 1, NULL, 0),
(238, 18812, 188, 'SA - Societate comercialã pe acţiuni', 0, 1, NULL, 0),
(239, 18813, 188, 'SCS - Societate comercialã în comanditã simplã', 0, 1, NULL, 0),
(240, 18814, 188, 'SNC - Societate comercialã în nume colectiv', 0, 1, NULL, 0),
(241, 18815, 188, 'SPI - Societate profesionala practicieni in insolventa (SPPI)', 0, 1, NULL, 0),
(242, 18816, 188, 'SRL - Societate comercialã cu rãspundere limitatã', 0, 1, NULL, 0),
(243, 18817, 188, 'URL - Intreprindere profesionala unipersonala cu rãspundere limitata (IPURL)', 0, 1, NULL, 0),
(244, 17801, 178, 'Empresa individual', 0, 1, NULL, 0),
(245, 17802, 178, 'Asociación General', 0, 1, NULL, 0),
(246, 17803, 178, 'Sociedad de Responsabilidad Limitada', 0, 1, NULL, 0),
(247, 17804, 178, 'Sociedad Civil', 0, 1, NULL, 0),
(248, 17805, 178, 'Sociedad Anónima', 0, 1, NULL, 0),
(249, 1300, 13, 'Personne physique', 0, 1, NULL, 0),
(250, 1301, 13, 'Société à responsabilité limitée (SARL)', 0, 1, NULL, 0),
(251, 1302, 13, 'Entreprise unipersonnelle à responsabilité limitée (EURL)', 0, 1, NULL, 0),
(252, 1303, 13, 'Société en Nom Collectif (SNC)', 0, 1, NULL, 0),
(253, 1304, 13, 'société par actions (SPA)', 0, 1, NULL, 0),
(254, 1305, 13, 'Société en Commandite Simple (SCS)', 0, 1, NULL, 0),
(255, 1306, 13, 'Société en commandite par actions (SCA)', 0, 1, NULL, 0),
(256, 1307, 13, 'Société en participation', 0, 1, NULL, 0),
(257, 1308, 13, 'Groupe de sociétés', 0, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_holiday_types`
--

DROP TABLE IF EXISTS `jvm_c_holiday_types`;
CREATE TABLE `jvm_c_holiday_types` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `affect` int(11) NOT NULL,
  `delay` int(11) NOT NULL,
  `newByMonth` double(8,5) NOT NULL DEFAULT '0.00000',
  `fk_country` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_holiday_types`
--

INSERT INTO `jvm_c_holiday_types` (`rowid`, `code`, `label`, `affect`, `delay`, `newByMonth`, `fk_country`, `active`) VALUES
(1, 'LEAVE_SICK', 'Sick leave', 0, 0, 0.00000, NULL, 1),
(2, 'LEAVE_OTHER', 'Other leave', 0, 0, 0.00000, NULL, 1),
(3, 'LEAVE_PAID', 'Paid vacation', 1, 7, 0.00000, NULL, 0),
(4, 'LEAVE_RTT_FR', 'RTT', 1, 7, 0.83000, 1, 1),
(5, 'LEAVE_PAID_FR', 'Paid vacation', 1, 30, 2.08334, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_hrm_department`
--

DROP TABLE IF EXISTS `jvm_c_hrm_department`;
CREATE TABLE `jvm_c_hrm_department` (
  `rowid` int(11) NOT NULL,
  `pos` tinyint(4) NOT NULL DEFAULT '0',
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_hrm_department`
--

INSERT INTO `jvm_c_hrm_department` (`rowid`, `pos`, `code`, `label`, `active`) VALUES
(1, 5, 'MANAGEMENT', 'Management', 1),
(3, 15, 'TRAINING', 'Training', 1),
(4, 20, 'IT', 'Inform. Technology (IT)', 0),
(5, 25, 'MARKETING', 'Marketing', 0),
(6, 30, 'SALES', 'Sales', 1),
(7, 35, 'LEGAL', 'Legal', 0),
(8, 40, 'FINANCIAL', 'Financial accounting', 1),
(9, 45, 'HUMANRES', 'Human resources', 1),
(10, 50, 'PURCHASING', 'Purchasing', 1),
(12, 60, 'CUSTOMSERV', 'Customer service', 0),
(14, 70, 'LOGISTIC', 'Logistics', 1),
(15, 75, 'CONSTRUCT', 'Engineering/design', 0),
(16, 80, 'PRODUCTION', 'Production', 1),
(17, 85, 'QUALITY', 'Quality assurance', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_hrm_function`
--

DROP TABLE IF EXISTS `jvm_c_hrm_function`;
CREATE TABLE `jvm_c_hrm_function` (
  `rowid` int(11) NOT NULL,
  `pos` tinyint(4) NOT NULL DEFAULT '0',
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `c_level` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_hrm_function`
--

INSERT INTO `jvm_c_hrm_function` (`rowid`, `pos`, `code`, `label`, `c_level`, `active`) VALUES
(1, 5, 'EXECBOARD', 'Executive board', 0, 1),
(2, 10, 'MANAGDIR', 'Managing director', 1, 1),
(3, 15, 'ACCOUNTMANAG', 'Account manager', 0, 1),
(4, 20, 'ENGAGDIR', 'Engagement director', 1, 1),
(5, 25, 'DIRECTOR', 'Director', 1, 1),
(6, 30, 'PROJMANAG', 'Project manager', 0, 1),
(7, 35, 'DEPHEAD', 'Department head', 0, 1),
(8, 40, 'SECRETAR', 'Secretary', 0, 1),
(9, 45, 'EMPLOYEE', 'Department employee', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_hrm_public_holiday`
--

DROP TABLE IF EXISTS `jvm_c_hrm_public_holiday`;
CREATE TABLE `jvm_c_hrm_public_holiday` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '0',
  `fk_country` int(11) DEFAULT NULL,
  `code` varchar(62) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dayrule` varchar(64) COLLATE utf8_unicode_ci DEFAULT '',
  `day` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_hrm_public_holiday`
--

INSERT INTO `jvm_c_hrm_public_holiday` (`id`, `entity`, `fk_country`, `code`, `dayrule`, `day`, `month`, `year`, `active`, `import_key`) VALUES
(1, 0, 0, 'NEWYEARDAY1', '', 1, 1, 0, 1, NULL),
(2, 0, 0, 'LABORDAY1', '', 1, 5, 0, 1, NULL),
(3, 0, 0, 'ASSOMPTIONDAY1', '', 15, 8, 0, 1, NULL),
(4, 0, 0, 'CHRISTMASDAY1', '', 25, 12, 0, 1, NULL),
(5, 0, 1, 'FR-VICTORYDAY', '', 8, 5, 0, 1, NULL),
(6, 0, 1, 'FR-NATIONALDAY', '', 14, 7, 0, 1, NULL),
(7, 0, 1, 'FR-ASSOMPTION', '', 15, 8, 0, 1, NULL),
(8, 0, 1, 'FR-TOUSSAINT', '', 1, 11, 0, 1, NULL),
(9, 0, 1, 'FR-ARMISTICE', '', 11, 11, 0, 1, NULL),
(10, 0, 1, 'FR-EASTER', 'eastermonday', 0, 0, 0, 1, NULL),
(11, 0, 1, 'FR-ASCENSION', 'ascension', 0, 0, 0, 1, NULL),
(12, 0, 1, 'FR-PENTECOST', 'pentecost', 0, 0, 0, 1, NULL),
(13, 0, 3, 'IT-LIBEAZIONE', '', 25, 4, 0, 1, NULL),
(14, 0, 3, 'IT-EPIPHANY', '', 1, 6, 0, 1, NULL),
(15, 0, 3, 'IT-REPUBBLICA', '', 2, 6, 0, 1, NULL),
(16, 0, 3, 'IT-TUTTISANTIT', '', 1, 11, 0, 1, NULL),
(17, 0, 3, 'IT-IMMACULE', '', 8, 12, 0, 1, NULL),
(18, 0, 3, 'IT-SAINTSTEFAN', '', 26, 12, 0, 1, NULL),
(19, 0, 4, 'ES-EASTER', 'easter', 0, 0, 0, 1, NULL),
(20, 0, 4, 'ES-REYE', '', 1, 6, 0, 1, NULL),
(21, 0, 4, 'ES-HISPANIDAD', '', 12, 10, 0, 1, NULL),
(22, 0, 4, 'ES-TOUSSAINT', '', 1, 11, 0, 1, NULL),
(23, 0, 4, 'ES-CONSTITUIZION', '', 6, 12, 0, 1, NULL),
(24, 0, 4, 'ES-IMMACULE', '', 8, 12, 0, 1, NULL),
(25, 0, 41, 'AT-EASTER', 'eastermonday', 0, 0, 0, 1, NULL),
(26, 0, 41, 'AT-ASCENSION', 'ascension', 0, 0, 0, 1, NULL),
(27, 0, 41, 'AT-PENTECOST', 'pentecost', 0, 0, 0, 1, NULL),
(28, 0, 41, 'AT-FRONLEICHNAM', 'fronleichnam', 0, 0, 0, 1, NULL),
(29, 0, 41, 'AT-KONEGIE', '', 1, 6, 0, 1, NULL),
(30, 0, 41, 'AT-26OKT', '', 26, 10, 0, 1, NULL),
(31, 0, 41, 'AT-TOUSSAINT', '', 1, 11, 0, 1, NULL),
(32, 0, 41, 'AT-IMMACULE', '', 8, 12, 0, 1, NULL),
(33, 0, 41, 'AT-24DEC', '', 24, 12, 0, 1, NULL),
(34, 0, 41, 'AT-SAINTSTEFAN', '', 26, 12, 0, 1, NULL),
(35, 0, 41, 'AT-Silvester', '', 31, 12, 0, 1, NULL),
(36, 0, 117, 'IN-REPUBLICDAY', '', 26, 1, 0, 1, NULL),
(37, 0, 117, 'IN-GANDI', '', 2, 10, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_incoterms`
--

DROP TABLE IF EXISTS `jvm_c_incoterms`;
CREATE TABLE `jvm_c_incoterms` (
  `rowid` int(11) NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_incoterms`
--

INSERT INTO `jvm_c_incoterms` (`rowid`, `code`, `label`, `libelle`, `active`) VALUES
(1, 'EXW', 'Ex Works', 'Ex Works, au départ non chargé, non dédouané sortie d\'usine (uniquement adapté aux flux domestiques, nationaux)', 1),
(2, 'FCA', 'Free Carrier', 'Free Carrier, marchandises dédouanées et chargées dans le pays de départ, chez le vendeur ou chez le commissionnaire de transport de l\'acheteur', 1),
(3, 'FAS', 'Free Alongside Ship', 'Free Alongside Ship, sur le quai du port de départ', 1),
(4, 'FOB', 'Free On Board', 'Free On Board, chargé sur le bateau, les frais de chargement dans celui-ci étant fonction du liner term indiqué par la compagnie maritime (à la charge du vendeur)', 1),
(5, 'CFR', 'Cost and Freight', 'Cost and Freight, chargé dans le bateau, livraison au port de départ, frais payés jusqu\'au port d\'arrivée, sans assurance pour le transport, non déchargé du navire à destination (les frais de déchargement sont inclus ou non au port d\'arrivée)', 1),
(6, 'CIF', 'Cost, Insurance, Freight', 'Cost, Insurance and Freight, chargé sur le bateau, frais jusqu\'au port d\'arrivée, avec l\'assurance marchandise transportée souscrite par le vendeur pour le compte de l\'acheteur', 1),
(7, 'CPT', 'Carriage Paid To', 'Carriage Paid To, livraison au premier transporteur, frais jusqu\'au déchargement du mode de transport, sans assurance pour le transport', 1),
(8, 'CIP', 'Carriage Insurance Paid', 'Carriage and Insurance Paid to, idem CPT, avec assurance marchandise transportée souscrite par le vendeur pour le compte de l\'acheteur', 1),
(9, 'DAT', 'Delivered At Terminal', 'Delivered At Terminal, marchandises (déchargées) livrées sur quai, dans un terminal maritime, fluvial, aérien, routier ou ferroviaire désigné (dédouanement import, et post-acheminement payés par l\'acheteur)', 1),
(10, 'DAP', 'Delivered At Place', 'Delivered At Place, marchandises (non déchargées) mises à disposition de l\'acheteur dans le pays d\'importation au lieu précisé dans le contrat (déchargement, dédouanement import payé par l\'acheteur)', 1),
(11, 'DDP', 'Delivered Duty Paid', 'Delivered Duty Paid, marchandises (non déchargées) livrées à destination finale, dédouanement import et taxes à la charge du vendeur ; l\'acheteur prend en charge uniquement le déchargement (si exclusion des taxes type TVA, le préciser clairement)', 1),
(12, 'DPU', 'Delivered at Place Unloaded', 'Delivered at Place unloaded', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_input_method`
--

DROP TABLE IF EXISTS `jvm_c_input_method`;
CREATE TABLE `jvm_c_input_method` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `libelle` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_input_method`
--

INSERT INTO `jvm_c_input_method` (`rowid`, `code`, `libelle`, `active`, `module`) VALUES
(1, 'OrderByMail', 'Courrier', 1, NULL),
(2, 'OrderByFax', 'Fax', 1, NULL),
(3, 'OrderByEMail', 'EMail', 1, NULL),
(4, 'OrderByPhone', 'Téléphone', 1, NULL),
(5, 'OrderByWWW', 'En ligne', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_input_reason`
--

DROP TABLE IF EXISTS `jvm_c_input_reason`;
CREATE TABLE `jvm_c_input_reason` (
  `rowid` int(11) NOT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_input_reason`
--

INSERT INTO `jvm_c_input_reason` (`rowid`, `code`, `label`, `active`, `module`) VALUES
(1, 'SRC_INTE', 'Web site', 1, NULL),
(2, 'SRC_CAMP_MAIL', 'Mailing campaign', 1, NULL),
(3, 'SRC_CAMP_PHO', 'Phone campaign', 1, NULL),
(4, 'SRC_CAMP_FAX', 'Fax campaign', 1, NULL),
(5, 'SRC_COMM', 'Commercial contact', 1, NULL),
(6, 'SRC_SHOP', 'Shop contact', 1, NULL),
(7, 'SRC_CAMP_EMAIL', 'EMailing campaign', 1, NULL),
(8, 'SRC_WOM', 'Word of mouth', 1, NULL),
(9, 'SRC_PARTNER', 'Partner', 1, NULL),
(10, 'SRC_EMPLOYEE', 'Employee', 1, NULL),
(11, 'SRC_SPONSORING', 'Sponsorship', 1, NULL),
(12, 'SRC_CUSTOMER', 'Incoming contact of a customer', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_lead_status`
--

DROP TABLE IF EXISTS `jvm_c_lead_status`;
CREATE TABLE `jvm_c_lead_status` (
  `rowid` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `percent` double(5,2) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_lead_status`
--

INSERT INTO `jvm_c_lead_status` (`rowid`, `code`, `label`, `position`, `percent`, `active`) VALUES
(1, 'PROSP', 'Prospection', 10, 0.00, 1),
(2, 'QUAL', 'Qualification', 20, 20.00, 1),
(3, 'PROPO', 'Proposal', 30, 40.00, 1),
(4, 'NEGO', 'Negotiation', 40, 60.00, 1),
(5, 'PENDING', 'Pending', 50, 50.00, 0),
(6, 'WON', 'Won', 60, 100.00, 1),
(7, 'LOST', 'Lost', 70, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_paiement`
--

DROP TABLE IF EXISTS `jvm_c_paiement`;
CREATE TABLE `jvm_c_paiement` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(62) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `accountancy_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_paiement`
--

INSERT INTO `jvm_c_paiement` (`id`, `entity`, `code`, `libelle`, `type`, `active`, `accountancy_code`, `module`, `position`) VALUES
(1, 1, 'TIP', 'TIP', 2, 0, NULL, NULL, 0),
(2, 1, 'VIR', 'Transfer', 2, 1, NULL, NULL, 0),
(3, 1, 'PRE', 'Debit order', 2, 1, NULL, NULL, 0),
(4, 1, 'LIQ', 'Cash', 2, 1, NULL, NULL, 0),
(6, 1, 'CB', 'Credit card', 2, 1, NULL, NULL, 0),
(7, 1, 'CHQ', 'Cheque', 2, 1, NULL, NULL, 0),
(50, 1, 'VAD', 'Online payment', 2, 0, NULL, NULL, 0),
(51, 1, 'TRA', 'Traite', 2, 0, NULL, NULL, 0),
(52, 1, 'LCR', 'LCR', 2, 0, NULL, NULL, 0),
(53, 1, 'FAC', 'Factor', 2, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_paper_format`
--

DROP TABLE IF EXISTS `jvm_c_paper_format`;
CREATE TABLE `jvm_c_paper_format` (
  `rowid` int(11) NOT NULL,
  `code` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `width` float(6,2) DEFAULT '0.00',
  `height` float(6,2) DEFAULT '0.00',
  `unit` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_paper_format`
--

INSERT INTO `jvm_c_paper_format` (`rowid`, `code`, `label`, `width`, `height`, `unit`, `active`, `module`) VALUES
(1, 'EU4A0', 'Format 4A0', 1682.00, 2378.00, 'mm', 1, NULL),
(2, 'EU2A0', 'Format 2A0', 1189.00, 1682.00, 'mm', 1, NULL),
(3, 'EUA0', 'Format A0', 840.00, 1189.00, 'mm', 1, NULL),
(4, 'EUA1', 'Format A1', 594.00, 840.00, 'mm', 1, NULL),
(5, 'EUA2', 'Format A2', 420.00, 594.00, 'mm', 1, NULL),
(6, 'EUA3', 'Format A3', 297.00, 420.00, 'mm', 1, NULL),
(7, 'EUA4', 'Format A4', 210.00, 297.00, 'mm', 1, NULL),
(8, 'EUA5', 'Format A5', 148.00, 210.00, 'mm', 1, NULL),
(9, 'EUA6', 'Format A6', 105.00, 148.00, 'mm', 1, NULL),
(100, 'USLetter', 'Format Letter (A)', 216.00, 279.00, 'mm', 1, NULL),
(105, 'USLegal', 'Format Legal', 216.00, 356.00, 'mm', 1, NULL),
(110, 'USExecutive', 'Format Executive', 190.00, 254.00, 'mm', 1, NULL),
(115, 'USLedger', 'Format Ledger/Tabloid (B)', 279.00, 432.00, 'mm', 1, NULL),
(200, 'CAP1', 'Format Canadian P1', 560.00, 860.00, 'mm', 1, NULL),
(205, 'CAP2', 'Format Canadian P2', 430.00, 560.00, 'mm', 1, NULL),
(210, 'CAP3', 'Format Canadian P3', 280.00, 430.00, 'mm', 1, NULL),
(215, 'CAP4', 'Format Canadian P4', 215.00, 280.00, 'mm', 1, NULL),
(220, 'CAP5', 'Format Canadian P5', 140.00, 215.00, 'mm', 1, NULL),
(225, 'CAP6', 'Format Canadian P6', 107.00, 140.00, 'mm', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_payment_term`
--

DROP TABLE IF EXISTS `jvm_c_payment_term`;
CREATE TABLE `jvm_c_payment_term` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `libelle_facture` text COLLATE utf8_unicode_ci,
  `type_cdr` tinyint(4) DEFAULT NULL,
  `nbjour` smallint(6) DEFAULT NULL,
  `decalage` smallint(6) DEFAULT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_payment_term`
--

INSERT INTO `jvm_c_payment_term` (`rowid`, `entity`, `code`, `sortorder`, `active`, `libelle`, `libelle_facture`, `type_cdr`, `nbjour`, `decalage`, `module`, `position`) VALUES
(1, 1, 'RECEP', 1, 1, 'Due upon receipt', 'Due upon receipt', 0, 1, NULL, NULL, 0),
(2, 1, '30D', 2, 1, '30 days', 'Due in 30 days', 0, 30, NULL, NULL, 0),
(3, 1, '30DENDMONTH', 3, 1, '30 days end of month', 'Due in 30 days, end of month', 1, 30, NULL, NULL, 0),
(4, 1, '60D', 4, 1, '60 days', 'Due in 60 days, end of month', 0, 60, NULL, NULL, 0),
(5, 1, '60DENDMONTH', 5, 1, '60 days end of month', 'Due in 60 days, end of month', 1, 60, NULL, NULL, 0),
(6, 1, 'PT_ORDER', 6, 1, 'Due on order', 'Due on order', 0, 1, NULL, NULL, 0),
(7, 1, 'PT_DELIVERY', 7, 1, 'Due on delivery', 'Due on delivery', 0, 1, NULL, NULL, 0),
(8, 1, 'PT_5050', 8, 1, '50 and 50', '50% on order, 50% on delivery', 0, 1, NULL, NULL, 0),
(9, 1, '10D', 9, 1, '10 days', 'Due in 10 days', 0, 10, NULL, NULL, 0),
(10, 1, '10DENDMONTH', 10, 1, '10 days end of month', 'Due in 10 days, end of month', 1, 10, NULL, NULL, 0),
(11, 1, '14D', 11, 1, '14 days', 'Due in 14 days', 0, 14, NULL, NULL, 0),
(12, 1, '14DENDMONTH', 12, 1, '14 days end of month', 'Due in 14 days, end of month', 1, 14, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_pincodes`
--

DROP TABLE IF EXISTS `jvm_c_pincodes`;
CREATE TABLE `jvm_c_pincodes` (
  `rowid` int(11) NOT NULL,
  `code_pincode` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `fk_city` int(11) DEFAULT NULL,
  `fk_state` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_pincodes`
--

INSERT INTO `jvm_c_pincodes` (`rowid`, `code_pincode`, `fk_city`, `fk_state`, `nom`, `active`) VALUES
(1, '302012', 1, 1015, 'Jaipur', 1),
(2, '302011', 2, 1015, 'civil line', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_price_expression`
--

DROP TABLE IF EXISTS `jvm_c_price_expression`;
CREATE TABLE `jvm_c_price_expression` (
  `rowid` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `expression` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_price_global_variable`
--

DROP TABLE IF EXISTS `jvm_c_price_global_variable`;
CREATE TABLE `jvm_c_price_global_variable` (
  `rowid` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `value` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_price_global_variable_updater`
--

DROP TABLE IF EXISTS `jvm_c_price_global_variable_updater`;
CREATE TABLE `jvm_c_price_global_variable_updater` (
  `rowid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parameters` text COLLATE utf8_unicode_ci,
  `fk_variable` int(11) NOT NULL,
  `update_interval` int(11) DEFAULT '0',
  `next_update` int(11) DEFAULT '0',
  `last_status` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_product_nature`
--

DROP TABLE IF EXISTS `jvm_c_product_nature`;
CREATE TABLE `jvm_c_product_nature` (
  `rowid` int(11) NOT NULL,
  `code` tinyint(4) NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_product_nature`
--

INSERT INTO `jvm_c_product_nature` (`rowid`, `code`, `label`, `active`) VALUES
(1, 0, 'RowMaterial', 1),
(2, 1, 'Finished', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_propalst`
--

DROP TABLE IF EXISTS `jvm_c_propalst`;
CREATE TABLE `jvm_c_propalst` (
  `id` smallint(6) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_propalst`
--

INSERT INTO `jvm_c_propalst` (`id`, `code`, `label`, `active`) VALUES
(0, 'PR_DRAFT', 'Brouillon', 1),
(1, 'PR_OPEN', 'Ouverte', 1),
(2, 'PR_SIGNED', 'Signée', 1),
(3, 'PR_NOTSIGNED', 'Non Signée', 1),
(4, 'PR_FAC', 'Facturée', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_prospectcontactlevel`
--

DROP TABLE IF EXISTS `jvm_c_prospectcontactlevel`;
CREATE TABLE `jvm_c_prospectcontactlevel` (
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_prospectcontactlevel`
--

INSERT INTO `jvm_c_prospectcontactlevel` (`code`, `label`, `sortorder`, `active`, `module`) VALUES
('PL_HIGH', 'High', 4, 1, NULL),
('PL_LOW', 'Low', 2, 1, NULL),
('PL_MEDIUM', 'Medium', 3, 1, NULL),
('PL_NONE', 'None', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_prospectlevel`
--

DROP TABLE IF EXISTS `jvm_c_prospectlevel`;
CREATE TABLE `jvm_c_prospectlevel` (
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortorder` smallint(6) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_prospectlevel`
--

INSERT INTO `jvm_c_prospectlevel` (`code`, `label`, `sortorder`, `active`, `module`) VALUES
('PL_HIGH', 'High', 4, 1, NULL),
('PL_LOW', 'Low', 2, 1, NULL),
('PL_MEDIUM', 'Medium', 3, 1, NULL),
('PL_NONE', 'None', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_recruitment_origin`
--

DROP TABLE IF EXISTS `jvm_c_recruitment_origin`;
CREATE TABLE `jvm_c_recruitment_origin` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_regions`
--

DROP TABLE IF EXISTS `jvm_c_regions`;
CREATE TABLE `jvm_c_regions` (
  `rowid` int(11) NOT NULL,
  `code_region` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `cheflieu` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tncc` int(11) DEFAULT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_regions`
--

INSERT INTO `jvm_c_regions` (`rowid`, `code_region`, `fk_pays`, `cheflieu`, `tncc`, `nom`, `active`) VALUES
(1, 0, 0, '0', 0, '-', 1),
(148, 11701, 117, '', 0, 'India', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_revenuestamp`
--

DROP TABLE IF EXISTS `jvm_c_revenuestamp`;
CREATE TABLE `jvm_c_revenuestamp` (
  `rowid` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `taux` double NOT NULL,
  `revenuestamp_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fixed',
  `note` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `accountancy_code_sell` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_buy` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_revenuestamp`
--

INSERT INTO `jvm_c_revenuestamp` (`rowid`, `fk_pays`, `taux`, `revenuestamp_type`, `note`, `active`, `accountancy_code_sell`, `accountancy_code_buy`) VALUES
(101, 10, 0.4, 'fixed', 'Revenue stamp tunisia', 1, NULL, NULL),
(1541, 154, 1.5, 'percent', 'Revenue stamp mexico', 1, NULL, NULL),
(1542, 154, 3, 'percent', 'Revenue stamp mexico', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_shipment_mode`
--

DROP TABLE IF EXISTS `jvm_c_shipment_mode`;
CREATE TABLE `jvm_c_shipment_mode` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `tracking` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_shipment_mode`
--

INSERT INTO `jvm_c_shipment_mode` (`rowid`, `entity`, `tms`, `code`, `libelle`, `description`, `tracking`, `active`, `module`) VALUES
(1, 1, '2021-01-22 06:42:01', 'CATCH', 'In-Store Collection', 'In-store collection by the customer', '', 1, NULL),
(2, 1, '2021-01-22 06:42:01', 'TRANS', 'Generic transport service', 'Generic transport service', '', 1, NULL),
(3, 1, '2021-01-22 06:42:01', 'COLSUI', 'Colissimo Suivi', 'Colissimo Suivi', 'https://www.laposte.fr/outils/suivre-vos-envois?code={TRACKID}', 0, NULL),
(4, 1, '2021-01-22 06:42:01', 'LETTREMAX', 'Lettre Max', 'Courrier Suivi et Lettre Max', 'https://www.laposte.fr/outils/suivre-vos-envois?code={TRACKID}', 0, NULL),
(5, 1, '2021-01-22 06:42:01', 'UPS', 'UPS', 'United Parcel Service', 'http://wwwapps.ups.com/etracking/tracking.cgi?InquiryNumber2=&InquiryNumber3=&tracknums_displayed=3&loc=fr_FR&TypeOfInquiryNumber=T&HTMLVersion=4.0&InquiryNumber22=&InquiryNumber32=&track=Track&Suivi.x=64&Suivi.y=7&Suivi=Valider&InquiryNumber1={TRACKID}', 1, NULL),
(6, 1, '2021-01-22 06:42:01', 'KIALA', 'KIALA', 'Relais Kiala', 'http://www.kiala.fr/tnt/delivery/{TRACKID}', 0, NULL),
(7, 1, '2021-01-22 06:42:01', 'GLS', 'GLS', 'General Logistics Systems', 'https://gls-group.eu/FR/fr/suivi-colis?match={TRACKID}', 0, NULL),
(8, 1, '2021-01-22 06:42:01', 'CHRONO', 'Chronopost', 'Chronopost', 'http://www.chronopost.fr/expedier/inputLTNumbersNoJahia.do?listeNumeros={TRACKID}', 0, NULL),
(9, 1, '2021-01-22 06:42:01', 'INPERSON', 'In person at your site', NULL, NULL, 0, NULL),
(10, 1, '2021-01-22 06:42:01', 'FEDEX', 'Fedex', NULL, 'https://www.fedex.com/apps/fedextrack/index.html?tracknumbers={TRACKID}', 0, NULL),
(11, 1, '2021-01-22 06:42:01', 'TNT', 'TNT', NULL, 'https://www.tnt.com/express/fr_fr/site/outils-expedition/suivi.html?searchType=con&cons=={TRACKID}', 0, NULL),
(12, 1, '2021-01-22 06:42:01', 'DHL', 'DHL', NULL, 'https://www.dhl.com/fr-fr/home/tracking/tracking-global-forwarding.html?submit=1&tracking-id={TRACKID}', 0, NULL),
(13, 1, '2021-01-22 06:42:01', 'DPD', 'DPD', NULL, 'https://www.dpd.fr/trace/{TRACKID}', 0, NULL),
(14, 1, '2021-01-22 06:42:01', 'MAINFREIGHT', 'Mainfreight', NULL, 'https://www.mainfreight.com/track?{TRACKID}', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_shipment_package_type`
--

DROP TABLE IF EXISTS `jvm_c_shipment_package_type`;
CREATE TABLE `jvm_c_shipment_package_type` (
  `rowid` int(11) NOT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_socialnetworks`
--

DROP TABLE IF EXISTS `jvm_c_socialnetworks`;
CREATE TABLE `jvm_c_socialnetworks` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `icon` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_socialnetworks`
--

INSERT INTO `jvm_c_socialnetworks` (`rowid`, `entity`, `code`, `label`, `url`, `icon`, `active`) VALUES
(1, 1, 'facebook', 'Facebook', 'https://www.facebook.com/{socialid}', 'fa-facebook', 1),
(2, 1, 'skype', 'Skype', 'https://www.skype.com/{socialid}', 'fa-skype', 1),
(3, 1, 'twitter', 'Twitter', 'https://www.twitter.com/{socialid}', 'fa-twitter', 1),
(4, 1, 'linkedin', 'LinkedIn', 'https://www.linkedin.com/{socialid}', 'fa-linkedin', 1),
(5, 1, 'instagram', 'Instagram', 'https://www.instagram.com/{socialid}', 'fa-instagram', 1),
(6, 1, 'snapchat', 'Snapchat', '{socialid}', 'fa-snapchat', 1),
(7, 1, 'googleplus', 'GooglePlus', 'https://www.googleplus.com/{socialid}', 'fa-google-plus-g', 0),
(8, 1, 'youtube', 'Youtube', 'https://www.youtube.com/{socialid}', 'fa-youtube', 1),
(9, 1, 'whatsapp', 'Whatsapp', '{socialid}', 'fa-whatsapp', 1),
(10, 1, 'tumblr', 'Tumblr', 'https://www.tumblr.com/{socialid}', 'fa-tumblr', 0),
(11, 1, 'vero', 'Vero', 'https://vero.co/{socialid}', '', 0),
(12, 1, 'viadeo', 'Viadeo', 'https://fr.viadeo.com/fr/{socialid}', 'fa-viadeo', 0),
(13, 1, 'slack', 'Slack', '{socialid}', 'fa-slack', 0),
(14, 1, 'xing', 'Xing', '{socialid}', 'fa-xing', 0),
(15, 1, 'meetup', 'Meetup', '{socialid}', 'fa-meetup', 0),
(16, 1, 'pinterest', 'Pinterest', '{socialid}', 'fa-pinterest', 0),
(17, 1, 'flickr', 'Flickr', '{socialid}', 'fa-flickr', 0),
(18, 1, '500px', '500px', '{socialid}', 'fa-500px', 0),
(19, 1, 'giphy', 'Giphy', '{socialid}', '', 0),
(20, 1, 'gifycat', 'Gificat', '{socialid}', '', 0),
(21, 1, 'dailymotion', 'Dailymotion', '{socialid}', '', 0),
(22, 1, 'vimeo', 'Vimeo', '{socialid}', '', 0),
(23, 1, 'periscope', 'Periscope', '{socialid}', '', 0),
(24, 1, 'twitch', 'Twitch', '{socialid}', '', 0),
(25, 1, 'discord', 'Discord', '{socialid}', 'fa-discord', 0),
(26, 1, 'wikipedia', 'Wikipedia', '{socialid}', '', 0),
(27, 1, 'reddit', 'Reddit', '{socialid}', 'fa-reddit', 0),
(28, 1, 'quora', 'Quora', '{socialid}', '', 0),
(29, 1, 'tripadvisor', 'Tripadvisor', '{socialid}', '', 0),
(30, 1, 'mastodon', 'Mastodon', '{socialid}', '', 0),
(31, 1, 'diaspora', 'Diaspora', '{socialid}', '', 0),
(32, 1, 'viber', 'Viber', '{socialid}', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_stcomm`
--

DROP TABLE IF EXISTS `jvm_c_stcomm`;
CREATE TABLE `jvm_c_stcomm` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picto` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_stcomm`
--

INSERT INTO `jvm_c_stcomm` (`id`, `code`, `libelle`, `picto`, `active`) VALUES
(-1, 'ST_NO', 'Do not contact', NULL, 1),
(0, 'ST_NEVER', 'Never contacted', NULL, 1),
(1, 'ST_TODO', 'To contact', NULL, 1),
(2, 'ST_PEND', 'Contact in progress', NULL, 1),
(3, 'ST_DONE', 'Contacted', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_stcommcontact`
--

DROP TABLE IF EXISTS `jvm_c_stcommcontact`;
CREATE TABLE `jvm_c_stcommcontact` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picto` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_stcommcontact`
--

INSERT INTO `jvm_c_stcommcontact` (`id`, `code`, `libelle`, `picto`, `active`) VALUES
(-1, 'ST_NO', 'Do not contact', NULL, 1),
(0, 'ST_NEVER', 'Never contacted', NULL, 1),
(1, 'ST_TODO', 'To contact', NULL, 1),
(2, 'ST_PEND', 'Contact in progress', NULL, 1),
(3, 'ST_DONE', 'Contacted', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ticket_category`
--

DROP TABLE IF EXISTS `jvm_c_ticket_category`;
CREATE TABLE `jvm_c_ticket_category` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pos` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) DEFAULT '1',
  `use_default` int(11) DEFAULT '1',
  `fk_parent` int(11) NOT NULL DEFAULT '0',
  `force_severity` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_ticket_category`
--

INSERT INTO `jvm_c_ticket_category` (`rowid`, `entity`, `code`, `pos`, `label`, `active`, `use_default`, `fk_parent`, `force_severity`, `description`) VALUES
(1, 1, 'OTHER', '10', 'Other', 1, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ticket_resolution`
--

DROP TABLE IF EXISTS `jvm_c_ticket_resolution`;
CREATE TABLE `jvm_c_ticket_resolution` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pos` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) DEFAULT '1',
  `use_default` int(11) DEFAULT '1',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_ticket_resolution`
--

INSERT INTO `jvm_c_ticket_resolution` (`rowid`, `entity`, `code`, `pos`, `label`, `active`, `use_default`, `description`) VALUES
(1, 1, 'SOLVED', '10', 'Solved', 1, 0, NULL),
(2, 1, 'CANCELED', '50', 'Canceled', 1, 0, NULL),
(3, 1, 'OTHER', '90', 'Other', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ticket_severity`
--

DROP TABLE IF EXISTS `jvm_c_ticket_severity`;
CREATE TABLE `jvm_c_ticket_severity` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pos` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `use_default` int(11) DEFAULT '1',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_ticket_severity`
--

INSERT INTO `jvm_c_ticket_severity` (`rowid`, `entity`, `code`, `pos`, `label`, `color`, `active`, `use_default`, `description`) VALUES
(1, 1, 'LOW', '10', 'Low', '', 1, 0, NULL),
(2, 1, 'NORMAL', '20', 'Normal', '', 1, 1, NULL),
(3, 1, 'HIGH', '30', 'High', '', 1, 0, NULL),
(4, 1, 'BLOCKING', '40', 'Critical / blocking', '', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ticket_type`
--

DROP TABLE IF EXISTS `jvm_c_ticket_type`;
CREATE TABLE `jvm_c_ticket_type` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pos` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) DEFAULT '1',
  `use_default` int(11) DEFAULT '1',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_ticket_type`
--

INSERT INTO `jvm_c_ticket_type` (`rowid`, `entity`, `code`, `pos`, `label`, `active`, `use_default`, `description`) VALUES
(1, 1, 'COM', '10', 'Commercial question', 1, 0, NULL),
(2, 1, 'HELP', '15', 'Request for functionnal help', 1, 0, NULL),
(3, 1, 'ISSUE', '20', 'Issue or problem', 1, 0, NULL),
(4, 1, 'REQUEST', '25', 'Change or enhancement request', 1, 0, NULL),
(5, 1, 'PROJECT', '30', 'Project', 0, 0, NULL),
(6, 1, 'OTHER', '40', 'Other', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_transport_mode`
--

DROP TABLE IF EXISTS `jvm_c_transport_mode`;
CREATE TABLE `jvm_c_transport_mode` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_transport_mode`
--

INSERT INTO `jvm_c_transport_mode` (`rowid`, `entity`, `code`, `label`, `active`) VALUES
(1, 1, 'MAR', 'Transport maritime (y compris camions ou wagons sur bateau)', 1),
(2, 1, 'TRA', 'Transport par chemin de fer (y compris camions sur wagon)', 1),
(3, 1, 'ROU', 'Transport par route', 1),
(4, 1, 'AIR', 'Transport par air', 1),
(5, 1, 'POS', 'Envois postaux', 1),
(6, 1, 'OLE', 'Installations de transport fixe (oléoduc)', 1),
(7, 1, 'NAV', 'Transport par navigation intérieure', 1),
(8, 1, 'PRO', 'Propulsion propre', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_tva`
--

DROP TABLE IF EXISTS `jvm_c_tva`;
CREATE TABLE `jvm_c_tva` (
  `rowid` int(11) NOT NULL,
  `fk_pays` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `taux` double NOT NULL,
  `localtax1` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `recuperableonly` int(11) NOT NULL DEFAULT '0',
  `note` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `accountancy_code_sell` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_buy` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_tva`
--

INSERT INTO `jvm_c_tva` (`rowid`, `fk_pays`, `code`, `taux`, `localtax1`, `localtax1_type`, `localtax2`, `localtax2_type`, `recuperableonly`, `note`, `active`, `accountancy_code_sell`, `accountancy_code_buy`) VALUES
(11, 1, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0 ou non applicable', 1, NULL, NULL),
(12, 1, '', 20, '0', '0', '0', '0', 0, 'VAT standard rate (France hors DOM-TOM)', 1, NULL, NULL),
(13, 1, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(14, 1, '', 5.5, '0', '0', '0', '0', 0, 'VAT reduced rate (France hors DOM-TOM)', 1, NULL, NULL),
(15, 1, '', 2.1, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(16, 1, '85', 8.5, '0', '0', '0', '0', 0, 'VAT standard rate (DOM sauf Guyane et Saint-Martin)', 0, NULL, NULL),
(17, 1, '85NPR', 8.5, '0', '0', '0', '0', 1, 'VAT standard rate (DOM sauf Guyane et Saint-Martin), non perçu par le vendeur mais récupérable par acheteur', 0, NULL, NULL),
(18, 1, '85NPROM', 8.5, '2', '3', '0', '0', 1, 'VAT standard rate (DOM sauf Guyane et Saint-Martin), NPR, Octroi de Mer', 0, NULL, NULL),
(19, 1, '85NPROMOMR', 8.5, '2', '3', '2.5', '3', 1, 'VAT standard rate (DOM sauf Guyane et Saint-Martin), NPR, Octroi de Mer et Octroi de Mer Regional', 0, NULL, NULL),
(21, 2, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0 ou non applicable', 1, NULL, NULL),
(22, 2, '', 6, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(23, 2, '', 21, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(24, 2, '', 12, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(31, 3, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(32, 3, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(33, 3, '', 4, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(34, 3, '', 22, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(41, 4, '', 0, '0', '3', '-19:-15:-9', '5', 0, 'VAT Rate 0', 1, NULL, NULL),
(42, 4, '', 10, '1.4', '3', '-19:-15:-9', '5', 0, 'VAT reduced rate', 1, NULL, NULL),
(43, 4, '', 4, '0.5', '3', '-19:-15:-9', '5', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(44, 4, '', 21, '5.2', '3', '-19:-15:-9', '5', 0, 'VAT standard rate', 1, NULL, NULL),
(51, 5, '', 0, '0', '0', '0', '0', 0, 'No VAT', 1, NULL, NULL),
(52, 5, '', 7, '0', '0', '0', '0', 0, 'ermäßigte USt.', 1, NULL, NULL),
(54, 5, '', 5.5, '0', '0', '0', '0', 0, 'USt. Forst', 0, NULL, NULL),
(55, 5, '', 10.7, '0', '0', '0', '0', 0, 'USt. Landwirtschaft', 0, NULL, NULL),
(56, 5, '', 19, '0', '0', '0', '0', 0, 'allgemeine Ust.', 1, NULL, NULL),
(61, 6, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(62, 6, '', 3.7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(63, 6, '', 2.5, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(64, 6, '', 7.7, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(71, 7, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(72, 7, '', 17.5, '0', '0', '0', '0', 0, 'VAT standard rate before 2011', 1, NULL, NULL),
(73, 7, '', 5, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(74, 7, '', 20, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(81, 8, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(82, 8, '', 23, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(83, 8, '', 13.5, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(84, 8, '', 9, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(85, 8, '', 4.8, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(91, 9, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(92, 9, '', 13, '0', '0', '0', '0', 0, 'VAT reduced rate 0', 1, NULL, NULL),
(93, 9, '', 3, '0', '0', '0', '0', 0, 'VAT super reduced rate 0', 1, NULL, NULL),
(94, 9, '', 17, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(101, 10, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(102, 10, '', 12, '0', '0', '0', '0', 0, 'VAT 12%', 1, NULL, NULL),
(103, 10, '', 18, '0', '0', '0', '0', 0, 'VAT 18%', 1, NULL, NULL),
(104, 10, '', 7.5, '0', '0', '0', '0', 0, 'VAT 6% Majoré à 25% (7.5%)', 1, NULL, NULL),
(105, 10, '', 15, '0', '0', '0', '0', 0, 'VAT 12% Majoré à 25% (15%)', 1, NULL, NULL),
(106, 10, '', 22.5, '0', '0', '0', '0', 0, 'VAT 18% Majoré à 25% (22.5%)', 1, NULL, NULL),
(107, 10, '', 6, '0', '0', '0', '0', 0, 'VAT 6%', 1, NULL, NULL),
(111, 11, '', 0, '0', '0', '0', '0', 0, 'No Sales Tax', 1, NULL, NULL),
(112, 11, '', 4, '0', '0', '0', '0', 0, 'Sales Tax 4%', 1, NULL, NULL),
(113, 11, '', 6, '0', '0', '0', '0', 0, 'Sales Tax 6%', 1, NULL, NULL),
(121, 12, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(122, 12, '', 14, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(123, 12, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(124, 12, '', 7, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(125, 12, '', 20, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(131, 13, '', 0, '0', '0', '0', '0', 0, 'TVA 0%', 1, NULL, NULL),
(132, 13, '', 9, '0', '0', '0', '0', 0, 'TVA 9%', 1, NULL, NULL),
(133, 13, '', 19, '0', '0', '0', '0', 0, 'TVA 19%', 1, NULL, NULL),
(141, 14, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(142, 14, '', 7, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(143, 14, '', 5, '9.975', '1', '0', '0', 0, 'GST/TPS and PST/TVQ rate for Province', 1, NULL, NULL),
(171, 17, '', 0, '0', '0', '0', '0', 0, '0 BTW tarief', 1, NULL, NULL),
(172, 17, '', 6, '0', '0', '0', '0', 0, 'Verlaagd BTW tarief', 1, NULL, NULL),
(173, 17, '', 19, '0', '0', '0', '0', 0, 'Algemeen BTW tarief', 1, NULL, NULL),
(174, 17, '', 21, '0', '0', '0', '0', 0, 'Algemeen BTW tarief (vanaf 1 oktober 2012)', 0, NULL, NULL),
(201, 20, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(202, 20, '', 12, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(203, 20, '', 6, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(204, 20, '', 25, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(211, 21, '', 0, '0', '0', '0', '0', 0, 'IVA Rate 0', 1, NULL, NULL),
(212, 21, '', 18, '7.5', '2', '0', '0', 0, 'IVA standard rate', 1, NULL, NULL),
(221, 22, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(222, 22, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(223, 22, '', 18, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(231, 23, '', 0, '0', '0', '0', '0', 0, 'IVA Rate 0', 1, NULL, NULL),
(232, 23, '', 10.5, '0', '0', '0', '0', 0, 'IVA reduced rate', 1, NULL, NULL),
(233, 23, '', 21, '0', '0', '0', '0', 0, 'IVA standard rate', 1, NULL, NULL),
(241, 24, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(242, 24, '', 19.25, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(251, 25, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(252, 25, '', 13, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(253, 25, '', 23, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(254, 25, '', 6, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(261, 26, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(262, 26, '', 5, '0', '0', '0', '0', 0, 'VAT Rate 5', 1, NULL, NULL),
(271, 27, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0 ou non applicable', 1, NULL, NULL),
(272, 27, '', 8.5, '0', '0', '0', '0', 0, 'VAT standard rate (DOM sauf Guyane et Saint-Martin)', 0, NULL, NULL),
(273, 27, '', 8.5, '0', '0', '0', '0', 1, 'VAT standard rate (DOM sauf Guyane et Saint-Martin), non perçu par le vendeur mais récupérable par acheteur', 0, NULL, NULL),
(274, 27, '', 5.5, '0', '0', '0', '0', 0, 'VAT reduced rate (France hors DOM-TOM)', 0, NULL, NULL),
(275, 27, '', 19.6, '0', '0', '0', '0', 0, 'VAT standard rate (France hors DOM-TOM)', 1, NULL, NULL),
(276, 27, '', 2.1, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(277, 27, '', 7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(281, 28, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(282, 28, '', 10, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(351, 35, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(352, 35, '', 7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(353, 35, '', 14, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(411, 41, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(412, 41, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(413, 41, '', 20, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(461, 46, '', 0, '0', '0', '0', '0', 0, 'No VAT', 1, NULL, NULL),
(462, 46, '', 15, '0', '0', '0', '0', 0, 'VAT 15%', 1, NULL, NULL),
(463, 46, '', 7.5, '0', '0', '0', '0', 0, 'VAT 7.5%', 1, NULL, NULL),
(561, 56, '', 0, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(591, 59, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(592, 59, '', 7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(593, 59, '', 20, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(671, 67, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(672, 67, '', 19, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(721, 72, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(722, 72, '', 18, '0.9', '1', '0', '0', 0, 'VAT Rate 18+0.9', 1, NULL, NULL),
(781, 78, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(782, 78, '', 9, '0', '0', '0', '0', 0, 'VAT Rate 9', 1, NULL, NULL),
(783, 78, '', 5, '0', '0', '0', '0', 0, 'VAT Rate 5', 1, NULL, NULL),
(784, 78, '', 19, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(801, 80, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(802, 80, '', 25, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(861, 86, '', 0, '0', '0', '0', '0', 0, 'SIN IVA', 1, NULL, NULL),
(862, 86, '', 13, '0', '0', '0', '0', 0, 'IVA 13', 1, NULL, NULL),
(1021, 102, '', 0, '0', '0', '0', '0', 0, 'Μηδενικό Φ.Π.Α.', 1, NULL, NULL),
(1022, 102, '', 24, '0', '0', '0', '0', 0, 'Κανονικός Φ.Π.Α.', 1, NULL, NULL),
(1023, 102, '', 13, '0', '0', '0', '0', 0, 'Μειωμένος Φ.Π.Α.', 1, NULL, NULL),
(1024, 102, '', 6, '0', '0', '0', '0', 0, 'Υπερμειωμένος Φ.Π.Α.', 1, NULL, NULL),
(1025, 102, '', 16, '0', '0', '0', '0', 0, 'Νήσων κανονικός Φ.Π.Α.', 1, NULL, NULL),
(1026, 102, '', 9, '0', '0', '0', '0', 0, 'Νήσων μειωμένος Φ.Π.Α.', 1, NULL, NULL),
(1027, 102, '', 4, '0', '0', '0', '0', 0, 'Νήσων υπερμειωμένος Φ.Π.Α.', 1, NULL, NULL),
(1028, 102, '', 17, '0', '0', '0', '0', 0, 'Νήσων υπερμειωμένος Φ.Π.Α.', 1, NULL, NULL),
(1141, 114, '', 0, '0', '0', '0', '0', 0, 'No ISV', 1, NULL, NULL),
(1142, 114, '', 12, '0', '0', '0', '0', 0, 'ISV 12%', 1, NULL, NULL),
(1161, 116, '', 0, '0', '0', '0', '0', 0, 'VAT rate 0', 1, NULL, NULL),
(1162, 116, '', 7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1163, 116, '', 25.5, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1171, 117, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 0, NULL, NULL),
(1172, 117, 'C+S-5', 0, '2.5', '1', '2.5', '1', 0, 'CGST+SGST - Same state sales', 1, NULL, NULL),
(1173, 117, 'I-5', 5, '0', '0', '0', '0', 0, 'IGST', 1, NULL, NULL),
(1174, 117, 'C+S-12', 0, '6', '1', '6', '1', 0, 'CGST+SGST - Same state sales', 1, NULL, NULL),
(1175, 117, 'I-12', 12, '0', '0', '0', '0', 0, 'IGST', 1, NULL, NULL),
(1176, 117, 'C+S-18', 0, '9', '1', '9', '1', 0, 'CGST+SGST - Same state sales', 1, NULL, NULL),
(1177, 117, 'I-18', 18, '0', '0', '0', '0', 0, 'IGST', 1, NULL, NULL),
(1178, 117, 'C+S-28', 0, '14', '1', '14', '1', 0, 'CGST+SGST - Same state sales', 1, NULL, NULL),
(1179, 117, 'I-28', 28, '0', '0', '0', '0', 0, 'IGST', 1, NULL, NULL),
(1231, 123, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1232, 123, '', 5, '0', '0', '0', '0', 0, 'VAT Rate 5', 1, NULL, NULL),
(1401, 140, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1402, 140, '', 14, '0', '0', '0', '0', 0, 'VAT intermediary rate', 1, NULL, NULL),
(1403, 140, '', 8, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1404, 140, '', 3, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(1405, 140, '', 17, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1481, 148, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1482, 148, '', 7, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1483, 148, '', 5, '0', '0', '0', '0', 0, 'VAT super-reduced rate', 1, NULL, NULL),
(1484, 148, '', 18, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1511, 151, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1512, 151, '', 14, '0', '0', '0', '0', 0, 'VAT Rate 14', 1, NULL, NULL),
(1521, 152, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1522, 152, '', 15, '0', '0', '0', '0', 0, 'VAT Rate 15', 1, NULL, NULL),
(1541, 154, '', 0, '0', '0', '0', '0', 0, 'No VAT', 1, NULL, NULL),
(1542, 154, '', 16, '0', '0', '0', '0', 0, 'VAT 16%', 1, NULL, NULL),
(1543, 154, '', 10, '0', '0', '0', '0', 0, 'VAT Frontero', 1, NULL, NULL),
(1651, 165, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1652, 165, '', 3, '0', '0', '0', '0', 0, 'VAT standard 3', 1, NULL, NULL),
(1653, 165, '', 6, '0', '0', '0', '0', 0, 'VAT standard 6', 1, NULL, NULL),
(1654, 165, '', 11, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1655, 165, '', 22, '0', '0', '0', '0', 0, 'VAT standard high', 1, NULL, NULL),
(1661, 166, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1662, 166, '', 15, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1691, 169, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1692, 169, '', 5, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1731, 173, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1732, 173, '', 14, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1733, 173, '', 8, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1734, 173, '', 25, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1781, 178, '', 0, '0', '0', '0', '0', 0, 'ITBMS Rate 0', 1, NULL, NULL),
(1782, 178, '', 7, '0', '0', '0', '0', 0, 'ITBMS standard rate', 1, NULL, NULL),
(1811, 181, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1818, 181, '', 18, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1841, 184, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1842, 184, '', 8, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1843, 184, '', 3, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1844, 184, '', 23, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1881, 188, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(1882, 188, '', 9, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1883, 188, '', 19, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(1884, 188, '', 5, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(1931, 193, '', 0, '0', '0', '0', '0', 0, 'No VAT in SPM', 1, NULL, NULL),
(2011, 201, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(2012, 201, '', 10, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(2013, 201, '', 19, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(2021, 202, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(2022, 202, '', 9.5, '0', '0', '0', '0', 0, 'VAT reduced rate', 1, NULL, NULL),
(2023, 202, '', 22, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(2051, 205, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(2052, 205, '', 15, '0', '0', '0', '0', 0, 'VAT standard rate', 1, NULL, NULL),
(2071, 207, '', 0, '0', '0', '0', '0', 0, 'VAT 0', 1, NULL, NULL),
(2072, 207, '', 15, '0', '0', '0', '0', 0, 'VAT 15%', 1, NULL, NULL),
(2131, 213, '', 0, '0', '0', '0', '0', 0, 'VAT 0', 1, NULL, NULL),
(2132, 213, '', 5, '0', '0', '0', '0', 0, 'VAT 5%', 1, NULL, NULL),
(2261, 226, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL),
(2262, 226, '', 20, '0', '0', '0', '0', 0, 'VAT standart rate', 1, NULL, NULL),
(2321, 232, '', 0, '0', '0', '0', '0', 0, 'No VAT', 1, NULL, NULL),
(2322, 232, '', 12, '0', '0', '0', '0', 0, 'VAT 12%', 1, NULL, NULL),
(2323, 232, '', 8, '0', '0', '0', '0', 0, 'VAT 8%', 1, NULL, NULL),
(2461, 246, '', 0, '0', '0', '0', '0', 0, 'VAT Rate 0', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_typent`
--

DROP TABLE IF EXISTS `jvm_c_typent`;
CREATE TABLE `jvm_c_typent` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_typent`
--

INSERT INTO `jvm_c_typent` (`id`, `code`, `libelle`, `fk_country`, `active`, `module`, `position`) VALUES
(0, 'TE_UNKNOWN', '-', NULL, 1, NULL, 0),
(1, 'TE_STARTUP', 'Start-up', NULL, 0, NULL, 0),
(2, 'TE_GROUP', 'Grand groupe', NULL, 1, NULL, 0),
(3, 'TE_MEDIUM', 'PME/PMI', NULL, 1, NULL, 0),
(4, 'TE_SMALL', 'TPE', NULL, 1, NULL, 0),
(5, 'TE_ADMIN', 'Administration', NULL, 1, NULL, 0),
(6, 'TE_WHOLE', 'Grossiste', NULL, 0, NULL, 0),
(7, 'TE_RETAIL', 'Revendeur', NULL, 0, NULL, 0),
(8, 'TE_PRIVATE', 'Particulier', NULL, 1, NULL, 0),
(100, 'TE_OTHER', 'Autres', NULL, 1, NULL, 0),
(231, 'TE_A_RI', 'Responsable Inscripto (typo A)', 23, 0, NULL, 0),
(232, 'TE_B_RNI', 'Responsable No Inscripto (typo B)', 23, 0, NULL, 0),
(233, 'TE_C_FE', 'Consumidor Final/Exento (typo C)', 23, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_type_contact`
--

DROP TABLE IF EXISTS `jvm_c_type_contact`;
CREATE TABLE `jvm_c_type_contact` (
  `rowid` int(11) NOT NULL,
  `element` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'external',
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_type_contact`
--

INSERT INTO `jvm_c_type_contact` (`rowid`, `element`, `source`, `code`, `libelle`, `active`, `module`, `position`) VALUES
(10, 'contrat', 'internal', 'SALESREPSIGN', 'Commercial signataire du contrat', 1, NULL, 0),
(11, 'contrat', 'internal', 'SALESREPFOLL', 'Commercial suivi du contrat', 1, NULL, 0),
(20, 'contrat', 'external', 'BILLING', 'Contact client facturation contrat', 1, NULL, 0),
(21, 'contrat', 'external', 'CUSTOMER', 'Contact client suivi contrat', 1, NULL, 0),
(22, 'contrat', 'external', 'SALESREPSIGN', 'Contact client signataire contrat', 1, NULL, 0),
(31, 'propal', 'internal', 'SALESREPFOLL', 'Commercial à l\'origine de la propale', 1, NULL, 0),
(40, 'propal', 'external', 'BILLING', 'Contact client facturation propale', 1, NULL, 0),
(41, 'propal', 'external', 'CUSTOMER', 'Contact client suivi propale', 1, NULL, 0),
(42, 'propal', 'external', 'SHIPPING', 'Contact client livraison propale', 1, NULL, 0),
(50, 'facture', 'internal', 'SALESREPFOLL', 'Responsable suivi du paiement', 1, NULL, 0),
(60, 'facture', 'external', 'BILLING', 'Contact client facturation', 1, NULL, 0),
(61, 'facture', 'external', 'SHIPPING', 'Contact client livraison', 1, NULL, 0),
(62, 'facture', 'external', 'SERVICE', 'Contact client prestation', 1, NULL, 0),
(70, 'invoice_supplier', 'internal', 'SALESREPFOLL', 'Responsable suivi du paiement', 1, NULL, 0),
(71, 'invoice_supplier', 'external', 'BILLING', 'Contact fournisseur facturation', 1, NULL, 0),
(72, 'invoice_supplier', 'external', 'SHIPPING', 'Contact fournisseur livraison', 1, NULL, 0),
(73, 'invoice_supplier', 'external', 'SERVICE', 'Contact fournisseur prestation', 1, NULL, 0),
(80, 'agenda', 'internal', 'ACTOR', 'Responsable', 1, NULL, 0),
(81, 'agenda', 'internal', 'GUEST', 'Guest', 1, NULL, 0),
(85, 'agenda', 'external', 'ACTOR', 'Responsable', 1, NULL, 0),
(86, 'agenda', 'external', 'GUEST', 'Guest', 1, NULL, 0),
(91, 'commande', 'internal', 'SALESREPFOLL', 'Responsable suivi de la commande', 1, NULL, 0),
(100, 'commande', 'external', 'BILLING', 'Contact client facturation commande', 1, NULL, 0),
(101, 'commande', 'external', 'CUSTOMER', 'Contact client suivi commande', 1, NULL, 0),
(102, 'commande', 'external', 'SHIPPING', 'Contact client livraison commande', 1, NULL, 0),
(110, 'supplier_proposal', 'internal', 'SALESREPFOLL', 'Responsable suivi de la demande', 1, NULL, 0),
(111, 'supplier_proposal', 'external', 'BILLING', 'Contact fournisseur facturation', 1, NULL, 0),
(112, 'supplier_proposal', 'external', 'SHIPPING', 'Contact fournisseur livraison', 1, NULL, 0),
(113, 'supplier_proposal', 'external', 'SERVICE', 'Contact fournisseur prestation', 1, NULL, 0),
(120, 'fichinter', 'internal', 'INTERREPFOLL', 'Responsable suivi de l\'intervention', 1, NULL, 0),
(121, 'fichinter', 'internal', 'INTERVENING', 'Intervenant', 1, NULL, 0),
(130, 'fichinter', 'external', 'BILLING', 'Contact client facturation intervention', 1, NULL, 0),
(131, 'fichinter', 'external', 'CUSTOMER', 'Contact client suivi de l\'intervention', 1, NULL, 0),
(140, 'order_supplier', 'internal', 'SALESREPFOLL', 'Responsable suivi de la commande', 1, NULL, 0),
(141, 'order_supplier', 'internal', 'SHIPPING', 'Responsable réception de la commande', 1, NULL, 0),
(142, 'order_supplier', 'external', 'BILLING', 'Contact fournisseur facturation commande', 1, NULL, 0),
(143, 'order_supplier', 'external', 'CUSTOMER', 'Contact fournisseur suivi commande', 1, NULL, 0),
(145, 'order_supplier', 'external', 'SHIPPING', 'Contact fournisseur livraison commande', 1, NULL, 0),
(150, 'dolresource', 'internal', 'USERINCHARGE', 'In charge of resource', 1, NULL, 0),
(151, 'dolresource', 'external', 'THIRDINCHARGE', 'In charge of resource', 1, NULL, 0),
(155, 'ticket', 'internal', 'SUPPORTTEC', 'Utilisateur contact support', 1, NULL, 0),
(156, 'ticket', 'internal', 'CONTRIBUTOR', 'Intervenant', 1, NULL, 0),
(157, 'ticket', 'external', 'SUPPORTCLI', 'Contact client suivi incident', 1, NULL, 0),
(158, 'ticket', 'external', 'CONTRIBUTOR', 'Intervenant', 1, NULL, 0),
(160, 'project', 'internal', 'PROJECTLEADER', 'Chef de Projet', 1, NULL, 0),
(161, 'project', 'internal', 'PROJECTCONTRIBUTOR', 'Intervenant', 1, NULL, 0),
(170, 'project', 'external', 'PROJECTLEADER', 'Chef de Projet', 1, NULL, 0),
(171, 'project', 'external', 'PROJECTCONTRIBUTOR', 'Intervenant', 1, NULL, 0),
(180, 'project_task', 'internal', 'TASKEXECUTIVE', 'Responsable', 1, NULL, 0),
(181, 'project_task', 'internal', 'TASKCONTRIBUTOR', 'Intervenant', 1, NULL, 0),
(190, 'project_task', 'external', 'TASKEXECUTIVE', 'Responsable', 1, NULL, 0),
(191, 'project_task', 'external', 'TASKCONTRIBUTOR', 'Intervenant', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_type_container`
--

DROP TABLE IF EXISTS `jvm_c_type_container`;
CREATE TABLE `jvm_c_type_container` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_type_container`
--

INSERT INTO `jvm_c_type_container` (`rowid`, `code`, `entity`, `label`, `module`, `active`) VALUES
(1, 'page', 1, 'Page', 'system', 1),
(2, 'banner', 1, 'Banner', 'system', 1),
(3, 'blogpost', 1, 'BlogPost', 'system', 1),
(4, 'menu', 1, 'Menu', 'system', 1),
(5, 'other', 1, 'Other', 'system', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_type_fees`
--

DROP TABLE IF EXISTS `jvm_c_type_fees`;
CREATE TABLE `jvm_c_type_fees` (
  `id` int(11) NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `accountancy_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_type_fees`
--

INSERT INTO `jvm_c_type_fees` (`id`, `code`, `label`, `type`, `accountancy_code`, `active`, `module`, `position`) VALUES
(1, 'TF_OTHER', 'Other', 0, NULL, 1, NULL, 0),
(2, 'TF_TRIP', 'Transportation', 0, NULL, 1, NULL, 0),
(3, 'TF_LUNCH', 'Lunch', 0, NULL, 1, NULL, 0),
(4, 'EX_KME', 'ExpLabelKm', 0, NULL, 1, NULL, 0),
(5, 'EX_FUE', 'ExpLabelFuelCV', 0, NULL, 0, NULL, 0),
(6, 'EX_HOT', 'ExpLabelHotel', 0, NULL, 0, NULL, 0),
(7, 'EX_PAR', 'ExpLabelParkingCV', 0, NULL, 0, NULL, 0),
(8, 'EX_TOL', 'ExpLabelTollCV', 0, NULL, 0, NULL, 0),
(9, 'EX_TAX', 'ExpLabelVariousTaxes', 0, NULL, 0, NULL, 0),
(10, 'EX_IND', 'ExpLabelIndemnityTransSubscrip', 0, NULL, 0, NULL, 0),
(11, 'EX_SUM', 'ExpLabelMaintenanceSupply', 0, NULL, 0, NULL, 0),
(12, 'EX_SUO', 'ExpLabelOfficeSupplies', 0, NULL, 0, NULL, 0),
(13, 'EX_CAR', 'ExpLabelCarRental', 0, NULL, 0, NULL, 0),
(14, 'EX_DOC', 'ExpLabelDocumentation', 0, NULL, 0, NULL, 0),
(15, 'EX_CUR', 'ExpLabelCustomersReceiving', 0, NULL, 0, NULL, 0),
(16, 'EX_OTR', 'ExpLabelOtherReceiving', 0, NULL, 0, NULL, 0),
(17, 'EX_POS', 'ExpLabelPostage', 0, NULL, 0, NULL, 0),
(18, 'EX_CAM', 'ExpLabelMaintenanceRepairCV', 0, NULL, 0, NULL, 0),
(19, 'EX_EMM', 'ExpLabelEmployeesMeal', 0, NULL, 0, NULL, 0),
(20, 'EX_GUM', 'ExpLabelGuestsMeal', 0, NULL, 0, NULL, 0),
(21, 'EX_BRE', 'ExpLabelBreakfast', 0, NULL, 0, NULL, 0),
(22, 'EX_FUE_VP', 'ExpLabelFuelPV', 0, NULL, 0, NULL, 0),
(23, 'EX_TOL_VP', 'ExpLabelTollPV', 0, NULL, 0, NULL, 0),
(24, 'EX_PAR_VP', 'ExpLabelParkingPV', 0, NULL, 0, NULL, 0),
(25, 'EX_CAM_VP', 'ExpLabelMaintenanceRepairPV', 0, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_type_resource`
--

DROP TABLE IF EXISTS `jvm_c_type_resource`;
CREATE TABLE `jvm_c_type_resource` (
  `rowid` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_type_resource`
--

INSERT INTO `jvm_c_type_resource` (`rowid`, `code`, `label`, `active`) VALUES
(1, 'RES_ROOMS', 'Rooms', 1),
(2, 'RES_CARS', 'Cars', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_units`
--

DROP TABLE IF EXISTS `jvm_c_units`;
CREATE TABLE `jvm_c_units` (
  `rowid` int(11) NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `scale` int(11) DEFAULT NULL,
  `label` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_label` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_c_units`
--

INSERT INTO `jvm_c_units` (`rowid`, `code`, `scale`, `label`, `short_label`, `unit_type`, `active`) VALUES
(1, 'T', 3, 'WeightUnitton', 'T', 'weight', 1),
(2, 'KG', 0, 'WeightUnitkg', 'kg', 'weight', 1),
(3, 'G', -3, 'WeightUnitg', 'g', 'weight', 1),
(4, 'MG', -6, 'WeightUnitmg', 'mg', 'weight', 1),
(5, 'OZ', 98, 'WeightUnitounce', 'Oz', 'weight', 1),
(6, 'LB', 99, 'WeightUnitpound', 'lb', 'weight', 1),
(7, 'M', 0, 'SizeUnitm', 'm', 'size', 1),
(8, 'DM', -1, 'SizeUnitdm', 'dm', 'size', 1),
(9, 'CM', -2, 'SizeUnitcm', 'cm', 'size', 1),
(10, 'MM', -3, 'SizeUnitmm', 'mm', 'size', 1),
(11, 'FT', 98, 'SizeUnitfoot', 'ft', 'size', 1),
(12, 'IN', 99, 'SizeUnitinch', 'in', 'size', 1),
(13, 'M2', 0, 'SurfaceUnitm2', 'm2', 'surface', 1),
(14, 'DM2', -2, 'SurfaceUnitdm2', 'dm2', 'surface', 1),
(15, 'CM2', -4, 'SurfaceUnitcm2', 'cm2', 'surface', 1),
(16, 'MM2', -6, 'SurfaceUnitmm2', 'mm2', 'surface', 1),
(17, 'FT2', 98, 'SurfaceUnitfoot2', 'ft2', 'surface', 1),
(18, 'IN2', 99, 'SurfaceUnitinch2', 'in2', 'surface', 1),
(19, 'M3', 0, 'VolumeUnitm3', 'm3', 'volume', 1),
(20, 'DM3', -3, 'VolumeUnitdm3', 'dm3', 'volume', 1),
(21, 'CM3', -6, 'VolumeUnitcm3', 'cm3', 'volume', 1),
(22, 'MM3', -9, 'VolumeUnitmm3', 'mm3', 'volume', 1),
(23, 'FT3', 88, 'VolumeUnitfoot3', 'ft3', 'volume', 1),
(24, 'IN3', 89, 'VolumeUnitinch3', 'in3', 'volume', 1),
(25, 'OZ3', 97, 'VolumeUnitounce', 'Oz', 'volume', 1),
(26, 'L', 98, 'VolumeUnitlitre', 'L', 'volume', 1),
(27, 'GAL', 99, 'VolumeUnitgallon', 'gal', 'volume', 1),
(28, 'P', 0, 'Piece', 'p', 'qty', 1),
(29, 'SET', 0, 'Set', 'set', 'qty', 1),
(30, 'S', 0, 'second', 's', 'time', 1),
(31, 'MI', 60, 'minute', 'i', 'time', 1),
(32, 'H', 3600, 'hour', 'h', 'time', 1),
(33, 'D', 86400, 'day', 'd', 'time', 1),
(34, 'W', 604800, 'week', 'w', 'time', 1),
(35, 'MO', 2629800, 'month', 'm', 'time', 1),
(36, 'Y', 31557600, 'year', 'y', 'time', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_c_ziptown`
--

DROP TABLE IF EXISTS `jvm_c_ziptown`;
CREATE TABLE `jvm_c_ziptown` (
  `rowid` int(11) NOT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_county` int(11) DEFAULT NULL,
  `fk_pays` int(11) NOT NULL DEFAULT '0',
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `town` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_default_values`
--

DROP TABLE IF EXISTS `jvm_default_values`;
CREATE TABLE `jvm_default_values` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `page` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `param` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_delivery`
--

DROP TABLE IF EXISTS `jvm_delivery`;
CREATE TABLE `jvm_delivery` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_customer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `fk_address` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_deliverydet`
--

DROP TABLE IF EXISTS `jvm_deliverydet`;
CREATE TABLE `jvm_deliverydet` (
  `rowid` int(11) NOT NULL,
  `fk_delivery` int(11) DEFAULT NULL,
  `fk_origin_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `qty` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_deliverydet_extrafields`
--

DROP TABLE IF EXISTS `jvm_deliverydet_extrafields`;
CREATE TABLE `jvm_deliverydet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_delivery_extrafields`
--

DROP TABLE IF EXISTS `jvm_delivery_extrafields`;
CREATE TABLE `jvm_delivery_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_deplacement`
--

DROP TABLE IF EXISTS `jvm_deplacement`;
CREATE TABLE `jvm_deplacement` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dated` datetime DEFAULT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `type` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `fk_statut` int(11) NOT NULL DEFAULT '1',
  `km` double DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT '0',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_document_model`
--

DROP TABLE IF EXISTS `jvm_document_model`;
CREATE TABLE `jvm_document_model` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_document_model`
--

INSERT INTO `jvm_document_model` (`rowid`, `nom`, `entity`, `type`, `libelle`, `description`) VALUES
(1, 'standard', 1, 'member', NULL, NULL),
(2, 'azur', 1, 'propal', NULL, NULL),
(3, 'einstein', 1, 'order', NULL, NULL),
(4, 'muscadet', 1, 'order_supplier', NULL, NULL),
(5, 'aurore', 1, 'supplier_proposal', NULL, NULL),
(6, 'crabe', 1, 'invoice', NULL, NULL),
(7, 'standard', 1, 'stock', NULL, NULL),
(8, 'stdmovement', 1, 'mouvement', NULL, NULL),
(9, 'rouget', 1, 'shipping', NULL, NULL),
(10, 'typhon', 1, 'delivery', NULL, NULL),
(11, '', 1, 'task', NULL, NULL),
(12, 'beluga', 1, 'project', NULL, NULL),
(13, 'baleine', 1, 'project', NULL, NULL),
(15, 'TICKET_ADDON_PDF_ODT_PATH', 1, 'ticket', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_don`
--

DROP TABLE IF EXISTS `jvm_don`;
CREATE TABLE `jvm_don` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `datedon` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `fk_payment` int(11) DEFAULT NULL,
  `paid` smallint(6) NOT NULL DEFAULT '0',
  `fk_soc` int(11) DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `societe` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `zip` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_country` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public` smallint(6) NOT NULL DEFAULT '1',
  `fk_projet` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_don_extrafields`
--

DROP TABLE IF EXISTS `jvm_don_extrafields`;
CREATE TABLE `jvm_don_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ecm_directories`
--

DROP TABLE IF EXISTS `jvm_ecm_directories`;
CREATE TABLE `jvm_ecm_directories` (
  `rowid` int(11) NOT NULL,
  `label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_parent` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cachenbofdoc` int(11) NOT NULL DEFAULT '0',
  `fullpath` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_c` int(11) DEFAULT NULL,
  `fk_user_m` int(11) DEFAULT NULL,
  `acl` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ecm_directories_extrafields`
--

DROP TABLE IF EXISTS `jvm_ecm_directories_extrafields`;
CREATE TABLE `jvm_ecm_directories_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ecm_files`
--

DROP TABLE IF EXISTS `jvm_ecm_files`;
CREATE TABLE `jvm_ecm_files` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `share` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `filepath` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `src_object_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `src_object_id` int(11) DEFAULT NULL,
  `fullpath_orig` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `keywords` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover` text COLLATE utf8_unicode_ci,
  `position` int(11) DEFAULT NULL,
  `gen_or_uploaded` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_c` int(11) DEFAULT NULL,
  `fk_user_m` int(11) DEFAULT NULL,
  `acl` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_ecm_files`
--

INSERT INTO `jvm_ecm_files` (`rowid`, `ref`, `label`, `share`, `entity`, `filepath`, `filename`, `src_object_type`, `src_object_id`, `fullpath_orig`, `description`, `keywords`, `cover`, `position`, `gen_or_uploaded`, `extraparams`, `date_c`, `tms`, `fk_user_c`, `fk_user_m`, `acl`) VALUES
(1, 'c292fdb3409e2cfb444f640fbc9728d4', 'c549168623d177de161eeaa2eb056237', NULL, 1, 'users/1', 'blue-star-limited-logo-vector.png', NULL, NULL, '/home/microcrm/jvmd.microcrm.in/documents/users/1/blue-star-limited-logo-vector.png', '', NULL, NULL, 1, 'unknown', NULL, '2021-01-22 07:52:09', '2021-01-22 07:52:09', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ecm_files_extrafields`
--

DROP TABLE IF EXISTS `jvm_ecm_files_extrafields`;
CREATE TABLE `jvm_ecm_files_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_element_contact`
--

DROP TABLE IF EXISTS `jvm_element_contact`;
CREATE TABLE `jvm_element_contact` (
  `rowid` int(11) NOT NULL,
  `datecreate` datetime DEFAULT NULL,
  `statut` smallint(6) DEFAULT '5',
  `element_id` int(11) NOT NULL,
  `fk_c_type_contact` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_element_element`
--

DROP TABLE IF EXISTS `jvm_element_element`;
CREATE TABLE `jvm_element_element` (
  `rowid` int(11) NOT NULL,
  `fk_source` int(11) NOT NULL,
  `sourcetype` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fk_target` int(11) NOT NULL,
  `targettype` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_element_resources`
--

DROP TABLE IF EXISTS `jvm_element_resources`;
CREATE TABLE `jvm_element_resources` (
  `rowid` int(11) NOT NULL,
  `element_id` int(11) DEFAULT NULL,
  `element_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `resource_type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `busy` int(11) DEFAULT NULL,
  `mandatory` int(11) DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `fk_user_create` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_emailcollector_emailcollector`
--

DROP TABLE IF EXISTS `jvm_emailcollector_emailcollector`;
CREATE TABLE `jvm_emailcollector_emailcollector` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hostcharset` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'UTF-8',
  `login` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_directory` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target_directory` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maxemailpercollect` int(11) DEFAULT '100',
  `datelastresult` datetime DEFAULT NULL,
  `codelastresult` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastresult` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datelastok` datetime DEFAULT NULL,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_emailcollector_emailcollectoraction`
--

DROP TABLE IF EXISTS `jvm_emailcollector_emailcollectoraction`;
CREATE TABLE `jvm_emailcollector_emailcollectoraction` (
  `rowid` int(11) NOT NULL,
  `fk_emailcollector` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `actionparam` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_emailcollector_emailcollectorfilter`
--

DROP TABLE IF EXISTS `jvm_emailcollector_emailcollectorfilter`;
CREATE TABLE `jvm_emailcollector_emailcollectorfilter` (
  `rowid` int(11) NOT NULL,
  `fk_emailcollector` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `rulevalue` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_entrepot`
--

DROP TABLE IF EXISTS `jvm_entrepot`;
CREATE TABLE `jvm_entrepot` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `entity` int(11) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8_unicode_ci,
  `lieu` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_departement` int(11) DEFAULT NULL,
  `fk_pays` int(11) DEFAULT '0',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` tinyint(4) DEFAULT '1',
  `fk_user_author` int(11) DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_parent` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_entrepot_extrafields`
--

DROP TABLE IF EXISTS `jvm_entrepot_extrafields`;
CREATE TABLE `jvm_entrepot_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_establishment`
--

DROP TABLE IF EXISTS `jvm_establishment`;
CREATE TABLE `jvm_establishment` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_state` int(11) DEFAULT '0',
  `fk_country` int(11) DEFAULT '0',
  `profid1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profid2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profid3` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_mod` int(11) DEFAULT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_events`
--

DROP TABLE IF EXISTS `jvm_events`;
CREATE TABLE `jvm_events` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `prefix_session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateevent` datetime DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_object` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_event_element`
--

DROP TABLE IF EXISTS `jvm_event_element`;
CREATE TABLE `jvm_event_element` (
  `rowid` int(11) NOT NULL,
  `fk_source` int(11) NOT NULL,
  `fk_target` int(11) NOT NULL,
  `targettype` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expedition`
--

DROP TABLE IF EXISTS `jvm_expedition`;
CREATE TABLE `jvm_expedition` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_customer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `date_expedition` datetime DEFAULT NULL,
  `fk_address` int(11) DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tracking_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `billed` smallint(6) DEFAULT '0',
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `size` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expeditiondet`
--

DROP TABLE IF EXISTS `jvm_expeditiondet`;
CREATE TABLE `jvm_expeditiondet` (
  `rowid` int(11) NOT NULL,
  `fk_expedition` int(11) NOT NULL,
  `fk_origin_line` int(11) DEFAULT NULL,
  `fk_entrepot` int(11) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expeditiondet_batch`
--

DROP TABLE IF EXISTS `jvm_expeditiondet_batch`;
CREATE TABLE `jvm_expeditiondet_batch` (
  `rowid` int(11) NOT NULL,
  `fk_expeditiondet` int(11) NOT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `fk_origin_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expeditiondet_extrafields`
--

DROP TABLE IF EXISTS `jvm_expeditiondet_extrafields`;
CREATE TABLE `jvm_expeditiondet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expedition_extrafields`
--

DROP TABLE IF EXISTS `jvm_expedition_extrafields`;
CREATE TABLE `jvm_expedition_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expedition_package`
--

DROP TABLE IF EXISTS `jvm_expedition_package`;
CREATE TABLE `jvm_expedition_package` (
  `rowid` int(11) NOT NULL,
  `fk_expedition` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` double(24,8) DEFAULT '0.00000000',
  `fk_package_type` int(11) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `size` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `dangerous_goods` smallint(6) DEFAULT '0',
  `tail_lift` smallint(6) DEFAULT '0',
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expensereport`
--

DROP TABLE IF EXISTS `jvm_expensereport`;
CREATE TABLE `jvm_expensereport` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_number_int` int(11) DEFAULT NULL,
  `ref_ext` int(11) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `date_create` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `date_refuse` datetime DEFAULT NULL,
  `date_cancel` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_author` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_validator` int(11) DEFAULT NULL,
  `fk_user_approve` int(11) DEFAULT NULL,
  `fk_user_refuse` int(11) DEFAULT NULL,
  `fk_user_cancel` int(11) DEFAULT NULL,
  `fk_statut` int(11) NOT NULL,
  `fk_c_paiement` int(11) DEFAULT NULL,
  `paid` smallint(6) NOT NULL DEFAULT '0',
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `detail_refuse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detail_cancel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `integration_compta` int(11) DEFAULT NULL,
  `fk_bank_account` int(11) DEFAULT NULL,
  `model_pdf` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expensereport_det`
--

DROP TABLE IF EXISTS `jvm_expensereport_det`;
CREATE TABLE `jvm_expensereport_det` (
  `rowid` int(11) NOT NULL,
  `fk_expensereport` int(11) NOT NULL,
  `docnumber` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_c_type_fees` int(11) NOT NULL,
  `fk_c_exp_tax_cat` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `product_type` int(11) DEFAULT '-1',
  `qty` double NOT NULL,
  `subprice` double(24,8) NOT NULL DEFAULT '0.00000000',
  `value_unit` double(24,8) NOT NULL,
  `remise_percent` double DEFAULT NULL,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_ht` double(24,8) NOT NULL DEFAULT '0.00000000',
  `total_tva` double(24,8) NOT NULL DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) NOT NULL DEFAULT '0.00000000',
  `date` date NOT NULL,
  `info_bits` int(11) DEFAULT '0',
  `special_code` int(11) DEFAULT '0',
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000',
  `fk_facture` int(11) DEFAULT '0',
  `fk_ecm_files` int(11) DEFAULT NULL,
  `fk_code_ventilation` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_warning_message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expensereport_extrafields`
--

DROP TABLE IF EXISTS `jvm_expensereport_extrafields`;
CREATE TABLE `jvm_expensereport_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expensereport_ik`
--

DROP TABLE IF EXISTS `jvm_expensereport_ik`;
CREATE TABLE `jvm_expensereport_ik` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_c_exp_tax_cat` int(11) NOT NULL DEFAULT '0',
  `fk_range` int(11) NOT NULL DEFAULT '0',
  `coef` double NOT NULL DEFAULT '0',
  `ikoffset` double NOT NULL DEFAULT '0',
  `active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_expensereport_ik`
--

INSERT INTO `jvm_expensereport_ik` (`rowid`, `datec`, `tms`, `fk_c_exp_tax_cat`, `fk_range`, `coef`, `ikoffset`, `active`) VALUES
(1, NULL, '2021-01-22 06:42:01', 4, 1, 0.41, 0, 1),
(2, NULL, '2021-01-22 06:42:01', 4, 2, 0.244, 824, 1),
(3, NULL, '2021-01-22 06:42:01', 4, 3, 0.286, 0, 1),
(4, NULL, '2021-01-22 06:42:01', 5, 4, 0.493, 0, 1),
(5, NULL, '2021-01-22 06:42:01', 5, 5, 0.277, 1082, 1),
(6, NULL, '2021-01-22 06:42:01', 5, 6, 0.332, 0, 1),
(7, NULL, '2021-01-22 06:42:01', 6, 7, 0.543, 0, 1),
(8, NULL, '2021-01-22 06:42:01', 6, 8, 0.305, 1180, 1),
(9, NULL, '2021-01-22 06:42:01', 6, 9, 0.364, 0, 1),
(10, NULL, '2021-01-22 06:42:01', 7, 10, 0.568, 0, 1),
(11, NULL, '2021-01-22 06:42:01', 7, 11, 0.32, 1244, 1),
(12, NULL, '2021-01-22 06:42:01', 7, 12, 0.382, 0, 1),
(13, NULL, '2021-01-22 06:42:01', 8, 13, 0.595, 0, 1),
(14, NULL, '2021-01-22 06:42:01', 8, 14, 0.337, 1288, 1),
(15, NULL, '2021-01-22 06:42:01', 8, 15, 0.401, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_expensereport_rules`
--

DROP TABLE IF EXISTS `jvm_expensereport_rules`;
CREATE TABLE `jvm_expensereport_rules` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dates` datetime NOT NULL,
  `datee` datetime NOT NULL,
  `amount` double(24,8) NOT NULL,
  `restrictive` tinyint(4) NOT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_usergroup` int(11) DEFAULT NULL,
  `fk_c_type_fees` int(11) NOT NULL,
  `code_expense_rules_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_for_all` tinyint(4) DEFAULT '0',
  `entity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_export_compta`
--

DROP TABLE IF EXISTS `jvm_export_compta`;
CREATE TABLE `jvm_export_compta` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `date_export` datetime NOT NULL,
  `fk_user` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_export_model`
--

DROP TABLE IF EXISTS `jvm_export_model`;
CREATE TABLE `jvm_export_model` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL DEFAULT '0',
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `field` text COLLATE utf8_unicode_ci NOT NULL,
  `filter` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_extrafields`
--

DROP TABLE IF EXISTS `jvm_extrafields`;
CREATE TABLE `jvm_extrafields` (
  `rowid` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `elementtype` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fieldcomputed` text COLLATE utf8_unicode_ci,
  `fielddefault` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fieldunique` int(11) DEFAULT '0',
  `fieldrequired` int(11) DEFAULT '0',
  `perms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos` int(11) DEFAULT '0',
  `alwayseditable` int(11) DEFAULT '0',
  `param` text COLLATE utf8_unicode_ci,
  `list` varchar(255) COLLATE utf8_unicode_ci DEFAULT '1',
  `printable` int(11) DEFAULT '0',
  `totalizable` tinyint(1) DEFAULT '0',
  `langs` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `help` text COLLATE utf8_unicode_ci,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture`
--

DROP TABLE IF EXISTS `jvm_facture`;
CREATE TABLE `jvm_facture` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_client` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `datef` date DEFAULT NULL,
  `date_pointoftax` date DEFAULT NULL,
  `date_valid` date DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_closing` datetime DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT '0',
  `remise_percent` double DEFAULT '0',
  `remise_absolue` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `close_code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `close_note` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `revenuestamp` double(24,8) DEFAULT '0.00000000',
  `total` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_closing` int(11) DEFAULT NULL,
  `module_source` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_source` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_fac_rec_source` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `increment` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_cond_reglement` int(11) NOT NULL DEFAULT '1',
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_lim_reglement` date DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_mode_transport` int(11) DEFAULT NULL,
  `situation_cycle_ref` smallint(6) DEFAULT NULL,
  `situation_counter` smallint(6) DEFAULT NULL,
  `situation_final` smallint(6) DEFAULT NULL,
  `retained_warranty` double DEFAULT NULL,
  `retained_warranty_date_limit` date DEFAULT NULL,
  `retained_warranty_fk_cond_reglement` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facturedet`
--

DROP TABLE IF EXISTS `jvm_facturedet`;
CREATE TABLE `jvm_facturedet` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `fk_remise_except` int(11) DEFAULT NULL,
  `subprice` double(24,8) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `fk_contract_line` int(11) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_code_ventilation` int(11) NOT NULL DEFAULT '0',
  `situation_percent` double DEFAULT '100',
  `fk_prev_id` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facturedet_extrafields`
--

DROP TABLE IF EXISTS `jvm_facturedet_extrafields`;
CREATE TABLE `jvm_facturedet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facturedet_rec`
--

DROP TABLE IF EXISTS `jvm_facturedet_rec`;
CREATE TABLE `jvm_facturedet_rec` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `product_type` int(11) DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `subprice` double(24,8) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT NULL,
  `date_start_fill` int(11) DEFAULT '0',
  `date_end_fill` int(11) DEFAULT '0',
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(10) UNSIGNED DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `fk_contract_line` int(11) DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facturedet_rec_extrafields`
--

DROP TABLE IF EXISTS `jvm_facturedet_rec_extrafields`;
CREATE TABLE `jvm_facturedet_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_extrafields`
--

DROP TABLE IF EXISTS `jvm_facture_extrafields`;
CREATE TABLE `jvm_facture_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_fourn`
--

DROP TABLE IF EXISTS `jvm_facture_fourn`;
CREATE TABLE `jvm_facture_fourn` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `ref_supplier` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `datef` date DEFAULT NULL,
  `date_pointoftax` date DEFAULT NULL,
  `date_valid` date DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paye` smallint(6) NOT NULL DEFAULT '0',
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `remise` double(24,8) DEFAULT '0.00000000',
  `close_code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `close_note` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `date_lim_reglement` date DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_mode_transport` int(11) DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_fourn_det`
--

DROP TABLE IF EXISTS `jvm_facture_fourn_det`;
CREATE TABLE `jvm_facture_fourn_det` (
  `rowid` int(11) NOT NULL,
  `fk_facture_fourn` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `pu_ht` double(24,8) DEFAULT NULL,
  `pu_ttc` double(24,8) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_ht` double(24,8) DEFAULT NULL,
  `tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `fk_code_ventilation` int(11) NOT NULL DEFAULT '0',
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_fourn_det_extrafields`
--

DROP TABLE IF EXISTS `jvm_facture_fourn_det_extrafields`;
CREATE TABLE `jvm_facture_fourn_det_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_fourn_extrafields`
--

DROP TABLE IF EXISTS `jvm_facture_fourn_extrafields`;
CREATE TABLE `jvm_facture_fourn_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_rec`
--

DROP TABLE IF EXISTS `jvm_facture_rec`;
CREATE TABLE `jvm_facture_rec` (
  `rowid` int(11) NOT NULL,
  `titre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `suspended` int(11) DEFAULT '0',
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `remise` double DEFAULT '0',
  `remise_percent` double DEFAULT '0',
  `remise_absolue` double DEFAULT '0',
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `revenuestamp` double(24,8) DEFAULT '0.00000000',
  `total` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_cond_reglement` int(11) NOT NULL DEFAULT '1',
  `fk_mode_reglement` int(11) DEFAULT '0',
  `date_lim_reglement` date DEFAULT NULL,
  `fk_account` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `modelpdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000',
  `usenewprice` int(11) DEFAULT '0',
  `frequency` int(11) DEFAULT NULL,
  `unit_frequency` varchar(2) COLLATE utf8_unicode_ci DEFAULT 'm',
  `date_when` datetime DEFAULT NULL,
  `date_last_gen` datetime DEFAULT NULL,
  `nb_gen_done` int(11) DEFAULT NULL,
  `nb_gen_max` int(11) DEFAULT NULL,
  `auto_validate` int(11) DEFAULT '0',
  `generate_pdf` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_facture_rec_extrafields`
--

DROP TABLE IF EXISTS `jvm_facture_rec_extrafields`;
CREATE TABLE `jvm_facture_rec_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinter`
--

DROP TABLE IF EXISTS `jvm_fichinter`;
CREATE TABLE `jvm_fichinter` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT '0',
  `fk_contrat` int(11) DEFAULT '0',
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `datei` date DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `dateo` date DEFAULT NULL,
  `datee` date DEFAULT NULL,
  `datet` date DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinterdet`
--

DROP TABLE IF EXISTS `jvm_fichinterdet`;
CREATE TABLE `jvm_fichinterdet` (
  `rowid` int(11) NOT NULL,
  `fk_fichinter` int(11) DEFAULT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `duree` int(11) DEFAULT NULL,
  `rang` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinterdet_extrafields`
--

DROP TABLE IF EXISTS `jvm_fichinterdet_extrafields`;
CREATE TABLE `jvm_fichinterdet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinterdet_rec`
--

DROP TABLE IF EXISTS `jvm_fichinterdet_rec`;
CREATE TABLE `jvm_fichinterdet_rec` (
  `rowid` int(11) NOT NULL,
  `fk_fichinter` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `duree` int(11) DEFAULT NULL,
  `rang` int(11) DEFAULT '0',
  `total_ht` double(24,8) DEFAULT NULL,
  `subprice` double(24,8) DEFAULT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_tx` double(6,3) DEFAULT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `fk_remise_except` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT NULL,
  `total_tva` double(24,8) DEFAULT NULL,
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT NULL,
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `fk_code_ventilation` int(11) NOT NULL DEFAULT '0',
  `fk_export_commpta` int(11) NOT NULL DEFAULT '0',
  `special_code` int(10) UNSIGNED DEFAULT '0',
  `fk_unit` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinter_extrafields`
--

DROP TABLE IF EXISTS `jvm_fichinter_extrafields`;
CREATE TABLE `jvm_fichinter_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_fichinter_rec`
--

DROP TABLE IF EXISTS `jvm_fichinter_rec`;
CREATE TABLE `jvm_fichinter_rec` (
  `rowid` int(11) NOT NULL,
  `titre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `fk_contrat` int(11) DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `duree` double DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `modelpdf` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `frequency` int(11) DEFAULT NULL,
  `unit_frequency` varchar(2) COLLATE utf8_unicode_ci DEFAULT 'm',
  `date_when` datetime DEFAULT NULL,
  `date_last_gen` datetime DEFAULT NULL,
  `nb_gen_done` int(11) DEFAULT NULL,
  `nb_gen_max` int(11) DEFAULT NULL,
  `auto_validate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_holiday`
--

DROP TABLE IF EXISTS `jvm_holiday`;
CREATE TABLE `jvm_holiday` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_user` int(11) NOT NULL,
  `fk_user_create` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_type` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `halfday` int(11) DEFAULT '0',
  `statut` int(11) NOT NULL DEFAULT '1',
  `fk_validator` int(11) NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_refuse` datetime DEFAULT NULL,
  `fk_user_refuse` int(11) DEFAULT NULL,
  `date_cancel` datetime DEFAULT NULL,
  `fk_user_cancel` int(11) DEFAULT NULL,
  `detail_refuse` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_holiday_config`
--

DROP TABLE IF EXISTS `jvm_holiday_config`;
CREATE TABLE `jvm_holiday_config` (
  `rowid` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_holiday_config`
--

INSERT INTO `jvm_holiday_config` (`rowid`, `name`, `value`) VALUES
(1, 'lastUpdate', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_holiday_extrafields`
--

DROP TABLE IF EXISTS `jvm_holiday_extrafields`;
CREATE TABLE `jvm_holiday_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_holiday_logs`
--

DROP TABLE IF EXISTS `jvm_holiday_logs`;
CREATE TABLE `jvm_holiday_logs` (
  `rowid` int(11) NOT NULL,
  `date_action` datetime NOT NULL,
  `fk_user_action` int(11) NOT NULL,
  `fk_user_update` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL,
  `type_action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prev_solde` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_solde` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_holiday_users`
--

DROP TABLE IF EXISTS `jvm_holiday_users`;
CREATE TABLE `jvm_holiday_users` (
  `fk_user` int(11) NOT NULL,
  `fk_type` int(11) NOT NULL,
  `nb_holiday` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_import_model`
--

DROP TABLE IF EXISTS `jvm_import_model`;
CREATE TABLE `jvm_import_model` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL DEFAULT '0',
  `label` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `field` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_intracommreport`
--

DROP TABLE IF EXISTS `jvm_intracommreport`;
CREATE TABLE `jvm_intracommreport` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `type_declaration` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periods` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_xml` text COLLATE utf8_unicode_ci,
  `type_export` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_inventory`
--

DROP TABLE IF EXISTS `jvm_inventory`;
CREATE TABLE `jvm_inventory` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '0',
  `ref` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_inventory` datetime DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_inventorydet`
--

DROP TABLE IF EXISTS `jvm_inventorydet`;
CREATE TABLE `jvm_inventorydet` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_inventory` int(11) DEFAULT '0',
  `fk_warehouse` int(11) DEFAULT '0',
  `fk_product` int(11) DEFAULT '0',
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_stock` double DEFAULT NULL,
  `qty_view` double DEFAULT NULL,
  `qty_regulated` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_links`
--

DROP TABLE IF EXISTS `jvm_links`;
CREATE TABLE `jvm_links` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datea` datetime NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `objecttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `objectid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_loan`
--

DROP TABLE IF EXISTS `jvm_loan`;
CREATE TABLE `jvm_loan` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `capital` double(24,8) NOT NULL DEFAULT '0.00000000',
  `insurance_amount` double(24,8) DEFAULT '0.00000000',
  `datestart` date DEFAULT NULL,
  `dateend` date DEFAULT NULL,
  `nbterm` double DEFAULT NULL,
  `rate` double NOT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `capital_position` double(24,8) DEFAULT '0.00000000',
  `date_position` date DEFAULT NULL,
  `paid` smallint(6) NOT NULL DEFAULT '0',
  `accountancy_account_capital` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_account_insurance` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_account_interest` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_loan_schedule`
--

DROP TABLE IF EXISTS `jvm_loan_schedule`;
CREATE TABLE `jvm_loan_schedule` (
  `rowid` int(11) NOT NULL,
  `fk_loan` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount_capital` double(24,8) DEFAULT '0.00000000',
  `amount_insurance` double(24,8) DEFAULT '0.00000000',
  `amount_interest` double(24,8) DEFAULT '0.00000000',
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `fk_payment_loan` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_localtax`
--

DROP TABLE IF EXISTS `jvm_localtax`;
CREATE TABLE `jvm_localtax` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `localtaxtype` tinyint(4) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mailing`
--

DROP TABLE IF EXISTS `jvm_mailing`;
CREATE TABLE `jvm_mailing` (
  `rowid` int(11) NOT NULL,
  `statut` smallint(6) DEFAULT '0',
  `titre` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `sujet` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` mediumtext COLLATE utf8_unicode_ci,
  `bgcolor` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bgimage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cible` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nbemail` int(11) DEFAULT NULL,
  `email_from` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_replyto` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_errorsto` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creat` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_appro` datetime DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_appro` int(11) DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `joined_file1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `joined_file2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `joined_file3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `joined_file4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mailing_cibles`
--

DROP TABLE IF EXISTS `jvm_mailing_cibles`;
CREATE TABLE `jvm_mailing_cibles` (
  `rowid` int(11) NOT NULL,
  `fk_mailing` int(11) NOT NULL,
  `fk_contact` int(11) NOT NULL,
  `lastname` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `source_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `source_type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `error_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mailing_unsubscribe`
--

DROP TABLE IF EXISTS `jvm_mailing_unsubscribe`;
CREATE TABLE `jvm_mailing_unsubscribe` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unsubscribegroup` varchar(128) COLLATE utf8_unicode_ci DEFAULT '',
  `ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creat` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_menu`
--

DROP TABLE IF EXISTS `jvm_menu`;
CREATE TABLE `jvm_menu` (
  `rowid` int(11) NOT NULL,
  `menu_handler` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `module` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `mainmenu` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `leftmenu` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_menu` int(11) NOT NULL,
  `fk_mainmenu` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_leftmenu` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `langs` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `perms` text COLLATE utf8_unicode_ci,
  `enabled` text COLLATE utf8_unicode_ci,
  `usertype` int(11) NOT NULL DEFAULT '0',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_menu`
--

INSERT INTO `jvm_menu` (`rowid`, `menu_handler`, `entity`, `module`, `type`, `mainmenu`, `leftmenu`, `fk_menu`, `fk_mainmenu`, `fk_leftmenu`, `position`, `url`, `target`, `titre`, `langs`, `level`, `perms`, `enabled`, `usertype`, `tms`) VALUES
(1, 'all', 1, 'barcode', 'left', 'tools', 'barcodeprint', -1, 'tools', NULL, 200, '/barcode/printsheet.php?mainmenu=tools&leftmenu=barcodeprint', '', 'BarCodePrintsheet', 'products', NULL, '($conf->global->MAIN_USE_ADVANCED_PERMS && $user->rights->barcode->lire_advance) || (! $conf->global->MAIN_USE_ADVANCED_PERMS)', '$conf->barcode->enabled', 2, '2021-01-22 06:46:18'),
(2, 'all', 1, 'barcode', 'left', 'home', NULL, -1, 'home', 'admintools', 300, '/barcode/codeinit.php?mainmenu=home&leftmenu=admintools', '', 'MassBarcodeInit', 'products', NULL, '($conf->global->MAIN_USE_ADVANCED_PERMS && $user->rights->barcode->creer_advance) || (! $conf->global->MAIN_USE_ADVANCED_PERMS)', '$conf->barcode->enabled && preg_match(\'/^(admintools|all)/\',$leftmenu)', 0, '2021-01-22 06:46:18'),
(3, 'all', 1, 'printing', 'left', 'home', NULL, -1, 'home', 'admintools', 300, '/printing/index.php?mainmenu=home&leftmenu=admintools', '', 'MenuDirectPrinting', 'printing', NULL, '$user->rights->printing->read', '$conf->printing->enabled && preg_match(\'/^(admintools|all)/\', $leftmenu)', 0, '2021-01-22 06:46:50'),
(4, 'all', 1, 'cron', 'left', 'home', NULL, -1, 'home', 'admintools', 200, '/cron/list.php?leftmenu=admintools', '', 'CronList', 'cron', NULL, '$user->rights->cron->read', '$conf->cron->enabled && preg_match(\'/^(admintools|all)/\', $leftmenu)', 2, '2021-01-22 07:34:26'),
(11, 'all', 1, 'agenda', 'top', 'agenda', NULL, 0, NULL, NULL, 86, '/comm/action/index.php', '', 'TMenuAgenda', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(12, 'all', 1, 'agenda', 'left', 'agenda', NULL, 11, NULL, NULL, 100, '/comm/action/index.php?mainmenu=agenda&amp;leftmenu=agenda', '', 'Actions', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(13, 'all', 1, 'agenda', 'left', 'agenda', NULL, 12, NULL, NULL, 101, '/comm/action/card.php?mainmenu=agenda&amp;leftmenu=agenda&amp;action=create', '', 'NewAction', 'commercial', NULL, '($user->rights->agenda->myactions->create||$user->rights->agenda->allactions->create)', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(14, 'all', 1, 'agenda', 'left', 'agenda', NULL, 12, NULL, NULL, 140, '/comm/action/index.php?action=default&amp;mainmenu=agenda&amp;leftmenu=agenda', '', 'Calendar', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(15, 'all', 1, 'agenda', 'left', 'agenda', NULL, 14, NULL, NULL, 141, '/comm/action/index.php?action=default&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=todo&amp;filter=mine', '', 'MenuToDoMyActions', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(16, 'all', 1, 'agenda', 'left', 'agenda', NULL, 14, NULL, NULL, 142, '/comm/action/index.php?action=default&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=done&amp;filter=mine', '', 'MenuDoneMyActions', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(17, 'all', 1, 'agenda', 'left', 'agenda', NULL, 14, NULL, NULL, 143, '/comm/action/index.php?action=default&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=todo&amp;filtert=-1', '', 'MenuToDoActions', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$user->rights->agenda->allactions->read', 2, '2021-01-25 07:32:08'),
(18, 'all', 1, 'agenda', 'left', 'agenda', NULL, 14, NULL, NULL, 144, '/comm/action/index.php?action=default&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=done&amp;filtert=-1', '', 'MenuDoneActions', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$user->rights->agenda->allactions->read', 2, '2021-01-25 07:32:08'),
(19, 'all', 1, 'agenda', 'left', 'agenda', NULL, 12, NULL, NULL, 110, '/comm/action/list.php?action=show_list&amp;mainmenu=agenda&amp;leftmenu=agenda', '', 'List', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(20, 'all', 1, 'agenda', 'left', 'agenda', NULL, 19, NULL, NULL, 111, '/comm/action/list.php?action=show_list&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=todo&amp;filter=mine', '', 'MenuToDoMyActions', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(21, 'all', 1, 'agenda', 'left', 'agenda', NULL, 19, NULL, NULL, 112, '/comm/action/list.php?action=show_list&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=done&amp;filter=mine', '', 'MenuDoneMyActions', 'agenda', NULL, '$user->rights->agenda->myactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(22, 'all', 1, 'agenda', 'left', 'agenda', NULL, 19, NULL, NULL, 113, '/comm/action/list.php?action=show_list&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=todo&amp;filtert=-1', '', 'MenuToDoActions', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$user->rights->agenda->allactions->read', 2, '2021-01-25 07:32:08'),
(23, 'all', 1, 'agenda', 'left', 'agenda', NULL, 19, NULL, NULL, 114, '/comm/action/list.php?action=show_list&amp;mainmenu=agenda&amp;leftmenu=agenda&amp;status=done&amp;filtert=-1', '', 'MenuDoneActions', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$user->rights->agenda->allactions->read', 2, '2021-01-25 07:32:08'),
(24, 'all', 1, 'agenda', 'left', 'agenda', NULL, 12, NULL, NULL, 160, '/comm/action/rapport/index.php?mainmenu=agenda&amp;leftmenu=agenda', '', 'Reportings', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$conf->agenda->enabled', 2, '2021-01-25 07:32:08'),
(25, 'all', 1, 'agenda', 'left', 'agenda', NULL, 12, NULL, NULL, 170, '/categories/index.php?mainmenu=agenda&amp;leftmenu=agenda&type=10', '', 'Categories', 'agenda', NULL, '$user->rights->agenda->allactions->read', '$conf->categorie->enabled&&$conf->categorie->enabled', 2, '2021-01-25 07:32:08'),
(26, 'all', 1, 'ticket', 'top', 'ticket', '1', 0, NULL, NULL, 88, '/ticket/index.php', '', 'Ticket', 'ticket', NULL, '$user->rights->ticket->read', '$conf->ticket->enabled', 2, '2021-01-25 07:32:31'),
(27, 'all', 1, 'ticket', 'left', 'ticket', 'ticket', -1, 'ticket', NULL, 101, '/ticket/index.php', '', 'Ticket', 'ticket', NULL, '$user->rights->ticket->read', '$conf->ticket->enabled', 2, '2021-01-25 07:32:31'),
(28, 'all', 1, 'ticket', 'left', 'ticket', NULL, -1, 'ticket', 'ticket', 102, '/ticket/card.php?action=create', '', 'NewTicket', 'ticket', NULL, '$user->rights->ticket->write', '$conf->ticket->enabled', 2, '2021-01-25 07:32:31'),
(29, 'all', 1, 'ticket', 'left', 'ticket', 'ticketlist', -1, 'ticket', 'ticket', 103, '/ticket/list.php?search_fk_status=non_closed', '', 'List', 'ticket', NULL, '$user->rights->ticket->read', '$conf->ticket->enabled', 2, '2021-01-25 07:32:31'),
(30, 'all', 1, 'ticket', 'left', 'ticket', 'ticketmy', -1, 'ticket', 'ticket', 105, '/ticket/list.php?mode=mine&search_fk_status=non_closed', '', 'MenuTicketMyAssign', 'ticket', NULL, '$user->rights->ticket->read', '$conf->ticket->enabled', 0, '2021-01-25 07:32:31'),
(31, 'all', 1, 'ticket', 'left', 'ticket', NULL, -1, 'ticket', 'ticket', 107, '/ticket/stats/index.php', '', 'Statistics', 'ticket', NULL, '$user->rights->ticket->read', '$conf->ticket->enabled', 0, '2021-01-25 07:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mrp_mo`
--

DROP TABLE IF EXISTS `jvm_mrp_mo`;
CREATE TABLE `jvm_mrp_mo` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '(PROV)',
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double NOT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `date_start_planned` datetime DEFAULT NULL,
  `date_end_planned` datetime DEFAULT NULL,
  `fk_bom` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mrp_mo_extrafields`
--

DROP TABLE IF EXISTS `jvm_mrp_mo_extrafields`;
CREATE TABLE `jvm_mrp_mo_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_mrp_production`
--

DROP TABLE IF EXISTS `jvm_mrp_production`;
CREATE TABLE `jvm_mrp_production` (
  `rowid` int(11) NOT NULL,
  `fk_mo` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `fk_product` int(11) NOT NULL,
  `fk_warehouse` int(11) DEFAULT NULL,
  `qty` double NOT NULL DEFAULT '1',
  `qty_frozen` smallint(6) DEFAULT '0',
  `disable_stock_change` smallint(6) DEFAULT '0',
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_mrp_production` int(11) DEFAULT NULL,
  `fk_stock_movement` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_multicurrency`
--

DROP TABLE IF EXISTS `jvm_multicurrency`;
CREATE TABLE `jvm_multicurrency` (
  `rowid` int(11) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) DEFAULT '1',
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_multicurrency_rate`
--

DROP TABLE IF EXISTS `jvm_multicurrency_rate`;
CREATE TABLE `jvm_multicurrency_rate` (
  `rowid` int(11) NOT NULL,
  `date_sync` datetime DEFAULT NULL,
  `rate` double NOT NULL DEFAULT '0',
  `fk_multicurrency` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_notify`
--

DROP TABLE IF EXISTS `jvm_notify`;
CREATE TABLE `jvm_notify` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `daten` datetime DEFAULT NULL,
  `fk_action` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'email',
  `type_target` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objet_type` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `objet_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_notify_def`
--

DROP TABLE IF EXISTS `jvm_notify_def`;
CREATE TABLE `jvm_notify_def` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` date DEFAULT NULL,
  `fk_action` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'email'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_notify_def_object`
--

DROP TABLE IF EXISTS `jvm_notify_def_object`;
CREATE TABLE `jvm_notify_def_object` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `objet_type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objet_id` int(11) NOT NULL,
  `type_notif` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'browser',
  `date_notif` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `moreparam` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_oauth_state`
--

DROP TABLE IF EXISTS `jvm_oauth_state`;
CREATE TABLE `jvm_oauth_state` (
  `rowid` int(11) NOT NULL,
  `service` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `entity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_oauth_token`
--

DROP TABLE IF EXISTS `jvm_oauth_token`;
CREATE TABLE `jvm_oauth_token` (
  `rowid` int(11) NOT NULL,
  `service` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8_unicode_ci,
  `tokenstring` text COLLATE utf8_unicode_ci,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `entity` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_object_lang`
--

DROP TABLE IF EXISTS `jvm_object_lang`;
CREATE TABLE `jvm_object_lang` (
  `rowid` int(11) NOT NULL,
  `fk_object` int(11) NOT NULL DEFAULT '0',
  `type_object` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `value` text COLLATE utf8_unicode_ci,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_onlinesignature`
--

DROP TABLE IF EXISTS `jvm_onlinesignature`;
CREATE TABLE `jvm_onlinesignature` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `object_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `object_id` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pathoffile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_opensurvey_comments`
--

DROP TABLE IF EXISTS `jvm_opensurvey_comments`;
CREATE TABLE `jvm_opensurvey_comments` (
  `id_comment` int(10) UNSIGNED NOT NULL,
  `id_sondage` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usercomment` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_opensurvey_formquestions`
--

DROP TABLE IF EXISTS `jvm_opensurvey_formquestions`;
CREATE TABLE `jvm_opensurvey_formquestions` (
  `rowid` int(11) NOT NULL,
  `id_sondage` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `question` text COLLATE utf8_unicode_ci,
  `available_answers` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_opensurvey_sondage`
--

DROP TABLE IF EXISTS `jvm_opensurvey_sondage`;
CREATE TABLE `jvm_opensurvey_sondage` (
  `id_sondage` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `commentaires` text COLLATE utf8_unicode_ci,
  `mail_admin` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nom_admin` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_creat` int(11) NOT NULL,
  `titre` text COLLATE utf8_unicode_ci NOT NULL,
  `date_fin` datetime DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `format` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `mailsonde` tinyint(4) NOT NULL DEFAULT '0',
  `allow_comments` tinyint(4) NOT NULL DEFAULT '1',
  `allow_spy` tinyint(4) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sujet` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_opensurvey_user_formanswers`
--

DROP TABLE IF EXISTS `jvm_opensurvey_user_formanswers`;
CREATE TABLE `jvm_opensurvey_user_formanswers` (
  `fk_user_survey` int(11) NOT NULL,
  `fk_question` int(11) NOT NULL,
  `reponses` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_opensurvey_user_studs`
--

DROP TABLE IF EXISTS `jvm_opensurvey_user_studs`;
CREATE TABLE `jvm_opensurvey_user_studs` (
  `id_users` int(11) NOT NULL,
  `nom` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `id_sondage` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `reponses` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_overwrite_trans`
--

DROP TABLE IF EXISTS `jvm_overwrite_trans`;
CREATE TABLE `jvm_overwrite_trans` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `lang` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transkey` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transvalue` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_overwrite_trans`
--

INSERT INTO `jvm_overwrite_trans` (`rowid`, `entity`, `lang`, `transkey`, `transvalue`) VALUES
(1, 1, 'en_US', 'DictionaryCity', 'City'),
(2, 1, 'en_US', 'DictionaryPincode', 'Pincode');

-- --------------------------------------------------------

--
-- Table structure for table `jvm_paiement`
--

DROP TABLE IF EXISTS `jvm_paiement`;
CREATE TABLE `jvm_paiement` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `multicurrency_amount` double(24,8) DEFAULT '0.00000000',
  `fk_paiement` int(11) NOT NULL,
  `num_paiement` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ext_payment_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext_payment_site` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_bank` int(11) NOT NULL DEFAULT '0',
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `fk_export_compta` int(11) NOT NULL DEFAULT '0',
  `pos_change` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_paiementcharge`
--

DROP TABLE IF EXISTS `jvm_paiementcharge`;
CREATE TABLE `jvm_paiementcharge` (
  `rowid` int(11) NOT NULL,
  `fk_charge` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `fk_typepaiement` int(11) NOT NULL,
  `num_paiement` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_paiementfourn`
--

DROP TABLE IF EXISTS `jvm_paiementfourn`;
CREATE TABLE `jvm_paiementfourn` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `multicurrency_amount` double(24,8) DEFAULT '0.00000000',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_paiement` int(11) NOT NULL,
  `num_paiement` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `statut` smallint(6) NOT NULL DEFAULT '0',
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_paiementfourn_facturefourn`
--

DROP TABLE IF EXISTS `jvm_paiementfourn_facturefourn`;
CREATE TABLE `jvm_paiementfourn_facturefourn` (
  `rowid` int(11) NOT NULL,
  `fk_paiementfourn` int(11) DEFAULT NULL,
  `fk_facturefourn` int(11) DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_amount` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_paiement_facture`
--

DROP TABLE IF EXISTS `jvm_paiement_facture`;
CREATE TABLE `jvm_paiement_facture` (
  `rowid` int(11) NOT NULL,
  `fk_paiement` int(11) DEFAULT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_amount` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_donation`
--

DROP TABLE IF EXISTS `jvm_payment_donation`;
CREATE TABLE `jvm_payment_donation` (
  `rowid` int(11) NOT NULL,
  `fk_donation` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_expensereport`
--

DROP TABLE IF EXISTS `jvm_payment_expensereport`;
CREATE TABLE `jvm_payment_expensereport` (
  `rowid` int(11) NOT NULL,
  `fk_expensereport` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_loan`
--

DROP TABLE IF EXISTS `jvm_payment_loan`;
CREATE TABLE `jvm_payment_loan` (
  `rowid` int(11) NOT NULL,
  `fk_loan` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datep` datetime DEFAULT NULL,
  `amount_capital` double(24,8) DEFAULT '0.00000000',
  `amount_insurance` double(24,8) DEFAULT '0.00000000',
  `amount_interest` double(24,8) DEFAULT '0.00000000',
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) NOT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_salary`
--

DROP TABLE IF EXISTS `jvm_payment_salary`;
CREATE TABLE `jvm_payment_salary` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_user` int(11) NOT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `fk_projet` int(11) DEFAULT NULL,
  `fk_typepayment` int(11) NOT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datesp` date DEFAULT NULL,
  `dateep` date DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_salary_extrafields`
--

DROP TABLE IF EXISTS `jvm_payment_salary_extrafields`;
CREATE TABLE `jvm_payment_salary_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_payment_various`
--

DROP TABLE IF EXISTS `jvm_payment_various`;
CREATE TABLE `jvm_payment_various` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `sens` smallint(6) NOT NULL DEFAULT '0',
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `fk_typepayment` int(11) NOT NULL,
  `accountancy_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subledger_account` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_pos_cash_fence`
--

DROP TABLE IF EXISTS `jvm_pos_cash_fence`;
CREATE TABLE `jvm_pos_cash_fence` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opening` double(24,8) DEFAULT '0.00000000',
  `cash` double(24,8) DEFAULT '0.00000000',
  `card` double(24,8) DEFAULT '0.00000000',
  `cheque` double(24,8) DEFAULT '0.00000000',
  `status` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `date_valid` datetime DEFAULT NULL,
  `day_close` int(11) DEFAULT NULL,
  `month_close` int(11) DEFAULT NULL,
  `year_close` int(11) DEFAULT NULL,
  `posmodule` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `posnumber` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_prelevement_bons`
--

DROP TABLE IF EXISTS `jvm_prelevement_bons`;
CREATE TABLE `jvm_prelevement_bons` (
  `rowid` int(11) NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'debit-order',
  `ref` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `statut` smallint(6) DEFAULT '0',
  `credite` smallint(6) DEFAULT '0',
  `note` text COLLATE utf8_unicode_ci,
  `date_trans` datetime DEFAULT NULL,
  `method_trans` smallint(6) DEFAULT NULL,
  `fk_user_trans` int(11) DEFAULT NULL,
  `date_credit` datetime DEFAULT NULL,
  `fk_user_credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_prelevement_facture`
--

DROP TABLE IF EXISTS `jvm_prelevement_facture`;
CREATE TABLE `jvm_prelevement_facture` (
  `rowid` int(11) NOT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_fourn` int(11) DEFAULT NULL,
  `fk_prelevement_lignes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_prelevement_facture_demande`
--

DROP TABLE IF EXISTS `jvm_prelevement_facture_demande`;
CREATE TABLE `jvm_prelevement_facture_demande` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_fourn` int(11) DEFAULT NULL,
  `sourcetype` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(24,8) NOT NULL,
  `date_demande` datetime NOT NULL,
  `traite` smallint(6) DEFAULT '0',
  `date_traite` datetime DEFAULT NULL,
  `fk_prelevement_bons` int(11) DEFAULT NULL,
  `fk_user_demande` int(11) NOT NULL,
  `code_banque` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_guichet` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_rib` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext_payment_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext_payment_site` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_prelevement_lignes`
--

DROP TABLE IF EXISTS `jvm_prelevement_lignes`;
CREATE TABLE `jvm_prelevement_lignes` (
  `rowid` int(11) NOT NULL,
  `fk_prelevement_bons` int(11) DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `statut` smallint(6) DEFAULT '0',
  `client_nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` double(24,8) DEFAULT '0.00000000',
  `code_banque` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_guichet` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_rib` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_prelevement_rejet`
--

DROP TABLE IF EXISTS `jvm_prelevement_rejet`;
CREATE TABLE `jvm_prelevement_rejet` (
  `rowid` int(11) NOT NULL,
  `fk_prelevement_lignes` int(11) DEFAULT NULL,
  `date_rejet` datetime DEFAULT NULL,
  `motif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_creation` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `afacturer` tinyint(4) DEFAULT '0',
  `fk_facture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_printing`
--

DROP TABLE IF EXISTS `jvm_printing`;
CREATE TABLE `jvm_printing` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `printer_name` text COLLATE utf8_unicode_ci NOT NULL,
  `printer_location` text COLLATE utf8_unicode_ci NOT NULL,
  `printer_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `copy` int(11) NOT NULL DEFAULT '1',
  `module` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `driver` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product`
--

DROP TABLE IF EXISTS `jvm_product`;
CREATE TABLE `jvm_product` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_parent` int(11) DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  `customcode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `fk_state` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `price_ttc` double(24,8) DEFAULT '0.00000000',
  `price_min` double(24,8) DEFAULT '0.00000000',
  `price_min_ttc` double(24,8) DEFAULT '0.00000000',
  `price_base_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'HT',
  `cost_price` double(24,8) DEFAULT NULL,
  `default_vat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_tx` double(6,3) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT '0',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `tosell` tinyint(4) DEFAULT '1',
  `tobuy` tinyint(4) DEFAULT '1',
  `onportal` tinyint(4) DEFAULT '0',
  `tobatch` tinyint(4) NOT NULL DEFAULT '0',
  `fk_product_type` int(11) DEFAULT '0',
  `duration` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `seuil_stock_alerte` float DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `accountancy_code_sell` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_sell_intra` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_sell_export` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_buy` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_buy_intra` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accountancy_code_buy_export` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partnumber` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `net_measure` float DEFAULT NULL,
  `net_measure_units` tinyint(4) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `weight_units` tinyint(4) DEFAULT NULL,
  `length` float DEFAULT NULL,
  `length_units` tinyint(4) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `width_units` tinyint(4) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `height_units` tinyint(4) DEFAULT NULL,
  `surface` float DEFAULT NULL,
  `surface_units` tinyint(4) DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `volume_units` tinyint(4) DEFAULT NULL,
  `stock` double DEFAULT NULL,
  `pmp` double(24,8) NOT NULL DEFAULT '0.00000000',
  `fifo` double(24,8) DEFAULT NULL,
  `lifo` double(24,8) DEFAULT NULL,
  `fk_default_warehouse` int(11) DEFAULT NULL,
  `canvas` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finished` tinyint(4) DEFAULT NULL,
  `hidden` tinyint(4) DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_price_expression` int(11) DEFAULT NULL,
  `desiredstock` float DEFAULT '0',
  `fk_unit` int(11) DEFAULT NULL,
  `price_autogen` tinyint(4) DEFAULT '0',
  `fk_project` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_association`
--

DROP TABLE IF EXISTS `jvm_product_association`;
CREATE TABLE `jvm_product_association` (
  `rowid` int(11) NOT NULL,
  `fk_product_pere` int(11) NOT NULL DEFAULT '0',
  `fk_product_fils` int(11) NOT NULL DEFAULT '0',
  `qty` double DEFAULT NULL,
  `incdec` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_attribute`
--

DROP TABLE IF EXISTS `jvm_product_attribute`;
CREATE TABLE `jvm_product_attribute` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rang` int(11) NOT NULL DEFAULT '0',
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_attribute_combination`
--

DROP TABLE IF EXISTS `jvm_product_attribute_combination`;
CREATE TABLE `jvm_product_attribute_combination` (
  `rowid` int(11) NOT NULL,
  `fk_product_parent` int(11) NOT NULL,
  `fk_product_child` int(11) NOT NULL,
  `variation_price` double(24,8) NOT NULL,
  `variation_price_percentage` int(11) DEFAULT NULL,
  `variation_weight` double NOT NULL,
  `variation_ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_attribute_combination2val`
--

DROP TABLE IF EXISTS `jvm_product_attribute_combination2val`;
CREATE TABLE `jvm_product_attribute_combination2val` (
  `rowid` int(11) NOT NULL,
  `fk_prod_combination` int(11) NOT NULL,
  `fk_prod_attr` int(11) NOT NULL,
  `fk_prod_attr_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_attribute_combination_price_level`
--

DROP TABLE IF EXISTS `jvm_product_attribute_combination_price_level`;
CREATE TABLE `jvm_product_attribute_combination_price_level` (
  `rowid` int(11) NOT NULL,
  `fk_product_attribute_combination` int(11) NOT NULL DEFAULT '1',
  `fk_price_level` int(11) NOT NULL DEFAULT '1',
  `variation_price` double(24,8) NOT NULL,
  `variation_price_percentage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_attribute_value`
--

DROP TABLE IF EXISTS `jvm_product_attribute_value`;
CREATE TABLE `jvm_product_attribute_value` (
  `rowid` int(11) NOT NULL,
  `fk_product_attribute` int(11) NOT NULL,
  `ref` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_batch`
--

DROP TABLE IF EXISTS `jvm_product_batch`;
CREATE TABLE `jvm_product_batch` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product_stock` int(11) NOT NULL,
  `eatby` datetime DEFAULT NULL,
  `sellby` datetime DEFAULT NULL,
  `batch` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_customer_price`
--

DROP TABLE IF EXISTS `jvm_product_customer_price`;
CREATE TABLE `jvm_product_customer_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `price_ttc` double(24,8) DEFAULT '0.00000000',
  `price_min` double(24,8) DEFAULT '0.00000000',
  `price_min_ttc` double(24,8) DEFAULT '0.00000000',
  `price_base_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'HT',
  `default_vat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_tx` double(6,3) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT '0',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_customer_price_log`
--

DROP TABLE IF EXISTS `jvm_product_customer_price_log`;
CREATE TABLE `jvm_product_customer_price_log` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `fk_product` int(11) NOT NULL,
  `fk_soc` int(11) NOT NULL DEFAULT '0',
  `price` double(24,8) DEFAULT '0.00000000',
  `price_ttc` double(24,8) DEFAULT '0.00000000',
  `price_min` double(24,8) DEFAULT '0.00000000',
  `price_min_ttc` double(24,8) DEFAULT '0.00000000',
  `price_base_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'HT',
  `default_vat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_tx` double(6,3) DEFAULT NULL,
  `recuperableonly` int(11) NOT NULL DEFAULT '0',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_extrafields`
--

DROP TABLE IF EXISTS `jvm_product_extrafields`;
CREATE TABLE `jvm_product_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_fournisseur_price`
--

DROP TABLE IF EXISTS `jvm_product_fournisseur_price`;
CREATE TABLE `jvm_product_fournisseur_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product` int(11) DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `ref_fourn` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc_fourn` text COLLATE utf8_unicode_ci,
  `fk_availability` int(11) DEFAULT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `quantity` double DEFAULT NULL,
  `remise_percent` double NOT NULL DEFAULT '0',
  `remise` double NOT NULL DEFAULT '0',
  `unitprice` double(24,8) DEFAULT '0.00000000',
  `charges` double(24,8) DEFAULT '0.00000000',
  `default_vat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT NULL,
  `tva_tx` double(6,3) NOT NULL,
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `info_bits` int(11) NOT NULL DEFAULT '0',
  `fk_user` int(11) DEFAULT NULL,
  `fk_supplier_price_expression` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_time_days` int(11) DEFAULT NULL,
  `supplier_reputation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `packaging` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_unitprice` double(24,8) DEFAULT NULL,
  `multicurrency_price` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_fournisseur_price_extrafields`
--

DROP TABLE IF EXISTS `jvm_product_fournisseur_price_extrafields`;
CREATE TABLE `jvm_product_fournisseur_price_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_fournisseur_price_log`
--

DROP TABLE IF EXISTS `jvm_product_fournisseur_price_log`;
CREATE TABLE `jvm_product_fournisseur_price_log` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `fk_product_fournisseur` int(11) NOT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `quantity` double DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_unitprice` double(24,8) DEFAULT NULL,
  `multicurrency_price` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_lang`
--

DROP TABLE IF EXISTS `jvm_product_lang`;
CREATE TABLE `jvm_product_lang` (
  `rowid` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL DEFAULT '0',
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_lot`
--

DROP TABLE IF EXISTS `jvm_product_lot`;
CREATE TABLE `jvm_product_lot` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `fk_product` int(11) NOT NULL,
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_lot_extrafields`
--

DROP TABLE IF EXISTS `jvm_product_lot_extrafields`;
CREATE TABLE `jvm_product_lot_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_price`
--

DROP TABLE IF EXISTS `jvm_product_price`;
CREATE TABLE `jvm_product_price` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product` int(11) NOT NULL,
  `date_price` datetime NOT NULL,
  `price_level` smallint(6) DEFAULT '1',
  `price` double(24,8) DEFAULT NULL,
  `price_ttc` double(24,8) DEFAULT NULL,
  `price_min` double(24,8) DEFAULT NULL,
  `price_min_ttc` double(24,8) DEFAULT NULL,
  `price_base_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'HT',
  `default_vat_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_tx` double(6,3) NOT NULL DEFAULT '0.000',
  `recuperableonly` int(11) NOT NULL DEFAULT '0',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `fk_user_author` int(11) DEFAULT NULL,
  `tosell` tinyint(4) DEFAULT '1',
  `price_by_qty` int(11) NOT NULL DEFAULT '0',
  `fk_price_expression` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_price` double(24,8) DEFAULT NULL,
  `multicurrency_price_ttc` double(24,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_pricerules`
--

DROP TABLE IF EXISTS `jvm_product_pricerules`;
CREATE TABLE `jvm_product_pricerules` (
  `rowid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `fk_level` int(11) NOT NULL,
  `var_percent` double NOT NULL,
  `var_min_percent` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_price_by_qty`
--

DROP TABLE IF EXISTS `jvm_product_price_by_qty`;
CREATE TABLE `jvm_product_price_by_qty` (
  `rowid` int(11) NOT NULL,
  `fk_product_price` int(11) NOT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `price_base_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'HT',
  `quantity` double DEFAULT NULL,
  `remise_percent` double NOT NULL DEFAULT '0',
  `remise` double NOT NULL DEFAULT '0',
  `unitprice` double(24,8) DEFAULT '0.00000000',
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_price` double(24,8) DEFAULT NULL,
  `multicurrency_price_ttc` double(24,8) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_stock`
--

DROP TABLE IF EXISTS `jvm_product_stock`;
CREATE TABLE `jvm_product_stock` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product` int(11) NOT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `reel` double DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_product_warehouse_properties`
--

DROP TABLE IF EXISTS `jvm_product_warehouse_properties`;
CREATE TABLE `jvm_product_warehouse_properties` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_product` int(11) NOT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `seuil_stock_alerte` float DEFAULT '0',
  `desiredstock` float DEFAULT '0',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_projet`
--

DROP TABLE IF EXISTS `jvm_projet`;
CREATE TABLE `jvm_projet` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateo` date DEFAULT NULL,
  `datee` date DEFAULT NULL,
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `fk_statut` int(11) NOT NULL DEFAULT '0',
  `fk_opp_status` int(11) DEFAULT NULL,
  `opp_percent` double(5,2) DEFAULT NULL,
  `fk_opp_status_end` int(11) DEFAULT NULL,
  `date_close` datetime DEFAULT NULL,
  `fk_user_close` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `email_msgid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opp_amount` double(24,8) DEFAULT NULL,
  `budget_amount` double(24,8) DEFAULT NULL,
  `usage_opportunity` int(11) DEFAULT '0',
  `usage_task` int(11) DEFAULT '1',
  `usage_bill_time` int(11) DEFAULT '0',
  `usage_organize_event` int(11) DEFAULT '0',
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_projet_extrafields`
--

DROP TABLE IF EXISTS `jvm_projet_extrafields`;
CREATE TABLE `jvm_projet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_projet_task`
--

DROP TABLE IF EXISTS `jvm_projet_task`;
CREATE TABLE `jvm_projet_task` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_projet` int(11) NOT NULL,
  `fk_task_parent` int(11) NOT NULL DEFAULT '0',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateo` datetime DEFAULT NULL,
  `datee` datetime DEFAULT NULL,
  `datev` datetime DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `duration_effective` double DEFAULT '0',
  `planned_workload` double DEFAULT '0',
  `progress` int(11) DEFAULT '0',
  `priority` int(11) DEFAULT '0',
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `rang` int(11) DEFAULT '0',
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_projet_task_extrafields`
--

DROP TABLE IF EXISTS `jvm_projet_task_extrafields`;
CREATE TABLE `jvm_projet_task_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_projet_task_time`
--

DROP TABLE IF EXISTS `jvm_projet_task_time`;
CREATE TABLE `jvm_projet_task_time` (
  `rowid` int(11) NOT NULL,
  `fk_task` int(11) NOT NULL,
  `task_date` date DEFAULT NULL,
  `task_datehour` datetime DEFAULT NULL,
  `task_date_withhour` int(11) DEFAULT '0',
  `task_duration` double DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `thm` double(24,8) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_line_id` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_propal`
--

DROP TABLE IF EXISTS `jvm_propal`;
CREATE TABLE `jvm_propal` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_client` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `fin_validite` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `price` double DEFAULT '0',
  `remise_percent` double DEFAULT '0',
  `remise_absolue` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total` double(24,8) DEFAULT '0.00000000',
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `fk_availability` int(11) DEFAULT NULL,
  `fk_input_reason` int(11) DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_delivery_address` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_propaldet`
--

DROP TABLE IF EXISTS `jvm_propaldet`;
CREATE TABLE `jvm_propaldet` (
  `rowid` int(11) NOT NULL,
  `fk_propal` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT '0.000',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `fk_unit` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_propaldet_extrafields`
--

DROP TABLE IF EXISTS `jvm_propaldet_extrafields`;
CREATE TABLE `jvm_propaldet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_propal_extrafields`
--

DROP TABLE IF EXISTS `jvm_propal_extrafields`;
CREATE TABLE `jvm_propal_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_propal_merge_pdf_product`
--

DROP TABLE IF EXISTS `jvm_propal_merge_pdf_product`;
CREATE TABLE `jvm_propal_merge_pdf_product` (
  `rowid` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `file_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_mod` int(11) NOT NULL,
  `datec` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_reception`
--

DROP TABLE IF EXISTS `jvm_reception`;
CREATE TABLE `jvm_reception` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `ref_ext` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_supplier` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `date_delivery` datetime DEFAULT NULL,
  `date_reception` datetime DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tracking_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_statut` smallint(6) DEFAULT '0',
  `billed` smallint(6) DEFAULT '0',
  `height` float DEFAULT NULL,
  `width` float DEFAULT NULL,
  `size_units` int(11) DEFAULT NULL,
  `size` float DEFAULT NULL,
  `weight_units` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_reception_extrafields`
--

DROP TABLE IF EXISTS `jvm_reception_extrafields`;
CREATE TABLE `jvm_reception_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_recruitment_recruitmentcandidature`
--

DROP TABLE IF EXISTS `jvm_recruitment_recruitmentcandidature`;
CREATE TABLE `jvm_recruitment_recruitmentcandidature` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '(PROV)',
  `fk_recruitmentjobposition` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `firstname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `remuneration_requested` int(11) DEFAULT NULL,
  `remuneration_proposed` int(11) DEFAULT NULL,
  `email_msgid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_recruitment_origin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_recruitment_recruitmentcandidature_extrafields`
--

DROP TABLE IF EXISTS `jvm_recruitment_recruitmentcandidature_extrafields`;
CREATE TABLE `jvm_recruitment_recruitmentcandidature_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_recruitment_recruitmentjobposition`
--

DROP TABLE IF EXISTS `jvm_recruitment_recruitmentjobposition`;
CREATE TABLE `jvm_recruitment_recruitmentjobposition` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '(PROV)',
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_user_recruiter` int(11) DEFAULT NULL,
  `email_recruiter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_supervisor` int(11) DEFAULT NULL,
  `fk_establishment` int(11) DEFAULT NULL,
  `date_planned` date DEFAULT NULL,
  `remuneration_suggested` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_recruitment_recruitmentjobposition_extrafields`
--

DROP TABLE IF EXISTS `jvm_recruitment_recruitmentjobposition_extrafields`;
CREATE TABLE `jvm_recruitment_recruitmentjobposition_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_resource`
--

DROP TABLE IF EXISTS `jvm_resource`;
CREATE TABLE `jvm_resource` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asset_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `fk_code_type_resource` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `note_public` text COLLATE utf8_unicode_ci,
  `note_private` text COLLATE utf8_unicode_ci,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_country` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_resource_extrafields`
--

DROP TABLE IF EXISTS `jvm_resource_extrafields`;
CREATE TABLE `jvm_resource_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_rights_def`
--

DROP TABLE IF EXISTS `jvm_rights_def`;
CREATE TABLE `jvm_rights_def` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_position` int(11) NOT NULL DEFAULT '0',
  `family_position` int(11) NOT NULL DEFAULT '0',
  `entity` int(11) NOT NULL DEFAULT '1',
  `perms` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subperms` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bydefault` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_rights_def`
--

INSERT INTO `jvm_rights_def` (`id`, `libelle`, `module`, `module_position`, `family_position`, `entity`, `perms`, `subperms`, `type`, `bydefault`) VALUES
(11, 'Read invoices', 'facture', 11, 0, 1, 'lire', NULL, 'a', 0),
(12, 'Create and update invoices', 'facture', 11, 0, 1, 'creer', NULL, 'a', 0),
(13, 'Devalidate invoices', 'facture', 11, 0, 1, 'invoice_advance', 'unvalidate', 'a', 0),
(14, 'Validate invoices', 'facture', 11, 0, 1, 'invoice_advance', 'validate', 'a', 0),
(15, 'Send invoices by email', 'facture', 11, 0, 1, 'invoice_advance', 'send', 'a', 0),
(16, 'Issue payments on invoices', 'facture', 11, 0, 1, 'paiement', NULL, 'a', 0),
(19, 'Delete invoices', 'facture', 11, 0, 1, 'supprimer', NULL, 'a', 0),
(21, 'Read commercial proposals', 'propale', 10, 0, 1, 'lire', NULL, 'r', 0),
(22, 'Create and update commercial proposals', 'propale', 10, 0, 1, 'creer', NULL, 'w', 0),
(24, 'Validate commercial proposals', 'propale', 10, 0, 1, 'propal_advance', 'validate', 'd', 0),
(25, 'Send commercial proposals to customers', 'propale', 10, 0, 1, 'propal_advance', 'send', 'd', 0),
(26, 'Close commercial proposals', 'propale', 10, 0, 1, 'cloturer', NULL, 'd', 0),
(27, 'Delete commercial proposals', 'propale', 10, 0, 1, 'supprimer', NULL, 'd', 0),
(28, 'Exporting commercial proposals and attributes', 'propale', 10, 0, 1, 'export', NULL, 'r', 0),
(31, 'Read products', 'produit', 26, 0, 1, 'lire', NULL, 'r', 0),
(32, 'Create/modify products', 'produit', 26, 0, 1, 'creer', NULL, 'w', 0),
(34, 'Delete products', 'produit', 26, 0, 1, 'supprimer', NULL, 'd', 0),
(38, 'Export products', 'produit', 26, 0, 1, 'export', NULL, 'r', 0),
(39, 'Ignore minimum price', 'produit', 26, 0, 1, 'ignore_price_min_advance', NULL, 'r', 0),
(41, 'Read projects and tasks (shared projects or projects I am contact for). Can also enter time consumed on assigned tasks (timesheet)', 'projet', 14, 0, 1, 'lire', NULL, 'r', 0),
(42, 'Create/modify projects and tasks (shared projects or projects I am contact for)', 'projet', 14, 0, 1, 'creer', NULL, 'w', 0),
(44, 'Delete project and tasks (shared projects or projects I am contact for)', 'projet', 14, 0, 1, 'supprimer', NULL, 'd', 0),
(45, 'Export projects', 'projet', 14, 0, 1, 'export', NULL, 'd', 0),
(71, 'Read members\' card', 'adherent', 6, 0, 1, 'lire', NULL, 'r', 0),
(72, 'Create/modify members (need also user module permissions if member linked to a user)', 'adherent', 6, 0, 1, 'creer', NULL, 'w', 0),
(74, 'Remove members', 'adherent', 6, 0, 1, 'supprimer', NULL, 'd', 0),
(75, 'Setup types of membership', 'adherent', 6, 0, 1, 'configurer', NULL, 'w', 0),
(76, 'Export members', 'adherent', 6, 0, 1, 'export', NULL, 'r', 0),
(78, 'Read subscriptions', 'adherent', 6, 0, 1, 'cotisation', 'lire', 'r', 0),
(79, 'Create/modify/remove subscriptions', 'adherent', 6, 0, 1, 'cotisation', 'creer', 'w', 0),
(81, 'Read sales orders', 'commande', 11, 0, 1, 'lire', NULL, 'r', 0),
(82, 'Creeat/modify sales orders', 'commande', 11, 0, 1, 'creer', NULL, 'w', 0),
(84, 'Validate sales orders', 'commande', 11, 0, 1, 'order_advance', 'validate', 'd', 0),
(86, 'Send sale orders by email', 'commande', 11, 0, 1, 'order_advance', 'send', 'd', 0),
(87, 'Close sale orders', 'commande', 11, 0, 1, 'order_advance', 'close', 'd', 0),
(88, 'Cancel sale orders', 'commande', 11, 0, 1, 'order_advance', 'annuler', 'd', 0),
(89, 'Delete sales orders', 'commande', 11, 0, 1, 'supprimer', NULL, 'd', 0),
(91, 'Lire les charges', 'tax', 50, 0, 1, 'charges', 'lire', 'r', 0),
(92, 'Creer/modifier les charges', 'tax', 50, 0, 1, 'charges', 'creer', 'w', 0),
(93, 'Supprimer les charges', 'tax', 50, 0, 1, 'charges', 'supprimer', 'd', 0),
(94, 'Exporter les charges', 'tax', 50, 0, 1, 'charges', 'export', 'r', 0),
(101, 'Lire les expeditions', 'expedition', 40, 0, 1, 'lire', NULL, 'r', 0),
(102, 'Creer modifier les expeditions', 'expedition', 40, 0, 1, 'creer', NULL, 'w', 0),
(104, 'Valider les expeditions', 'expedition', 40, 0, 1, 'shipping_advance', 'validate', 'd', 0),
(105, 'Envoyer les expeditions aux clients', 'expedition', 40, 0, 1, 'shipping_advance', 'send', 'd', 0),
(106, 'Exporter les expeditions', 'expedition', 40, 0, 1, 'shipment', 'export', 'r', 0),
(109, 'Supprimer les expeditions', 'expedition', 40, 0, 1, 'supprimer', NULL, 'd', 0),
(121, 'Read third parties', 'societe', 9, 0, 1, 'lire', NULL, 'r', 0),
(122, 'Create and update third parties', 'societe', 9, 0, 1, 'creer', NULL, 'w', 0),
(125, 'Delete third parties', 'societe', 9, 0, 1, 'supprimer', NULL, 'd', 0),
(126, 'Export third parties', 'societe', 9, 0, 1, 'export', NULL, 'r', 0),
(141, 'Read all projects and tasks (also private projects I am not contact for)', 'projet', 14, 0, 1, 'all', 'lire', 'r', 0),
(142, 'Create/modify all projects and tasks (also private projects I am not contact for). Can also enter time consumed on assigned tasks (timesheet)', 'projet', 14, 0, 1, 'all', 'creer', 'w', 0),
(144, 'Delete all projects and tasks (also private projects I am not contact for)', 'projet', 14, 0, 1, 'all', 'supprimer', 'd', 0),
(221, 'Consulter les mailings', 'mailing', 22, 0, 1, 'lire', NULL, 'r', 0),
(222, 'Creer/modifier les mailings (sujet, destinataires...)', 'mailing', 22, 0, 1, 'creer', NULL, 'w', 0),
(223, 'Valider les mailings (permet leur envoi)', 'mailing', 22, 0, 1, 'valider', NULL, 'w', 0),
(229, 'Supprimer les mailings', 'mailing', 22, 0, 1, 'supprimer', NULL, 'd', 0),
(237, 'View recipients and info', 'mailing', 22, 0, 1, 'mailing_advance', 'recipient', 'r', 0),
(238, 'Manually send mailings', 'mailing', 22, 0, 1, 'mailing_advance', 'send', 'w', 0),
(239, 'Delete mailings after validation and/or sent', 'mailing', 22, 0, 1, 'mailing_advance', 'delete', 'd', 0),
(241, 'Lire les categories', 'categorie', 20, 0, 1, 'lire', NULL, 'r', 0),
(242, 'Creer/modifier les categories', 'categorie', 20, 0, 1, 'creer', NULL, 'w', 0),
(243, 'Supprimer les categories', 'categorie', 20, 0, 1, 'supprimer', NULL, 'd', 0),
(251, 'Consulter les autres utilisateurs', 'user', 5, 0, 1, 'user', 'lire', 'r', 0),
(252, 'Consulter les permissions des autres utilisateurs', 'user', 5, 0, 1, 'user_advance', 'readperms', 'r', 0),
(253, 'Creer/modifier utilisateurs internes et externes', 'user', 5, 0, 1, 'user', 'creer', 'w', 0),
(254, 'Creer/modifier utilisateurs externes seulement', 'user', 5, 0, 1, 'user_advance', 'write', 'w', 0),
(255, 'Modifier le mot de passe des autres utilisateurs', 'user', 5, 0, 1, 'user', 'password', 'w', 0),
(256, 'Supprimer ou desactiver les autres utilisateurs', 'user', 5, 0, 1, 'user', 'supprimer', 'd', 0),
(262, 'Read all third parties by internal users (otherwise only if commercial contact). Not effective for external users (limited to themselves).', 'societe', 9, 0, 1, 'client', 'voir', 'r', 0),
(281, 'Read contacts', 'societe', 9, 0, 1, 'contact', 'lire', 'r', 0),
(282, 'Create and update contact', 'societe', 9, 0, 1, 'contact', 'creer', 'w', 0),
(283, 'Delete contacts', 'societe', 9, 0, 1, 'contact', 'supprimer', 'd', 0),
(286, 'Export contacts', 'societe', 9, 0, 1, 'contact', 'export', 'd', 0),
(300, 'Read barcodes', 'barcode', 0, 0, 1, 'lire_advance', NULL, 'r', 1),
(301, 'Create/modify barcodes', 'barcode', 0, 0, 1, 'creer_advance', NULL, 'w', 0),
(341, 'Consulter ses propres permissions', 'user', 5, 0, 1, 'self_advance', 'readperms', 'r', 0),
(342, 'Creer/modifier ses propres infos utilisateur', 'user', 5, 0, 1, 'self', 'creer', 'w', 0),
(343, 'Modifier son propre mot de passe', 'user', 5, 0, 1, 'self', 'password', 'w', 0),
(344, 'Modifier ses propres permissions', 'user', 5, 0, 1, 'self_advance', 'writeperms', 'w', 0),
(351, 'Consulter les groupes', 'user', 5, 0, 1, 'group_advance', 'read', 'r', 0),
(352, 'Consulter les permissions des groupes', 'user', 5, 0, 1, 'group_advance', 'readperms', 'r', 0),
(353, 'Creer/modifier les groupes et leurs permissions', 'user', 5, 0, 1, 'group_advance', 'write', 'w', 0),
(354, 'Supprimer ou desactiver les groupes', 'user', 5, 0, 1, 'group_advance', 'delete', 'd', 0),
(358, 'Exporter les utilisateurs', 'user', 5, 0, 1, 'user', 'export', 'r', 0),
(430, 'Use Debug Bar', 'debugbar', 75, 0, 1, 'read', NULL, 'u', 1),
(531, 'Read services', 'service', 29, 0, 1, 'lire', NULL, 'r', 0),
(532, 'Create/modify services', 'service', 29, 0, 1, 'creer', NULL, 'w', 0),
(534, 'Delete les services', 'service', 29, 0, 1, 'supprimer', NULL, 'd', 0),
(538, 'Export services', 'service', 29, 0, 1, 'export', NULL, 'r', 0),
(1001, 'Lire les stocks', 'stock', 39, 0, 1, 'lire', NULL, 'r', 0),
(1002, 'Creer/Modifier les stocks', 'stock', 39, 0, 1, 'creer', NULL, 'w', 0),
(1003, 'Supprimer les stocks', 'stock', 39, 0, 1, 'supprimer', NULL, 'd', 0),
(1004, 'Lire mouvements de stocks', 'stock', 39, 0, 1, 'mouvement', 'lire', 'r', 0),
(1005, 'Creer/modifier mouvements de stocks', 'stock', 39, 0, 1, 'mouvement', 'creer', 'w', 0),
(1101, 'Read delivery receipts', 'expedition', 40, 0, 1, 'delivery', 'lire', 'r', 0),
(1102, 'Create/modify delivery receipts', 'expedition', 40, 0, 1, 'delivery', 'creer', 'w', 0),
(1104, 'Validate delivery receipts', 'expedition', 40, 0, 1, 'delivery_advance', 'validate', 'd', 0),
(1109, 'Delete delivery receipts', 'expedition', 40, 0, 1, 'delivery', 'supprimer', 'd', 0),
(1121, 'Read supplier proposals', 'supplier_proposal', 35, 0, 1, 'lire', NULL, 'w', 0),
(1122, 'Create/modify supplier proposals', 'supplier_proposal', 35, 0, 1, 'creer', NULL, 'w', 0),
(1123, 'Validate supplier proposals', 'supplier_proposal', 35, 0, 1, 'validate_advance', NULL, 'w', 0),
(1124, 'Envoyer les demandes fournisseurs', 'supplier_proposal', 35, 0, 1, 'send_advance', NULL, 'w', 0),
(1125, 'Delete supplier proposals', 'supplier_proposal', 35, 0, 1, 'supprimer', NULL, 'w', 0),
(1126, 'Close supplier price requests', 'supplier_proposal', 35, 0, 1, 'cloturer', NULL, 'w', 0),
(1181, 'Consulter les fournisseurs', 'fournisseur', 12, 0, 1, 'lire', NULL, 'r', 0),
(1182, 'Consulter les commandes fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'lire', 'r', 0),
(1183, 'Creer une commande fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'creer', 'w', 0),
(1184, 'Valider une commande fournisseur', 'fournisseur', 12, 0, 1, 'supplier_order_advance', 'validate', 'w', 0),
(1185, 'Approuver une commande fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'approuver', 'w', 0),
(1186, 'Commander une commande fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'commander', 'w', 0),
(1187, 'Receptionner une commande fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'receptionner', 'd', 0),
(1188, 'Supprimer une commande fournisseur', 'fournisseur', 12, 0, 1, 'commande', 'supprimer', 'd', 0),
(1189, 'Check/Uncheck a supplier order reception', 'fournisseur', 12, 0, 1, 'commande_advance', 'check', 'w', 0),
(1191, 'Exporter les commande fournisseurs, attributs', 'fournisseur', 12, 0, 1, 'commande', 'export', 'r', 0),
(1201, 'Lire les exports', 'export', 72, 0, 1, 'lire', NULL, 'r', 0),
(1202, 'Creer/modifier un export', 'export', 72, 0, 1, 'creer', NULL, 'w', 0),
(1231, 'Consulter les factures fournisseur', 'fournisseur', 12, 0, 1, 'facture', 'lire', 'r', 0),
(1232, 'Creer une facture fournisseur', 'fournisseur', 12, 0, 1, 'facture', 'creer', 'w', 0),
(1233, 'Valider une facture fournisseur', 'fournisseur', 12, 0, 1, 'supplier_invoice_advance', 'validate', 'w', 0),
(1234, 'Supprimer une facture fournisseur', 'fournisseur', 12, 0, 1, 'facture', 'supprimer', 'd', 0),
(1235, 'Envoyer les factures par mail', 'fournisseur', 12, 0, 1, 'supplier_invoice_advance', 'send', 'a', 0),
(1236, 'Exporter les factures fournisseurs, attributs et reglements', 'fournisseur', 12, 0, 1, 'facture', 'export', 'r', 0),
(1251, 'Run mass imports of external data (data load)', 'import', 70, 0, 1, 'run', NULL, 'r', 0),
(1321, 'Export customer invoices, attributes and payments', 'facture', 11, 0, 1, 'facture', 'export', 'r', 0),
(1322, 'Re-open a fully paid invoice', 'facture', 11, 0, 1, 'invoice_advance', 'reopen', 'r', 0),
(1421, 'Export sales orders and attributes', 'commande', 11, 0, 1, 'commande', 'export', 'r', 0),
(2401, 'Read actions/tasks linked to his account', 'agenda', 15, 0, 1, 'myactions', 'read', 'r', 0),
(2402, 'Create/modify actions/tasks linked to his account', 'agenda', 15, 0, 1, 'myactions', 'create', 'w', 0),
(2403, 'Delete actions/tasks linked to his account', 'agenda', 15, 0, 1, 'myactions', 'delete', 'w', 0),
(2411, 'Read actions/tasks of others', 'agenda', 15, 0, 1, 'allactions', 'read', 'r', 0),
(2412, 'Create/modify actions/tasks of others', 'agenda', 15, 0, 1, 'allactions', 'create', 'w', 0),
(2413, 'Delete actions/tasks of others', 'agenda', 15, 0, 1, 'allactions', 'delete', 'w', 0),
(2414, 'Export actions/tasks of others', 'agenda', 15, 0, 1, 'export', NULL, 'w', 0),
(23001, 'Read cron jobs', 'cron', 50, 0, 1, 'read', NULL, 'w', 0),
(23002, 'Create cron Jobs', 'cron', 50, 0, 1, 'create', NULL, 'w', 0),
(23003, 'Delete cron Jobs', 'cron', 50, 0, 1, 'delete', NULL, 'w', 0),
(23004, 'Execute cron Jobs', 'cron', 50, 0, 1, 'execute', NULL, 'w', 0),
(56001, 'Read ticket', 'ticket', 60, 0, 1, 'read', NULL, 'r', 0),
(56002, 'Create les tickets', 'ticket', 60, 0, 1, 'write', NULL, 'w', 0),
(56003, 'Delete les tickets', 'ticket', 60, 0, 1, 'delete', NULL, 'd', 0),
(56004, 'Manage tickets', 'ticket', 60, 0, 1, 'manage', NULL, 'w', 0),
(56005, 'See all tickets, even if not assigned to (not effective for external users, always restricted to the thirdpardy they depends on)', 'ticket', 60, 0, 1, 'view', 'all', 'r', 0),
(64001, 'DirectPrint', 'printing', 52, 0, 1, 'read', NULL, 'r', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_session`
--

DROP TABLE IF EXISTS `jvm_session`;
CREATE TABLE `jvm_session` (
  `session_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `session_variable` text COLLATE utf8_unicode_ci,
  `last_accessed` datetime NOT NULL,
  `fk_user` int(11) NOT NULL,
  `remote_ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe`
--

DROP TABLE IF EXISTS `jvm_societe`;
CREATE TABLE `jvm_societe` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_alias` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` tinyint(4) DEFAULT '0',
  `parent` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `code_client` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_fournisseur` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_compta` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_compta_fournisseur` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_departement` int(11) DEFAULT '0',
  `fk_pays` int(11) DEFAULT '0',
  `fk_account` int(11) DEFAULT '0',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `socialnetworks` text COLLATE utf8_unicode_ci,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `snapchat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_effectif` int(11) DEFAULT '0',
  `fk_typent` int(11) DEFAULT '0',
  `fk_forme_juridique` int(11) DEFAULT '0',
  `fk_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `siren` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `siret` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ape` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idprof4` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idprof5` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idprof6` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tva_intra` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capital` double(24,8) DEFAULT NULL,
  `fk_stcomm` int(11) NOT NULL DEFAULT '0',
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prefix_comm` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client` tinyint(4) DEFAULT '0',
  `fournisseur` tinyint(4) DEFAULT '0',
  `supplier_account` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_prospectlevel` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_incoterms` int(11) DEFAULT NULL,
  `location_incoterms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_bad` tinyint(4) DEFAULT '0',
  `customer_rate` double DEFAULT '0',
  `supplier_rate` double DEFAULT '0',
  `remise_client` double DEFAULT '0',
  `remise_supplier` double DEFAULT '0',
  `mode_reglement` tinyint(4) DEFAULT NULL,
  `cond_reglement` tinyint(4) DEFAULT NULL,
  `transport_mode` tinyint(4) DEFAULT NULL,
  `mode_reglement_supplier` tinyint(4) DEFAULT NULL,
  `cond_reglement_supplier` tinyint(4) DEFAULT NULL,
  `transport_mode_supplier` tinyint(4) DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `tva_assuj` tinyint(4) DEFAULT '1',
  `localtax1_assuj` tinyint(4) DEFAULT '0',
  `localtax1_value` double(6,3) DEFAULT NULL,
  `localtax2_assuj` tinyint(4) DEFAULT '0',
  `localtax2_value` double(6,3) DEFAULT NULL,
  `barcode` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT '0',
  `price_level` int(11) DEFAULT NULL,
  `outstanding_limit` double(24,8) DEFAULT NULL,
  `order_min_amount` double(24,8) DEFAULT NULL,
  `supplier_order_min_amount` double(24,8) DEFAULT NULL,
  `default_lang` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo_squarred` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canvas` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_entrepot` int(11) DEFAULT '0',
  `webservices_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `webservices_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_account`
--

DROP TABLE IF EXISTS `jvm_societe_account`;
CREATE TABLE `jvm_societe_account` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `login` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pass_encoding` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_crypted` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_temp` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_website` int(11) DEFAULT NULL,
  `site` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_account` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key_account` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `date_last_login` datetime DEFAULT NULL,
  `date_previous_login` datetime DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) NOT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_address`
--

DROP TABLE IF EXISTS `jvm_societe_address`;
CREATE TABLE `jvm_societe_address` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT '0',
  `name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_pays` int(11) DEFAULT '0',
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_commerciaux`
--

DROP TABLE IF EXISTS `jvm_societe_commerciaux`;
CREATE TABLE `jvm_societe_commerciaux` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_contacts`
--

DROP TABLE IF EXISTS `jvm_societe_contacts`;
CREATE TABLE `jvm_societe_contacts` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL,
  `fk_soc` int(11) NOT NULL,
  `fk_c_type_contact` int(11) NOT NULL,
  `fk_socpeople` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_extrafields`
--

DROP TABLE IF EXISTS `jvm_societe_extrafields`;
CREATE TABLE `jvm_societe_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_prices`
--

DROP TABLE IF EXISTS `jvm_societe_prices`;
CREATE TABLE `jvm_societe_prices` (
  `rowid` int(11) NOT NULL,
  `fk_soc` int(11) DEFAULT '0',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `price_level` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_remise`
--

DROP TABLE IF EXISTS `jvm_societe_remise`;
CREATE TABLE `jvm_societe_remise` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `remise_client` double(6,3) NOT NULL DEFAULT '0.000',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_remise_except`
--

DROP TABLE IF EXISTS `jvm_societe_remise_except`;
CREATE TABLE `jvm_societe_remise_except` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `discount_type` int(11) NOT NULL DEFAULT '0',
  `datec` datetime DEFAULT NULL,
  `amount_ht` double(24,8) NOT NULL,
  `amount_tva` double(24,8) NOT NULL DEFAULT '0.00000000',
  `amount_ttc` double(24,8) NOT NULL DEFAULT '0.00000000',
  `tva_tx` double(6,3) NOT NULL DEFAULT '0.000',
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `fk_user` int(11) NOT NULL,
  `fk_facture_line` int(11) DEFAULT NULL,
  `fk_facture` int(11) DEFAULT NULL,
  `fk_facture_source` int(11) DEFAULT NULL,
  `fk_invoice_supplier_line` int(11) DEFAULT NULL,
  `fk_invoice_supplier` int(11) DEFAULT NULL,
  `fk_invoice_supplier_source` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `multicurrency_amount_ht` double(24,8) NOT NULL DEFAULT '0.00000000',
  `multicurrency_amount_tva` double(24,8) NOT NULL DEFAULT '0.00000000',
  `multicurrency_amount_ttc` double(24,8) NOT NULL DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_remise_supplier`
--

DROP TABLE IF EXISTS `jvm_societe_remise_supplier`;
CREATE TABLE `jvm_societe_remise_supplier` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_soc` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `remise_supplier` double(6,3) NOT NULL DEFAULT '0.000',
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_societe_rib`
--

DROP TABLE IF EXISTS `jvm_societe_rib`;
CREATE TABLE `jvm_societe_rib` (
  `rowid` int(11) NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ban',
  `label` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_banque` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_guichet` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_rib` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bic` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iban_prefix` varchar(34) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domiciliation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proprio` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_rib` smallint(6) NOT NULL DEFAULT '0',
  `rum` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_rum` date DEFAULT NULL,
  `frstrecur` varchar(16) COLLATE utf8_unicode_ci DEFAULT 'FRST',
  `last_four` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cvn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exp_date_month` int(11) DEFAULT NULL,
  `exp_date_year` int(11) DEFAULT NULL,
  `country_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved` int(11) DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `max_total_amount_of_all_payments` double(24,8) DEFAULT NULL,
  `preapproval_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `total_amount_of_all_payments` double(24,8) DEFAULT NULL,
  `stripe_card_ref` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_account` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ipaddress` varchar(68) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_socpeople`
--

DROP TABLE IF EXISTS `jvm_socpeople`;
CREATE TABLE `jvm_socpeople` (
  `rowid` int(11) NOT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_soc` int(11) DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civility` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_departement` int(11) DEFAULT NULL,
  `fk_pays` int(11) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `poste` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_perso` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_mobile` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `socialnetworks` text COLLATE utf8_unicode_ci,
  `jabberid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `snapchat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `googleplus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_email` smallint(6) NOT NULL DEFAULT '0',
  `priv` smallint(6) NOT NULL DEFAULT '0',
  `fk_prospectcontactlevel` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_stcommcontact` int(11) NOT NULL DEFAULT '0',
  `fk_user_creat` int(11) DEFAULT '0',
  `fk_user_modif` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `default_lang` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `canvas` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_socpeople_extrafields`
--

DROP TABLE IF EXISTS `jvm_socpeople_extrafields`;
CREATE TABLE `jvm_socpeople_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_stock_mouvement`
--

DROP TABLE IF EXISTS `jvm_stock_mouvement`;
CREATE TABLE `jvm_stock_mouvement` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datem` datetime DEFAULT NULL,
  `fk_product` int(11) NOT NULL,
  `batch` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL,
  `fk_entrepot` int(11) NOT NULL,
  `value` double DEFAULT NULL,
  `price` double(24,8) DEFAULT '0.00000000',
  `type_mouvement` smallint(6) DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inventorycode` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_project` int(11) DEFAULT NULL,
  `fk_origin` int(11) DEFAULT NULL,
  `origintype` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_projet` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_subscription`
--

DROP TABLE IF EXISTS `jvm_subscription`;
CREATE TABLE `jvm_subscription` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `fk_adherent` int(11) DEFAULT NULL,
  `fk_type` int(11) DEFAULT NULL,
  `dateadh` datetime DEFAULT NULL,
  `datef` datetime DEFAULT NULL,
  `subscription` double(24,8) DEFAULT NULL,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_supplier_proposal`
--

DROP TABLE IF EXISTS `jvm_supplier_proposal`;
CREATE TABLE `jvm_supplier_proposal` (
  `rowid` int(11) NOT NULL,
  `ref` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_projet` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `date_cloture` datetime DEFAULT NULL,
  `fk_user_author` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `fk_user_valid` int(11) DEFAULT NULL,
  `fk_user_cloture` int(11) DEFAULT NULL,
  `fk_statut` smallint(6) NOT NULL DEFAULT '0',
  `price` double DEFAULT '0',
  `remise_percent` double DEFAULT '0',
  `remise_absolue` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `tva` double(24,8) DEFAULT '0.00000000',
  `localtax1` double(24,8) DEFAULT '0.00000000',
  `localtax2` double(24,8) DEFAULT '0.00000000',
  `total` double(24,8) DEFAULT '0.00000000',
  `fk_account` int(11) DEFAULT NULL,
  `fk_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_cond_reglement` int(11) DEFAULT NULL,
  `fk_mode_reglement` int(11) DEFAULT NULL,
  `note_private` text COLLATE utf8_unicode_ci,
  `note_public` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_main_doc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_livraison` date DEFAULT NULL,
  `fk_shipping_method` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extraparams` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_tx` double(24,8) DEFAULT '1.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_supplier_proposaldet`
--

DROP TABLE IF EXISTS `jvm_supplier_proposaldet`;
CREATE TABLE `jvm_supplier_proposaldet` (
  `rowid` int(11) NOT NULL,
  `fk_supplier_proposal` int(11) NOT NULL,
  `fk_parent_line` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `fk_remise_except` int(11) DEFAULT NULL,
  `vat_src_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT '',
  `tva_tx` double(6,3) DEFAULT '0.000',
  `localtax1_tx` double(6,3) DEFAULT '0.000',
  `localtax1_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localtax2_tx` double(6,3) DEFAULT '0.000',
  `localtax2_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `remise_percent` double DEFAULT '0',
  `remise` double DEFAULT '0',
  `price` double DEFAULT NULL,
  `subprice` double(24,8) DEFAULT '0.00000000',
  `total_ht` double(24,8) DEFAULT '0.00000000',
  `total_tva` double(24,8) DEFAULT '0.00000000',
  `total_localtax1` double(24,8) DEFAULT '0.00000000',
  `total_localtax2` double(24,8) DEFAULT '0.00000000',
  `total_ttc` double(24,8) DEFAULT '0.00000000',
  `product_type` int(11) DEFAULT '0',
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `info_bits` int(11) DEFAULT '0',
  `buy_price_ht` double(24,8) DEFAULT '0.00000000',
  `fk_product_fournisseur_price` int(11) DEFAULT NULL,
  `special_code` int(11) DEFAULT '0',
  `rang` int(11) DEFAULT '0',
  `ref_fourn` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_multicurrency` int(11) DEFAULT NULL,
  `multicurrency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multicurrency_subprice` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ht` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_tva` double(24,8) DEFAULT '0.00000000',
  `multicurrency_total_ttc` double(24,8) DEFAULT '0.00000000',
  `fk_unit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_supplier_proposaldet_extrafields`
--

DROP TABLE IF EXISTS `jvm_supplier_proposaldet_extrafields`;
CREATE TABLE `jvm_supplier_proposaldet_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_supplier_proposal_extrafields`
--

DROP TABLE IF EXISTS `jvm_supplier_proposal_extrafields`;
CREATE TABLE `jvm_supplier_proposal_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_takepos_floor_tables`
--

DROP TABLE IF EXISTS `jvm_takepos_floor_tables`;
CREATE TABLE `jvm_takepos_floor_tables` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leftpos` float DEFAULT NULL,
  `toppos` float DEFAULT NULL,
  `floor` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ticket`
--

DROP TABLE IF EXISTS `jvm_ticket`;
CREATE TABLE `jvm_ticket` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) DEFAULT '1',
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `track_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fk_soc` int(11) DEFAULT '0',
  `fk_project` int(11) DEFAULT '0',
  `origin_email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_create` int(11) DEFAULT NULL,
  `fk_user_assign` int(11) DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `fk_statut` int(11) DEFAULT NULL,
  `resolution` int(11) DEFAULT NULL,
  `progress` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timing` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `severity_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `date_close` datetime DEFAULT NULL,
  `notify_tiers_at_create` tinyint(4) DEFAULT NULL,
  `email_msgid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_ticket_extrafields`
--

DROP TABLE IF EXISTS `jvm_ticket_extrafields`;
CREATE TABLE `jvm_ticket_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_tva`
--

DROP TABLE IF EXISTS `jvm_tva`;
CREATE TABLE `jvm_tva` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `datec` datetime DEFAULT NULL,
  `datep` date DEFAULT NULL,
  `datev` date DEFAULT NULL,
  `amount` double(24,8) NOT NULL DEFAULT '0.00000000',
  `fk_typepayment` int(11) DEFAULT NULL,
  `num_payment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `note` text COLLATE utf8_unicode_ci,
  `fk_bank` int(11) DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user`
--

DROP TABLE IF EXISTS `jvm_user`;
CREATE TABLE `jvm_user` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref_ext` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_int` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` smallint(6) DEFAULT '0',
  `employee` tinyint(4) DEFAULT '1',
  `fk_establishment` int(11) DEFAULT '0',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `login` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pass_encoding` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_crypted` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_temp` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `civility` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_state` int(11) DEFAULT '0',
  `fk_country` int(11) DEFAULT '0',
  `birth` date DEFAULT NULL,
  `job` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature` text COLLATE utf8_unicode_ci,
  `socialnetworks` text COLLATE utf8_unicode_ci,
  `fk_soc` int(11) DEFAULT NULL,
  `fk_socpeople` int(11) DEFAULT NULL,
  `fk_member` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_user_expense_validator` int(11) DEFAULT NULL,
  `fk_user_holiday_validator` int(11) DEFAULT NULL,
  `idpers1` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idpers2` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idpers3` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_public` text COLLATE utf8_unicode_ci,
  `note` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datelastlogin` datetime DEFAULT NULL,
  `datepreviouslogin` datetime DEFAULT NULL,
  `datelastpassvalidation` datetime DEFAULT NULL,
  `datestartvalidity` datetime DEFAULT NULL,
  `dateendvalidity` datetime DEFAULT NULL,
  `iplastlogin` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ippreviouslogin` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `egroupware_id` int(11) DEFAULT NULL,
  `ldap_sid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `statut` tinyint(4) DEFAULT '1',
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_barcode_type` int(11) DEFAULT '0',
  `accountancy_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nb_holiday` int(11) DEFAULT '0',
  `thm` double(24,8) DEFAULT NULL,
  `tjm` double(24,8) DEFAULT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `salaryextra` double(24,8) DEFAULT NULL,
  `dateemployment` date DEFAULT NULL,
  `dateemploymentend` date DEFAULT NULL,
  `weeklyhours` double(16,8) DEFAULT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_range` int(11) DEFAULT NULL,
  `default_c_exp_tax_cat` int(11) DEFAULT NULL,
  `fk_warehouse` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_user`
--

INSERT INTO `jvm_user` (`rowid`, `entity`, `ref_ext`, `ref_int`, `admin`, `employee`, `fk_establishment`, `datec`, `tms`, `fk_user_creat`, `fk_user_modif`, `login`, `pass_encoding`, `pass`, `pass_crypted`, `pass_temp`, `api_key`, `gender`, `civility`, `lastname`, `firstname`, `address`, `zip`, `town`, `fk_state`, `fk_country`, `birth`, `job`, `office_phone`, `office_fax`, `user_mobile`, `personal_mobile`, `email`, `personal_email`, `signature`, `socialnetworks`, `fk_soc`, `fk_socpeople`, `fk_member`, `fk_user`, `fk_user_expense_validator`, `fk_user_holiday_validator`, `idpers1`, `idpers2`, `idpers3`, `note_public`, `note`, `model_pdf`, `datelastlogin`, `datepreviouslogin`, `datelastpassvalidation`, `datestartvalidity`, `dateendvalidity`, `iplastlogin`, `ippreviouslogin`, `egroupware_id`, `ldap_sid`, `openid`, `statut`, `photo`, `lang`, `color`, `barcode`, `fk_barcode_type`, `accountancy_code`, `nb_holiday`, `thm`, `tjm`, `salary`, `salaryextra`, `dateemployment`, `dateemploymentend`, `weeklyhours`, `import_key`, `default_range`, `default_c_exp_tax_cat`, `fk_warehouse`) VALUES
(1, 0, NULL, NULL, 1, 1, 0, '2021-01-22 06:42:34', '2021-01-22 07:49:13', NULL, NULL, 'jvmd_admin', NULL, NULL, '$2y$10$i.GF7SYXSf7y3N5QpqKZmO8azx2cNVT5LYQv.Kqyr5igfttNOv7Wa', NULL, NULL, NULL, '', 'SuperAdmin', '', '', '', '', NULL, NULL, NULL, 'Board Of Director', '', '', '', '', 'support@microprixs.com', '', '', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, '2021-01-27 07:10:44', '2021-01-25 14:15:31', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 1, 'blue-star-limited-logo-vector.png', NULL, '', NULL, 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, NULL, NULL, 0, 0, 0, '2021-01-23 13:32:19', '2021-01-25 14:11:48', NULL, NULL, 'jvmd_sub_admin', NULL, NULL, '$2y$10$AXvxq7GpqHfEAFT.QnvVe.zJCrdr73PzgLku8V2tkZ/8LlWaIkwQ.', NULL, 'kg84yh2m59', 'man', 'MR', 'Admin', '', '', '', '', NULL, NULL, NULL, '', '', '', '', '', 'sub-admin@jvmd.com', '', '', '[]', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '', '', NULL, '2021-01-25 14:10:26', '2021-01-25 14:06:08', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 1, NULL, NULL, '', NULL, 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, NULL, NULL, 0, 1, 0, '2021-01-23 13:35:04', '2021-01-25 14:12:31', NULL, NULL, 'jvmd_rm', NULL, NULL, '$2y$10$UlaTbXOVYCOkHwn4XKzOg.xeX7hWPAbRS1oPO4wS8x3U9tboYIRBq', NULL, '837cq49pxs', 'man', 'MR', 'jvmd_RM', 'Regional Manager', '', '', '', NULL, NULL, NULL, '', '', '', '', '', 'rm@jvmd.com', '', '', '[]', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, '', '', NULL, '2021-01-23 13:57:16', '2021-01-23 13:54:52', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 1, NULL, NULL, '', NULL, 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, NULL, NULL, 0, 1, 0, '2021-01-23 13:39:07', '2021-01-25 14:12:58', NULL, NULL, 'usr_vendor', NULL, NULL, '$2y$10$pgDnLhj/JG9I/2ufL.STLO4UiZNxX1gbZVLV08xgPvEDyS.IvrFDe', NULL, '6d5z0byfrg', 'man', 'MR', 'vendor', 'Microprixs', '', '', '', NULL, NULL, NULL, '', '', '', '', '', 'vendor@jvmd.com', '', '', '[]', NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, '', '', NULL, '2021-01-23 13:58:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 1, NULL, NULL, '', NULL, 0, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_usergroup`
--

DROP TABLE IF EXISTS `jvm_usergroup`;
CREATE TABLE `jvm_usergroup` (
  `rowid` int(11) NOT NULL,
  `nom` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` text COLLATE utf8_unicode_ci,
  `model_pdf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_usergroup`
--

INSERT INTO `jvm_usergroup` (`rowid`, `nom`, `entity`, `datec`, `tms`, `note`, `model_pdf`) VALUES
(1, 'Employee', 1, '2021-01-22 07:51:04', '2021-01-22 07:51:04', 'Super Admin', NULL),
(2, 'Admin', 1, '2021-01-23 10:58:39', '2021-01-23 10:58:39', 'Admin', NULL),
(3, 'RM', 1, '2021-01-23 10:59:07', '2021-01-23 10:59:07', 'Regional Manager', NULL),
(4, 'Vendors', 1, '2021-01-23 10:59:39', '2021-01-23 10:59:39', 'Vendors', NULL),
(5, 'Call Center', 1, '2021-01-23 10:59:56', '2021-01-23 10:59:56', 'Call Center', NULL),
(6, 'All India Head', 1, '2021-01-25 13:33:24', '2021-01-25 13:33:24', 'All India Head', NULL),
(7, 'Service', 1, '2021-01-25 13:34:00', '2021-01-25 13:34:00', 'Service', NULL),
(8, 'Sale', 1, '2021-01-25 13:34:17', '2021-01-25 13:34:17', 'Sale', NULL),
(9, 'Deliver', 1, '2021-01-25 13:34:31', '2021-01-25 13:34:31', 'Deliver', NULL),
(10, 'Commercial', 1, '2021-01-25 13:34:44', '2021-01-25 13:34:44', 'Commercial', NULL),
(11, 'Central Basic Officer', 1, '2021-01-25 13:35:27', '2021-01-25 13:35:27', 'Central Basic Officer&nbsp;', NULL),
(12, 'Service Manager', 1, '2021-01-25 13:36:01', '2021-01-25 13:36:01', 'Service Manager', NULL),
(13, 'Service Executive', 1, '2021-01-25 13:36:20', '2021-01-25 13:36:20', 'Service Executive', NULL),
(14, 'Technician', 1, '2021-01-25 13:36:56', '2021-01-25 13:36:56', 'Technician&nbsp;', NULL),
(15, 'Super Admin', 1, '2021-01-25 13:38:46', '2021-01-25 13:38:46', 'Super Admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_usergroup_extrafields`
--

DROP TABLE IF EXISTS `jvm_usergroup_extrafields`;
CREATE TABLE `jvm_usergroup_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_usergroup_rights`
--

DROP TABLE IF EXISTS `jvm_usergroup_rights`;
CREATE TABLE `jvm_usergroup_rights` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_usergroup` int(11) NOT NULL,
  `fk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_usergroup_rights`
--

INSERT INTO `jvm_usergroup_rights` (`rowid`, `entity`, `fk_usergroup`, `fk_id`) VALUES
(227, 1, 2, 11),
(228, 1, 2, 12),
(229, 1, 2, 13),
(230, 1, 2, 14),
(231, 1, 2, 15),
(232, 1, 2, 16),
(233, 1, 2, 19),
(234, 1, 2, 21),
(235, 1, 2, 22),
(236, 1, 2, 24),
(237, 1, 2, 25),
(238, 1, 2, 26),
(239, 1, 2, 27),
(240, 1, 2, 28),
(241, 1, 2, 31),
(242, 1, 2, 32),
(243, 1, 2, 34),
(244, 1, 2, 38),
(245, 1, 2, 39),
(246, 1, 2, 41),
(247, 1, 2, 42),
(248, 1, 2, 44),
(249, 1, 2, 45),
(250, 1, 2, 71),
(251, 1, 2, 72),
(252, 1, 2, 74),
(253, 1, 2, 75),
(254, 1, 2, 76),
(255, 1, 2, 78),
(256, 1, 2, 79),
(257, 1, 2, 81),
(258, 1, 2, 82),
(259, 1, 2, 84),
(260, 1, 2, 86),
(261, 1, 2, 87),
(262, 1, 2, 88),
(263, 1, 2, 89),
(264, 1, 2, 91),
(265, 1, 2, 92),
(266, 1, 2, 93),
(267, 1, 2, 94),
(268, 1, 2, 101),
(269, 1, 2, 102),
(270, 1, 2, 104),
(271, 1, 2, 105),
(272, 1, 2, 106),
(273, 1, 2, 109),
(274, 1, 2, 121),
(275, 1, 2, 122),
(276, 1, 2, 125),
(277, 1, 2, 126),
(278, 1, 2, 141),
(279, 1, 2, 142),
(280, 1, 2, 144),
(281, 1, 2, 221),
(282, 1, 2, 222),
(283, 1, 2, 223),
(284, 1, 2, 229),
(285, 1, 2, 237),
(286, 1, 2, 238),
(287, 1, 2, 239),
(288, 1, 2, 241),
(289, 1, 2, 242),
(290, 1, 2, 243),
(291, 1, 2, 251),
(292, 1, 2, 252),
(294, 1, 2, 254),
(297, 1, 2, 262),
(298, 1, 2, 281),
(299, 1, 2, 282),
(300, 1, 2, 283),
(301, 1, 2, 286),
(302, 1, 2, 300),
(303, 1, 2, 301),
(304, 1, 2, 341),
(772, 1, 2, 342),
(771, 1, 2, 343),
(307, 1, 2, 344),
(308, 1, 2, 351),
(309, 1, 2, 352),
(310, 1, 2, 353),
(311, 1, 2, 354),
(313, 1, 2, 430),
(314, 1, 2, 531),
(315, 1, 2, 532),
(316, 1, 2, 534),
(317, 1, 2, 538),
(318, 1, 2, 1001),
(319, 1, 2, 1002),
(320, 1, 2, 1003),
(321, 1, 2, 1004),
(322, 1, 2, 1005),
(323, 1, 2, 1101),
(324, 1, 2, 1102),
(325, 1, 2, 1104),
(326, 1, 2, 1109),
(327, 1, 2, 1121),
(328, 1, 2, 1122),
(329, 1, 2, 1123),
(330, 1, 2, 1124),
(331, 1, 2, 1125),
(332, 1, 2, 1126),
(333, 1, 2, 1181),
(334, 1, 2, 1182),
(335, 1, 2, 1183),
(336, 1, 2, 1184),
(337, 1, 2, 1185),
(338, 1, 2, 1186),
(339, 1, 2, 1187),
(340, 1, 2, 1188),
(341, 1, 2, 1189),
(342, 1, 2, 1191),
(343, 1, 2, 1201),
(344, 1, 2, 1202),
(345, 1, 2, 1231),
(346, 1, 2, 1232),
(347, 1, 2, 1233),
(348, 1, 2, 1234),
(349, 1, 2, 1235),
(350, 1, 2, 1236),
(351, 1, 2, 1251),
(352, 1, 2, 1321),
(353, 1, 2, 1322),
(354, 1, 2, 1421),
(355, 1, 2, 23001),
(356, 1, 2, 23002),
(357, 1, 2, 23003),
(358, 1, 2, 23004),
(359, 1, 2, 64001),
(626, 1, 15, 11),
(627, 1, 15, 12),
(628, 1, 15, 13),
(629, 1, 15, 14),
(630, 1, 15, 15),
(631, 1, 15, 16),
(632, 1, 15, 19),
(633, 1, 15, 21),
(634, 1, 15, 22),
(635, 1, 15, 24),
(636, 1, 15, 25),
(637, 1, 15, 26),
(638, 1, 15, 27),
(639, 1, 15, 28),
(640, 1, 15, 31),
(641, 1, 15, 32),
(642, 1, 15, 34),
(643, 1, 15, 38),
(644, 1, 15, 39),
(645, 1, 15, 41),
(646, 1, 15, 42),
(647, 1, 15, 44),
(648, 1, 15, 45),
(649, 1, 15, 71),
(650, 1, 15, 72),
(651, 1, 15, 74),
(652, 1, 15, 75),
(653, 1, 15, 76),
(654, 1, 15, 78),
(655, 1, 15, 79),
(656, 1, 15, 81),
(657, 1, 15, 82),
(658, 1, 15, 84),
(659, 1, 15, 86),
(660, 1, 15, 87),
(661, 1, 15, 88),
(662, 1, 15, 89),
(663, 1, 15, 91),
(664, 1, 15, 92),
(665, 1, 15, 93),
(666, 1, 15, 94),
(667, 1, 15, 101),
(668, 1, 15, 102),
(669, 1, 15, 104),
(670, 1, 15, 105),
(671, 1, 15, 106),
(672, 1, 15, 109),
(673, 1, 15, 121),
(674, 1, 15, 122),
(675, 1, 15, 125),
(676, 1, 15, 126),
(677, 1, 15, 141),
(678, 1, 15, 142),
(679, 1, 15, 144),
(680, 1, 15, 221),
(681, 1, 15, 222),
(682, 1, 15, 223),
(683, 1, 15, 229),
(684, 1, 15, 237),
(685, 1, 15, 238),
(686, 1, 15, 239),
(687, 1, 15, 241),
(688, 1, 15, 242),
(689, 1, 15, 243),
(690, 1, 15, 251),
(691, 1, 15, 252),
(692, 1, 15, 253),
(693, 1, 15, 254),
(694, 1, 15, 255),
(695, 1, 15, 256),
(696, 1, 15, 262),
(697, 1, 15, 281),
(698, 1, 15, 282),
(699, 1, 15, 283),
(700, 1, 15, 286),
(701, 1, 15, 300),
(702, 1, 15, 301),
(703, 1, 15, 341),
(704, 1, 15, 342),
(705, 1, 15, 343),
(706, 1, 15, 344),
(707, 1, 15, 351),
(708, 1, 15, 352),
(709, 1, 15, 353),
(710, 1, 15, 354),
(711, 1, 15, 358),
(712, 1, 15, 430),
(713, 1, 15, 531),
(714, 1, 15, 532),
(715, 1, 15, 534),
(716, 1, 15, 538),
(717, 1, 15, 1001),
(718, 1, 15, 1002),
(719, 1, 15, 1003),
(720, 1, 15, 1004),
(721, 1, 15, 1005),
(722, 1, 15, 1101),
(723, 1, 15, 1102),
(724, 1, 15, 1104),
(725, 1, 15, 1109),
(726, 1, 15, 1121),
(727, 1, 15, 1122),
(728, 1, 15, 1123),
(729, 1, 15, 1124),
(730, 1, 15, 1125),
(731, 1, 15, 1126),
(732, 1, 15, 1181),
(733, 1, 15, 1182),
(734, 1, 15, 1183),
(735, 1, 15, 1184),
(736, 1, 15, 1185),
(737, 1, 15, 1186),
(738, 1, 15, 1187),
(739, 1, 15, 1188),
(740, 1, 15, 1189),
(741, 1, 15, 1191),
(742, 1, 15, 1201),
(743, 1, 15, 1202),
(744, 1, 15, 1231),
(745, 1, 15, 1232),
(746, 1, 15, 1233),
(747, 1, 15, 1234),
(748, 1, 15, 1235),
(749, 1, 15, 1236),
(750, 1, 15, 1251),
(751, 1, 15, 1321),
(752, 1, 15, 1322),
(753, 1, 15, 1421),
(754, 1, 15, 2401),
(755, 1, 15, 2402),
(756, 1, 15, 2403),
(757, 1, 15, 2411),
(758, 1, 15, 2412),
(759, 1, 15, 2413),
(760, 1, 15, 2414),
(761, 1, 15, 23001),
(762, 1, 15, 23002),
(763, 1, 15, 23003),
(764, 1, 15, 23004),
(765, 1, 15, 56001),
(766, 1, 15, 56002),
(767, 1, 15, 56003),
(768, 1, 15, 56004),
(769, 1, 15, 56005),
(770, 1, 15, 64001);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_usergroup_user`
--

DROP TABLE IF EXISTS `jvm_usergroup_user`;
CREATE TABLE `jvm_usergroup_user` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_user` int(11) NOT NULL,
  `fk_usergroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_usergroup_user`
--

INSERT INTO `jvm_usergroup_user` (`rowid`, `entity`, `fk_user`, `fk_usergroup`) VALUES
(1, 1, 1, 1),
(7, 1, 2, 2),
(6, 1, 3, 3),
(8, 1, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_alert`
--

DROP TABLE IF EXISTS `jvm_user_alert`;
CREATE TABLE `jvm_user_alert` (
  `rowid` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `fk_contact` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_clicktodial`
--

DROP TABLE IF EXISTS `jvm_user_clicktodial`;
CREATE TABLE `jvm_user_clicktodial` (
  `fk_user` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poste` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_employment`
--

DROP TABLE IF EXISTS `jvm_user_employment`;
CREATE TABLE `jvm_user_employment` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ref_ext` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `job` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `salary` double(24,8) DEFAULT NULL,
  `salaryextra` double(24,8) DEFAULT NULL,
  `weeklyhours` double(16,8) DEFAULT NULL,
  `dateemployment` date DEFAULT NULL,
  `dateemploymentend` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_extrafields`
--

DROP TABLE IF EXISTS `jvm_user_extrafields`;
CREATE TABLE `jvm_user_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_param`
--

DROP TABLE IF EXISTS `jvm_user_param`;
CREATE TABLE `jvm_user_param` (
  `fk_user` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `param` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_rib`
--

DROP TABLE IF EXISTS `jvm_user_rib`;
CREATE TABLE `jvm_user_rib` (
  `rowid` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `datec` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `label` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_banque` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code_guichet` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cle_rib` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bic` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iban_prefix` varchar(34) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domiciliation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proprio` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_user_rights`
--

DROP TABLE IF EXISTS `jvm_user_rights`;
CREATE TABLE `jvm_user_rights` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `fk_user` int(11) NOT NULL,
  `fk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jvm_user_rights`
--

INSERT INTO `jvm_user_rights` (`rowid`, `entity`, `fk_user`, `fk_id`) VALUES
(93, 1, 1, 11),
(87, 1, 1, 12),
(88, 1, 1, 13),
(89, 1, 1, 14),
(90, 1, 1, 15),
(92, 1, 1, 16),
(94, 1, 1, 19),
(37, 1, 1, 21),
(30, 1, 1, 22),
(31, 1, 1, 24),
(32, 1, 1, 25),
(34, 1, 1, 26),
(36, 1, 1, 27),
(38, 1, 1, 28),
(111, 1, 1, 31),
(106, 1, 1, 32),
(108, 1, 1, 34),
(110, 1, 1, 38),
(112, 1, 1, 39),
(147, 1, 1, 41),
(144, 1, 1, 42),
(146, 1, 1, 44),
(148, 1, 1, 45),
(8, 1, 1, 71),
(3, 1, 1, 72),
(5, 1, 1, 74),
(9, 1, 1, 75),
(7, 1, 1, 76),
(11, 1, 1, 78),
(12, 1, 1, 79),
(46, 1, 1, 81),
(41, 1, 1, 82),
(42, 1, 1, 84),
(43, 1, 1, 86),
(44, 1, 1, 87),
(45, 1, 1, 88),
(47, 1, 1, 89),
(102, 1, 1, 91),
(99, 1, 1, 92),
(101, 1, 1, 93),
(103, 1, 1, 94),
(134, 1, 1, 101),
(130, 1, 1, 102),
(131, 1, 1, 104),
(132, 1, 1, 105),
(133, 1, 1, 106),
(135, 1, 1, 109),
(18, 1, 1, 121),
(15, 1, 1, 122),
(17, 1, 1, 125),
(19, 1, 1, 126),
(152, 1, 1, 141),
(151, 1, 1, 142),
(153, 1, 1, 144),
(170, 1, 1, 221),
(167, 1, 1, 222),
(169, 1, 1, 223),
(171, 1, 1, 229),
(172, 1, 1, 237),
(173, 1, 1, 238),
(174, 1, 1, 239),
(157, 1, 1, 241),
(156, 1, 1, 242),
(158, 1, 1, 243),
(20, 1, 1, 262),
(26, 1, 1, 281),
(23, 1, 1, 282),
(25, 1, 1, 283),
(27, 1, 1, 286),
(159, 1, 1, 300),
(160, 1, 1, 301),
(183, 1, 1, 430),
(118, 1, 1, 531),
(115, 1, 1, 532),
(117, 1, 1, 534),
(119, 1, 1, 538),
(123, 1, 1, 1001),
(122, 1, 1, 1002),
(124, 1, 1, 1003),
(126, 1, 1, 1004),
(127, 1, 1, 1005),
(140, 1, 1, 1101),
(138, 1, 1, 1102),
(139, 1, 1, 1104),
(141, 1, 1, 1109),
(83, 1, 1, 1121),
(76, 1, 1, 1122),
(78, 1, 1, 1123),
(80, 1, 1, 1124),
(82, 1, 1, 1125),
(84, 1, 1, 1126),
(49, 1, 1, 1181),
(63, 1, 1, 1182),
(52, 1, 1, 1183),
(53, 1, 1, 1184),
(55, 1, 1, 1185),
(57, 1, 1, 1186),
(59, 1, 1, 1187),
(62, 1, 1, 1188),
(60, 1, 1, 1189),
(64, 1, 1, 1191),
(163, 1, 1, 1201),
(164, 1, 1, 1202),
(72, 1, 1, 1231),
(67, 1, 1, 1232),
(68, 1, 1, 1233),
(70, 1, 1, 1234),
(71, 1, 1, 1235),
(73, 1, 1, 1236),
(161, 1, 1, 1251),
(95, 1, 1, 1321),
(96, 1, 1, 1322),
(48, 1, 1, 1421),
(212, 1, 1, 2401),
(209, 1, 1, 2402),
(213, 1, 1, 2403),
(222, 1, 1, 2411),
(219, 1, 1, 2412),
(223, 1, 1, 2413),
(226, 1, 1, 2414),
(181, 1, 1, 23001),
(178, 1, 1, 23002),
(180, 1, 1, 23003),
(182, 1, 1, 23004),
(238, 1, 1, 56001),
(231, 1, 1, 56002),
(235, 1, 1, 56003),
(239, 1, 1, 56004),
(242, 1, 1, 56005),
(175, 1, 1, 64001),
(184, 1, 2, 300),
(185, 1, 2, 430),
(214, 1, 2, 2401),
(211, 1, 2, 2402),
(215, 1, 2, 2403),
(224, 1, 2, 2411),
(221, 1, 2, 2412),
(225, 1, 2, 2413),
(227, 1, 2, 2414),
(240, 1, 2, 56001),
(233, 1, 2, 56002),
(237, 1, 2, 56003),
(241, 1, 2, 56004),
(243, 1, 2, 56005),
(186, 1, 3, 300),
(187, 1, 3, 430),
(188, 1, 4, 300),
(189, 1, 4, 430);

-- --------------------------------------------------------

--
-- Table structure for table `jvm_website`
--

DROP TABLE IF EXISTS `jvm_website`;
CREATE TABLE `jvm_website` (
  `rowid` int(11) NOT NULL,
  `type_container` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'page',
  `entity` int(11) NOT NULL DEFAULT '1',
  `ref` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maincolor` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maincolorbis` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otherlang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `fk_default_home` int(11) DEFAULT NULL,
  `use_manifest` int(11) DEFAULT NULL,
  `virtualhost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `position` int(11) DEFAULT '0',
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_website_extrafields`
--

DROP TABLE IF EXISTS `jvm_website_extrafields`;
CREATE TABLE `jvm_website_extrafields` (
  `rowid` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_object` int(11) NOT NULL,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_website_page`
--

DROP TABLE IF EXISTS `jvm_website_page`;
CREATE TABLE `jvm_website_page` (
  `rowid` int(11) NOT NULL,
  `fk_website` int(11) NOT NULL,
  `type_container` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'page',
  `pageurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `aliasalt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_page` int(11) DEFAULT NULL,
  `allowed_in_frames` int(11) DEFAULT '0',
  `htmlheader` text COLLATE utf8_unicode_ci,
  `content` mediumtext COLLATE utf8_unicode_ci,
  `status` int(11) DEFAULT '1',
  `grabbed_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_user_creat` int(11) DEFAULT NULL,
  `fk_user_modif` int(11) DEFAULT NULL,
  `author_alias` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fk_object` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jvm_zapier_hook`
--

DROP TABLE IF EXISTS `jvm_zapier_hook`;
CREATE TABLE `jvm_zapier_hook` (
  `rowid` int(11) NOT NULL,
  `entity` int(11) NOT NULL DEFAULT '1',
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_creation` datetime NOT NULL,
  `fk_user` int(11) NOT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `import_key` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jvm_accounting_account`
--
ALTER TABLE `jvm_accounting_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_account` (`account_number`,`entity`,`fk_pcg_version`),
  ADD KEY `idx_accounting_account_fk_pcg_version` (`fk_pcg_version`),
  ADD KEY `idx_accounting_account_account_parent` (`account_parent`);

--
-- Indexes for table `jvm_accounting_bookkeeping`
--
ALTER TABLE `jvm_accounting_bookkeeping`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_accounting_bookkeeping_doc_date` (`doc_date`),
  ADD KEY `idx_accounting_bookkeeping_fk_doc` (`fk_doc`),
  ADD KEY `idx_accounting_bookkeeping_fk_docdet` (`fk_docdet`),
  ADD KEY `idx_accounting_bookkeeping_numero_compte` (`numero_compte`),
  ADD KEY `idx_accounting_bookkeeping_code_journal` (`code_journal`);

--
-- Indexes for table `jvm_accounting_bookkeeping_tmp`
--
ALTER TABLE `jvm_accounting_bookkeeping_tmp`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_accounting_bookkeeping_tmp_doc_date` (`doc_date`),
  ADD KEY `idx_accounting_bookkeeping_tmp_fk_docdet` (`fk_docdet`),
  ADD KEY `idx_accounting_bookkeeping_tmp_numero_compte` (`numero_compte`),
  ADD KEY `idx_accounting_bookkeeping_tmp_code_journal` (`code_journal`);

--
-- Indexes for table `jvm_accounting_fiscalyear`
--
ALTER TABLE `jvm_accounting_fiscalyear`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_accounting_journal`
--
ALTER TABLE `jvm_accounting_journal`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_journal_code` (`code`,`entity`);

--
-- Indexes for table `jvm_accounting_system`
--
ALTER TABLE `jvm_accounting_system`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_accounting_system_pcg_version` (`pcg_version`);

--
-- Indexes for table `jvm_actioncomm`
--
ALTER TABLE `jvm_actioncomm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_actioncomm_fk_soc` (`fk_soc`),
  ADD KEY `idx_actioncomm_fk_contact` (`fk_contact`),
  ADD KEY `idx_actioncomm_code` (`code`),
  ADD KEY `idx_actioncomm_fk_element` (`fk_element`),
  ADD KEY `idx_actioncomm_fk_user_action` (`fk_user_action`),
  ADD KEY `idx_actioncomm_fk_project` (`fk_project`),
  ADD KEY `idx_actioncomm_datep` (`datep`),
  ADD KEY `idx_actioncomm_datep2` (`datep2`),
  ADD KEY `idx_actioncomm_recurid` (`recurid`),
  ADD KEY `idx_actioncomm_ref_ext` (`ref_ext`);

--
-- Indexes for table `jvm_actioncomm_extrafields`
--
ALTER TABLE `jvm_actioncomm_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_actioncomm_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_actioncomm_reminder`
--
ALTER TABLE `jvm_actioncomm_reminder`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_actioncomm_reminder_unique` (`fk_actioncomm`,`fk_user`,`typeremind`,`offsetvalue`,`offsetunit`),
  ADD KEY `idx_actioncomm_reminder_dateremind` (`dateremind`),
  ADD KEY `idx_actioncomm_reminder_fk_user` (`fk_user`),
  ADD KEY `idx_actioncomm_reminder_status` (`status`);

--
-- Indexes for table `jvm_actioncomm_resources`
--
ALTER TABLE `jvm_actioncomm_resources`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_actioncomm_resources` (`fk_actioncomm`,`element_type`,`fk_element`),
  ADD KEY `idx_actioncomm_resources_fk_element` (`fk_element`);

--
-- Indexes for table `jvm_adherent`
--
ALTER TABLE `jvm_adherent`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_adherent_login` (`login`,`entity`),
  ADD UNIQUE KEY `uk_adherent_fk_soc` (`fk_soc`),
  ADD KEY `idx_adherent_fk_adherent_type` (`fk_adherent_type`);

--
-- Indexes for table `jvm_adherent_extrafields`
--
ALTER TABLE `jvm_adherent_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_adherent_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_adherent_type`
--
ALTER TABLE `jvm_adherent_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_adherent_type_libelle` (`libelle`,`entity`);

--
-- Indexes for table `jvm_adherent_type_extrafields`
--
ALTER TABLE `jvm_adherent_type_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_adherent_type_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_adherent_type_lang`
--
ALTER TABLE `jvm_adherent_type_lang`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_advtargetemailing`
--
ALTER TABLE `jvm_advtargetemailing`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_advtargetemailing_name` (`name`);

--
-- Indexes for table `jvm_asset`
--
ALTER TABLE `jvm_asset`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_asset_rowid` (`rowid`),
  ADD KEY `idx_asset_ref` (`ref`),
  ADD KEY `idx_asset_entity` (`entity`),
  ADD KEY `idx_asset_fk_asset_type` (`fk_asset_type`);

--
-- Indexes for table `jvm_asset_extrafields`
--
ALTER TABLE `jvm_asset_extrafields`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_asset_type`
--
ALTER TABLE `jvm_asset_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_asset_type_label` (`label`,`entity`);

--
-- Indexes for table `jvm_asset_type_extrafields`
--
ALTER TABLE `jvm_asset_type_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_asset_type_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_bank`
--
ALTER TABLE `jvm_bank`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bank_datev` (`datev`),
  ADD KEY `idx_bank_dateo` (`dateo`),
  ADD KEY `idx_bank_fk_account` (`fk_account`),
  ADD KEY `idx_bank_rappro` (`rappro`),
  ADD KEY `idx_bank_num_releve` (`num_releve`);

--
-- Indexes for table `jvm_bank_account`
--
ALTER TABLE `jvm_bank_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bank_account_label` (`label`,`entity`),
  ADD KEY `idx_fk_accountancy_journal` (`fk_accountancy_journal`);

--
-- Indexes for table `jvm_bank_account_extrafields`
--
ALTER TABLE `jvm_bank_account_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bank_account_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_bank_categ`
--
ALTER TABLE `jvm_bank_categ`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_bank_class`
--
ALTER TABLE `jvm_bank_class`
  ADD UNIQUE KEY `uk_bank_class_lineid` (`lineid`,`fk_categ`);

--
-- Indexes for table `jvm_bank_url`
--
ALTER TABLE `jvm_bank_url`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bank_url` (`fk_bank`,`url_id`,`type`);

--
-- Indexes for table `jvm_blockedlog`
--
ALTER TABLE `jvm_blockedlog`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `signature` (`signature`),
  ADD KEY `fk_object_element` (`fk_object`,`element`),
  ADD KEY `entity` (`entity`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `entity_action` (`entity`,`action`),
  ADD KEY `entity_action_certified` (`entity`,`action`,`certified`);

--
-- Indexes for table `jvm_blockedlog_authority`
--
ALTER TABLE `jvm_blockedlog_authority`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `signature` (`signature`);

--
-- Indexes for table `jvm_bom_bom`
--
ALTER TABLE `jvm_bom_bom`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bom_bom_ref` (`ref`,`entity`),
  ADD KEY `idx_bom_bom_rowid` (`rowid`),
  ADD KEY `idx_bom_bom_ref` (`ref`),
  ADD KEY `jvm_bom_bom_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_bom_bom_status` (`status`),
  ADD KEY `idx_bom_bom_fk_product` (`fk_product`);

--
-- Indexes for table `jvm_bom_bomline`
--
ALTER TABLE `jvm_bom_bomline`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bom_bomline_rowid` (`rowid`),
  ADD KEY `idx_bom_bomline_fk_product` (`fk_product`),
  ADD KEY `idx_bom_bomline_fk_bom` (`fk_bom`);

--
-- Indexes for table `jvm_bom_bomline_extrafields`
--
ALTER TABLE `jvm_bom_bomline_extrafields`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_bom_bom_extrafields`
--
ALTER TABLE `jvm_bom_bom_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_bom_bom_extrafields_fk_object` (`fk_object`);

--
-- Indexes for table `jvm_bookmark`
--
ALTER TABLE `jvm_bookmark`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bookmark_title` (`fk_user`,`entity`,`title`);

--
-- Indexes for table `jvm_bordereau_cheque`
--
ALTER TABLE `jvm_bordereau_cheque`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_bordereau_cheque` (`ref`,`entity`);

--
-- Indexes for table `jvm_boxes`
--
ALTER TABLE `jvm_boxes`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_boxes` (`entity`,`box_id`,`position`,`fk_user`),
  ADD KEY `idx_boxes_boxid` (`box_id`),
  ADD KEY `idx_boxes_fk_user` (`fk_user`);

--
-- Indexes for table `jvm_boxes_def`
--
ALTER TABLE `jvm_boxes_def`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_boxes_def` (`file`,`entity`,`note`);

--
-- Indexes for table `jvm_budget`
--
ALTER TABLE `jvm_budget`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_budget_lines`
--
ALTER TABLE `jvm_budget_lines`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_budget_lines` (`fk_budget`,`fk_project_ids`);

--
-- Indexes for table `jvm_categorie`
--
ALTER TABLE `jvm_categorie`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_categories_extrafields`
--
ALTER TABLE `jvm_categories_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_categories_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_categorie_account`
--
ALTER TABLE `jvm_categorie_account`
  ADD PRIMARY KEY (`fk_categorie`,`fk_account`),
  ADD KEY `idx_categorie_account_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_account_fk_account` (`fk_account`);

--
-- Indexes for table `jvm_categorie_actioncomm`
--
ALTER TABLE `jvm_categorie_actioncomm`
  ADD PRIMARY KEY (`fk_categorie`,`fk_actioncomm`),
  ADD KEY `idx_categorie_actioncomm_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_actioncomm_fk_actioncomm` (`fk_actioncomm`);

--
-- Indexes for table `jvm_categorie_contact`
--
ALTER TABLE `jvm_categorie_contact`
  ADD PRIMARY KEY (`fk_categorie`,`fk_socpeople`),
  ADD KEY `idx_categorie_contact_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_contact_fk_socpeople` (`fk_socpeople`);

--
-- Indexes for table `jvm_categorie_fournisseur`
--
ALTER TABLE `jvm_categorie_fournisseur`
  ADD PRIMARY KEY (`fk_categorie`,`fk_soc`),
  ADD KEY `idx_categorie_fournisseur_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_fournisseur_fk_societe` (`fk_soc`);

--
-- Indexes for table `jvm_categorie_lang`
--
ALTER TABLE `jvm_categorie_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_category_lang` (`fk_category`,`lang`);

--
-- Indexes for table `jvm_categorie_member`
--
ALTER TABLE `jvm_categorie_member`
  ADD PRIMARY KEY (`fk_categorie`,`fk_member`),
  ADD KEY `idx_categorie_member_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_member_fk_member` (`fk_member`);

--
-- Indexes for table `jvm_categorie_product`
--
ALTER TABLE `jvm_categorie_product`
  ADD PRIMARY KEY (`fk_categorie`,`fk_product`),
  ADD KEY `idx_categorie_product_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_product_fk_product` (`fk_product`);

--
-- Indexes for table `jvm_categorie_project`
--
ALTER TABLE `jvm_categorie_project`
  ADD PRIMARY KEY (`fk_categorie`,`fk_project`),
  ADD KEY `idx_categorie_project_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_project_fk_project` (`fk_project`);

--
-- Indexes for table `jvm_categorie_societe`
--
ALTER TABLE `jvm_categorie_societe`
  ADD PRIMARY KEY (`fk_categorie`,`fk_soc`),
  ADD KEY `idx_categorie_societe_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_societe_fk_societe` (`fk_soc`);

--
-- Indexes for table `jvm_categorie_user`
--
ALTER TABLE `jvm_categorie_user`
  ADD PRIMARY KEY (`fk_categorie`,`fk_user`),
  ADD KEY `idx_categorie_user_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_user_fk_user` (`fk_user`);

--
-- Indexes for table `jvm_categorie_warehouse`
--
ALTER TABLE `jvm_categorie_warehouse`
  ADD PRIMARY KEY (`fk_categorie`,`fk_warehouse`),
  ADD KEY `idx_categorie_warehouse_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_warehouse_fk_warehouse` (`fk_warehouse`);

--
-- Indexes for table `jvm_categorie_website_page`
--
ALTER TABLE `jvm_categorie_website_page`
  ADD PRIMARY KEY (`fk_categorie`,`fk_website_page`),
  ADD KEY `idx_categorie_website_page_fk_categorie` (`fk_categorie`),
  ADD KEY `idx_categorie_website_page_fk_website_page` (`fk_website_page`);

--
-- Indexes for table `jvm_chargesociales`
--
ALTER TABLE `jvm_chargesociales`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_commande`
--
ALTER TABLE `jvm_commande`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_commande_ref` (`ref`,`entity`),
  ADD KEY `idx_commande_fk_soc` (`fk_soc`),
  ADD KEY `idx_commande_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_commande_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_commande_fk_user_cloture` (`fk_user_cloture`),
  ADD KEY `idx_commande_fk_projet` (`fk_projet`),
  ADD KEY `idx_commande_fk_account` (`fk_account`),
  ADD KEY `idx_commande_fk_currency` (`fk_currency`);

--
-- Indexes for table `jvm_commandedet`
--
ALTER TABLE `jvm_commandedet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commandedet_fk_commande` (`fk_commande`),
  ADD KEY `idx_commandedet_fk_product` (`fk_product`),
  ADD KEY `fk_commandedet_fk_unit` (`fk_unit`),
  ADD KEY `fk_commandedet_fk_commandefourndet` (`fk_commandefourndet`);

--
-- Indexes for table `jvm_commandedet_extrafields`
--
ALTER TABLE `jvm_commandedet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commandedet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_commande_extrafields`
--
ALTER TABLE `jvm_commande_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_commande_fournisseur`
--
ALTER TABLE `jvm_commande_fournisseur`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_commande_fournisseur_ref` (`ref`,`fk_soc`,`entity`),
  ADD KEY `idx_commande_fournisseur_fk_soc` (`fk_soc`),
  ADD KEY `billed` (`billed`);

--
-- Indexes for table `jvm_commande_fournisseurdet`
--
ALTER TABLE `jvm_commande_fournisseurdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_commande_fournisseurdet_fk_unit` (`fk_unit`),
  ADD KEY `idx_commande_fournisseurdet_fk_commande` (`fk_commande`),
  ADD KEY `idx_commande_fournisseurdet_fk_product` (`fk_product`);

--
-- Indexes for table `jvm_commande_fournisseurdet_extrafields`
--
ALTER TABLE `jvm_commande_fournisseurdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseurdet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_commande_fournisseur_dispatch`
--
ALTER TABLE `jvm_commande_fournisseur_dispatch`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_dispatch_fk_commande` (`fk_commande`),
  ADD KEY `idx_commande_fournisseur_dispatch_fk_reception` (`fk_reception`);

--
-- Indexes for table `jvm_commande_fournisseur_dispatch_extrafields`
--
ALTER TABLE `jvm_commande_fournisseur_dispatch_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_dispatch_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_commande_fournisseur_extrafields`
--
ALTER TABLE `jvm_commande_fournisseur_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_commande_fournisseur_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_commande_fournisseur_log`
--
ALTER TABLE `jvm_commande_fournisseur_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_comment`
--
ALTER TABLE `jvm_comment`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_const`
--
ALTER TABLE `jvm_const`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_const` (`name`,`entity`);

--
-- Indexes for table `jvm_contrat`
--
ALTER TABLE `jvm_contrat`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_contrat_ref` (`ref`,`entity`),
  ADD KEY `idx_contrat_fk_soc` (`fk_soc`),
  ADD KEY `idx_contrat_fk_user_author` (`fk_user_author`);

--
-- Indexes for table `jvm_contratdet`
--
ALTER TABLE `jvm_contratdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_fk_contrat` (`fk_contrat`),
  ADD KEY `idx_contratdet_fk_product` (`fk_product`),
  ADD KEY `idx_contratdet_date_ouverture_prevue` (`date_ouverture_prevue`),
  ADD KEY `idx_contratdet_date_ouverture` (`date_ouverture`),
  ADD KEY `idx_contratdet_date_fin_validite` (`date_fin_validite`),
  ADD KEY `fk_contratdet_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_contratdet_extrafields`
--
ALTER TABLE `jvm_contratdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_contratdet_log`
--
ALTER TABLE `jvm_contratdet_log`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contratdet_log_fk_contratdet` (`fk_contratdet`),
  ADD KEY `idx_contratdet_log_date` (`date`);

--
-- Indexes for table `jvm_contrat_extrafields`
--
ALTER TABLE `jvm_contrat_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_contrat_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_cronjob`
--
ALTER TABLE `jvm_cronjob`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_cronjob_status` (`status`),
  ADD KEY `idx_cronjob_datelastrun` (`datelastrun`),
  ADD KEY `idx_cronjob_datenextrun` (`datenextrun`),
  ADD KEY `idx_cronjob_datestart` (`datestart`),
  ADD KEY `idx_cronjob_dateend` (`dateend`);

--
-- Indexes for table `jvm_c_accounting_category`
--
ALTER TABLE `jvm_c_accounting_category`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_accounting_category` (`code`,`entity`);

--
-- Indexes for table `jvm_c_actioncomm`
--
ALTER TABLE `jvm_c_actioncomm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_actioncomm` (`code`);

--
-- Indexes for table `jvm_c_action_trigger`
--
ALTER TABLE `jvm_c_action_trigger`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_action_trigger_code` (`code`),
  ADD KEY `idx_action_trigger_rang` (`rang`);

--
-- Indexes for table `jvm_c_availability`
--
ALTER TABLE `jvm_c_availability`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_availability` (`code`);

--
-- Indexes for table `jvm_c_barcode_type`
--
ALTER TABLE `jvm_c_barcode_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_barcode_type` (`code`,`entity`);

--
-- Indexes for table `jvm_c_chargesociales`
--
ALTER TABLE `jvm_c_chargesociales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jvm_c_cities`
--
ALTER TABLE `jvm_c_cities`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_departements` (`code_city`,`fk_state`),
  ADD KEY `idx_departements_fk_region` (`fk_state`);

--
-- Indexes for table `jvm_c_civility`
--
ALTER TABLE `jvm_c_civility`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_civility` (`code`);

--
-- Indexes for table `jvm_c_country`
--
ALTER TABLE `jvm_c_country`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_c_country_code` (`code`),
  ADD UNIQUE KEY `idx_c_country_label` (`label`),
  ADD UNIQUE KEY `idx_c_country_code_iso` (`code_iso`);

--
-- Indexes for table `jvm_c_currencies`
--
ALTER TABLE `jvm_c_currencies`
  ADD PRIMARY KEY (`code_iso`),
  ADD UNIQUE KEY `uk_c_currencies_code_iso` (`code_iso`);

--
-- Indexes for table `jvm_c_departements`
--
ALTER TABLE `jvm_c_departements`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_departements` (`code_departement`,`fk_region`),
  ADD KEY `idx_departements_fk_region` (`fk_region`);

--
-- Indexes for table `jvm_c_ecotaxe`
--
ALTER TABLE `jvm_c_ecotaxe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_ecotaxe` (`code`);

--
-- Indexes for table `jvm_c_effectif`
--
ALTER TABLE `jvm_c_effectif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_effectif` (`code`);

--
-- Indexes for table `jvm_c_email_senderprofile`
--
ALTER TABLE `jvm_c_email_senderprofile`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_email_senderprofile` (`entity`,`label`,`email`);

--
-- Indexes for table `jvm_c_email_templates`
--
ALTER TABLE `jvm_c_email_templates`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_email_templates` (`entity`,`label`,`lang`),
  ADD KEY `idx_type` (`type_template`);

--
-- Indexes for table `jvm_c_exp_tax_cat`
--
ALTER TABLE `jvm_c_exp_tax_cat`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_exp_tax_range`
--
ALTER TABLE `jvm_c_exp_tax_range`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_field_list`
--
ALTER TABLE `jvm_c_field_list`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_format_cards`
--
ALTER TABLE `jvm_c_format_cards`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_forme_juridique`
--
ALTER TABLE `jvm_c_forme_juridique`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_forme_juridique` (`code`);

--
-- Indexes for table `jvm_c_holiday_types`
--
ALTER TABLE `jvm_c_holiday_types`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_holiday_types` (`code`);

--
-- Indexes for table `jvm_c_hrm_department`
--
ALTER TABLE `jvm_c_hrm_department`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_hrm_function`
--
ALTER TABLE `jvm_c_hrm_function`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_hrm_public_holiday`
--
ALTER TABLE `jvm_c_hrm_public_holiday`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_hrm_public_holiday` (`entity`,`code`),
  ADD UNIQUE KEY `uk_c_hrm_public_holiday2` (`entity`,`fk_country`,`dayrule`,`day`,`month`,`year`);

--
-- Indexes for table `jvm_c_incoterms`
--
ALTER TABLE `jvm_c_incoterms`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_incoterms` (`code`);

--
-- Indexes for table `jvm_c_input_method`
--
ALTER TABLE `jvm_c_input_method`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_input_method` (`code`);

--
-- Indexes for table `jvm_c_input_reason`
--
ALTER TABLE `jvm_c_input_reason`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_input_reason` (`code`);

--
-- Indexes for table `jvm_c_lead_status`
--
ALTER TABLE `jvm_c_lead_status`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_lead_status_code` (`code`);

--
-- Indexes for table `jvm_c_paiement`
--
ALTER TABLE `jvm_c_paiement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_paiement_code` (`entity`,`code`);

--
-- Indexes for table `jvm_c_paper_format`
--
ALTER TABLE `jvm_c_paper_format`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_payment_term`
--
ALTER TABLE `jvm_c_payment_term`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_payment_term_code` (`entity`,`code`);

--
-- Indexes for table `jvm_c_pincodes`
--
ALTER TABLE `jvm_c_pincodes`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_departements` (`code_pincode`,`fk_state`),
  ADD KEY `idx_departements_fk_region` (`fk_state`);

--
-- Indexes for table `jvm_c_price_expression`
--
ALTER TABLE `jvm_c_price_expression`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_price_global_variable`
--
ALTER TABLE `jvm_c_price_global_variable`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_price_global_variable_updater`
--
ALTER TABLE `jvm_c_price_global_variable_updater`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_product_nature`
--
ALTER TABLE `jvm_c_product_nature`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_product_nature` (`code`,`active`);

--
-- Indexes for table `jvm_c_propalst`
--
ALTER TABLE `jvm_c_propalst`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_propalst` (`code`);

--
-- Indexes for table `jvm_c_prospectcontactlevel`
--
ALTER TABLE `jvm_c_prospectcontactlevel`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `jvm_c_prospectlevel`
--
ALTER TABLE `jvm_c_prospectlevel`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `jvm_c_recruitment_origin`
--
ALTER TABLE `jvm_c_recruitment_origin`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_regions`
--
ALTER TABLE `jvm_c_regions`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code_region` (`code_region`),
  ADD KEY `idx_c_regions_fk_pays` (`fk_pays`);

--
-- Indexes for table `jvm_c_revenuestamp`
--
ALTER TABLE `jvm_c_revenuestamp`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_shipment_mode`
--
ALTER TABLE `jvm_c_shipment_mode`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_shipment_mode` (`code`,`entity`);

--
-- Indexes for table `jvm_c_shipment_package_type`
--
ALTER TABLE `jvm_c_shipment_package_type`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_c_socialnetworks`
--
ALTER TABLE `jvm_c_socialnetworks`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_c_socialnetworks_code` (`code`);

--
-- Indexes for table `jvm_c_stcomm`
--
ALTER TABLE `jvm_c_stcomm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_stcomm` (`code`);

--
-- Indexes for table `jvm_c_stcommcontact`
--
ALTER TABLE `jvm_c_stcommcontact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_stcommcontact` (`code`);

--
-- Indexes for table `jvm_c_ticket_category`
--
ALTER TABLE `jvm_c_ticket_category`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Indexes for table `jvm_c_ticket_resolution`
--
ALTER TABLE `jvm_c_ticket_resolution`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Indexes for table `jvm_c_ticket_severity`
--
ALTER TABLE `jvm_c_ticket_severity`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Indexes for table `jvm_c_ticket_type`
--
ALTER TABLE `jvm_c_ticket_type`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_code` (`code`,`entity`);

--
-- Indexes for table `jvm_c_transport_mode`
--
ALTER TABLE `jvm_c_transport_mode`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_transport_mode` (`code`,`entity`);

--
-- Indexes for table `jvm_c_tva`
--
ALTER TABLE `jvm_c_tva`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_tva_id` (`fk_pays`,`code`,`taux`,`recuperableonly`);

--
-- Indexes for table `jvm_c_typent`
--
ALTER TABLE `jvm_c_typent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_typent` (`code`);

--
-- Indexes for table `jvm_c_type_contact`
--
ALTER TABLE `jvm_c_type_contact`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_contact_id` (`element`,`source`,`code`);

--
-- Indexes for table `jvm_c_type_container`
--
ALTER TABLE `jvm_c_type_container`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_container_id` (`code`,`entity`);

--
-- Indexes for table `jvm_c_type_fees`
--
ALTER TABLE `jvm_c_type_fees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_c_type_fees` (`code`);

--
-- Indexes for table `jvm_c_type_resource`
--
ALTER TABLE `jvm_c_type_resource`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_type_resource_id` (`label`,`code`);

--
-- Indexes for table `jvm_c_units`
--
ALTER TABLE `jvm_c_units`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_c_units_code` (`code`);

--
-- Indexes for table `jvm_c_ziptown`
--
ALTER TABLE `jvm_c_ziptown`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ziptown_fk_pays` (`zip`,`town`,`fk_pays`),
  ADD KEY `idx_c_ziptown_fk_county` (`fk_county`),
  ADD KEY `idx_c_ziptown_fk_pays` (`fk_pays`),
  ADD KEY `idx_c_ziptown_zip` (`zip`);

--
-- Indexes for table `jvm_default_values`
--
ALTER TABLE `jvm_default_values`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_default_values` (`type`,`entity`,`user_id`,`page`,`param`);

--
-- Indexes for table `jvm_delivery`
--
ALTER TABLE `jvm_delivery`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_delivery_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_delivery_fk_soc` (`fk_soc`),
  ADD KEY `idx_delivery_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_delivery_fk_user_valid` (`fk_user_valid`);

--
-- Indexes for table `jvm_deliverydet`
--
ALTER TABLE `jvm_deliverydet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_deliverydet_fk_delivery` (`fk_delivery`);

--
-- Indexes for table `jvm_deliverydet_extrafields`
--
ALTER TABLE `jvm_deliverydet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_deliverydet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_delivery_extrafields`
--
ALTER TABLE `jvm_delivery_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_delivery_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_deplacement`
--
ALTER TABLE `jvm_deplacement`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_document_model`
--
ALTER TABLE `jvm_document_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_document_model` (`nom`,`type`,`entity`);

--
-- Indexes for table `jvm_don`
--
ALTER TABLE `jvm_don`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_don_extrafields`
--
ALTER TABLE `jvm_don_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_don_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_ecm_directories`
--
ALTER TABLE `jvm_ecm_directories`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ecm_directories` (`label`,`fk_parent`,`entity`),
  ADD KEY `idx_ecm_directories_fk_user_c` (`fk_user_c`),
  ADD KEY `idx_ecm_directories_fk_user_m` (`fk_user_m`);

--
-- Indexes for table `jvm_ecm_directories_extrafields`
--
ALTER TABLE `jvm_ecm_directories_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ecm_directories_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_ecm_files`
--
ALTER TABLE `jvm_ecm_files`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ecm_files` (`filepath`,`filename`,`entity`),
  ADD KEY `idx_ecm_files_label` (`label`);

--
-- Indexes for table `jvm_ecm_files_extrafields`
--
ALTER TABLE `jvm_ecm_files_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ecm_files_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_element_contact`
--
ALTER TABLE `jvm_element_contact`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_contact_idx1` (`element_id`,`fk_c_type_contact`,`fk_socpeople`),
  ADD KEY `fk_element_contact_fk_c_type_contact` (`fk_c_type_contact`),
  ADD KEY `idx_element_contact_fk_socpeople` (`fk_socpeople`);

--
-- Indexes for table `jvm_element_element`
--
ALTER TABLE `jvm_element_element`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_element_idx1` (`fk_source`,`sourcetype`,`fk_target`,`targettype`),
  ADD KEY `idx_element_element_fk_target` (`fk_target`);

--
-- Indexes for table `jvm_element_resources`
--
ALTER TABLE `jvm_element_resources`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_element_resources_idx1` (`resource_id`,`resource_type`,`element_id`,`element_type`),
  ADD KEY `idx_element_element_element_id` (`element_id`);

--
-- Indexes for table `jvm_emailcollector_emailcollector`
--
ALTER TABLE `jvm_emailcollector_emailcollector`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollector_ref` (`ref`,`entity`),
  ADD KEY `idx_emailcollector_entity` (`entity`),
  ADD KEY `idx_emailcollector_status` (`status`);

--
-- Indexes for table `jvm_emailcollector_emailcollectoraction`
--
ALTER TABLE `jvm_emailcollector_emailcollectoraction`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollectoraction` (`fk_emailcollector`,`type`),
  ADD KEY `idx_emailcollector_fk_emailcollector` (`fk_emailcollector`);

--
-- Indexes for table `jvm_emailcollector_emailcollectorfilter`
--
ALTER TABLE `jvm_emailcollector_emailcollectorfilter`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_emailcollector_emailcollectorfilter` (`fk_emailcollector`,`type`,`rulevalue`),
  ADD KEY `idx_emailcollector_fk_emailcollector` (`fk_emailcollector`);

--
-- Indexes for table `jvm_entrepot`
--
ALTER TABLE `jvm_entrepot`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_entrepot_label` (`ref`,`entity`);

--
-- Indexes for table `jvm_entrepot_extrafields`
--
ALTER TABLE `jvm_entrepot_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_entrepot_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_establishment`
--
ALTER TABLE `jvm_establishment`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_events`
--
ALTER TABLE `jvm_events`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_events_dateevent` (`dateevent`);

--
-- Indexes for table `jvm_event_element`
--
ALTER TABLE `jvm_event_element`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_expedition`
--
ALTER TABLE `jvm_expedition`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_expedition_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_expedition_fk_soc` (`fk_soc`),
  ADD KEY `idx_expedition_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_expedition_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_expedition_fk_shipping_method` (`fk_shipping_method`);

--
-- Indexes for table `jvm_expeditiondet`
--
ALTER TABLE `jvm_expeditiondet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expeditiondet_fk_expedition` (`fk_expedition`),
  ADD KEY `idx_expeditiondet_fk_origin_line` (`fk_origin_line`);

--
-- Indexes for table `jvm_expeditiondet_batch`
--
ALTER TABLE `jvm_expeditiondet_batch`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_fk_expeditiondet` (`fk_expeditiondet`);

--
-- Indexes for table `jvm_expeditiondet_extrafields`
--
ALTER TABLE `jvm_expeditiondet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expeditiondet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_expedition_extrafields`
--
ALTER TABLE `jvm_expedition_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expedition_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_expedition_package`
--
ALTER TABLE `jvm_expedition_package`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_expensereport`
--
ALTER TABLE `jvm_expensereport`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_expensereport_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_expensereport_date_debut` (`date_debut`),
  ADD KEY `idx_expensereport_date_fin` (`date_fin`),
  ADD KEY `idx_expensereport_fk_statut` (`fk_statut`),
  ADD KEY `idx_expensereport_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_expensereport_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_expensereport_fk_user_approve` (`fk_user_approve`),
  ADD KEY `idx_expensereport_fk_refuse` (`fk_user_approve`);

--
-- Indexes for table `jvm_expensereport_det`
--
ALTER TABLE `jvm_expensereport_det`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_expensereport_extrafields`
--
ALTER TABLE `jvm_expensereport_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_expensereport_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_expensereport_ik`
--
ALTER TABLE `jvm_expensereport_ik`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_expensereport_rules`
--
ALTER TABLE `jvm_expensereport_rules`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_export_compta`
--
ALTER TABLE `jvm_export_compta`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_export_model`
--
ALTER TABLE `jvm_export_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_export_model` (`label`,`type`);

--
-- Indexes for table `jvm_extrafields`
--
ALTER TABLE `jvm_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_extrafields_name` (`name`,`entity`,`elementtype`);

--
-- Indexes for table `jvm_facture`
--
ALTER TABLE `jvm_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_facture_ref` (`ref`,`entity`),
  ADD KEY `idx_facture_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_facture_fk_facture_source` (`fk_facture_source`),
  ADD KEY `idx_facture_fk_projet` (`fk_projet`),
  ADD KEY `idx_facture_fk_account` (`fk_account`),
  ADD KEY `idx_facture_fk_currency` (`fk_currency`),
  ADD KEY `idx_facture_fk_statut` (`fk_statut`);

--
-- Indexes for table `jvm_facturedet`
--
ALTER TABLE `jvm_facturedet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_fk_remise_except` (`fk_remise_except`,`fk_facture`),
  ADD KEY `idx_facturedet_fk_facture` (`fk_facture`),
  ADD KEY `idx_facturedet_fk_product` (`fk_product`),
  ADD KEY `idx_facturedet_fk_code_ventilation` (`fk_code_ventilation`),
  ADD KEY `fk_facturedet_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_facturedet_extrafields`
--
ALTER TABLE `jvm_facturedet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facturedet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_facturedet_rec`
--
ALTER TABLE `jvm_facturedet_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_facturedet_rec_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_facturedet_rec_extrafields`
--
ALTER TABLE `jvm_facturedet_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facturedet_rec_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_facture_extrafields`
--
ALTER TABLE `jvm_facture_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_facture_fourn`
--
ALTER TABLE `jvm_facture_fourn`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_facture_fourn_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_facture_fourn_ref_supplier` (`ref_supplier`,`fk_soc`,`entity`),
  ADD KEY `idx_facture_fourn_date_lim_reglement` (`date_lim_reglement`),
  ADD KEY `idx_facture_fourn_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_fourn_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_fourn_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_facture_fourn_fk_projet` (`fk_projet`);

--
-- Indexes for table `jvm_facture_fourn_det`
--
ALTER TABLE `jvm_facture_fourn_det`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_det_fk_facture` (`fk_facture_fourn`),
  ADD KEY `idx_facture_fourn_det_fk_product` (`fk_product`),
  ADD KEY `idx_facture_fourn_det_fk_code_ventilation` (`fk_code_ventilation`),
  ADD KEY `fk_facture_fourn_det_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_facture_fourn_det_extrafields`
--
ALTER TABLE `jvm_facture_fourn_det_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_det_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_facture_fourn_extrafields`
--
ALTER TABLE `jvm_facture_fourn_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_fourn_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_facture_rec`
--
ALTER TABLE `jvm_facture_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_facture_rec_uk_titre` (`titre`,`entity`),
  ADD KEY `idx_facture_rec_fk_soc` (`fk_soc`),
  ADD KEY `idx_facture_rec_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_facture_rec_fk_projet` (`fk_projet`);

--
-- Indexes for table `jvm_facture_rec_extrafields`
--
ALTER TABLE `jvm_facture_rec_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_facture_rec_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_fichinter`
--
ALTER TABLE `jvm_fichinter`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_fichinter_ref` (`ref`,`entity`),
  ADD KEY `idx_fichinter_fk_soc` (`fk_soc`);

--
-- Indexes for table `jvm_fichinterdet`
--
ALTER TABLE `jvm_fichinterdet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_fichinterdet_fk_fichinter` (`fk_fichinter`);

--
-- Indexes for table `jvm_fichinterdet_extrafields`
--
ALTER TABLE `jvm_fichinterdet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ficheinterdet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_fichinterdet_rec`
--
ALTER TABLE `jvm_fichinterdet_rec`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_fichinter_extrafields`
--
ALTER TABLE `jvm_fichinter_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ficheinter_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_fichinter_rec`
--
ALTER TABLE `jvm_fichinter_rec`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_fichinter_rec_uk_titre` (`titre`,`entity`),
  ADD KEY `idx_fichinter_rec_fk_soc` (`fk_soc`),
  ADD KEY `idx_fichinter_rec_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_fichinter_rec_fk_projet` (`fk_projet`);

--
-- Indexes for table `jvm_holiday`
--
ALTER TABLE `jvm_holiday`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_holiday_entity` (`entity`),
  ADD KEY `idx_holiday_fk_user` (`fk_user`),
  ADD KEY `idx_holiday_fk_user_create` (`fk_user_create`),
  ADD KEY `idx_holiday_date_create` (`date_create`),
  ADD KEY `idx_holiday_date_debut` (`date_debut`),
  ADD KEY `idx_holiday_date_fin` (`date_fin`),
  ADD KEY `idx_holiday_fk_validator` (`fk_validator`);

--
-- Indexes for table `jvm_holiday_config`
--
ALTER TABLE `jvm_holiday_config`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_holiday_config` (`name`);

--
-- Indexes for table `jvm_holiday_extrafields`
--
ALTER TABLE `jvm_holiday_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_holiday_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_holiday_logs`
--
ALTER TABLE `jvm_holiday_logs`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_holiday_users`
--
ALTER TABLE `jvm_holiday_users`
  ADD UNIQUE KEY `uk_holiday_users` (`fk_user`,`fk_type`);

--
-- Indexes for table `jvm_import_model`
--
ALTER TABLE `jvm_import_model`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_import_model` (`label`,`type`);

--
-- Indexes for table `jvm_intracommreport`
--
ALTER TABLE `jvm_intracommreport`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_inventory`
--
ALTER TABLE `jvm_inventory`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_inventory_ref` (`ref`,`entity`),
  ADD KEY `idx_inventory_tms` (`tms`),
  ADD KEY `idx_inventory_date_creation` (`date_creation`);

--
-- Indexes for table `jvm_inventorydet`
--
ALTER TABLE `jvm_inventorydet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_inventorydet` (`fk_inventory`,`fk_warehouse`,`fk_product`,`batch`),
  ADD KEY `idx_inventorydet_tms` (`tms`),
  ADD KEY `idx_inventorydet_datec` (`datec`),
  ADD KEY `idx_inventorydet_fk_inventory` (`fk_inventory`);

--
-- Indexes for table `jvm_links`
--
ALTER TABLE `jvm_links`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_links` (`objectid`,`label`);

--
-- Indexes for table `jvm_loan`
--
ALTER TABLE `jvm_loan`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_loan_schedule`
--
ALTER TABLE `jvm_loan_schedule`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_localtax`
--
ALTER TABLE `jvm_localtax`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_mailing`
--
ALTER TABLE `jvm_mailing`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_mailing_cibles`
--
ALTER TABLE `jvm_mailing_cibles`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_mailing_cibles` (`fk_mailing`,`email`),
  ADD KEY `idx_mailing_cibles_email` (`email`);

--
-- Indexes for table `jvm_mailing_unsubscribe`
--
ALTER TABLE `jvm_mailing_unsubscribe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_mailing_unsubscribe` (`email`,`entity`,`unsubscribegroup`);

--
-- Indexes for table `jvm_menu`
--
ALTER TABLE `jvm_menu`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_menu_uk_menu` (`menu_handler`,`fk_menu`,`position`,`url`,`entity`),
  ADD KEY `idx_menu_menuhandler_type` (`menu_handler`,`type`);

--
-- Indexes for table `jvm_mrp_mo`
--
ALTER TABLE `jvm_mrp_mo`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_mrp_mo_ref` (`ref`),
  ADD KEY `idx_mrp_mo_entity` (`entity`),
  ADD KEY `idx_mrp_mo_fk_soc` (`fk_soc`),
  ADD KEY `fk_mrp_mo_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_mrp_mo_status` (`status`),
  ADD KEY `idx_mrp_mo_fk_product` (`fk_product`),
  ADD KEY `idx_mrp_mo_date_start_planned` (`date_start_planned`),
  ADD KEY `idx_mrp_mo_date_end_planned` (`date_end_planned`),
  ADD KEY `idx_mrp_mo_fk_bom` (`fk_bom`),
  ADD KEY `idx_mrp_mo_fk_project` (`fk_project`);

--
-- Indexes for table `jvm_mrp_mo_extrafields`
--
ALTER TABLE `jvm_mrp_mo_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_mrp_mo_fk_object` (`fk_object`);

--
-- Indexes for table `jvm_mrp_production`
--
ALTER TABLE `jvm_mrp_production`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `fk_mrp_production_product` (`fk_product`),
  ADD KEY `fk_mrp_production_stock_movement` (`fk_stock_movement`),
  ADD KEY `idx_mrp_production_fk_mo` (`fk_mo`);

--
-- Indexes for table `jvm_multicurrency`
--
ALTER TABLE `jvm_multicurrency`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_multicurrency_rate`
--
ALTER TABLE `jvm_multicurrency_rate`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_notify`
--
ALTER TABLE `jvm_notify`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_notify_def`
--
ALTER TABLE `jvm_notify_def`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_notify_def_object`
--
ALTER TABLE `jvm_notify_def_object`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jvm_oauth_state`
--
ALTER TABLE `jvm_oauth_state`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_oauth_token`
--
ALTER TABLE `jvm_oauth_token`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_object_lang`
--
ALTER TABLE `jvm_object_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_object_lang` (`fk_object`,`type_object`,`property`,`lang`);

--
-- Indexes for table `jvm_onlinesignature`
--
ALTER TABLE `jvm_onlinesignature`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_opensurvey_comments`
--
ALTER TABLE `jvm_opensurvey_comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `idx_id_comment` (`id_comment`),
  ADD KEY `idx_id_sondage` (`id_sondage`);

--
-- Indexes for table `jvm_opensurvey_formquestions`
--
ALTER TABLE `jvm_opensurvey_formquestions`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_opensurvey_sondage`
--
ALTER TABLE `jvm_opensurvey_sondage`
  ADD PRIMARY KEY (`id_sondage`),
  ADD KEY `idx_date_fin` (`date_fin`);

--
-- Indexes for table `jvm_opensurvey_user_studs`
--
ALTER TABLE `jvm_opensurvey_user_studs`
  ADD PRIMARY KEY (`id_users`),
  ADD KEY `idx_opensurvey_user_studs_id_users` (`id_users`),
  ADD KEY `idx_opensurvey_user_studs_nom` (`nom`),
  ADD KEY `idx_opensurvey_user_studs_id_sondage` (`id_sondage`);

--
-- Indexes for table `jvm_overwrite_trans`
--
ALTER TABLE `jvm_overwrite_trans`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_overwrite_trans` (`lang`,`transkey`);

--
-- Indexes for table `jvm_paiement`
--
ALTER TABLE `jvm_paiement`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_paiementcharge`
--
ALTER TABLE `jvm_paiementcharge`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_paiementfourn`
--
ALTER TABLE `jvm_paiementfourn`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_paiementfourn_facturefourn`
--
ALTER TABLE `jvm_paiementfourn_facturefourn`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_paiementfourn_facturefourn` (`fk_paiementfourn`,`fk_facturefourn`),
  ADD KEY `idx_paiementfourn_facturefourn_fk_facture` (`fk_facturefourn`),
  ADD KEY `idx_paiementfourn_facturefourn_fk_paiement` (`fk_paiementfourn`);

--
-- Indexes for table `jvm_paiement_facture`
--
ALTER TABLE `jvm_paiement_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_paiement_facture` (`fk_paiement`,`fk_facture`),
  ADD KEY `idx_paiement_facture_fk_facture` (`fk_facture`),
  ADD KEY `idx_paiement_facture_fk_paiement` (`fk_paiement`);

--
-- Indexes for table `jvm_payment_donation`
--
ALTER TABLE `jvm_payment_donation`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_payment_expensereport`
--
ALTER TABLE `jvm_payment_expensereport`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_payment_loan`
--
ALTER TABLE `jvm_payment_loan`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_payment_salary`
--
ALTER TABLE `jvm_payment_salary`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_payment_salary_ref` (`num_payment`),
  ADD KEY `idx_payment_salary_user` (`fk_user`,`entity`),
  ADD KEY `idx_payment_salary_datep` (`datep`),
  ADD KEY `idx_payment_salary_datesp` (`datesp`),
  ADD KEY `idx_payment_salary_dateep` (`dateep`);

--
-- Indexes for table `jvm_payment_salary_extrafields`
--
ALTER TABLE `jvm_payment_salary_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_payment_salary_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_payment_various`
--
ALTER TABLE `jvm_payment_various`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_pos_cash_fence`
--
ALTER TABLE `jvm_pos_cash_fence`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_prelevement_bons`
--
ALTER TABLE `jvm_prelevement_bons`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_prelevement_bons_ref` (`ref`,`entity`);

--
-- Indexes for table `jvm_prelevement_facture`
--
ALTER TABLE `jvm_prelevement_facture`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_facture_fk_prelevement_lignes` (`fk_prelevement_lignes`);

--
-- Indexes for table `jvm_prelevement_facture_demande`
--
ALTER TABLE `jvm_prelevement_facture_demande`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_facture_demande_fk_facture` (`fk_facture`),
  ADD KEY `idx_prelevement_facture_demande_fk_facture_fourn` (`fk_facture_fourn`);

--
-- Indexes for table `jvm_prelevement_lignes`
--
ALTER TABLE `jvm_prelevement_lignes`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_prelevement_lignes_fk_prelevement_bons` (`fk_prelevement_bons`);

--
-- Indexes for table `jvm_prelevement_rejet`
--
ALTER TABLE `jvm_prelevement_rejet`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_printing`
--
ALTER TABLE `jvm_printing`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_product`
--
ALTER TABLE `jvm_product`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_ref` (`ref`,`entity`),
  ADD UNIQUE KEY `uk_product_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_product_label` (`label`),
  ADD KEY `idx_product_barcode` (`barcode`),
  ADD KEY `idx_product_import_key` (`import_key`),
  ADD KEY `idx_product_seuil_stock_alerte` (`seuil_stock_alerte`),
  ADD KEY `idx_product_fk_country` (`fk_country`),
  ADD KEY `idx_product_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_product_fk_barcode_type` (`fk_barcode_type`),
  ADD KEY `idx_product_fk_project` (`fk_project`),
  ADD KEY `fk_product_fk_unit` (`fk_unit`),
  ADD KEY `fk_product_finished` (`finished`),
  ADD KEY `fk_product_default_warehouse` (`fk_default_warehouse`);

--
-- Indexes for table `jvm_product_association`
--
ALTER TABLE `jvm_product_association`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_association` (`fk_product_pere`,`fk_product_fils`),
  ADD KEY `idx_product_association_fils` (`fk_product_fils`);

--
-- Indexes for table `jvm_product_attribute`
--
ALTER TABLE `jvm_product_attribute`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_attribute_ref` (`ref`);

--
-- Indexes for table `jvm_product_attribute_combination`
--
ALTER TABLE `jvm_product_attribute_combination`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_att_com_product_parent` (`fk_product_parent`),
  ADD KEY `idx_product_att_com_product_child` (`fk_product_child`);

--
-- Indexes for table `jvm_product_attribute_combination2val`
--
ALTER TABLE `jvm_product_attribute_combination2val`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_product_attribute_combination_price_level`
--
ALTER TABLE `jvm_product_attribute_combination_price_level`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `fk_product_attribute_combination` (`fk_product_attribute_combination`,`fk_price_level`);

--
-- Indexes for table `jvm_product_attribute_value`
--
ALTER TABLE `jvm_product_attribute_value`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_attribute_value` (`fk_product_attribute`,`ref`);

--
-- Indexes for table `jvm_product_batch`
--
ALTER TABLE `jvm_product_batch`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_batch` (`fk_product_stock`,`batch`),
  ADD KEY `idx_fk_product_stock` (`fk_product_stock`),
  ADD KEY `idx_batch` (`batch`);

--
-- Indexes for table `jvm_product_customer_price`
--
ALTER TABLE `jvm_product_customer_price`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_customer_price_fk_product_fk_soc` (`fk_product`,`fk_soc`),
  ADD KEY `idx_product_customer_price_fk_user` (`fk_user`),
  ADD KEY `idx_product_customer_price_fk_soc` (`fk_soc`);

--
-- Indexes for table `jvm_product_customer_price_log`
--
ALTER TABLE `jvm_product_customer_price_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_product_extrafields`
--
ALTER TABLE `jvm_product_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_product_fournisseur_price`
--
ALTER TABLE `jvm_product_fournisseur_price`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_fournisseur_price_ref` (`ref_fourn`,`fk_soc`,`quantity`,`entity`),
  ADD UNIQUE KEY `uk_product_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_product_fournisseur_price_fk_user` (`fk_user`),
  ADD KEY `idx_product_fourn_price_fk_product` (`fk_product`,`entity`),
  ADD KEY `idx_product_fourn_price_fk_soc` (`fk_soc`,`entity`),
  ADD KEY `idx_product_barcode` (`barcode`),
  ADD KEY `idx_product_fk_barcode_type` (`fk_barcode_type`);

--
-- Indexes for table `jvm_product_fournisseur_price_extrafields`
--
ALTER TABLE `jvm_product_fournisseur_price_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_fournisseur_price_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_product_fournisseur_price_log`
--
ALTER TABLE `jvm_product_fournisseur_price_log`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_product_lang`
--
ALTER TABLE `jvm_product_lang`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_lang` (`fk_product`,`lang`);

--
-- Indexes for table `jvm_product_lot`
--
ALTER TABLE `jvm_product_lot`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_lot` (`fk_product`,`batch`);

--
-- Indexes for table `jvm_product_lot_extrafields`
--
ALTER TABLE `jvm_product_lot_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_lot_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_product_price`
--
ALTER TABLE `jvm_product_price`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_product_price_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_product_price_fk_product` (`fk_product`);

--
-- Indexes for table `jvm_product_pricerules`
--
ALTER TABLE `jvm_product_pricerules`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `unique_level` (`level`);

--
-- Indexes for table `jvm_product_price_by_qty`
--
ALTER TABLE `jvm_product_price_by_qty`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_price_by_qty_level` (`fk_product_price`,`quantity`),
  ADD KEY `idx_product_price_by_qty_fk_product_price` (`fk_product_price`);

--
-- Indexes for table `jvm_product_stock`
--
ALTER TABLE `jvm_product_stock`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_product_stock` (`fk_product`,`fk_entrepot`),
  ADD KEY `idx_product_stock_fk_product` (`fk_product`),
  ADD KEY `idx_product_stock_fk_entrepot` (`fk_entrepot`);

--
-- Indexes for table `jvm_product_warehouse_properties`
--
ALTER TABLE `jvm_product_warehouse_properties`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_projet`
--
ALTER TABLE `jvm_projet`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_projet_ref` (`ref`,`entity`),
  ADD KEY `idx_projet_fk_soc` (`fk_soc`);

--
-- Indexes for table `jvm_projet_extrafields`
--
ALTER TABLE `jvm_projet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_projet_task`
--
ALTER TABLE `jvm_projet_task`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_projet_task_ref` (`ref`,`entity`),
  ADD KEY `idx_projet_task_fk_projet` (`fk_projet`),
  ADD KEY `idx_projet_task_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_projet_task_fk_user_valid` (`fk_user_valid`);

--
-- Indexes for table `jvm_projet_task_extrafields`
--
ALTER TABLE `jvm_projet_task_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_task_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_projet_task_time`
--
ALTER TABLE `jvm_projet_task_time`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_projet_task_time_task` (`fk_task`),
  ADD KEY `idx_projet_task_time_date` (`task_date`),
  ADD KEY `idx_projet_task_time_datehour` (`task_datehour`);

--
-- Indexes for table `jvm_propal`
--
ALTER TABLE `jvm_propal`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_propal_ref` (`ref`,`entity`),
  ADD KEY `idx_propal_fk_soc` (`fk_soc`),
  ADD KEY `idx_propal_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_propal_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_propal_fk_user_cloture` (`fk_user_cloture`),
  ADD KEY `idx_propal_fk_projet` (`fk_projet`),
  ADD KEY `idx_propal_fk_account` (`fk_account`),
  ADD KEY `idx_propal_fk_currency` (`fk_currency`);

--
-- Indexes for table `jvm_propaldet`
--
ALTER TABLE `jvm_propaldet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propaldet_fk_propal` (`fk_propal`),
  ADD KEY `idx_propaldet_fk_product` (`fk_product`),
  ADD KEY `fk_propaldet_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_propaldet_extrafields`
--
ALTER TABLE `jvm_propaldet_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propaldet_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_propal_extrafields`
--
ALTER TABLE `jvm_propal_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_propal_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_propal_merge_pdf_product`
--
ALTER TABLE `jvm_propal_merge_pdf_product`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_reception`
--
ALTER TABLE `jvm_reception`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_reception_uk_ref` (`ref`,`entity`),
  ADD KEY `idx_reception_fk_soc` (`fk_soc`),
  ADD KEY `idx_reception_fk_user_author` (`fk_user_author`),
  ADD KEY `idx_reception_fk_user_valid` (`fk_user_valid`),
  ADD KEY `idx_reception_fk_shipping_method` (`fk_shipping_method`);

--
-- Indexes for table `jvm_reception_extrafields`
--
ALTER TABLE `jvm_reception_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_reception_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_recruitment_recruitmentcandidature`
--
ALTER TABLE `jvm_recruitment_recruitmentcandidature`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_recruitmentcandidature_email_msgid` (`email_msgid`),
  ADD KEY `idx_recruitment_recruitmentcandidature_rowid` (`rowid`),
  ADD KEY `idx_recruitment_recruitmentcandidature_ref` (`ref`),
  ADD KEY `jvm_recruitment_recruitmentcandidature_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_recruitment_recruitmentcandidature_status` (`status`);

--
-- Indexes for table `jvm_recruitment_recruitmentcandidature_extrafields`
--
ALTER TABLE `jvm_recruitment_recruitmentcandidature_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitmentcandidature_fk_object` (`fk_object`);

--
-- Indexes for table `jvm_recruitment_recruitmentjobposition`
--
ALTER TABLE `jvm_recruitment_recruitmentjobposition`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitment_recruitmentjobposition_rowid` (`rowid`),
  ADD KEY `idx_recruitment_recruitmentjobposition_ref` (`ref`),
  ADD KEY `idx_recruitment_recruitmentjobposition_fk_soc` (`fk_soc`),
  ADD KEY `idx_recruitment_recruitmentjobposition_fk_project` (`fk_project`),
  ADD KEY `jvm_recruitment_recruitmentjobposition_fk_user_recruiter` (`fk_user_recruiter`),
  ADD KEY `jvm_recruitment_recruitmentjobposition_fk_user_supervisor` (`fk_user_supervisor`),
  ADD KEY `jvm_recruitment_recruitmentjobposition_fk_establishment` (`fk_establishment`),
  ADD KEY `jvm_recruitment_recruitmentjobposition_fk_user_creat` (`fk_user_creat`),
  ADD KEY `idx_recruitment_recruitmentjobposition_status` (`status`);

--
-- Indexes for table `jvm_recruitment_recruitmentjobposition_extrafields`
--
ALTER TABLE `jvm_recruitment_recruitmentjobposition_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_recruitmentjobposition_fk_object` (`fk_object`);

--
-- Indexes for table `jvm_resource`
--
ALTER TABLE `jvm_resource`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_resource_ref` (`ref`,`entity`),
  ADD KEY `fk_code_type_resource_idx` (`fk_code_type_resource`),
  ADD KEY `idx_resource_fk_country` (`fk_country`);

--
-- Indexes for table `jvm_resource_extrafields`
--
ALTER TABLE `jvm_resource_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_resource_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_rights_def`
--
ALTER TABLE `jvm_rights_def`
  ADD PRIMARY KEY (`id`,`entity`);

--
-- Indexes for table `jvm_session`
--
ALTER TABLE `jvm_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `jvm_societe`
--
ALTER TABLE `jvm_societe`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_prefix_comm` (`prefix_comm`,`entity`),
  ADD UNIQUE KEY `uk_societe_code_client` (`code_client`,`entity`),
  ADD UNIQUE KEY `uk_societe_code_fournisseur` (`code_fournisseur`,`entity`),
  ADD UNIQUE KEY `uk_societe_barcode` (`barcode`,`fk_barcode_type`,`entity`),
  ADD KEY `idx_societe_user_creat` (`fk_user_creat`),
  ADD KEY `idx_societe_user_modif` (`fk_user_modif`),
  ADD KEY `idx_societe_stcomm` (`fk_stcomm`),
  ADD KEY `idx_societe_pays` (`fk_pays`),
  ADD KEY `idx_societe_account` (`fk_account`),
  ADD KEY `idx_societe_prospectlevel` (`fk_prospectlevel`),
  ADD KEY `idx_societe_typent` (`fk_typent`),
  ADD KEY `idx_societe_forme_juridique` (`fk_forme_juridique`),
  ADD KEY `idx_societe_shipping_method` (`fk_shipping_method`),
  ADD KEY `idx_societe_entrepot` (`fk_entrepot`);

--
-- Indexes for table `jvm_societe_account`
--
ALTER TABLE `jvm_societe_account`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_account_login_website_soc` (`entity`,`fk_soc`,`login`,`site`,`fk_website`),
  ADD UNIQUE KEY `uk_societe_account_key_account_soc` (`entity`,`fk_soc`,`key_account`,`site`,`fk_website`),
  ADD KEY `idx_societe_account_rowid` (`rowid`),
  ADD KEY `idx_societe_account_login` (`login`),
  ADD KEY `idx_societe_account_status` (`status`),
  ADD KEY `idx_societe_account_fk_website` (`fk_website`),
  ADD KEY `idx_societe_account_fk_soc` (`fk_soc`);

--
-- Indexes for table `jvm_societe_address`
--
ALTER TABLE `jvm_societe_address`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_societe_commerciaux`
--
ALTER TABLE `jvm_societe_commerciaux`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_commerciaux` (`fk_soc`,`fk_user`);

--
-- Indexes for table `jvm_societe_contacts`
--
ALTER TABLE `jvm_societe_contacts`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `idx_societe_contacts_idx1` (`entity`,`fk_soc`,`fk_c_type_contact`,`fk_socpeople`),
  ADD KEY `fk_societe_contacts_fk_c_type_contact` (`fk_c_type_contact`),
  ADD KEY `fk_societe_contacts_fk_soc` (`fk_soc`),
  ADD KEY `fk_societe_contacts_fk_socpeople` (`fk_socpeople`);

--
-- Indexes for table `jvm_societe_extrafields`
--
ALTER TABLE `jvm_societe_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_societe_prices`
--
ALTER TABLE `jvm_societe_prices`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_societe_remise`
--
ALTER TABLE `jvm_societe_remise`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_societe_remise_except`
--
ALTER TABLE `jvm_societe_remise_except`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_societe_remise_except_fk_user` (`fk_user`),
  ADD KEY `idx_societe_remise_except_fk_soc` (`fk_soc`),
  ADD KEY `idx_societe_remise_except_fk_facture_line` (`fk_facture_line`),
  ADD KEY `idx_societe_remise_except_fk_facture` (`fk_facture`),
  ADD KEY `idx_societe_remise_except_fk_facture_source` (`fk_facture_source`),
  ADD KEY `idx_societe_remise_except_discount_type` (`discount_type`),
  ADD KEY `fk_soc_remise_fk_invoice_supplier_line` (`fk_invoice_supplier_line`),
  ADD KEY `fk_societe_remise_fk_invoice_supplier_source` (`fk_invoice_supplier`);

--
-- Indexes for table `jvm_societe_remise_supplier`
--
ALTER TABLE `jvm_societe_remise_supplier`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_societe_rib`
--
ALTER TABLE `jvm_societe_rib`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_societe_rib` (`label`,`fk_soc`),
  ADD KEY `jvm_societe_rib_fk_societe` (`fk_soc`);

--
-- Indexes for table `jvm_socpeople`
--
ALTER TABLE `jvm_socpeople`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_socpeople_fk_soc` (`fk_soc`),
  ADD KEY `idx_socpeople_fk_user_creat` (`fk_user_creat`);

--
-- Indexes for table `jvm_socpeople_extrafields`
--
ALTER TABLE `jvm_socpeople_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_socpeople_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_stock_mouvement`
--
ALTER TABLE `jvm_stock_mouvement`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_stock_mouvement_fk_product` (`fk_product`),
  ADD KEY `idx_stock_mouvement_fk_entrepot` (`fk_entrepot`);

--
-- Indexes for table `jvm_subscription`
--
ALTER TABLE `jvm_subscription`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_subscription` (`fk_adherent`,`dateadh`);

--
-- Indexes for table `jvm_supplier_proposal`
--
ALTER TABLE `jvm_supplier_proposal`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_supplier_proposaldet`
--
ALTER TABLE `jvm_supplier_proposaldet`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_supplier_proposaldet_fk_supplier_proposal` (`fk_supplier_proposal`),
  ADD KEY `idx_supplier_proposaldet_fk_product` (`fk_product`),
  ADD KEY `fk_supplier_proposaldet_fk_unit` (`fk_unit`);

--
-- Indexes for table `jvm_supplier_proposaldet_extrafields`
--
ALTER TABLE `jvm_supplier_proposaldet_extrafields`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_supplier_proposal_extrafields`
--
ALTER TABLE `jvm_supplier_proposal_extrafields`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_takepos_floor_tables`
--
ALTER TABLE `jvm_takepos_floor_tables`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_ticket`
--
ALTER TABLE `jvm_ticket`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_ticket_track_id` (`track_id`),
  ADD UNIQUE KEY `uk_ticket_ref` (`ref`,`entity`),
  ADD KEY `idx_ticket_entity` (`entity`),
  ADD KEY `idx_ticket_fk_soc` (`fk_soc`),
  ADD KEY `idx_ticket_fk_user_assign` (`fk_user_assign`),
  ADD KEY `idx_ticket_fk_project` (`fk_project`),
  ADD KEY `idx_ticket_fk_statut` (`fk_statut`);

--
-- Indexes for table `jvm_ticket_extrafields`
--
ALTER TABLE `jvm_ticket_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_ticket_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_tva`
--
ALTER TABLE `jvm_tva`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_user`
--
ALTER TABLE `jvm_user`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_login` (`login`,`entity`),
  ADD UNIQUE KEY `uk_user_fk_socpeople` (`fk_socpeople`),
  ADD UNIQUE KEY `uk_user_fk_member` (`fk_member`),
  ADD UNIQUE KEY `uk_user_api_key` (`api_key`),
  ADD KEY `idx_user_fk_societe` (`fk_soc`);

--
-- Indexes for table `jvm_usergroup`
--
ALTER TABLE `jvm_usergroup`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_name` (`nom`,`entity`);

--
-- Indexes for table `jvm_usergroup_extrafields`
--
ALTER TABLE `jvm_usergroup_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_usergroup_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_usergroup_rights`
--
ALTER TABLE `jvm_usergroup_rights`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_rights` (`entity`,`fk_usergroup`,`fk_id`),
  ADD KEY `fk_usergroup_rights_fk_usergroup` (`fk_usergroup`);

--
-- Indexes for table `jvm_usergroup_user`
--
ALTER TABLE `jvm_usergroup_user`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_usergroup_user` (`entity`,`fk_user`,`fk_usergroup`),
  ADD KEY `fk_usergroup_user_fk_user` (`fk_user`),
  ADD KEY `fk_usergroup_user_fk_usergroup` (`fk_usergroup`);

--
-- Indexes for table `jvm_user_alert`
--
ALTER TABLE `jvm_user_alert`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_user_clicktodial`
--
ALTER TABLE `jvm_user_clicktodial`
  ADD PRIMARY KEY (`fk_user`);

--
-- Indexes for table `jvm_user_employment`
--
ALTER TABLE `jvm_user_employment`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_employment` (`ref`,`entity`),
  ADD KEY `fk_user_employment_fk_user` (`fk_user`);

--
-- Indexes for table `jvm_user_extrafields`
--
ALTER TABLE `jvm_user_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_user_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_user_param`
--
ALTER TABLE `jvm_user_param`
  ADD UNIQUE KEY `uk_user_param` (`fk_user`,`param`,`entity`);

--
-- Indexes for table `jvm_user_rib`
--
ALTER TABLE `jvm_user_rib`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `jvm_user_rights`
--
ALTER TABLE `jvm_user_rights`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_user_rights` (`entity`,`fk_user`,`fk_id`),
  ADD KEY `fk_user_rights_fk_user_user` (`fk_user`);

--
-- Indexes for table `jvm_website`
--
ALTER TABLE `jvm_website`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_website_ref` (`ref`,`entity`);

--
-- Indexes for table `jvm_website_extrafields`
--
ALTER TABLE `jvm_website_extrafields`
  ADD PRIMARY KEY (`rowid`),
  ADD KEY `idx_website_extrafields` (`fk_object`);

--
-- Indexes for table `jvm_website_page`
--
ALTER TABLE `jvm_website_page`
  ADD PRIMARY KEY (`rowid`),
  ADD UNIQUE KEY `uk_website_page_url` (`fk_website`,`pageurl`);

--
-- Indexes for table `jvm_zapier_hook`
--
ALTER TABLE `jvm_zapier_hook`
  ADD PRIMARY KEY (`rowid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jvm_accounting_account`
--
ALTER TABLE `jvm_accounting_account`
  MODIFY `rowid` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_accounting_bookkeeping`
--
ALTER TABLE `jvm_accounting_bookkeeping`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_accounting_bookkeeping_tmp`
--
ALTER TABLE `jvm_accounting_bookkeeping_tmp`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_accounting_fiscalyear`
--
ALTER TABLE `jvm_accounting_fiscalyear`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_accounting_journal`
--
ALTER TABLE `jvm_accounting_journal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jvm_accounting_system`
--
ALTER TABLE `jvm_accounting_system`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `jvm_actioncomm`
--
ALTER TABLE `jvm_actioncomm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_actioncomm_extrafields`
--
ALTER TABLE `jvm_actioncomm_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_actioncomm_reminder`
--
ALTER TABLE `jvm_actioncomm_reminder`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_actioncomm_resources`
--
ALTER TABLE `jvm_actioncomm_resources`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_adherent`
--
ALTER TABLE `jvm_adherent`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_adherent_extrafields`
--
ALTER TABLE `jvm_adherent_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_adherent_type`
--
ALTER TABLE `jvm_adherent_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_adherent_type_extrafields`
--
ALTER TABLE `jvm_adherent_type_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_adherent_type_lang`
--
ALTER TABLE `jvm_adherent_type_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_advtargetemailing`
--
ALTER TABLE `jvm_advtargetemailing`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_asset`
--
ALTER TABLE `jvm_asset`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_asset_extrafields`
--
ALTER TABLE `jvm_asset_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_asset_type`
--
ALTER TABLE `jvm_asset_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_asset_type_extrafields`
--
ALTER TABLE `jvm_asset_type_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bank`
--
ALTER TABLE `jvm_bank`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bank_account`
--
ALTER TABLE `jvm_bank_account`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bank_account_extrafields`
--
ALTER TABLE `jvm_bank_account_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bank_categ`
--
ALTER TABLE `jvm_bank_categ`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bank_url`
--
ALTER TABLE `jvm_bank_url`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_blockedlog`
--
ALTER TABLE `jvm_blockedlog`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_blockedlog_authority`
--
ALTER TABLE `jvm_blockedlog_authority`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bom_bom`
--
ALTER TABLE `jvm_bom_bom`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bom_bomline`
--
ALTER TABLE `jvm_bom_bomline`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bom_bomline_extrafields`
--
ALTER TABLE `jvm_bom_bomline_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bom_bom_extrafields`
--
ALTER TABLE `jvm_bom_bom_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bookmark`
--
ALTER TABLE `jvm_bookmark`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_bordereau_cheque`
--
ALTER TABLE `jvm_bordereau_cheque`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_boxes`
--
ALTER TABLE `jvm_boxes`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `jvm_boxes_def`
--
ALTER TABLE `jvm_boxes_def`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `jvm_budget`
--
ALTER TABLE `jvm_budget`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_budget_lines`
--
ALTER TABLE `jvm_budget_lines`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_categorie`
--
ALTER TABLE `jvm_categorie`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_categories_extrafields`
--
ALTER TABLE `jvm_categories_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_categorie_lang`
--
ALTER TABLE `jvm_categorie_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_chargesociales`
--
ALTER TABLE `jvm_chargesociales`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande`
--
ALTER TABLE `jvm_commande`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commandedet`
--
ALTER TABLE `jvm_commandedet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commandedet_extrafields`
--
ALTER TABLE `jvm_commandedet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_extrafields`
--
ALTER TABLE `jvm_commande_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseur`
--
ALTER TABLE `jvm_commande_fournisseur`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseurdet`
--
ALTER TABLE `jvm_commande_fournisseurdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseurdet_extrafields`
--
ALTER TABLE `jvm_commande_fournisseurdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseur_dispatch`
--
ALTER TABLE `jvm_commande_fournisseur_dispatch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseur_dispatch_extrafields`
--
ALTER TABLE `jvm_commande_fournisseur_dispatch_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseur_extrafields`
--
ALTER TABLE `jvm_commande_fournisseur_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_commande_fournisseur_log`
--
ALTER TABLE `jvm_commande_fournisseur_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_comment`
--
ALTER TABLE `jvm_comment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_const`
--
ALTER TABLE `jvm_const`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;

--
-- AUTO_INCREMENT for table `jvm_contrat`
--
ALTER TABLE `jvm_contrat`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_contratdet`
--
ALTER TABLE `jvm_contratdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_contratdet_extrafields`
--
ALTER TABLE `jvm_contratdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_contratdet_log`
--
ALTER TABLE `jvm_contratdet_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_contrat_extrafields`
--
ALTER TABLE `jvm_contrat_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_cronjob`
--
ALTER TABLE `jvm_cronjob`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jvm_c_accounting_category`
--
ALTER TABLE `jvm_c_accounting_category`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jvm_c_action_trigger`
--
ALTER TABLE `jvm_c_action_trigger`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `jvm_c_availability`
--
ALTER TABLE `jvm_c_availability`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jvm_c_barcode_type`
--
ALTER TABLE `jvm_c_barcode_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jvm_c_chargesociales`
--
ALTER TABLE `jvm_c_chargesociales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4110;

--
-- AUTO_INCREMENT for table `jvm_c_cities`
--
ALTER TABLE `jvm_c_cities`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jvm_c_departements`
--
ALTER TABLE `jvm_c_departements`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1510;

--
-- AUTO_INCREMENT for table `jvm_c_ecotaxe`
--
ALTER TABLE `jvm_c_ecotaxe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jvm_c_email_senderprofile`
--
ALTER TABLE `jvm_c_email_senderprofile`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_email_templates`
--
ALTER TABLE `jvm_c_email_templates`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jvm_c_exp_tax_cat`
--
ALTER TABLE `jvm_c_exp_tax_cat`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `jvm_c_exp_tax_range`
--
ALTER TABLE `jvm_c_exp_tax_range`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jvm_c_field_list`
--
ALTER TABLE `jvm_c_field_list`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_format_cards`
--
ALTER TABLE `jvm_c_format_cards`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jvm_c_forme_juridique`
--
ALTER TABLE `jvm_c_forme_juridique`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `jvm_c_holiday_types`
--
ALTER TABLE `jvm_c_holiday_types`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jvm_c_hrm_public_holiday`
--
ALTER TABLE `jvm_c_hrm_public_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `jvm_c_incoterms`
--
ALTER TABLE `jvm_c_incoterms`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jvm_c_input_method`
--
ALTER TABLE `jvm_c_input_method`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jvm_c_input_reason`
--
ALTER TABLE `jvm_c_input_reason`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jvm_c_lead_status`
--
ALTER TABLE `jvm_c_lead_status`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jvm_c_paiement`
--
ALTER TABLE `jvm_c_paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `jvm_c_paper_format`
--
ALTER TABLE `jvm_c_paper_format`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `jvm_c_payment_term`
--
ALTER TABLE `jvm_c_payment_term`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jvm_c_pincodes`
--
ALTER TABLE `jvm_c_pincodes`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jvm_c_price_expression`
--
ALTER TABLE `jvm_c_price_expression`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_price_global_variable`
--
ALTER TABLE `jvm_c_price_global_variable`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_price_global_variable_updater`
--
ALTER TABLE `jvm_c_price_global_variable_updater`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_product_nature`
--
ALTER TABLE `jvm_c_product_nature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jvm_c_recruitment_origin`
--
ALTER TABLE `jvm_c_recruitment_origin`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_regions`
--
ALTER TABLE `jvm_c_regions`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `jvm_c_revenuestamp`
--
ALTER TABLE `jvm_c_revenuestamp`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1543;

--
-- AUTO_INCREMENT for table `jvm_c_shipment_mode`
--
ALTER TABLE `jvm_c_shipment_mode`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jvm_c_shipment_package_type`
--
ALTER TABLE `jvm_c_shipment_package_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_c_socialnetworks`
--
ALTER TABLE `jvm_c_socialnetworks`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `jvm_c_ticket_category`
--
ALTER TABLE `jvm_c_ticket_category`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jvm_c_ticket_resolution`
--
ALTER TABLE `jvm_c_ticket_resolution`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jvm_c_ticket_severity`
--
ALTER TABLE `jvm_c_ticket_severity`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jvm_c_ticket_type`
--
ALTER TABLE `jvm_c_ticket_type`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jvm_c_transport_mode`
--
ALTER TABLE `jvm_c_transport_mode`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jvm_c_tva`
--
ALTER TABLE `jvm_c_tva`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2462;

--
-- AUTO_INCREMENT for table `jvm_c_type_container`
--
ALTER TABLE `jvm_c_type_container`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jvm_c_type_fees`
--
ALTER TABLE `jvm_c_type_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jvm_c_type_resource`
--
ALTER TABLE `jvm_c_type_resource`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jvm_c_units`
--
ALTER TABLE `jvm_c_units`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `jvm_c_ziptown`
--
ALTER TABLE `jvm_c_ziptown`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_default_values`
--
ALTER TABLE `jvm_default_values`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_delivery`
--
ALTER TABLE `jvm_delivery`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_deliverydet`
--
ALTER TABLE `jvm_deliverydet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_deliverydet_extrafields`
--
ALTER TABLE `jvm_deliverydet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_delivery_extrafields`
--
ALTER TABLE `jvm_delivery_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_deplacement`
--
ALTER TABLE `jvm_deplacement`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_document_model`
--
ALTER TABLE `jvm_document_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jvm_don`
--
ALTER TABLE `jvm_don`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_don_extrafields`
--
ALTER TABLE `jvm_don_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_ecm_directories`
--
ALTER TABLE `jvm_ecm_directories`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_ecm_directories_extrafields`
--
ALTER TABLE `jvm_ecm_directories_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_ecm_files`
--
ALTER TABLE `jvm_ecm_files`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jvm_ecm_files_extrafields`
--
ALTER TABLE `jvm_ecm_files_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_element_contact`
--
ALTER TABLE `jvm_element_contact`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_element_element`
--
ALTER TABLE `jvm_element_element`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_element_resources`
--
ALTER TABLE `jvm_element_resources`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_emailcollector_emailcollector`
--
ALTER TABLE `jvm_emailcollector_emailcollector`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_emailcollector_emailcollectoraction`
--
ALTER TABLE `jvm_emailcollector_emailcollectoraction`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_emailcollector_emailcollectorfilter`
--
ALTER TABLE `jvm_emailcollector_emailcollectorfilter`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_entrepot`
--
ALTER TABLE `jvm_entrepot`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_entrepot_extrafields`
--
ALTER TABLE `jvm_entrepot_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_establishment`
--
ALTER TABLE `jvm_establishment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_events`
--
ALTER TABLE `jvm_events`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_event_element`
--
ALTER TABLE `jvm_event_element`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expedition`
--
ALTER TABLE `jvm_expedition`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expeditiondet`
--
ALTER TABLE `jvm_expeditiondet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expeditiondet_batch`
--
ALTER TABLE `jvm_expeditiondet_batch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expeditiondet_extrafields`
--
ALTER TABLE `jvm_expeditiondet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expedition_extrafields`
--
ALTER TABLE `jvm_expedition_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expedition_package`
--
ALTER TABLE `jvm_expedition_package`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expensereport`
--
ALTER TABLE `jvm_expensereport`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expensereport_det`
--
ALTER TABLE `jvm_expensereport_det`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expensereport_extrafields`
--
ALTER TABLE `jvm_expensereport_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_expensereport_ik`
--
ALTER TABLE `jvm_expensereport_ik`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jvm_expensereport_rules`
--
ALTER TABLE `jvm_expensereport_rules`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_export_compta`
--
ALTER TABLE `jvm_export_compta`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_export_model`
--
ALTER TABLE `jvm_export_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_extrafields`
--
ALTER TABLE `jvm_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture`
--
ALTER TABLE `jvm_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facturedet`
--
ALTER TABLE `jvm_facturedet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facturedet_extrafields`
--
ALTER TABLE `jvm_facturedet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facturedet_rec`
--
ALTER TABLE `jvm_facturedet_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facturedet_rec_extrafields`
--
ALTER TABLE `jvm_facturedet_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_extrafields`
--
ALTER TABLE `jvm_facture_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_fourn`
--
ALTER TABLE `jvm_facture_fourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_fourn_det`
--
ALTER TABLE `jvm_facture_fourn_det`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_fourn_det_extrafields`
--
ALTER TABLE `jvm_facture_fourn_det_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_fourn_extrafields`
--
ALTER TABLE `jvm_facture_fourn_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_rec`
--
ALTER TABLE `jvm_facture_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_facture_rec_extrafields`
--
ALTER TABLE `jvm_facture_rec_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinter`
--
ALTER TABLE `jvm_fichinter`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinterdet`
--
ALTER TABLE `jvm_fichinterdet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinterdet_extrafields`
--
ALTER TABLE `jvm_fichinterdet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinterdet_rec`
--
ALTER TABLE `jvm_fichinterdet_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinter_extrafields`
--
ALTER TABLE `jvm_fichinter_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_fichinter_rec`
--
ALTER TABLE `jvm_fichinter_rec`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_holiday`
--
ALTER TABLE `jvm_holiday`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_holiday_config`
--
ALTER TABLE `jvm_holiday_config`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jvm_holiday_extrafields`
--
ALTER TABLE `jvm_holiday_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_holiday_logs`
--
ALTER TABLE `jvm_holiday_logs`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_import_model`
--
ALTER TABLE `jvm_import_model`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_intracommreport`
--
ALTER TABLE `jvm_intracommreport`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_inventory`
--
ALTER TABLE `jvm_inventory`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_inventorydet`
--
ALTER TABLE `jvm_inventorydet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_links`
--
ALTER TABLE `jvm_links`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_loan`
--
ALTER TABLE `jvm_loan`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_loan_schedule`
--
ALTER TABLE `jvm_loan_schedule`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_localtax`
--
ALTER TABLE `jvm_localtax`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_mailing`
--
ALTER TABLE `jvm_mailing`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_mailing_cibles`
--
ALTER TABLE `jvm_mailing_cibles`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_mailing_unsubscribe`
--
ALTER TABLE `jvm_mailing_unsubscribe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_menu`
--
ALTER TABLE `jvm_menu`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `jvm_mrp_mo`
--
ALTER TABLE `jvm_mrp_mo`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_mrp_mo_extrafields`
--
ALTER TABLE `jvm_mrp_mo_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_mrp_production`
--
ALTER TABLE `jvm_mrp_production`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_multicurrency`
--
ALTER TABLE `jvm_multicurrency`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_multicurrency_rate`
--
ALTER TABLE `jvm_multicurrency_rate`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_notify`
--
ALTER TABLE `jvm_notify`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_notify_def`
--
ALTER TABLE `jvm_notify_def`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_notify_def_object`
--
ALTER TABLE `jvm_notify_def_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_oauth_state`
--
ALTER TABLE `jvm_oauth_state`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_oauth_token`
--
ALTER TABLE `jvm_oauth_token`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_object_lang`
--
ALTER TABLE `jvm_object_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_onlinesignature`
--
ALTER TABLE `jvm_onlinesignature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_opensurvey_comments`
--
ALTER TABLE `jvm_opensurvey_comments`
  MODIFY `id_comment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_opensurvey_formquestions`
--
ALTER TABLE `jvm_opensurvey_formquestions`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_opensurvey_user_studs`
--
ALTER TABLE `jvm_opensurvey_user_studs`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_overwrite_trans`
--
ALTER TABLE `jvm_overwrite_trans`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jvm_paiement`
--
ALTER TABLE `jvm_paiement`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_paiementcharge`
--
ALTER TABLE `jvm_paiementcharge`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_paiementfourn`
--
ALTER TABLE `jvm_paiementfourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_paiementfourn_facturefourn`
--
ALTER TABLE `jvm_paiementfourn_facturefourn`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_paiement_facture`
--
ALTER TABLE `jvm_paiement_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_donation`
--
ALTER TABLE `jvm_payment_donation`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_expensereport`
--
ALTER TABLE `jvm_payment_expensereport`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_loan`
--
ALTER TABLE `jvm_payment_loan`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_salary`
--
ALTER TABLE `jvm_payment_salary`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_salary_extrafields`
--
ALTER TABLE `jvm_payment_salary_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_payment_various`
--
ALTER TABLE `jvm_payment_various`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_pos_cash_fence`
--
ALTER TABLE `jvm_pos_cash_fence`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_prelevement_bons`
--
ALTER TABLE `jvm_prelevement_bons`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_prelevement_facture`
--
ALTER TABLE `jvm_prelevement_facture`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_prelevement_facture_demande`
--
ALTER TABLE `jvm_prelevement_facture_demande`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_prelevement_lignes`
--
ALTER TABLE `jvm_prelevement_lignes`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_prelevement_rejet`
--
ALTER TABLE `jvm_prelevement_rejet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_printing`
--
ALTER TABLE `jvm_printing`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product`
--
ALTER TABLE `jvm_product`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_association`
--
ALTER TABLE `jvm_product_association`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_attribute`
--
ALTER TABLE `jvm_product_attribute`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_attribute_combination`
--
ALTER TABLE `jvm_product_attribute_combination`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_attribute_combination2val`
--
ALTER TABLE `jvm_product_attribute_combination2val`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_attribute_combination_price_level`
--
ALTER TABLE `jvm_product_attribute_combination_price_level`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_attribute_value`
--
ALTER TABLE `jvm_product_attribute_value`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_batch`
--
ALTER TABLE `jvm_product_batch`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_customer_price`
--
ALTER TABLE `jvm_product_customer_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_customer_price_log`
--
ALTER TABLE `jvm_product_customer_price_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_extrafields`
--
ALTER TABLE `jvm_product_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_fournisseur_price`
--
ALTER TABLE `jvm_product_fournisseur_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_fournisseur_price_extrafields`
--
ALTER TABLE `jvm_product_fournisseur_price_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_fournisseur_price_log`
--
ALTER TABLE `jvm_product_fournisseur_price_log`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_lang`
--
ALTER TABLE `jvm_product_lang`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_lot`
--
ALTER TABLE `jvm_product_lot`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_lot_extrafields`
--
ALTER TABLE `jvm_product_lot_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_price`
--
ALTER TABLE `jvm_product_price`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_pricerules`
--
ALTER TABLE `jvm_product_pricerules`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_price_by_qty`
--
ALTER TABLE `jvm_product_price_by_qty`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_stock`
--
ALTER TABLE `jvm_product_stock`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_product_warehouse_properties`
--
ALTER TABLE `jvm_product_warehouse_properties`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_projet`
--
ALTER TABLE `jvm_projet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_projet_extrafields`
--
ALTER TABLE `jvm_projet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_projet_task`
--
ALTER TABLE `jvm_projet_task`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_projet_task_extrafields`
--
ALTER TABLE `jvm_projet_task_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_projet_task_time`
--
ALTER TABLE `jvm_projet_task_time`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_propal`
--
ALTER TABLE `jvm_propal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_propaldet`
--
ALTER TABLE `jvm_propaldet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_propaldet_extrafields`
--
ALTER TABLE `jvm_propaldet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_propal_extrafields`
--
ALTER TABLE `jvm_propal_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_propal_merge_pdf_product`
--
ALTER TABLE `jvm_propal_merge_pdf_product`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_reception`
--
ALTER TABLE `jvm_reception`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_reception_extrafields`
--
ALTER TABLE `jvm_reception_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_recruitment_recruitmentcandidature`
--
ALTER TABLE `jvm_recruitment_recruitmentcandidature`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_recruitment_recruitmentcandidature_extrafields`
--
ALTER TABLE `jvm_recruitment_recruitmentcandidature_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_recruitment_recruitmentjobposition`
--
ALTER TABLE `jvm_recruitment_recruitmentjobposition`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_recruitment_recruitmentjobposition_extrafields`
--
ALTER TABLE `jvm_recruitment_recruitmentjobposition_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_resource`
--
ALTER TABLE `jvm_resource`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_resource_extrafields`
--
ALTER TABLE `jvm_resource_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe`
--
ALTER TABLE `jvm_societe`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_account`
--
ALTER TABLE `jvm_societe_account`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_address`
--
ALTER TABLE `jvm_societe_address`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_commerciaux`
--
ALTER TABLE `jvm_societe_commerciaux`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_contacts`
--
ALTER TABLE `jvm_societe_contacts`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_extrafields`
--
ALTER TABLE `jvm_societe_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_prices`
--
ALTER TABLE `jvm_societe_prices`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_remise`
--
ALTER TABLE `jvm_societe_remise`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_remise_except`
--
ALTER TABLE `jvm_societe_remise_except`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_remise_supplier`
--
ALTER TABLE `jvm_societe_remise_supplier`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_societe_rib`
--
ALTER TABLE `jvm_societe_rib`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_socpeople`
--
ALTER TABLE `jvm_socpeople`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_socpeople_extrafields`
--
ALTER TABLE `jvm_socpeople_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_stock_mouvement`
--
ALTER TABLE `jvm_stock_mouvement`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_subscription`
--
ALTER TABLE `jvm_subscription`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_supplier_proposal`
--
ALTER TABLE `jvm_supplier_proposal`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_supplier_proposaldet`
--
ALTER TABLE `jvm_supplier_proposaldet`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_supplier_proposaldet_extrafields`
--
ALTER TABLE `jvm_supplier_proposaldet_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_supplier_proposal_extrafields`
--
ALTER TABLE `jvm_supplier_proposal_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_takepos_floor_tables`
--
ALTER TABLE `jvm_takepos_floor_tables`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_ticket`
--
ALTER TABLE `jvm_ticket`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_ticket_extrafields`
--
ALTER TABLE `jvm_ticket_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_tva`
--
ALTER TABLE `jvm_tva`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_user`
--
ALTER TABLE `jvm_user`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jvm_usergroup`
--
ALTER TABLE `jvm_usergroup`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jvm_usergroup_extrafields`
--
ALTER TABLE `jvm_usergroup_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_usergroup_rights`
--
ALTER TABLE `jvm_usergroup_rights`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=773;

--
-- AUTO_INCREMENT for table `jvm_usergroup_user`
--
ALTER TABLE `jvm_usergroup_user`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jvm_user_alert`
--
ALTER TABLE `jvm_user_alert`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_user_employment`
--
ALTER TABLE `jvm_user_employment`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_user_extrafields`
--
ALTER TABLE `jvm_user_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_user_rib`
--
ALTER TABLE `jvm_user_rib`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_user_rights`
--
ALTER TABLE `jvm_user_rights`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `jvm_website`
--
ALTER TABLE `jvm_website`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_website_extrafields`
--
ALTER TABLE `jvm_website_extrafields`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_website_page`
--
ALTER TABLE `jvm_website_page`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jvm_zapier_hook`
--
ALTER TABLE `jvm_zapier_hook`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jvm_accounting_account`
--
ALTER TABLE `jvm_accounting_account`
  ADD CONSTRAINT `fk_accounting_account_fk_pcg_version` FOREIGN KEY (`fk_pcg_version`) REFERENCES `jvm_accounting_system` (`pcg_version`);

--
-- Constraints for table `jvm_adherent`
--
ALTER TABLE `jvm_adherent`
  ADD CONSTRAINT `adherent_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_adherent_adherent_type` FOREIGN KEY (`fk_adherent_type`) REFERENCES `jvm_adherent_type` (`rowid`);

--
-- Constraints for table `jvm_asset`
--
ALTER TABLE `jvm_asset`
  ADD CONSTRAINT `fk_asset_asset_type` FOREIGN KEY (`fk_asset_type`) REFERENCES `jvm_asset_type` (`rowid`);

--
-- Constraints for table `jvm_bank_account`
--
ALTER TABLE `jvm_bank_account`
  ADD CONSTRAINT `fk_bank_account_accountancy_journal` FOREIGN KEY (`fk_accountancy_journal`) REFERENCES `jvm_accounting_journal` (`rowid`);

--
-- Constraints for table `jvm_bom_bom`
--
ALTER TABLE `jvm_bom_bom`
  ADD CONSTRAINT `jvm_bom_bom_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_bom_bomline`
--
ALTER TABLE `jvm_bom_bomline`
  ADD CONSTRAINT `jvm_bom_bomline_fk_bom` FOREIGN KEY (`fk_bom`) REFERENCES `jvm_bom_bom` (`rowid`);

--
-- Constraints for table `jvm_boxes`
--
ALTER TABLE `jvm_boxes`
  ADD CONSTRAINT `fk_boxes_box_id` FOREIGN KEY (`box_id`) REFERENCES `jvm_boxes_def` (`rowid`);

--
-- Constraints for table `jvm_budget_lines`
--
ALTER TABLE `jvm_budget_lines`
  ADD CONSTRAINT `fk_budget_lines_budget` FOREIGN KEY (`fk_budget`) REFERENCES `jvm_budget` (`rowid`);

--
-- Constraints for table `jvm_categorie_account`
--
ALTER TABLE `jvm_categorie_account`
  ADD CONSTRAINT `fk_categorie_account_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_account_fk_account` FOREIGN KEY (`fk_account`) REFERENCES `jvm_bank_account` (`rowid`);

--
-- Constraints for table `jvm_categorie_actioncomm`
--
ALTER TABLE `jvm_categorie_actioncomm`
  ADD CONSTRAINT `fk_categorie_actioncomm_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_actioncomm_fk_actioncomm` FOREIGN KEY (`fk_actioncomm`) REFERENCES `jvm_actioncomm` (`id`);

--
-- Constraints for table `jvm_categorie_contact`
--
ALTER TABLE `jvm_categorie_contact`
  ADD CONSTRAINT `fk_categorie_contact_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_contact_fk_socpeople` FOREIGN KEY (`fk_socpeople`) REFERENCES `jvm_socpeople` (`rowid`);

--
-- Constraints for table `jvm_categorie_fournisseur`
--
ALTER TABLE `jvm_categorie_fournisseur`
  ADD CONSTRAINT `fk_categorie_fournisseur_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_fournisseur_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_categorie_lang`
--
ALTER TABLE `jvm_categorie_lang`
  ADD CONSTRAINT `fk_category_lang_fk_category` FOREIGN KEY (`fk_category`) REFERENCES `jvm_categorie` (`rowid`);

--
-- Constraints for table `jvm_categorie_member`
--
ALTER TABLE `jvm_categorie_member`
  ADD CONSTRAINT `fk_categorie_member_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_member_member_rowid` FOREIGN KEY (`fk_member`) REFERENCES `jvm_adherent` (`rowid`);

--
-- Constraints for table `jvm_categorie_product`
--
ALTER TABLE `jvm_categorie_product`
  ADD CONSTRAINT `fk_categorie_product_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_product_product_rowid` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`);

--
-- Constraints for table `jvm_categorie_project`
--
ALTER TABLE `jvm_categorie_project`
  ADD CONSTRAINT `fk_categorie_project_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_project_fk_project_rowid` FOREIGN KEY (`fk_project`) REFERENCES `jvm_projet` (`rowid`);

--
-- Constraints for table `jvm_categorie_societe`
--
ALTER TABLE `jvm_categorie_societe`
  ADD CONSTRAINT `fk_categorie_societe_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_societe_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_categorie_user`
--
ALTER TABLE `jvm_categorie_user`
  ADD CONSTRAINT `fk_categorie_user_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_user_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_categorie_warehouse`
--
ALTER TABLE `jvm_categorie_warehouse`
  ADD CONSTRAINT `fk_categorie_warehouse_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_warehouse_fk_warehouse_rowid` FOREIGN KEY (`fk_warehouse`) REFERENCES `jvm_entrepot` (`rowid`);

--
-- Constraints for table `jvm_categorie_website_page`
--
ALTER TABLE `jvm_categorie_website_page`
  ADD CONSTRAINT `fk_categorie_websitepage_categorie_rowid` FOREIGN KEY (`fk_categorie`) REFERENCES `jvm_categorie` (`rowid`),
  ADD CONSTRAINT `fk_categorie_websitepage_website_page_rowid` FOREIGN KEY (`fk_website_page`) REFERENCES `jvm_website_page` (`rowid`);

--
-- Constraints for table `jvm_commande`
--
ALTER TABLE `jvm_commande`
  ADD CONSTRAINT `fk_commande_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_cloture` FOREIGN KEY (`fk_user_cloture`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_commande_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_commandedet`
--
ALTER TABLE `jvm_commandedet`
  ADD CONSTRAINT `fk_commandedet_fk_commande` FOREIGN KEY (`fk_commande`) REFERENCES `jvm_commande` (`rowid`),
  ADD CONSTRAINT `fk_commandedet_fk_commandefourndet` FOREIGN KEY (`fk_commandefourndet`) REFERENCES `jvm_commande_fournisseurdet` (`rowid`),
  ADD CONSTRAINT `fk_commandedet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_commande_fournisseur`
--
ALTER TABLE `jvm_commande_fournisseur`
  ADD CONSTRAINT `fk_commande_fournisseur_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_commande_fournisseurdet`
--
ALTER TABLE `jvm_commande_fournisseurdet`
  ADD CONSTRAINT `fk_commande_fournisseurdet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_commande_fournisseur_dispatch`
--
ALTER TABLE `jvm_commande_fournisseur_dispatch`
  ADD CONSTRAINT `fk_commande_fournisseur_dispatch_fk_reception` FOREIGN KEY (`fk_reception`) REFERENCES `jvm_reception` (`rowid`);

--
-- Constraints for table `jvm_contrat`
--
ALTER TABLE `jvm_contrat`
  ADD CONSTRAINT `fk_contrat_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_contrat_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_contratdet`
--
ALTER TABLE `jvm_contratdet`
  ADD CONSTRAINT `fk_contratdet_fk_contrat` FOREIGN KEY (`fk_contrat`) REFERENCES `jvm_contrat` (`rowid`),
  ADD CONSTRAINT `fk_contratdet_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`),
  ADD CONSTRAINT `fk_contratdet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_contratdet_log`
--
ALTER TABLE `jvm_contratdet_log`
  ADD CONSTRAINT `fk_contratdet_log_fk_contratdet` FOREIGN KEY (`fk_contratdet`) REFERENCES `jvm_contratdet` (`rowid`);

--
-- Constraints for table `jvm_c_departements`
--
ALTER TABLE `jvm_c_departements`
  ADD CONSTRAINT `fk_departements_fk_region` FOREIGN KEY (`fk_region`) REFERENCES `jvm_c_regions` (`code_region`);

--
-- Constraints for table `jvm_c_regions`
--
ALTER TABLE `jvm_c_regions`
  ADD CONSTRAINT `fk_c_regions_fk_pays` FOREIGN KEY (`fk_pays`) REFERENCES `jvm_c_country` (`rowid`);

--
-- Constraints for table `jvm_c_ziptown`
--
ALTER TABLE `jvm_c_ziptown`
  ADD CONSTRAINT `fk_c_ziptown_fk_county` FOREIGN KEY (`fk_county`) REFERENCES `jvm_c_departements` (`rowid`),
  ADD CONSTRAINT `fk_c_ziptown_fk_pays` FOREIGN KEY (`fk_pays`) REFERENCES `jvm_c_country` (`rowid`);

--
-- Constraints for table `jvm_delivery`
--
ALTER TABLE `jvm_delivery`
  ADD CONSTRAINT `fk_delivery_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_delivery_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_delivery_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_deliverydet`
--
ALTER TABLE `jvm_deliverydet`
  ADD CONSTRAINT `fk_deliverydet_fk_delivery` FOREIGN KEY (`fk_delivery`) REFERENCES `jvm_delivery` (`rowid`);

--
-- Constraints for table `jvm_ecm_directories`
--
ALTER TABLE `jvm_ecm_directories`
  ADD CONSTRAINT `fk_ecm_directories_fk_user_c` FOREIGN KEY (`fk_user_c`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_ecm_directories_fk_user_m` FOREIGN KEY (`fk_user_m`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_element_contact`
--
ALTER TABLE `jvm_element_contact`
  ADD CONSTRAINT `fk_element_contact_fk_c_type_contact` FOREIGN KEY (`fk_c_type_contact`) REFERENCES `jvm_c_type_contact` (`rowid`);

--
-- Constraints for table `jvm_emailcollector_emailcollectoraction`
--
ALTER TABLE `jvm_emailcollector_emailcollectoraction`
  ADD CONSTRAINT `fk_emailcollectoraction_fk_emailcollector` FOREIGN KEY (`fk_emailcollector`) REFERENCES `jvm_emailcollector_emailcollector` (`rowid`);

--
-- Constraints for table `jvm_emailcollector_emailcollectorfilter`
--
ALTER TABLE `jvm_emailcollector_emailcollectorfilter`
  ADD CONSTRAINT `fk_emailcollectorfilter_fk_emailcollector` FOREIGN KEY (`fk_emailcollector`) REFERENCES `jvm_emailcollector_emailcollector` (`rowid`);

--
-- Constraints for table `jvm_expedition`
--
ALTER TABLE `jvm_expedition`
  ADD CONSTRAINT `fk_expedition_fk_shipping_method` FOREIGN KEY (`fk_shipping_method`) REFERENCES `jvm_c_shipment_mode` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_expedition_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_expeditiondet`
--
ALTER TABLE `jvm_expeditiondet`
  ADD CONSTRAINT `fk_expeditiondet_fk_expedition` FOREIGN KEY (`fk_expedition`) REFERENCES `jvm_expedition` (`rowid`);

--
-- Constraints for table `jvm_expeditiondet_batch`
--
ALTER TABLE `jvm_expeditiondet_batch`
  ADD CONSTRAINT `fk_expeditiondet_batch_fk_expeditiondet` FOREIGN KEY (`fk_expeditiondet`) REFERENCES `jvm_expeditiondet` (`rowid`);

--
-- Constraints for table `jvm_facture`
--
ALTER TABLE `jvm_facture`
  ADD CONSTRAINT `fk_facture_fk_facture_source` FOREIGN KEY (`fk_facture_source`) REFERENCES `jvm_facture` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_facture_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_facturedet`
--
ALTER TABLE `jvm_facturedet`
  ADD CONSTRAINT `fk_facturedet_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `jvm_facture` (`rowid`),
  ADD CONSTRAINT `fk_facturedet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_facturedet_rec`
--
ALTER TABLE `jvm_facturedet_rec`
  ADD CONSTRAINT `fk_facturedet_rec_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_facture_fourn`
--
ALTER TABLE `jvm_facture_fourn`
  ADD CONSTRAINT `fk_facture_fourn_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_facture_fourn_det`
--
ALTER TABLE `jvm_facture_fourn_det`
  ADD CONSTRAINT `fk_facture_fourn_det_fk_facture` FOREIGN KEY (`fk_facture_fourn`) REFERENCES `jvm_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_facture_fourn_det_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_facture_rec`
--
ALTER TABLE `jvm_facture_rec`
  ADD CONSTRAINT `fk_facture_rec_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_facture_rec_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_facture_rec_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_fichinter`
--
ALTER TABLE `jvm_fichinter`
  ADD CONSTRAINT `fk_fichinter_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_fichinterdet`
--
ALTER TABLE `jvm_fichinterdet`
  ADD CONSTRAINT `fk_fichinterdet_fk_fichinter` FOREIGN KEY (`fk_fichinter`) REFERENCES `jvm_fichinter` (`rowid`);

--
-- Constraints for table `jvm_fichinter_rec`
--
ALTER TABLE `jvm_fichinter_rec`
  ADD CONSTRAINT `fk_fichinter_rec_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_fichinter_rec_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_mrp_mo`
--
ALTER TABLE `jvm_mrp_mo`
  ADD CONSTRAINT `fk_mrp_mo_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_mrp_production`
--
ALTER TABLE `jvm_mrp_production`
  ADD CONSTRAINT `fk_mrp_production_mo` FOREIGN KEY (`fk_mo`) REFERENCES `jvm_mrp_mo` (`rowid`),
  ADD CONSTRAINT `fk_mrp_production_product` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`),
  ADD CONSTRAINT `fk_mrp_production_stock_movement` FOREIGN KEY (`fk_stock_movement`) REFERENCES `jvm_stock_mouvement` (`rowid`);

--
-- Constraints for table `jvm_paiement_facture`
--
ALTER TABLE `jvm_paiement_facture`
  ADD CONSTRAINT `fk_paiement_facture_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `jvm_facture` (`rowid`),
  ADD CONSTRAINT `fk_paiement_facture_fk_paiement` FOREIGN KEY (`fk_paiement`) REFERENCES `jvm_paiement` (`rowid`);

--
-- Constraints for table `jvm_payment_salary`
--
ALTER TABLE `jvm_payment_salary`
  ADD CONSTRAINT `fk_payment_salary_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_prelevement_facture`
--
ALTER TABLE `jvm_prelevement_facture`
  ADD CONSTRAINT `fk_prelevement_facture_fk_prelevement_lignes` FOREIGN KEY (`fk_prelevement_lignes`) REFERENCES `jvm_prelevement_lignes` (`rowid`);

--
-- Constraints for table `jvm_prelevement_lignes`
--
ALTER TABLE `jvm_prelevement_lignes`
  ADD CONSTRAINT `fk_prelevement_lignes_fk_prelevement_bons` FOREIGN KEY (`fk_prelevement_bons`) REFERENCES `jvm_prelevement_bons` (`rowid`);

--
-- Constraints for table `jvm_product`
--
ALTER TABLE `jvm_product`
  ADD CONSTRAINT `fk_product_barcode_type` FOREIGN KEY (`fk_barcode_type`) REFERENCES `jvm_c_barcode_type` (`rowid`),
  ADD CONSTRAINT `fk_product_default_warehouse` FOREIGN KEY (`fk_default_warehouse`) REFERENCES `jvm_entrepot` (`rowid`),
  ADD CONSTRAINT `fk_product_finished` FOREIGN KEY (`finished`) REFERENCES `jvm_c_product_nature` (`code`),
  ADD CONSTRAINT `fk_product_fk_country` FOREIGN KEY (`fk_country`) REFERENCES `jvm_c_country` (`rowid`),
  ADD CONSTRAINT `fk_product_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_product_batch`
--
ALTER TABLE `jvm_product_batch`
  ADD CONSTRAINT `fk_product_batch_fk_product_stock` FOREIGN KEY (`fk_product_stock`) REFERENCES `jvm_product_stock` (`rowid`);

--
-- Constraints for table `jvm_product_customer_price`
--
ALTER TABLE `jvm_product_customer_price`
  ADD CONSTRAINT `fk_product_customer_price_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`),
  ADD CONSTRAINT `fk_product_customer_price_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_product_customer_price_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_product_fournisseur_price`
--
ALTER TABLE `jvm_product_fournisseur_price`
  ADD CONSTRAINT `fk_product_fournisseur_price_barcode_type` FOREIGN KEY (`fk_barcode_type`) REFERENCES `jvm_c_barcode_type` (`rowid`),
  ADD CONSTRAINT `fk_product_fournisseur_price_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`),
  ADD CONSTRAINT `fk_product_fournisseur_price_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_product_lang`
--
ALTER TABLE `jvm_product_lang`
  ADD CONSTRAINT `fk_product_lang_fk_product` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`);

--
-- Constraints for table `jvm_product_price`
--
ALTER TABLE `jvm_product_price`
  ADD CONSTRAINT `fk_product_price_product` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_product_price_user_author` FOREIGN KEY (`fk_product`) REFERENCES `jvm_product` (`rowid`);

--
-- Constraints for table `jvm_product_price_by_qty`
--
ALTER TABLE `jvm_product_price_by_qty`
  ADD CONSTRAINT `fk_product_price_by_qty_fk_product_price` FOREIGN KEY (`fk_product_price`) REFERENCES `jvm_product_price` (`rowid`);

--
-- Constraints for table `jvm_projet`
--
ALTER TABLE `jvm_projet`
  ADD CONSTRAINT `fk_projet_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_projet_task`
--
ALTER TABLE `jvm_projet_task`
  ADD CONSTRAINT `fk_projet_task_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_projet_task_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_projet_task_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_propal`
--
ALTER TABLE `jvm_propal`
  ADD CONSTRAINT `fk_propal_fk_projet` FOREIGN KEY (`fk_projet`) REFERENCES `jvm_projet` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_cloture` FOREIGN KEY (`fk_user_cloture`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_propal_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_propaldet`
--
ALTER TABLE `jvm_propaldet`
  ADD CONSTRAINT `fk_propaldet_fk_propal` FOREIGN KEY (`fk_propal`) REFERENCES `jvm_propal` (`rowid`),
  ADD CONSTRAINT `fk_propaldet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_reception`
--
ALTER TABLE `jvm_reception`
  ADD CONSTRAINT `fk_reception_fk_shipping_method` FOREIGN KEY (`fk_shipping_method`) REFERENCES `jvm_c_shipment_mode` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_user_author` FOREIGN KEY (`fk_user_author`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_reception_fk_user_valid` FOREIGN KEY (`fk_user_valid`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_recruitment_recruitmentcandidature`
--
ALTER TABLE `jvm_recruitment_recruitmentcandidature`
  ADD CONSTRAINT `jvm_recruitment_recruitmentcandidature_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_recruitment_recruitmentjobposition`
--
ALTER TABLE `jvm_recruitment_recruitmentjobposition`
  ADD CONSTRAINT `jvm_recruitment_recruitmentjobposition_fk_establishment` FOREIGN KEY (`fk_establishment`) REFERENCES `jvm_establishment` (`rowid`),
  ADD CONSTRAINT `jvm_recruitment_recruitmentjobposition_fk_user_creat` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `jvm_recruitment_recruitmentjobposition_fk_user_recruiter` FOREIGN KEY (`fk_user_recruiter`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `jvm_recruitment_recruitmentjobposition_fk_user_supervisor` FOREIGN KEY (`fk_user_supervisor`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_resource`
--
ALTER TABLE `jvm_resource`
  ADD CONSTRAINT `fk_resource_fk_country` FOREIGN KEY (`fk_country`) REFERENCES `jvm_c_country` (`rowid`);

--
-- Constraints for table `jvm_societe_account`
--
ALTER TABLE `jvm_societe_account`
  ADD CONSTRAINT `jvm_societe_account_fk_societe` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `jvm_societe_account_fk_website` FOREIGN KEY (`fk_website`) REFERENCES `jvm_website` (`rowid`);

--
-- Constraints for table `jvm_societe_contacts`
--
ALTER TABLE `jvm_societe_contacts`
  ADD CONSTRAINT `fk_societe_contacts_fk_c_type_contact` FOREIGN KEY (`fk_c_type_contact`) REFERENCES `jvm_c_type_contact` (`rowid`),
  ADD CONSTRAINT `fk_societe_contacts_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_societe_contacts_fk_socpeople` FOREIGN KEY (`fk_socpeople`) REFERENCES `jvm_socpeople` (`rowid`);

--
-- Constraints for table `jvm_societe_remise_except`
--
ALTER TABLE `jvm_societe_remise_except`
  ADD CONSTRAINT `fk_soc_remise_fk_facture_line` FOREIGN KEY (`fk_facture_line`) REFERENCES `jvm_facturedet` (`rowid`),
  ADD CONSTRAINT `fk_soc_remise_fk_invoice_supplier_line` FOREIGN KEY (`fk_invoice_supplier_line`) REFERENCES `jvm_facture_fourn_det` (`rowid`),
  ADD CONSTRAINT `fk_soc_remise_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_facture` FOREIGN KEY (`fk_facture`) REFERENCES `jvm_facture` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_facture_source` FOREIGN KEY (`fk_facture_source`) REFERENCES `jvm_facture` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_invoice_supplier` FOREIGN KEY (`fk_invoice_supplier`) REFERENCES `jvm_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_invoice_supplier_source` FOREIGN KEY (`fk_invoice_supplier`) REFERENCES `jvm_facture_fourn` (`rowid`),
  ADD CONSTRAINT `fk_societe_remise_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_societe_rib`
--
ALTER TABLE `jvm_societe_rib`
  ADD CONSTRAINT `jvm_societe_rib_fk_societe` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`);

--
-- Constraints for table `jvm_socpeople`
--
ALTER TABLE `jvm_socpeople`
  ADD CONSTRAINT `fk_socpeople_fk_soc` FOREIGN KEY (`fk_soc`) REFERENCES `jvm_societe` (`rowid`),
  ADD CONSTRAINT `fk_socpeople_user_creat_user_rowid` FOREIGN KEY (`fk_user_creat`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_supplier_proposaldet`
--
ALTER TABLE `jvm_supplier_proposaldet`
  ADD CONSTRAINT `fk_supplier_proposaldet_fk_supplier_proposal` FOREIGN KEY (`fk_supplier_proposal`) REFERENCES `jvm_supplier_proposal` (`rowid`),
  ADD CONSTRAINT `fk_supplier_proposaldet_fk_unit` FOREIGN KEY (`fk_unit`) REFERENCES `jvm_c_units` (`rowid`);

--
-- Constraints for table `jvm_usergroup_rights`
--
ALTER TABLE `jvm_usergroup_rights`
  ADD CONSTRAINT `fk_usergroup_rights_fk_usergroup` FOREIGN KEY (`fk_usergroup`) REFERENCES `jvm_usergroup` (`rowid`);

--
-- Constraints for table `jvm_usergroup_user`
--
ALTER TABLE `jvm_usergroup_user`
  ADD CONSTRAINT `fk_usergroup_user_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`),
  ADD CONSTRAINT `fk_usergroup_user_fk_usergroup` FOREIGN KEY (`fk_usergroup`) REFERENCES `jvm_usergroup` (`rowid`);

--
-- Constraints for table `jvm_user_employment`
--
ALTER TABLE `jvm_user_employment`
  ADD CONSTRAINT `fk_user_employment_fk_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_user_rights`
--
ALTER TABLE `jvm_user_rights`
  ADD CONSTRAINT `fk_user_rights_fk_user_user` FOREIGN KEY (`fk_user`) REFERENCES `jvm_user` (`rowid`);

--
-- Constraints for table `jvm_website_page`
--
ALTER TABLE `jvm_website_page`
  ADD CONSTRAINT `fk_website_page_website` FOREIGN KEY (`fk_website`) REFERENCES `jvm_website` (`rowid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
