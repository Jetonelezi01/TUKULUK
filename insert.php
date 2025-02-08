<?php
$servername = "localhost";
$username = "root"; // Përdorni përdoruesin tuaj MySQL
$password = ""; // Përdorni fjalëkalimin tuaj për MySQL
$dbname = "marketplace"; // Emri i databazës

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}

// Merrni të dhënat nga formulari
$emri = $_POST['emri'];
$kategoria = $_POST['kategoria'];
$cmimi = $_POST['cmimi'];
$info = $_POST['info'];
$emri_shitesit = $_POST['emri_shitesit'];
$kontakt_shitesit = $_POST['kontakt_shitesit'];

// Merrni datën e tanishme dhe formatoni atë si YYYY-MM-DD
$data_shpalljes = date("Y-m-d");

// Dërgoni të dhënat në databazë për produktin
$sql = "INSERT INTO produktet (emri, kategoria, cmimi, info, emri_shitesit, kontakt_shitesit, data_shpalljes) 
        VALUES ('$emri', '$kategoria', '$cmimi', '$info', '$emri_shitesit', '$kontakt_shitesit', '$data_shpalljes')";

if ($conn->query($sql) === TRUE) {
    $produkt_id = $conn->insert_id; // Merrni ID-në e produktit të sapo-insertuar

    // Kontrolloni dhe ruani fotot
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $uploaded_files = $_FILES['fotos'];

    $total_files = count($uploaded_files['name']);
    if ($total_files > 10) {
        die("Ju mund të ngarkoni deri në 10 foto vetëm.");
    }

    for ($i = 0; $i < $total_files; $i++) {
        $file_type = $uploaded_files['type'][$i];
        if (in_array($file_type, $allowed_types)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($uploaded_files['name'][$i]);

            if (move_uploaded_file($uploaded_files['tmp_name'][$i], $target_file)) {
                $sql_foto = "INSERT INTO fotot_produktit (produkt_id, foto_path) 
                             VALUES ('$produkt_id', '$target_file')";
                $conn->query($sql_foto);
            }
        }
    }

    echo "Shpallja është shtuar me sukses!";
    header("Location: blej.php");
    exit();
} else {
    echo "Gabim: " . $conn->error;
}

$conn->close();
?>
