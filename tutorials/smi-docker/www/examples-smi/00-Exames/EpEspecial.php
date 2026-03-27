<?php

function goToPage($pageToGo, $debug) {
  if ( $debug == true ) {   
    echo "Vai ser redirecionado para a página $pageToGo";
  } 
  header( "Location: $pageToGo" );
}

?>