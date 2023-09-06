<?php
session_start();


if (!(isset($_SESSION["logged_in_employee"]) && $_SESSION["logged_in_employee"])) {

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


$sql = "SELECT * FROM employees WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
  
    header("Location: /ECF_Garage_Automobile/index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/style.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/media.css">
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

if (isset($_SESSION["logged_in_employee"]) && $_SESSION["logged_in_employee"]) {
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

</header>

<body>

<h3 class="customers-messages">Messages Clients</h3>

<?php

try
{
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=garage;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
  die('Erreur : '.$e->getMessage());
}

$sqlQuery = "SELECT * FROM contact WHERE id";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {

    $id = $recipe["id"];
    $name = $recipe["name"];
    $lastname = $recipe["lastname"];
    $email = $recipe["email"];
    $phone = $recipe["phone"];
    $subject = $recipe["subject"];
    $message = $recipe["message"];

echo "<div class='d-flex justify-content-center'>
        <div class='list-group list-messages'>
    <a class='list-group-item list-group-item-action d-flex gap-3 py-3 bg-dark' aria-current='true'>
      <div class='d-flex gap-2 w-100 justify-content-between'>
        <div>
          <h6 class='mb-0 info-customer'>De: " . $recipe["name"] . " " .$recipe["lastname"] . " -  " . $recipe["email"] . " - " . $recipe["phone"] . "</h6>
          <h6 class='mb-0 subject-customer'>Sujet: " . $recipe["subject"] . "</h6>
          <p class='mb-0 message-customer'>Message: " . $recipe["message"] . "</p>
        </div>
        <small class='opacity-50 text-nowrap'>Id: " . $recipe["id"] . "</small>
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

<h3 class="customers-messages">Témoignages Clients</h3>

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

$sqlQuery = "SELECT * FROM testimonial WHERE approved = 0";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {
    $id = $recipe["id"];
    $name = $recipe["name"];
    $comment = $recipe["comment"];
    $score = $recipe["score"];

echo "<div class='d-flex justify-content-center'>
        <div class='list-group list-messages'>
    <a class='list-group-item list-group-item-action d-flex gap-3 py-3 bg-dark' aria-current='true'>
      <div class='d-flex gap-2 w-100 justify-content-between'>
        <div>
          <h6 class='mb-0 info-customer'>" . $recipe["name"] . "</h6><br>
          <h6 class='mb-0 subject-customer'>" . $recipe["comment"] . "</h6><br>
          <p class='mb-0 message-customer'>Note: " . $recipe["score"] . "/10</p>
          <form method='POST' action='/ECF_Garage_Automobile/Score/approved.php'>
          <input type='hidden' name='id' value='" . $recipe["id"] . "'>
          <input type='hidden' name='approved' value='1'>
          <button class='btn btn-success' type='submit' name='approve' value='Approuver'>Approuver</button>
          <button class='btn btn-danger' type='submit' name='reject' value='Rejeter'>Rejeter</button>
          </form>
        </div>
        <small class='opacity-50 text-nowrap'>Id: " . $recipe["id"] . "</small>
      </div>
    </a>
  </div>
</div>";

    
} ?>

<h3 class="customers-messages">Approuvés</h3>

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

$sqlQuery = "SELECT * FROM testimonial WHERE approved = 1";
$recipesStatement = $mysqlClient->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

foreach ($recipes as $recipe) {
    $id = $recipe["id"];
    $name = $recipe["name"];
    $comment = $recipe["comment"];
    $score = $recipe["score"];

echo "<div class='d-flex justify-content-center'>
        <div class='list-group list-messages'>
    <a class='list-group-item list-group-item-action d-flex gap-3 py-3 bg-dark' aria-current='true'>
      <div class='d-flex gap-2 w-100 justify-content-between'>
        <div>
          <h6 class='mb-0 info-customer'>" . $recipe["name"] . "</h6><br>
          <h6 class='mb-0 subject-customer'>" . $recipe["comment"] . "</h6><br>
          <p class='mb-0 message-customer'>Note: " . $recipe["score"] . "/10</p>
        </div>
        <small class='opacity-50 text-nowrap'>Id: " . $recipe["id"] . "</small>
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

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-danger supp-testimonial" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#supp-testimonial'>Supprimer un Témoignage</button>
</div>

<div class="modal fade modal-testimonial" id="supp-testimonial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="testimonial">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Suppression d'un Témoignage</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Score/supp-score.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="id" required>
            <label for="floatingInput">Id du témoignage</label>
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

<h3 class="customers-messages">Les Véhicules d'Occasion</h3>

<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-success add-vehicles" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#add-vehicle'>Ajouter un Véhicule</button>
</div>

<div class="modal fade modal-vehicle" id="add-vehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="vehicle">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Ajout d'un Véhicule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Vehicles/vehicles.php" enctype="multipart/form-data">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="name" required>
            <label for="floatingInput">Nom du Véhicule</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="price" required>
            <label for="floatingPassword">Prix du Véhicule</label>
          </div>
          <label for="file-input">
          <label for="floatingInput">Photo du Véhicule</label>
          <input id="file-input" type="file" name="file" required>
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="date"required>
            <label for="floatingInput">Date de mise en circulation du Véhicule</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="mileage"required>
            <label for="floatingInput">Kilométrage du Véhicule</label>
          </div>
          <textarea type="text" class="form-control rounded-3" id="floatingInput" name="description" require="false"></textarea>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="valider">Envoyer</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>


<div class="d-flex justify-content-center">
<button class="w-30 mb-2 btn btn-lg rounded-3 btn-danger supp-vehicles" type="submit" name="valider" data-bs-toggle='modal' data-bs-target='#supp-vehicle'>Supprimer un Véhicule</button>
</div>

<div class="modal fade modal-vehicle" id="supp-vehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow" id="vehicle">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Suppression d'un Véhicule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5 pt-0">
        <form method="post" action="/ECF_Garage_Automobile/Vehicles/supp-vehicles.php" enctype="multipart/form-data">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" name="id" required>
            <label for="floatingPassword">Id du Véhicule</label>
          </div>
          <div class="text-center">
          <button class="w-30 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="delete-vehicle">Supprimer</button>
          </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>
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
    $description = $recipe["description"];

    ?>

<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 horizontal-cards justify-content-center'>
<div class='row'>

  <?php
echo "<div class='col'>
    <div class='card vehicle-card'>
            <img class='picture-card' src='/ECF_Garage_Automobile/img/Voitures/". $recipe["picture"] ."' alt='photo de voiture'>
            <div class='card-body bg-dark text-light vehicle-card-body'>
                <h3 class='card-text'>". $recipe["name"] ."</h3>
                <p class='card-text'>". $recipe["price"] ." €</p>
                <p class='card-text'>id: ". $recipe["id"] ."</p>
                <div class='d-flex justify-content-center'>
                <button class='w-30 mb-2 btn btn-lg rounded-4 btn-success details-vehicles' type='submit' data-bs-toggle='modal' data-bs-target='#". $recipe["id"] ."'>Plus</button>
                </div>
            </div>
        </div>
    </div>";

    ?>

</div>
</div>


<?php

echo "<div class='modal fade modal-details-vehicle' id='". $recipe["id"] ."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
          <div class='modal-dialog d-flex justify-content-center align-items-center height-modal'>
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
      <h5 class='specification'>Description: ". $recipe["description"] ."</h5>
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

    <script src="/ECF_Garage_Automobile/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>