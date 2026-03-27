<?php
    $DebugForm=true;
    
    if ( $DebugForm==true ) {
        define( "DebugName", "Carlos Gonçalves");
        define( "DebugEmail", "carlos.goncalves@isel.pt");
        define( "DebugSubject", "Subject for sending an e-mail");
        define( "DebugMessage", "Message body of the e-mail");
        
        define( "DebugAccountName", "Account" );
        define( "DebugAccountServer", "smtp.gmail.com" );
        define( "DebugAccountPort", "465" );
        define( "DebugAccountTimeout", "30" );
        define( "DebugAccountLogin", "email@gmail.com" );
        define( "DebugAccountEmail", DebugAccountLogin );
        define( "DebugAccountPassword", "1qa2ws3ed" );
        define( "DebugAccountDisplayName", "My name" );
    }
    else {
        define( "DebugName", "");
        define( "DebugEmail", "");
        define( "DebugSubject", "");
        define( "DebugMessage", "");
        
        define( "DebugAccountName", "" );
        define( "DebugAccountServer", "" );
        define( "DebugAccountPort", "" );
        define( "DebugAccountTimeout", "" );
        define( "DebugAccountLogin", "" );
        define( "DebugAccountEmail", "" );
        define( "DebugAccountPassword", "" );
        define( "DebugAccountDisplayName", "" );
    }
?>
