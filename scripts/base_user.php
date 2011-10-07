<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class User
   * 
   * # need to complete !!!
   * 
   */

  class User 
  {
    var $User; // data uživatele
    var $id; // současná stránka
    var $sql_select; // proměnná obsahující všechny výsledky pro výpis
    var $SID; // proměnná obsahující imformaci o přihlášení pro předání na konec každého odkazu

    function login()
    {
      global $session, $SID, $User, $_POST, $Time, $Database, $Config;

      if( !empty($_POST['username']) AND !empty($_POST['password']) ){
        
        $nick = strtolower($_POST['username']); //print("Uživatel: ".$nick." <br>");
        $heslo = $_POST['password']; //print("Heslo: ".$heslo." <br>");
        
        $heslo_md5 = md5($heslo); //print("Hash1: ".$heslo_md5." <br>");
        $heslo_sha1 = sha1($heslo); //print("Hash2: ".$heslo_sha1." <br>");

        /* přihlášení proběhne pouze pokud bylo odesláno heslo a jméno */ 
          $User = $Database->fetch_array($Database->Query("SELECT * FROM `{$Config['Table_']}user` WHERE (LOWER(`username`)='$nick') LIMIT 1 ")); 
          
          //print("<br>Hash1: ".$User['password_md5']." - 3d0c300ba209487b96194b2fb88cf8cf <br>");
          //print("Hash2: ".$User['password_sha1']." - 9cd66f507ce52d5094e9655bb4947ecc4b96aba6 <br>");
          
          if( $User['password_md5'] == $heslo_md5 AND $User['password_sha1'] == $heslo_sha1 AND $User['reg_active'] == 1 )
          { 
            $Database->query("UPDATE `{$Config['Table_']}user` SET `login`='1', `login_hash`='{$session}', `login_time`='{$Time}' WHERE `id`='{$User['id']}' LIMIT 1");
            
            $login_err = "Přihlášení proběhlo úspěšně.";
            header("Location: ?page=login&SID={$session}&err=".urlencode($login_err)); exit;
          } 
          elseif( $User['reg_active'] != 1 )
          {
            $login_err = "Příhlášení se nezdařilo, protože váš účet ještě nebyl aktivován!";
          }
          elseif( ($User['password_md5'] != $heslo_md5 OR $User['password_sha1'] != $heslo_sha1) AND !empty($User['id']) )
          {
            $login_err = "Příhlášení se nezdařilo, protože bylo špatně zadáno heslo!";
          }
          else
          { 
            $login_err = "Nejste registrovaný uživatel nebo byly špaťně zadány údaje,<br /> přihlásit se proto nemůžete! "; 
          };
        } 
        elseif( isset($_POST['login']) AND ( empty($prijaty_nick) OR empty($prijate_heslo) ) )
        {
          $login_err = "Jeden z údajů chybí! Vyplňte Prosím jméno i heslo!";
        };
      
      $this->User = $User;

      return $login_err;
    } // konec login()

    function logout()
    {
      global $session, $SID, $Config, $User, $Database, $Config;

      session_unset(); session_regenerate_id();
      $Database->query("UPDATE `{$Config['Table_']}user` SET `login`=0 WHERE `login_hash`='{$session}' LIMIT 1"); 
      unset($User); unset($SID);
      
      $logout_err = "Odhlášení proběhlo úspěšně.";
      
      header("Location: ?page=login&err=".urlencode($logout_err)); exit;

      return true;
    } // konec logout()

    function pageLoginCheck()
    {
      global $session, $SID, $User, $Time, $Database, $Config;

        //print("Kontroluji přihlášení<br>");
        
        $User_sql = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}user` WHERE `login_hash`='{$session}' LIMIT 1 "));
        //print_r($User_sql);
        if( $User_sql['login'] == 1 ) { 
          $User = array_merge($User_sql, $User); //print_r($User);
          $User['loged'] = 1; 
          $get = count($_GET);
            if( $get < 1 ){ $SID = "?SID=".$session; } 
            else{ $SID = "&amp;SID=".$session; }; 
          $time_login = $User['login_time']+(60*20);
          if( $time_login <= $Time )
          {  
            $this->Logout();
          } 
          else
          { 
            $keys = array_keys($_GET);
            for($i=0; $i<count($keys) ;$i++)
            {
              if( $i==0 ){ $l_p .= "?"; }
              else{ $l_p .= "&"; };
              $l_p .= $keys[$i]."=".$_GET[$keys[$i]];
            };
            $l_ip = $_SERVER['REMOTE_ADDR'];
            
            $Database->query("UPDATE `{$Config['Table_']}user` SET `login_time`='{$Time}',`last_page`='{$l_p}',`last_ip`='{$l_ip}' WHERE `id`='{$User['id']}' LIMIT 1"); 
          };
      
          } else{ unset($User); }; 
      
      $this->User = $User;
      
      return true;
    } // konec pageLoginCheck()

  }
  
  $User['base'] = new User();

  /**
   * =================================
   */

?>
