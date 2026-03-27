<?php
    include_once( "../debug.inc" );
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
    </head>
  
    <body>
        <h2>Add new e-mail account</h2>
        
        <div align="center">
            <form action="processFormManageAccountsAdd.php" method="post">
                <div class="rTableForm">
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Account Name:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountName;?>"
                                name="accountName">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Use SSL:</div>
                        <div class="rTableCellForm">
                            <select name="useSSL" >
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* SMTP Server:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountServer;?>"
                                name="smtpServer">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Port:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountPort;?>"
                                name="port">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Timeout:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountTimeout;?>"
                                name="timeout">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Login Name:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountLogin;?>"
                                name="loginName">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* E-mail:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="email" 
                                size=32 
                                required
                                value="<?php echo DebugAccountEmail;?>"
                                name="email"></div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Password:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="password" 
                                size=32 
                                required
                                value="<?php echo DebugAccountPassword;?>"
                                name="password">
                        </div>
                    </div>
                    
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Display Name:</div>
                        <div class="rTableCellForm"><input 
                                type="text" 
                                size=32 
                                required
                                value="<?php echo DebugAccountDisplayName;?>"
                                name="displayName">
                        </div>
                    </div>
                </div>

                <p></p>
                <input type="submit" name="add" value="Add Account"> <input type="reset" name="reset" value="Clear">

                <br>
                <p>The fields marked with a * are mandatory.</p>
            </form>
        </div>
        
        <hr>
        <p><span class='mainPageEntry'><a target="_top" href="./formManageAccounts.php">Back.</a></span></p>
    </body>
</html>
