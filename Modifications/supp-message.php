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

if (isset($_POST["delete-score"])) {
    $id = $_POST["id"];

    $stmt = $conn->prepare("DELETE FROM contact WHERE id = :id");
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        echo "Utilisateur supprimé avec succès.";
        header("Location: /ECF_Garage_Automobile/Management/gestion-employee.php");
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
}
?>