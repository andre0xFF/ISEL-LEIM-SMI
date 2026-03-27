<?php
    include_once( "debug.inc" );
?>
                    <div class="rTableRowForm">
                        <div class="rTableCellForm">To name:</div>
                        <div class="rTableCellForm">
                            <input 
                                type="text" 
                                value="<?php echo DebugName;?>" 
                                size="64" id="ToNameID" 
                                name="ToName" 
                                required 
                                placeholder="To name"></div>
                    </div>


                    <div class="rTableRowForm">
                        <div class="rTableCellForm">To e-mail:</div>
                        <div class="rTableCellForm"><input 
                                type="email" 
                                value="<?php echo DebugEmail;?>" size="64" id="ToEmailID" name="ToEmail" required placeholder="To e-mail"></div>
                    </div>

                    <div class="rTableRowForm">
                        <div class="rTableCellForm">Subject:</div>
                        <div class="rTableCellForm"><input 
                                type="text" 
                                value="<?php echo DebugSubject;?>" size=64 id="SubjectID" name="Subject" required placeholder="Email Subject"></div>
                    </div>

                    <div class="rTableRowForm">
                        <div class="rTableCellForm">Message:</div>
                        <div class="rTableCellForm"><textarea id="MessageID" name="Message" required rows="4" cols="50" placeholder="Mail body"><?php echo DebugMessage;?></textarea></div>
                    </div>
