<?php

    require_once("../../Lib/lib.php");

    $flags[] = FILTER_NULL_ON_FAILURE;

    $token = filter_input(INPUT_GET, 'token', FILTER_UNSAFE_RAW, $flags);
    $token = trim($token != null ? $token : '');

    $idUser = getUserIdByActivationToken($token);

    if($idUser === null){
        redirectToPage("formRegister.php", "Activation Error", "Could not activate account");
        exit(0);
    }

    $idRole = getIdRoleByName("user");

    if ($idRole === null) {
        redirectToPage("formRegister.php", "Activation Error", "Could not activate account.");
        exit(0);
    }

    if(userHasRole($idUser, $idRole)){

        $tokenDeleted = deleteActivationTokenByUserId($idUser);
        if(!$tokenDeleted){
            //TODO ideally log for admin
        }

        redirectToPage("formLogin.php", "Activation Success", "Your account is already activated.
         You will be redirected to the login page.");
        exit(0);
    }


    $activated = activateUserById($idUser);
    if(!$activated){
        redirectToPage("formRegister.php", "Activation Error", "Could not activate account");
        exit(0);
    }

    $assigned = assignRoleToUser($idUser, $idRole);


    if(!$assigned){
        $deactivated = deactivateUserById($idUser);

        if(!$deactivated){
            //TODO ideally log to admin
        }
        redirectToPage("formRegister.php", "Activation Error", "Could not activate account");

        exit(0);
    }

    $tokenDeleted = deleteActivationTokenByUserId($idUser);
    if(!$tokenDeleted){
        //TODO ideally log for admin
    }

    redirectToPage("formLogin.php", "Activation Success", "Your account was activated successfully.
     You will be redirected to the login page.");
    exit(0);