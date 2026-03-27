        <h1>Manage e-mail contacts</h1>

        <div align="center">
            <form action="processFormManageContacts.php" method="post">
                <div class="rTableForm">
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">Operation:</div>
                        <div class="rTableCellForm">
                            <select name="operation">
                                <option value="Add">Add contact</option>
                                <option value="Change">Change contact</option>
                                <option value="Delete">Delete contact</option>
                                <option value="List">List contacts</option>
                            </select>
                        </div>
                    </div>
                </div>

                <p></p>
                <input type="submit" name="config" value="Send">
            </form>
        </div>
