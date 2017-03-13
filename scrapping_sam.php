<?php

require_once 'simple_html_dom.php';

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
// $page = file_get_contents("http://www.developpez.com/");
//
// $url = 'http://www.google.fr/';
// echo htmlspecialchars(implode('', file($url)));
//$data = file_get_contents('http://mytemporalbucket.s3.amazonaws.com/code.txt');
//
//$dom = new domDocument;
//
//@$dom->loadHTML($data);
//$dom->preserveWhiteSpace = false;
//$tables = $dom->getElementsByTagName('table');
//
//$rows = $tables->item(1)->getElementsByTagName('tr');
//
//foreach ($rows as $row) {
//        $cols = $row->getElementsByTagName('td');
//        echo $cols[2];
//}
//
//$url ="http://www.laboutiqueofficielle.com/robes-jupes-129/";
//$url ="http://www.laboutiqueofficielle.com/robes-jupes-129/";
// http://simplehtmldom.sourceforge.net/
//*[contains(concat( " ", @class, " " ), concat( " ", "product_list_block", " " ))]
//$site ="http://www.oooff.com";
//$site = "https://www.google.fr/";
//$siteHtml = file_get_contents($site);
//
//echo($siteHtml);
//$siteXml = simplexml_load_string($siteHtml);
//$id = $xml->xpath("//*[@class='prix-produit']");
//var_dump($id);
//$url = "oooff.com";
//$ch = curl_init($url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$curl_scraped_page = curl_exec($ch);
//curl_close($ch);
//echo $curl_scraped_page;



function test_scrap1() {

  $source = file_get_contents("http://www.imdb.com/search/name?birth_monthday=11-24&refine=birth_monthday&ref_=nv_cel_brn_1");

  $dom = new DOMDocument();

  @$dom->loadHTML($source);

  $xpath = new DOMXPath($dom);

  $rows = $xpath->query("//tr[contains(@class, 'detailed')]/td[@class='name']/a");

  foreach ($rows as $index => $row) {
    echo ($index + 1) . ') ' . $row->textContent . '<br />';
  }
}

// =======================================
// récupération des prix de la page
function test_scrap2() {

  $url = "http://blzjeans.com/new-products.php?n=120";

  $source = file_get_contents($url);

  $dom = new DOMDocument();

  @$dom->loadHTML($source);

  $xpath = new DOMXPath($dom);

//  $rows = $xpath->query('//*[contains(concat( " ", @class, " " ), concat( " ", "price", " " ))]');
  $rows = $xpath->query('//*[contains(@class, "price")]');

  foreach ($rows as $index => $row) {
    echo ($index + 1) . ') ' . $row->textContent . '<br />';
  }
}

// =======================================
// récupération des prix de la page
function test_scrap3() {

  $url = "http://blzjeans.com/new-products.php?n=120";
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  var_dump($url);
  $source = file_get_contents($url);
  var_dump($source);
  $dom = new DOMDocument();
  var_dump($dom);
  @$dom->loadHTML($source);

  $xpath = new DOMXPath($dom);
  var_dump($xpath);
//  $rows = $xpath->query('//*[contains(concat( " ", @class, " " ), concat( " ", "price", " " ))]');
  $rows = $xpath->query('//*[contains(concat( " ", @class, " " ), concat( " ", "product_list_block", " " ))]');

  foreach ($rows as $index => $row) {
    echo ($index + 1) . ') ' . $row->nodeValue . '<br />';
    echo $row->item(0);
  }
}

// =======================================
// liste les éléments complets
function test_scrap4() {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  $html = file_get_html($url);

  foreach ($html->find('li[class=product_list_block]') as $element) {
    echo '-' . $element . '<br>';
    var_dump($element);
    echo "<br><br>=======================";
  }
}

// =======================================

function test_scrap5() {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  $html = file_get_html($url);



  foreach ($html->find('li[class=product_list_block]') as $element) {

    $prix = $element->find('[class=price]');
    echo "prix: '" . $prix[0] . "'<br>";

//    $marque = $element->find('h3');
//    echo "marque: ";
//    var_dump($element['brand']);
    echo "<br>";


    echo "<br>=======================<br>";
  }
}

// =======================================

function test_scrap6() {
  $html = file_get_html('https://slashdot.org/');

  //print_r($html);
// Find all article blocks
  foreach ($html->find('div.article') as $article) {
    $item['title'] = $article->find('div.title', 0)->plaintext;
    $item['intro'] = $article->find('div.intro', 0)->plaintext;
    $item['details'] = $article->find('div.details', 0)->plaintext;
    $articles[] = $item;
  }

  var_dump($articles[1]);
  //print_r($articles);
  //var_dump($articles);
}

// =======================================

function test_scrap7() {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  $html = file_get_html($url);



  foreach ($html->find('li[class=product_list_block]') as $element) {

    $prix = $element->find('span.price', 0)->plaintext;
    if ($prix != NULL)
      echo "prix: '" . $prix . "'<br>";

    $nom = $element->find('.brand', 0)->plaintext;
    if ($nom != NULL)
      echo "nom: '" . $nom . "'<br>";

    $img = $element->find('.product_img_link');
    if ($img != NULL) {
      $imgTxt = $img[0] . 'simple_html_dom_node';
      echo "imgTxt: " . var_dump($imgTxt);
      //$titre = $imgTxt->find('title');
      echo "titre: ";
      //var_dump($titre);
    }

    echo "<br>=======================<br>";
  }
}
// =======================================
//
//function trimUltime($chaine) {
//  $chaine = trim($chaine);
//  $chaine = str_replace("###antiSlashe###t", " ", $chaine);
//  $chaine = eregi_replace("[ ]+", " ", $chaine);
//  return $chaine;
//}

// =======================================

function test_scrap8() {
  $url = "file:///K:/wamp/www/scrapping_boutOff/scrapping_test.html";

  $html = file_get_html($url);

  foreach ($html->find('li[class=product_list_block]') as $element) {

    $prix = $element->find('[class=price]');
    echo "prix: '" . $prix[0] . "'<br>";
//
//    $marque = $element->find('[class=brand]');
//    echo "marque: '" . $marque[0]->plaintext . "'<br>";

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
    if ($imgLink == NULL) echo "ImgLink Null<br>";
      else {
        
        // récupération du code 'onmouseout' du type '$('#photo_30853').attr('src','/30853-111574-produit/t-shirt-homme-blanc-avec-poche-effet-bomber.jpg')'
        $link = $imgLink[0]->children[0]->attr['onmouseout'];

        // séparation des différents éléments séparés par "'" et récupération du sixième
        $sepLinkTxt = explode("'", $link)[5];
        
        // l'url est récupéré: séparation du chemin url séparé par '/' et récupération du troisième élément
        $imgName = explode("/", $sepLinkTxt)[2];

        echo ("'".$imgName."'");
      }
     
    echo "<br>";
    echo "<br>=======================<br>";
  }
}

// =======================================
// =======================================

test_scrap8();
