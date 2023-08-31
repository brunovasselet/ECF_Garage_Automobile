<?php
$serverIp = "127.0.0.1";
$serverPort = 3306;
$username = "root";
$password = "root";
$dbname = "garage";

try {
    $conn = new PDO("mysql:host=$serverIp;port=$serverPort;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $extensions = array("jpeg","jpg","png");

    $name = $_POST["name"];
    $price = $_POST["price"];
    $picture = $file_name;
    $date = $_POST["date"];
    $mileage = $_POST["mileage"];

    $destination_path = "D:/MAMP/htdocs/ECF_Garage_Automobile/img/Voitures/" . $picture;
    move_uploaded_file($file_tmp, $destination_path);

    $sql = "INSERT INTO vehicles (name, price, picture, date, mileage) VALUES (:name, :price, :picture, :date, :mileage)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':picture', $picture);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':mileage', $mileage);

    if ($stmt->execute()) {
        header("Refresh: 0; url=/ECF_Garage_Automobile/Management/gestion-employee.php");
    } else {
        echo "Erreur: " . $stmt->errorInfo()[2];
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

$conn = null;
?>