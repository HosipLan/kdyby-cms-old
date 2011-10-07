<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Database
   * 
   * ??? - need to complete !!!
   */

  class Database extends mysql 
  {
    
    var $Prefix = '';
    
    function select($Table, $What = '*', $Condition = 1)
    {
      global $Config;
      $Query = "SELECT ".$What." FROM `{$Config['Table_']}".$Table."` WHERE ".$Condition;
      return($this->query($Query));  
    }
    
    function delete($Table, $Condition)
    {
      global $Config;
      $this->query("DELETE FROM `{$Config['Table_']}".$Table."` WHERE ".$Condition);  
    }
    
    function insert($Table, $Data)
    {
      global $Config;
      $Name = '';
      $Values = '';
      foreach($Data as $Key => $Value)
      {
        $Value = strtr($Value, '"', '\"');
        $Name .= ','.$Key;
  	    if($Value == 'NOW()') $Values .= ",".$Value;
  	      else $Values .= ",'".$Value."'";
      }
      $Name = substr($Name, 1);
      $Values = substr($Values, 1);
      $this->query("INSERT INTO `{$Config['Table_']}".$Table."` (".$Name.") VALUES(".$Values.")");  
    }
    
    function update($Table, $Condition, $Data)
    {
      global $Config;
      foreach($Data as $Key => $Value)
      {
  	    $Value = strtr($Value, '"', '\"');
        if($Value != 'NOW()') $Value = "'".$Value."'";
        $Values .= ", ".$Key."=".$Value;
      }
      $Values = substr($Values, 2);  
      $this->query("UPDATE `{$Config['Table_']}".$Table."` SET ".$Values." WHERE (".$Condition.")");
    }
    
    function replace($Table, $Data)
    {
      global $Config;
      $Name = '';
      $Values = '';
      foreach($Data as $Key => $Value)
      {
        $Value = strtr($Value, '"', '\"');
        $Name .= ",".$Key;
        if($Value == 'NOW()') $Values .= ",".$Value;
          else $Values .= ',"'.$Value.'"';
      }
      $Name = substr($Name, 1);
      $Values = substr($Values, 1);
      $this->query("REPLACE INTO `{$Config['Table_']}".$Table."` (`".$Name."`) VALUES(".$values.")");
    }
    
    function fetch_array($sql)
    {
      return mysqli_fetch_array($sql);
    }
    
    function charset($Charset)
    {
      $this->query('SET CHARACTER SET '.$Charset);
      return true;
    }
    
    function connectDB()
    {
      global $Config;
      //$result = FALSE;

      //mysqli_connect([string hostname], [string username], [string passwd], [string dbname], [int port], [string socket])
      $this->connect($Config['Database']['Host'], $Config['Database']['User'], $Config['Database']['Password']);
      $this->switchDB($Config['Database']['DB']);
      //$result = "<p>Vyskytla se chyba a nelze se připojit k databázi.<br> Zkuste to později.</p>"; 
      //return false;
    }
    
    function switchDB($db)
    {
      global $Config;
      
      if( $this->select_db($db) ){ 
        $this->charset($Config['DB_encoding']);
        } 
      else{ return false; };
      return true;
    }
    
    function unConnect()
    {
      $this->close();
    }
    
  }
  
  $Database = new Database();

  /**
   * =================================
   */

?>