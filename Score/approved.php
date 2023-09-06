<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    
    if (isset($_POST["approve"])) {
        $approved = 1; // Approuver le témoignage
    } elseif (isset($_POST["reject"])) {
        $approved = 0; // Rejeter le témoignage
    }

    // Connexion à la base de données (remplacez les informations par les vôtres)
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

    // Requête SQL pour mettre à jour le champ "approved" dans la table "testimonial"
    $sql = "UPDATE testimonial SET approved = :approved WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":approved", $approved, PDO::PARAM_INT);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Rediriger l'administrateur vers la page d'administration après la mise à jour
        header("Location: /ECF_Garage_Automobile/index.php");
        exit();
    } else {
        // Gérer les erreurs si la mise à jour échoue
        echo "Erreur lors de la mise à jour.";
        header("Location: /ECF_Garage_Automobile/index.php");
    }
}
?>