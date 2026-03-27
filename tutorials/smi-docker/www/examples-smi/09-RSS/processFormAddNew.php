<?php
    require_once( "../Lib/db.php" );
    require_once( "../Lib/lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
     
    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        echo "Invalid HTTP method (" . $method . ")";
        exit();
    }
    
    $_description = filter_input( $_INPUT_METHOD, 'description', FILTER_UNSAFE_RAW, $flags);
    $_author = filter_input( $_INPUT_METHOD, 'author', FILTER_UNSAFE_RAW, $flags);
    $_title = filter_input( $_INPUT_METHOD, 'title', FILTER_UNSAFE_RAW, $flags);
    $_contents = filter_input( $_INPUT_METHOD, 'contents', FILTER_UNSAFE_RAW, $flags);
    
    $ServerName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_UNSAFE_RAW, $flags);
    $ServerPort = filter_input( INPUT_SERVER, 'SERVER_PORT', FILTER_SANITIZE_NUMBER_INT, $flags);
    
    if ( $_description==null || $_author==null || $_title==null || $_contents==null ) {
        echo "Missing arguments.";
        exit();
    }

    $description = addslashes($_description);
    $author = addslashes($_author);
    $title = addslashes($_title);
    $contents = addslashes($_contents);

    $name = webAppName();

    dbConnect( ConfigFile );

    $db = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $db);

    $queryInsertNew = 
            "INSERT INTO `$db`.`rss-news`" .
            "(`description`, `author`, `title`, `contents`, `pubDate`) values " .
            "('$description', '$author', '$title', '$contents', CURDATE() )";
    
    if ( mysqli_query($GLOBALS['ligacao'], $queryInsertNew)===false ) {
        $msg = "Insert of RSS has failed. Cause: " . dbGetLastError();
    }
    else {
        $msg = "RSS added with success.";
        $lastId = mysqli_insert_id( $GLOBALS['ligacao'] );
    }
    
    $link = "http://" . $ServerName . ":" . $ServerPort . $name . "getFullRSS.php?idNew=" . $lastId;
    dbDisconnect();    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Rich Site Summary - RSS</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        
        <link rel="stylesheet" typr="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="styles/rss.css">
    </head>
   <body>
        <h1>Rich Site Summary - RSS</h1>
        
        <p>Description: <?php echo $description;?></p>
        <p>Author: <?php echo $author;?></p>
        <p><a target="_blank" href="<?php echo $link;?>">Link to RSS</a></p>
        <p>Title:  <?php echo $title;?></p>
        <p>Contents: <?php echo $contents;?></p>
        <p>SQL statment: <?php echo $queryInsertNew;?></p>
    </body>
</html>
