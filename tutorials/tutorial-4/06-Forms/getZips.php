<?php
header('Content-Type: text/html; charset=utf-8');

$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( $method=='POST') {
  $_args = $_POST;
} elseif ( $method=='GET' ) {
    $_args = $_GET;
  }
  else {
    exit(-1);
  }

$county = $_args[ "county" ];
$district = $_args[ "district" ];

$options = "";

if ( $county=="5" AND $district=="11" ) {
  $result[] = array( 'id'=>0, 'value'=>"" );
  $result[] = array( 'id'=>1, 'value'=>"2785-175" );
  $result[] = array( 'id'=>2, 'value'=>"2785-301" );
  $result[] = array( 'id'=>3, 'value'=>"2785-728" );
}
else {
  $result[] = array( 'id'=>0, 'value'=>"" );
}

echo json_encode( $result );
?>