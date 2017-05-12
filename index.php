<?php
require_once ("config/config.php");

$bdd = null;
$sqlConnexionState = FALSE;

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
function test_localsave() {

  define("LOCAL_SAVE_HTML", "D:/wamp64/www/Scraping/html_scrap/");

  loadAndSaveHTML("http://blzjeans.com/gilet-homme/29719-cape-navy-homme-et-tee-shirt-blanc.html", LOCAL_SAVE_HTML, FALSE);
}
// ------------------------
function test_localSaveAllArticles() {
  $array_url = DBScrap_getAllUrls();

  foreach ($array_url as $url) {
    loadAndSaveHTML($url['url'], LOCAL_SAVE_HTML, FALSE);
  }
}
// ------------------------
function test_localSaveImg() {
  $htmlFile = loadAndSaveHTML(
      "http://blzjeans.com/gilet-homme/29719-cape-navy-homme-et-tee-shirt-blanc.html",
      LOCAL_SAVE_HTML,
      TRUE);

  $article = new Article();

  $article->scrap_imgsArticle($htmlFile);
}
// ------------------------a
function test_scanUrlandSaveImgs() {
  $array_urls = DBScrap_getAllUrls();

  $art = new Article();

  foreach ($array_urls as $url) {
    //var_dump($url['url']);

    $htmlFile = file_get_html($url['url']);

    $art->scrap_imgsArticle($htmlFile);
  }
}

// ==================================================================
// ==================================================================
// boucle principale

set_time_limit(5000);

// 18

//test_scanUneCategorie(16);
//test_scanUneCategorie(15);
//test_scanUneCategorie(28);
//test_scanUneCategorie(21);
//test_scanUneCategorie(20);
//test_localSaveAllArticles();

test_scanUrlandSaveImgs();
