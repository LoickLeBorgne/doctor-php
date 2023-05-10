<?php
// On définie les valeurs de la base de données, le serveur, l'identifiant, le mot de passe, et le nom de la base de données 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'clients');
 
//Si les informations sont correctes, on essaie de lancer une tentative de connection, sinon on détruit la connection avec "die"
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Vérifier la connexion
if($link === false){
    // Sinon on tue la connection et on affiche un message d'erreur
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>