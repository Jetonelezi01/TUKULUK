<?php
// Krijimi i lidhjes me bazën e të dhënave (MySQL)
$servername = "localhost";
$username = "root"; // Përdorni emrin e përdoruesit tuaj të MySQL
$password = ""; // Përdorni fjalëkalimin tuaj të MySQL
$dbname = "produktet"; // Emri i databazës që do të krijoni

// Krijimi i lidhjes
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollimi i lidhjes
if ($conn->connect_error) {
    die("Lidhja me bazën e të dhënave ka dështuar: " . $conn->connect_error);
}

// Kontrollimi që formulari është dërguar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Marrja e informacionit nga formulari
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $sellerName = $_POST['sellerName'];
    $contact = $_POST['contact'];

    // Kontrollimi dhe ruajtja e informacionit në bazën e të dhënave
    $sql = "INSERT INTO products (name, category, price, seller_name, contact) 
            VALUES ('$productName', '$category', '$price', '$sellerName', '$contact')";

    if ($conn->query($sql) === TRUE) {
        echo "Produkt shpallur me sukses!<br>";

        // Marrja e ID të fundit të produktit për t'i lidhur fotot
        $last_id = $conn->insert_id;

        // Kontrollimi i ngarkimit të fotove
        if (isset($_FILES['fileToUpload']) && count($_FILES['fileToUpload']['name']) > 0) {
            $target_dir = "uploads/";

            // Sigurohuni që dosja uploads ekziston dhe ka leje për të shkruar
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $total_files = count($_FILES['fileToUpload']['name']);
            for ($i = 0; $i < $total_files; $i++) {
                $target_file = $target_dir . basename($_FILES['fileToUpload']['name'][$i]);
                $file_tmp = $_FILES['fileToUpload']['tmp_name'][$i];

                // Krijo një emër unik për secilën foto (për të shmangur konflikte)
                $unique_filename = $target_dir . uniqid() . '-' . basename($_FILES['fileToUpload']['name'][$i]);

                // Përpjekja për ngarkimin e skedarëve
                if (move_uploaded_file($file_tmp, $unique_filename)) {
                    echo "Foto u ngarkua me sukses: " . $_FILES['fileToUpload']['name'][$i] . "<br>";

                    // Ruajtja e lidhjes së fotos me produktin në bazën e të dhënave
                    $sql = "INSERT INTO product_images (product_id, image_path) 
                            VALUES ('$last_id', '$unique_filename')";
                    if ($conn->query($sql) === TRUE) {
                        echo "Foto e lidhur me produktin.<br>";
                    } else {
                        echo "Gabim në lidhjen e fotos me produktin: " . $conn->error . "<br>";
                    }
                } else {
                    echo "Ka ndodhur një gabim gjatë ngarkimit të fotos: " . $_FILES['fileToUpload']['name'][$i] . "<br>";
                }
            }
        } else {
            echo "Nuk ka foto të ngarkuara!<br>";
        }
    } else {
        echo "Gabim në shpalljen e produktit: " . $conn->error . "<br>";
    }
}

// Mbyllja e lidhjes me bazën e të dhënave
$conn->close();
?>
