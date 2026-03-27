<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

function generateSpriteForMovie($baseURL, $thumbBaseName, $numSecondsBetweenFrames) { 
    $dirToScan = "Thumbs/" . $thumbBaseName;
    
    $filePreffix = $thumbBaseName . "-Thumb-";
    $fileSuffix = ".jpeg";
    $thumbWidth = 80;
    $thumbHeight = 80;
    
    $spriteImageFile = "Thumbs/" . $thumbBaseName . "-sprite.png";
	
    $spriteURL = $baseURL . $spriteImageFile;
    $spriteVTT = "VTT/Thumbs/" . $thumbBaseName . "-thumbs-sprite.vtt";
    
    $imageLine = 20;
    $dst_x = 0;
    $dst_y = 0;
    
    echo "Base URL: $baseURL\n<br>";
    echo "Directory to scan: $dirToScan\n<br>";
	echo "File preffix: $filePreffix\n<br>";
	echo "File suffix: $fileSuffix\n<br>";
    echo "Sprite image file: $spriteImageFile\n<br>";
    echo "Sprite URL: $spriteURL\n<br>";
    echo "Sprite VTT file: $spriteVTT\n<br>";
	   
    // Lê o diretório com thumbnails
    $imageFiles = glob( $dirToScan . "/" . $filePreffix . "*" . $fileSuffix);
    sort($imageFiles);
	
	//echo "<pre>";
	//print_r( $imageFiles );
	//echo "</pre>";
	    
    // Calcula as dimensões do sprite
    $spriteWidth = $thumbWidth * $imageLine;
    $spriteHeight = $thumbHeight * (int)(count($imageFiles) / $imageLine + 1);
    
    // Cria o arquivo PNG para o sprite
    $spriteImage = imagecreatetruecolor($spriteWidth, $spriteHeight);
    
    // Abre o arquivo VTT
    $handle = fopen($spriteVTT, "w");
    fwrite($handle, "WEBVTT\n\n");
    
    // Insere thumbs no sprite e escreve no arquivo VTT
    foreach ($imageFiles as $idx => $file) {
        echo "Processing $file...\n<br>";
        
        $counter = (int)str_replace([$filePreffix, $fileSuffix], "", basename($file));
        
        $imageSrc = imagecreatefromjpeg($file);
        $resized = imagescale($imageSrc, $thumbWidth, $thumbHeight);
        imagecopy($spriteImage, $resized, $dst_x, $dst_y, 0, 0, $thumbWidth, $thumbHeight);
        
        $start_time = gmdate("H:i:s", ($counter - 1) * $numSecondsBetweenFrames) . ".000";
        $end_time = gmdate("H:i:s", $counter * $numSecondsBetweenFrames) . ".000";
        
        $var_sprite = "$spriteURL#xywh=$dst_x,$dst_y,$thumbWidth,$thumbHeight";
        fwrite($handle, "$start_time --> $end_time\n$var_sprite\n\n");
        
        // Cria uma nova linha após 20 imagens
        if (($idx + 1) % $imageLine == 0) {
            $dst_x = 0;
            $dst_y += $thumbHeight;
        } else {
            $dst_x += $thumbWidth;
        }
    }
    
    // Fecha o arquivo VTT
    fclose($handle);
    
    // Salva o sprite
    imagepng($spriteImage, $spriteImageFile);
    imagedestroy($spriteImage);
}


function generateForMovie($baseURL, $thumbBaseName, $numSecondsBetweenFrames) {
	$dirToScan = "Thumbs/" . $thumbBaseName;
    
    $filePreffix = $thumbBaseName . "-Thumb-";
    $fileSuffix = ".jpeg";
    $thumbWidth = 80;
    $thumbHeight = 80;
    
    $spriteImageFile = "Thumbs/" . $thumbBaseName . "-sprite.png";
	
    $fileVTT = "VTT/Thumbs/" . $thumbBaseName . "-thumbs.vtt";

    $imageLine = 20;
    $dst_x = 0;
    $dst_y = 0;
	
	echo "Base URL: $baseURL\n<br>";
    echo "Directory to scan: $dirToScan\n<br>";
	echo "File preffix: $filePreffix\n<br>";
	echo "File suffix: $fileSuffix\n<br>";
	echo "File VTT: $fileVTT\n<br>";

    // Lê o diretório com thumbnails
    $imageFiles = glob( $dirToScan . "/" . $filePreffix . "*" . $fileSuffix);
    sort( $imageFiles );
	
	echo "<pre>";
	//print_r( $imageFiles );
	echo "</pre>";
	

    // Abre o arquivo VTT
    $handle = fopen( $fileVTT, 'w' );
    fwrite( $handle, "WEBVTT\n\n" );

    foreach ($imageFiles as $idx => $file) {
        echo "Processing $file...\n<br>";

        $counter = (int) str_replace([$filePreffix, $fileSuffix], "", basename($file));

        $start_time = gmdate("H:i:s", ($counter - 1) * $numSecondsBetweenFrames) . ".000";
        $end_time = gmdate("H:i:s", $counter * $numSecondsBetweenFrames) . ".000";

        $imageEntry = $baseURL . "Thumbs/$thumbBaseName/" . basename($file);

        fwrite($handle, "$start_time --> $end_time\n$imageEntry\n\n");
    }

    fclose($handle);
}

$videoNameRaw = $_GET[ "videoName" ];
$numFrames = $_GET[ "numFrames" ];
$modeSprite = $_GET[ "mode" ];

$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['SCRIPT_NAME']) . "/";

if ( $modeSprite=="true" ) {
	generateSpriteForMovie( $baseURL, $videoNameRaw, $numFrames );
}
else {
	generateForMovie( $baseURL, $videoNameRaw, $numFrames );
}

?>