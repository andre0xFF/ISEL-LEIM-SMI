<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Accessing Web Services using PHP - Client Process</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
    </head>

    <body>

        <?php
        try {
            $wsdl = "https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL";
            
            $options = array('cache_wsdl' => WSDL_CACHE_NONE);
            
            $proxy = new SoapClient($wsdl, $options);
            
            $_arg1 = 15.99;
            $arg1 = array( "dNum" => $_arg1 );
            
            $_arg2 = 1234;
            $arg2 = array( "ubiNum" => $_arg2 );
            
            $operationName1 = "NumberToDollars";
            $operationName2 = "NumberToWords";
            
            $result1_a_raw = $proxy->NumberToDollars( $arg1 );
            print_r( $result1_a_raw );
            
            echo "\n<br>";
            
            $result1_a = $result1_a_raw->NumberToDollarsResult;

            $result1_b = $proxy->$operationName1( $arg1 )->NumberToDollarsResult;
            
            $result2 = $proxy->$operationName2( $arg2 )->NumberToWordsResult;
            
            echo "WSDL location: $wsdl\n<br>";
            
            echo "\$proxy->$operationName1( $_arg1 ) = $result1_b\n<br>";
            echo "\$proxy->$operationName2( $_arg2 ) = $result2\n<br>";

            /*
              $argsAddInteger = array( "Arg1"=> 34, "Arg2"=> -4 );
              $operationName = "AddInteger";

              $res = $proxy->$operationName( $argsAddInteger );

              echo "<pre>";
              print_r( $res );
              echo "</pre>";

              echo $res->AddIntegerResult;


              $argsDivideInteger1  = array( "Arg1"=> 4, "Arg2"=> 2 );
              $argsDivideInteger2  = array( "Arg1"=> 4, "Arg2"=> 0 );

              echo "<pre>";
              print_r( $proxy->DivideInteger( $argsDivideInteger1 ) );
              echo "</pre>";

              echo "<pre>";
              print_r( $proxy->DivideInteger( $argsDivideInteger2 ) );
              echo "</pre>";

             */
        } catch (SoapFault $e) {
            echo "Could not execute WS. Cause:<br>\n";
            echo $e->faultstring . "<br>\n";
            echo $e->getTraceAsString() . "<br>\n";
        }
        ?>

        <br><hr><a href="javascript: history.go(-1)">Back</a>

    </body>
</html>