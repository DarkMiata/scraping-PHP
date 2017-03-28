<?php

/**
 * Description of PageSite
 *
 * @author global
 */

class PageSiteCat {
  public    $url;
  private   $cat;
  private   $count;
  private   $listArticles = [];
  
// ==================================================================
// ==================================================================
  
  function set_count($count) {
    
    $countInt = intval($count);
    
    if (is_int($countInt) == TRUE and $countInt > 0) {
      $this->count = $countInt;
    } else {
      echo ("erreur 'set_count':".$countInt." n'est pas un entier<br>");
    }
  }

// ==================================================================

  function set_cat($cat) {
    $this->cat = $cat;
  }

  function set_listArticles($listArticles) {
    $this->listArticles = $listArticles;
  }

  
// ==================================================================

  function get_cat() {
    return $this->cat;
  }

  function get_count() {
    return $this->count;
  }

  function get_listArticles() {
    return $this->listArticles;
  }

  function get_url() {
    return $this->url;
  }



// ==================================================================

<<<<<<< HEAD

  
// ==================================================================
  
  function scanPageListeArticles($page) {

    $urlPage = $this->url."?p=$page";

    var_dump($urlPage);

    $html = file_get_html($urlPage);

    $blockListe     = $html->find('div[id=products_list]')[0];
    $blockArticles  = $blockListe->find('li[class=product_list_block]');

    foreach ($blockArticles as $blockArt) {

      $urlArticle = $blockArt->find('a')[0]->attr['href'];

      $article = new Article;
      $article->scanPageArticle($urlArticle);
      
      
    }

    //var_dump($blockListe);

    //var_dump($blockArticles);



  }
=======
function scanPageListeArticles($page) {
  
  $urlPage = $this->url."?p=$page";
  
  var_dump($urlPage);
  
  $html = file_get_html($urlPage);
  
  $blockListe = $html->find('div[id=products_list]')[0];
  
  var_dump($blockListe);
  
  $linkArticles = $blockListe->find('a')[0];
  
  //var_dump($linkArticles);
  
  
  
}
>>>>>>> master
  
// ==================================================================
}
