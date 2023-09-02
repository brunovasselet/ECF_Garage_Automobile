<?php

session_start();

if (isset($_POST['garage_action'])) {
  $action = $_POST['garage_action'];
  $_SESSION['garage_state'] = $action;
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
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
              <a class="nav-link active" aria-current="page" href="">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/ECF_Garage_Automobile/occasion.php">Véhicules</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/ECF_Garage_Automobile/contact.php">Contact</a>
            </li>
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
<?php

if (isset($_COOKIE['garage_state'])) {
  $garageState = $_COOKIE['garage_state'];

  echo "<h5 class='state'>Le Garage est : <span class='state-color'>$garageState</span></h5>";

} else {

  echo "L'état du garage est inconnu.";

}

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

<div id="myCarousel" class="carousel slide mb-6 carousel-garage" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class="active" aria-current="true"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item">
        <center><img src="/ECF_Garage_Automobile/img/Voitures/peugeot208.jpg" alt="Image de la Peugeot 208"></center>
        <div class="container">
          <div class="carousel-caption">
            <h1>Peugeot 208</h1>
            <p class="opacity-75">La peugeot 208 d'occasion.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Voir l'Offre</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
      <center><img src="/ECF_Garage_Automobile/img/Voitures/renault-clio-5.jpg" alt="Image de la Renault Clio 5"></center>
        <div class="container">
          <div class="carousel-caption">
            <h1>Renault Clio 5</h1>
            <p class="opacity-75">La Renault Clio 5 d'occasion.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Voir l'Offre</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item active">
      <center><img height="600px" src="/ECF_Garage_Automobile/img/Voitures/citroen-c4.jpg" alt="Image de la Renault Clio 5"></center>
        <div class="container">
          <div class="carousel-caption">
            <h1>Citroën C4</h1>
            <p class="opacity-75">La Citroën C4 d'occasion.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Voir l'Offre</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <h2 class="titre-services">Besoin de Réparations ?</h2>

  <?php
try
{
  $mysqlClient = new PDO('mysql:host=localhost;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM services WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];


    echo "<div class='d-flex justify-content-center'>
          <div class='card' style='width: 50rem;'>
          <div class='card-body'>
          <h5 class='card-title'>". $recipe["name"] ."</h5>
          <p class='card-text'>". $recipe["description"] ."</p>
          </div>
          </div>
          </div>
          </div>";

          
    
} ?>

</div>
</div>
</div>

<h3 class="title-testimonial">Les Témoignage Clients</h3>

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

$sqlQuery = "SELECT * FROM testimonial WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $comment = $recipe["comment"];
    $score = $recipe["score"];

echo "<div class='d-flex justify-content-center'>
        <div class='list-group list-messages'>
    <a class='list-group-item list-group-item-action d-flex gap-3 py-3 bg-dark' aria-current='true'>
      <div class='d-flex gap-2 w-100 justify-content-between'>
        <div>
          <h6 class='mb-0 info-customer'>" . $recipe["name"] . "</h6>
          <h6 class='mb-0 subject-customer'>Commentaire: <br>" . $recipe["comment"] . "</h6>
          <p class='mb-0 message-customer'>Note: " . $recipe["score"] . "/10</p>
        </div>
      </div>
    </a>
  </div>
</div>";

    
} ?>

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-success button-testimonial" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#testimonial'>Ajouter un Témoignage</button>
</div>

<div class="modal fade modal-testimonial" id="testimonial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="testimonial">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Témoignage</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Score/score.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="name" required>
            <label for="floatingInput">Nom</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="comment" required>
            <label for="floatingPassword">Commentaire</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="score" placeholder="/10" required>
            <label for="floatingPassword">Note</label>
            <p>Note sur 10.</p>
          </div>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="valider">Envoyer</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

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

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>