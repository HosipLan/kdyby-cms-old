<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Database
   * 
   * ??? - need to complete !!!
   */

  class Database extends mysqli 
  {
    
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
      
      $pat = array("/^[\n\r\t ]+/", "/[\n\r\t ]+$/"); $rep = array("", "");
      $keys = array_keys($Data);
      for($i=0; $i<count($keys) ;$i++)
      {
        $Data[$keys[$i]] = preg_replace($pat, $rep, $Data[$keys[$i]]);
      }
      
      $Names = implode("`,`", array_keys($Data));
      $Values = implode("','", InputValues($Data));
      
      $this->query("INSERT INTO `{$Config['Table_']}".$Table."` (`".$Names."`) VALUES('".$Values."') ");  
    }
    
    function update($Table, $Condition, $Data)
    {
      global $Config;
      foreach($Data as $Key => $Value)
      {
  	    $Value = strtr($Value, '"', '\"');
        if($Value != 'NOW()') $Value = "'".$Value."'";
        $Values .= ", `".$Key."`=".$Value;
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
      return @mysqli_fetch_array($sql);
    }
    
    function charset($Charset)
    {
      $this->query('SET CHARACTER SET '.$Charset);
    }
    
    function connectDB()
    {
      global $Config; 

      $this->connect($Config['Database']['Host'], $Config['Database']['User'], $Config['Database']['Password']);
      $this->switchDB($Config['Database']['DB']);
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