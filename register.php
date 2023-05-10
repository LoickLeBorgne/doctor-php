<?php

// Initialiser la session

session_start();

// Inclure le fichier de configuration de la BDD
require_once "php/config.php";

// Définir des variables et les initialiser avec des valeurs vides
$username = $password = $confirm_password = $name = $firstname = $age =  "";
$username_err = $password_err = $confirm_password_err = $name_err = $firstname_err = $age_err = "";


// Traitement des données du formulaire lors de son envoi
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Valider le nom 
    if (empty(trim($_POST["name"]))) {
        $name_err = "Veuillez rentrer un nom.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))) {
        $name_err = "Le nom d'utilisateur ne peut contenir que des lettres";
    } else {
        // Préparer une déclaration de sélection
        $sql = "SELECT id FROM users WHERE name = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            // Régler les paramètres
            $param_name = trim($_POST["name"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le nom
                mysqli_stmt_store_result($stmt);
                $name = trim($_POST["name"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }


    // Valider le prénom 
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Veuillez rentrer un prénom";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["firstname"]))) {
        $firstname_err = "Le prénom ne peut contenir que des lettres";
    } else {
        // Préparer une déclaration de sélection
        $sql = "SELECT id FROM users WHERE firstname = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_firstname);
            // Définir les paramètres
            $param_firstname = trim($_POST["firstname"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                /* stocker le résultat */
                mysqli_stmt_store_result($stmt);
                $firstname = trim($_POST["firstname"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }

     // Valider l'âge (au minimum 18 ans sinon l'utilisateur ne peut pas créer de compte sur le site)'
    $age = intval($_POST["age"]);
    if (empty(trim($_POST["age"])) || $_POST["age"] < 18 || $_POST["age"] > 99) {
        $age_err = "Veuillez rentrer un âge valide entre 18 et 99 ans";

    } elseif (!preg_match('/[0-99]/', trim($_POST["age"]))) {
        // Preg match pour définir que des chiffres compris entre 0 et 99
        $age_err = "L'âge ne peut contenir que des chiffres.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM users WHERE age = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_age);
            // Définir les paramètres
            $param_age = trim($_POST["age"]);
            mysqli_stmt_close($stmt);
        }
    }



    // Valider le nom d'utilisateur
    if (empty(trim($_POST["username"]))) {
        $username_err = "Veuillez rentrer un nom d'utilisateur.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Le nom d'utilisateur ne peut contenir que des lettres, des chiffres et des traits de soulignement.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // On défini les paramètres
            $param_username = trim($_POST["username"]);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {

                // On stock l'username
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Ce nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }




    // Valider le mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
         // Le mot de passe doit contenir au minimum 6 caractères
        $password_err = "Le mot de passe doit comporter au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }
    // Valider le  confirmer le mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            // Si le mot de passe ne correspond pas à celui du dessus, on ne peut pas créer de compte
            $confirm_password_err = "Le mot de passe ne correspond pas.";
        }
    }

    // On vérifie les erreurs de saisie avant l'insertion dans la base de données
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err) && empty($firstname_err) && empty($age_err)) {

        // Préparer une déclaration d'insertion
        $sql = "INSERT INTO users (username, password, name, firstname, age, is_admin) VALUES (?, ?, ?, ?, ?, 0)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "ssssi", $param_username, $param_password, $param_name, $param_firstname, $param_age);

            // Régler les paramètres
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $param_name = $name;
            $param_firstname = $firstname;
            $param_age = $age;
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // Redirection vers la page de connexion si aucunes erreur à été détecté dans les champs remplis
                $_SESSION['success_message'] = 'Votre compte a été créé avec succès!';
                header("location: login.php");
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
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
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

<body id="page-top">

    <?php
    include('php/nav.php');
    ?>

     <!-- Formulaire PHP pour créer un compte sur le site web-->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
     <!-- On affiche les erreurs si il y a des champs vides / incorrectes-->
        <?php
        if (!empty($login_err)) {
            echo '<div class="login__error">' . $login_err . '</div>';
        }
        ?>
        <div class="doctor_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 padding_top0">
                        <h1 class="highest_text green">Enregistrez-vous</h1>
                        <div class="form-login">
                            <label>Nom <span class="dot-red">*</span></label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Prénom <span class="dot-red">*</span></label>
                            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                            <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Age <span class="dot-red">*</span></label>
                            <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Nom d'utilisateur <span class="dot-red">*</span></label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Mot de passe <span class="dot-red">*</span></label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Confirmez le mot de passe <span class="dot-red">*</span></label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-login">
                            <input type="submit" class="btn btn-primary btn-register" value="S'enregistrer">
                            <p class="connect-account">Vous avez déjà un compte ?</p><a href="login.php" class="green">Se connecter</a>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <!-- javascript -->
    <script src="js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>