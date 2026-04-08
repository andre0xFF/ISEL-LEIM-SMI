<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );
    require_once ("../../06-Forms/regex.php");
    require_once ("../../Lib/lib-mail-v2.php");

    session_start();


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

    $flags[] = FILTER_NULL_ON_FAILURE;

    $username = filter_input($_INPUT_METHOD, "username", FILTER_UNSAFE_RAW, $flags);
    $password = filter_input($_INPUT_METHOD, "password", FILTER_UNSAFE_RAW, $flags);
    $email = filter_input($_INPUT_METHOD, "email", FILTER_SANITIZE_EMAIL, $flags);
    $captcha = filter_input($_INPUT_METHOD, "captcha", FILTER_UNSAFE_RAW, $flags);



    $username = trim($username !== null ? $username: '');
    $password = trim($password !== null ? $password: '');
    $email = trim($email !== null ? $email: '');
    $captcha = trim($captcha !== null ? $captcha: '');



    $errors = array();

    // Input Validation
    if(!preg_match(toPhpRegex(ALIAS_REGEX), $username)){
        $errors[] = "Alias must have 3 to 15 letters, numbers or underscore";
    }

    if(!preg_match(toPhpRegex(PASS_REGEX), $password)){
        $errors[] = "Password must be between 6 and 15 characters, letters and numbers";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid Email format";
    }

    // duplicate check validation
    if(existUserField("name", $username, "basic")){
        $errors[] = "Username already exists";
    }
    if(existUserField("email",$email, "basic")){
        $errors[] = "Email already exists";
    }

    if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] !== $captcha) {
        $errors[] = "Invalid captcha code";
    }

    unset($_SESSION['captcha']);


    if(!empty($errors)){
        $message = "<ul><li>".implode("</li><li>", $errors)."</li></ul>";
        redirectToLastPage("Registration Error", $message, 5);
        exit(0);
    }else{
        $account = getEmailAccountById(2);
        if($account === null){
            redirectToLastPage("Registration Error", "No e-mail account configured.", 5);
            exit(0);
        }
        $idUser = createInactiveUser($username, $password, $email);

        if($idUser <= 0){
            redirectToLastPage("Registration Error", "Could not create user.",5);
            exit(0);
        }

        $token = createActivationToken($idUser);
        if($token === ''){
            deleteInactiveUserById($idUser);
            redirectToLastPage("Registration Error", "Could not create activation token");
            exit(0);
        }

        $activationUrl = getCurrentBaseUrl() . "/activateAccount.php?token=".urlencode($token);
        $subject = "Activate your account";
        $message = "Hello $username, \n\n"."Please activate your account using this link:\n".
            $activationUrl."\n\n"."If you did not request this registration, ignore this e-mail.";

        $emailSent = sendAuthEmail($account['smtpServer'],
            $account["useSSL"], $account['port'], $account['timeout'],
            $account['loginName'], $account['password'],$account['email'], $account['displayName'],
            "$username <$email>", null, null, $subject, $message, false, null);

        if(!$emailSent){
            deleteActivationTokenByUserId($idUser);
            deleteInactiveUserById($idUser);
            redirectToLastPage("Registration Error", "Could not send activation e-mail", 5);
            exit(0);
        }

    }

        header("Location: registerPending.php?email=" . urlencode($email));
        exit(0);

