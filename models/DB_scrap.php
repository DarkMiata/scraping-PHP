<?php
require_once '/config/config.php';

// ========================================
/**
 * DB_CAT
 *  id
 *  name
 *  url
 *  count_articles

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
function DB_is_categorie(Categorie $cat) {

  $bdd = DB_connexion();

  $name = $cat->get_name();

  $reqSql = $bdd->query(
          " SELECT id"
          . " FROM " . DB_CAT
          . " WHERE name='$name';"
      )->fetch();

  var_dump($reqSql);

  //return $bool;
}
// ========================================

function DB_hydrate_categorie($name, $url, $cntArt) {

    $bdd = DB_connexion();

    $reqSql = $bdd->query(
        " INSERT INTO " . DB_CAT
        . " (name, url, count_articles)"
        . " VALUES ('$name', '$url', '$cntArt');"
        );

    echo("requete sql hydrate: ");
    var_dump($reqSql);
}

