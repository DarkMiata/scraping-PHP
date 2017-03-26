<?php

// ========================================
// Configuration de la connexion à la base de données

define("DB_NAME", "vitrine");
define("DB_URL", "localhost");

// !!! à redéfinir en version final !!
define("DB_LOGIN", "root");
define("DB_PWD", "");

// ========================================
// Routage des includes

define("PATH_INC"     , "inc/");
define("PATH_DB"      , "models/");
define("PATH_MODELS"  , "models/");
define("PATH_VIEW"    , "view/");
define("PATH_IMG"     , "img/");
define("PATH_CLASS"   , "class/");
define("PATH_LIB"     , "lib/");

// ========================================

define("URL_SITE"     , "page_principale_categorie.html");

// ========================================

require_once (PATH_MODELS . "DB_scraping.php");
require_once (PATH_LIB    . "simple_html_dom.php");

// ========================================

require_once (PATH_CLASS  . "PageSite.php");
require_once (PATH_CLASS  . "Article.php");
require_once (PATH_CLASS  . "WebSite.php");
