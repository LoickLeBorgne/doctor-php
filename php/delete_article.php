<?php

// Initialiser la session

session_start();

// Vérification de la connexion en tant qu'administrateur

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /blog/login.php");
    exit();
}

// Inclure le fichier de configuration de la BDD


require_once "config.php";

// Si on clique sur le bouton supprimer, l'article va être supprimé de la BDD (BDD = BASE DE DONNEES)


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $article_id = trim($_POST["article_id"]);

    $sql = "DELETE FROM news WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $article_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        // Si l'article est bien supprimé, on affiche un message
        $_SESSION['delete_article'] = 'Article supprimé !';
         // Et on redirige l'admistrateur sur la page des articles
        header("Location: /blog/php/articles.php");
        exit();
    }
}
