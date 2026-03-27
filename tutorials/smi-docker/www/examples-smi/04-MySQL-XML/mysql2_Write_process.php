<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>MySQL - Example 2 - Write</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>
        <h1 align="center">MySQL - Example 2 - Write - Process Form</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_INPUT_METHOD = INPUT_POST;
            $args = $_POST;
        } else {
            $_INPUT_METHOD = INPUT_GET;
            $args = $_GET;
        }

        $flags[] = FILTER_NULL_ON_FAILURE;

        $name = filter_input(
                $_INPUT_METHOD,
                'name',
                FILTER_UNSAFE_RAW,
                $flags);
        $email = filter_input(
                $_INPUT_METHOD,
                'email',
                FILTER_SANITIZE_EMAIL,
                $flags);

        $n = $args["name"];
        $e = $args['email'];

        if ($name === null || $name == "" || $email === null) {
            echo "Invalid arguments.";
            echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid e-mail format.";
            echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
            exit();
        }

        $host = "localhost";
        $port = 3306;
        $credentials = $host . ":" . $port;
        $userName = "smi";
        $password = "segredo";

        $dataBaseName = "smi";

        $linkIdentifier = mysqli_connect($credentials, $userName, $password);

        mysqli_set_charset($linkIdentifier, 'utf8');

        mysqli_select_db($linkIdentifier, "smi");

        $query = "INSERT INTO `$dataBaseName`.`email-contacts` " .
                "(`displayName`, `email`) values " .
                "('$name', '$email')";

        echo "Query issued: $query<br>\n";

        if (mysqli_query($linkIdentifier, $query) == false) {
            echo "Insert has failed. Details: \n<br>";
            $errorMsg = mysqli_error($linkIdentifier);
            $errorCode = mysqli_errno($linkIdentifier);
            echo "[$errorCode] $errorMsg\n<br>";
        } else {
            echo "Contact added with success.";
        }

        mysqli_close($linkIdentifier);
        ?>
        <br><a href="javascript: history.go(-1)">Back</a>
    </body>
</html>