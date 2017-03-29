<?php


/**
 *
 */
class Categorie
{

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $url;

  /**
   * @var integer
   */
  public $countArticles;

  /**
   * @var \Article[]
   */
  public $listeArticles;

// ========================================
// ========================================
  function get_countArticles() {
    return $this->countArticles;
  }
  // ------------------------
  function get_url() {
    return $this->url;
  }


// ========================================

  function set_countArticles($countArticles) {
    $this->countArticles = $countArticles;
  }
  // ------------------------
  function set_name($name) {
    $this->name = $name;
  }

// ========================================
// ======================================== 
  
  public function scrap_PageCategorie($page) {

    $urlPage = $this->get_url()."?p=$page";

    var_dump($urlPage);

    $html = file_get_html($urlPage);

    $blockListe     = $html->find('div[id=products_list]')[0];
    $blockArticles  = $blockListe->find('li[class=product_list_block]');

    foreach ($blockArticles as $blockArt) {

      $urlArticle = $blockArt->find('a')[0]->attr['href'];

      $article = new Article;
      $article->scrap_pageArticle($urlArticle);
      
      $this->listeArticles[] = $article;
    }

    //var_dump($blockListe);
    //var_dump($blockArticles);
  }

// ------------------------------  

  
  
  
}
