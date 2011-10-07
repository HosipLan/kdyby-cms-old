<?php

/* =========== Základní definice =========== */
  define("IN_KDYBY", TRUE);
  if( !defined("IN_KDYBY") ){ exit; }
  $Time = time();
  $TimeMS = date("");
  if( empty($BaseFile) )
  {
    $BaseFile = basename(__FILE__);
  }

/* =========== Global =========== */
  require_once "./global.php";

/* =========== Jádro =========== */
  $Page = $_GET['page'];
  if( empty($Page) ){ $Page = "default"; }
  
  $sql_style = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}styles` WHERE (`name`='{$Config['Style']}' AND ( `enabled`=1 ) ) LIMIT 1"));
  $Cache['base']->checkCache($sql_style);
  $cache_dir = $Cache['base']->cacheDir()."/".strtolower($sql_style['folder']);
  if( !file_exists($cache_dir) )
  { 
    print("Cache stylu nenalezen!"); exit;
  };
  
  $sql_blocks = $Database->query("SELECT * FROM `{$Config['Table_']}block` WHERE ( ".pageRule()."`pages`='' ) ORDER BY `location` ASC");
  while( $blocks = $Database->fetch_array($sql_blocks) )
  {
    //$OutputData .= "začátek Bloku: ".$blocks['id']."<br>";
    if( empty($blocks['template']) )
    {
      switch( empty($blocks['style_id']) )
      {
        case true: switch( $blocks['location'] )
                    {
                      case 5: $Data[$blocks['name']][1] .= ""; break;
                      default: $Data[$blocks['name']][1] .= "    <div>\n"; break;
                    }; break;
        case false: $Data[$blocks['name']][1] .= "    <div id=\"".$blocks['style_id']."\">\n"; break;
      };
    } 
    // id 	block name 	type	data 	priority	pages	desc
    $sql_block_contain = $Database->query("SELECT * FROM `{$Config['Table_']}block_contain` WHERE ( ".pageRule()."`pages`='' ) AND (`block`='{$blocks['id']}') ORDER BY `priority` ASC");
    while( $block_contain = $Database->fetch_array($sql_block_contain) )
    {
      //$OutputData .= "začátek prvku bloku: <br>";
      //print("Vkládám obsah: ".$block_contain['id']."-".$block_contain['name']." <br>\n\n");
      switch( empty($block_contain['style_id']) )
      {
        case true: switch( $blocks['location'] )
                    {
                      case 5: $Data[$blocks['name']][$block_contain['name']] .= ""; break;
                      default: $Data[$blocks['name']][$block_contain['name']] .= "      <div>\n"; break;
                    }; break;
        case false: $Data[$blocks['name']][$block_contain['name']] .= "      <div id=\"".$block_contain['style_id']."\">\n"; break;
      };
      switch($block_contain['type'])
      {
        case 1: $Data[$blocks['name']][$block_contain['name']] .= $Blocks->fileInclude($block_contain['data'], $sql_style); break;
        case 2: $Data[$blocks['name']][$block_contain['name']] .= $Blocks->initModule($block_contain['data'], $sql_style); break;
        case 3: $Data[$blocks['name']][$block_contain['name']] .= $Blocks->printText($block_contain['data'], $sql_style); break;
        default: $Data[$blocks['name']][$block_contain['name']] .= "Blok ".$block_contain['name']." nebylo možné zobrazit!";
      };
      switch( $blocks['location'] )
      {
        case 5: $Data[$blocks['name']][$block_contain['name']] .= ""; break;
        default: $Data[$blocks['name']][$block_contain['name']] .= "      </div>\n"; break;
      };
      //$OutputData .= "konec prvku bloku: <br>";
    }
    if( is_array($Data[$blocks['name']]) )
    {
      $keys = array_keys($Data[$blocks['name']]); 
     // print("Klíče: ");print_r($keys);print(" \n"); 
      //print("\$data[".$blocks['name']."] = ");print_r($Data[$blocks['name']]);print(" \n"); 
      $unset = array("1");
      for($l=0; $l<count($keys) ;$l++)
      {
        //print("mažu: hodnotu-".$keys[$l]."- klíče-".$unset[$l]."- z ");print_r($keys);print(" \n"); 
        if( !in_array($keys[$l], $unset) )
        {
          //print("Přidávám obsah ".$keys[$l]." do \$Data[".$blocks['name']."][1] \n");
          //print("Přidaný obsah: ".$Data[$blocks['name']][$keys[$l]]."\n\n");
          $Data[$blocks['name']][1] .= $Data[$blocks['name']][$keys[$l]];
          //print("Obsah ".$keys[$l]." nastaven v \$Data[".$blocks['name']."][1] na: \n\n");
          //print($Data[$blocks['name']][1]);
          //print("\n\n==================================================================\n\n");
        }
      }
    }
    if( empty($blocks['template']) )
    {
      if( $blocks['location'] != 5 )
      {
        $Data[$blocks['name']][1] .= "    </div>\n\n";
      }
    }
    else
    {
      require $cache_dir."/".$blocks['template'].".php";
      $Data[$blocks['name']][1] = $template;
    }
    //print("BLOCK: -".$blocks['name']."- :\n\n".$Data[$blocks['name']][1]."\n\n");
    //print("\n\n==================================================================\n\n");
    //$OutputData .= "konec Bloku: <br>";
    $Data['OutputData'] .= $Data[$blocks['name']][1]."\n";
  }
  //print("\n\n==================================================================\n\n");
  //print($Data['OutputData']);
  if( !empty($Data['OutputData']) )
  {
    //print("Vygenerováno za: ".($Time-time())."s");
    require $cache_dir."/page_body.html.php";
  };
  
/* =========== Odpojení od databáze =========== */
  $Database->UnConnect();

?>