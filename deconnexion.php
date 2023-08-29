<?php
    
session_start();
unset($_SESSION['mail']);
header("Refresh: 0; url=/ECF_Garage_Automobile/index.php");
echo "Vous avez été correctement déconnecté du site.<br><br><i>Redirection en cours, vers la page d'accueil...</i>";

?>