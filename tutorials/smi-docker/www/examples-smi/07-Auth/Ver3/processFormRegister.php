<?php
    require_once( "../../Lib/lib.php" );
    require_once( "../../Lib/db.php" );
    require_once ("../../06-Forms/regex.php");

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

    $username = trim((string)filter_input($_INPUT_METHOD, "username", FILTER_UNSAFE_RAW, $flags) ?? '');
    $password = trim(filter_input($_INPUT_METHOD, "password", FILTER_UNSAFE_RAW, $flags) ?? '');
    $email = trim(filter_input($_INPUT_METHOD, "email", FILTER_SANITIZE_EMAIL, $flags) ?? '');

    $serverName = filter_input(INPUT_SERVER, "SERVER_NAME", FILTER_UNSAFE_RAW, $flags);

    $serverPort = 8080;

    $name = webAppName();

    $baseUrl = "http://" . $serverName . ":" . $serverPort;

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


    if(!empty($errors)){
        $message = "<ul><li>".implode("</li><li>", $errors)."</li></ul>";
        redirectToLastPage("Registration Error", $message, 5);
        exit(0);
    }else{
        createInactiveUser($username, $password, $email);
    }

