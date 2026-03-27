<?php
    require_once( "../Lib/db.php" );
                
    dbConnect( ConfigFile );
                
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $queryStringAccounts = "SELECT `id`,`accountName` FROM `$dataBaseName`.`email-accounts`";
    $queryResultAccounts = mysqli_query( $GLOBALS['ligacao'], $queryStringAccounts );
    
    $queryStringContacts = "SELECT `displayName`,`email` FROM `$dataBaseName`.`email-contacts`";
    $queryResultContacts = mysqli_query( $GLOBALS['ligacao'], $queryStringContacts );
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Send an e-mail using PHP Mailer</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../Styles/TableUsingDivs.css">
        
        <link REL="stylesheet" TYPE="text/css" href="./Styles/forms.css">
        
        <script TYPE="text/javascript" src="./Scripts/forms.js">
        </script>
    </head>

    <body>
        <h1>Send an e-mail with PHP Mailer</h1>

        <div align="center"><form 
                action="processFormSendEmailUsingPHPMailer.php" 
                method="post" >
            <div class="rTableForm">
                <div class="rTableRowForm">
                    <div class="rTableCellForm">Account:</div>
                    <div class="rTableCellForm">
                        <select name="Account" id="AccountID" size="1">
<?php
    if ( $queryResultAccounts ) {
        while ( $record = mysqli_fetch_array( $queryResultAccounts ) ) {
            $id             = $record[ 'id' ];
            $accountName    = $record[ 'accountName' ];
?>
                            <option value="<?php echo $id;?>"><?php echo $accountName;?></option>
<?php
        }
    }
    else {
?>
                            <option value="-1">No accounts available</option>";
<?php
    }
?>
                        </select>
                    </div>
                </div>
                <div class="rTableRowForm">
                    <div class="rTableCellForm">Contacts:</div>
                    <div class="rTableCellForm">
                        <select 
                            onchange="SelectContactChange(this)"
                            name="Contact" 
                            id="ContactID" 
                            size="1">
<?php
    if ( $queryResultContacts ) {
        while ( $record = mysqli_fetch_array( $queryResultContacts ) ) {
            $displayName    = $record[ 'displayName' ];
            $email          = $record[ 'email' ];
?>
                            <option value="<?php echo $email;?>"><?php echo $displayName;?></option>
<?php
        }
    }
    else {
?>
                            <option value="-1">No contacts available</option>";
<?php
    }
?>
                        </select>
                    </div>
                </div>

<?php
    mysqli_free_result( $queryResultAccounts );
    mysqli_free_result( $queryResultContacts );

    dbDisconnect();
?>
                    
                
<?php
    include_once( "formEmail.inc" );
?>                
                <div class="rTableRowForm">
                    <div class="rTableCellForm">Send as HTML:</div>
                    <div class="rTableCellForm"><input type="checkbox" id="SendAsHTMLID" name="SendAsHTML"></div>
                </div>
                <div class="rTableRowForm">
                    <div class="rTableCellForm">Debug SMTP:</div>
                    <div class="rTableCellForm"><input type="checkbox" id="DebugID" name="Debug"></div>
                </div>
            </div>
            <div>
                <input type="submit" id="SendID" name="Send" value="Send E-mail"> <input type="reset" id="ResetID" name="Reset" value="Clear">
            </div>
            </form></div>

        <hr>
        <br><span class='mainPageEntry'><a href=".">Back</a></span>
    </body>
</html>
