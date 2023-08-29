<?php

session_start();
$email = "email";
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
        if(isset($_SESSION['email'])){
            echo "<h1>Vous êtes déjà connecté</h1>";
        } else {
            if(isset($_POST['valider'])){
                if(!isset($_POST['email'],$_POST['mdp'])){
                    echo "Un des champs n'est pas reconnu.";
                } else {
                    $mysqli=mysqli_connect('localhost','root','root','garage');
                    if(!$mysqli) {
                        echo "Erreur de connexion à la BDD";
                    } else {
                        $Email='mail';
                        $Mdp='mdp';
                        $req=mysqli_query($mysqli,"SELECT * FROM administrator WHERE email='$Email' AND mdp='$Mdp'");
                        if(mysqli_num_rows($req)!=1){
                            echo "Mail ou mot de passe incorrect.";
                        } else {
                            $_SESSION['mail']=$Email;
                            echo "Vous êtes connecté avec succès $Email!";
                            $TraitementFini=true;
                        }
                    }
                }
            }
            if(!isset($TraitementFini)){
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
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="valider">Connexion</button>
          <hr class="my-4">
        </form>
      </div>
    </div>
</div>
</div>

                
                <?php
            }
        }
        ?>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark" aria-label="Thirteenth navbar example">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
          <a class="navbar-brand col-lg-3 me-0" href="#">Garage V. Parrot</a>
          <ul class="navbar-nav col-lg-6 justify-content-lg-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Accueil</a>
            </li>
          </ul>
          <div class="d-lg-flex col-lg-3 justify-content-lg-end">
          <?php
          if(isset($_POST['email'])){
            echo "<li class='nav-item dropdown'>
          <img class='profil dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false' src='img/photo_de_profil.jpg' alt='Profil'>
          <ul class='dropdown-menu'>
                <li><p class='dropdown-item'>Administrateur</p></li>
                <li><a class='dropdown-item' href='gestion.php'>Gestion</a></li>
                <li><a class='dropdown-item' href='deconnexion.php'>Deconnexion</a></li>
              </ul>
              </li>";
          }else{
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
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Example headline.</h1>
            <p class="opacity-75">Some representative placeholder content for the first slide of the carousel.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
        <div class="container">
          <div class="carousel-caption">
            <h1>Another example headline.</h1>
            <p>Some representative placeholder content for the second slide of the carousel.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item active">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>One more for good measure.</h1>
            <p>Some representative placeholder content for the third slide of this carousel.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
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

  <h1 class="title-services">Nos Services</h1>


    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>