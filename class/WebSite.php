<?php


/**
 *
 */
class WebSite {

  /**
  * @var string
  */
  public $name;

  /**
   * @var string
   */
  public $mainUrl;

  /**
   * @var integer
   */
  public $countCategories;


  /**
   * @var \Categorie[]
   */
  public $listeCategories;

  // ========================================
  // ========================================

  public function get_listeCategories() {
    return $this->listeCategories;
  }


  // ========================================
  // ========================================

  /**
   *
   */
  public function scrap_catsFromWebSite() {

    $htmlMainPage = file_get_html(URL_SITE);

    // récup des deux menus: "catégories" et "marque"
    $block_menus = $htmlMainPage->find('ul[class=advcSearchList]');

    // dans le menu "catégories" on recherche les "li"
    $block_menuCat = $block_menus[0]->find('li');

    $this->countCategories = count($block_menuCat);

      // dans chaque catégorie, rechercher le lien
    foreach ($block_menuCat as $htmlCat) {
      $categorie = new Categorie();

      //récup du lien
      $categorie->url  = $htmlCat->find('[href]')[0]->attr['href'];

      // récup du nom de la catégorie
      $nomCatHref       = $htmlCat->find('[href]')[0]->plaintext;
      $nomCatExpl       = explode("(", $nomCatHref);

      $categorie->set_countArticles(explode(")",$nomCatExpl[1])[0]);
      $categorie->set_name(trim($nomCatExpl[0]));

      $this->categorie[]  = $categorie;

      $categorie->to_DB();
    }
  }
  // ========================================

  public function scrap_Categories() {

    $nbrArtParPage = 30;

  //foreach ($this->categorie as $catCourant) {

    $cat        = $this->categorie[17];
    //$cat = $catCourant;

    $nbrArti    = $cat->get_countArticles();

    //var_dump($cat);
    //var_dump($nbrArti);

    $nbrPages = floor($nbrArti / $nbrArtParPage)+1;

    for ($n=1; $n < ($nbrPages+1); $n++) {
      $cat->scrap_PageCategorie($n);
    }

    $this->listeCategories[] = $cat;
  //}
  }
  // ========================================




  // ========================================
}
