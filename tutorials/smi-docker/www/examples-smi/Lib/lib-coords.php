<?php
ini_set( 'display_errors', 'On' );
    
error_reporting( E_ALL );

function trunc($number) {
  return intval( $number );
}

function getCoordValue($rawCoordinate) {
  $valuesCoordinate = explode( "/", $rawCoordinate );
  
  $dividend = $valuesCoordinate[ 0 ];
  $divisor  = $valuesCoordinate[ 1 ];

  return $dividend / $divisor;
}

function getCoordFromEXIF($rawCoordinate, $coordRef) {
  $degrees = getCoordValue( $rawCoordinate[0] );
  $minutes = getCoordValue( $rawCoordinate[1] );
  $seconds = round( getCoordValue( $rawCoordinate[2] ), 4);
  
  return "$degrees $minutes' $seconds'' $coordRef";
}

function getCoordComponent($value) {
  $normalizedValue = str_replace(",", ".", $value);
  $normalizedValue = preg_replace('/[^0-9.\-]/', '', $normalizedValue);

  if ($normalizedValue === '' || $normalizedValue === '-' || $normalizedValue === '.') {
    return 0;
  }

  return floatval($normalizedValue);
}

// https://en.wikipedia.org/wiki/Geographic_coordinate_conversion
function convertDMS2Decimal($coord) {
  if ( $coord=="" || $coord==null ) {
    return 0;
  }

  $coord = trim($coord);
  $coordNumeric = str_replace(",", ".", $coord);

  if (is_numeric($coordNumeric)) {
    return floatval($coordNumeric);
  }

  $lastChar = strtoupper(substr( $coord, -1 ));

  if ( $lastChar === "N" || $lastChar === "E" ) {
    $factor = 1;
  }
  else if ( $lastChar === "S" || $lastChar === "W" ) {
    $factor = -1;
  }
  else {
    $factor = 1;
  }

  $components = preg_split('/\s+/', $coord);

  $degrees = isset($components[0]) ? getCoordComponent($components[0]) : 0;
  $minutes = isset($components[1]) ? getCoordComponent($components[1]) / 60 : 0;
  $seconds = isset($components[2]) ? getCoordComponent($components[2]) / 3600 : 0;

  return  ($degrees + $minutes + $seconds) * $factor;
}

// https://en.wikipedia.org/wiki/Geographic_coordinate_conversion
function convertDecimal2DMS($coord, $latitude=true) {
  $coordAbs = abs( $coord );

  $degrees = trunc( $coordAbs );

  $minutes = trunc( 60 * ( $coordAbs - $degrees ) );
  $seconds = round( (3600 * ( $coordAbs - $degrees )  - 60 * $minutes), 4);

  if ( $latitude==true ) {
    $cardinalPoint = $coord>0 ? "N" : "S" ;
  }
  else {
    $cardinalPoint = $coord>0 ? "E" : "W" ;
  }

  return "$degrees $minutes' $seconds'' $cardinalPoint";
}

function getCoordInGoogleFormat($latitude, $longitude) {
  
    return array( 
                "latitude"=> convertDMS2Decimal( $latitude ),
                "longitude"=> convertDMS2Decimal( $longitude )
                );
}

function getCoordFromGoogleFormat($latitudeDecimal, $longitudeDecimal) {
  return array(
      "latitude" => convertDecimal2DMS( $latitudeDecimal, true ),
      "longitude" => convertDecimal2DMS( $longitudeDecimal, false ),
  );
}
?>
