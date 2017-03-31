<?php

require_once 'config/config.php';

// ========================================
/**
 * DB_CAT
 *  id
 *  name
 *  url
 *  countArticles

  DB_ART
 *  id
 *  name
 *  url
 *  description
 *  ref
 *  refsite
 *  marque
 *  prix
 *  categorie_id
 *  tailles_id
 *  images_id
 *  stocks_id
 */
// ========================================

function DB_get_catIdByName($name) {

  $bdd = DB_connexion();

  $reqSql = $bdd->query(
          " SELECT id"
          . " FROM " . DB_CAT
          . " WHERE name='$name';"
      )->fetch();

  return $reqSql;
}

// ------------------------

function DB_hydr_categorie($name, $url, $cntArt) {

  $bdd = DB_connexion();

  $reqSqlTxt = " INSERT INTO " . DB_CAT
      . " (name, url, countArticles)"
      . " VALUES ('$name', '$url', '$cntArt');"
  ;

  $reqSql = $bdd->query($reqSqlTxt);

  if ($reqSql == FALSE) {
    echo("erreur DB_hydr_categorie<br>");
    echo("requete: " . $reqSqlTxt);
    return FALSE;
  }
  else {
    return TRUE;
  }
}

// ------------------------

function DB_hydr_article($name, $url, $description
, $ref, $refsite, $marque, $prix, $cat_id, $cat_name) {

  $bdd = DB_connexion();

  $description = addslashes($description);

  $reqSqlTxt = " INSERT INTO " . DB_ART
      . " (name, url, description, ref, "
      . "refsite, marque, prix, categorie_id, cat_name)"
      . " VALUES ("
      . "'$name', '$url', '$description', '$ref'"
      . ", '$refsite', '$marque', '$prix', '$cat_id', '$cat_name'"
      . ");";

  $reqSql = $bdd->query($reqSqlTxt);

  if ($reqSql == FALSE) {
    echo("erreur DB_hydr_article<br>");
    echo("requete: " . $reqSqlTxt);
    return FALSE;
  }
  else {
    return TRUE;
  }
}

// ------------------------

function DB_get_catById($id) {

  $bdd = DB_connexion();

  $reqSqlTxt = "SELECT *"
      . " FROM " . DB_CAT
      . " WHERE id='$id';";

  $reqSql = $bdd->query($reqSqlTxt)->fetchall();

  if ($reqSql == FALSE) {
    echo("erreur DB_get_catById<br>");
    echo("requete: " . $reqSqlTxt);
    return FALSE;
  }
  else {
    return $reqSql;
  }
}

// ------------------------

function DB_is_ArticleByUrl($url) {

  $bdd = DB_connexion();

  $reqSqlTxt = "SELECT 1"
      . " FROM " . DB_ART
      . " WHERE url='$url';";

  $reqSql = $bdd->query($reqSqlTxt)->fetch();

  var_dump($reqSql);

  if ($reqSql == FALSE) {
    return FALSE;
  }
  else {
    return TRUE;
  }
}

// ========================================

