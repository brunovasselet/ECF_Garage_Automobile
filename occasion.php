<?php

session_start();

if (isset($_POST['garage_action'])) {
  $action = $_POST['garage_action'];
  $_SESSION['garage_state'] = $action;
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100" data-bs-theme="dark"> 
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/style.css">
    <link rel="stylesheet" href="/ECF_Garage_Automobile/media.css">
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

<form class="filtre-vehicles" method="POST" action="">
    <select name="priceFilter">
        <option value="Tous">Prix</option>
        <option value="1000-5000">1000 - 5000</option>
        <option value="5000-10000">5000 - 10000</option>
        <option value="10000-20000">10000 - 20000</option>
        <option value="20000-30000">20000 - 30000</option>
    </select>

    <select name="kilometersFilter">
        <option value="Tous">Kilométrage</option>
        <option value="0-10000">0 - 50000</option>
        <option value="50000-100000">50000 - 100000</option>
        <option value="100000-150000">100000 - 150000</option>
    </select>

    <select name="dateFilter">
        <option value="Tous">Date</option>
        <option value="2023">2023</option>
        <option value="2022">2022</option>
        <option value="2021">2021</option>
        <option value="2020">2020</option>
        <option value="2019">2019</option>
        <option value="2018">2018</option>
        <option value="2017">2017</option>
        <option value="2016">2016</option>
        <option value="2015">2015</option>
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        <option value="2007">2007</option>
        <option value="2006">2006</option>
        <option value="2005">2005</option>
        <option value="2004">2004</option>
        <option value="2003">2003</option>
        <option value="2002">2002</option>
        <option value="2001">2001</option>
        <option value="2000">2000</option>
        <option value="1999">1999</option>
        <option value="1998">1998</option>
        <option value="1997">1997</option>
        <option value="1996">1996</option>
        <option value="1995">1995</option>
        <option value="1994">1994</option>
        <option value="1993">1993</option>
        <option value="1992">1992</option>
        <option value="1991">1991</option>
        <option value="1990">1990</option>
        <option value="1989">1989</option>
        <option value="1988">1988</option>
        <option value="1987">1987</option>
        <option value="1986">1986</option>
        <option value="1985">1985</option>
    </select>

    <input type="submit" name="submit" value="Filtrer">
</form>

<h2 class="text-center">Résultat de votre recherche :</h2>

<?php

$dsn = "mysql:host=localhost;dbname=garage";
$username = "root";
$password = "root";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}


if(isset($_POST['submit'])){

  $priceFilter = $_POST['priceFilter'];
  $kilometersFilter = $_POST['kilometersFilter'];
  $dateFilter = $_POST['dateFilter'];


  $sql = "SELECT * FROM vehicles WHERE 1=1";

  if ($priceFilter != "Tous") {

      list($minPrice, $maxPrice) = explode("-", $priceFilter);


      if ($minPrice == "1000") {
          $minPrice = 1000;
      }

      $sql .= " AND price >= :minPrice AND price <= :maxPrice";
  }

  if ($kilometersFilter != "Tous") {

      list($minKilometers, $maxKilometers) = explode("-", $kilometersFilter);


      if ($minKilometers == "0") {
          $minKilometers = 0;
      }

      $sql .= " AND mileage >= :minKilometers AND mileage <= :maxKilometers";
  }

  if ($dateFilter != "Tous") {
      $sql .= " AND date = :dateFilter";
  }


  $stmt = $pdo->prepare($sql);


  if ($priceFilter != "Tous") {
      $stmt->bindParam(':minPrice', $minPrice, PDO::PARAM_INT);
      $stmt->bindParam(':maxPrice', $maxPrice, PDO::PARAM_INT);
  }

  if ($kilometersFilter != "Tous") {
      $stmt->bindParam(':minKilometers', $minKilometers, PDO::PARAM_INT);
      $stmt->bindParam(':maxKilometers', $maxKilometers, PDO::PARAM_INT);
  }

  if ($dateFilter != "Tous") {
      $stmt->bindParam(':dateFilter', $dateFilter, PDO::PARAM_INT);
  }


  $stmt->execute();


    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($results) > 0) {
        foreach ($results as $row) {
          ?>

          <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 horizontal-cards marge-cards justify-content-center'>
          <div class='row'>

            <?php
            echo "<div class='col'>
    <div class='card vehicle-card'>
            <img class='picture-card' src='/ECF_Garage_Automobile/img/Voitures/". $row["picture"] ."' alt='photo de voiture'>
            <div class='card-body bg-dark text-light vehicle-card-body'>
                <h3 class='card-text'>". $row["name"] ."</h3>
                <p class='card-text'>". $row["price"] ." €</p>
                <div class='d-flex justify-content-center'>
                <button class='w-30 mb-2 btn btn-lg rounded-4 btn-success details-vehicles' type='submit' name='valider' data-bs-toggle='modal' data-bs-target='#". $row["id"] ."'>Plus</button>
                </div>
            </div>
        </div>
    </div>";

    ?>

    </div>
    </div>
    
    <?php

        }
    } else {
        echo "Aucun résultat trouvé.";
    }
}
?>

<h2 class="text-center">Tous les Véhicules</h2>


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
    $description = $recipe["description"];

    ?>

<div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 horizontal-cards marge-cards justify-content-center'>
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
      <li class="nav-item"><a href="/ECF_Garage_Automobile/index.php" class="nav-link px-2 text-body-secondary">Accueil</a></li>
      <li class="nav-item"><a href="" class="nav-link px-2 text-body-secondary">Véhicules</a></li>
      <li class="nav-item"><a href="/ECF_Garage_Automobile/contact.php" class="nav-link px-2 text-body-secondary">Contact</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2023 Garage V. Parrot, Inc</p>
  </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/ECF_Garage_Automobile/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
