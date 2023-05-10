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

$title = $object = $created_at = $posted_by = $nb_like = $comment = $date =  "";
$title_err = $object_err = $created_at_err = $posted_by_err = $nb_like_err = $comment_err = $date_err = "";


// Récupérer les informations relatives à l'utilisateur

// On viens sélectionner le nom, prénom dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable

$sql = "SELECT name, firstname FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $firstname);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Traitement des données du formulaire lorsque celui-ci est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // On valide le titre de l'article
    if (empty(trim($_POST["title"]))) {
        $title_err = "Veuillez rentrer un titre.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM news WHERE title = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_title);
            // Définir les paramètres
            $param_title = trim($_POST["title"]);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le  résultat
                mysqli_stmt_store_result($stmt);

                // Si il y déjà le même titre, alors on affiche un message d'erreur, sinon on stock le titre
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $title_err = "Ce titre est déjà existant.";
                } else {
                    $title = trim($_POST["title"]);
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }


    // On valude le sujet
    if (empty(trim($_POST["object"]))) {
        $object_err = "Veuillez rentrer un sujet.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM news WHERE object = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_object);
            // Set parameters
            $param_object = trim($_POST["object"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le résultat
                mysqli_stmt_store_result($stmt);
                // Si le sujet est déjà existant, on affiche un message d'erreur, sinon on stock le sujet
                if (mysqli_stmt_num_rows($stmt) == 4) {
                    $object_err = "Ce sujet est déjà existant.";
                } else {
                    $object = trim($_POST["object"]);
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }


    // On vérifie qui poste le message (par défaut c'est l'administrateur)
    if (empty(trim($_POST["posted_by"]))) {
        $posted_by_err = "Impossible d'utiliser un autre pseudo que 'Admin'";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM news WHERE posted_by = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_posted_by);
            // Set parameters
            $param_posted_by = trim($_POST["posted_by"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le résultat
                mysqli_stmt_store_result($stmt); {
                    $posted_by = trim($_POST["posted_by"]);
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }

    //On défini la date par défaut (Jour actuelle du poste de l'article)

    if (empty(trim($_POST["date"]))) {
        $date_err = "Date non-valide, ou date du jour invalide";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM news WHERE created_at = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_date);
            // Set parameters
            $param_date = trim($_POST["date"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le résultat
                mysqli_stmt_store_result($stmt);
                $date = trim($_POST["date"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }

    // On vérifie qu'il y a bien le message de l'article, sinon on affiche un message d'erreur
    if (empty(trim($_POST["comment"]))) {
        $comment_err = "Veuillez écrire un message";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM news WHERE comment = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_comment);
            // Set parameters
            $param_comment = trim($_POST["comment"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stock le résultat
                mysqli_stmt_store_result($stmt);
                $comment = trim($_POST["comment"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }



    // Vérifier les erreurs de saisie des champs avant l'insertion dans la base de données
    if (empty($title_err) && empty($object_err) && empty($posted_by_err) && empty($comment_err) && empty($date_err)) {

        // Préparer une déclaration d'insertion

        $sql = "INSERT INTO news (title, object, posted_by, comment, created_at) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "sssss", $param_title, $param_object, $param_posted_by, $param_comment, $param_date);

            // Définir les paramètres
            $param_date = $date;
            $param_title = $title;
            $param_object = $object;
            $param_posted_by = $posted_by;
            $param_comment = $comment;
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // Si tout est valide, on affiche un message de succès, et on redirige l'administrateur sur la page gestion d'articles
                $_SESSION['article_succes'] = 'Votre article à été posté !';
                header("location: /blog/php/articles.php");
                exit();
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
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

<body id="page-top">
    <?php
    include('adminnav.php');
    ?>




    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <div class="doctor_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 padding_top0">
                        <h1 class="highest_text green">Créer un nouvel article</h1>
                        <div class="form-login">
                            <label>Titre <span class="dot-red">*</span></label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Sujet <span class="dot-red">*</span></label>
                            <input type="text" name="object" class="form-control <?php echo (!empty($object_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $object; ?>">
                            <span class="invalid-feedback"><?php echo $object_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Posté par : <span class="dot-red">*</span></label>
                            <input type="text" name="posted_by" class="form-control <?php echo (!empty($posted_by_err)) ? 'is-invalid' : ''; ?>" value="Admin" readonly>
                            <span class="invalid-feedback"><?php echo $posted_by_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Message <span class="dot-red">*</span></label>
                            <input type="text" name="comment" class="form-control <?php echo (!empty($comment_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $comment; ?>">
                            <span class="invalid-feedback"><?php echo $comment_err; ?></span>
                        </div>
                        <div class="form-login">
                            <label>Date <span class="dot-red">*</span></label>
                            <?php
                            date_default_timezone_set('Europe/Paris');
                            $date_heure = date('d-m-Y H:i:s');
                            ?>
                            <input type="text" name="date" value="<?php echo  $date_heure; ?>" readonly />
                            <span class="invalid-feedback"><?php echo $date_err; ?></span>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-resetpw " value="Créer un nouvel article">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image_4"><img src="images/img-4.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require('footer.php') ?>

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