<?php

// Initialiser la session

session_start();

// Inclure le fichier de configuration de la BDD

require 'php/config.php';

// Vérifier si l'id de l'article est spécifié dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

// On viens sélectionner le nom, prénom, dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable



$sql = "SELECT username FROM users WHERE id = ?";
// On prépare la requête
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

$sql = "SELECT name, firstname FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $firstname);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Récupérer les informations de l'article depuis la base de données titre,sujet,créé à (date), posté par, le nombre de commentaire
$sql = "SELECT title, object, created_at, posted_by, comment FROM news WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $title, $object, $created_at, $posted_by, $comment);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Récupérer les commentaires liés à l'article (avec l'id) depuis la base de données
$sql = "SELECT pseudo, contenu FROM commentaire WHERE news_id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pseudo, $contenu);
    $comments = [];
    //On créer une boucle pour afficher le contenu
    while (mysqli_stmt_fetch($stmt)) {
        $comments[] = ['pseudo' => $pseudo, 'contenu' => $contenu];
    }
    mysqli_stmt_close($stmt);
}

// Traiter l'envoi du commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Le champ du pseudo
    $pseudo = trim($_POST['pseudo']);
    // Le message du commentaire
    $contenu = trim($_POST['contenu']);
     //Si tout est bon on envoie dans la BDD  (BDD = BASE DE DONNEES) avec le pseudo,le message, et l'id du commentaire
    if (!empty($pseudo) && !empty($contenu)) {
        $sql = "INSERT INTO commentaire (news_id, pseudo, contenu) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "iss", $_GET['id'], $pseudo, $contenu);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: article.php?id=' . $_GET['id']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Newlife</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="./css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="/images/fevicon.png" type="image/gif" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body>
    <?php
    include('php/nav.php');
    ?>



    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="blog_text"><?php echo $title; ?></h1>
                <h2 class="sub-title"><?php echo $object; ?></h2>
                <p><?php echo $comment; ?></p>
                <h3>Posté par <?php echo $posted_by; ?> le <?php echo $created_at; ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="article.php?id=<?php echo $_GET['id']; ?>" method="POST">
                    <div class="form-group">
                        <label for="pseudo">Votre pseudo :</label>
                        <input type="text" class="form-control" name="pseudo" value="<?php echo $username ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="contenu">Votre message :</label>
                        <textarea class="form-control" name="contenu"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Poster mon commentaire</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3>Commentaires :</h3>
                <ul class="list-unstyled">
                    <?php foreach ($comments as $comment) : ?>
                        <li>
                            <strong>Pseudo :</strong> <?php echo $comment['pseudo']; ?><br>
                            <span><?php echo $comment['contenu']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php
    include('php/footer.php');
    ?>


    <!-- Javascript files-->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.0.0.min.js"></script>
    <script src="./js/plugin.js"></script>
    <!-- sidebar -->
    <script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./js/custom.js"></script>
    <!-- javascript -->
    <script src="./js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>