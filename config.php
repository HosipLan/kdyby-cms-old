<?php

  /* =======================================
   * config.sample.php se používá tak, 
   * že ho zkopírujete, přejmenujete na config.php
   * a do tohoto souboru nastavíte potřebné údaje      
  ======================================= */

$Config = array(

  /* ======= Databáze ======= */
    'Database' => array(        # Připojení k databázi
      'Host' => 'mysql.ic.cz',    # Adresa databáze
      'User' => 'ic_hosiplan',    # Uživatel k databázi
      'Password' => '',    # Heslo k databázi
      'DB' => 'ic_hosiplan'        # databáze
    ),
    'Table_' => '',          # Předpona u tabulek
  
  /* ======= Styly ======= */
    'Style' => 'hosiplan',      # Základní Styl
  
  /* ======= Jazyky ======= */
    'language' => 'cz',         # Základní jazyk
  
  /* ======= Jazyky ======= */
    'encoding' => 'utf-8',         # Kódování stránek
    'DB_encoding' => 'utf8',         # Kódování databáze
  
  /* ======= Slozky ======= */
    'Base_Dir' => './',         # Základní adresář
    'Admin_Dir' => 'admin',         # Adresář s administrací
    'Instal_Dir' => 'instal',         # Adresář s instalací
    'Error_Dir' => 'error',         # Adresář s chybami
    'Styles_Dir' => 'styles',       # Adresář se styly
    'Modules_Dir' => 'modules',      # Adresář s moduly
    'Download_Dir' => '',     # Adresář pro soubory ke stažení
    'Upload_Dir' => '',       # Adresář pro soubory k uploadu
    'Cache_Dir' => 'cache',       # Adresář pro dočasné nebo generované soubory
  
  );
  
  //error_reporting(0);
  //define("KDYBY_INSTALED", true);
  $KDYBY_DEBUG = true;

?>