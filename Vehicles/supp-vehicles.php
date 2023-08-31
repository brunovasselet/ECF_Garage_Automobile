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

if (isset($_POST["delete-vehicle"])) {
    $id = $_POST["id"];

    $stmt = $conn->prepare("DELETE FROM Vehicles WHERE id = :id");
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        echo "Véhicule supprimé avec succès.";
        header("Location: /ECF_Garage_Automobile/Management/gestion-employee.php");
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de du véhicule : " . $e->getMessage();
    }
}
?>