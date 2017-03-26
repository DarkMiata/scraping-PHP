<?php

/**
 * Description of PageSite
 *
 * @author global
 */

class PageSiteCat {
  public  $url;
  private  $cat;
  private $count;
  private $listArticles = [];
  
// ==================================================================
  
  function set_count($count) {
    
    $count = intval($count);
    
    if (is_int($count) == TRUE and $count > 0) {
      $this->count = $count;
    } else {
      echo ("erreur 'set_count':".$count." n'est pas un entier<br>");
    }
  }

// ==================================================================

  function set_cat($cat) {
    $this->cat = $cat;
  }

// ==================================================================

}

