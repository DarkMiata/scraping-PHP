<?php

/**
 *
 */

// ================================

function cleanString ($string, $deep = 5) {
  $string = trim($string);
  $string = str_replace("\n", "", $string);
  $string = str_replace("\r", "", $string);
  $string = str_replace("\t", "", $string);
  for ($n = 1; $n < $deep; $n++) {
    $string = str_replace("  ", " ", $string);
  }
  
  return $string;
}