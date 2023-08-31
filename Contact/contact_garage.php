<?php

$serverIp = "127.0.0.1";
$serverPort = 3306;
$username = "root";
$password = "root";
$dbname = "garage";

try {
    $conn = new PDO("mysql:host=$serverIp;port=$serverPort;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO contact (name, lastname, email, phone, subject, message) VALUES (:name, :lastname, :email, :phone, :subject, :message)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":subject", $subject);
    $stmt->bindParam(":message", $message);
    
    $stmt->execute();
    header("Location: /ECF_Garage_Automobile/contact.php");
}

?>