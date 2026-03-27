<?php
    require_once( "../../Lib/db.php");
    
    dbConnect( ConfigFile );
                
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString = "SELECT `id`, `accountName` FROM `$dataBaseName`.`email-accounts`"; 
    $result = mysqli_query( $GLOBALS['ligacao'], $queryString );
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail accounts</title>
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/TableUsingDivs.css">
    </head>
    <body>
        <h2>Change an existing e-mail account</h2>

        <div align="center">
            <form action="processFormManageAccountsChange.php" method="post">
                <div class="rTableForm">
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">Account:</div>
                        <div class="rTableCellForm"><select name="accountID" >
<?php
    if ( $result ) {
        while ( $record = mysqli_fetch_array( $result ) ) {
            $id          = $record[ 'id' ];
            $accountName = $record[ 'accountName' ];
            echo "\t\t\t\t\t\t\t<option value=\"$id\">$accountName</option>\n";
        }

        mysqli_free_result($result);
    }
    else {
        echo "                <option value=\"-1\">No e-mail accounts available</option>\n";
    }
    dbDisconnect();
?>
                            </select>
                        </div>
                    </div>
                </div>

                <p></p>
                <input type="submit" name="change" value="Change Account">
            </form>
        </div>
        
        <hr>
        <p><span class='mainPageEntry'><a target="_top" href="./formManageAccounts.php">Back.</a></span></p>
    </body>
</html>
