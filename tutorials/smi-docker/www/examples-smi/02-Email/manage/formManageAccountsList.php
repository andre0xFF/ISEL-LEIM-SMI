<?php
    require_once( "../../Lib/db.php" );
    
    dbConnect( ConfigFile );
                
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = "SELECT * FROM `$dataBaseName`.`email-accounts`"; 
    $result = mysqli_query( $GLOBALS['ligacao'], $queryString );
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail accounts</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/TableUsingDivs.css">
    </head>
  
    <body>
  
        <h2>List existing e-mail accounts</h2>

        <div align="center">
    <?php
      if ( $result==FALSE ) {
        echo "There are no accounts.";
      }
      else {
        echo "<div class=\"rTable\">\n";
        
        echo "  <div class=\"rTableRow\">\n";
        
        echo "    <div class=\"rTableHead\">Account Name</div>\n";
        echo "    <div class=\"rTableHead\">SMTP Server</div>\n";
        echo "    <div class=\"rTableHead\">Use SSL</div>\n";
        echo "    <div class=\"rTableHead\">Port</div>\n";
        echo "    <div class=\"rTableHead\">Timeout</div>\n";
        echo "    <div class=\"rTableHead\">Login Name</div>\n";
        echo "    <div class=\"rTableHead\">E-mail</div>\n";
        echo "    <div class=\"rTableHead\">Display Name</div>\n";
        
        echo "  </div>\n";

        while ( $accountData = mysqli_fetch_array( $result ) ) {
          $accountName  = $accountData[ 'accountName' ];
          $smtpServer   = $accountData[ 'smtpServer' ];
          $_useSSL       = $accountData[ 'useSSL' ];
          $port         = $accountData[ 'port' ];
          $timeout      = $accountData[ 'timeout' ];
          $login        = $accountData[ 'loginName' ];
          $fromEmail    = $accountData[ 'email' ];
          $fromName     = $accountData[ 'displayName' ];
          
          if ( $_useSSL==0 ) {
            $useSSL = "No";
          }
          else {
            $useSSL = "Yes";
          }

          echo "  <div class=\"rTableRow\">\n";
          
          echo "    <div class=\"rTableCell\">$accountName</div>\n";
          echo "    <div class=\"rTableCell\">$smtpServer</div>\n";
          echo "    <div class=\"rTableCell\">$useSSL</div>\n";
          echo "    <div class=\"rTableCell\">$port</div>\n";
          echo "    <div class=\"rTableCell\">$timeout</div>\n";
          echo "    <div class=\"rTableCell\">$login</div>\n";
          echo "    <div class=\"rTableCell\">$fromEmail</div>\n";
          echo "    <div class=\"rTableCell\">$fromName</div>\n";
          
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
        <p><span class='mainPageEntry'><a target="_top" href="./formManageAccounts.php">Back.</a></span></p>
    </body>
</html>