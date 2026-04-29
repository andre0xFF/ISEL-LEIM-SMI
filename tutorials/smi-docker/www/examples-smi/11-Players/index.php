<!DOCTYPE html>
<?php
ini_set('display_errors', 'On');

error_reporting(E_ALL);

function endsWith($value, $suffix) {
    return $suffix === '' || substr($value, -strlen($suffix)) === $suffix;
}

function listFiles($directory, $extension) {
	try {
		if (strpos($extension, '.') !== 0) {
            $extension = ".$extension";
        }

        $files = [];
        if (is_dir($directory)) {
            foreach (scandir($directory) as $file) {
                if (is_file("$directory/$file") && endsWith($file, $extension)) {
                    $files[] = ["nome" => pathinfo( $file, PATHINFO_FILENAME) ];
                }
            }
        }

        return $files;
    }
	catch (Exception $e) {
        return json_encode(["error" => $e->getMessage()], JSON_PRETTY_PRINT);
    }
}

?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <title>Play video</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="./Styles/Videos.css">
    </head>
	
    <body>
	
        <h1>Play video using HTML 5 or JW Player</h1>
                
		<h2>Thumbs and Sprits Management</h2>
		
		<h3>Thumbs generation</h3>
		
		<div align="center">
            <form action="thumbsGenerator.php" method="GET" target="_blank">
			
				<label for="videoName">Available videos:</label>
				<select id="videoName" name="videoName" required size="1" title="Video name">
					<option value=""> </option>
					<?php
						foreach ( listFiles( "./Videos", "mp4" ) as $currentVideoName) {
							$nome = $currentVideoName[ 'nome' ];
							echo "<option value=\"$nome\">$nome</option>";
						}
					?>
				</select>
				
				<br>
				
                <label for="numFrames">Number of seconds between frames (1-10):</label>
                <input type="number" id="numFrames" name="numFrames" size="4" min="1" max="10" value="2" title="Number of seconds between frames">
                
				<input type="submit" value="Generate">
            </form>
        </div>

		<h3>VTT files generation</h3>
		
		<div align="center">
            <form action="spriteGenerator.php" method="GET" target="_blank">
			
				<label for="videoName">Available videos:</label>
				<select id="videoName" name="videoName" required size="1" title="Video name">
					<option value=""> </option>
					<?php
						foreach ( listFiles( "./Videos", "mp4" ) as $currentVideoName) {
							$nome = $currentVideoName[ 'nome' ];
							echo "<option value=\"$nome\">$nome</option>";
						}
					?>
				</select>
				
				<br>
				
                <label for="numFrames">Number of seconds between frames (1-10):</label>
                <input type="number" id="numFrames" name="numFrames" size="4" min="1" max="10" value="2" title="Number of seconds between frames">
				
				<br>
				
				<label for="mode">Mode:</label>
				<select id="mode" name="mode" required size="1" title="VTT mode">
					<option value=""> </option>
					<option value="true">Sprite</option>
					<option value="false">Single</option>
				</select>
				
				<br>
                
				<input type="submit" value="Generate">
            </form>
        </div>
		
		<h3>Show generated VTT file</h3>
		
		<div align="center">
            <form action="showGeneratedSpriteVTT.php" method="GET" target="_blank" >
			
				<label for="videoName">Available videos:</label>
				<select id="videoName" name="videoName" required size="1" title="Video name">
					<option value=""> </option>
					<?php
						foreach ( listFiles( "./Videos", "mp4" ) as $currentVideoName) {
							$nome = $currentVideoName[ 'nome' ];
							echo "<option value=\"$nome\">$nome</option>";
						}
					?>
				</select>
				
				<br>
				
				<label for="mode">Mode:</label>
				<select id="mode" name="mode" required size="1" title="VTT mode">
					<option value=""> </option>
					<option value="true">Sprite</option>
					<option value="false">Single</option>
				</select>
				
				<br>
                
				<input type="submit" value="Show">
            </form>
        </div>
		
		<h3>Show generated Sprite image</h3>
		
		<div align="center">
            <form action="showGeneratedSpriteImage.php" method="GET" target="_blank">
			
				<label for="videoName">Available videos:</label>
				<select id="videoName" name="videoName" required size="1" title="Video name">
					<option value=""> </option>
					<?php
						foreach ( listFiles( "./Videos", "mp4" ) as $currentVideoName) {
							$nome = $currentVideoName[ 'nome' ];
							echo "<option value=\"$nome\">$nome</option>";
						}
					?>
				</select>
                
				<input type="submit" value="Show Generated Sprite Image">
            </form>
        </div>

		<hr>
		
        <h2>Play using HTML5</h2>

		<div align="center" >
			<p><a href="play-HTML5.html">Player with HTML5</a></p>
			
			<p><a href="play-HTML5-preview.html">Player with HTML5 with Thumb Preview</a></p>
			
			<p><a href="play-HTML5-preview-sprite.html">Player with HTML5 with Thumb Preview using Sprite</a></p>
		</div>

        <h2>Play using JW Player</h2>
		
		<div align="center">
            <form action="./play-JWPlayer.php" method="GET">			
				<label for="videoName">Available videos:</label>
				<select id="videoName" name="videoName" required size="1" title="Video name">
					<option value=""> </option>
					<?php
						foreach ( listFiles( "./Videos", "mp4" ) as $currentVideoName) {
							$nome = $currentVideoName[ 'nome' ];
							echo "<option value=\"$nome\">$nome</option>";
						}
					?>
				</select>
				
				<br>
				
				<label for="mode">Mode:</label>
				<select id="mode" name="mode" required size="1" title="VTT mode">
					<option value=""> </option>
					<option value="true">Sprite</option>
					<option value="false">Single</option>
				</select>
				
				<br>
                
				<input type="submit" value="Play Video">
            </form>
        </div>
		
		<hr>
				
		<h2>Static Resources</h2>

        <p><a href="/static/VTT/Subtitles/movie1-pt.vtt">Default Legends (VTT file)</a></p>
		
		<hr>

        <p ><a target="_top" href="../">Back to Examples Pages</a></p>
    </body>
</html>
