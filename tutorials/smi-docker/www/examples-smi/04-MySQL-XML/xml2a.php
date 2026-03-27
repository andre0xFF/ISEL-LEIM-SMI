<?php

header('Content-Type: text/html; charset=utf-8');

$config = simplexml_load_file("file.xml");

echo "Configurations:\n<br>";
echo "Host name: $config->Host\n<br>";
echo "Port number: $config->Port\n<br>";
echo "Data base: $config->DB\n<br>";
echo "Username: $config->Username\n<br>";
echo "Password: $config->Password\n<br>";
?>