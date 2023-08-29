<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Garage V. Parrot</title>

</head>

<header>

<?php


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "garage";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];


    $sql = "SELECT * FROM administrator WHERE email = '$email' AND mdp = '$mdp'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $_SESSION["logged_in"] = true;
        $_SESSION["email"] = $email;


        header("Location: index.php");
        exit();
    } else {
        $error_message = "Identifiants invalides.";
    }
}

?>

<div class="modal fade modal-connexion" id="connexion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="connexion">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Connexion</h1>
        <button type="button" class="btn-close" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form class="" method="post">
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

<nav class="navbar navbar-dark navbar-expand-lg bg-dark" aria-label="Thirteenth navbar example">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="">Garage V. Parrot</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Voitures D'occasions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/ECF_Garage_Automobile/contact.php">Contact</a>
            </li>
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
<?php

          if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
          echo "<li class='nav-item dropdown'>
          <img class='profil dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false' src='img/photo_de_profil.jpg' alt='Profil'>
          <ul class='dropdown-menu'>
            <li><p class='dropdown-item'>Administrateur</p></li>
            <li><a class='dropdown-item' href='gestion.php'>Gestion</a></li>
            <li><a class='dropdown-item' href='deconnexion.php'>Déconnexion</a></li>
        </ul>
    </li>";
} else {
    echo "<button class='w-100 mb-2 btn btn-lg rounded-3 btn-primary' type='submit' data-bs-toggle='modal' data-bs-target='#connexion'>Connexion</button>";
}
?>
</div>
</div>
</div>
</nav>

</header>

<body>

<div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
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
            <p>La Renault Clio 5 d'occasion.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Voir l'Offre</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item active">
      <center><img height="600px" src="/ECF_Garage_Automobile/img/Voitures/citroen-c4.jpg" alt="Image de la Renault Clio 5"></center>
        <div class="container">
          <div class="carousel-caption">
            <h1>Citroën C4</h1>
            <p>La Citroën C4 d'occasion.</p>
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
  // On se connecte à MySQL
  $mysqlClient = new PDO('mysql:host=localhost;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table recipes

$sqlQuery = "SELECT * FROM services WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// On affiche chaque recette une à une

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];

    echo "<ul>
          <div class='reparations'>
          <div class='card' style='width: 25rem;'>
          <div class='card-body'>
          <h5 class='card-title'>". $recipe["name"] ."</h5>
          <p class='card-text'>". $recipe["description"] ."</p>
          </div>
          </div>
          </div>
          </ul>";

          
    
} ?>

<h3 class="titre-horaires">Les Horaires D'ouvertures</h3>

<center><table class="horaires">
  <tbody>
  <tr>
     <td class="text-center">Jours</td>
     <td class="text-center">Matin</td>
     <td class="text-center">Après-Midi</td>
   </tr>
   <tr>
     <td class="jours">Lundi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Mardi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Mercredi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Jeudi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Vendredi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Samedi</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 18h00</td>
   </tr>
   <tr>
     <td class="jours">Dimanche</td>
     <td class="text-center">8h00 / 12h00</td>
     <td class="text-center">13h00 / 15h00</td>
   </tr>
  </tbody>
  </table>
</center>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>