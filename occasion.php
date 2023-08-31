<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en" class="h-100" data-bs-theme="dark"> 
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/style.css">
    <title>Garage V. Parrot</title>

</head>

<header>

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


  $stmt_admin = $conn->prepare("SELECT * FROM administrator WHERE email = :email AND mdp = :mdp");
  $stmt_admin->bindParam(':email', $email);
  $stmt_admin->bindParam(':mdp', $mdp);
  $stmt_admin->execute();


  $stmt_employee = $conn->prepare("SELECT * FROM employees WHERE email = :email AND mdp = :mdp");
  $stmt_employee->bindParam(':email', $email);
  $stmt_employee->bindParam(':mdp', $mdp);
  $stmt_employee->execute();

  if ($stmt_admin->rowCount() == 1) {
    $_SESSION["logged_in"] = true;
    $_SESSION["email"] = $email;
  } elseif ($stmt_employee->rowCount() == 1) {
    $_SESSION["logged_in_employee"] = true;
    $_SESSION["email"] = $email;
  } else {
      $error_message = "Identifiants invalides.";
  }
}

?>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark" aria-label="Thirteenth navbar example">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="">Garage V. Parrot</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link" href="/ECF_Garage_Automobile/index.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="">Véhicules</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/ECF_Garage_Automobile/contact.php">Contact</a>
            </li>
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
<?php

          if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
          echo "<li class='nav-item dropdown'>
          <img class='profil dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false' src='/ECF_Garage_Automobile/img/photo_de_profil.jpg' alt='Profil'>
          <ul class='dropdown-menu'>
            <li><p class='dropdown-item'>Administrateur</p></li>
            <li><a class='dropdown-item' href='/ECF_Garage_Automobile/Management/gestion.php'>Gestion</a></li>
            <li><a class='dropdown-item' href='/ECF_Garage_Automobile/deconnexion.php'>Déconnexion</a></li>
        </ul>
    </li>";
}elseif (isset($_SESSION["logged_in_employee"]) && $_SESSION["logged_in_employee"]) {
  echo "<li class='nav-item dropdown'>
  <img class='profil dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false' src='/ECF_Garage_Automobile/img/photo_de_profil.jpg' alt='Profil'>
  <ul class='dropdown-menu'>
    <li><p class='dropdown-item'>Employé</p></li>
    <li><a class='dropdown-item' href='/ECF_Garage_Automobile/Management/gestion-employee.php'>Gestion</a></li>
    <li><a class='dropdown-item' href='/ECF_Garage_Automobile/deconnexion.php'>Déconnexion</a></li>
</ul>
</li>";
} else {
    echo "<button class='w-30 mb-2 btn btn-lg rounded-3 btn-primary' type='submit' data-bs-toggle='modal' data-bs-target='#connexion'>Connexion</button>";
}
 

?>
</div>
</div>
</div>
</nav>

<div class="modal fade modal-connexion" id="connexion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="connexion">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Connexion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" name="email" placeholder="name@example.com">
            <label for="floatingInput">Adresse Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3"name="mdp" placeholder="Password">
            <label for="floatingPassword">Mot de Passe</label>
          </div>
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="valider">Connexion</button>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

</header>

<body>

<?php

try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}


$sqlQuery = "SELECT * FROM vehicles WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {

    $id = $recipe["id"];
    $name = $recipe["name"];
    $price = $recipe["price"];
    $picture = $recipe["picture"];
    $date = $recipe["date"];
    $mileage = $recipe["mileage"];

    ?>

<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 horizontal-cards marge-cards'>
<div class='row'>
  <?php
echo "<div class='col'>
    <div class='card vehicle-card'>
            <img class='picture-card' src='/ECF_Garage_Automobile/img/Voitures/". $recipe["picture"] ."' alt='photo de voiture'>
            <div class='card-body bg-dark text-light vehicle-card-body'>
                <h3 class='card-text'>". $recipe["name"] ."</h3>
                <p class='card-text'>". $recipe["price"] ." €</p>
                <div class='d-flex justify-content-center'>
                <button class='w-30 mb-2 btn btn-lg rounded-4 btn-success details-vehicles' type='submit' name='valider' data-bs-toggle='modal' data-bs-target='#". $recipe["id"] ."'>Plus</button>
                </div>
            </div>
        </div>
    </div>";

    ?>

