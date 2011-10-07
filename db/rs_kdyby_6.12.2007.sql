-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-6
-- http://www.phpmyadmin.net
-- 
-- Počítač: mysql.ic.cz
-- Vygenerováno: Čtvrtek 06. prosince 2007, 17:58
-- Verze MySQL: 4.10.0
-- Verze PHP: 4.4.4-8+etch4
-- 
-- Databáze: `ic_hosiplan`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `block`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `block` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `location` enum('1','2','3','4','5') NOT NULL,
  `width` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `top` varchar(20) NOT NULL,
  `left` varchar(20) NOT NULL,
  `pages` text NOT NULL,
  `style_id` varchar(50) NOT NULL COMMENT 'Refer to actual CSS style',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Vypisuji data pro tabulku `block`
-- 

INSERT INTO `block` (`id`, `name`, `location`, `width`, `height`, `top`, `left`, `pages`, `style_id`) VALUES 
(1, 'Hlavička', '1', '', '', '', '', '', 'top'),
(2, 'Menu', '2', '', '', '', '', '', 'column_1'),
(3, 'Obsah', '2', '', '', '', '', '', 'column_2'),
(4, 'Patička', '3', '', '', '', '', '', 'toe');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `block_contain`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Úterý 04. prosince 2007, 15:34
-- 

CREATE TABLE `block_contain` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `block` int(11) unsigned NOT NULL COMMENT 'Refer to block.id',
  `name` varchar(50) NOT NULL,
  `type` smallint(3) unsigned NOT NULL default '0' COMMENT 'Refer to block_contain_typ.id',
  `data` varchar(100) NOT NULL,
  `priority` smallint(3) unsigned NOT NULL default '1' COMMENT 'Rule for order',
  `pages` text NOT NULL COMMENT 'Requirement for display',
  `style_id` varchar(50) NOT NULL COMMENT 'Refer to actual CSS style',
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Vypisuji data pro tabulku `block_contain`
-- 

