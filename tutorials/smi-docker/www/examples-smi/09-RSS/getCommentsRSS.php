<?php

header('Content-Type: text/html; charset=utf-8');

require_once( "../Lib/db.php" );
require_once( "../Lib/lib.php" );

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

dbConnect(ConfigFile);

$db = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $db);

$isFirst = true;

$queryComments = "SELECT * FROM `$db`.`rss-comments` WHERE `idNew`='$idNew'";

$resultComments = mysqli_query($GLOBALS['ligacao'], $queryComments);

while ($rssDataComments = mysqli_fetch_array($resultComments)) {

    if ($isFirst == true) {
        $isFirst = false;
    } else {
        echo "<hr>";
    }

    $commentsData = $rssDataComments['pubDate'];
    $commentsContents = $rssDataComments['contents'];

    echo "Date: " . $commentsData . "\n<br>";
    echo "Comment:\n<br>";
    echo "$commentsContents\n<br>";
}

mysqli_free_result($resultComments);

dbDisconnect();
?>