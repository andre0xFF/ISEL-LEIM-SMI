<?php

header('Content-Type: text/html; charset=utf-8');

$students = simplexml_load_file("students.xml");

echo "<pre>";
print_r($students);
echo "</pre>";
echo "<hr>";

$studentsAsXML = str_replace(
        '>',
        '&gt;',
        str_replace(
                '<',
                '&lt;',
                str_replace(
                        '&',
                        '&amp;',
                        $students->asXML())));
echo $studentsAsXML;
echo "<hr>";

$aux = $students->Student[0];
$aux->Name;

$aux2 = $students->Student[0]->Name;

echo "Name of the 1st student:\n<br>";
echo $students->Student[0]->Name . "\n<br><br>";
echo "<hr>";

echo "Show all the students:\n<br>";
foreach ($students->Student as $student) {
    echo "Name: " . $student->Name . "\n<br>";
    echo "Filiation:\n<br>";

    echo "Father: " . $student->Filiation->Father . "\n<br>";
    echo "Mother: " . $student->Filiation->Mother . "\n<br>";

    if (count($student->Filiation) > 1) {
        echo "Second Father: " . $student->Filiation[1]->Father . "\n<br>";
        echo "Second Mother: " . $student->Filiation[1]->Mother . "\n<br>";
    }

    echo "<ul>";
    echo "\n<br>IC data:\n<br>";
    echo "Number: " . $student->ic . "\n<br>";
    echo "Date: " . $student->ic['date'] . "\n<br>";
    echo "City: " . $student->ic['city'] . "\n<br>";
    echo "</ul>";

    echo "\n<br>E-mail: " . $student->email . "\n<br><br>";
}
?>