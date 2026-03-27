<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$videoName = $_GET[ "videoName" ];

$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['SCRIPT_NAME']) . "/";

header( 'Location: ' . $baseURL . "Thumbs/" . $videoName . "-sprite.png" );

?>