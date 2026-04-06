<?php

    require_once("../../Lib/lib.php");

    $flags[] = FILTER_NULL_ON_FAILURE;

    $token = filter_input(INPUT_GET, 'token', FILTER_UNSAFE_RAW, $flags);
    $token = trim($token != null ? $token : '');

    $idUser = getUserIdByActivationToken($token);

    if($idUser === null){
        redirectToLastPage("Activation Error", "Invalid activation token");
        exit(0);
    }

    $activated = activateUserById($idUser);
    if(!$activated){
        redirectToLastPage("Activation Error", "Could not activate account");
        exit(0);
    }

    $idRole = getIdRoleByName("user");

    if($idRole === null){
        $deactivated = deactivateUserById($idUser);
        if(!$deactivated){
            //TODO ideally log to admin
        }
        redirectToLastPage("Activation Error", "Could not activate account");
        exit(0);
    }

    $assigned = assignRoleToUser($idUser, $idRole);

    if(!$assigned){
        $deactivated = deactivateUserById($idUser);

        if(!$deactivated){
            //TODO ideally log to admin
        }
        redirectToLastPage("Activation Error", "Could not activate account");

        exit(0);
    }

    $tokenDeleted = deleteActivationTokenByUserId($idUser);
    if(!$tokenDeleted){
        //TODO ideally log for admin
    }

    header("Location: formLogin.php");
    exit(0);