<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>SOAP Client - NumberConversion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
</head>

<body>

<h2>SOAP Client &mdash; NumberConversion</h2>

<?php try {
    $wsdl =
        "https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL";

    $options = ["cache_wsdl" => WSDL_CACHE_NONE];

    $proxy = new SoapClient($wsdl, $options);

    // Show available operations
    echo "<h3>Available Operations</h3>";
    echo "<pre>";
    print_r($proxy->__getFunctions());
    echo "</pre>";

    // --- NumberToDollars ---
    $dollarValue = 15.99;
    $arg1 = ["dNum" => $dollarValue];
    $result1 = $proxy->NumberToDollars($arg1)->NumberToDollarsResult;

    // --- NumberToWords ---
    $numberValue = 12344;
    $arg2 = ["ubiNum" => $numberValue];
    $result2 = $proxy->NumberToWords($arg2)->NumberToWordsResult;

    // Display results
    echo "<h3>Results</h3>";
    echo "WSDL: <code>$wsdl</code><br><br>";
    echo "NumberToDollars($dollarValue) = <strong>$result1</strong><br>";
    echo "NumberToWords($numberValue) = <strong>$result2</strong><br>";
} catch (SoapFault $e) {
    echo "<p style='color:red;'>Could not execute WS. Cause:<br>\n";
    echo $e->faultstring . "<br>\n";
    echo $e->getTraceAsString() . "</p>\n";
} ?>

<br><hr><a href="javascript: history.go(-1)">Back</a>

</body>
</html>
