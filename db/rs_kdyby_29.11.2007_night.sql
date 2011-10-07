-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Počítač: localhost
-- Vygenerováno: Čtvrtek 29. listopadu 2007, 22:12
-- Verze MySQL: 5.0.27
-- Verze PHP: 5.2.0
-- 
-- Databáze: `kdyby_rs`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `block`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `block` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `location` enum('1','2','3','4') NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `top` bigint(20) NOT NULL,
  `left` bigint(20) NOT NULL,
  `style_id` varchar(50) NOT NULL COMMENT 'Refer to actual CSS style',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `block`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `block_contain`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `block_contain` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `block` int(11) unsigned NOT NULL COMMENT 'Refer to block.id',
  `name` varchar(50) NOT NULL,
  `type` smallint(3) unsigned NOT NULL default '0' COMMENT 'Refer to block_contain_typ.id',
  `link` varchar(50) NOT NULL,
  `priority` smallint(3) unsigned NOT NULL default '1' COMMENT 'Rule for order',
  `pages` text NOT NULL COMMENT 'Requirement for display',
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `block_contain`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `block_contain_type`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `block_contain_type` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT 'Refer from block_contain.type',
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Vypisuji data pro tabulku `block_contain_type`
-- 

INSERT INTO `block_contain_type` (`id`, `name`, `desc`) VALUES 
(2, 'module', 'ID modulu (modul musí být registrován v databázi systému'),
(1, 'file', 'Odkazuje na nějaký soubor i s cestou k němu'),
(3, 'block_text', 'ID textu, který se zobrazí v bloku'),
(4, 'image', 'Odkaz na nějaký obrázek i s cestou k němu'),
(5, 'file', 'Odkaz na nějaký soubor i s cestou. Pravidlo je že na stránce kde se zobrazí soubor ke stažení by nemělo být už nice jiného');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `db_info`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `db_info` (
  `kategory` varchar(50) NOT NULL,
  `header` varchar(50) NOT NULL,
  `data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `db_info`
-- 

INSERT INTO `db_info` (`kategory`, `header`, `data`) VALUES 
('PROJEKT - RS KDYBY', '14.listopadu 2007', '+ Počátek projektu\r\n + Databáze \r\n |    Pár tabulek\r\n + Scripty\r\n |    Základní struktura rozvoržení souborů a složek'),
('PROJEKT - RS KDYBY', '15.listopadu 2007', ' + Databáze \r\n |    Pár tabulek\r\n + Scripty\r\n |    Pracoval jsem na základních scriptech pro práci s moduly, styly atd.'),
('PROJEKT - RS KDYBY', '27.listopadu 2007', '+ Databáze\r\n |    - Struktura téměř hotová\r\n |    - Dokumentace 100% na současnou databázi'),
('PROJEKT - RS KDYBY - Struktura databáze', 'Tabulka: block', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s blokem\r\n +-+ name:\r\n   |    Název pro snažší orientaci\r\n +-+ location: \r\n   |    Umístění bloku\r\n   |    1) Hlavička\r\n   |    2) Sloupec\r\n   |    3) Patička\r\n   |    4) Absolutní prvek \r\n +-+ width:\r\n   |    Šířka bloku  \r\n   |    - "[0-9]+%" = procentuální šířka\r\n   |    - "[0-9]+px" = šířka v pixelech\r\n   |    - "auto" = šířka bude automaticky určena obsahem\r\n +-+ height: \r\n   |    Výška bloku\r\n   |    - "[0-9]+%" = procentuální výška\r\n   |    - "[0-9]+px" = výška v pixelech\r\n   |    - "auto" = výška bude automaticky určena obsahem\r\n +-+ top: \r\n   |    Umístění zleva v pixelech\r\n +-+ left: \r\n   |    Umístění zprava v pixelech\r\n +-+ style_id: \r\n   |    Odkazuje na ID v CSS souboru\r\n   |    Prvku bude ID přiřazeno a tím se i podle ID v CSS nastyluje'),
('PROJEKT - RS KDYBY - Struktura databáze', 'Tabulka: block_contain', '+ Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s obsahem bloku\r\n +-+ block: \r\n   |    Odkazuje na block.id\r\n +-+ name:\r\n   |    Název pro snažší orientaci\r\n +-+ type: \r\n   |    Odkazuje na block_type.id\r\n   |    ovlivňuje zdroj pro this.link\r\n +-+ link: \r\n   |    Vyhodnotí se podle svého typu\r\n   |    a následně script vrátí objekt s tímto odkazem\r\n +-+ priority: \r\n   |    Atribut podle kterého bude řazen výpis\r\n +-+ pages: \r\n   |    Odkazuje na block_page.id\r\n   |    Podle hodnoty $_GET[''page''] bude vyhodnoceno\r\n   |    zda se stránka zobrazí nebo ne\r\n   |    používá se ve funkci eregi\r\n   |    - pokud obsahuje " ||| " bude rozřezáno na víc pravidel\r\n   |    - pokud začíná na "!" tak se "!" považuje za negaci řetězce\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `menu`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `style` enum('vertical','horizontal') NOT NULL,
  `show_title` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `menu`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `menu_element`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `menu_element` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `menu` int(11) unsigned NOT NULL COMMENT 'Refer to menu.id',
  `submenu` int(11) unsigned NOT NULL default '0',
  `title` varchar(50) default NULL,
  `link` varchar(50) default NULL,
  `desc` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `menu_element`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `menu_perm`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `menu_perm` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `menu` int(11) unsigned NOT NULL default '0' COMMENT 'Refer to menu.perm',
  `menu_element` int(11) unsigned NOT NULL default '0' COMMENT 'Refer to menu_element.id',
  `user_group` int(11) unsigned NOT NULL COMMENT 'Refer to user_groups.id',
  `term` varchar(50) NOT NULL default '0',
  `perm` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `menu_perm`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `modules`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
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
-- Struktura tabulky `page_css`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:43
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:49
-- 

CREATE TABLE `page_css` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `style` int(11) unsigned NOT NULL,
  `for_page` varchar(50) NOT NULL,
  `use_style` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `page_css`
-- 

INSERT INTO `page_css` (`id`, `style`, `for_page`, `use_style`) VALUES 
(1, 1, 'documentation', 'documentation');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `page_meta`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:44
-- Poslední změna: Čtvrtek 29. listopadu 2007, 21:27
-- 

CREATE TABLE `page_meta` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `for_page` varchar(50) NOT NULL,
  `meta_type` varchar(25) NOT NULL,
  `data` varchar(255) NOT NULL,
  `meta` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- 
-- Vypisuji data pro tabulku `page_meta`
-- 

INSERT INTO `page_meta` (`id`, `for_page`, `meta_type`, `data`, `meta`, `desc`) VALUES 
(1, '0', 'title', 'HosipLan', '<title>@data</title>', 'Nadpisek stránky'),
(2, 'documentation', 'stylesheet', './css.php?style=documentation', '<link rel="stylesheet" href="@data" type="text/css">', 'Tag který slouží k připojení tabulek stylů ke stránce.'),
(3, '0', 'javascript', '', '<script src="@data" type="text/javascript"></script>', ''),
(4, '0', 'content-type', 'utf-8', '<meta http-equiv="@meta" content="text/html; charset=@data">', 'Kódování stránky'),
(5, '0', 'author', 'HosipLan; e-mail: HosipLan@seznam.cz', '<meta name="@meta" content="@data">', 'Autor stránek'),
(6, '0', 'imagetoolbar', 'no', '<meta http-equiv="@meta" content="@data">', 'Zobrazování panelu nástrojů u obrázku v IE'),
(7, '0', 'generator', 'PSPad editor, www.pspad.com', '<meta name="@meta" content="@data">', 'Program, přes který byly vytvořeny stránky'),
(8, '0', 'robots', 'all', '<meta name="@meta" content="@data">', 'Instrukce pro vyhledávací roboty'),
(9, '0', 'pragma', '', '<meta http-equiv="@meta" content="@data">', ''),
(10, '0', 'cache-control', '', '<meta http-equiv="@meta" content="@data">', ''),
(11, '0', 'expires', '', '<meta http-equiv="@meta" content="@data">', ''),
(12, '0', 'last-modified', '', '<meta http-equiv="@meta" content="@data">', ''),
(13, '!documentation', 'stylesheet', './css.php?style=all', '<link rel="stylesheet" href="@data" type="text/css">', 'Tag který slouží k připojení tabulek stylů ke stránce.');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `styles`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 21:41
-- Poslední změna: Čtvrtek 29. listopadu 2007, 21:49
-- 

CREATE TABLE `styles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `enabled` enum('0','1') NOT NULL default '0',
  `default` enum('0','1') NOT NULL,
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

INSERT INTO `styles` (`id`, `enabled`, `default`, `folder`, `name`, `version`, `writer`, `encoding`, `published`, `desc`) VALUES 
(1, '1', '1', 'hosiplan', 'HosipLan', '1.0a', 'HosipLan', 'utf-8', '25.11.2007', 'Základní styl mého Blogu');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 21:12
-- Poslední změna: Čtvrtek 29. listopadu 2007, 21:12
-- 

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `icq` varchar(11) NOT NULL,
  `jabber` varchar(255) NOT NULL,
  `mns` varchar(255) NOT NULL,
  `yahoo` varchar(255) NOT NULL,
  `reg_date` bigint(20) unsigned NOT NULL,
  `active` enum('0','1') NOT NULL default '0',
  `last_visit` bigint(20) unsigned NOT NULL,
  `last_ip` varchar(15) NOT NULL default '1.1.1.1',
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `last_page` text NOT NULL,
  `lang` varchar(100) NOT NULL,
  `style` int(11) unsigned NOT NULL,
  `pass_chng` int(11) unsigned NOT NULL,
  `pass_new` varchar(32) NOT NULL,
  `pass_active` varchar(32) NOT NULL,
  `online` enum('0','1') NOT NULL default '0',
  `phpsession` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `user`
-- 

INSERT INTO `user` (`id`, `username`, `pass`, `email`, `icq`, `jabber`, `mns`, `yahoo`, `reg_date`, `active`, `last_visit`, `last_ip`, `name`, `surname`, `last_page`, `lang`, `style`, `pass_chng`, `pass_new`, `pass_active`, `online`, `phpsession`) VALUES 
(1, 'admin', '', '', '', '', '', '', 0, '1', 0, '1.1.1.1', '', '', '', '', 0, 0, '', '', '0', '');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user_groups`
-- 
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
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
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
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
-- Vytvoření: Čtvrtek 29. listopadu 2007, 20:20
-- Poslední změna: Čtvrtek 29. listopadu 2007, 20:20
-- 

CREATE TABLE `user_groups_perm` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `block` int(11) unsigned NOT NULL COMMENT 'Refer to block.id',
  `block_contain` int(11) unsigned NOT NULL COMMENT 'Refer to block_contain.id',
  `permission` smallint(3) unsigned NOT NULL COMMENT 'Rule',
  `group` int(11) NOT NULL COMMENT 'Refer to user_groups.id',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Vypisuji data pro tabulku `user_groups_perm`
-- 

INSERT INTO `user_groups_perm` (`id`, `block`, `block_contain`, `permission`, `group`) VALUES 
(1, 0, 0, 1, 1);
