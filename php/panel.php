<?php
// Initialiser la session

session_start();

// Vérification de la connexion en tant qu'administrateur

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php"); // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    exit();
}


// Inclure le fichier de configuration de la BDD


require_once "config.php";

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
    <!-- fevicon -->
    <link rel="icon" href="/images/fevicon.png" type="image/gif" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Scrollbar Custom CSS -->
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

    <div class="services_section layout_padding padding_bottom_0">
        <div class="container">
                <h1 class="blog_text">Panel d'administration</h1>
                <div class="row">
                <div class="col-lg-4">
                        <div class="call_box active text-center">
                            <h2 class="emergency_text">Gérer les rendez-vous</h2>
                            <div class="call_image"><img src="../images/calendaradmin.png"></div>
                            <a href="rdv.php" class="btn btn-manage ">Gérer les rendez-vous</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="call_box active text-center">
                            <h2 class="emergency_text">Gérer les utilisateurs</h2>
                            <div class="call_image"><img src="../images/useradmin.png"></div>
                            <a href="users.php" class="btn btn-manage">Gérer les utilisateurs</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="call_box active text-center">
                            <h2 class="emergency_text">Gérer les articles</h2>
                            <div class="call_image"><img src="../images/newsadmin.png"></div>
                            <a href="articles.php" class="btn btn-manage">Gérer les articles</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Javascript files-->
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