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

/* =========== Připojení k Databázi =========== */
  $Database->connectDB();

/* =========== Čištění vstupních hodnot =========== */
  $_POST = InputValues($_POST);
  $_GET = InputValues($_GET);

/* =========== Jádro =========== */
  print($Styles['base']->doctype("html 4.01 transitional"));
  print("<html>\n  <head>\n");
  print($Styles['base']->meta());
  print("  </head>\n  <body>\n\n");
    $doc_sql = $Database->query("SELECT * FROM `db_info` ORDER BY `kategory` ASC, `header` ASC ");
    $header = array();
    for($i=0; $result = $Database->fetch_array($doc_sql) ;$i++)
    {
      if( !in_array($result['kategory'], $header) )
      {
        print("  <h1>".$result['kategory']."</h1>\n");
        $header[$i] = $result['kategory'];
      }
      
      print("<h2>".$result['header']."</h2>\n");
      print("<p>".preg_replace(array("/<br \/>/", "/[\t ]/"), array("<br>", "&nbsp;"), nl2br($result['data']))."</p><br>\n");
    }
  print("\n  </body>\n</html>\n");

/* =========== Odpojení od databáze =========== */
  $Database->UnConnect();

?>