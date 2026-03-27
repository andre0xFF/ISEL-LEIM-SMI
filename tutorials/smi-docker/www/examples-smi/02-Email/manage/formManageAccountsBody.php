        <h1>Manage e-mail accounts</h1>

        <div align="center">
            <form action="processFormManageAccounts.php" method="post">
                <div class="rTableForm">
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">Operation:</div>
                        <div class="rTableCellForm">
                            <select name="operation">
                                <option value="Add">Add account</option>
                                <option value="Change">Change account</option>
                                <option value="Delete">Delete account</option>
                                <option value="List">List accounts</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <p></p>
                <input type="submit" name="config" value="Send">
            </form>
        </div>
