<?php

// ========================================
// Configuration de la connexion à la base de données

define ("DB_NAME", "vitrine");
define ("DB_URL", "localhost");

// !!! à redéfinir en version final !!
define ("DB_LOGIN"  , "root");
define ("DB_PWD"    , "");

define ("DB_CAT"    , "scrap_categories");
define ("DB_ART"    , "scrap_articles");

define ("URL_SITE"  , "http://blzjeans.com/110-vetement-homme");

$sqlConnexionState = FALSE;

// ========================================
// Routage des includes

define ("PATH_INC"        , "inc/");
define ("PATH_DB"         , "models/");
define ("PATH_MODELS"     , "models/");
define ("PATH_VIEW"       , "view/");
define ("PATH_CONTROL"    , "controllers/");
define ("PATH_IMG"        , "img/");
define ("PATH_CLASS"      , "class/");
//define ("PATH_CLASS"   , "temp/class/");
define ("PATH_LIB"        , "lib/");
define ("PATH_LOCAL_IMG"  , "D:/wamp64/www/Scraping/img/");
define ("LOCAL_SAVE_HTML" , "D:/wamp64/www/Scraping/html_scrap/");

// ========================================

require_once (PATH_MODELS . "DB.php");
require_once (PATH_MODELS . "DB_blz.php");
require_once (PATH_MODELS . "DB_scrap.php");

require_once (PATH_LIB      . "simple_html_dom.php");
require_once (PATH_LIB      . "darkmiata_lib.php");
//require_once (PATH_LIB      . "drk_logger.php");

require_once (PATH_CONTROL  . "scrap.php");

// ========================================
/**
require_once (PATH_CLASS  . "PageSite.php");
require_once (PATH_CLASS  . "Article.php");
require_once (PATH_CLASS  . "WebSite.php");
**/

require_once (PATH_CLASS . "Article.php");
require_once (PATH_CLASS . "Categorie.php");
require_once (PATH_CLASS . "WebSite.php");
