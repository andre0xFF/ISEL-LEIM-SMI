<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$videoName = $_GET[ "videoName" ];
$modeSprite = $_GET[ "mode" ];

$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['SCRIPT_NAME']) . "/";

if ( $modeSprite=="true" ) {
	header( 'Location: ' . $baseURL . "VTT/Thumbs/" . $videoName . "-thumbs-sprite.vtt" );
}
else {
	header( 'Location: ' . $baseURL . "VTT/Thumbs/" . $videoName . "-thumbs.vtt" );
}

?>