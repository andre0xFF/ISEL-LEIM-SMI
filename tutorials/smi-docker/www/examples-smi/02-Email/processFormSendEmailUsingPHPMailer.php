<?php
    require_once( "../Lib/lib.php");
    require_once( "../Lib/db.php" );

    require_once( "../Lib/phpMailer/src/PHPMailer.php" );
    require_once( "../Lib/phpMailer/src/Exception.php" );
    require_once( "../Lib/phpMailer/src/SMTP.php" );
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

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
        
    $Debug = filter_input( $_INPUT_METHOD, 'Debug', FILTER_VALIDATE_BOOLEAN, $flags);
    $SendAsHTML = filter_input( $_INPUT_METHOD, 'SendAsHTML', FILTER_VALIDATE_BOOLEAN, $flags);
        
    $Account = filter_input( $_INPUT_METHOD, 'Account', FILTER_SANITIZE_NUMBER_INT, $flags);
    $ToName = filter_input( $_INPUT_METHOD, 'ToName', FILTER_UNSAFE_RAW, $flags);
    $ToEmail = filter_input( $_INPUT_METHOD, 'ToEmail', FILTER_SANITIZE_EMAIL, $flags);
    $Subject = filter_input( $_INPUT_METHOD, 'Subject', FILTER_UNSAFE_RAW, $flags);
    $Message = filter_input( $_INPUT_METHOD, 'Message', FILTER_UNSAFE_RAW, $flags);
        
    if ( $ToName == NULL || $ToEmail == NULL || $Subject == NULL || $Message == NULL) {
        redirectToLastPage( "Invalid fields" );
    }
    
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
	
    $mail = new PHPMailer;
	
    $mail->isSMTP();
	
    $mail->SMTPDebug = $Debug==FALSE ? SMTP::DEBUG_OFF : SMTP::DEBUG_LOWLEVEL;
	
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Host = $smtpServer;
    $mail->Port = $port;
	
    $mail->SMTPAuth = true;
    $mail->Username = $loginName;
    $mail->Password = $password;
    
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
	
    $mail->setFrom( $fromEmail, $fromName );
	
    $mail->addReplyTo( $fromEmail, $fromName );
	
    $mail->addAddress( $ToEmail, $ToName );
	
    $mail->Subject = $Subject; 
    $mail->Body = $Message;

    if ( $SendAsHTML==TRUE ) {
        $MessageHTML = <<<EOD
        <html>
            <body style="background: url('background.gif') repeat;">
                <font face="Verdana, Arial" color="#FF0000">
                    $Message
                </font>
            </body>
        </html>
        EOD;

        $mail->msgHTML( $MessageHTML );
        
        $mail->addAttachment( 'attachs/Example.zip' );
        $mail->addAttachment( 'attachs/Example.png' );
        $mail->addAttachment( 'attachs/Example.pdf' );
    }

    if ( !$mail->send() ) {
        echo "Mailer Error: ". $mail->ErrorInfo;
        $userMessage = "could not be";
    }
    else {
        echo "The email message was sent!";
        $userMessage = "was";
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
