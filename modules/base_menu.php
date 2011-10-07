<?php
/* === MODULE CONFIG === ##
NAME: Base Menu
VERSION: 0.9a
TYPE: view + admin
WRITER: HosipLan
ENCODING: utf-8
PUBLISHED: 30.11.2007
DESCRIPTION: Tento modul generuje jednoduché menu
## === MODULE CONFIG === */

  class BaseMenu
  {
    var $Menu = ''; // výsledné menu
    var $Odsazeni = '        '; // Odsazeni
    var $Data = ''; // Vstup pro nastavení pracovní hodnoty
    
    public function view()
    {
      global $Config, $Database, $SID;
      
      $sql_menu = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}mod_menu` WHERE `id`=".$this->Data." LIMIT 1 "));
      
      // id 	menu 	submenu 	priority 	title 	link 	desc
      $sql_elements = $Database->query("SELECT * FROM `{$Config['Table_']}mod_menu_element` WHERE `menu`={$sql_menu['id']} ORDER BY `priority` ASC ");
      
      for($i=0; $elements=$Database->fetch_array($sql_elements) ;$i++)
      {
        if( $i == 0 )
        {
          $this->Menu .= $this->Odsazeni."<ul id=\"menu_".$this->Data."\">\n"; print(" ".$elements['show_title']." ");
          if( $sql_menu['show_title'] == 1 )
          {
            $this->Menu .= $this->Odsazeni."  <li class='strong'>".$sql_menu['title']."</li>\n";
          }
        }
        
        if( $elements['submenu'] != 0 )
        {
          $this->Menu .= $this->Odsazeni."  <li class=\"tree\">\n";
          $store = $this->Odsazeni;
          $this->Odsazeni .= '    ';
          
          $this->Data = $elements['submenu'];
          $this->view();
          
          $this->Odsazeni = $store;
          $this->Menu .= $this->Odsazeni."  </li>\n";
        }
        else
        {
          if( !empty($elements['desc']) ){
            $t = " title=\"".$elements['desc']."\""; }
          else { unset($t); }
          $this->Menu .= $this->Odsazeni."  <li$t><a href=\"".$elements['link'].$SID."\">".$elements['title']."</a></li>\n";
        }
      }
      
      if( $i != 0 )
      {
        $this->Menu .= $this->Odsazeni."</ul>\n";
      }
      
      return $this->Menu;
    }
    
    public function admin()
    {
      return "Admin: Yeah!<br>\n";
    }
    
  }

 $Module['BaseMenu'] = new BaseMenu();


?>