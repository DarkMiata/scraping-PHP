<?php
/**
 * Description of WebSite
 *
 * @author global
 */
class WebSite {
  private $CatLink = [];
  private $CatCount;
  
  // ==================================================================
  
  public function get_CatLink() {
    return $this->CatLink;
  }
  // ==========================
  
  public function get_CatCount() {
    return $this->CatCount;
  }
  // ==========================
  
  public function set_CatLink($CatLink) {
    $this->CatLink = $CatLink;
  }
  
  // ==================================================================

  public function scanMainPage () {

    $htmlMainPage = file_get_html(URL_SITE);

    // récup des deux menus: "catégories" et "marque"
    $block_menus = $htmlMainPage->find('ul[class=advcSearchList]');

    // dans le menu "catégories" on recherche les "li"
    $block_menuCat = $block_menus[0]->find('li');

    $this->CatCount = count($block_menuCat);
    
      // dans chaque catégorie, rechercher le lien
    foreach ($block_menuCat as $cat) {
      $pageSite = new PageSiteCat;

      //récup du lien
      $pageSite->url  = $cat->find('[href]')[0]->attr['href'];
      
      // récup du nom de la catégorie
      $nomCatHref       = $cat->find('[href]')[0]->plaintext;
      $nomCatExpl       = explode("(", $nomCatHref);
      
      $pageSite->set_count(explode(")",$nomCatExpl[1])[0]);
      $pageSite->set_cat(trim($nomCatExpl[0]));
      
      $this->CatLink[]  = $pageSite;
    }
  }
}
