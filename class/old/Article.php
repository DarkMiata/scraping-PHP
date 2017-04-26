<?php

/**
 * Description of Article
 *
 * @author global
 */

class Article {
  
  private $ref;
  private $refSite;
  private $nom;
  private $marque;
  private $prix;
  private $pageSite;
  private $categorie;
  private $description;
  private $tailles  = [];
  private $stocks   = [];
  private $listImgs = [];
  // ==================================================================
  // ==================================================================

  function get_ref() {
    return $this->ref;
  }
  // ------------------------------
  function get_nom() {
    return $this->nom;
  }
  // ------------------------------
  function get_marque() {
    return $this->marque;
  }
  // ------------------------------
  function get_prix() {
    return $this->prix;
  }
  // ------------------------------
  function get_pageSite() {
    return $this->pageSite;
  }
  // ------------------------------
  function get_categorie() {
    return $this->categorie;
  }
  // ------------------------------
  function get_tailles() {
    return $this->tailles;
  }
  // ------------------------------
  function get_stocks() {
    return $this->stocks;
  }
  // ------------------------------
  function get_listImgs() {
    return $this->listImgs;
  }
  // ------------------------------
  function get_description() {
    return $this->description;
  }
  // ------------------------------
  function get_refSite() {
    return $this->refSite;
  }
  // ==================================================================

  function set_ref($ref) {
    $this->ref = $ref;
  }
  // ------------------------------
  function set_nom($nom) {
    $this->nom = $nom;
  }
  // ------------------------------
  function set_marque($marque) {
    $this->marque = $marque;
  }
  // ------------------------------
  function set_prix($prix) {
    $this->prix = $prix;
  }
  // ------------------------------
  function set_pageSite($pageSite) {
    $this->pageSite = $pageSite;
  }
  // ------------------------------
  function set_categorie($categorie) {
    $this->categorie = $categorie;
  }
  // ------------------------------
  function set_tailles($tailles) {
    $this->tailles = $tailles;
  }
  // ------------------------------
  function set_stocks($stocks) {
    $this->stocks = $stocks;
  }
  // ------------------------------
  function set_listImgs($listImgs) {
    $this->listImgs = $listImgs;
  }
  // ------------------------------
  function set_description($description) {
    $this->description = $description;
  }
  // ------------------------------
  function set_refSite($refSite) {
    $this->refSite = $refSite;
  }
  // ==================================================================
  // ==================================================================
  // Méthodes
 
  public function scanPageArticle ($url) {
    
    $this->set_pageSite($url);
    
    // Récupération du numéro ref (dans url lien de la page)    
    $urlExpl  = explode("/", $url)[4];
    $ref      = explode('-', $urlExpl)[0];
    $ref      = intval($ref);
    $this->set_ref($ref);
    
    $htmlPage = file_get_html($url);
    
    // Récupération du bloc principal de la page contenant les infos
    $urlBlock = $htmlPage->find('div[id=product_block]')[0];
    
    // Récupération du nom (div h1)
    $nom = $urlBlock->find('h1')[0]->plaintext;
    $nom = html_entity_decode($nom);
    $this->set_nom($nom);
    
    // Récupération du descriptif de l'article
    $descript = $htmlPage->find('div[id=desc_long]')[0]->plaintext;
    $descript = cleanString($descript);
    $this->set_description($descript);
    // Espaces en trop dans le corps du texte à supprimer par la suite
    
    $refSite = $urlBlock->find('span[class=editable]')[0]->plaintext;
    $refSite = trim($refSite);
    $this->set_refSite($refSite);
    
    // Récupération du prix
    $prix = $urlBlock->find('span[id=our_price_display]')[0]->plaintext;
    $prix = trim($prix);
    $prix = str_replace("&#8364;", ".", $prix);
    $prix = floatval($prix);  
    $this->set_prix($prix);
    
    // Récupération de la marque (dans le titre de la page)
    $marque = $htmlPage->find('head')[0]->children[0]->plaintext;
    $marque = explode("-", $marque)[0];
    $marque = trim($marque);
    $this->set_marque($marque);
    
    // Récupération de la catégorie (dans: "vous êtes ici:")
    $cat = $urlBlock->find('div[class=breadcrumb]')[0]->plaintext;
    $cat = explode(">", $cat)[1];
    $cat = trim($cat);
    $this->set_categorie($cat);
    
    // Récupération des tailles disponibles et stockage en array
    $taille       = $urlBlock->find('select[id=group_4]')[0]->plaintext;
    $taille       = trim($taille);
    $taille_tab   = explode(" ", $taille);
    
    foreach ($taille_tab as $key => $value) {
      $taille_tab[$key] = trim($value);
    }
    $this->set_tailles($taille_tab);
    
    // Récupération des URLs des images en array
    $img_block  = $urlBlock->find('ul[id=thumbs_list_frame]')[0]->children;
    
    foreach ($img_block as $key => $block) {
      $img[] = $block->children[0]->attr['href'];      
    }
    $this->set_listImgs($img);    
  } 
    // ==================================================================
}
