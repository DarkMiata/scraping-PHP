<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
</head>

<?php
require_once '/config/config.php';

define ("DEBUG", TRUE);

// but de l'exercice: scrapper le site internet blzjeans
// et récupérer les articles 'nouveautés' du site.
//
// Samuel Vermeulen
// 10/03/2017
// ==================================================================

function debug ($string) {
  if (DEBUG === TRUE) {
    echo ($string);
  }
}
// ==================================================================

// Affichage de l'image et sauvegarde dans le répertoire 'img'
function get_ArticleImgFile($url, $fileName) {
  $PATH_URL_IMG = "http://blzjeans.com";
  $PATH_LOCAL_IMG = "file:///K:/wamp/www/scrapping_boutOff/img/";

  echo "traitement image<br>";
  // lecture/écriture des images des articles si fichier n'existe pas
  if (file_exists($PATH_LOCAL_IMG . $fileName) === FALSE) {
    echo "écriture: " . $PATH_URL_IMG . $url . " => "
        . $PATH_LOCAL_IMG . $fileName . "<br>";

    file_put_contents(
        $PATH_LOCAL_IMG . $fileName
        , file_get_contents($PATH_URL_IMG . $url)
    );
  }
}
// ==================================================================
  
  function find_prixHtml($html) {
    $prixTab = $html->find('[class=price]');

    $prix = $prixTab[0]->plaintext;
    debug ($prix."<br>");
    //var_dump($prix);
    debug  ("<br>");
    
    // remplace le '€' par un '.'
    $prixFloat = str_replace("&#8364;", ".", $prix);
    
    return $prixFloat;
  }
// ==================================================================
 
// renvoi le nom et la marque
  function find_nomMarqueHtml($html) {
    // récupération de la marque/nom de l'article
    $nom = $html->find('[class=product_name]');
    
    $nomTxt = $nom[0]->plaintext;
    
    // séparation du nom et de la marque
    $Tab_marqueNom = explode(" - ", $nomTxt);
    
    $Tab_result['nom']    = trim($Tab_marqueNom[1]);
    $Tab_result['marque'] = trim($Tab_marqueNom[0]);
      
    return $Tab_result; 
}
// ==================================================================

// Renvoi le nom du fichier image et son Url
function find_imgLinkHtml($html) {
    $imgLink = $html->find('[class=product_img_link]');
    
    // récupération du code 'onmouseout' du type '$('#photo_30853').attr('src',
    // '/30853-111574-produit/t-shirt-homme-blanc-avec-poche-effet-bomber.jpg')'
    
    $link = $imgLink[0]->children[0]->attr['onmouseout'];

    // séparation des différents éléments séparés par "'" et récupération du sixième
    $tab_result['url'] = explode("'", $link)[5];
    
    // récupère le nom du répertoire contenant le numéro de référence
    $repertoireRef      = explode("/", $tab_result['url'])[1];
    
    // récupère le premier élément du nom du répertoire: le num référence
    $tab_result['ref']  = explode("-", $repertoireRef)[0];
    
    // l'url est récupéré: séparation du chemin url séparé par '/' et
    //  récupération du troisième élément    
    $tab_result['file'] = explode("/", $tab_result['url'])[2];
    
    return $tab_result;
}
// ==================================================================

// Récupère l'adresse url du lien de la page de l'article

function find_urlLinkHtml($html) {
    $imgLink = $html->find('[class=product_img_link]');
    
    // récupération du code 'onmouseout' du type '$('#photo_30853').attr('src',
    // '/30853-111574-produit/t-shirt-homme-blanc-avec-poche-effet-bomber.jpg')'
    
    debug($imgLink);
    
    $link = $imgLink[0]->children[0]->attr['href'];
    
    debug($link);
}
// ==================================================================

// Retourne sous forme d'array les blocs des articles
function get_blockArticle($urlHtml) {

  //$urlHtml ="http://blzjeans.com/new-products.php?n=4";
  $html = file_get_html($urlHtml);
  $block_array = $html->find('li[class=product_list_block]');    

  return $block_array;
}
// ==================================================================

// retourne sous forme d'array les link url et ref des articles.
/**
 * 
 * @param type $block_array - blocs des articles sous forme d'array
 */
function get_urlLink($block_array) {
  foreach ($block_array as $block) {

    //var_dump($block);

    // récupération de l'url du link
    $hrefUrl = $block->find('[href]')[0]->attr['href'];
    
    //var_dump($hrefUrl);
    //echo("================================");
    
    
    // Va chercher le num ref contenu dans le nom du fichier .html
    $temp['href'] = $hrefUrl;
    
    $linkHtmlFile = explode("/", $hrefUrl)[4];
    //var_dump($linkHtmlFile);
    
    $temp['ref'] = explode("-", $linkHtmlFile)[0];
    
    $result_array[] = $temp;
  }
  
  return $result_array;
}

// ==================================================================

