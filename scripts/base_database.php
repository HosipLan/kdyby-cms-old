<?php

  if( !defined("IN_KDYBY") ){ exit; }

  /**
   * class Database
   * 
   * ??? - need to complete !!!
   */

  class Database extends mysqli 
  {
    
    var $Prefix = '';
    
    function select($Table, $What = '*', $Condition = 1)
    {
      $Query = "SELECT ".$What." FROM `".$this->Prefix.$Table."` WHERE ".$Condition;
      return($this->query($Query));  
    }
    
    function delete($Table, $Condition)
    {
      $this->query("DELETE FROM `".$this->Prefix.$Table."` WHERE ".$Condition);  
    }
    
    function insert($Table, $Data)
    {
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
      $this->query('INSERT INTO `'.$this->Prefix.$Table.'` ('.$Name.') VALUES('.$Values.')');  
    }
    
    function update($Table, $Condition, $Data)
    {
      foreach($Data as $Key => $Value)
      {
  	    $Value = strtr($Value, '"', '\"');
        if($Value != 'NOW()') $Value = "'".$Value."'";
        $Values .= ", ".$Key."=".$Value;
      }
      $Values = substr($Values, 2);  
      $this->query('UPDATE `'.$this->Prefix.$Table.'` SET '.$Values.' WHERE ('.$Condition.')');
    }
    
    function replace($Table, $Data)
    {
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
      $this->query('REPLACE INTO `'.$this->Prefix.$Table.'` (`'.$Name.'`) VALUES('.$values.')');
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
      if( $this->select_db($db) ){ 
        $this->charset("utf8");
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
