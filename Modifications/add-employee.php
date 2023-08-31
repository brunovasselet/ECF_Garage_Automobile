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
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];

    $stmt = $conn->prepare("INSERT INTO employees (email, mdp) VALUES (:email, :mdp)");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":mdp", $mdp);
    
    $stmt->execute();
    header("Location: /ECF_Garage_Automobile/Management/gestion.php");
} else {

    header("Location: /ECF_Garage_Automobile/Management/gestion.php");
    die();
}
?>