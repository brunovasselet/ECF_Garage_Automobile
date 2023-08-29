<?php

session_start();

session_unset();

session_destroy();

header("Location: /ECF_Garage_Automobile/index.php");
exit();

?>