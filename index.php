<?php
require_once ("config/config.php");

define ("DEBUG", TRUE);

// but de l'exercice: scrapper le site internet blzjeans
// et récupérer les articles 'nouveautés' du site.
//
// Samuel Vermeulen
// 10/03/2017
//
// modif 29/03/2017
//
// v3.0

// ==================================================================

function debug ($string) {
  if (DEBUG === TRUE) {
    echo ($string);
  }
}
// ========================================

function scanCatAndArticles() {

  $mainPage = new WebSite();
  $mainPage->scrap_catsFromWebSite();

  $mainPage->scrap_Categories();

  var_dump($mainPage);
}
// ========================================

function test_scanUnArticle() {

  $article = new Article();

  $url = "http://blzjeans.com/vetement-t-shirt-homme/31115-tee-shirt-homme-rose-imprime-jack-and-jones.html";

  $article->scrap_pageArticle($url);
  $article->to_DB();
}
// ------------------------

function test_scanUneCategorie($catId) {

  $cat = DB_get_catById($catId);

  $categorie = new Categorie();
  $categorie->hydrateFromArray($cat[0]);

  $nbrArticles  = $categorie->get_countArticles();
  $nbrPages     = floor($nbrArticles / 30)+1;

  for ($n=1; $n < ($nbrPages+1); $n++) {
    $categorie->scrap_PageCategorie($n);
  }

}


// ==================================================================
// ==================================================================
// boucle principale

test_scanUneCategorie(17);




