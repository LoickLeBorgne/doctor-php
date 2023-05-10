<?php
// Initialiser la session
session_start();
 
// Désinitialisation de toutes les variables de session
$_SESSION = array();
 
// Détruire la session.
session_destroy();
 
// Redirection vers la page de connexion
header("location: /blog/index.php");
exit;
?>