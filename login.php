<?php

// Initialiser la session
session_start();

// On vérifie si l'utilisateur est connecté


if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ./index.php");
    exit;
}

// Inclure le fichier de configuration

require_once "php/config.php";


// Définir des variables et les initialiser avec des valeurs vides

$username = $password = "";
$username_err = $password_err = $login_err = "";


// Traitement des données du formulaire lors de son envoi

// L'utilisateur doit rentrer son pseudo et non le "NOM" et son mot de passe préalablement saisie sur le formulaire d'inscription

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Veuillez saisir votre nom d'utilisateur.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez saisir votre mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    // On vérifie les erreurs du formulaire de saisie avant de vérifier les informations dans la BDD 

    // Si les champs ne contiennent aucunes erreur l'utilisateur peut se connecter et on vérifie si l'utilisateur n'est pas bannie
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, is_banned FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $is_banned);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Si "is_banned" est égal à "1" alors l'utilisateur est redirigé vers la page de bannissement
                            if ($is_banned == 1) {
                                // Redirection vers la page de bannissement
                                header('Location: ban.php');
                                exit();
                            } else {
                                // Si l'utilisateur à rentrer les bonnes informations et n'est pas banni alors il est redirigé sur la page d'acceuil "index.php"
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                $_SESSION['conn_success_message'] = 'Connexion réussie !';
                                header("location: index.php");
                            }
                        } else {
                            $login_err = "Nom d'utilisateur ou mot de passe incorrect.";
                        }
                    }
                } else {
                    $login_err = "Nom d'utilisateur ou mot de passe incorrect.";
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body class="login-body">
    <?php
    include('php/nav.php');
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <?php
        if (!empty($login_err)) {
            echo '<div class="login_error">' . $login_err . '</div>';
        }
        ?>
        <div class="doctor_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 padding_top0">
                        <h1 class="highest_text green">Connectez-vous</h1>
                        <div class="form-login">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-login">
                            <input type="submit" class="btn btn-primary btn-register" value="Se connecter">
                            <p class="connect-account">Vous n'avez pas de compte ?</p><a href="register.php" class="green">Créer un compte</a>
                        </div>
                        <div class="form-login">
                            <?php
                            if (isset($_SESSION['success_message'])) {
                                // Afficher le message de réussite
                                $message = '<div id="succes_register" class="succes_register">' . $_SESSION['success_message'] . '</div>';
                                // Désactiver le message de réussite pour éviter qu'il ne s'affiche à nouveau
                                unset($_SESSION['success_message']);
                                // Afficher un message dans une div
                                echo $message;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image_4"><img src="images/img-4.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require('php/footer.php') ?>

    <!-- Javascript files-->
    <script>
        $(document).ready(function() {
            $('#succes_register').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, avec du délais
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