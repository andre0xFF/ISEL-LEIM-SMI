<!DOCTYPE html>
<?php
require_once( "../Lib/db.php" );
require_once( "../Lib/lib.php" );

require_once( "configMap.php" );
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Update user profile - Forms App</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" type="text/css" href="../Styles/GlobalStyle.css">
        <link rel="stylesheet" type="text/css" href="./Styles/forms.css">
        <link rel="stylesheet" type="text/css" href="./Styles/mapas.css">

        <!-- Open Street Maps API - Begin -->
        <!-- Versão 1.9.4 - https://leafletjs-cdn.s3.amazonaws.com/content/leaflet/v1.9.4/leaflet.zip -->
        <link rel="stylesheet" href="../external/leaflet/leaflet.css" />

        <script src="../external/leaflet/leaflet.js"></script>
        <!-- Open Street Maps API - End -->

        <!-- Leaflet Marker Cluster - Begin -->
        <!-- Versão 1.4.1 - https://github.com/Leaflet/Leaflet.markercluster -->

        <link rel="stylesheet" href="../external/markercluster/MarkerCluster.css" />
        <link rel="stylesheet" href="../external/markercluster/MarkerCluster.Default.css" />

        <script src="../external/markercluster/leaflet.markercluster.js"></script>
        <!-- Leaflet Marker Cluster - End -->

        <!-- Código JavaScript global do projeto - Begin -->
        <script type="module" src="./Scripts/main.js" >
        </script>
        <!-- Código JavaScript global do projeto - End -->

    </head>

    <body onLoad="initMap('<?php echo $mapCanvasID; ?>')">
        <div class="centerUI">
            Latitude/Longitude: <input id="inputLat" type="text">, <input id="inputLng" type="text"> <input type="button" name="Route" value="Calculate Route" onclick="calcRoute()">
        </div>

        <div class="map" id="<?php echo $mapCanvasID; ?>" >
            <span class="mapaNoLoad">Error when loading map!</span>
        </div>
        
        <script type="module">
            // Test one of the following functions
            changeSelectDistrict();
            
            //changeSelectCounty();
            
            //changeSelectPostalCode();
        </script>
    </body>
</html>