</div>
</div>

<?php

echo "<div class='modal fade modal-details-vehicle' id='". $recipe["id"] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog d-flex justify-content-center align-items-center' style='height: 115vh;'>
    <div class='modal-content rounded-4 shadow content-vehicles' id='vehicle'>
      <div class='modal-header p-5 pb-4 border-bottom-0'>
        <h1 class='fw-bold mb-0 fs-2'>Détails du Véhicule</h1>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>

      <div class='modal-body p-5 pt-0'>
      <div class='text-center'>
      <img class='picture-vehicle' src='/ECF_Garage_Automobile/img/Voitures/". $recipe["picture"] ."' alt='photo de voiture'>
      <h3 class='vehicle-title'>". $recipe["name"] ."</h3>
      <h5 class='specification'>Prix: ". $recipe["price"] ." €</h5>
      <h5 class='specification'>Année de mise en circulation: ". $recipe["date"] ."</h5>
      <h5 class='specification'>Kilométrage: ". $recipe["mileage"] ." Km</h5>
      </div>
      <h3 class='contact-vehicle'>Nous Contacter:</h3>
      <div class='d-flex justify-content-center'>
        <form class='form-vehicle' method='post' action='/ECF_Garage_Automobile/Contact/contact_garage.php'>
        <div class='form-floating mb-3'>
        <input type='text' class='form-control rounded-3' name='name' required>
            <label for='floatingInput'>Nom</label>
            </div>
            <div class='form-floating mb-3'>
            <input type='text' class='form-control rounded-3' name='lastname' required>
            <label for='floatingInput'>Prénom</label>
            </div>
            <div class='form-floating mb-3'>
            <input type='email' class='form-control rounded-3' name='email' required>
            <label for='floatingInput'>Email</label>
            </div>
            <div class='form-floating mb-3'>
            <input type='text' class='form-control rounded-3' name='phone' required>
            <label for='floatingInput'>Numero de Téléphone</label>
            </div>
            <div class='form-floating mb-3'>
            <input type='text' class='form-control rounded-3' name='subject' value='" . $recipe["name"] . " / Identifiant: " . $recipe["id"] . "' readonly>
            <label for='floatingInput'>Sujet</label>
            </div>
            <label class='message-title-detail'>Message:</label>
            <textarea class='message-vehicle' type='text' class='form-control rounded-3' id='floatingInput' name='message'  require='false' required></textarea> 
            <button class='w-30 mb-2 btn btn-lg rounded-3 btn-primary ' type='submit' name='valider'>Envoyer</button>
          </div>
          <hr class='my-4'>
        </form>
        </div>
      </div>
    </div>
</div>
</div>";

    
} ?>

<h3 class="title-timetables">Les Horaires D'ouvertures</h3>

<div class="d-flex justify-content-center">
  <table class="horaires bg-dark">
  <tbody>
  <tr>
     <td class="text-center">Jours</td>
     <td class="text-center">Matin</td>
     <td class="text-center">Après-Midi</td>
   </tr>
   <tr>
     <td class="jours">Lundi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">14h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Mardi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">14h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Mercredi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">14h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Jeudi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">14h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Vendredi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">14h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Samedi</td>
     <td class="text-center">08h45 / 12h00</td>
     <td class="text-center">Fermé</td>
   </tr>
   <tr>
     <td class="jours">Dimanche</td>
     <td class="text-center">Fermé</td>
     <td class="text-center">Fermé</td>
   </tr>
  </tbody>
  </table>
</div>

<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2023 Company, Inc</p>
  </footer>
</div>

<script src="/ECF_Garage_Automobile/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
