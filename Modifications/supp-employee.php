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

if (isset($_POST["delete_user"])) {
    $email = $_POST["email"];

    $stmt = $conn->prepare("DELETE FROM employees WHERE email = :email");
    $stmt->bindParam(':email', $email);

    try {
        $stmt->execute();
        echo "Utilisateur supprimé avec succès.";
        header("Location: /ECF_Garage_Automobile/Management/gestion.php");
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
}
?>