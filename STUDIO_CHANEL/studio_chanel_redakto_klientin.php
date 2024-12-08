<?php
include('db_connection.php'); // Përdorni lidhjen e databazës

// Kontrollo nëse është dërguar ID për redaktim
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    
    // SQL për të marrë të dhënat e rezervimit
    $sql_edit = "SELECT * FROM rezervimet WHERE id = '$edit_id'";
    $result_edit = $conn->query($sql_edit);
    
    if ($result_edit && $result_edit->num_rows > 0) {
        $row = $result_edit->fetch_assoc();
    } else {
        echo "Rezervimi nuk u gjet.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Chanel - Redakto Klientin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Stilet e përgjithshme */
body {
    font-family: Arial, sans-serif;
    background-color: #000; /* Sfondi i zi */
    color: #fff; /* Tekst i bardhë për kontrast */
    margin: 0;
    padding: 0;
}

header {
    background-color: #333; /* Ngjyrë gri për menunë */
    padding: 20px 0;
}

header .container {
    width: 80%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    margin: 0;
    font-size: 28px;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #007bff;
}

/* Forma për redaktimin e rezervimit */
.form-container {
    width: 60%;
    margin: 40px auto;
    background-color: #333; /* Background i errët për formën */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.form-container h2 {
    text-align: center;
    color: #fff;
    margin-bottom: 30px;
}

.form-container label {
    font-size: 16px;
    color: #fff;
    display: block;
    margin-bottom: 8px;
}

.form-container input, .form-container textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    background-color: #444;
    color: #fff;
}

.form-container input:focus, .form-container textarea:focus {
    border-color: #007bff;
    background-color: #555;
}

.form-container input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    font-size: 18px;
    border: none;
    cursor: pointer;
    padding: 12px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.form-container input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>

    <!-- Menuja lartë -->
    <header>
        <div class="container">
            <h1>Studio Chanel</h1>
            <nav>
                <ul>
                    <li><a href="studiochanel_login.html">Studio</a></li>
                    <li><a href="studio_chanel_shiko_rezervimet.php">Shiko Rezervimet</a></li>
                    <li><a href="studio_chanel_shto_rezervim.php">Shto Rezervim</a></li>
 
                </ul>
            </nav>
        </div>
    </header>

    <!-- Formulari për redaktimin -->
    <div class="form-container">
        <h2>Redakto Rezervimin</h2>
        <form method="POST" action="studio_chanel_redakto_klientin.php">
            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            
            <label for="emri">Emri:</label>
            <input type="text" id="emri" name="emri" value="<?php echo $row['emri']; ?>" required>
            
            <label for="mbiemri">Mbiemri:</label>
            <input type="text" id="mbiemri" name="mbiemri" value="<?php echo $row['mbiemri']; ?>" required>
            
            <label for="kontakti">Kontakti:</label>
            <input type="text" id="kontakti" name="kontakti" value="<?php echo $row['kontakti']; ?>" required>
            
            <label for="data_rezervimit">Data e Rezervimit:</label>
            <input type="date" id="data_rezervimit" name="data_rezervimit" value="<?php echo $row['data_rezervimit']; ?>" required>
            
            <label for="ora_rezervimit">Ora e Rezervimit:</label>
            <input type="time" id="ora_rezervimit" name="ora_rezervimit" value="<?php echo $row['ora_rezervimit']; ?>" required>
            
            <label for="shuma_totale">Shuma Totale:</label>
            <input type="number" step="0.01" id="shuma_totale" name="shuma_totale" value="<?php echo $row['shuma_totale']; ?>" required>
            
            <label for="para_pagesa">Para-Pagesa:</label>
            <input type="number" step="0.01" id="para_pagesa" name="para_pagesa" value="<?php echo $row['para_pagesa']; ?>" required>
            
            <label for="borxhi">Borxhi:</label>
            <input type="number" step="0.01" id="borxhi" name="borxhi" value="<?php echo $row['borxhi']; ?>" required>
            
            <label for="koment">Koment:</label>
            <textarea id="koment" name="koment" required><?php echo $row['koment']; ?></textarea>
            
            <input type="submit" value="Ruaj Ndryshimet">
        </form>
    </div>

    <?php
    // Pasi të dërgohet formulari, përditësojmë të dhënat
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $emri = $_POST['emri'];
        $mbiemri = $_POST['mbiemri'];
        $kontakti = $_POST['kontakti'];
        $data_rezervimit = $_POST['data_rezervimit'];
        $ora_rezervimit = $_POST['ora_rezervimit'];
        $shuma_totale = $_POST['shuma_totale'];
        $para_pagesa = $_POST['para_pagesa'];
        $borxhi = $_POST['borxhi'];
        $koment = $_POST['koment'];
        
        // SQL për përditësimin e të dhënave
        $sql_update = "UPDATE rezervimet SET 
            emri = '$emri', 
            mbiemri = '$mbiemri', 
            kontakti = '$kontakti', 
            data_rezervimit = '$data_rezervimit', 
            ora_rezervimit = '$ora_rezervimit', 
            shuma_totale = '$shuma_totale', 
            para_pagesa = '$para_pagesa', 
            borxhi = '$borxhi', 
            koment = '$koment' 
            WHERE id = '$edit_id'";

        // Ekzekutojmë pyetjen e përditësimit
        if ($conn->query($sql_update) === TRUE) {
            echo "<script>alert('Të dhënat u përditësuan me sukses!'); window.location.href='studio_chanel_shiko_rezervimet.php';</script>";
        } else {
            echo "Gabim: " . $conn->error;
        }
    }
    ?>
</body>
</html>
