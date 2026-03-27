<?php
header("Content-type: application/javascript");

require_once( "../../configMap.php" );

ini_set('display_errors', 'On');

error_reporting(E_ALL);

function getPinPopUp4Video($text, $videoPoster, $videoSource) {
    $result = 
            "<div class='pinPlaceHolder'>" .
            "   <span class='pinText'>$text</span>" .
            "       <video class='pinMedia' width='350' poster='$videoPoster' controls >" .
            "           <source src='$videoSource' type='video/mp4' />" .
            "       </video>" .
            "</div>";
    
    return $result;
}

function getPinPopUp4URL($text, $url, $titleURL, $imageSource) {
    $result = 
            "<div class='pinPlaceHolder'>" .
            "   <span class='pinText'>$text</span>" .
            "   <a href='$url' target='_blank' title='$titleURL'>" .
            "       <img class='pinMedia' src='$imageSource'>" .
            "   </a>" .
            "</div>";
    
    return $result;
}
?>
var theMap;

var markers;

var layerRoute;

var layerDistrict;
var layerCounty;
var layerPostalCode;

var latMyInitialPosition;
var lngMyInitialPosition;

var pinCenter;
var pinDistrict;
var pinCounty;
var pinPostalCode;

var pinISEL;
var pinIPL;

const defaultLatPosition = <?php echo $mapInitialLat; ?>;
const defaultLngPosition = <?php echo $mapInitialLng; ?>;

const defaultZoom = <?php echo $defaultZoom; ?>;

const osrKey = "<?php echo $osrKey; ?>";

const latIPL = 38.7493859;
const lngIPL = -9.1936041;

const latISEL = 38.7569741;
const lngISEL = -9.116452;

const iconSize = <?php echo $iconSize; ?>;

const popupOptions = {
    maxWidth: <?php echo $wdthPopUp; ?>
};

const defaultMapOptions = {
    center: [ defaultLatPosition, defaultLngPosition ],
    zoom: defaultZoom
};

function upDateCoords(lat, lng) {
    let latPlaceHolder = document.getElementById( 'inputLat' );
    latMyInitialPosition = lat;
    latPlaceHolder.value = latMyInitialPosition;

    let lngPlaceHolder = document.getElementById( 'inputLng' );
    lngMyInitialPosition = lng;
    lngPlaceHolder.value = lngMyInitialPosition; 
}

function initVars() {
    layerRoute = null;

    layerDistrict = null;
    layerCounty = null;
    layerPostalCode = null;

    pinCenter = null;
    pinDistrict = null;
    pinCounty = null;
    pinPostalCode = null;
    
    pinIPL = null;
    pinISEL = null;

    if ( !navigator.geolocation ) {
        alert( "Browser does not suport geolocation. Using default values." );

        latMyInitialPosition = 39.69484;
        lngMyInitialPosition = -8.13031;
    }
    else {
        latMyInitialPosition = lngMyInitialPosition = null;

        navigator.geolocation.getCurrentPosition( 
            function(pos) {
                const coords = pos.coords;

                latMyInitialPosition = coords.latitude;
                lngMyInitialPosition = coords.longitude;

                const markerOptionsCenter = {
                    title: "A minha posição.",
                    draggable: true
                };

                upDateCoords( latMyInitialPosition, lngMyInitialPosition );

                pinCenter = new L.Marker( [ latMyInitialPosition, lngMyInitialPosition ] , markerOptionsCenter );
                pinCenter.addTo( theMap );
                pinCenter.on( 
                    'move',
                    (event) => {
                        upDateCoords( event.target.getLatLng().lat, event.target.getLatLng().lng );
                    }
                );

                pinCenter.bindPopup( 
                    "<?php echo getPinPopUp4Video( "Um video", "./Resources/Videos/movie.png", "./Resources/Videos/movie1.mp4");?>", 
                    popupOptions );
            }
        );
    }
}

