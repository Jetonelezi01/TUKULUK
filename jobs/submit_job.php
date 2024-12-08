<?php
// Krijo lidhjen me MySQL
$servername = "localhost";
$username = "root";
$password = "";  // Vendosni fjalëkalimin tuaj nëse përdorni një
$dbname = "job_portal";

// Krijo lidhjen
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Merr të dhënat nga formulari
$business_name = $_POST['business_name'];
$position = $_POST['position'];
$num_employees = $_POST['num_employees'];
$salary = $_POST['salary'];
$work_hours = $_POST['work_hours'];
$comments = $_POST['comments'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];

// Krijo query për të dërguar të dhënat në tabelë
$sql = "INSERT INTO job_posts (business_name, position, num_employees, salary, work_hours, comments, contact_number, email)
        VALUES ('$business_name', '$position', $num_employees, $salary, $work_hours, '$comments', '$contact_number', '$email')";

// Ekzekuto query-n
if ($conn->query($sql) === TRUE) {
    echo "Vendin e punës e shpallët me sukses!";
} else {
    echo "Gabim: " . $sql . "<br>" . $conn->error;
}

// Mbyll lidhjen
$conn->close();
?>
