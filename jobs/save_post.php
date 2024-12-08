<?php
// Lidhja me databazën
$servername = "localhost";
$username = "root"; // Vendosni username-in tuaj
$password = ""; // Vendosni fjalëkalimin tuaj
$dbname = "job_posts"; // Emri i bazës së të dhënave

// Krijo lidhjen
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo nëse lidhja është e suksesshme
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

// Merr të dhënat nga formulari
$business_name = $_POST['business_name'];
$position = $_POST['position'];
$category = $_POST['category'];
$num_employees = $_POST['num_employees'];
$salary = $_POST['salary'];
$work_hours = $_POST['work_hours'];
$comments = $_POST['comments'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];
$facebook_id = $_POST['facebook_id'];

// Përgatitja e pyetjes për insertimin e të dhënave
$sql = "INSERT INTO posts (business_name, position, category, num_employees, salary, work_hours, comments, contact_number, email, facebook_id)
VALUES ('$business_name', '$position', '$category', '$num_employees', '$salary', '$work_hours', '$comments', '$contact_number', '$email', '$facebook_id')";

// Ekzekuto pyetjen
if ($conn->query($sql) === TRUE) {
    echo "Shpallja u ruajt me sukses!";
} else {
    echo "Gabim: " . $sql . "<br>" . $conn->error;
}

// Mbyll lidhjen me bazën
$conn->close();
?>
