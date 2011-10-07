-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Počítač: localhost
-- Vygenerováno: Neděle 25. listopadu 2007, 17:35
-- Verze MySQL: 5.0.27
-- Verze PHP: 5.2.0
-- 
-- Databáze: `rs_kdyby`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `menu`
-- 
-- Vytvoření: Sobota 17. listopadu 2007, 12:03
-- Poslední změna: Sobota 17. listopadu 2007, 12:03
-- 

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `style` enum('vertical','horizontal') NOT NULL,
  `perm` int(11) unsigned NOT NULL COMMENT 'Refer to menu_perm.id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Struktura tabulky `menu_perm`
-- 
-- Vytvoření: Sobota 17. listopadu 2007, 12:02
-- Poslední změna: Sobota 17. listopadu 2007, 12:02
-- 

CREATE TABLE `menu_perm` (
  `id` int(11) unsigned NOT NULL COMMENT 'Refer to menu.perm',
  `user_group` int(11) unsigned NOT NULL COMMENT 'Refer to user_groups.id',
  `perm` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Struktura tabulky `modules`
-- 
-- Vytvoření: Neděle 25. listopadu 2007, 15:28
-- Poslední změna: Neděle 25. listopadu 2007, 15:28
-- 

CREATE TABLE `modules` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `enabled` enum('0','1') NOT NULL default '0',
  `file` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL default 'Module Extension',
  `version` varchar(255) NOT NULL default '1.0a',
  `type` varchar(255) NOT NULL default 'work',
  `writer` varchar(255) NOT NULL default 'HosipLan',
  `encoding` varchar(255) NOT NULL default 'utf-8',
  `published` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `file` (`file`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `modules`
-- 

INSERT INTO `modules` (`id`, `enabled`, `file`, `name`, `version`, `type`, `writer`, `encoding`, `published`, `desc`) VALUES 
(1, '1', 'sample.php', 'Sample', '0.9a', 'work + view', 'HosipLan', 'utf-8', '16.11.2007', 'Testovací modul do KDYBY');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `page_meta`
-- 
-- Vytvoření: Neděle 25. listopadu 2007, 17:32
-- Poslední změna: Neděle 25. listopadu 2007, 17:34
-- 

CREATE TABLE `page_meta` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `meta_type` varchar(25) NOT NULL,
  `data` varchar(255) NOT NULL,
  `meta` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Vypisuji data pro tabulku `page_meta`
-- 

INSERT INTO `page_meta` (`id`, `meta_type`, `data`, `meta`, `desc`) VALUES 
(1, 'title', 'HosipLan', '<title>$data</title>\\n', 'Nadpisek stránky'),
(2, 'stylesheet', '', '<link rel="stylesheet" href="$data" type="text/css">\\n', ''),
(3, 'javascript', '', '<script src="$data" type="text/javascript"></script>\\n', ''),
(4, 'content-type', 'utf-8', '<meta http-equiv="$meta" content="text/html; charset=$data">\\n', 'Kódování stránky'),
(5, 'author', 'HosipLan; e-mail: HosipLan@seznam.cz', '<meta name="$meta" content="$data">\\n', 'Autor stránek'),
(6, 'imagetoolbar', 'no', '<meta http-equiv="$meta" content="$data">\\n', 'Zobrazování panelu nástrojů u obrázku v IE'),
(7, 'generator', 'PSPad editor, www.pspad.com', '<meta name="$meta" content="$data">\\n', 'Program, přes který byly vytvořeny stránky'),
(8, 'robots', 'all', '<meta name="$meta" content="$data">\\n', 'Instrukce pro vyhledávací roboty'),
(9, 'pragma', '', '<meta http-equiv="$meta" content="$data">\\n', ''),
(10, 'cache-control', '', '<meta http-equiv="$meta" content="$data">\\n', ''),
(11, 'expires', '', '<meta http-equiv="$meta" content="$data">\\n', ''),
(12, 'last-modified', '', '<meta http-equiv="$meta" content="$data">\\n', '');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `styles`
-- 
-- Vytvoření: Neděle 25. listopadu 2007, 15:28
-- Poslední změna: Neděle 25. listopadu 2007, 15:28
-- 

CREATE TABLE `styles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `enabled` enum('0','1') NOT NULL default '0',
  `folder` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL default 'Page Style',
  `version` varchar(255) NOT NULL default '1.0a',
  `writer` varchar(255) NOT NULL default 'HosipLan',
  `encoding` varchar(255) NOT NULL default 'utf-8',
  `published` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `folder` (`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `styles`
-- 

INSERT INTO `styles` (`id`, `enabled`, `folder`, `name`, `version`, `writer`, `encoding`, `published`, `desc`) VALUES 
(1, '1', 'hosiplan', 'HosipLan', '1.0a', 'HosipLan', 'utf-8', '25.11.2007', 'Základní styl mého Blogu');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user`
-- 
-- Vytvoření: Sobota 17. listopadu 2007, 01:07
-- Poslední změna: Neděle 25. listopadu 2007, 14:49
-- 

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `icq` varchar(11) NOT NULL,
  `jabber` varchar(255) NOT NULL,
  `mns` varchar(255) NOT NULL,
  `yahoo` varchar(255) NOT NULL,
  `reg_date` bigint(20) unsigned NOT NULL,
  `active` enum('0','1') NOT NULL default '1',
  `last_visit` bigint(20) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `last_page` text NOT NULL,
  `lang` varchar(100) NOT NULL,
  `pass_chng` int(11) unsigned NOT NULL,
  `pass_new` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `user`
-- 

INSERT INTO `user` (`id`, `username`, `pass`, `email`, `icq`, `jabber`, `mns`, `yahoo`, `reg_date`, `active`, `last_visit`, `name`, `surname`, `last_page`, `lang`, `pass_chng`, `pass_new`) VALUES 
(0, 'admin', '', '', '', '', '', '', 0, '1', 0, '', '', '', '', 0, '');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user_groups`
-- 
-- Vytvoření: Sobota 17. listopadu 2007, 11:39
-- Poslední změna: Sobota 17. listopadu 2007, 11:43
-- 

CREATE TABLE `user_groups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Vypisuji data pro tabulku `user_groups`
-- 

INSERT INTO `user_groups` (`id`, `name`, `desc`) VALUES 
(1, 'Admin', 'Skupina s maximálním oprávněním'),
(2, 'Redaktor', 'Skupina uživatelů s oprávněním pouze pro práci s články'),
(3, 'Uživatel', 'Registrovaní užitelé, mohou pouze prohlížet web a případně komentovat');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user_groups_mbr`
-- 
-- Vytvoření: Sobota 17. listopadu 2007, 12:07
-- Poslední změna: Neděle 25. listopadu 2007, 15:00
-- 

CREATE TABLE `user_groups_mbr` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user` int(11) unsigned NOT NULL COMMENT 'Refer to user.id',
  `group` int(11) unsigned NOT NULL COMMENT 'Refer to user_groups.id',
  `desc` varchar(255) NOT NULL COMMENT 'Comment',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `user_groups_mbr`
-- 

INSERT INTO `user_groups_mbr` (`id`, `user`, `group`, `desc`) VALUES 
(1, 1, 1, 'Uživatel s globálním oprávněním');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user_groups_perm`
-- 
-- Vytvoření: Neděle 25. listopadu 2007, 15:03
-- Poslední změna: Neděle 25. listopadu 2007, 15:03
-- 

CREATE TABLE `user_groups_perm` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `perm_type` varchar(100) NOT NULL default 'module' COMMENT 'Module or something else',
  `perm_data` varchar(255) NOT NULL COMMENT 'Additional data',
  `permission` smallint(3) unsigned NOT NULL COMMENT 'Rule',
  `group` int(11) NOT NULL COMMENT 'Refer to user_groups.id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `user_groups_perm`
-- 

INSERT INTO `user_groups_perm` (`id`, `perm_type`, `perm_data`, `permission`, `group`) VALUES 
(1, 'all', '', 1, 1);
