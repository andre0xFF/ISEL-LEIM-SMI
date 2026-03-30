<?php
    require_once("../Lib/db.php");

    $district = $_GET["district"];

    dbConnect(ConfigFile);
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);
    $queryString =
        "SELECT `idCounty`, `nameCounty` FROM `$dataBaseName`.`forms-counties` " .
        "WHERE `idDistrict`=$district";
    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

    if ($queryResult) {
        $result[] = array('idCounty' => 0, 'nameCounty' => "");

        while ($registo = mysqli_fetch_array($queryResult)) {
            $result[] = array(
                'idCounty' => $registo['idCounty'],
                'nameCounty' => $registo['nameCounty']);
        }
    } else {
        $errDesc = mysqli_error($GLOBALS['ligacao']);
        $errNumber = mysqli_errno($GLOBALS['ligacao']);

        $result[] = array(
            'idCounty' => -1,
            'nameCounty' => "No Counties Available");
        $result[] = array(
            'idCounty' => -$errNumber,
            'nameCounty' => $errDesc);
    }
    dbDisconnect();
    echo json_encode($result);
?>
