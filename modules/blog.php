<?php
/* === MODULE CONFIG === ##
NAME: Blog
VERSION: 0.9a
TYPE: view + admin
WRITER: HosipLan
ENCODING: utf-8
PUBLISHED: 2.12.2007
DESCRIPTION: Obsahuje funkce, které umožní udělat na stránkách blog
## === MODULE CONFIG === */

  class Blog
  {
    var $Data = 'news'; // Vstup pro nastavení pracovní hodnoty
    var $CacheDir; // Složka s cachem
    var $ActStyle; // Aktuální styl
   
    var $PageList; // Dočasně uložené stránkování pro výpis článků
    
    var $NewsTemplate = 'articles.html.php'; // Šablona pro články
    var $NewsTemplateBorder = 'articles_border.html.php'; // Obal článků
    var $ArticleTemplate = 'article_blog.html.php'; // Šablona pro článek
    var $ArticlesList = 'articles_list.html.php'; // Šablona pro článek
    
    public function view()
    {
      global $Config, $Database, $SID;
      
      switch($this->Data)
      {
        case 'news': $result = $this->news(); break;
        case 'list': $result = $this->articlesList(); break;
        case 'article': $result = $this->article(); break;
      };
      
      return $result;
    }
    
    public function admin()
    {
      return "Admin: Yeah!<br>\n";
    }
    
    function news()
    {
      global $Database, $Config, $Limit, $SID, $_GET;
      
      if( !empty($_GET['article']) )
      {
        return $this->article();
      };
      
      $sql = "SELECT * FROM `{$Config['Table_']}mod_blog_articles` WHERE `confirmed`!=0 ORDER BY `added` DESC";
      $sql_articles = SQLselect_Strankovani($sql, $Limit, $Config['ex']['blog_news_onpage'], $SID);
      
      for($i=0; $sql_art_res = $Database->fetch_array($sql_articles['result']) ;$i++)
      {
        $art_res[$i] = $this->newsTemplate($sql_art_res);
      }; 
      
      $this->PageList = $sql_articles['list'];
      
      for($i=0; $i<count($art_res) ;$i++)
      {
        $Data['Articles'] .= $art_res[$i];
      };
      
      $sql_articles['result'] = $this->loadTemplate($Data, 2);
      
      return $sql_articles['result'];
    }
    
    function article()
    {
      global $Database, $Config, $Limit, $SID, $_GET;
      
      $this->setWorkData();
      
      $sql_rule = "(`id`='{$_GET['article']}' OR `pages` LIKE '%<article:{$_GET['article']}>%')";
      $article = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}mod_blog_articles` WHERE $sql_rule LIMIT 1"));
      $Database->query("UPDATE `{$Config['Table_']}mod_blog_articles` SET `num_read`='".(++$article['num_read'])."' WHERE $sql_rule LIMIT 1");
      
      if( !empty($_GET['rank']) AND is_numeric($_GET['rank']) )
      {
        $this->addArticleRank($article['id'],$_GET['rank']);
      };
      
      switch($Config['ex']['blog_article_link'])
      {
        case 1: $article['url'] = "?page=blog&amp;article=".$this->generateArticleLink($article['header']).$SID; break;
        case 2: $article['url'] = "?page=blog&amp;article=".$article['id'].$SID; break;
      };
      
      if( empty($article['id']) )
      {
        $article = array(
          'id' => "0",
          'header' => "Chyba",
          'article_fp' => "Článek nebylo možné zobrazit!",
          'autor_nick' => "Admin",
          'added' => time(),
          'num_read' => "0",
          );
      };
      
      $Data = array(
        'ArticleId' => $article['id'],
        'ArticleHeader' => $article['header'],
        'Article' => "<p>".$article['article_fp']."</p>\n".$article['article'],
        'ArticleAutor' => $article['autor_nick'],
        'ArticleDate' => date("H:i d.m.Y", $article['added']),
        'ArticleRead' => $article['num_read'],
        'ArticleRank' => $this->loadArticleRank($article['id']),
        'ArticleUrl' => $article['url'],
        'ArticleCat' => $this->loadArticleCategory($article['category']),
        'ArticleRank1Url' => $article['url']."&amp;rank=1",
        'ArticleRank2Url' => $article['url']."&amp;rank=2",
        'ArticleRank3Url' => $article['url']."&amp;rank=3",
        'ArticleRank4Url' => $article['url']."&amp;rank=4",
        'ArticleRank5Url' => $article['url']."&amp;rank=5",
        );
      
      unset($article);
      $article = $this->loadTemplate($Data, 3);
      
      return $article;
    }
    
    function newsTemplate($articles)
    {
      global $Database, $Config, $Limit, $SID, $sql_style;
      
      $this->setWorkData();
      
      switch($Config['ex']['blog_article_link'])
      {
        case 1: $articles['url'] = "?page=blog&amp;article=".$this->generateArticleLink($articles['header']).$SID; break;
        case 2: $articles['url'] = "?page=blog&amp;article=".$articles['id'].$SID; break;
      };
      
      $Data = array(
        'ArticleId' => $articles['id'],
        'ArticleHeader' => $articles['header'],
        //'Article' => $articles['article'],
        'Article' => $articles['article_fp'],
        'ArticleAutor' => $articles['autor_nick'],
        'ArticleDate' => date("H:i d.m.Y", $articles['added']),
        'ArticleRead' => $articles['num_read'],
        'ArticleUrl' => $articles['url'],
        );
      
      $article = $this->loadTemplate($Data, 1);
      
      return $article;
    }
    
    function generateArticleLink($str)
    {
      $pat = array(
        "/^[\n\r\t ]+/",
        "/[\n\r\t ]+$/",
        "/[^a-zA-Z0-9]+/",
        "/--+/", );
      $rep = array(
        "", "", "-", "-", );
      $str = preg_replace($pat, $rep, $str);
      
      return $str;
    }
    
    function setWorkData()
    {
      global $Cache, $Config, $sql_style;
      
      if( empty($this->CacheDir) OR empty($this->ActStyle) )
      {
        $this->CacheDir = $Cache['base']->cacheDir();
        $this->ActStyle = $sql_style['folder'];
      };
      
      return true;
    }
    
    function loadTemplate($Data, $Template)
    {
      $addr = $this->CacheDir."/".$this->ActStyle."/";
      switch($Template)
      {
        case 1: $Template = $addr.$this->NewsTemplate; break;
        case 2: $Template = $addr.$this->NewsTemplateBorder; break;
        case 3: $Template = $addr.$this->ArticleTemplate; break;
        case 4: $Template = $addr.$this->ArticlesList; break;
      };
      
      if( file_exists($Template) )
      {
        require $Template;
        return $template;
      }
      else
      {
        PageError("Nebyl nalezen soubor <b>".$Template."</b> !");
      };
      
      return false;
    }
    
    function loadArticleCategory($id)
    {
      global $Config, $Database;
      
      $category = $Database->fetch_array($Database->query("SELECT * FROM `{$Config['Table_']}mod_blog_groups` WHERE `id`='{$id}' LIMIT 1"));
      
      return $category['name'];
    }
    
    function loadArticleRank($id)
    {
      global $Config, $Database;
      
      $rank_sql = $Database->fetch_array($Database->query("SELECT ( SUM(`rank`)/COUNT(`id`) ) AS `num` FROM `{$Config['Table_']}mod_blog_articles_rank` WHERE `article`='{$id}' "));
      
      if( empty($rank_sql['num']) )
      {
        $rank_sql['num'] = 0;
      };
      
      return round($rank_sql['num'], 1);
    }
    
    function addArticleRank($id,$rank)
    {
      global $Config, $Database, $Time, $User, $_SERVER;
      
      $check = $Database->fetch_array($Database->query("SELECT `date` FROM `{$Config['Table_']}mod_blog_articles_rank` WHERE (`article`='{$id}' AND (`ip`='{$_SERVER['REMOTE_ADDR']}' OR ( `user`='{$User['id']}' AND `user`!='0' ))) ORDER BY `date` DESC LIMIT 1"));
      
      if( ($check['date'] > $Time AND date("d.m.Y", $check['date']) != date("d.m.Y", $Time)) OR empty($check['date']) )
      {
        $cols = array("id","article","rank","date","user","ip");
        $data = array("NULL",$id,$rank,$Time,$User['id'],$_SERVER['REMOTE_ADDR']);
        $rank_sql = $Database->query("INSERT INTO `{$Config['Table_']}mod_blog_articles_rank` (`".implode("`,`", $cols)."`) VALUES ('".implode("','", $data)."') ");
      };
      
      return true;
    }
    
    function articlesList()
    {
      global $Config, $Database;
      
      $Data['ArticlesList'] = $this->PageList;
      
      $list = $this->loadTemplate($Data, 4);
      
      return $list;
    }
    
  }

 $Module['Blog'] = new Blog();

?>