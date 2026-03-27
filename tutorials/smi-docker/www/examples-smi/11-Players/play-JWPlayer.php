<!DOCTYPE html>
<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$videoName = $_GET[ "videoName" ];
	
	if ( $_GET[ "mode" ] =="true" ) {
		$vttFile = "./VTT/Thumbs/$videoName-thumbs-sprite.vtt";
	}
	else {
		$vttFile = "./VTT/Thumbs/$videoName-thumbs.vtt";
	}
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		
        <title>Play video using JW Plawyer</title>
		
		<link rel="icon" type="image/x-icon" href="/static/favicon.ico">

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="./Styles/Videos.css">
        
        <script type="text/javascript" src="/jwplayer6/jwplayer.js"> </script>

        <script type="text/javascript">
            function initVideo(containerID) {
                jwplayer( containerID ).setup( {
                    allowfullscreen: true,
                    allowscriptaccess: "always",
                    volume: 80,
                    primary: "flash",
                    autostart: "false",
                    author: "Carlos Gonçalves",
                    date: "April 01 2018 00:06:27",
                    width: 640,
                    height: 480,
                    playlist: [
                    {
                        title: "<?php echo $videoName;?>",
                        description: "Mais um filme por ai...",
                        image: "./Videos/Posters/<?php echo $videoName;?>.png",
                        sources: [
                            {
                                file: "./Videos/<?php echo $videoName;?>.mp4",
                                type: "mp4"
                            }
                        ],
                        tracks: [
                            {
                                file: "<?php echo $vttFile;?>",
                                kind: "thumbnails"
                            }
                        ]
                    }
                ] } );
            }
        </script>
    </head>

    <body onload="initVideo( 'container' )">

        <h1>Player with JW Player (JavaScript)</h1>
        
        <div class="MyVideoPlayer">
            <div id="container">JW Player is loading...</div>
        </div>

        <p><a href='javascript:history.back()'>Back</a></p>

    </body>

</html>
