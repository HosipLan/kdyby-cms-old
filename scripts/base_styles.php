<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Modules 
   * 
   * # need to complete !!!
   */
  
  class Styles
  {
    var $Styles = ""; // Proměnná se Styly
    
    function stylesDir()
    {
      global $Config;
      return $Config['Base_Dir'].$Config['Styles_Dir'];
    } // konec stylesDir()
    
    function doctype($dtd)
    {
      $type = preg_replace("/^([a-z0-9\.\+ ]+)+ ([a-z0-9]+)$/", "\\2", $dtd);
      $lang = preg_replace("/^([a-z0-9\.\+ ]+)+ ([a-z0-9]+)$/", "\\1", $dtd);
      switch($lang)
      {
        case 'html 4.01': switch($type)
          {
            case 'strict':        return "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\"\n   \"http://www.w3.org/TR/html4/strict.dtd\">\n"; break;
            case 'transitional':  return "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\n   \"http://www.w3.org/TR/html4/loose.dtd\">\n"; break;
            case 'frameset':      return "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\"\n   \"http://www.w3.org/TR/html4/frameset.dtd\">\n"; break;
          }; break;
        case 'xhtml 1.0': switch($type)
          {
            case 'strict':        return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n   \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"; break;
            case 'transitional':  return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n   \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n"; break;
            case 'frameset':      return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\"\n   \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n"; break;
          }; break;
        case 'xhtml 1.1': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n   \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n"; break;
          }; break;
        case 'xhtml basic 1.0': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML Basic 1.0//EN\"\n    \"http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd\">\n"; break;
          }; break;
        case 'xhtml basic 1.1': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML Basic 1.1//EN\"\n    \"http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd\">\n"; break;
          }; break;
        case 'html 2.0': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"; break;
          }; break;
        case 'html 3.2': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 3.2 Final//EN\">\n"; break;
          }; break;
        case 'mathml 1.01': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE math SYSTEM 	\"http://www.w3.org/Math/DTD/mathml1/mathml.dtd\">\n"; break;
          }; break;
        case 'mathml 2.0': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE math PUBLIC \"-//W3C//DTD MathML 2.0//EN\"	\n	\"http://www.w3.org/TR/MathML2/dtd/mathml2.dtd\">\n"; break;
          }; break;
        case 'shtml + mathml + svg': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE html PUBLIC\n    \"-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN\"\n    \"http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd\">\n"; break;
          }; break;
        case 'svg 1.0': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.0//EN\"\n	\"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd\">\n"; break;
          }; break;
        case 'svg 1.1 full': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\"\n	\"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">\n"; break;
          }; break;
        case 'svg 1.1 basic': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1 Basic//EN\"\n	\"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-basic.dtd\">\n"; break;
          }; break;
        case 'svg 1.1 tiny': switch($type)
          {
            case 'dtd':           return "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1 Tiny//EN\"\n	\"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11-tiny.dtd\">\n"; break;
          }; break;
      }
    }
    
    function meta()
    {
      global $Database, $Config, $BaseFile;
      $BaseFile_name = split("\.", $BaseFile);
      $BaseFile_name = $BaseFile_name[0];
      $sql_meta_rule = "(( `for_page` LIKE '%<file:{$BaseFile_name}>%' ) AND NOT( `for_page` LIKE '%<file:!{$BaseFile_name}>%' )) OR ";
      $sql_meta = $Database->query("SELECT * FROM `{$Config['Table_']}page_meta` WHERE (`data` != '' AND `meta_type` != '') AND ( {$sql_meta_rule}`for_page`='' ) ");
      for($i=0; $result=$Database->fetch_array($sql_meta) ;$i++)
      {
        $pattern = array("/@data/", "/@meta/");
        $replacement = array($result['data'], $result['meta_type']);
        $meta .= "   ".preg_replace($pattern, $replacement, $result['meta'])."\n";
      }
      
      return $meta;
    } // konec meta()
    
    function saveStyle($i)
    {
      global $Config, $Database;
      
      // id  	enabled 	default 	folder 	name 	desc
      $insert = array(
        'folder' => addslashes($this->Styles[$i]['folder']),
        'name' => addslashes($this->Styles[$i]['name']),
        'desc' => addslashes($this->Styles[$i]['desc']),
        ); //print_r($insert);
      $Database->insert("styles", $insert);
      
      $keys = array_keys($this->Styles[$i]); //print_r($keys);
      for($l=0; $l<count($keys) ;$l++)
      {
        $data[$keys[$l]] = addslashes($this->Styles[$i][$keys[$l]]);
      }
      
      $unset = array("folder","name","desc");
      for($l=0; $l<count($unset) ;$l++)
      {
        unset($data[$unset[$l]]);
      } //print_r($data);
      
      // id  	style 	attr 	data
      $sql_inserted_style = $Database->fetch_array($Database->query("SELECT `id` FROM `{$Config['Table_']}styles` WHERE ( `folder`='".addslashes($this->Styles[$i]['folder'])."' ) LIMIT 1"));
      
      $keys = array_keys($data);
      for($l=0; $l<count($keys) ;$l++)
      {
        $insert = array(
          'style' => $sql_inserted_style['id'],
          'attr' => addslashes($keys[$l]),
          'data' => $data[$keys[$l]],
          ); //print_r($insert);
        $Database->insert("styles_description", $insert);
      }
    } // konec saveStyle()
    
    function readStyleDesc($current_file)
    {
      $file = fopen($current_file, "r");
      $file = fread($file, FileSize($current_file));
      if( eregi("^<"."\?xml([\t ]+)version=\"[0-9\.]+\" encoding=\"utf-8\"([\t ]+)?\?".">", $file) )
      {
        $desc_f = split("<\/[a-zA-Z0-9]+>[\n\r]+", $file);
        $pattern = array("/^<"."\?xml([\t ]+)version=\"[0-9\.]+\"([\t ]+)encoding=\"utf-8\"([\t ]+)?\?".">/",
                         "/^([\n\r\t ]+)?</",
                         "/<\/[a-zA-Z0-9]+>([\n\r\t ]+)?/",
                         "/[\n\t\r ]+$/");
        $replacement = array("","","");
        for($i=0; $i<count($desc_f) ;$i++)
        {
          $desc_f[$i] = preg_replace($pattern, $replacement, $desc_f[$i]);
          if( eregi("^[a-zA-Z0-9]+>(.)+$", $desc_f[$i]) )
          {
            $attr = split(">", $desc_f[$i]);
            $desc[strtolower($attr[0])] = $attr[1];
          }
        }
        return $desc;
      }
      return false;
    } // konec readStyleDesc()
    
    function listStyles()
    {
      $folder = $this->stylesDir();
      $read = opendir($folder);
      for($i=1; $file = readdir($read) ;$i++) // Pozor! Začíná jedničkou
      {
        $current_file = $folder."/".$file;
        if( eregi("^[a-zA-Z0-9_-]+$", $file) AND is_dir($current_file) )
        {
          $this->Styles[$i] = array_merge($this->readStyleDesc($current_file."/description.xml"), array('folder' => strtolower(basename($current_file))));
        }
      }
      closedir($read);
    } // konec listStyles()
    
    function initTemplate($style_id)
    {/*
      global $Database, $Styles, $Cache, $Config, $_GET;
      $Page = $_GET['page'];
      if( !empty($Page) )
      {
        $sql_page_template_rule = "(( `pages` LIKE '%$Page%' ) AND NOT( `pages` LIKE '%!$Page%' )) OR ";
      }
      
      $sql_page_template = $Database->query("SELECT * FROM `{$Config['Table_']}styles_templates` WHERE `style`={$sql_styles['id']} AND ( {$sql_page_template_rule}`pages`='' ) ORDER BY `priority` ASC");
      for($i=0; $page_t=$Database->fetch_array($sql_page_template) ;$i++)
      {
        $file = $Cache['base']->cacheDir()."/".$sql_styles['folder']."/".$page_t['file'].".php";
        if( !file_exists($file) )
        {
          print("Chyba, soubor nenalezen!"); exit;
        }
        else
        {
          $Files[$i] = $file;
        }
      }
      
      global $Styles, $Database, $Modules, $User, $Data;
      for($i=0; $i<count($Files) ;$i++)
      {
        require $Files[$i];
      }
      
      return true;*/
    } // konec initStyle()
    
    function initStyle($style_id)
    {/*
      global $Database, $Styles, $Cache, $Config, $_GET;
      
      $Page = $_GET['page'];
      if( !empty($Page) )
      {
        $sql_page_template_rule = "(( `pages` LIKE '%$Page%' ) AND NOT( `pages` LIKE '%!$Page%' )) OR ";
      }
      
      $sql_page_template = $Database->query("SELECT * FROM `{$Config['Table_']}styles_templates` WHERE `style`={$sql_styles['id']} AND ( {$sql_page_template_rule}`pages`='' ) ORDER BY `priority` ASC");
      for($i=0; $page_t=$Database->fetch_array($sql_page_template) ;$i++)
      {
        $file = $Cache['base']->cacheDir()."/".$sql_styles['folder']."/".$page_t['file'].".php";
        if( !file_exists($file) )
        {
          print("Chyba, soubor nenalezen!"); exit;
        }
        else
        {
          $Files[$i] = $file;
        }
      }
      //Debug("Files: ".$i." "); print_r($Files); 
      
      global $Styles, $Database, $Modules, $User, $Data;
      for($i=0; $i<count($Files) ;$i++)
      {
        require $Files[$i];
      }
      
      return true;*/
    } // konec initStyle()
    
  } // konec třídy
  
  $Styles['base'] = new Styles();
  
  /**
   * =================================
   */

?>
