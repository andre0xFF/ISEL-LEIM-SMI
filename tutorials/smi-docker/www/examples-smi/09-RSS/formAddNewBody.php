<h2>Add News</h2>

<form action="processFormAddNew.php" method="post" >
    <table>
        <tr>
            <td>
                Title
            </td>
            <td>
                <input type="text" name="title" value="Title">
            </td>
        </tr>

        <tr>
            <td>
                Author
            </td>
            <td>
                <input type="text" name="author" value="Carlos Conçalves">
            </td>
        </tr>

        <tr>
            <td>
                Description
            </td>
            <td>
                <input type="text" name="description" value="This is the description">
            </td>
        </tr>
    </table>        

    <br>Contents<br>
    <?php
      try {
        ini_set( 'display_errors', 'On' );
	  
	    error_reporting( E_ALL );

        $URL = "http://loripsum.net/api/1/short/plaintext";

        /*
        $context = stream_context_create(
            array( 
                'http' => array('header'=>'Connection: close\r\n') 
            )
        );
        $contents = file_get_contents( $URL, false, $context );
        */

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $URL );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $contents = curl_exec( $ch );
        curl_close( $ch );

        if ($contents === false) {
          $contents = "An new example about RSS's is available";
        }
      }
      catch (Exception $e) {
        $contents = "An new example about RSS's is available";
      }
    ?>
    <textarea name="contents" rows="4" cols="50"><?php echo $contents; ?></textarea><br><br>

    <input type="submit" name="submit" value="Publish"> 
    <input type="reset" name="reset" value="Clean">

</form>
