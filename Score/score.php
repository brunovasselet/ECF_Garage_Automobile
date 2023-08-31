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
    $comment = $_POST["comment"];
    $score = $_POST["score"];

    $stmt = $conn->prepare("INSERT INTO testimonial (name, comment, score) VALUES (:name, :comment, :score)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":comment", $comment);
    $stmt->bindParam(":score", $score);
    
    $stmt->execute();
    header("Location: /ECF_Garage_Automobile/index.php");
}

?>