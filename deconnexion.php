<?php
   session_start();
    unset($_SESSION["login"]);
    unset($_SESSION["mdp"]);
    header("Location: index.php?msg= Vous venez de vous déconnecté");
?>
