<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Cache
   * 
   * # need to complete !!!
   */
  
  class Cache 
  {
    var $Cache = ""; // Proměnná s moduly
    
    function cacheDir()
    {
      global $Config;
      return $Config['Base_Dir'].$Config['Cache_Dir'];
    } // konec cacheDir()
    
    function styleCacheDir($folder)
    {
      global $Config; 
      if( !file_exists($folder) )
      {
        if( mkdir($folder) )
        {
          @chmod($folder, "7777");
          return true;
        }
        else
        {
          print("Nepodařilo se vytvořit ".$folder."<br>"); exit;
        }
      }
      else
      {
        @chmod($folder, "7777");
        return true;
      }
    } // konec styleCacheDir()
    
    function stylesDir($sql_style)
    {
      global $Config;
      return $Config['Base_Dir'].$Config['Styles_Dir']."/".strtolower($sql_style['folder']);
    } // konec stylesDir()
    
    function createCache($file, $data)
    {
      $fw = fopen($file, "a+");
      if( !fwrite($fw, $data) )
      {
        fclose($fw);
        return false;
      }	
      fclose($fw);
      return true;
    } // konec createCache()
    
    function checkCache($sql_styles)
    {
      global $Config, $Database;
      
      $folder_cache = $this->cacheDir()."/".strtolower($sql_styles['folder']);
      $this->styleCacheDir($folder_cache); 
      //Debug("Složka vytvořena: ".$folder_cache);
      
      $folder_style = $this->stylesDir($sql_styles)."/pages/";
      $read = opendir($folder_style);
      
      for($i=1; $file = readdir($read) ;$i++) // Pozor! Začíná jedničkou
      {
        $current_style = $folder_style.$file;
        $current_cache = $folder_cache."/".$file.".php";
        if( eregi("^[a-z0-9_\.-]+\.[a-z0-9]+$", strtolower($file)) AND !is_dir($current_style) )
        {
          if( !file_exists($current_cache) )
          {
            //Debug("Compiling<br>\n");
            $Cache = $this->compileCache($current_style);
            if( $Cache != FALSE )
            {
              $this->createCache($current_cache, $Cache);
            }
            else
            {
              print("Nebylo mozne vytvořit cache! Soubor \"$current_style\" má chybný obsah!"); exit; 
            }
          }
        }
      };
      fclose($read);
    } // konec checkCache()
    
    function compileCache($file)
    {
      $read = fopen($file, "r");
      $data = fread($read, filesize($file));
      
      //print("Originální Data z HTML souboru:<br> \n\n\n".nl2br($data)."<br>\n\n");
      
      $php_s = '<'.'?php';
      $php_e = '?'.'>';
      
      if( eregi("^<!--[\t ]+FILE_TYPE:[\t ]+(varchar)[\t ]+-->", $data) )
      {
        $data = preg_replace( array(
            "/\"/",
            "/<!--[\t ]+FILE_TYPE:[\t ]+([a-z]+)[\t ]+-->([\n\r\t ]+)?/",
            "/<!--[\t ]+VAR:[\t ]+([a-zA-Z0-9_]+)(\|)([a-zA-Z0-9_\[\]'\(\)]+)?[\t ]+-->/",
            "/<!--[\t ]+VAR:[\t ]+([a-zA-Z0-9_]+)([a-zA-Z0-9_\[\]'\(\)]+)?[\t ]+-->/",
            "/(.)$/",
          ), array(
            "\\\"",
            "$php_s \$template = \"",
            "\".\$\\1[\$blocks['name']]\\3.\"", 
            "\".\$\\1\\2.\"", 
            "\\1\"; $php_e",
          ), $data);
      }
      elseif( eregi("^<!--[\t ]+FILE_TYPE:[\t ]+(require)[\t ]+-->", $data) )
      {
        $data = preg_replace( array(
            "/<!--[\t ]+FILE_TYPE:[\t ]+([a-z]+)[\t ]+-->([\n\r\t ]+)?/",
            "/<!--[\t ]+DOCTYPE:[\t ]+([a-z0-9\.\+\t ]+)[\t ]+-->/",
            "/<!--[\t ]+META[\t ]+-->/",
            "/<!--[\t ]+PRINT:[\t ]+([a-zA-Z0-9\.\+_-]+)[\t ]+-->/",
            "/<!--[\t ]+FOOT[\t ]+-->/",
            "/<!--[\t ]+VAR:[\t ]+([a-zA-Z0-9_\[\]'\"\(\)]+)[\t ]+-->/",
            //"/<!--[\t ]+MENU_([0-9]+)[\t ]+-->/",
          ), array(
            "",
            "$php_s print(\$Styles['base']->doctype('\\1')); $php_e",
            "$php_s print(\$Styles['base']->meta()); $php_e",
            "$php_s print(\$\\1); $php_e",
            "$php_s print(\$Data['Foot']); $php_e",
            "$php_s print(\$\\1); $php_e",
            //"$php_s print(\$Data['Menu'][\\1]); $php_e",
          ), $data);
      }
      else
      {
        return FALSE;
      }
      
      //print("Data po čistce:<br> \n\n\n".nl2br($data)."<br>\n\n");
      
      closedir($read);
      return $data;
    } // konec compileCache()
    
  } // konec třídy
  
  $Cache['base'] = new Cache();
  
  /**
   * =================================
   */

?>