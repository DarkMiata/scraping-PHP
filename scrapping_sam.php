<?php

require_once 'simple_html_dom.php';
require_once "DB_scraping.php";

define ("DEBUG", FALSE);

// but de l'exercice: scrapper le site internet blzjeans
// et récupérer les articles 'nouveautés' du site.
//
// Samuel Vermeulen
// 10/03/2017
// =======================================

function debug ($string) {
  if (DEBUG === TRUE) {
    echo ($string);
  }
}
// =======================================

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
// =======================================
  
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
// =======================================
 
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
// =======================================

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
// =======================================

function scrapPage($page) {
  //$url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";
  $url ="http://blzjeans.com/new-products.php?p=$page&from=top&n=120";
  
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
// =======================================
// =======================================
// boucle principale

// 
set_time_limit (600);

for ($page = 1; $page < 10; $page++) {
  echo "=============<br>";
  echo "page: $page<br>";
  scrapPage($page);
}
