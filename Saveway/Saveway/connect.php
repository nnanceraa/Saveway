<?php

//DB configuration Constants
$servername = "localhost";
$username = "saveway_admin";
$password = "saveway123";
$dbname = "Saveway";

//PDO Database Connection
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>