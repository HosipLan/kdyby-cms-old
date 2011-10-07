<?php

/* =========== Základní definice =========== */
  define("IN_KDYBY", TRUE);
  if( !defined("IN_KDYBY") ){ exit; }
  $Time = time();
  if( empty($BaseFile) )
  {
    $BaseFile = basename(__FILE__);
  }

/* =========== Config aj. =========== */
  require_once "./global.php";

/* =========== Jádro =========== */
  header('Content-type: text/css');
  header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));
  
  if( !isset($_GET['style']) AND !isset($_GET['SID']) )
  {
    $Database->connectDB();
    
    $BaseFile_name = split("\.", $BaseFile);
    $BaseFile_name = $BaseFile_name[0];
    
    $sql_style = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}styles` WHERE ( `enabled`='1' AND `default`='1' ) LIMIT 1"));
    $sql_css = $Database->query("SELECT * FROM `{$Config['Table_']}page_css` WHERE ( `for_page`='default' AND `style`='{$sql_style['id']}' ) ");
    
    $css_dir = $Config['Base_Dir'].$Config['Styles_Dir']."/".$sql_style['folder']."/css";
    
    for($i=0; $result=$Database->fetch_array($sql_css) ;$i++)
      {
        $file = $result['use_style'];
        $current_file = $css_dir."/".$file.".css"; 
        if( file_exists($current_file) )
        {
          readfile($current_file);
        }
      }
    
    $Database->UnConnect();
  }
  elseif( isset($_GET['SID']) )
  {
    
  }
  else
  {
    $Database->connectDB();
    
    $BaseFile_name = split("\.", $BaseFile);
    $BaseFile_name = $BaseFile_name[0];
    
    $sql_style = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}styles` WHERE ( `enabled`='1' AND `default`='1' ) LIMIT 1"));
    $sql_css = $Database->query("SELECT * FROM `{$Config['Table_']}page_css` WHERE ( `for_page`='{$_GET['style']}' AND `style`='{$sql_style['id']}' ) ");
    
    $css_dir = $Config['Base_Dir'].$Config['Styles_Dir']."/".$sql_style['folder']."/css";
    
    for($i=0; $result=$Database->fetch_array($sql_css) ;$i++)
      {
        $file = $result['use_style'];
        $current_file = $css_dir."/".$file.".css"; 
        if( file_exists($current_file) )
        {
          readfile($current_file);
        }
      }
    
    $Database->UnConnect();
  }




?>
