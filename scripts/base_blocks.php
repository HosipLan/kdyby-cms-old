<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Blocks
   * 
   * ??? - need to complete !!!
   */

  class Blocks
  {
    
    /* ==================================
     * Význam hodnot z block_contain_type
     *
     * 1 	file - Vloží soubor
     * 2  module - Zaktivuje modul
     * 3 	block_text - vypíše text
    ================================== */
    
    function fileInclude($file, $sql_style)
    {
      if( !file_exists($file) )
      {
        return false;
      }
      include $file;
    }
    
    function initModule($module_work, $sql_style)
    {
      global $Modules;
      
      $mod = split("[\t ]+", $module_work);
      $keys = array_keys($mod);
      for($i=3; $i<count($keys) ;$i++)
      {
        $mod[2] .= " ".$mod[$i];
        unset($mod[$i]);
      };
      
      return $Modules['base']->initModule($mod[0], $mod[2], $mod[1]);
    }
    
    function printText($text, $sql_style)
    {
      global $Config, $Database, $Cache, $_GET, $_POST;
      
      if( !is_numeric($text) )
      {
        $rule = PageRules(); //print_r($rule);
        
        $text = split("[\n\r\t ]+", $text);
        $text_id = $text[0];
        
        for($i=0; $i<count($rule) ;$i++)
        {
          if( !in_array($text[$i], $rule) ){ unset($text[$i]); }
        };
        
        if( !empty($text) ){ $pages = "( `pages` LIKE '%".implode("%' OR `pages` LIKE '%", $text)."%' )"; }
        else{ $pages = ""; }
        
        $where = "`id`=$text_id AND (".pageRule()." $pages) ";
      }
      else{ $where = "`id`=$text"; }
      
      $sql_text = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}page_text` WHERE $where LIMIT 1"));
      $Database->update("page_text", " `id`='{$sql_text['id']}' ", array('num_read' => ++$sql_text['num_read']));
      
      $Php_S = "<"."\?";
      $Php_E = "\?".">";
      $sql_text['text'] = preg_replace( array(
              "/{$Php_S}date\(Y\){$Php_E}/",
        ), array(
              date("Y"),
        ), $sql_text['text']);
      
      $temp = $Cache['base']->cacheDir()."/".strtolower($sql_style['folder'])."/article.html.php";
      if( file_exists($temp) AND $sql_text['article'] == 1 )
      {
        $Data['ArticleHeader'] = $sql_text['name'];
        $Data['ArticleDate'] = date("H:i d.m.Y", $sql_text['date']);
        $Data['ArticleAutor'] = $sql_text['writer'];
        if( $sql_text['break'] == 1 )
        {
          $Data['Article'] = "<p>".str_replace("<br />", "<br>", nl2br($sql_text['text']))."</p>";
        }
        else
        {
          $Data['Article'] = $sql_text['text'];
        }
        require $temp;
        return $template;
      }
      else
      {
        if( !empty($sql_text['name']) )
        {
          $Article .= "\n<h1>".$sql_text['name']."</h1>\n";
        }
        if( $sql_text['break'] == 1 )
        {
          $Article .= "<p>".str_replace("<br />", "<br>", nl2br($sql_text['text']))."</p>";
        }
        else
        {
          $Article .= "<p>".$sql_text['text']."</p>";
        }
        if( $sql_text['date'] != 0 )
        {
          $Article .= "<p>Vloženo: ".date("H:i d.m.Y", $sql_text['date'])." | Přečteno: ".$sql_text['num_read']."x</p>\n\n";
        }
        return $Article;
      }
    }
    
  }
  
  $Blocks = new Blocks();

  /**
   * =================================
   */

?>