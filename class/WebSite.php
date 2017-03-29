<?php
/**
 * Description of WebSite
 *
 * @author global
 */
class WebSite {
  private $listeCategories;
  private $countCategories;
  
  // ==================================================================
  
  public function get_Categorie() {
    return $this->categorie;
  }
  // ==========================
  
  public function get_CatCount() {
    return $this->countCategories;
  }
  // ==========================
  
  public function set_CatLink($CatLink) {
    $this->categorie = $CatLink;
  }
  
  // ==================================================================

  public function scanMainPage() {

    $htmlMainPage = file_get_html(URL_SITE);

    // récup des deux menus: "catégories" et "marque"
    $block_menus = $htmlMainPage->find('ul[class=advcSearchList]');

    // dans le menu "catégories" on recherche les "li"
    $block_menuCat = $block_menus[0]->find('li');

    $this->countCategories = count($block_menuCat);
    
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
      
      $this->categorie[]  = $pageSite;
    }
  }
  // ==================================================================
  
  function scanCategories() {
    
    $nbrArtParPage = 30;
    
    //foreach ($this->categorie as $catCourant) {
      
    
    
      $cat        = $this->listeCategories[17];
      //$cat = $catCourant;

      $nbrArti    = $cat->get_CatCount();

      //var_dump($cat);
      //var_dump($nbrArti);

      $nbrPages = floor($nbrArti / $nbrArtParPage)+1;

      for ($n=1; $n < ($nbrPages+1); $n++) {
        $cat->scanPageListeArticles($n);
      }
    //}
  }
  
// ================================
  
}
