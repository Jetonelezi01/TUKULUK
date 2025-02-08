<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "punesimi"; // Emri i databazës tuaj

// Krijo lidhjen me databazën
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}

// Merr të dhënat e shpalljeve
$sql = "SELECT * FROM shpallje";
$result = $conn->query($sql);

$shpalljet = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $shpalljet[] = $row;
    }
} else {
    echo "Nuk ka shpallje.";
}

// Dërgo shpalljet në format JSON
echo json_encode($shpalljet);

$conn->close();
