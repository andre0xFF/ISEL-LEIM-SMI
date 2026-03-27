<?php

require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
require_once( "../Lib/GraficoBarras.php" );

$graphTitle = "Contents Statistics";

if (!isset($_GET['type'])) {
    $graphType = "None";
} else {
    $graphType = $_GET['type'];
}

switch ($graphType) {
    case "Pie":
        // Read from the data base stats about all the files
        $stats = getStats();
        $numFiles = $stats['numFiles'];
        $numImages = $stats['numImages'];
        $numVideos = $stats['numVideos'];
        $numAudios = $stats['numAudios'];

        header("Content-type: image/png");

        $myImage = imagecreate(400, 300);
        $black = imagecolorallocate($myImage, 0, 0, 0);
        $white = imagecolorallocate($myImage, 255, 255, 255);
        $red = imagecolorallocate($myImage, 255, 0, 0);
        $green = imagecolorallocate($myImage, 0, 255, 0);
        $blue = imagecolorallocate($myImage, 255, 255, 0);

        $ccc = imagecolorallocate($myImage, 100, 100, 100);

        // Fill image with a color
        imagefill($myImage, 0, 0, $white);

        $x = (400 / 2) - ((8 * strlen($graphTitle)) / 2);
        $y = 0;
        imagestring(
                $myImage, // Image
                5, // Font 0 <-> 5
                $x, // X start position of text
                $y, // Y start position of text
                $graphTitle, // Text to write 
                $black        // Text color 
        );

        $angleImagesBegin = 0;
        $angleImagesEnd = $angleImagesBegin + $numImages * 360 / $numFiles;

        $angleVideosBegin = $angleImagesEnd;
        $angleVideosEnd = $angleVideosBegin + $numVideos * 360 / $numFiles;

        $angleAudiosBegin = $angleVideosEnd;
        $angleAudiosEnd = $angleAudiosBegin + $numAudios * 360 / $numFiles;

        $a1 = $angleAudiosEnd;
        $a2 = 360;

        // Arco correspondente às imagens
        imagefilledarc(
                $myImage, // Image 
                200, // X center of ellipse
                150, // Y center of ellipse
                260, // X size of the ellipse
                260, // Y size of the ellipse
                $angleImagesBegin, // Start angle (clock wise start at 0)
                $angleImagesEnd, // End angle
                $red, // Color
                IMG_ARC_PIE        // Style
        );

        // Arco correspondente aos vídeos
        imagefilledarc(
                $myImage, 200, 150, 260, 260, $angleVideosBegin, $angleVideosEnd, $green, IMG_ARC_PIE);

        // Arco correspondente aos áudios
        imagefilledarc(
                $myImage, 200, 150, 260, 260, $angleAudiosBegin, $angleAudiosEnd, $blue, IMG_ARC_PIE);

        if ($angleAudiosEnd < 360) {
            // Arco correspondente aos outros conteúdos
            imagefilledarc(
                    $myImage, 200, 150, 260, 260, $a1, $a2, $ccc, IMG_ARC_PIE);
        }

        // Linha do arco
        imagearc(
                $myImage, 200, 150, 260, 260, 0, 360, $black);

        // Fazer o arco
        imagepng($myImage);

        // Libertar os recursos
        imagedestroy($myImage);
        break;
    case "Bar":
        // Read from the data base stats about all the files
        $stats = getStats();
        $numFiles = $stats['numFiles'];
        $numImages = $stats['numImages'];
        $numVideos = $stats['numVideos'];
        $numAudios = $stats['numAudios'];

        $numOthers = $numFiles - ($numImages + $numVideos + $numAudios);

        header("Content-type: image/png");
        $gb = new GraficoBarras(4);
        $gb->adicionarTituloGrafico($graphTitle);
        $gb->desenhaExterior();
        $gb->desenhaEscVertical();
        $gb->desenhaEscHorizontal();
        $gb->setMaxValor(300);
        $gb->addDados($numImages * 300 / $numFiles);
        $gb->addDados($numVideos * 300 / $numFiles);
        $gb->addDados($numAudios * 300 / $numFiles);
        $gb->addDados($numOthers * 300 / $numFiles);

        $gb->criaGrafico();
        $gb->desenhaGrafico();
        break;
    default:
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Image Processing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../Styles/GlobalStyle.css">
    </head>
    <body>
        <table align="center" border="1">
            <tr>
                <td>
                    <img alt="" src="stats.php?type=Pie">
                </td>
                <td>
                    <img alt="" src="stats.php?type=Bar">
                </td>
            </tr>
        </table>
    </body>
</html>
        <?php

        break;
}
?>