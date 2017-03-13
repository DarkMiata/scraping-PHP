<?php

require_once 'simple_html_dom.php';
require_once "DB_scrapping.php";

// but de l'exercice: scrapper le site internet laboutiqueofficielle.com
// et récupérer les articles 'robes' du site.
//
// http://www.laboutiqueofficielle.com/robes-jupes-129/
//
// Samuel Vermeulen
// 10/03/2017
//
// lecture d'une page
// 
// =======================================

function get_ArticleImgFile ($url, $fileName) {
  $PATH_URL_IMG     = "http://blzjeans.com";
  $PATH_LOCAL_IMG   = "file:///K:/wamp/www/scrapping_boutOff/img/";
  
  ?>
    <img src="<?php echo ($PATH_URL_IMG.$url); ?>"><br>
  <?php
  
  echo ("path url: "    .$PATH_URL_IMG    .$url       ."<br>");
  echo ("path local: "  .$PATH_LOCAL_IMG  .$fileName  ."<br>");
 
  // lecture/écriture des images des articles
  file_put_contents(
      $PATH_LOCAL_IMG.$fileName
      , file_get_contents($PATH_URL_IMG.$url)
      );
}
// =======================================



// =======================================

function test_scrap8() {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  $html = file_get_html($url);

  foreach ($html->find('li[class=product_list_block]') as $element) {

    $prixTab = $element->find('[class=price]');
    
    $prix = $prixTab[0]->plaintext;
    
    // remplace le '€' par un '.'
    $prix2 = str_replace("&#8364;", ".", $prix);
    echo "prix: '" .$prix2. "'<br>";
        
    // récupération de la marque/nom de l'article
    $nom = $element->find('[class=product_name]');
    
    $nomTxt = $nom[0]->plaintext;
    
    // séparation du nom et de la marque
    $marqueNomTab = explode(" - ", $nomTxt);
    
    // récupération de la marque et nom article et suppression des espaces indésirables
    $marque     = trim($marqueNomTab[0]);
    $nomArticle = trim($marqueNomTab[1]);
    
    echo ("marque: "        .$marque      ."<br>");
    echo ("nom article: "   .$nomArticle  ."<br>");
    
    $imgLink = $element->find('[class=product_img_link]');
    if ($imgLink === NULL) { echo "ImgLink Null<br>"; }
      else {
        
        // récupération du code 'onmouseout' du type '$('#photo_30853').attr('src','/30853-111574-produit/t-shirt-homme-blanc-avec-poche-effet-bomber.jpg')'
        $link = $imgLink[0]->children[0]->attr['onmouseout'];

        // séparation des différents éléments séparés par "'" et récupération du sixième
        $imgUrl= explode("'", $link)[5];
        echo ("img Url: '".$imgUrl."'<br>");
        
        // l'url est récupéré: séparation du chemin url séparé par '/' et récupération du troisième élément
        $imgFile = explode("/", $imgUrl)[2];

        echo ("'".$imgFile."'<br>");

        //get_ArticleImgFile($imgUrl);
        get_ArticleImgFile($imgUrl, $imgFile);
      }
     
    echo "<br>";
    echo "<br>=======================<br>";
  }
}

// =======================================
// =======================================

test_scrap8();
