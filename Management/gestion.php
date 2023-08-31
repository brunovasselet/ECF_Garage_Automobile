<?php
session_start();


if (!(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])) {

    header("Location: /ECF_Garage_Automobile/index.php");
    exit();
}


$serverIp = "127.0.0.1";
$serverPort = 3306;
$username = "root";
$password = "root";
$dbname = "garage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$email = $_SESSION["email"]; 


$sql = "SELECT * FROM administrator WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
  
    header("Location: /ECF_Garage_Automobile/index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/style.css">
    <title>Garage V. Parrot</title>

</head>

<header>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark" aria-label="Thirteenth navbar example">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="/ECF_Garage_Automobile/index.php">Garage V. Parrot</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Gestion</a>
            </li>
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
          <?php

          if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
          echo "<li class='nav-item dropdown'>
          <img class='profil dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false' src='/ECF_Garage_Automobile/img/photo_de_profil.jpg' alt='Profil'>
          <ul class='dropdown-menu'>
            <li><p class='dropdown-item'>Administrateur</p></li>
            <li><a class='dropdown-item' href='/ECF_Garage_Automobile/gestion.php'>Gestion</a></li>
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

</header>

<body>

<h2 class="gestion-staff">Gestion des Employées</h2>

<?php
try
{
  // On se connecte à MySQL
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM employees WHERE id";
$servicesStatement = $mysqlClient->prepare($sqlQuery);
$servicesStatement->execute();
$services = $servicesStatement->fetchAll();

foreach ($services as $service) {
    $email = $service["email"];
    $mdp = $service["mdp"];

    echo "<div class='d-flex justify-content-center'>
          <table class='list-employees'>
          <tbody>
          <tr>
          <td class='text-center mail-cel bold'>Email:</td>
          <td class='text-center mail-cel'>". $service["email"] ."</td>
          <td class='text-center mdp-cel bold'>Mot De Passe:</td>
          <td class='text-center mdp-cel'>". $service["mdp"] ."</td>
          </tr>
          </tbody>
          </table>
          </div>";
}
?>

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-success button-add" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#add'>Ajouter un Employé</button>
</div>

<div class="modal fade modal-employee" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="employee">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Ajout d'un Employé</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Modifications/add-employee.php">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" name="email" required>
            <label for="floatingInput">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" name="mdp" required>
            <label for="floatingPassword">Mot de Passe</label>
          </div>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="valider">Ajouter</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-danger button-supp" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#supp'>Supprimer un Employé</button>
</div>

<div class="modal fade modal-employee" id="supp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="employee">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Supprimer un Employé</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Modifications/supp-employee.php">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" name="email" required>
            <label for="floatingInput">Email</label>
          </div>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="delete_user">Supprimer</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

<h2 class="gestion-services">Gestion des Services</h2>

<?php
try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM services WHERE id='1'";
$servicesStatement = $mysqlClient->prepare($sqlQuery);
$servicesStatement->execute();
$services = $servicesStatement->fetchAll();

foreach ($services as $service) {
    $name = $service["name"];
    $description = $service["description"];
}
?>

<center><div class="carrosserie">
  <h3 class="titre-service"><?php echo $name; ?></h3>
  <p class="description-service"><?php echo $description; ?></p>
      <button class="btn btn-primary modification-service" data-bs-toggle="modal" data-bs-target="#modal-edition">Modifier</button>
        </div></center>

<!-- Modal Gestion des Services-->

<div class="modal fade modal3" id="modal-edition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-edition" style="height: 600px;">
        <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2 titre-modal-edition">Modification</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0" >

        <form class="" method="post" action="/ECF_Garage_Automobile/modifications/modification-reparation1.php">

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>">

            <textarea type="text" class="form-control rounded-3" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
          <div class="text-center">
          <button class="mb-2 btn rounded-3 btn-primary" type="submit" name="submit">Modifier</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM services WHERE id='2'";
$servicesStatement = $mysqlClient->prepare($sqlQuery);
$servicesStatement->execute();
$services = $servicesStatement->fetchAll();

foreach ($services as $service) {
    $name = $service["name"];
    $description = $service["description"];
}
?>

<center><div class="carrosserie">
  <h3 class="titre-service"><?php echo $name; ?></h3>
  <p class="description-service"><?php echo $description; ?></p>
      <button class="btn btn-primary modification-service" data-bs-toggle="modal" data-bs-target="#modal-edition1">Modifier</button>
        </div></center>

<!-- Modal Gestion des Services-->

<div class="modal fade modal3" id="modal-edition1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-edition" style="height: 600px;">
        <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2 titre-modal-edition">Modification</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0" >

        <form class="" method="post" action="/ECF_Garage_Automobile/modifications/modification-reparation2.php">

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>">

        <textarea type="text" class="form-control rounded-3" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
          <div class="text-center">
          <button class="mb-2 btn rounded-3 btn-primary" type="submit" name="submit">Modifier</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM services WHERE id='3'";
$servicesStatement = $mysqlClient->prepare($sqlQuery);
$servicesStatement->execute();
$services = $servicesStatement->fetchAll();

foreach ($services as $service) {
    $name = $service["name"];
    $description = $service["description"];
}
?>

<center><div class="carrosserie">
  <h3 class="titre-service"><?php echo $name; ?></h3>
  <p class="description-service"><?php echo $description; ?></p>
      <button class="btn btn-primary modification-service" data-bs-toggle="modal" data-bs-target="#modal-edition2">Modifier</button>
        </div></center>

<!-- Modal Gestion des Services-->

<div class="modal fade modal3" id="modal-edition2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-edition" style="height: 600px;">
        <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2 titre-modal-edition">Modification</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0" >

        <form class="" method="post" action="/ECF_Garage_Automobile/modifications/modification-reparation3.php">

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>">

            <textarea type="text" class="form-control rounded-3" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
          <div class="text-center">
          <button class="mb-2 btn rounded-3 btn-primary" type="submit" name="submit">Modifier</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>

<?php
try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM services WHERE id='4'";
$servicesStatement = $mysqlClient->prepare($sqlQuery);
$servicesStatement->execute();
$services = $servicesStatement->fetchAll();

foreach ($services as $service) {
    $name = $service["name"];
    $description = $service["description"];
}
?>

<center><div class="carrosserie">
  <h3 class="titre-service"><?php echo $name; ?></h3>
  <p class="description-service"><?php echo $description; ?></p>
      <button class="btn btn-primary modification-service" data-bs-toggle="modal" data-bs-target="#modal-edition3">Modifier</button>
        </div></center>

<!-- Modal Gestion des Services-->

<div class="modal fade modal3" id="modal-edition3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-edition" style="height: 600px;">
        <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2 titre-modal-edition">Modification</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 pt-0" >

        <form class="" method="post" action="/ECF_Garage_Automobile/modifications/modification-reparation4.php">

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>">

            <textarea type="text" class="form-control rounded-3" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
          <div class="text-center">
          <button class="mb-2 btn rounded-3 btn-primary" type="submit" name="submit">Modifier</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>

<h3 class="customers-messages">Messages Clients</h3>

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

$sqlQuery = "SELECT * FROM contact WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $lastname = $recipe["lastname"];
    $email = $recipe["email"];
    $phone = $recipe["phone"];
    $subject = $recipe["subject"];
    $message = $recipe["message"];

echo "<div class='d-flex justify-content-center'>
        <div class='list-group list-messages'>
    <a href='#' class='list-group-item list-group-item-action d-flex gap-3 py-3 bg-dark' aria-current='true'>
      <div class='d-flex gap-2 w-100 justify-content-between'>
        <div>
          <h6 class='mb-0 info-customer'>De: " . $recipe["name"] . " " .$recipe["lastname"] . " -  " . $recipe["email"] . " - " . $recipe["phone"] . "</h6>
          <h6 class='mb-0 subject-customer'>Sujet: " . $recipe["subject"] . "</h6>
          <p class='mb-0 message-customer'>Message: " . $recipe["message"] . "</p>
        </div>
        <small class='opacity-50 text-nowrap'>now</small>
      </div>
    </a>
  </div>
</div>";

    
} ?>

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-danger supp-message" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#supp-message'>Supprimer un Message</button>
</div>

<div class="modal fade modal-message" id="supp-message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="message">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Suppression d'un Message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Modifications/supp-message.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="id" required>
            <label for="floatingInput">Id du Message</label>
          </div>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="delete-score">Supprimer</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

    <script src="/ECF_Garage_Automobile/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>