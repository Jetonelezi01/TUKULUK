<?php
// Krijimi i lidhjes me bazën e të dhënave
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studio_anida";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollimi i lidhjes
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kontrollo nëse është selektuar një datë
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vit = $_POST['vit'];
    $muaji = $_POST['muaji'];
    $dite = $_POST['dite'];
    
    // Formatimi i datës në formatin Y-m-d
    $data_selektuara = $vit . '-' . str_pad($muaji, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dite, 2, '0', STR_PAD_LEFT);
    
    // SQL për të marrë rezervimet për datën e zgjedhur
    $sql = "SELECT * FROM rezervimet WHERE data_rezervimit = '$data_selektuara' ORDER BY ora_rezervimit";
    $result = $conn->query($sql);
} else {
    $result = null;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    
    // Lidhja me databazën është e hapur nga sipër, kështu që mund të përdorim $conn për të fshirë
    $sql_delete = "DELETE FROM rezervimet WHERE id = '$delete_id'";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Rezervimi u fshi me sukses!'); window.location.href='studio_anida_shiko_rezervimet.php';</script>";
    } else {
        echo "Gabim: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Anida - Shiko Rezervimet</title>
    <style>
        /* Global styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #111;
            color: #fff;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header styles */
        header {
            background-color: #222;
            color: #fff;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: center;
            flex-direction: column;
        }

        header .logo h1 {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #ff6600;
            margin-bottom: 20px;
        }

        /* Navigation menu styles */
        nav {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        header nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        header nav ul li {
            display: inline-block;
        }

        header nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            text-transform: uppercase;
            transition: color 0.3s, transform 0.3s;
        }

        header nav ul li a:hover {
            color: #ff6600;
            transform: translateY(-5px);
        }

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 650px;
            padding: 25px;
            background-color: #222;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-top: 80px;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #ff6600;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 1.1rem;
            font-weight: bold;
            color: #ddd;
            margin-bottom: 8px;
            display: block;
        }

        select,
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #333;
            color: #fff;
            font-size: 1.1rem;
        }

        input[type="submit"] {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 15px 0;
            text-align: center;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #e65c00;
        }

        /* Results Container */
        .results-container {
            margin-top: 30px;
            color: #fff;
        }

        .reservation-item {
            background-color: #333;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .reservation-item p {
            margin: 5px 0;
        }



        .reservation-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.reservation-table th,
.reservation-table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #555;
}

.reservation-table th {
    background-color: #444;
    color: #fff;
    font-weight: bold;
}

.reservation-table td {
    background-color: #333;
    color: #fff;
}

.reservation-table tr:nth-child(even) td {
    background-color: #444;
}

.reservation-table tr:hover {
    background-color: #555;
}

        /* Mobile responsive styles */
        @media (max-width: 768px) {
            header {
                padding: 20px 15px;
            }

            header nav ul {
                display: none;
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-top: 20px;
            }

            header nav ul li a {
                font-size: 16px;
            }

            .menu-icon {
                display: flex;
            }

            /* Show menu when the icon is clicked */
            .menu-icon.open + nav ul {
                display: flex;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h1>Studio ANIDA</h1>
    </div>

    <nav>
        <ul>
        <li><a href="studioanida_login.html">Studio</a></li>
            <li><a href="studio_anida_shiko_rezervimet.php">Shiko Rezervimet</a></li>

            <li><a href="studio_anida_admin.php">Beje Rezervimin</a></li>
        </ul>
    </nav>
</header>

<div class="form-container">
    <h1>Shiko Rezervimet</h1>
    <form method="POST" action="studio_anida_shiko_rezervimet.php">
        <div class="form-group">
            <label for="vit">Viti:</label>
            <select id="vit" name="vit" required>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <!-- Add more years as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="muaji">Muaji:</label>
            <select id="muaji" name="muaji" required>
                <option value="1">Janar</option>
                <option value="2">Shkurt</option>
                <option value="3">Mars</option>
                <option value="4">Prill</option>
                <option value="5">Maj</option>
                <option value="6">Qershor</option>
                <option value="7">Korrik</option>
                <option value="8">Gusht</option>
                <option value="9">Shtator</option>
                <option value="10">Tetor</option>
                <option value="11">Nëntor</option>
                <option value="12">Dhjetor</option>
            </select>
        </div>

        <div class="form-group">
            <label for="dite">Dita:</label>
            <select id="dite" name="dite" required>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
        </div>

        <input type="submit" value="Shiko Rezervimet">
    </form>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="results-container">
        <h2>Rezervimet për datën <?php echo $data_selektuara; ?>:</h2>
        
        <!-- Tabela për shfaqjen e të dhënave -->
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Emri</th>
                    <th>Mbiemri</th>
                    <th>Kontakti</th>
                    <th>Data e Rezervimit</th>
                    <th>Ora e Rezervimit</th>
                    <th>Shuma Totale</th>
                    <th>Para-Pagesa</th>
                    <th>Borxhi</th>
                    <th>Koment</th>
                    <th style="width: 20px;" >Modifiko klientitn</th>
                    <th style="width: 20px;" >Fshije klientin</th>  <!-- Kolona e veprimeve -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['emri']; ?></td>
                        <td><?php echo $row['mbiemri']; ?></td>
                        <td><?php echo $row['kontakti']; ?></td>
                        <td><?php echo $row['data_rezervimit']; ?></td>
                        <td><?php echo $row['ora_rezervimit']; ?></td>
                        <td><?php echo $row['shuma_totale']; ?></td>
                        <td><?php echo $row['para_pagesa']; ?></td>
                        <td><?php echo $row['borxhi']; ?></td>
                        <td><?php echo $row['koment']; ?></td>
                        <td>
                            
                            <form method="GET" action="studio_anida_redakto_klientin.php" style="display:inline;">
                                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Redakto" style="background-color: #ff6600; color: white; border: none; padding: 5px 10px; width:65px; cursor: pointer; font-size: 13px;">
                            </form>
                            </td>
                            <td>
                            <form method="POST" action="studio_anida_shiko_rezervimet.php" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Fshi" style="background-color: red; color: white; border: none; padding: 5px 10px; width:55px; cursor: pointer; font-size: 13px;">
                            </form>
                            <!-- Butoni për redaktimin -->
                            </td>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
<?php elseif ($result && $result->num_rows == 0): ?>
    <div class="results-container">
        <p>Nuk ka rezervime për këtë datë.</p>
    </div>
    

<?php endif; ?>



</body>
</html>
