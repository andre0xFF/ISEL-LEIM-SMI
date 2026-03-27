<?php
    require_once( "../../Lib/db.php" );
    require_once( "../../Lib/lib.php" );
    
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

    $id = filter_input( $_INPUT_METHOD, 'id', FILTER_SANITIZE_NUMBER_INT, $flags);
    $displayName = filter_input( $_INPUT_METHOD, 'displayName', FILTER_SANITIZE_STRING, $flags);
    $email = filter_input( $_INPUT_METHOD, 'email', FILTER_SANITIZE_EMAIL, $flags);
    
    if ( 
            $id == NULL || filter_var( $id, FILTER_VALIDATE_INT, $flags)==FALSE ||
            $displayName == NULL ||
            $email==NULL || filter_var( $email, FILTER_VALIDATE_EMAIL, $flags)==FALSE ) {
        redirectToLastPage( "Invalid fields" );
    }

    dbConnect( ConfigFile );
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $queryString =
            "UPDATE `$dataBaseName`.`email-contacts` " .
            "SET ".
                "`displayName`='$displayName', " .
                "`email`='$email' " .
            "WHERE `id`='$id'";
    
    mysqli_query( $GLOBALS['ligacao'], $queryString );
    
    $recordsInserted = mysqli_affected_rows( $GLOBALS['ligacao'] );
    
    dbDisconnect();
    
    if ( $recordsInserted==-1 ) {
    	$msg = "Contact update failed!";
    }
    else {
    	$msg = "Contact update succeded.";
    }    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail contacts</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
    </head>
    <body>
        <p><?php echo $msg;?></p>
        
        <hr>
        <br><a href="formManageContactsChange.php">Back</a>
    </body>
</html>