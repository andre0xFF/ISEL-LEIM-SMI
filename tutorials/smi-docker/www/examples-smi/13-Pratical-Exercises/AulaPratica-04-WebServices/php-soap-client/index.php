<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Accessing Web Services using PHP - Client Process</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link REL="stylesheet" TYPE="text/css" href="../../../Styles/GlobalStyle.css">
</head>

<body>

<?php
try {
    $wsdl = "https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL";

    $options = array('cache_wsdl' => WSDL_CACHE_NONE);

    $proxy = new SoapClient($wsdl, $options);

    $arg1 = array( "dNum" => 15.99 );

    $arg2 = array( "ubiNum" => 12344 );

    $operationName1 = "NumberToDollars";
    $operationName2 = "NumberToWords";

    $res1 = $proxy->NumberToDollars($arg1);
    $res2 = $proxy->NumberToWords($arg2);

    echo "\n<br>";


    echo $res1->NumberToDollarsResult;
    echo "<br>";

    echo  $res2->NumberToWordsResult;

    echo "<br>";


} catch (SoapFault $e) {
    echo "Could not execute WS. Cause:<br>\n";
    echo $e->faultstring . "<br>\n";
    echo $e->getTraceAsString() . "<br>\n";
}
?>

<br><hr><a href="javascript: history.go(-1)">Back</a>

</body>
</html>