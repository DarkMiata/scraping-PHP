<?php

// Configuration de la connexion à la base de données

define("DB_NAME", "vitrine");
define("DB_URL", "localhost");

// !!! à redéfinir en version final !!
define("DB_LOGIN", "root");
define("DB_PWD", "");

// ========================================

function DB_connexion() {
  $bdd_co = 'mysql:host=' . DB_URL
      . ';dbname=' . DB_NAME
      . ';charset=utf8';

  $bdd = new PDO($bdd_co, DB_LOGIN, DB_PWD);

  return $bdd;
}

// ========================================
function DB_ref_exit($ref) {
  $bdd = DB_connexion();

  $reqSql = $bdd->query(
          " SELECT ref"
          . " FROM blz"
          . " WHERE ref='$ref';"
      )->fetch();

  echo "reqsql ref exit";
  var_dump($reqSql);
  echo "<br>";
  
  return $reqSql;
}
// ========================================

function DB_add_article($nom, $marque, $ref, $prix, $img_fichier, $img_url) {

  $bdd = DB_connexion();

  if (DB_ref_exit($ref) === FALSE) {
  
    $reqSql = $bdd->query(
      " INSERT INTO blz"
      . " (nom, marque, ref, prix, img_fichier, img_url)"
      . " VALUES ('$nom', '$marque', '$ref', '$prix', '$img_fichier', '$img_url');"
      )->fetch();
  }
  else {
    echo "la ref $ref existe déjà dans la DB<br>";
    $reqSql = FALSE;
  }

  return $reqSql;
}

