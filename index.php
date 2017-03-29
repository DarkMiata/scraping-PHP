<?php
require_once '/config/config.php';

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

// ==================================================================
// ==================================================================
// boucle principale

//scanCatAndArticles();

DB_hydrate_categorie("test", "http://test.com", 5);
