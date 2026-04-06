<?php



$flags[] = FILTER_NULL_ON_FAILURE;

$method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_UNSAFE_RAW, $flags);

if ( $method=='POST') {
    $_INPUT_METHOD = INPUT_POST;
} elseif ( $method=='GET' ) {
    $_INPUT_METHOD = INPUT_GET;
}
else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}

$email = filter_input($_INPUT_METHOD, "email", FILTER_SANITIZE_EMAIL, $flags);
$email = trim($email !== null ? $email: '');

if($email === ''){
    $message = "An activation e-mail was sent. Please check your inbox and click the activation link.";
}else{
    $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $message = "An activation e-mail was sent to $safeEmail. Please check your inbox and click the activation link.";
}

?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Registration Pending</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../../Styles/auth.css">
    </head>
    <body>
        <h1>Registration Pending</h1>
        <p><?php echo $message; ?></p>
        <p><a href="formLogin.php">Go to login</a></p>
    </body>
</html>