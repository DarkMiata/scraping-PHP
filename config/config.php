<?php

// ========================================
// Configuration de la connexion à la base de données

define ("DB_NAME", "vitrine");
define ("DB_URL", "localhost");

// !!! à redéfinir en version final !!
define ("DB_LOGIN"  , "root");
define ("DB_PWD"    , "");

define ("DB_CAT"    , "scrap_categorie");
define ("DB_ART"    , "scrap_articles");

// ========================================
// Routage des includes

define ("PATH_INC"     , "inc/");
define ("PATH_DB"      , "models/");
define ("PATH_MODELS"  , "models/");
define ("PATH_VIEW"    , "view/");
define ("PATH_IMG"     , "img/");
//define("PATH_CLASS"   , "class/");
define ("PATH_CLASS"   , "temp/class/");
define ("PATH_LIB"     , "lib/");

// ========================================

require_once (PATH_MODELS . "DB.php");
require_once (PATH_MODELS . "DB_blz.php");
require_once (PATH_MODELS . "DB_scrap.php");

require_once (PATH_LIB    . "simple_html_dom.php");
require_once (PATH_LIB    . "darkmiata_lib.php");
require_once (PATH_LIB    . "scrap.php");

// ========================================
/**
require_once (PATH_CLASS  . "PageSite.php");
require_once (PATH_CLASS  . "Article.php");
require_once (PATH_CLASS  . "WebSite.php");
**/

require_once (PATH_CLASS . "Article.php");
require_once (PATH_CLASS . "Categorie.php");
require_once (PATH_CLASS . "WebSite.php");
