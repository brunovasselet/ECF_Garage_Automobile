<?php
session_start();


if (!(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])) {

    header("Location: /ECF_Garage_Automobile/index.php");
    exit();
}

$servername = "localhost";
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
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Garage V. Parrot</title>

</head>

<header>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark" aria-label="Thirteenth navbar example">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="#">Garage V. Parrot</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Gestion</a>
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

<h2 class="gestion-staff">Gestion du Staff</h2>

<h2 class="gestion-services">Gestion des Services</h2>

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

$sqlQuery = "SELECT * FROM services WHERE id='1'";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// On affiche chaque recette une à une

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];
    
} ?>

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

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>" required>

            <textarea type="text" class="form-control rounded-3 description-label-visible" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
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

$sqlQuery = "SELECT * FROM services WHERE id='2'";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// On affiche chaque recette une à une

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];
    
} ?>

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

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>" required>

            <textarea type="text" class="form-control rounded-3 description-label-visible" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
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

$sqlQuery = "SELECT * FROM services WHERE id='3'";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// On affiche chaque recette une à une

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];
    
} ?>

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

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>" required>

            <textarea type="text" class="form-control rounded-3 description-label-visible" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
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

$sqlQuery = "SELECT * FROM services WHERE id='4'";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// On affiche chaque recette une à une

foreach ($recipes as $recipe) {

    $name = $recipe["name"];
    $description = $recipe["description"];
    
} ?>

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

        <input type="text" class="form-control rounded-3" id="floatingInput" name="name" value="<?php echo $name; ?>" required>

            <textarea type="text" class="form-control rounded-3 description-label-visible" id="floatingInput" name="description" placeholder="Description"  require="false"><?php echo $description; ?></textarea>
          <div class="text-center">
          <button class="mb-2 btn rounded-3 btn-primary" type="submit" name="submit">Modifier</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>