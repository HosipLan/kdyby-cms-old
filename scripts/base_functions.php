<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * Debug($var)
   * 
   * Funkcí obalujte hodnoty, které mohou mít nějaký význam při odlaďování
   * Funkce vrací vstupní hodnotu, ale navíc jí vypíše pokud je DEBUG zaplý
   *            
   */

  function Debug($var){ 
    global $KDYBY_DEBUG;
    if( $KDYBY_DEBUG == true )
    {
      //print str_replace("<br />", "<br>", nl2br(preg_replace(array("/</","/>/"), array("&#60;","&#62;"), $var)))."<br>";
      print $var."<br>\n";
      //print $var;
    }
    return $var;
    }

  /**
   * Debug($var)
   * 
   * Funkcí obalujte hodnoty, které mohou mít nějaký význam při odlaďování
   * Funkce vrací vstupní hodnotu, ale navíc jí vypíše pokud je DEBUG zaplý
   *            
   */

  function PageError($reson=''){ 
    print("<html>\n  <head>\n");
    print("   <title>HosipLan</title>\n");
    print("   <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">\n");
    print("  </head>\n  <body>\n");
    print("\n  <p>".$reson."</p>\n");
    print("\n  </body>\n</html>\n");
    
    exit;
    }

  /**
   * pageRule()
   * 
   * ???
   *            
   */

  function pageRule(){ 
    global $_GET;
    
    $Page = $_GET['page'];
    if( empty($Page) ){ $Page = "default"; }
    
    return "(NOT( `pages` LIKE '%<page:!{$Page}>%' ) AND `pages` LIKE '%<page:{$Page}>%') OR";
    }

  /**
   * PageRules()
   * 
   * ???
   *            
   */

  function PageRules(){ 
    global $_GET, $_POST;
    
    $array_REQUEST = array_merge($_GET, $_POST); 
    $keys = array_merge(array_keys($_GET), array_keys($_POST)); 
    for($i=0; $i<count($keys) ;$i++)
    {
      $rule[$i] = "<".$keys[$i].":".$array_REQUEST[$keys[$i]].">";
    };
    
    return $rule;
    }

  /**
   * InputValues($Values)
   * 
   * Čistí vstupní hodnotu, kterou pak vrátí
   *            
   */

  function InputValues($Values){ 
    
    $klic = array_keys($Values);
    
    for ($i=0; $i<count($klic) ;$i++) {
      $Values[$klic[$i]] = addslashes($Values[$klic[$i]]);
      };
    
    return $Values;
    }

  /**
   * DelNl($str)
   * 
   * Odstraná řádkování z řetězce
   *            
   */

  function DelNl($str){ 
    $str = @str_replace("\n","",$str);
    $str = @str_replace("\r","",$str);
    return $str;
    }

  /**
   * AbsCheck($int)
   * 
   * Zjistí zda je hodnota kladná a vrací TRUE
   * pokud není kladná vrací FALSE
   *            
   */

  function AbsCheck($int){ return (abs($int)==$int)? true : false; }

  /**
   * FirstLetter($string)
   * 
   * Předělá první písmeno na velké
   *            
   */

  function UpFirstLetter($string){ 
    $first = strtoupper(substr($string,0,1));
    $other = substr($string,1,strlen($string));
    return $first.$other;
    }

  /**
   * FirstLetter($string)
   * 
   * Předělá první písmeno na velké
   *            
   */

  function FirstWord($string, $match){ 
    if( eregi("^".strtoupper($match).":[\t ]+", $string) )
    {
      $string = Debug(eregi_replace("^".strtoupper($match).":[\t ]+", "", $string));
      return true; 
    }
    return false;
    }

  /**
   * StEnCut($string)
   * 
   * Ořízne z řetězce počáteční a koncové mezery a odřádkování
   *            
   */

  function StEnCut($string){ 
    $pat = array("/^[\n\r\t ]+/", "/[\n\r\t ]+$/");
    $rep = array("", "");
    return preg_replace($pat, $rep, $string);
    }

  /**
   * StranovaniVypisu($sql, $limit, $nastranu, $adresa, $SID)
   * SQLselect_Strankovani($dotaz, $limit, $nastranu, $adresa, $SID)   
   * 
   * SQLselect_Strankovani() zavolá StranovaniVypisu()
   * a následně vykoná příkaz $sql s atributy 
   * $limit a $nastranu 
   * Vrátí výsledek funkce StranovaniVypisu() a vykonaný příkaz
   * 
   * StranovaniVypisu() vykoná příkaz znovu bez limitu 
   * a vrátí stránkování   
   *            
   */

  function Strankovani_URL(){ 
    global $_GET;
    $Values = $_GET;
    
    $keys = array_keys($Values);
    for ($i=0; $i<count($keys) ;$i++)
    {
      if( $keys[$i] == "list" ){  }
      elseif( $i == 0 ){ $result .= "?".$keys[$i]."=".$Values[$keys[$i]]; }
      elseif( $i > 0 ){ $result .= "&amp;".$keys[$i]."=".$Values[$keys[$i]]; }
    };
    
    return $result;
    }

  function StranovaniVypisu($sql, $limit, $nastranu, $SID){ 
    global $Database, $text;
    
    $pat = array("/^(SELECT)[\t ]+.+[\t ]+(FROM)/", );
    $rep = array("\\1 COUNT(`id`) AS `rows` \\2", );
    $sql = preg_replace($pat, $rep, $sql);
    
    $pocet_radku = $Database->fetch_array($Database->query($sql));
    $pocet_radku = $pocet_radku['rows']; 
    
    $adresa = Strankovani_URL();
    
    if( $pocet_radku > 0 ) { 
      $listovani = $pocet_radku/10; 
      $listovani = ceil($listovani); 
      $listovani = $listovani/($nastranu/10);
      $listovani = ceil($listovani); 

      if( $listovani == 1 ){ 
        $navigace = "&lt;&lt; &nbsp; &lt; <b>1</b> &gt; &nbsp; &gt;&gt;";
        }
      elseif( $listovani > 1 ){ 
        $predchozi = $limit-1;
        $dalsi = $limit+1;
        $posledni = $listovani;
        if( $predchozi < 1 ){ $predchozi = 1; };

        if( $listovani <= 10 ){ 
          for( $i=1; ($i<=10)AND($i<=$listovani) ;$i++ ){ 
            if($i==$limit){$navigace['cisla'] .= " <b title=\"".$text['navigation']['onpage'].$text['navigation']['number']." $i\">".$i."</b>\n";}
            else{$navigace['cisla'] .= " <a href=\"index.php".$adresa."&amp;list=".$i.$SID."\" title=\"".$text['navigation']['page'].$text['navigation']['number']." $i\">".$i."</a>\n";};
            };

          $navigace['zacatek'] = "<a href=\"index.php".$adresa."&amp;list=1".$SID."\" title=\"".$text['navigation']['start']."\">&lt;&lt;</a>"." &nbsp; ";
          $navigace['zacatek'] .= "<a href=\"index.php".$adresa."&amp;list=".$predchozi.$SID."\" title=\"".$text['navigation']['previous']."\">&lt;</a> ";
          $navigace['konec'] = " <a href=\"index.php".$adresa."&amp;list=".$dalsi.$SID."\" title=\"".$text['navigation']['next']."\">&gt;</a>"." &nbsp; ";
          $navigace['konec'] .= "<a href=\"index.php".$adresa."&amp;list=".$posledni.$SID."\" title=\"".$text['navigation']['end']."\">&gt;&gt;</a>";

          if( $limit == 1 ){ $navigace['zacatek'] = "&lt;&lt;"." &nbsp; &lt; "; };
          if( $limit == $listovani ){ $navigace['konec'] = " &gt; &nbsp; &gt;&gt;"; };
          } 
        else{
          if( $limit <= 6 ){ 
            for( $i=1; ($i<=10) ;$i++ ){ 
              if($i==$limit){$navigace['cisla'] .= " <b title=\"".$text['navigation']['onpage'].$text['navigation']['number']." $i\">".$i."</b>\n";}
              else{$navigace['cisla'] .= " <a href=\"index.php".$adresa."&amp;list=".$i.$SID."\" title=\"".$text['navigation']['page'].$text['navigation']['number']." $i\">".$i."</a>\n";};
              }; $navigace['cisla'] .= " ... ";
            } 
          elseif( $limit >= 6 AND (($limit+6) <= $listovani) ){ 
            $navigace['cisla'] .= " ... ";
            
            for( $i=$limit-5; ($i<=$limit+5) ;$i++ ){ 
  
              if($i==$limit){$navigace['cisla'] .= " <b title=\"".$text['navigation']['onpage'].$text['navigation']['number']." $i\">".$i."</b>\n";}
              else{$navigace['cisla'] .= " <a href=\"index.php".$adresa."&amp;list=".$i.$SID."\" title=\"".$text['navigation']['page'].$text['navigation']['number']." $i\">".$i."</a>\n";};
  
              }; $navigace['cisla'] .= " ... ";
            } 
          elseif( ($limit+6) >= $listovani ){ 
            $navigace['cisla'] .= " ... ";
            for( $i=$listovani-10; ($i<=$listovani) ;$i++ ){ 
              if($i==$limit){$navigace['cisla'] .= " <b title=\"".$text['navigation']['onpage'].$text['navigation']['number']." $i\">".$i."</b>\n";}
              else{$navigace['cisla'] .= "<a href=\"index.php".$adresa."&amp;list=".$i.$SID."\" title=\"".$text['navigation']['page'].$text['navigation']['number']." $i\">".$i."</a>\n";};
              }; 
            }; 

          $navigace['zacatek'] = "<a href=\"index.php".$adresa."&amp;list=1".$SID."\" title=\"".$text['navigation']['start']."\">&lt;&lt;</a>"." &nbsp; ";
          $navigace['zacatek'] .= "<a href=\"index.php".$adresa."&amp;list=".$predchozi.$SID."\" title=\"".$text['navigation']['previous']."\">&lt;</a> ";
          $navigace['konec'] = " <a href=\"index.php".$adresa."&amp;list=".$dalsi.$SID."\" title=\"".$text['navigation']['next']."\">&gt;</a>"." &nbsp; ";
          $navigace['konec'] .= "<a href=\"index.php".$adresa."&amp;list=".$posledni.$SID."\" title=\"".$text['navigation']['end']."\">&gt;&gt;</a>";


          if( $limit == 1 ){ $navigace['zacatek'] = "&lt;&lt;"." &nbsp; &lt; "; };
          if( $limit == $listovani ){ $navigace['konec'] = " &gt; &nbsp; &gt;&gt;"; };
          };
        $navigace = $navigace['zacatek'].$navigace['cisla'].$navigace['konec'];
        };
      
      return $navigace;
      }
    else{ return FALSE; };
    }

  function SQLselect_Strankovani($dotaz, $limit, $nastranu, $SID){ 
    global $Database;
    
    $navigace = StranovaniVypisu($dotaz, $limit, $nastranu, $SID);
    $dotaz =  $Database->Query($dotaz." LIMIT ".(--$limit*10*($nastranu/10)).", $nastranu "); 
    $vysledek = array( 'result'   => $dotaz, 
                       'list'     => $navigace );
    return $vysledek;
    }
  
  /**
   * =================================
   */

?>