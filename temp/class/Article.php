<?php

/**
 *
 */

class Article
{

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $url;

  /**
   * @var string
   */
  public $description;

  /**
   * @var integer
   */
  public $ref;

  /**
   * @var string
   */
  public $refSite;

  /**
   * @var string
   */
  public $marque;

  /**
   * @var float
   */
  public $prix;

  /**
   * @var string
   */
  //    public $categorie;

  /**
   * @var array
   */
  public $tailles;

  /**
   * @var array
   */
  public $images;

  /**
   * @var array
   */
  public $stocks;


  // ------------------------

  /**
   * @var \Categorie[]
   */
  public $articles;

  // ========================================    
  function getName() {
    return $this->name;
  }

  function getUrl() {
    return $this->url;
  }

  function getDescription() {
    return $this->description;
  }

  function getRef() {
    return $this->ref;
  }

  function getRefSite() {
    return $this->refSite;
  }

  function getMarque() {
    return $this->marque;
  }

  function getPrix() {
    return $this->prix;
  }

  //  function getCategorie() {
  //    return $this->categorie;
  //  }

  function getTailles() {
    return $this->tailles;
  }

  function getImages() {
    return $this->images;
  }

  function getStocks() {
    return $this->stocks;
  }

  function getArticles() {
    return $this->articles;
  }

  // ========================================

  function setName($name) {
    $this->name = $name;
  }

  function setUrl($url) {
    $this->url = $url;
  }

  function setDescription($description) {
    $this->description = $description;
  }

  function setRef($ref) {
    $this->ref = $ref;
  }

  function setRefSite($refSite) {
    $this->refSite = $refSite;
  }

  function setMarque($marque) {
    $this->marque = $marque;
  }

  function setPrix($prix) {
    $this->prix = $prix;
  }

//  function setCategorie($categorie) {
//    $this->categorie = $categorie;
//  }

  function setTailles($tailles) {
    $this->tailles = $tailles;
  }

  function setImages($images) {
    $this->images = $images;
  }

  function setStocks($stocks) {
    $this->stocks = $stocks;
  }

  function setArticles(array $articles) {
    $this->articles = $articles;
  }

  // ========================================
  // ========================================

  public function scrap_pageArticle($url) {


    $this->setUrl($url);

    // Récupération du numéro ref (dans url lien de la page)    
    $urlExpl = explode("/", $url)[4];
    $ref     = explode('-', $urlExpl)[0];
    $ref     = intval($ref);
    $this->setRef($ref);

    $htmlPage = file_get_html($url);

    // Récupération du bloc principal de la page contenant les infos
    $urlBlock = $htmlPage->find('div[id=product_block]')[0];

    // Récupération du nom (div h1)
    $nom = $urlBlock->find('h1')[0]->plaintext;
    $nom = html_entity_decode($nom);
    $this->setName($nom);

    // Récupération du descriptif de l'article
    $descript = $htmlPage->find('div[id=desc_long]')[0]->plaintext;
    $descript = cleanString($descript);
    $this->setDescription($descript);
    // Espaces en trop dans le corps du texte à supprimer par la suite

    $refSite = $urlBlock->find('span[class=editable]')[0]->plaintext;
    $refSite = trim($refSite);
    $this->setRefSite($refSite);

    // Récupération du prix
    $prix = $urlBlock->find('span[id=our_price_display]')[0]->plaintext;
    $prix = trim($prix);
    $prix = str_replace("&#8364;", ".", $prix);
    $prix = floatval($prix);
    $this->setPrix($prix);

    // Récupération de la marque (dans le titre de la page)
    $marque = $htmlPage->find('head')[0]->children[0]->plaintext;
    $marque = explode("-", $marque)[0];
    $marque = trim($marque);
    $this->setMarque($marque);

    // Récupération de la catégorie (dans: "vous êtes ici:")
    //    $cat = $urlBlock->find('div[class=breadcrumb]')[0]->plaintext;
    //    $cat = explode(">", $cat)[1];
    //    $cat = trim($cat);
    //    $this->setCategorie($cat);
  
    // Récupération des tailles disponibles et stockage en array
    $taille     = $urlBlock->find('select[id=group_4]')[0]->plaintext;
    $taille     = trim($taille);
    $taille_tab = explode(" ", $taille);

    foreach ($taille_tab as $key => $value) {
      $taille_tab[$key] = trim($value);
    }
    $this->setTailles($taille_tab);

    // Récupération des URLs des images en array
    $img_block = $urlBlock->find('ul[id=thumbs_list_frame]')[0]->children;

    foreach ($img_block as $key => $block) {
      $img[] = $block->children[0]->attr['href'];
    }
    $this->setImages($img);
  }

  // ========================================
  }
