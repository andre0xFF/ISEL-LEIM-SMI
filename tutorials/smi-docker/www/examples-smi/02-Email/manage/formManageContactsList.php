<?php
    require_once( "../../Lib/db.php" );
    
    dbConnect( ConfigFile );
                
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = "SELECT * FROM `$dataBaseName`.`email-contacts`"; 
    $result = mysqli_query( $GLOBALS['ligacao'], $queryString );
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail contacts</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/TableUsingDivs.css">
    </head>
  
    <body>
  
        <h2>List existing e-mail contacts</h2>

        <div align="center">
    <?php
      if ( $result==FALSE ) {
        echo "There are no contacts";
      }
      else {
        echo "<div class=\"rTable\">\n";
        
        echo "  <div class=\"rTableRow\">\n";
        
        echo "    <div class=\"rTableHead\">Display Name</div>\n";
        echo "    <div class=\"rTableHead\">E-mail</div>\n";
        
        echo "  </div>\n";

        while ( $contacData = mysqli_fetch_array( $result ) ) {
          $displayName  = $contacData[ 'displayName' ];
          $email   = $contacData[ 'email' ];

          echo "  <div class=\"rTableRow\">\n";
          
          echo "    <div class=\"rTableCell\">$displayName</div>\n";
          echo "    <div class=\"rTableCell\">$email</div>\n";
          
         echo "  </div>\n";
        }
        echo "  </div>\n";

        mysqli_free_result($result);

        dbDisconnect();
      }
?>
        </div>
        <p></p>
        <hr>
        <p><span class='mainPageEntry'><a target="_top" href="./formManageContacts.php">Back.</a></span></p>
    </body>
</html>
