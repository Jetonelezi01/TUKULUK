<?php
$servername = "localhost";
$username = "root"; // Përdorni përdoruesin tuaj MySQL
$password = ""; // Përdorni fjalëkalimin tuaj për MySQL
$dbname = "marketplace"; // Emri i databazës

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}

$sql = "SELECT * FROM produktet";
$result = $conn->query($sql);

$produkte = [];
while ($row = $result->fetch_assoc()) {
    // Merrni fotot nga tabela e fotove
    $produkt_id = $row['id'];
    $foto_sql = "SELECT foto_path FROM fotot_produktit WHERE produkt_id = '$produkt_id'";
    $foto_result = $conn->query($foto_sql);
    $fotot = [];
    while ($foto_row = $foto_result->fetch_assoc()) {
        $fotot[] = $foto_row['foto_path'];
    }

    // Formatimi i datës (from YYYY-MM-DD to DD/MM/YYYY)
    $data_shpalljes = date("d/m/Y", strtotime($row['data_shpalljes']));

    // Krijoni array për çdo produkt
    $produkte[] = [
        'emri' => $row['emri'],
        'kategoria' => $row['kategoria'],
        'cmimi' => $row['cmimi'],
        'info' => $row['info'],
        'emri_shitesit' => $row['emri_shitesit'],
        'kontakti' => $row['kontakt_shitesit'],
        'data_shpalljes' => $data_shpalljes, // Shto datën e formatuar
        'fotot' => $fotot,
    ];
}

echo json_encode($produkte);

$conn->close();
?>