// Fonction principale de récupération d'informations
function scrapPage($page) {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";
  //$url ="http://blzjeans.com/new-products.php?p=$page&from=top&n=120";
  
  $html = file_get_html($url);

  foreach ($html->find('li[class=product_list_block]') as $elementHtml) {

    $prix = find_prixHtml($elementHtml);
    debug ("prix: '" .$prix. "'<br>"); 
    // récupération de la marque et nom article et suppression des espaces indésirables
    
    $tab_result = find_nomMarqueHtml($elementHtml);
    
    // décodage pour les accents/symboles utf-8
    $marque     = html_entity_decode($tab_result['marque']);
    $nomArticle = html_entity_decode($tab_result['nom']);
    
    debug ("marque: "        .$marque      ."<br>");
    debug ("nom article: "   .$nomArticle  ."<br>");
    
    $tab_result = find_imgLinkHtml($elementHtml);
    
    $imgUrl   = $tab_result['url'];
    $imgFile  = $tab_result['file'];
    $ref      = $tab_result['ref'];

    debug ("ref: " .$ref. "<br>");
    
    get_ArticleImgFile($imgUrl, $imgFile);

    DB_add_article($nomArticle, $marque, $ref, $prix
        , $imgFile, $imgUrl);
    
    debug ("<br>=======================<br>");
    debug ("<br>");
  }
}
// ==================================================================

// Scanne les 10 premieres pages des nouveautés.
function scanPageNouveauxArticles() {

  set_time_limit (600);

  for ($page = 1; $page < 10; $page++) {
    echo "=============<br>";
    echo "page: $page<br>";
    scrapPage($page);
  }
}
// ==================================================================
/**
Exemple d'url: http://blzjeans.com/pull-homme/29831-pullover-fipullover-fin-homme-gris-chine-oversize-arrondie-celebry-tees.html
url de l'article ref 29831.
*/

/**
 * scanne la page d'un seul article et récupère ses infos.
 * @param type $ref
 */
function scanPageArticleUnitaire ($ref) {
  
}
// ==================================================================

function get_urlLink_to_DB ($urlPage) {
  
  $blockArticle_tab = get_blockArticle($urlPage);
  $urlLinkRef_tab   = get_urlLink($blockArticle_tab);
  
  //var_dump($urlLinkRef_tab);
  
  foreach ($urlLinkRef_tab as $article) {
    $ref  = $article['ref'];
    $href = $article['href'];
    
    var_dump($ref);
    var_dump($href);
    
    $reqSql = DB_getBlzLinkUrl($ref);
    echo("reqsql:");
    var_dump($reqSql);
    
    if ($reqSql === FALSE) {
      DB_setBlzHrefByRef($ref, $href);
      echo("reqsql false");
    }
    else { echo ("reqsql true"); }
  }
}
// ==================================================================
/**
 * Récupération des urls des types de produits sur la page principale
 * "http://blzjeans.com/" - "les produits"
 * 
 * 
 * @return type array - la liste des liens
 */

/*
function scanPagePrincipale () {
  
  //$urlMainPage    = "http://blzjeans.com/110-vetement-homme";
  $urlMainPage    = "page_principale_categorie.html";
  
  $htmlMainPage   = file_get_html($urlMainPage);
  
  // récup des deux menus: "catégories" et "marque"
  $block_menus = $htmlMainPage->find('ul[class=advcSearchList]');

  // dans le menu "catégories" on recherche les "li"
  $block_menuCat = $block_menus[0]->find('li');
  
  // dans chaque catégorie, rechercher le lien
  foreach ($block_menuCat as $cat) {
    
    //récup du lien
    $hrefCat  = $cat->find('[href]')[0]->attr['href'];
    
    // récup du nom de la catégorie
    $nomCat   = $cat->find('[href]')[0]->plaintext;
    $nomCat   = explode("(", $nomCat)[0];
    $nomCat   = trim($nomCat);
    
    $temp['href'] = $hrefCat;
    $temp['nom']  = $nomCat;
    
    $linkCat[] = $temp;
  }

  return $linkCat;
}
 */

// ==================================================================
/*
function nbrPagesListeArticle($url) {
  
  $html = file_get_html($url);
  
  $nbrPagesText = $html->find('[class=selectPage]')[0]->find('option')[0]->plaintext;
  $nbrPages = explode(' / ', $nbrPagesText)[1];
 
  return $nbrPages;
}
*/

// ==================================================================

function scanPagesListeArticles() {
  
  global $linkCat_array;
  
  foreach ($linkCat_array as $link) {

  $urlFirstPageArticles = $link['href'];
  var_dump($urlFirstPageArticles);
  
  $htmlFirstPageArticles = file_get_html($urlFirstPageArticles);
  }
  
  $nbrPages = nbrPagesListeArticle($htmlFirstPageArticles);
 
}

// ==================================================================
// ==================================================================
// boucle principale


$mainPage = new WebSite();

$mainPage->scanMainPage();

var_dump($mainPage->get_CatLink());



$urlPageArticle = "http://blzjeans.com/vetement-t-shirt-homme"
        . "/31024-t-shirt-gris-graphique-imprime-tete-de"
        . "-mort-homme-jack-and-jones.html";

$pageArticle = new Article();

$pageArticle->scanPageArticle($urlPageArticle);

var_dump($pageArticle);

