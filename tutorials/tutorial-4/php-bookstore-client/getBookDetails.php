<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

// Determine input method (POST or GET)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_INPUT_METHOD = INPUT_POST;
} else {
    $_INPUT_METHOD = INPUT_GET;
}

$flags = [FILTER_NULL_ON_FAILURE];

$uri = filter_input($_INPUT_METHOD, "uri", FILTER_SANITIZE_URL, $flags);
$bookName = filter_input($_INPUT_METHOD, "bookName", FILTER_UNSAFE_RAW, $flags);

if ($uri === null || $bookName === null) {
    http_response_code(400);
    exit();
}

include_once "./CurlHelper.php";

// Build the URL: {baseUri}/book/by/title/{bookName}
$uriWithArgs = $uri . "/book/by/title/" . rawurlencode($bookName);

// Forward the response from the REST API directly to the browser
echo CurlHelper::perform_http_request("GET", $uriWithArgs);
?>
