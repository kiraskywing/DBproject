<?php

$dbservername='localhost';
$dbname='NCTU_maskOrderDB';
$dbusername='root';
$dbpassword='';

try {
    $connection = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>