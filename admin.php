<?php
// Initialiser la session

session_start();
// Inclure le fichier de configuration de la BDD

require_once "php/config.php";

// Traiter l'envoi du commentaire


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des identifiants de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $link->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification des résultats de la requête
    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password']) && ($user['is_admin']) == 1) {
            // Si l'utilisateur est un administrateur, démarrer la session et rediriger vers la page d'administration
            $_SESSION['is_admin'] = true;        
            header('Location: ./php/panel.php');
        } else {
            // Sinon, afficher un message d'erreur
            $error = 'Identifiants invalides';
        }
    } else {
        // Aucun utilisateur trouvé avec ces identifiants
        $error = 'Identifiants invalides';
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="./css/owl.carousel.min.css">
    <link rel="stylesheet" href="./css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body class="login-body">
    <?php
    include('php/nav.php');
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <div class="doctor_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 padding_top0">
                        <h1 class="highest_text green">Panel administrateur</h1>
                        <div class="form-login">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="username" class="form-control " value="">
                        </div>
                        <div class="form-login">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-primary btn-register" value="Se connecter">
                    </div>
                    <div class="col-md-6">
                        <div class="image_4"><img src="images/img-4.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Javascript files-->
    <script>
        $(document).ready(function() {
            $('#succes_register').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, attend 5 secondes, puis le fait disparaître en fondu
        });
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <!-- javascript -->
    <script src="js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>