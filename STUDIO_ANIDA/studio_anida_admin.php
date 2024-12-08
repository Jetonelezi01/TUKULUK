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

// Kontrollo nëse është dërguar forma
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $emri = $_POST['emri'];
  $mbiemri = $_POST['mbiemri'];
  $kontakti = $_POST['kontakti'];
  $data_rezervimit = $_POST['data_rezervimit'];
  $ora_rezervimit = $_POST['ora_rezervimit'];
  $shuma_totale = $_POST['shuma_totale'];
  $para_pagesa = $_POST['para_pagesa'];
  $koment = $_POST['koment'];

  // Llogarit borxhin
  $borxhi = $shuma_totale - $para_pagesa;

  // Futja të dhënave në bazën e të dhënave
  $sql = "INSERT INTO rezervimet (emri, mbiemri, kontakti, data_rezervimit, ora_rezervimit, shuma_totale, para_pagesa, borxhi, koment)
  VALUES ('$emri', '$mbiemri', '$kontakti', '$data_rezervimit', '$ora_rezervimit', '$shuma_totale', '$para_pagesa', '$borxhi', '$koment')";

  if ($conn->query($sql) === TRUE) {
    echo "<div class='success-message'>Rezervimi është regjistruar me sukses!</div>";
  } else {
    echo "<div class='error-message'>Gabim: " . $sql . "<br>" . $conn->error . "</div>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Studio Anida - Rezervimet</title>
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

    /* Mobile Menu (Hamburger) */
    .menu-icon {
      display: none;
      cursor: pointer;
      flex-direction: column;
      gap: 5px;
    }

    .menu-icon div {
      width: 25px;
      height: 3px;
      background-color: #fff;
    }

    /* Mesazhi i suksesit dhe gabimit */
    .success-message {
      color: #28a745;
      background-color: #d4edda;
      padding: 15px;
      border: 1px solid #c3e6cb;
      margin-top: 20px;
      text-align: center;
      border-radius: 8px;
    }
    
    .error-message {
      color: #721c24;
      background-color: #f8d7da;
      padding: 15px;
      border: 1px solid #f5c6cb;
      margin-top: 20px;
      text-align: center;
      border-radius: 8px;
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

    input[type="text"],
    input[type="date"],
    input[type="time"],
    input[type="number"],
    textarea {
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

    textarea {
      resize: vertical;
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

    <!-- Mobile menu icon -->
    <div class="menu-icon" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>

    <!-- Navigation menu -->
    <nav>
      <ul>
        <li><a href="studioanida_login.html">Studio</a></li>
        <li><a href="studio_anida_shiko_rezervimet.php">Shiko Rezervimet</a></li>
        <li><a href="studio_anida_admin.php">Beje Rezervimin</a></li>
      </ul>
    </nav>
  </header>

  <div class="form-container">

   
    <h1>Rezervimi</h1>
    <hr style="width: 140px; justify-content: center; margin-left: 230px; ">

    <form method="POST" action="studio_anida_admin.php">
      <div class="form-group">
        <label for="emri">Emri:</label>
        <input type="text" id="emri" name="emri" required>
      </div>

      <div class="form-group">
        <label for="mbiemri">Mbiemri:</label>
        <input type="text" id="mbiemri" name="mbiemri" required>
      </div>

      <div class="form-group">
        <label for="kontakti">Kontakti:</label>
        <input type="text" id="kontakti" name="kontakti" required>
      </div>

      <div class="form-group">
        <label for="data_rezervimit">Data e Rezervimit:</label>
        <input type="date" id="data_rezervimit" name="data_rezervimit" required>
      </div>

      <div class="form-group">
        <label for="ora_rezervimit">Ora e Rezervimit:</label>
        <input type="time" id="ora_rezervimit" name="ora_rezervimit" required>
      </div>

      <div class="form-group">
        <label for="shuma_totale">Shuma Totale:</label>
        <input type="number" id="shuma_totale" name="shuma_totale" required>
      </div>

      <div class="form-group">
        <label for="para_pagesa">Para Pagesa:</label>
        <input type="number" id="para_pagesa" name="para_pagesa" required>
      </div>

      <div class="form-group">
        <label for="koment">Koment:</label>
        <textarea id="koment" name="koment" rows="4" required></textarea>
      </div>

      <input type="submit" value="Regjistro Rezervimin">
    </form>
  </div>

  <script>
    // Toggle menu for mobile
    function toggleMenu() {
      document.querySelector('.menu-icon').classList.toggle('open');
      document.querySelector('nav ul').classList.toggle('open');
    }
  </script>

</body>
</html>
