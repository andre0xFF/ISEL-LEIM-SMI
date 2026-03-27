<?php

require_once( "../Lib/db.php" );
require_once( "../Lib/lib.php" );

$ServerName = $_SERVER['SERVER_NAME'];
$ServerPort = $_SERVER['SERVER_PORT'];

$name = webAppName();

dbConnect(ConfigFile);

$db = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $db);

$queryNews = "SELECT * FROM `$db`.`rss-news`";

$resultNews = mysqli_query($GLOBALS['ligacao'], $queryNews);

$BaseLink = $ServerName . ":" . $ServerPort . $name;

$BaseSchemma = "http://";

$LinkFQ = $BaseSchemma . $BaseLink;

if ($resultNews == FALSE) {
    echo "Couldn't read RSS's";
} else {

    $rss = "";

    $rss .= "<?xml version='1.0' encoding='utf-8'?>\n";
    $rss .= "<rss version='2.0'>\n";
    $rss .= "<channel>\n";
    $rss .= "<generator>Built with PHP</generator>\n";
    $rss .= "<title>RSS for SMI</title>\n";
    $rss .= "<link>" . $LinkFQ . "</link>\n";
    $rss .= "<description>News with PHP</description>\n";
    $rss .= "<language>pt-pt</language>\n";

    $rss .= "<image>\n";
    $rss .= "<title>PHP</title>\n";
    $rss .= "<link>" . $LinkFQ . "</link>\n";
    $rss .= "<url>" . $LinkFQ . "images/xml.gif</url>\n";
    $rss .= "<width>36</width>\n";
    $rss .= "<height>14</height>\n";
    $rss .= "</image>\n";

    $contents = "";

    while ($rssData = mysqli_fetch_array($resultNews)) {
        $contents .= "<item>\n";
        $contents .= "<title>" . $rssData['title'] . "</title>\n";
        $contents .= "<author>" . $rssData['author'] . "</author>\n";
        $contents .= "<description>" . $rssData['description'] . "</description>\n";
        $contents .= "<pubDate>" . $rssData['pubDate'] . "</pubDate>\n";
        $contents .= "<link>" . $LinkFQ . "getFullRSS.php?idNew=" . $rssData['idNew'] . "</link>\n";
        $contents .= "<comments>" . $LinkFQ . "getCommentsRSS.php?idNew=" . $rssData['idNew'] . "</comments>\n";
        $contents .= "</item>\n";
    }

    mysqli_free_result($resultNews);

    dbDisconnect();

    $rss .= $contents;

    $rss .= "</channel>\n</rss>";

    $browser = getBrowser();
    //$userAgent = $_SERVER['HTTP_USER_AGENT'];
    //echo "User Agent: " . $userAgent . "\n";
    //echo "Browser: " . $browser . "\n";

    if ($browser == "Internet Explorer") {
        header('Content-type: application/rss+xml; charset=utf-8');
    } else {
        header('Content-type: text/xml; charset=utf-8');
    }

    header('Content-Length: ' . strlen($rss));

    echo $rss;
}
?>