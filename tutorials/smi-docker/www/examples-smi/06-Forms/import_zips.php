<?php
set_time_limit(0);
ini_set('memory_limit', '512M');

require_once __DIR__ . '/../Lib/db.php';

define(
    'ZIP_FILE',
    '/var/www/html/examples-smi/DataCodigosPostais/cp-reduced-utf8.txt'
);

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

$file = fopen(ZIP_FILE, 'r');
if ($file === false) {
    die("Could not open zip file.\n");
}

mysqli_query($GLOBALS['ligacao'], "TRUNCATE TABLE `$dataBaseName`.`forms-zips`");

$batchSize = 1000;
$values = array();
$total = 0;

while (($row = fgetcsv($file, 0, ';')) !== false) {
    if (count($row) !== 7) {
        continue;
    }

    $idDistrict = (int)$row[0];
    $idCounty = (int)$row[1];
    $idLocation = (int)$row[2];
    $nameLocation = mysqli_real_escape_string($GLOBALS['ligacao'], trim($row[3]));
    $postalCode = mysqli_real_escape_string($GLOBALS['ligacao'], trim($row[4]));
    $postalCodeExtension = mysqli_real_escape_string($GLOBALS['ligacao'], trim($row[5]));
    $postalCodeName = mysqli_real_escape_string($GLOBALS['ligacao'], trim($row[6]));

    $values[] = "($idDistrict, $idCounty, $idLocation, '$nameLocation', '$postalCode', '$postalCodeExtension', '$postalCodeName')";

    if (count($values) >= $batchSize) {
        $sql = "INSERT INTO `$dataBaseName`.`forms-zips`
                (`idDistrict`, `idCounty`, `idLocation`, `nameLocation`, `postalCode`, `postalCodeExtension`, `postalCodeName`)
                VALUES " . implode(",\n", $values);

        if (!mysqli_query($GLOBALS['ligacao'], $sql)) {
            die("Insert error: " . mysqli_error($GLOBALS['ligacao']) . "\n");
        }

        $total += count($values);
        echo "Inserted $total rows<br>\n";
        flush();

        $values = array();
    }
}

if (!empty($values)) {
    $sql = "INSERT INTO `$dataBaseName`.`forms-zips`
            (`idDistrict`, `idCounty`, `idLocation`, `nameLocation`, `postalCode`, `postalCodeExtension`, `postalCodeName`)
            VALUES " . implode(",\n", $values);

    if (!mysqli_query($GLOBALS['ligacao'], $sql)) {
        die("Insert error: " . mysqli_error($GLOBALS['ligacao']) . "\n");
    }

    $total += count($values);
}

fclose($file);
dbDisconnect();

echo "Done. Total inserted: $total<br>\n";