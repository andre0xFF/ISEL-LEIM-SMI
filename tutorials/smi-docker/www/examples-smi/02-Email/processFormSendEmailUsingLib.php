<?php
    require_once( "../Lib/lib.php");
    require_once( "../Lib/lib-mail-v2.php" );
    require_once( "../Lib/HtmlMimeMail.php" );
    require_once( "../Lib/db.php" );

    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_UNSAFE_RAW, $flags);
    $referer = filter_input( INPUT_SERVER, 'HTTP_REFERER', FILTER_UNSAFE_RAW, $flags);
    
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
    
    $Account = filter_input( $_INPUT_METHOD, 'Account', FILTER_SANITIZE_NUMBER_INT, $flags);
    $ToName = filter_input( $_INPUT_METHOD, 'ToName', FILTER_UNSAFE_RAW, $flags);
    $ToEmail = filter_input( $_INPUT_METHOD, 'ToEmail', FILTER_SANITIZE_EMAIL, $flags);
    $Subject = filter_input( $_INPUT_METHOD, 'Subject', FILTER_UNSAFE_RAW, $flags);
    $Message = filter_input( $_INPUT_METHOD, 'Message', FILTER_UNSAFE_RAW, $flags);
        
    if ( $ToName == NULL || $ToEmail == NULL || $Subject == NULL || $Message == NULL) {
        redirectToLastPage( "Invalid fields" );
    }
    
    $Debug = filter_input( $_INPUT_METHOD, 'Debug', FILTER_VALIDATE_BOOLEAN, $flags);
    $SendAsHTML = filter_input( $_INPUT_METHOD, 'SendAsHTML', FILTER_VALIDATE_BOOLEAN, $flags);  
    
    dbConnect( ConfigFile );
                
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = "SELECT * FROM `$dataBaseName`.`email-accounts` WHERE `id`='$Account'";
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );
    $record = mysqli_fetch_array( $queryResult );
        
    $smtpServer = $record[ 'smtpServer' ];
    $port = intval( $record[ 'port' ] );
    $useSSL = boolval( $record[ 'useSSL' ] );
    $timeout = intval( $record[ 'timeout' ] );
    $loginName = $record[ 'loginName' ];
    $password = $record[ 'password' ];
    $fromEmail = $record[ 'email' ];
    $fromName = $record[ 'displayName' ];
    
    mysqli_free_result( $queryResult );
    
    dbDisconnect();
    
    if ( $SendAsHTML==TRUE ) {
        /*
         * Read the files to attach.
         */
        
        $files[0]['Name'] = 'Example.zip';
        $files[0]['Type'] = 'application/octet-stream';
        
        $files[1]['Name'] = 'Example.png';
        $files[1]['Type'] = 'image/png';
        
        $files[2]['Name'] = 'Example.pdf';
        $files[2]['Type'] = 'application/octet-stream';
        
        $AttachDirectory = "attachs";
        for($i=0; $i<count($files);++$i) {
            $fileName = $AttachDirectory . DIRECTORY_SEPARATOR . $files[$i]['Name'];
            
            $fHandler = fopen( $fileName, 'rb' );
            $files[$i][ 'Contents' ] = fread( $fHandler, filesize( $fileName ) );
            fclose( $fHandler );
        }
        
        /*
         * Create the mail object.
         */
        $mail = new HtmlMimeMail();
        
        /*
         * HTML component of the e-mail
         */
$MessageHTML = <<<EOD
<html>
    <body style="background: url('background.gif') repeat;">
        <font face="Verdana, Arial" color="#FF0000">
            $Message
        </font>
    </body>
</html>
EOD;
        /*
         * Add the text, html and embedded images.
         */
        $mail->add_html( $MessageHTML, $Message);
        
        /*
         * Add the attachments to the email.
         */
        for($i=0; $i<count($files);++$i) {
            $mail->add_attachment( 
                    $files[$i]['Contents'], 
                    $files[$i]['Name'], 
                    $files[$i]['Type']);
        }
        
        /*
         * Builds the message.
         */
        $mail->build_message();
        
        /*
         * Sends the message.
         */
        $result = $mail->send(
              $smtpServer,
              $useSSL,
              $port,
              $loginName,
              $password,
              $ToName, 
              $ToEmail,
              $fromName, 
              $fromEmail,
              $Subject,
              "X-Mailer: Html Mime Mail Class");
    }
    else {
        $result = sendAuthEmail(
            $smtpServer,
            $useSSL,
            $port,
            $timeout,
            $loginName,
            $password,
            $fromEmail,
            $fromName,
            $ToName . " <" . $ToEmail . ">",
            NULL,
            NULL,
            $Subject,
            $Message,
            $Debug,  // set to true see debug messages
            NULL );
    }
    
    if ( $result==true ) {
        $userMessage = "was";
    }
    else {
        $userMessage = "could not be";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Send an e-mail using PHP SMTP library</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>
    <body>
        <p>E-mail <?php echo $userMessage;?> delivered to e-mail server.</p>
        
        <hr>
        <br><a href="<?php echo $referer;?>">Back</a>
    </body>
</html>
