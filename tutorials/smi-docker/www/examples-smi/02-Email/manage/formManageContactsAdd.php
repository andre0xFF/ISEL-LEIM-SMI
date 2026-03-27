<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Manage e-mail contacts</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link REL="stylesheet" TYPE="text/css" href="../../Styles/GlobalStyle.css">
        <link REL="stylesheet" TYPE="text/css" href="../../Styles/TableUsingDivs.css">
        
        <link REL="stylesheet" TYPE="text/css" href="../Styles/forms.css">
    </head>
  
    <body>
        <h2>Add new e-mail contact</h2>
  
        <div align="center">
            <form action="processFormManageContactsAdd.php" method="post">
                <div class="rTableForm">

                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* Display name:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                size=32 
                                required
                                name="displayName"></div>
                    </div>

                    <div class="rTableRowForm">
                        <div class="rTableCellForm">* E-mail address:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="email" 
                                size=32 
                                required
                                name="email"></div>
                    </div>
                </div>
                
                <p></p>
                <input type="submit" name="add" value="Add Contact"> <input type="reset" name="reset" value="Clear">

                <br>
                <p>The fields marked with a * are mandatory.</p>
            </form>
        </div>
        
        <hr>
        <p><span class='mainPageEntry'><a target="_top" href="./formManageContacts.php">Back.</a></span></p>
    </body>
</html>
