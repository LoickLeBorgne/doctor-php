<?php
// Initialiser la session
session_start();

// On vérifie si l'utilisateur est connecté

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Inclure le fichier de configuration

require_once "php/config.php";

// Définir des variables et les initialiser avec des valeurs vides
$created_at = "";
$created_at_err = "";

// On viens sélectionner le titre, le sujet, quand il à été créé, les commentaires, et qui à posté l'article dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable

$sql = "SELECT title, object, created_at, comment, posted_by FROM news WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"],);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $title, $object, $created_at, $posted_by, $comment);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

$sql = "SELECT id, title, object, created_at, posted_by, comment FROM news";
$result = mysqli_query($link, $sql);


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



    <div class="services_section layout_padding padding_bottom_0">
        <div class="container">
            <h1 class="blog_text">Actualité</h1>
            <div class="row">
                <?php
                // Boucle pour afficher le titre, l'id, le sujet, qui à créée l'article, posté par qui, et le nombre de commentaires
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row["title"];
                    $id = $row["id"];
                    $object = $row["object"];
                    $created_at = $row["created_at"];
                    $posted_by = $row["posted_by"];
                    $comment = $row["comment"];
                ?>



                    <div class="col-lg-6">
                        <div class='normal'>
                            <div class='module'>
                                <div class='thumbnail'>
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/169963/photo-1429043794791-eb8f26f44081.jpeg">
                                </div>
                                <div class='content'>
                                    <div class="category"><?php echo $title; ?></div>
                                    <h2 class='sub-title'><?php echo $object; ?></h2>
                                    <div class="description"><?php echo $comment; ?></div>
                                    <div class="meta">
                                        <span class="timestamp">
                                            Posté par: <span class="pseudo-news"><?php echo $posted_by; ?></span> <br> le <span class="date-news"><?php echo $created_at; ?></span>
                                        </span> <br>
                                        <span class="comments">
                                            <i class='fa fa-comments'></i>
                                            <a href="#"><span class="comments-news""> 39</span> <span class=" hours-news">commentaires</span></a>
                                        </span>
                                        <span class="comments"> <br>
                                        <a href="article.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lire la suite</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>




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

</html>