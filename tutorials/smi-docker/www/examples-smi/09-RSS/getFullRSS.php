<?php

header('Content-Type: text/html; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $args = $_POST;
} elseif ($method == 'GET') {
    $args = $_GET;
}

$idNew = $args['idNew'];

if ($idNew == NULL) {
    echo "Invalid RSS";
    exit;
}

require_once( "../Lib/db.php" );

dbConnect(ConfigFile);

$db = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $db);

$queryNews = "SELECT * FROM `$db`.`rss-news` WHERE `idNew`='$idNew'";

$resultNews = mysqli_query($GLOBALS['ligacao'], $queryNews);

if ($resultNews == FALSE) {
    echo "No such RSS";
} else {
    $rssData = mysqli_fetch_array($resultNews);

    $rssContents = $rssData['contents'];

    echo $rssContents;
}

mysqli_free_result($resultNews);

dbDisconnect();
?>