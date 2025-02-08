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

// Merr të dhënat nga formulari
$emri_biznesit = $_POST['emri_biznesit'];
$emri_shpalljes = $_POST['emri_shpalljes'];
$pozicioni_punes = $_POST['pozicioni_punes'];
$numri_puntoreve = $_POST['numri_puntoreve'];
$pagesa_ore = isset($_POST['pagesa_ore']) ? $_POST['pagesa_ore'] : NULL;
$email_biznesit = $_POST['email_biznesit'];
$numri_biznesit = $_POST['numri_biznesit'];
$lloji_biznesit = $_POST['lloji_biznesit'];
$ore_pune = $_POST['ore_pune']; // Merr orët e punës

// Fshihet nga SQL injection
$emri_biznesit = $conn->real_escape_string($emri_biznesit);
$emri_shpalljes = $conn->real_escape_string($emri_shpalljes);
$pozicioni_punes = $conn->real_escape_string($pozicioni_punes);
$email_biznesit = $conn->real_escape_string($email_biznesit);
$numri_biznesit = $conn->real_escape_string($numri_biznesit);
$lloji_biznesit = $conn->real_escape_string($lloji_biznesit);
$ore_pune = $conn->real_escape_string($ore_pune); // Pastrimi i orëve të punës

// Dërgo të dhënat në databazë
$sql = "INSERT INTO shpallje (emri_biznesit, emri_shpalljes, pozicioni_punes, numri_puntoreve, pagesa_ore, email_biznesit, numri_biznesit, lloji_biznesit, ore_pune)
VALUES ('$emri_biznesit', '$emri_shpalljes', '$pozicioni_punes', '$numri_puntoreve', '$pagesa_ore', '$email_biznesit', '$numri_biznesit', '$lloji_biznesit', '$ore_pune')";

if ($conn->query($sql) === TRUE) {
    echo "Shpallja u ruajt me sukses!";
} else {
    echo "Gabim: " . $sql . "<br>" . $conn->error;
}

$conn->close();
