<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Accessing Web Services using PHP - Calc Process</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script type="text/javascript" src="scripts/forms.js">
        </script>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>

        <?php
        ini_set('display_errors', 'On');

        error_reporting(E_ALL);

        include_once( './CurlHelper.php' );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_INPUT_METHOD = INPUT_POST;
        } else {
            $_INPUT_METHOD = INPUT_GET;
        }

        $flags[] = FILTER_NULL_ON_FAILURE;

        $uri = filter_input($_INPUT_METHOD, 'uri', FILTER_SANITIZE_URL, $flags);

        if ($uri === null) {
            echo "Invalid arguments.";
            echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
            exit();
        }

        if (!filter_var($uri, FILTER_VALIDATE_URL)) {
            echo "Invalid URI format.";
            echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
            exit();
        }

        $result = CurlHelper::perform_http_request("GET", $uri);

        $bookList = json_decode($result, true);
        $numberOfBooks = count($bookList);
        ?>

        <input type="hidden" name="uri" value="<?php echo $uri; ?>">

        <select 
            name="bookList" 
            size="<?php echo $numberOfBooks; ?>"
            onchange="BookSelected(this)" >
                <?php
                foreach ($bookList as $currentBook) {
                    $currentBookName = $currentBook["title"];
                    echo "      <option value=\"$currentBookName\">$currentBookName</option>\n";
                }
                ?>
        </select>

        <table align="center" border ="1">
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