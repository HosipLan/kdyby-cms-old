<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Modules 
   * 
   * # need to complete !!!
   */
  
  class Modules 
  {
    var $Modules = ""; // Proměnná s moduly
    
    function modulesDir()
    {
      global $Config;
      return $Config['Base_Dir'].$Config['Modules_Dir'];
    } // konec modulesDir()
    
    function readModuleDesc($current_file)
    {
      $file = fopen($current_file, "r");
      $file = fread($file, FileSize($current_file));
      if( eregi("(\/\* \=+ MODULE CONFIG \=+ ##)(.*)(## \=+ MODULE CONFIG \=+ \*\/)", $file) )
      {
        $desc_f = split("(#+ =+ MODULE CONFIG =+ \*\/)", $file);
        $pattern = array("/(\/\* =+ MODULE CONFIG =+ #+)/",
                         "/^([\n\t\r ]+)?(<\?(php)?)?[\n\t\r ]+/",
                         "/[\n\t\r ]+$/");
        $replacement = array("","","");
        $desc_f = preg_replace($pattern, $replacement, $desc_f[0]);
        $desc_f = split("[\n]+", $desc_f);
        for($i=0; $i<count($desc_f) ;$i++)
        {
          $attr = split(":([\n\t\r ]+)?", $desc_f[$i]);
          $desc[strtolower($attr[0])] = $attr[1];
        }
        $desc['file'] = strtolower(basename($current_file));
        return $desc;
      }
      return false;
    } // konec readModuleDesc()
    
    function listModules()
    {
      $folder = $this->modulesDir();
      $read = opendir($folder);
      for($i=1; $file = readdir($read) ;$i++) // Pozor! Začíná jedničkou
      {
        $current_file = $folder."/".$file;
        if( eregi("^[a-z0-9_\.-]+\.php$", strtolower($file)) AND !is_dir($current_file) )
        {
          $this->Modules[$i] = $this->readModuleDesc($current_file);
        }
      }
      closedir($read);
    } // konec listModules()
    
    function saveModule($i)
    {
      global $Database;
      
      // id 	enabled 	file 	name 	version 	type 	writer 	encoding 	published 	desc
      $insert = array(
        'file' => $this->Modules[$i]['file'],
        'name' => $this->Modules[$i]['name'],
        'version' => $this->Modules[$i]['version'],
        'type' => $this->Modules[$i]['type'],
        'writer' => $this->Modules[$i]['writer'],
        'encoding' => $this->Modules[$i]['encoding'],
        'published' => $this->Modules[$i]['published'],
        'desc' => $this->Modules[$i]['description'],
        ); print_r($insert);
      $Database->insert("modules", $insert);
    } // konec saveModule()
    
    function initModule($mod, $data, $work)
    {
      global $Database, $Config, $Module;
      
      $load = true;
      if( $this->Modules[$mod] == TRUE )
      { 
        $load = false; 
      }; //print("Load: ".$load."<br>\n"); print_r($this->Modules);
      
      $result = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}modules` WHERE (`id`='".$mod."' AND `enabled`=1) LIMIT 1"));
      
      if( file_exists($this->modulesDir()."/".$result['file']) AND $load )
      {
        require $this->modulesDir()."/".$result['file']; 
        $this->Modules[$mod] = TRUE;
      } 
      
      $wtd = split("([\n\t\r ]+)?\+([\n\t\r ]+)?", $result['type']); 
      $mod_name = StEnCut(str_replace(" ", "", $result['name']));
      
      /* DEBUG: 
      print("<textarea style=\"width: 100%; height: 200px;\">\n");
      $mod_keys = array_keys($Module); print($mod_name." "); print_r($mod_keys); print_r($Module);
      switch( $mod_name == 'BaseMenu' )
      {
        case true: print("yeah $mod_name !"); break;
        case false: print("omg $mod_name !!"); break;
      }
      switch( in_array($mod_name, $mod_keys) )
      {
        case true: print("yeah !"); break;
        case false: print("omg !!"); break;
      }
      print("</textarea>\n");
      */
      
      for($i=0; $i<count($wtd) ;$i++)
      {
        if( eregi("work", $wtd[$i]) AND $work == "work" )
        {
          $Module[$mod_name]->Data = $data;
          return $Module[$mod_name]->work();
        }
        if( eregi("view", $wtd[$i]) AND $work == "view" )
        {
          $Module[$mod_name]->Data = $data;
          return $Module[$mod_name]->view();
        }
        if( eregi("admin", $wtd[$i]) AND $work == "admin" )
        {
          $Module[$mod_name]->Data = $data;
          return $Module[$mod_name]->admin();
        }
      }
    } // konec initModule()
    
  } // konec třídy
  
  $Modules['base'] = new Modules();
  
  /**
   * =================================
   */

?>