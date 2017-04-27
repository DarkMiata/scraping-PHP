<?php

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
// ------------------------
