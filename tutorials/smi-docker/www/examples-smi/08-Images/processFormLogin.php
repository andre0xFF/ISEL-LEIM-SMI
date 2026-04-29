<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );

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

    $username = filter_input( $_INPUT_METHOD, 'username', FILTER_UNSAFE_RAW, $flags);
    $password = filter_input( $_INPUT_METHOD, 'password', FILTER_UNSAFE_RAW, $flags);


    $idUser = isValid($username, $password, "basic");

    if ( $idUser>0 ) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $idUser;


        $nextUrl = isset($_SESSION['locationAfterAuth']) ? $_SESSION['locationAfterAuth'] : 'list.php';

        unset($_SESSION['locationAfterAuth']);

        header( "Location: "  . $nextUrl );
        exit(0);
    }


    header("Location: formLogin.php");
    exit(0);
?>
