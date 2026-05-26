<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>REST Client - BookStore - Results</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <script type="text/javascript" src="scripts/forms.js"></script>

    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
</head>

<body>

<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);

include_once "./CurlHelper.php";

// Determine input method (POST or GET)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_INPUT_METHOD = INPUT_POST;
} else {
    $_INPUT_METHOD = INPUT_GET;
}

$flags = [FILTER_NULL_ON_FAILURE];

// Validate the URI parameter
$uri = filter_input($_INPUT_METHOD, "uri", FILTER_SANITIZE_URL, $flags);

if ($uri === null) {
    echo "<p style='color:red;'>Invalid arguments.</p>";
    echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
    exit();
}

if (!filter_var($uri, FILTER_VALIDATE_URL)) {
    echo "<p style='color:red;'>Invalid URI format: <code>" .
        htmlspecialchars($uri) .
        "</code></p>";
    echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
    exit();
}

// Call the REST API to get the list of books
$result = CurlHelper::perform_http_request("GET", $uri);

if ($result === false) {
    echo "<p style='color:red;'>Error: Could not reach the BookStore service at <code>" .
        htmlspecialchars($uri) .
        "</code></p>";
    echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
    exit();
}

$bookList = json_decode($result, true);

if ($bookList === null) {
    echo "<p style='color:red;'>Error: Invalid JSON response from service.</p>";
    echo "<pre>" . htmlspecialchars($result) . "</pre>";
    echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
    exit();
}

$numberOfBooks = count($bookList);
?>

<h3>Available Books (<?php echo $numberOfBooks; ?>)</h3>

<!-- Hidden field to pass the base URI to AJAX calls -->
<input type="hidden" name="uri" value="<?php echo htmlspecialchars($uri); ?>">

<select
    name="bookList"
    size="<?php echo $numberOfBooks; ?>"
    onchange="BookSelected(this)">
    <?php foreach ($bookList as $currentBook) {
        $currentBookName = htmlspecialchars($currentBook["title"]);
        echo "<option value=\"$currentBookName\">$currentBookName</option>\n";
    } ?>
</select>

<table align="center" border="1">
    <tr>
        <td>
            <p>ISBN:</p>
            <div id="isbn"></div>

            <p>Price:</p>
            <div id="price"></div>

            <p>Quantity:</p>
            <div id="quantity"></div>
        </td>
        <td>
            <img id="image" src="" alt="Book cover" height="250">
        </td>
    </tr>
</table>

<br><hr><a href="javascript: history.go(-1)">Back</a>

</body>
</html>
