<?php
    require_once( "../../Lib/db.php");
    require_once( "../../Lib/lib.php");
  
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
    $referer = filter_input( INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING, $flags);
    
    if ( $referer==NULL ) {
        redirectToLastPage( "Invalid data", 5, "HTTP REFERER is missing" );
    }
    
    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        redirectToLastPage( "Invalid data", 5, "Invalid HTTP method (" . $method . ")" );
    }
    
    $accountId = filter_input( $_INPUT_METHOD, 'accountID', FILTER_SANITIZE_NUMBER_INT, $flags);

    if ( $accountId==NULL || filter_var( $accountId, FILTER_VALIDATE_INT, $flags)==FALSE) {
        redirectToLastPage( "Invalid fields" );
    }
    dbConnect( ConfigFile );

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = 
            "DELETE FROM `$dataBaseName`.`email-accounts` " .
            "WHERE `id`='$accountId'";

    if ( mysqli_query( $GLOBALS['ligacao'], $queryString )==false ) {
        $msg = "Delete has failed. Details: " . dbGetLastError();
    }
    else {
        $msg = "Account deleteded with success.";
    }

    dbDisconnect();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail accounts</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
    </head>
    <body>
        <p><?php echo $msg;?></p>
        
        <hr>
        <br><a href="<?php echo $referer;?>">Back</a>
    </body>
</html>