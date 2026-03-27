<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$fileName = $_GET[ "videoName" ];

$videoName = $fileName . ".mp4";

$numSecondsBetweenFrames = $_GET[ "numFrames" ];

$frameRate = 1 / $numSecondsBetweenFrames;

$cmd = "/examples-php/11-Players/genSprite.sh";

$fileNameWithFullPath= "Videos" . DIRECTORY_SEPARATOR . $videoName;

$commandWithArgs = "$cmd $frameRate $fileName $fileNameWithFullPath";

echo "<pre>";
	echo "Number of seconds between frames: $numSecondsBetweenFrames<br>";
	echo "Video name: $fileNameWithFullPath<br>";
	echo "Thumb base name: $fileName<br>";
	echo "FFMPEG command: $commandWithArgs<br>";

	ob_flush();
	flush();

	$last_line = system( $commandWithArgs, $retval);
	
	echo "Return value from thumbs generation: $retval\n";
	
	ob_flush();
	flush();
echo "</pre>";
