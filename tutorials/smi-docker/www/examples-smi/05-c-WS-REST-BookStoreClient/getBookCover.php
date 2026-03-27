<?php

ini_set('display_errors', 'On');

error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
} else {
    $_INPUT_METHOD = INPUT_GET;
}

$flags[] = FILTER_NULL_ON_FAILURE;

$uri = filter_input($_INPUT_METHOD, 'uri', FILTER_SANITIZE_URL, $flags);
$bookISBN = filter_input($_INPUT_METHOD, 'bookISBN', FILTER_UNSAFE_RAW, $flags);
$flags[] = FILTER_NULL_ON_FAILURE;

if ($uri === null || $bookISBN === null) {
    exit();
}

include_once( './CurlHelper.php' );

$uriWithArgs = $uri . "/book/cover/" . rawurlencode($bookISBN);

$result = CurlHelper::perform_http_request("GET", $uriWithArgs);

echo $result;
?>
