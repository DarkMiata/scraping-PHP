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

function DB_add_article($nom, $prix, $description, $ref, $stock, $cat) {

  $bdd = DB_connexion();

  $reqSql = $bdd->query(
    " INSERT INTO produit"
    . " (nom, prix, description, ref, stock, cat)"
    . " VALUES ('$nom', '$prix', '$description'"
    . ", '$ref', '$stock', '$cat');"
    )->fetch();

  return $reqSql;
}

