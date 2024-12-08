<?php
// Lidhja me bazën e të dhënave
$servername = "localhost";
$username = "root"; // Vendosni username-in tuaj
$password = ""; // Vendosni fjalëkalimin tuaj
$dbname = "job_posts"; // Emri i bazës së të dhënave

// Krijimi i lidhjes
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo nëse lidhja është e suksesshme
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

// Filtrimi i shpalljeve sipas kategorisë
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Merr kategoritë për filtrimin
$categories = ["Gaming", "Restorant", "Shishabar", "Fastfood", "Ujeinstalues"];

// SQL për të marrë shpalljet
$sql = "SELECT * FROM posts WHERE category LIKE '%$category_filter%' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Kontrollo nëse ka rezultate
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kërko Punë</title>
    <style>
        /* Stilet për faqen */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            padding: 30px;
            color: #4CAF50;
            font-size: 32px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .filter {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .filter select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #fff;
        }

        .job-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .job-post {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
            padding: 20px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .job-post:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .job-post h3 {
            color: #4CAF50;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .job-post p {
            font-size: 14px;
            margin: 8px 0;
        }

        .job-post p strong {
            color: #333;
        }

        .job-post .details {
            margin-top: 15px;
            font-size: 16px;
            text-align: center;
        }

        .job-post .details a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .job-post .details a:hover {
            color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Shih shpalljet e punës</h1>

        <!-- Filtri për kategori -->
        <div class="filter">
            <div>
                <strong>Filtroni sipas pozites:</strong>
                <form method="GET">
                    <select name="category" onchange="this.form.submit();">
                        <option value="">Të gjitha kategoritë</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category ?>" <?= ($category == $category_filter) ? 'selected' : '' ?>><?= $category ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Lista e shpalljeve -->
        <div class="job-list">
            <?php
            if ($result->num_rows > 0) {
                // Shfaq shpalljet
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='job-post'>";
                    echo "<h3>" . $row['position'] . " - " . $row['business_name'] . "</h3>";
                    echo "<p><strong>Numri i Puntorëve:</strong> " . $row['num_employees'] . "</p>";
                    echo "<p><strong>Pagesa:</strong> " . $row['salary'] . " lekë në muaj</p>";
                    echo "<p><strong>Orët e Punes:</strong> " . $row['work_hours'] . " orë</p>";
                    echo "<p><strong>Kontakt:</strong> " . $row['contact_number'] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                    echo "<p><strong>Komente:</strong> " . $row['comments'] . "</p>";
                    echo "<div class='details'><a href='mailto:" . $row['email'] . "'>Aplikoni për këtë pozita</a></div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Nuk ka shpallje të disponueshme për këtë kategori.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>

<?php
// Mbyll lidhjen me databazën
$conn->close();
?>
