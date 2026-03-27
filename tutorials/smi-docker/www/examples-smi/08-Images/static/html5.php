 <!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
        <link rel="stylesheet" type="text/css" href="../../Styles/GlobalStyle.css" >
    
        <link rel="stylesheet" type="text/css" href="./styles/AdvertisingDemo.css">
    
        <script type="text/javascript" src="./scripts/AdvertisingDemoHTML5.js"> 
        </script>
    </head>
		
    <body onload="initializeHTML5()" >
        <h2 align="center">Playing videos using HTML 5</h2>
    
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
                <video 
                        id="my_video" 
                        width="640" 
                        height="480" 
                        poster="videoDemo.jpg" 
                        controls 
                        preload="metadata" >
                    <source src="videoDemo.mp4" type="video/mp4" />
                    <source src="videoDemo.ogg" type="video/ogg" />
          
                    <track label="English" kind="subtitles" srclang="en" src="subtitles/vtt/videoDemo-en.vtt">
                    <track label="Français" kind="subtitles" srclang="fr" src="subtitles/vtt/videoDemo-fr.vtt" >
                    <track label="Português" kind="subtitles" srclang="pt" src="subtitles/vtt/videoDemo-pt.vtt" default>
                    <track label="Deutsch" kind="subtitles" srclang="de" src="subtitles/vtt/videoDemo-de.vtt">
                    Your browser do not support HTML5 video! Try a different browser instead.
                </video>        
            </div>
        </div>
    
    </body>
  
    <script>
        // Get the Video Object
        theVideo = document.getElementById( "my_video" );
    </script>
</html>