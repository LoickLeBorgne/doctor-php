<?php
// Initialiser la session
session_start();

// Vérification de la connexion en tant qu'administrateur

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: /blog/login.php"); // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    exit();
}

// Inclure le fichier de configuration de la BDD

require_once "config.php";

// Définir des variables et les initialiser avec des valeurs vides

$created_at = "";
$created_at_err = "";


// Récupérer les informations relatives aux articles posté

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
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- Font Awesome icons (free version)-->
      <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
      
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="../css/owl.carousel.min.css">
      <link rel="stylesheet" href="../css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    </head>

<body>
    <?php
    include('adminnav.php');
    ?>


<?php
                            if (isset($_SESSION['article_succes'])) {
                                // Afficher le message de réussite
                                $message = '<div id="article_succes" class="succes_register">' . $_SESSION['article_succes'] . '</div>';
                                // Annuler le message de réussite pour éviter de l'afficher à nouveau
                                unset($_SESSION['article_succes']);
                                // Afficher le message dans une div
                                echo $message;
                            }
                            ?>

<?php
                            if (isset($_SESSION['delete_article'])) {
                                // Afficher le message de réussite
                                $message = '<div id="delete_article" class="succes_register">' . $_SESSION['delete_article'] . '</div>';
                                // Annuler le message de réussite pour éviter de l'afficher à nouveau
                                unset($_SESSION['delete_article']);
                                // Afficher le message dans une div
                                echo $message;
                            }
                            ?>
    <div class="services_section layout_padding padding_bottom_0">
        <div class="container">
            <h1 class="blog_text">Gérer les actualité</h1>
            <a href="createnews.php" class="btn btn-primary">Créer un nouvel article</a>
            <div class="row">
                <?php
                // Boucle pour parcourir les articles posté, on récupère le titre, le sujet, créée à (date), posté par (par défaut par l'ADMINISTRATEUR), et le nombre de commentaires
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row["title"];
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
                                        <a href="/blog/article.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Lire la suite</a>
                                            <form method="post" action="delete_article.php">
                                                <input type="hidden" name="article_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
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
    <script>
        $(document).ready(function() {
            $('#article_succes').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, attend 5 secondes, puis le fait disparaître en fondu
        });
    </script>
       <script>
        $(document).ready(function() {
            $('#delete_article').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, attend 5 secondes, puis le fait disparaître en fondu
        });
    </script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.0.0.min.js"></script>
    <script src="../js/plugin.js"></script>
    <!-- sidebar -->
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../js/custom.js"></script>
    <!-- javascript -->
    <script src="../js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>