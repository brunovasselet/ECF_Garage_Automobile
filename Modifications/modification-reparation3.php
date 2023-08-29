<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "garage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$query = "SELECT email FROM administrator WHERE email = 'admin@gmail.com'";

$result = $conn->query($query);

if ($result->num_rows === 0) {
    header("Location: /ECF_Garage_Automobile/index.php");
    exit();
}

$conn->close();
?>

<?php
// Vérifier si le formulaire a été soumis
if(isset($_POST['submit'])) {

    // Récupérer les données saisies par l'utilisateur
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=garage', 'root', 'root');

    // Préparer la requête SQL
    $stmt = $pdo->prepare("UPDATE services SET description = :description, name = :name WHERE id = '3'");

    // Exécuter la requête SQL
    $stmt->execute(array(
        ':description' => $description,
        ':name' => $name
    ));

    // Afficher un message de confirmation
    header("Location: /ECF_Garage_Automobile/gestion.php");
}
?>