<?php
// Lidhja me databazën
$servername = "localhost";
$username = "root"; // Emri i përdoruesit të databazës
$password = ""; // Fjalëkalimi i databazës
$dbname = "studio_chanel"; // Emri i databazës tuaj

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

    // Krijo një query SQL për të kontrolluar përdoruesin dhe fjalëkalimin
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Nëse përdoruesi është gjetur në databazë
    if ($result->num_rows > 0) {
        // Regjistro sesionin për përdoruesin dhe drejto në faqen tjetër
        session_start();
        $_SESSION['username'] = $username;
        header("Location: studiochanel_login.html"); // Kthe në panelin e përdoruesit
    } else {
        echo "<script>alert('Emri i përdoruesit ose fjalëkalimi janë gabim');
        window.location.href = 'index.html';</script>";    
    }
 
}

$conn->close();
?>