export function initMap(container) {
    console.log( "maps#initMap(%s) called", container );
    
    initVars();

    const optionsIconIPL = {
        iconUrl: './Resources/Images/IPL.png',
        iconSize: [ iconSize, iconSize ]
    };

    const optionsIconISEL = {
        iconUrl: './Resources/Images/ISEL.png',
        iconSize: [ iconSize, iconSize ]
    };

    const iconIPL = L.icon( optionsIconIPL );
    const iconISEL = L.icon( optionsIconISEL );
    
    const markerOptionsIPL = {
        title: "Instituto Politécnico de Lisboa",
        icon: iconIPL
    };

    const markerOptionsISEL = {
        title: "Instituto Superior de Engenharia de Lisboa",
        icon: iconISEL
    };   

    // Creating a map object
    theMap = new L.map( document.getElementById( container ), defaultMapOptions );

    // Creating a Layer object
    let layer = new L.TileLayer( 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png' );

    // Adding the layer to the map
    theMap.addLayer( layer );
    
    // Creating a marker/pin to represent IPL school
    pinIPL = new L.Marker( [ latIPL, lngIPL ] , markerOptionsIPL );
    pinIPL.addTo( theMap );

    // Creating a marker/pin to represent ISEL school
    pinISEL = new L.Marker( [ latISEL, lngISEL ] , markerOptionsISEL );
    pinISEL.addTo( theMap );
    
    markers = L.markerClusterGroup();
    
    markers.addLayer( pinIPL );
    markers.addLayer( pinISEL );
    
    theMap.addLayer( markers );

    pinIPL.bindPopup( 
        "<?php echo getPinPopUp4URL( "Instituto Politécnico de Lisboa", "https://www.ipl.pt/", "IPL", "./Resources/Images/IPL.jpg" ); ?>", 
        popupOptions );
  
    pinISEL.bindPopup( 
        "<?php echo getPinPopUp4URL( "Instituto Superior de Engenharia de Lisboa", "https://www.isel.pt/", "ISEL", "./Resources/Images/ISEL.jpg" ); ?>",
        popupOptions );
}

export function calcRoute() {
    console.log( "maps#calcRoute() called" );
    
    let xml = getXmlHttpObject();

    let params = new Object();

    params.coordinates = [];

    params.coordinates.push( [lngMyInitialPosition, latMyInitialPosition] );
    
    if ( pinPostalCode!=null ) {
        params.coordinates.push( [ pinPostalCode.getLatLng().lng, pinPostalCode.getLatLng().lat ] );  
    }
    
    if ( pinCounty!=null ) {
        params.coordinates.push( [ pinCounty.getLatLng().lng, pinCounty.getLatLng().lat ] );  
    }
    if ( pinDistrict!=null ) {
        params.coordinates.push( [ pinDistrict.getLatLng().lng, pinDistrict.getLatLng().lat ] );  
    }

    let baseURL = "https://api.openrouteservice.org/v2/directions/";
    let profile = "driving-car";
    let url = baseURL + profile + "/geojson";

    // Using Post
    xml.open( "POST", url, true );
    xml.onreadystatechange = () => {
        if( xml.readyState === XMLHttpRequest.DONE ) {
            if ( layerRoute!=null ) {
                theMap.removeLayer( layerRoute );
            }

            theMap.addLayer( (layerRoute=L.geoJSON( JSON.parse( xml.responseText ) ) ) ); 
        }
    };
    xml.setRequestHeader( 'Content-Type', 'application/json; charset=utf-8' );
    xml.setRequestHeader( 'Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8' );
    xml.setRequestHeader( 'Authorization', osrKey );
    xml.send( JSON.stringify( params ) );
}

function resetLayers() {
    console.log( "maps#resetLayers() called" );
    
    if ( layerDistrict!=null ) {
        theMap.removeLayer( layerDistrict );
    }

    if ( layerCounty!=null ) {
        theMap.removeLayer( layerCounty );
    }

    if ( layerPostalCode!=null ) {
        theMap.removeLayer( layerPostalCode );
    }
}

function resetPins() {
    console.log( "maps#resetPins() called" );
    
    if ( pinDistrict!=null ) {
        theMap.removeLayer( pinDistrict );
    }

    if ( pinCounty!=null ) {
        theMap.removeLayer( pinCounty );
    }

    if ( pinPostalCode!=null ) {
        theMap.removeLayer( pinPostalCode );
    }
}

export function resetMap() {
    console.log( "maps#resetMap() called" );
    
    resetLayers();
    
    resetPins();
    
    theMap.setZoom( defaultZoom );
    theMap.panTo( L.latLng( defaultLatPosition, defaultLngPosition ), { animate: true } );
}

export function updateDistrictOnMap(district) {
    console.log( "maps#updateDistrictOnMap(%s) called", district );
    
    let xml = getXmlHttpObject();

    let url = "https://json.geoapi.pt/distrito/" + district;

    // Using GET
    xml.open( "GET", url, true );
    xml.onreadystatechange = () => {
        if( xml.readyState === XMLHttpRequest.DONE ) {
            console.log( "maps#updateDistrictOnMap(%s) reply called", district );
            
            let data = JSON.parse( xml.responseText )[ "geojson" ];
            let centroidDistrict = data[ 'properties' ][ 'centros' ][ 'centroide' ];
            let boundingBox = data[ 'bbox' ];

            resetLayers();
            resetPins();

            theMap.addLayer( (layerDistrict = L.geoJSON( data, {color: 'red'} )) );
            theMap.addLayer( (pinDistrict = new L.Marker( [centroidDistrict[1], centroidDistrict[0] ], { title: district } )) );

            theMap.flyToBounds( L.latLngBounds( L.latLng( boundingBox[1], boundingBox[0] ), L.latLng( boundingBox[3], boundingBox[2] ) ) );
        }
    };
    xml.send( null );
}

export function updateCountyOnMap(county) {
    console.log( "maps#updateCountyOnMap(%s) called", county );
    
    let xml = getXmlHttpObject();

    let url = "https://json.geoapi.pt/municipio/" + county;

    // Using GET
    xml.open( "GET", url, true );
    xml.onreadystatechange = () => {
        if( xml.readyState === XMLHttpRequest.DONE ) {
            console.log( "maps#updateCountyOnMap(%s) reply called", county );
            
            let data = JSON.parse( xml.responseText )[ "geojsons" ][ 'municipio' ];
            let centroidCounty = data[ 'properties' ][ 'centros' ][ 'centroide' ];
            let boundingBox = data[ 'bbox' ];

            if ( layerCounty!=null ) {
                theMap.removeLayer( layerCounty );
            }
            
            if ( layerPostalCode!=null ) {
                theMap.removeLayer( layerPostalCode );
            }

            if ( pinCounty!=null ) {
                theMap.removeLayer( pinCounty );
            }
            
            if ( pinPostalCode!=null ) {
                theMap.removeLayer( pinPostalCode );
            }

            theMap.addLayer( (layerCounty = L.geoJSON( data, {color: 'blue'} )) );
            theMap.addLayer( (pinCounty = new L.Marker( [centroidCounty[1], centroidCounty[0] ], { title: county } )) );

            theMap.flyToBounds( L.latLngBounds( L.latLng( boundingBox[1], boundingBox[0] ), L.latLng( boundingBox[3], boundingBox[2] ) ) );
        }
    };
    xml.send( null );
}

export function updatePostalCodeOnMap(postalCode) {
    console.log( "maps#updatePostalCodeOnMap(%s) called", postalCode );
    
    let xml = getXmlHttpObject();

    let url = "https://json.geoapi.pt/cp/" + postalCode;

    // Using GET
    xml.open( "GET", url, true );
    xml.onreadystatechange = () => {
        if( xml.readyState === XMLHttpRequest.DONE ) {
            console.log( "maps#updatePostalCodeOnMap(%s) reply called", postalCode );
            
            let rawData = JSON.parse( xml.responseText );

            let pontos = rawData[ "poligono" ];
            let centroidPostalCode = rawData[ 'centroide' ];

            if ( layerPostalCode!=null ) {
                theMap.removeLayer( layerPostalCode );
            }

            if ( pinPostalCode!=null ) {
                theMap.removeLayer( pinPostalCode );
            }
            
            if ( centroidPostalCode!=null ) {
                theMap.addLayer( (pinPostalCode = new L.Marker( [centroidPostalCode[0], centroidPostalCode[1] ], { title: postalCode } )) );
            }

            let auxElem = document.getElementById( 'postalCodeAreaMissing' );
            if ( pontos!=null ) {
                theMap.addLayer( (layerPostalCode = L.polyline( pontos, {color: 'green'} )) );
                
                theMap.flyToBounds( layerPostalCode.getBounds() );
                
                auxElem.innerHTML= "";
            }
            else {
                auxElem.innerHTML= "No data";
            }
        }
    };
    xml.send( null );
}