INSERT INTO `block_contain` (`id`, `block`, `name`, `type`, `data`, `priority`, `pages`, `style_id`, `desc`) VALUES 
(1, 2, 'Menu', 2, '2 view 1', 1, '', '', ''),
(2, 3, 'Článek - Úvod', 3, '1', 1, 'uvod default', '', ''),
(3, 4, 'Pata', 3, '2', 1, '', '', ''),
(4, 3, 'Článek - Webdesign', 3, '3', 1, 'webdesign', '', ''),
(5, 3, 'Kontakt - HosipLan', 3, '4 <user:HosipLan>', 1, 'kontakt', '', ''),
(6, 3, 'Kontakt - Borci', 3, '5 <user:Borci>', 1, 'kontakt', '', '');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `block_contain_type`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `db_info` (
  `kategory` varchar(50) NOT NULL,
  `header` varchar(50) NOT NULL,
  `data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Vypisuji data pro tabulku `db_info`
-- 

INSERT INTO `db_info` (`kategory`, `header`, `data`) VALUES 
('RS KDYBY', '14.listopadu 2007', ' + Počátek projektu\r\n + Databáze \r\n |    Pár tabulek\r\n + Scripty\r\n |    Základní struktura rozvoržení souborů a složek'),
('RS KDYBY', '15.listopadu 2007', ' + Databáze \r\n |    Pár tabulek\r\n + Scripty\r\n |    Pracoval jsem na základních scriptech pro práci s moduly, styly atd.'),
('RS KDYBY', '27.listopadu 2007', '+ Databáze\r\n |    - Struktura téměř hotová\r\n |    - Dokumentace 100% na současnou databázi'),
('RS KDYBY - Struktura databáze', 'Tabulka: block', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s blokem\r\n +-+ name:\r\n   |    Název pro snažší orientaci\r\n +-+ location: \r\n   |    Umístění bloku\r\n   |    1) Hlavička\r\n   |    2) Sloupec\r\n   |    3) Patička\r\n   |    4) Absolutní prvek \r\n +-+ width:\r\n   |    Šířka bloku  \r\n   |    - "[0-9]+%" = procentuální šířka\r\n   |    - "[0-9]+px" = šířka v pixelech\r\n   |    - "auto" = šířka bude automaticky určena obsahem\r\n +-+ height: \r\n   |    Výška bloku\r\n   |    - "[0-9]+%" = procentuální výška\r\n   |    - "[0-9]+px" = výška v pixelech\r\n   |    - "auto" = výška bude automaticky určena obsahem\r\n +-+ top: \r\n   |    Umístění zleva v pixelech\r\n +-+ left: \r\n   |    Umístění zprava v pixelech\r\n +-+ style_id: \r\n   |    Odkazuje na ID v CSS souboru\r\n   |    Prvku bude ID přiřazeno a tím se i podle ID v CSS nastyluje'),
('RS KDYBY - Struktura databáze', 'Tabulka: block_contain', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s obsahem bloku\r\n +-+ block: \r\n   |    Odkazuje na block.id\r\n +-+ name:\r\n   |    Název pro snažší orientaci\r\n +-+ type: \r\n   |    Odkazuje na block_type.id\r\n   |    ovlivňuje zdroj pro this.link\r\n +-+ data: \r\n   |    Vyhodnotí se podle svého typu\r\n   |    a následně script vrátí objekt s tímto odkazem\r\n +-+ priority: \r\n   |    Atribut podle kterého bude řazen výpis\r\n +-+ pages: \r\n   |    Odkazuje na block_page.id\r\n   |    Podle hodnoty $_GET[''page''] bude vyhodnoceno\r\n   |    zda se stránka zobrazí nebo ne\r\n   |    používá se ve funkci eregi\r\n   |    - pokud obsahuje " ||| " bude rozřezáno na víc pravidel\r\n   |    - pokud začíná na "!" tak se "!" považuje za negaci řetězce\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu'),
('RS KDYBY - Struktura databáze', 'Tabulka: block_contain_type', ' + Struktura:\r\n +-+ id: \r\n   |    Odkazuje na block.id\r\n +-+ name:\r\n   |    Název pro snažší orientaci\r\n +-+ desc:\r\n   |    Popis nebo poznámka k záznamu\r\n + Poznámka: \r\n |    Funkce jsou definovány ve scriptu kvůli jednoduchosti'),
('RS KDYBY - Struktura databáze', 'Tabulka: menu', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s menu\r\n +-+ title:\r\n   |    Název pro snažší orientaci\r\n +-+ style:\r\n   |    Popis nebo poznámka k záznamu\r\n +-+ show_title:\r\n   |    1 - zobrazit this.title\r\n   |    0 - nezobrazit this.title'),
('RS KDYBY - Struktura databáze', 'Tabulka: menu_element', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ menu: \r\n   |    Odkazuje na menu.id\r\n +-+ submenu: \r\n   |    Pokud není nula tak se považuje za odkaz na menu.id\r\n   |    posune se o odsazení položky menu\r\n +-+ title: \r\n   |    Výraz který bude zobrazen jako odkaz\r\n   |    Pokud je this.submenu 0 tak nemá výnam a měl by být nulový\r\n +-+ link: \r\n   |    výraz který bude použit jako odkaz\r\n   |    Pokud je this.submenu 0 tak nemá výnam a měl by být nulový\r\n +-+ desc: \r\n   |    Popis nebo poznámka k odkazu která\r\n   |    bude zobrazena jako atribut title u odkazu'),
('RS KDYBY - Struktura databáze', 'Tabulka: menu_perm', ' + Struktura:\r\n +-+ menu: \r\n   |    Odkazuje na menu.id\r\n +-+ menu_element: \r\n   |    Odkazuje na menu_element.id\r\n +-+ user_group:\r\n   |    Odkazuje na user_groups.id\r\n   |    Pravidlo bude aplikováno na udanou skupinu uživatelů\r\n +-+ term:\r\n   |    Pravidlo se aplikuje pouze pokud je vyjímka splněna\r\n   |    pokud je vyjímka nulová aplikuje se pouze pravidlo\r\n   |    když vyjímka není splněna, tak se menu/položka nezobrazí\r\n +-+ perm:\r\n   |    Pravidlo pro skupinu uživatelů\r\n   |    1 - zobrazit\r\n   |    0 - nezobrazit '),
('RS KDYBY - Struktura databáze', 'Tabulka: modules', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ enabled: \r\n   |    1 - modul je povolený\r\n   |    0 - modul není povolený\r\n +-+ file: \r\n   |    soubor s modulem\r\n +-+ name: \r\n   |    Jméno modulu\r\n +-+ version: \r\n   |    Verze modulu\r\n +-+ type: \r\n   |    Typ modulu \r\n   |    - work = odbsahuje metodu work který vykoná nějakou práci\r\n   |    - admin = obsahuje metodu admin která bude využita při \r\n   |              spravování modulu přes administraci\r\n   |    - view = obsahuje metodu view která bude využita pří\r\n   |             zobrazení modulu na stránce\r\n +-+ writer: \r\n   |    Obsahuje jmémo autora\r\n +-+ encoding: \r\n   |    Určuje v jakém kódování je napsán modul\r\n   |    Pokud se neshoduje kódování souboru s kódováním stránek\r\n   |    bude modul přeformátován do kódování stránek\r\n +-+ published: \r\n   |    Datum vydání autorem\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu'),
('RS KDYBY - Struktura databáze', 'Tabulka: page_meta', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ meta_type: \r\n   |    Konkrétní metaTAG\r\n +-+ data: \r\n   |    Data která bude obsahovat\r\n +-+ meta: \r\n   |    Šablona metaTAGu; může obsahovat:\r\n   |    - @data = za tuto proměnnou bude dosazen údaj z this.data\r\n   |    - @meta = za tuto proměnnou bude dosazen údaj z this.meta_type\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu'),
('RS KDYBY - Struktura databáze', 'Tabulka: styles', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ enabled: \r\n   |    1 - styl je povolený\r\n   |    0 - styl není povolený\r\n +-+ folder: \r\n   |    složka se stylem\r\n +-+ name: \r\n   |    Jméno stylu\r\n +-+ version: \r\n   |    Verze stylu\r\n +-+ writer: \r\n   |    Obsahuje jmémo autora\r\n +-+ encoding: \r\n   |    Určuje v jakém kódování je napsán modul\r\n   |    Pokud se neshoduje kódování stylu s kódováním stránek\r\n   |    bude styl přeformátován do kódování stránek\r\n +-+ published: \r\n   |    Datum vydání autorem\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu'),
('RS KDYBY - Struktura databáze', 'Tabulka: user', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ username: \r\n   |    Nick uživatele\r\n +-+ pass: \r\n   |    Heslo uživatele\r\n +-+ email: \r\n   |    E-mail uživatele\r\n +-+ icq: \r\n   |    ICQ uživatele\r\n +-+ jabber: \r\n   |    Jabber JID uživatele\r\n +-+ mns: \r\n   |    MSN uživatele\r\n +-+ yahoo: \r\n   |    Yahoo uživatele\r\n +-+ reg_date: \r\n   |    Datum registrace uživatele\r\n +-+ active: \r\n   |    1 - účet je aktivní\r\n   |    0 - účet není aktivní\r\n   |    ALTER TABLE `user` CHANGE `active` `active` ENUM( ''0'', ''1'' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''0''\r\n   |    atributem default lze nastavit jestli se uživatelé aktivují při registraci nebo nebo až po aktivaci účtu\r\n +-+ active_code: \r\n   |    Kód pro aktivaci uživatele\r\n +-+ last_visit: \r\n   |    Poslední návštěva v UNIXtime\r\n +-+ last_ip: \r\n   |    IP adresa ze které uživatel navštívil stránky naposledy\r\n +-+ name: \r\n   |    Skutečné jméno uživatele\r\n +-+ surname: \r\n   |    Skutečné příjmení uživatele \r\n +-+ last_page: \r\n   |    Stránka ze které odešel při poslední návštěvě\r\n +-+ lang: \r\n   |    Jazykové nastavení uživatele\r\n +-+ style: \r\n   |    Pokud to web dovoluje obsahuje toto pole odkaz na jím nastavený styl\r\n +-+ pass_chng: \r\n   |    Kolikrát si změnil heslo\r\n +-+ pass_new: \r\n   |    Nové heslo které ale musí být nejdříve aktivováno\r\n +-+ pass_active: \r\n   |    Kód pro aktivaci nového hesla\r\n +-+ online: \r\n   |    1 - uživatel je online\r\n   |    0 - uživatel je offline\r\n +-+ phpsession: \r\n   |    Uživatelův aktuální klíč pro navázání na status "přihlášený"'),
('RS KDYBY - Struktura databáze', 'Tabulka: user_groups', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ name: \r\n   |    Jméno Skupiny\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu'),
('RS KDYBY - Struktura databáze', 'Tabulka: user_groups_mbr', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ user: \r\n   |    ID uživatele\r\n +-+ group: \r\n   |    ID skupiny\r\n +-+ desc: \r\n   |    Popis nebo poznámka k záznamu\r\n + Poznámka: \r\n |    Vyplněním this.user a this.group se uživatel sváže se skupinou\r\n |    ale neznamená to že nemůže být ve více skupinách zároveň'),
('RS KDYBY - Struktura databáze', 'Tabulka: user_groups_perm', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro práci s položkou\r\n +-+ group: \r\n   |    Odkazuje na user_groups.id\r\n +-+ block: \r\n   |    Odkazuje na block.id\r\n +-+ block_contain: \r\n   |    Odkazuje na block_contain.id\r\n +-+ permision: \r\n   |    Pravidlo pro skupinu\r\n + Poznámka: \r\n |    Pokud jsou this.block a this.block_contain 0 potom\r\n |    se pravidlo aplikuje na všechny případy které nejsou definovány '),
('RS KDYBY - Struktura databáze', 'Tabulka: db_info', ' + Struktura:\r\n +-+ kategory: \r\n   |    Kategorie, podle které se seřadí data\r\n +-+ header: \r\n   |    Podnadpis, nebo taky podkategorie\r\n +-+ data: \r\n   |    Obsahuje informace s dokumentací'),
('RS KDYBY - Struktura databáze', 'Tabulka: page_css', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro usnadnění práce\r\n +-+ style: \r\n   |    Odkazuje na styles.id\r\n +-+ for_page: \r\n   |    Obsahuje pravidla pro zobrazení na jednotlivých stránkách\r\n +-+ use_style: \r\n   |    Odsahuje název souboru, který se použije jako styl pro stránku'),
('RS KDYBY - Struktura databáze', 'Tabulka: page_text', ' + Struktura:\r\n +-+ id: \r\n   |    Konkrétní ID pro usnadnění práce \r\n +-+ name: \r\n   |    Jméno textu\r\n +-+ writer: \r\n   |    Autor textu\r\n +-+ date: \r\n   |    Datum vložení\r\n +-+ num_read: \r\n   |    Počet přečtení textu\r\n +-+ text: \r\n   |    Konkrétní text, který se vypíše');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `mod_blog_articles`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:44
-- Poslední změna: Pondělí 03. prosince 2007, 18:44
-- 

CREATE TABLE `mod_blog_articles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `article` longtext NOT NULL,
  `article_fp` text NOT NULL,
  `autor` int(11) unsigned NOT NULL,
  `added` bigint(20) unsigned NOT NULL,
  `num_read` bigint(20) unsigned NOT NULL,
  `category` int(11) unsigned NOT NULL,
  `confirmed` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `mod_blog_articles`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `mod_blog_groups`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `mod_blog_groups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `subcategory_of` int(11) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Vypisuji data pro tabulku `mod_blog_groups`
-- 

INSERT INTO `mod_blog_groups` (`id`, `subcategory_of`, `name`, `desc`) VALUES 
(1, 0, 'Programování', 'Tuny článků o programování podle vlastních zkušeností'),
(2, 1, 'PHP, HTML, CSS', 'Pokud máte zájem se něco dozvědět o webových technologiích směle pokračujte!'),
(3, 1, 'Python', 'Velice zajímavý programovací jazyk pro Linux'),
(4, 0, 'Hry', 'Co jsem hrál, co hraji a co budu hrát? '),
(5, 4, 'World of Warcraft', 'Nejdokonalejší, nejúžasnější a nejlepší hra jaká kdy spatřila světlo světa!!'),
(6, 1, 'Databáse', 'Bez nich se dnes už prakticky nejde obejít');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `mod_menu`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `mod_menu` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `style` enum('vertical','horizontal') NOT NULL,
  `show_title` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Vypisuji data pro tabulku `mod_menu`
-- 

INSERT INTO `mod_menu` (`id`, `title`, `style`, `show_title`) VALUES 
(1, 'Navigace', 'vertical', '1'),
(2, 'Kontakt', 'vertical', '1');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `mod_menu_element`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `mod_menu_element` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `menu` int(11) unsigned NOT NULL COMMENT 'Refer to menu.id',
  `submenu` int(11) unsigned NOT NULL default '0',
  `priority` smallint(3) unsigned NOT NULL default '1' COMMENT 'Rule for order',
  `title` varchar(50) default NULL,
  `link` varchar(50) default NULL,
  `desc` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Vypisuji data pro tabulku `mod_menu_element`
-- 

INSERT INTO `mod_menu_element` (`id`, `menu`, `submenu`, `priority`, `title`, `link`, `desc`) VALUES 
(1, 1, 0, 1, 'Úvod', '?page=uvod', NULL),
(2, 1, 0, 2, 'Blog', '?page=blog', NULL),
(3, 1, 0, 3, 'Webdesign', '?page=webdesign', NULL),
(4, 1, 2, 4, NULL, NULL, NULL),
(5, 2, 0, 1, 'HosipLan', '?page=kontakt&amp;user=HosipLan', NULL),
(6, 2, 0, 2, 'Borci', '?page=kontakt&amp;user=Borci', NULL);

-- --------------------------------------------------------

-- 
-- Struktura tabulky `mod_menu_perm`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `mod_menu_perm` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `menu` int(11) unsigned NOT NULL default '0' COMMENT 'Refer to menu.perm',
  `menu_element` int(11) unsigned NOT NULL default '0' COMMENT 'Refer to menu_element.id',
  `user_group` int(11) unsigned NOT NULL COMMENT 'Refer to user_groups.id',
  `term` varchar(50) NOT NULL default '0',
  `perm` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `mod_menu_perm`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `modules`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Vypisuji data pro tabulku `modules`
-- 

INSERT INTO `modules` (`id`, `enabled`, `file`, `name`, `version`, `type`, `writer`, `encoding`, `published`, `desc`) VALUES 
(1, '1', 'sample.php', 'Sample', '0.9a', 'work + view', 'HosipLan', 'utf-8', '16.11.2007', 'Testovací modul do KDYBY'),
(2, '0', 'base_menu.php', 'Base Menu\r', '0.9a\r', 'view + admin\r', 'HosipLan\r', 'utf-8\r', '30.11.2007\r', 'Tento modul generuje jednoduché menu');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `page_css`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
-- 

CREATE TABLE `page_css` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `style` int(11) unsigned NOT NULL,
  `for_page` varchar(50) NOT NULL,
  `use_style` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Vypisuji data pro tabulku `page_css`
-- 

INSERT INTO `page_css` (`id`, `style`, `for_page`, `use_style`) VALUES 
(1, 1, 'documentation', 'documentation'),
(2, 1, 'default', 'base_css');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `page_meta`
-- 
-- Vytvoření: Středa 05. prosince 2007, 15:45
-- Poslední změna: Středa 05. prosince 2007, 15:45
-- 

CREATE TABLE `page_meta` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `for_page` text NOT NULL,
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
(1, '', 'title', 'HosipLan', '<title>@data</title>', 'Nadpisek stránky'),
(2, '<file:documentation>', 'stylesheet', './css.php?style=documentation', '<link rel="stylesheet" href="@data" type="text/css">', 'Tag který slouží k připojení tabulek stylů ke stránce.'),
(3, '', 'javascript', '', '<script src="@data" type="text/javascript"></script>', ''),
(4, '', 'content-type', 'utf-8', '<meta http-equiv="@meta" content="text/html; charset=@data">', 'Kódování stránky'),
(5, '', 'author', 'HosipLan; e-mail: HosipLan@seznam.cz', '<meta name="@meta" content="@data">', 'Autor stránek'),
(6, '', 'imagetoolbar', 'no', '<meta http-equiv="@meta" content="@data">', 'Zobrazování panelu nástrojů u obrázku v IE'),
(7, '', 'generator', 'PSPad editor, www.pspad.com', '<meta name="@meta" content="@data">', 'Program, přes který byly vytvořeny stránky'),
(8, '', 'robots', 'all', '<meta name="@meta" content="@data">', 'Instrukce pro vyhledávací roboty'),
(9, '', 'pragma', '', '<meta http-equiv="@meta" content="@data">', ''),
(10, '', 'cache-control', '', '<meta http-equiv="@meta" content="@data">', ''),
(11, '', 'expires', '', '<meta http-equiv="@meta" content="@data">', ''),
(12, '', 'last-modified', '', '<meta http-equiv="@meta" content="@data">', ''),
(13, '<file:!documentation>', 'stylesheet', './css.php', '<link rel="stylesheet" href="@data" type="text/css">', 'Tag který slouží k připojení tabulek stylů ke stránce.');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `page_text`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Středa 05. prosince 2007, 19:22
-- 

CREATE TABLE `page_text` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `writer` varchar(50) NOT NULL,
  `date` bigint(20) unsigned NOT NULL default '0',
  `num_read` bigint(20) unsigned NOT NULL default '0',
  `text` longtext NOT NULL,
  `pages` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Vypisuji data pro tabulku `page_text`
-- 

INSERT INTO `page_text` (`id`, `name`, `writer`, `date`, `num_read`, `text`, `pages`) VALUES 
(1, 'Úvod', 'HosipLan', 0, 88, 'text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ', ''),
(2, '', 'HosipLan', 0, 226, '[&nbsp;HosipLan&nbsp;&copy;&nbsp;2006-<?date(Y)?>&nbsp;] [&nbsp;KdybyRS&nbsp;&copy;&nbsp;2007&nbsp;] [&nbsp;<a href="http://hbstudio.ic.cz">HB&nbsp;Studio&nbsp;Design</a>&nbsp;&copy;&nbsp;2006-<?date(Y)?>&nbsp;]', ''),
(3, 'Webdesign', 'HosipLan', 0, 14, 'text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ', ''),
(4, 'Kontakt - HosipLan', 'HosipLan', 0, 35, 'text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ', '<user:HosipLan>'),
(5, 'Kontakt - Borci', 'HosipLan', 0, 36, 'text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text \r\n\r\ntext text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ', '<user:Borci>');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `styles`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 21:02
-- Poslední změna: Pondělí 03. prosince 2007, 21:03
-- 

CREATE TABLE `styles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `enabled` smallint(3) NOT NULL default '0',
  `default` smallint(3) NOT NULL default '0',
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
(1, 1, 1, 'hosiplan', 'HosipLan', '1.0a', 'HosipLan', 'utf-8', '25.11.2007', 'Základní styl mého Blogu');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `styles_templates`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 19:51
-- Poslední změna: Pondělí 03. prosince 2007, 21:35
-- 

CREATE TABLE `styles_templates` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `style` int(11) unsigned NOT NULL,
  `pages` text NOT NULL,
  `file` varchar(50) NOT NULL,
  `priority` smallint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Vypisuji data pro tabulku `styles_templates`
-- 

INSERT INTO `styles_templates` (`id`, `style`, `pages`, `file`, `priority`) VALUES 
(1, 1, '', 'page_top.html', 1),
(2, 1, '', 'page_bottom.html', 999),
(3, 1, '', 'page_body.html', 2);

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
  `active_code` varchar(32) NOT NULL,
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

INSERT INTO `user` (`id`, `username`, `pass`, `email`, `icq`, `jabber`, `mns`, `yahoo`, `reg_date`, `active`, `active_code`, `last_visit`, `last_ip`, `name`, `surname`, `last_page`, `lang`, `style`, `pass_chng`, `pass_new`, `pass_active`, `online`, `phpsession`) VALUES 
(1, 'admin', '', '', '', '', '', '', 0, '1', '', 0, '1.1.1.1', '', '', '', '', 0, 0, '', '', '0', '');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `user_groups`
-- 
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
-- Vytvoření: Pondělí 03. prosince 2007, 18:19
-- Poslední změna: Pondělí 03. prosince 2007, 18:19
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
