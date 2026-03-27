<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>PHP - Arrays</title>
    </head>
    <body>
        <pre>
            <?php           
            $index = "one_thing";

            $arr1[ "aula" ] = "xpto";
            $arr1[] = "abc";
            $arr1[1] = "def";
            $arr1[$index] = 12;
            $arr1[2] = 24;

            $arr2[] = "hello";        // <=> $arr2[ 0 ] = "hello";
            $arr2[] = "world";        // <=> $arr2[ 1 ] = "world";
            $arr2[] = "PHP";
            $arr2[] = "SMI";
            
            $arr3 = array(4 => 1, 2, 3, 9 => 4, 5, 6, 1 => 7);
            $arr3[0] = 25;
            $arr3[] = 13;

            $arr4 = array(
                1, 
                2, 
                30 => 3, 
                "language" => "PHP", 
                "Programming", 
                "class" => "xpto", 
                11);

            $arr5 = array(
                1,
                2,
                "Data" => array(
                    "name" => "Carlos Jorge",
                    "email" => "cgoncalves@isel.pt"),
                "language" => "PHP");

            echo "\n";
            
            print( "Going to show the arrays using \"print_r\"...\n<br>" );

            print_r( $arr1 );
            print_r( $arr2 );
            print_r( $arr3 );
            print_r( $arr4 );
            print_r( $arr5 );
            
            print( "Going to show the arrays (2)...\n<br>" );
            
            $name = $arr5[ "Data" ][ "name" ];
            $email = $arr5[ "Data" ][ "email" ];

            $aux = $arr5["Data"];
            $name2 = $aux[ "name" ];
            $email2 = $aux[ "email" ];
            
            print( $aux ); echo "<br>\n";
            
            print_r( $aux );

            echo "<p>Name: " . $name . "\n";
            echo "<p>E-mail: " . $arr5["Data"]["email"] . "\n";

            $arr2[0] = "Hello";

            print_r($arr2);
            
            echo "\n<p> ----------- <br>";
            for($idx=0; $idx<count($arr2); ++$idx) {
              echo '$arr2[ ' . $idx . "] = " . $arr2[ $idx ] . "\n<br>";
            }

            echo "\n<p> ----------- <br>";

            $position = 1;
            foreach ($arr4 as $value) {
                echo '$arr4[ "' . $position . 'ª" ] = ' . $value . "\n<br>";
                ++$position;
            }

            echo "\n<p> ----------- <br>";
            
            foreach ($arr4 as $key => $value) {
                //foreach ($value as $key2 => $value2)
                echo "\$arr4[ $key ] = $value \n<br>";
            }
            ?>
        </pre>
        <a href="../index.php"></a>
    </body>
</html>