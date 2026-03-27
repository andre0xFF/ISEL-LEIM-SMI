<!DOCTYPE html>
<html>
    <?php
    ini_set('display_errors', 'On');

    error_reporting(E_ALL);

    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );
    require_once( "../Lib/lib-coords.php" );

    include_once( "config.php" );
    include_once( "configKeys.php" );

    $name = webAppName();

    // TODO validate input data
    $id = $_GET['id'];

    // Read from the data base details about the image
    $fileDetails = getFileDetails($id);

    $fileDetailsFileName = $fileDetails['fileName'];
    $fileDetailsMime = $fileDetails['mimeFileName'];
    $fileDetailsType = $fileDetails['typeFileName'];
    $fileDetailsLatitude = $fileDetails['latitude'];
    $fileDetailsLongitude = $fileDetails['longitude'];
    $fileDetailsTitle = $fileDetails['title'];
    $fileDetailsDescription = htmlentities($fileDetails['description'], ENT_QUOTES, "UTF-8");

    $dateNow = date('F d Y');

    $pathParts = pathinfo($fileDetailsFileName);
    $fileName = $pathParts['filename'];

    $locationGoogle = getCoordInGoogleFormat($fileDetailsLatitude, $fileDetailsLongitude);
    $latGoogle = $locationGoogle['latitude'];
    $lonGoogle = $locationGoogle['longitude'];

    $height = 300;
    $width = 400;
    
    $defaultZoom = 10;
    ?>

    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        
        <!-- Open Street Maps API - Begin -->
        <!-- Versão 1.9.4 - https://leafletjs-cdn.s3.amazonaws.com/content/leaflet/v1.9.4/leaflet.zip -->
        <link rel="stylesheet" href="./static/external/leaflet/leaflet.css" />

        <script src="./static/external/leaflet/leaflet.js"></script>
        <!-- Open Street Maps API - End -->

        <style>
            #map_canvas {
                width:  <?php echo $width; ?>px;
                height: <?php echo $height; ?>px;
            }
        </style>

        <script type="text/javascript" src="<?php echo $jwplayerScript; ?>" >
        </script>

        <script type="text/javascript" >
            jwplayer.key = "<?php echo $jwplayerKey; ?>";
        </script>

        <script type="text/javascript" >
            function initializeMaps(container) {
                let latCenter = <?php echo $latGoogle; ?>;
                let lngCenter = <?php echo $lonGoogle; ?>;
                
                const mapOptions = {
                    center: [ latCenter, lngCenter ],
                    zoom: <?php echo $defaultZoom; ?>
                };
                
                const markerOptionsCenter = {
                     title: "<?php echo $fileDetails['description'] ?>",
                     draggable: false
                };
                
                // Creating a map object
                var theMap = new L.map( document.getElementById( container ), mapOptions);
                
                // Creating a Layer object
                let layer = new L.TileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png' );
                
                // Adding layer to the map
                theMap.addLayer( layer );
                
                let pinCenter = new L.Marker( [ latCenter, lngCenter ] , markerOptionsCenter );
                pinCenter.addTo( theMap );                
            }

            function initializeMap() {
                initializeMaps("map_canvas");
            }
        </script>

        <script type="text/javascript" >
            function initializePlayer(container) {
<?php if ($fileDetailsType == "mpeg") {
    $fileType = "mp3";
} else {
    $fileType = $fileDetailsType;
} ?>
                jwplayer(container).setup({
                    primary: "flash",
                    autostart: "false",
                    author: "Carlos Gonçalves",
                    date: "<?php echo $dateNow ?>",
                    height: <?php echo $height ?>,
                    width: <?php echo $width ?>,
                    playlist: [{
                            title: "<?php echo $fileDetailsTitle ?>",
                            description: "<?php echo $fileDetailsDescription ?>",
                            image: "<?php echo $name; ?>showMovieImage.php?id=<?php echo $id ?>",
                                                sources: [{
                                                        file: "<?php echo $name; ?>getFileContents.php?id=<?php echo $id ?>",
                                                                                    type: "<?php echo $fileType; ?>"
                                                                                }]
                                                                        }]
                                                                });
                                                            }
        </script>
    </head>

    <body onload="initializeMap()">
        <table border=1>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <?php
                                if ($fileDetails['mimeFileName'] == "image") {
                                    echo "<img width=\"" . $width . "\" src=\"" . $name . "getFileContents.php?id=$id\">";
                                } elseif ($fileDetails['mimeFileName'] == "video" || $fileDetails['mimeFileName'] == "audio") {
                                    echo "<div id=\"playerCanvas\">JW Player is loading...</div>\n";
                                    echo "                <script  type=\"text/javascript\">\n";
                                    echo "                  initializePlayer( 'playerCanvas' );\n";
                                    echo "                </script>";
                                }
                                ?> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p align="center"><?php echo $fileDetailsTitle ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <div id="map_canvas">
                    </div>
                </td>
            </tr>
        </table>

        <p>File properties</p>    
        <form action="<?php echo $name; ?>processFileUpadateProperties.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <table border="1">

                <tr>
                    <th>Fields</th>
                    <th>Old Values</th>
                    <th>New value</th>
                </tr>

                <tr>
                    <td>File Name</td>
                    <td><?php echo $fileName ?></td>
                    <td><input type="text" disabled="disabled" size=32 name="fileName" value="<?php echo $fileName ?>"></td>
                </tr>

                <tr>
                    <td>Latitude</td>
                    <td><?php echo $fileDetailsLatitude ?></td>
                    <td><input type="text" size=32 name="latitude" value="<?php echo $fileDetailsLatitude ?>"></td>
                </tr>

                <tr>
                    <td>Longitude</td>
                    <td><?php echo $fileDetailsLongitude ?></td>
                    <td><input type="text" size=32 name="longitude" value="<?php echo $fileDetailsLongitude ?>"></td>
                </tr>

                <tr>
                    <td>Title</td>
                    <td><?php echo $fileDetailsTitle ?></td>
                    <td><input type="text" size=32 name="title" value='<?php echo $fileDetailsTitle ?>'></td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td><?php echo $fileDetailsDescription ?></td>
                    <td><input type="text" size=32 name="description" value="<?php echo $fileDetailsDescription ?>"></td>
                </tr>

                <tr>
                    <td>Mime</td>
                    <td><?php echo $fileDetailsMime ?></td>
                    <td><input type="text" size=32 name="mime" value="<?php echo $fileDetailsMime ?>"></td>
                </tr>

                <tr>
                    <td>Type</td>
                    <td><?php echo $fileDetailsType ?></td>
                    <td><input type="text" size=32 name="type" value="<?php echo $fileDetailsType ?>"></td>
                </tr>        
            </table>

            <input type="submit" name="Submit" value="Update file properties">

        </form>

        <br>
        <a href='javascript:history.back()'>Back</a>

    </body>
</html>