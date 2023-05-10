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

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Définir des variables et les initialiser avec des valeurs vides
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// On viens sélectionner le nom, prénom, l'âge dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable
$sql = "SELECT name, firstname, age FROM users WHERE id = ?";
// On prépare la requête
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $firstname, $age);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Traitement des données du formulaire lors de son envoi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valider le nouveau mot de passe
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Veuillez saisir le nouveau mot de passe.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Valider confirmer le mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }

    // Vérifier les erreurs de saisie avant de mettre à jour la base de données
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Préparer une déclaration de mise à jour
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Régler les paramètres
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // Si le mot de passe a été mis à jour avec succès, on affiche un message qui valide bien que le mot de passe à été changé.
                $_SESSION['modify_succes_pw'] = 'Votre mot de passe à été changé avec succès !';
                header("location: /blog/profil.php");
                exit();
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }

            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }

    // Fermer la connexion
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
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body id="page-top">
    <?php
    include('php/nav.php');
    ?>

    <div class="services_section layout_padding padding_bottom_0">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
                            if (isset($_SESSION['modify_succes_pw'])) {
                                // Afficher le message de la modification du mot de passe
                                $message = '<div id="modify_succes_pw" class="succes_register">' . $_SESSION['modify_succes_pw'] . '</div>';
                                // Désactiver le message  pour éviter qu'il ne s'affiche à nouveau
                                unset($_SESSION['modify_succes_pw']);
                                // Afficher un message dans une div
                                echo $message;
                            }
                            ?>
            <div class="container">
                <h1 class="blog_text">Vos informations</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="call_box active">
                            <h2 class="emergency_text">Information du compte</h2>
                            <div class="call_image active"><img src="images/users.png"></div>
                            <h2 class="emergency_text">Nom : <?php echo $name; ?></h2>
                            <h2 class="emergency_text">Prénom : <?php echo $firstname; ?></h2>
                            <h2 class="emergency_text">Age : <?php echo $age; ?></h2>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="call_box active text-center">
                            <h2 class="emergency_text">Sécurité</h2>
                            <div class="call_image"><img src="images/pass.png"></div>
                            <h2 class="emergency_text">Mot de passe</h2>
                            <div class="form-group white">
                                <label>Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                            </div>
                            <div class="form-group white">
                                <label>Confirmer le mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-resetpw " value="Rénitialiser le mot de passe">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    


    <?php require('php/footer.php') ?>

    <script>
        $(document).ready(function() {
            $('#modify_succes_pw').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu avec du délais
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