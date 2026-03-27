<?php
$to = "smiaux1@gmail.com";
$subject = "PHP mail() from Docker";
$message = "If you got this, Docker PHP mail() is working.\nDate: " . date('c') . "\n";
$headers = "From: smi-docker@localhost\r\n";

$ok = mail($to, $subject, $message, $headers);
echo $ok ? "mail() sent OK" : "mail() FAILED";
