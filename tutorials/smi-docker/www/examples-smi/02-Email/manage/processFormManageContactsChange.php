<?php
    require_once( "../../Lib/db.php" );
    require_once( "../../Lib/lib.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
    $referer = filter_input( INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING, $flags);
    
    if ( $referer==NULL ) {
        redirectToLastPage( "Invalid data", 5, "HTTP REFERER is missing" );
    }
    
    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        redirectToLastPage( "Invalid data", 5, "Invalid HTTP method (" . $method . ")" );
    }
    
    $contactId = filter_input( $_INPUT_METHOD, 'contactId', FILTER_SANITIZE_NUMBER_INT, $flags);

    if ( $contactId==NULL || filter_var( $contactId, FILTER_VALIDATE_INT, $flags)==FALSE) {
        redirectToLastPage( "Invalid fields" );
    }
    
    dbConnect( ConfigFile );
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = 
            "SELECT * FROM `$dataBaseName`.`email-contacts` " .
            "WHERE `id` = '$contactId'";
    
    $result = mysqli_query( $GLOBALS['ligacao'], $queryString );

    if ( $result==FALSE ) {
        dbDisconnect();
        redirectToLastPage( "Invalid contact ID", 5);
    }

    $contactData = mysqli_fetch_array( $result );
            
    $id           = $contactData[ 'id' ];
    $displayName  = $contactData[ 'displayName' ];
    $email        = $contactData[ 'email' ];

    mysqli_free_result( $result );
            
    dbDisconnect();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail accounts</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/TableUsingDivs.css">
        
        <link REL="stylesheet" TYPE="text/css" href="../Styles/forms.css">
        
        <link REL="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        
        <script TYPE="text/javascript" src="../Scripts/email.js">
        </script>
    </head>
    <body>
        <h2>Change e-mail contact</h2>
        
        <div align="center">
            <form action="processFormManageContactsChangeUpdate.php" method="post">
                <div class="rTableForm">
                    
                    <div class="rTableRowForm">
                        <div class="rTableHead">Attribute</div>
                        <div class="rTableHead">Old value</div>
                        <div class="rTableHead">New value</div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Display Name</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $displayName;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="displayName" 
                                required
                                value="<?php echo $displayName;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Email</div>
                        <div class="rTableCellForm">
                            <input 
                                type="email" 
                                size=32 
                                readonly
                                value="<?php echo $email;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="email" 
                                size=32 
                                name="email" 
                                required
                                value="<?php echo $email;?>">
                        </div>
                    </div>
                </div>
                
                <br>
                <p>The fields marked with a * are mandatory.</p>
                
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <p></p>
                <input type="submit" name="change" value="Change Contact"> <input type="reset" name="reset" value="Clear">

            </form>
        </div>
        
        <hr>
        <br><a href="<?php echo $referer;?>">Back</a>
    </body>
</html>
