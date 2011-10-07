<?php
/* === MODULE CONFIG === ##
NAME: Sample
VERSION: 0.9a
TYPE: work + view
WRITER: HosipLan
ENCODING: utf-8
PUBLISHED: 16.11.2007
DESCRIPTION: Testovací modul do KDYBY
## === MODULE CONFIG === */

/* =========================
 * Pokud chete udělat zalomení v MODULE CONFIG napište prostě \n místo zaEntrování
 * Mezera je povinná pouze za dvojtečkou 
 * Maximální délka hodnoty jednotlivých atributů je 255 znaků, kromě DESCRIPTION, který by neměl přesáhnout 500 znaků
 * Pořadí atributů je libovolné 
 * 
 * Typy modulů se budou rozlišovat podle funkcí 
 *  TYPE: work|admin|view
 * funkce prostě spojte za sebou plusky, třeba takhle:
 *  TYPE: work + admin
 * Mezery nehrají roli     
========================= */

  class Sample
  {
    
    public function work()
    {
      return "Work: Yeah!<br>\n";
    }
    
    public function view()
    {
      return "View: Yeah!<br>\n";
    }
    
    public function admin()
    {
      return "Admin: Yeah!<br>\n";
    }
    
  }

 $Module['Sample'] = new Sample();

?>