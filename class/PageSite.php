<?php

/**
 * Description of PageSite
 *
 * @author global
 */

class PageSiteCat {
  public    $url;
  private   $cat;
  private   $count;
  private   $listArticles = [];
  
// ==================================================================
// ==================================================================
  
  function set_count($count) {
    
    $countInt = intval($count);
    
    if (is_int($countInt) == TRUE and $countInt > 0) {
      $this->count = $countInt;
    } else {
      echo ("erreur 'set_count':".$countInt." n'est pas un entier<br>");
    }
  }

// ==================================================================

  function set_cat($cat) {
    $this->cat = $cat;
  }

// ==================================================================
// ==================================================================

  
  
// ==================================================================
}

