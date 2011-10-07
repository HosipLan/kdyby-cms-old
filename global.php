<?php

  if( !defined("IN_KDYBY") ){ exit; }

/* =========== Jádro =========== */
  require_once "./config.php"; 
  require_once "./language/".$Config['language'].".php"; 

  $Files = array(
    1 => "base_integrity.php",
    2 => "base_functions.php",
    3 => "base_user.php",
    4 => "base_modules.php",
    5 => "base_cache.php",
    6 => "base_styles.php",
    //7 => "", // rezervováno pro databázi
    8 => "base_blocks.php",
    );
  
  if( class_exists('mysqli') )
  {
    $Files[7] = "mysqli_database.php";
  } 
  else
  {
    $keys = array_keys($_GET);
    $get = "";
    for($i=0; $i<count($keys) ;$i++)
    {
      if( $i == 0 ){ $get .= "?"; }
      else{ $get .= "&"; }
      $get .= $_GET[$keys[$i]];
    }
    header("Location: ".$Config['Base_Dir'].$BaseFile."5".$get);
  }

  for($i=1; $i<=count($Files) ;$i++)
  {
    if( file_exists($Config['Base_Dir']."scripts/".$Files[$i]) )
    {
      require_once $Config['Base_Dir']."scripts/".$Files[$i];
    } else { print(UpFirstLetter($text['other']['file'])." ".$Config['Base_Dir']."scripts/".$Files[$i]." {$text['error']['include']}\n"); exit; } 
  };
  
/* =========== Čištění vstupních hodnot =========== */
  $_POST = InputValues($_POST);
  $_GET = InputValues($_GET);
  
  $Limit = $_GET['list']; // tady získá list z adresy
    if( is_numeric($Limit) == FALSE ){ unset($Limit); }; 
    if( $Limit < 1 OR empty($Limit) ){ $Limit = 1; }; 

/* =========== Připojení k Databázi =========== */
  $Database->connectDB();
  
/* =========== Doplněnéí nastavení o databázi =========== */
  $ConfigDB = $Database->query("SELECT * FROM `{$Config['Table_']}config` ORDER BY `data` ASC");
  while( $cfg_result = $Database->fetch_array($ConfigDB) )
  {
    $Config['ex'][$cfg_result['data']] = $cfg_result['set'];
  }; //print_r($Config);

/* =========== Pár operací kvůli loginu =========== */
  session_start(); 
  $session = session_id('PHPSESSID'); 
  $session_id = $_GET['SID']; 
  if( !empty($session_id) ){ $session = $session_id; }; 



?>