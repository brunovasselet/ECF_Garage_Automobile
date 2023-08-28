<?php

$mysqli = mysqli_connect('localhost', 'root', 'root', 'Garage');

if(!$mysqli) {
    echo "Erreur connexion BDD";
} else {
    $mail=htmlentities($_POST['mail'],ENT_QUOTES,"UTF-8");//Pour éviter les injections SQL
    $mdp=md5($_POST['mdp']);//md5() convertie une chaine de caractères en chaine de 32 caractères d'après un algorithme PHP, cf doc
    $req=mysqli_query($mysqli,"SELECT * FROM Administrator WHERE mail='$Mail' AND mdp='$Mdp'");
    if(mysqli_num_rows($req)!=1){
        echo "Mail ou mot de passe incorrect.";
    } else {
        $_SESSION['mail']=$Mail;
        header("Refresh:0, url=/ECF_Garage_Automobile/index.php");
        $TraitementFini=true;//pour cacher le formulaire
    }
}

?>