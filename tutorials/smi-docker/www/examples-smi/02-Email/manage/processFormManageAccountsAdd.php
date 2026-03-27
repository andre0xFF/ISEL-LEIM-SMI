<?php
	ini_set('display_errors', 'On');
	   
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
    
    $accountName = filter_input( $_INPUT_METHOD, 'accountName', FILTER_SANITIZE_STRING, $flags);
    $smtpServer = filter_input( $_INPUT_METHOD, 'smtpServer', FILTER_SANITIZE_EMAIL, $flags);
    $useSSL = filter_input( $_INPUT_METHOD, 'useSSL', FILTER_SANITIZE_NUMBER_INT, $flags);
    $port = filter_input( $_INPUT_METHOD, 'port', FILTER_SANITIZE_NUMBER_INT, $flags);
    $timeout = filter_input( $_INPUT_METHOD, 'timeout', FILTER_SANITIZE_NUMBER_INT, $flags);
    $loginName = filter_input( $_INPUT_METHOD, 'loginName', FILTER_SANITIZE_STRING, $flags);
    $password = filter_input( $_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);
	$email = filter_input( $_INPUT_METHOD, 'email', FILTER_SANITIZE_EMAIL, $flags);
    $displayName = filter_input( $_INPUT_METHOD, 'displayName', FILTER_SANITIZE_STRING, $flags);

    if ( 
            $accountName == NULL || 
            $smtpServer == NULL || 
            $useSSL == NULL ||
            $port == NULL || filter_var( $port, FILTER_VALIDATE_INT, $flags)==FALSE ||
            $timeout == NULL || filter_var( $timeout, FILTER_VALIDATE_INT, $flags)==FALSE ||
            $loginName == NULL ||
			$password == NULL ||
            $email==NULL || filter_var( $email, FILTER_VALIDATE_EMAIL, $flags)==FALSE ||
            $displayName==NULL ) {
        redirectToLastPage( "Invalid fields" );
    }
    
    dbConnect( ConfigFile );
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $queryString = 
            "INSERT INTO `$dataBaseName`.`email-accounts` " .  
            "(`accountName`, `smtpServer`, `useSSL`, `port`, `timeout`, `loginName`, `password`, `email`, `displayName`) values " .
            "('$accountName', '$smtpServer', '$useSSL', '$port', '$timeout', '$loginName', '$password', '$email', '$displayName')";

    if ( mysqli_query( $GLOBALS['ligacao'], $queryString )==false ) {
        $msg = "Account creation has failed. Details: " . dbGetLastError();
    }
    else {
        $msg = "Account added with success.";
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