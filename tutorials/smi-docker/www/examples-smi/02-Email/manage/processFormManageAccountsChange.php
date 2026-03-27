<?php
    require_once( "../../Lib/db.php");
    require_once( "../../Lib/lib.php");
    
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
    
    $accountId = filter_input( $_INPUT_METHOD, 'accountID', FILTER_SANITIZE_NUMBER_INT, $flags);

    if ( $accountId==NULL || filter_var( $accountId, FILTER_VALIDATE_INT, $flags)==FALSE) {
        redirectToLastPage( "Invalid fields" );
    }
    
    dbConnect( ConfigFile );
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = 
            "SELECT * FROM `$dataBaseName`.`email-accounts` " .
            "WHERE `id` = '$accountId'";
    
    $result = mysqli_query( $GLOBALS['ligacao'], $queryString );

    if ( $result==FALSE ) {
        redirectToLastPage( "Invalid account ID", 5);
    }

    $accountData = mysqli_fetch_array( $result );
            
    $id           = $accountData[ 'id' ];
    $accountName  = $accountData[ 'accountName' ];
    $smtpServer   = $accountData[ 'smtpServer' ];
    $useSSL       = $accountData[ 'useSSL' ];
    $port         = $accountData[ 'port' ];
    $timeout      = $accountData[ 'timeout' ];
    $loginName    = $accountData[ 'loginName' ];
    $password     = $accountData[ 'password' ];
    $email        = $accountData[ 'email' ];
    $displayName  = $accountData[ 'displayName' ];

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
        <h2>Change e-mail account</h2>
        
        <div align="center">
            <form action="processFormManageAccountsChangeUpdate.php" method="post">
                <div class="rTableForm">
                    
                    <div class="rTableRowForm">
                        <div class="rTableHead">Attribute</div>
                        <div class="rTableHead">Old value</div>
                        <div class="rTableHead">New value</div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Account Name</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $accountName;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="accountName" 
                                required
                                value="<?php echo $accountName;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* SMTP Server</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $smtpServer;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="smtpServer" 
                                required
                                value="<?php echo $smtpServer;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Use SSL</div>
                        <div class="rTableCellForm"><?php echo $useSSL==1 ? "Yes" : "No" ;?></div>
                        <div class="rTableCellForm">
                            <select name="useSSL">
                                <option 
                                    <?php if (intval($useSSL)==0) {echo "selected=\"selected\"";}?>
                                    value="0">No</option>
                                <option 
                                    <?php if (intval($useSSL)==1) {echo "selected=\"selected\"";}?>
                                    value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Port</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $port;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="port" 
                                required
                                value="<?php echo $port;?>">
                        </div>
                    </div>
        
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Timeout</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $timeout;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="timeout" 
                                required
                                value="<?php echo $timeout;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Login name</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $loginName;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="loginName" 
                                required
                                value="<?php echo $loginName;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Password</div>
                        <div class="rTableCellForm">
                            <div>
                                <input 
                                    type="password" 
                                    size=32 
                                    id="passwordID" 
                                    readonly
                                    value="<?php echo $password;?>">
                                <i 
                                    id="passwordStatusID" 
                                    class="fa fa-eye" 
                                    aria-hidden="true" 
                                    onClick="viewPassword()">
                                </i>
                            </div>
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="password" 
                                size=32 
                                name="password" 
                                required
                                value="<?php echo $password;?>">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Email</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                readonly
                                value="<?php echo $email;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                name="email" 
                                required
                                value="<?php echo $email;?>">
                        </div>
                    </div>

                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Display name</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=50 
                                readonly
                                value="<?php echo $displayName;?>">
                        </div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=50 
                                name="displayName" 
                                required
                                value="<?php echo $displayName;?>">
                        </div>
                    </div>
                    
                </div>
                
                <br>
                <p>The fields marked with a * are mandatory.</p>
                
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <p></p>
                <input type="submit" name="change" value="Change Account"> <input type="reset" name="reset" value="Clear">

            </form>
        </div>
        
        <hr>
        <br><a href="<?php echo $referer;?>">Back</a>
    </body>
</html>
