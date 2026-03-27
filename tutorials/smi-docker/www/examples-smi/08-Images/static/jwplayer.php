<!DOCTYPE html>
<html>
<?php
    require_once( "../config.php" );
?>

    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <link rel="stylesheet" type="text/css" href="../../Styles/GlobalStyle.css" >

        <link rel="stylesheet" type="text/css" href="./styles/AdvertisingDemo.css" >

        <script type="text/javascript" src="<?php echo $jwplayerScript;?>" >
        </script>

        <script type="text/javascript" >jwplayer.key="vcwcUyC5+6Vt4//CWqA75J1tVcD3wQTRLcZN5g==";
        </script>
    
        <script type="text/javascript" src="./scripts/AdvertisingDemoJWPlayer.php" > 
        </script>

    </head>
  
    <body onload="initializeJWPlayer()" >
        <h2 align="center">Playing videos using JWPlayer 6</h2>
    
        <p align="center"><span id="seek_status"></span></p>
    
        <div id="global_video_area">
            <div id="ad_area">
                <div id='close' onclick='this.parentNode.parentNode.removeChild(this.parentNode); return false;'>
                    <p><p><a href="#">[x]</a>
                </div>

                <p align="center">SMI Rocks!</p>

                <p align="center">Visit <a target="_blank" href="http://www.debugpoint.com">DebugPoint.com</a> for more tutorials!

            </div>

            <div id="video_area">
                Loading JWPlayer ...
            </div>
        </div>
    </body>
</html>
    