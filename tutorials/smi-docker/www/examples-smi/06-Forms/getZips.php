<?php
header('Content-Type: text/html; charset=utf-8');

require_once ("../Lib/db.php");

$district = $_GET["district"];
$county = $_GET["county"];





$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( $method=='POST') {
  $_args = $_POST;
} elseif ( $method=='GET' ) {
    $_args = $_GET;
  }
  else {
    exit(-1);
  }

$district = isset($_args["district"]) ? (int)$_args["district"] : 0;
$county = isset($_args["county"]) ? (int)$_args["county"] : 0;

  if($county <= 0 || $district <= 0){
      echo json_encode(array(array("id" => 0, "value" => 0)));
      exit();
  }


dbConnect(ConfigFile);
$dataBaseName = $GLOBALS["configDataBase"] -> db;
mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$queryString =
    "SELECT DISTINCT `postalCode`, `postalCodeExtension` FROM `$dataBaseName`.`forms-zips` " .
    "WHERE `idDistrict` = $district AND `idCounty` = $county ORDER BY `postalCode`, `postalCodeExtension`";


$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {
    $result[] = array('id' => 0, 'value' => "");

    while($registo = mysqli_fetch_array($queryResult)){
        $zipValue = $registo['postalCode'] . "-" . $registo['postalCodeExtension'];

        $result[] = array('id' => $zipValue, 'value' => $zipValue);
    };
} else{
    $errDesc = mysqli_error($GLOBALS['ligacao']);
    $errNumber = mysqli_errno($GLOBALS['ligacao']);

    $result[] = array('id' => -1, 'value' => "No Zip-Codes Available");
    $result[] = array('id' => -$errNumber, 'value' => $errDesc);
}

dbDisconnect();
echo json_encode($result);

?>