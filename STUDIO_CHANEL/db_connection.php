<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studio_chanel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
