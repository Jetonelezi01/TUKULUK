<?php
// Lidhja me databazën
$servername = "localhost";
$username = "root"; // Emri i përdoruesit të databazës
$password = ""; // Fjalëkalimi i databazës
$dbname = "studio_anida"; // Emri i databazës tuaj

// Krijo lidhjen me databazën
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}

// Kontrollo nëse formulari është dërguar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kontrollo nëse përdoruesi ekziston tashmë
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Përdoruesi ekziston tashmë.');</script>";
    } else {
        // Fillo regjistrimin e përdoruesit
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Përdoruesi është regjistruar me sukses!');</script>";
        } else {
            echo "<script>alert('Ka ndodhur një gabim gjatë regjistrimit.');</script>";
        }
    }
}

$conn->close();
?>
