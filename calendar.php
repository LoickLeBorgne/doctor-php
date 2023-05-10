<?php
// Initialiser la session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}




// Inclure le fichier de configuration de la BDD

require_once "php/config.php";

// Définir des variables et les initialiser avec des valeurs vides

$name = $firstname = $date_start =  $type_consultation = $message_consultation = "";
$date_start_err = $type_consultation_err = $message_consultation_err = $name_err = $firstname_err =  "";
$succes = "";

// On viens sélectionner le nom, prénom la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable

$sql = "SELECT id, name, firstname FROM users";
$result = $link->query($sql);
// On viens sélectionner le nom, prénom, dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable

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
    // Validate username
    if (empty(trim($_POST["date_start"]))) {
        $date_start_err = "Veuillez sélectionner une date.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM rdv WHERE date_start = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_date_start);
            // Set parameters
            $param_date_start = trim($_POST["date_start"]);

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                //On stocke le résultat
                mysqli_stmt_store_result($stmt);
                $date_start = trim($_POST["date_start"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }


        // On vérifie le type de constulation

    if (empty(trim($_POST["type_consultation"]))) {
        $type_consultation_err = "Veuillez rentrer un nom.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM rdv WHERE type_consultation = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_type_consultation);
            // Définir les paramètres
            $param_type_consultation = trim($_POST["type_consultation"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                // On stocke le résultat
                mysqli_stmt_store_result($stmt);
                $type_consultation = trim($_POST["type_consultation"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }



    if (empty(trim($_POST["message_consultation"]))) {
        $message_consultation_err = "Veuillez rentrer un message pour votre rendez-vous.";
    } else {
        // Préparer une instruction de sélection
        $sql = "SELECT id FROM rdv WHERE message_consultation = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "s", $param_message_consultation);
            // Définir les paramètres
            $param_message_consultation = trim($_POST["message_consultation"]);
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
               // On stocke le résultat
                mysqli_stmt_store_result($stmt);
                $message_consultation = trim($_POST["message_consultation"]);
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }
            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    }



    // Vérifier les erreurs de saisie avant l'insertion dans la base de données
    if (empty($date_start_err) && empty($type_consultation_err) && empty($message_consultation_err) && empty($name_err) && empty($firstname_err)) {

        // Préparer une déclaration d'insertion
        $sql = "INSERT INTO rdv (date_start, type_consultation, message_consultation, name, firstname) VALUES (?,?,?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "sssss", $param_date_start, $param_type_consultation, $param_message_consultation, $param_name, $param_firstname);

            // Définir les paramètres
            $param_name = $name;
            $param_firstname = $firstname;
            $param_date_start = $date_start;
            $param_type_consultation = $type_consultation;
            $param_message_consultation = $message_consultation;
            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['rdv_succes'] = 'Vous avez bien pris rendez-vous !';
                header("location: calendar.php");
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

<body id="page-top index-body">
    <?php include('php/nav.php'); ?>





    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <div class="doctor_section layout_padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 padding_top0">
                    <?php
                            if (isset($_SESSION['rdv_succes'])) {
                                // Afficher le message de réussite
                                $message = '<div id="rdv_succes" class="succes_register">' . $_SESSION['rdv_succes'] . '</div>';
                                // Annuler le message de réussite pour éviter de l'afficher à nouveau
                                unset($_SESSION['rdv_succes']);
                                // Afficher le message dans une div
                                echo $message;
                            }
                            ?>
                        <h1 class="highest_text green">Prendre rendez-vous</h1>
                        <div class="form-login">
                            <label>Nom :</label> <br>
                            <input type="text" autocomplete="off" name="name" placeholder="<?php echo $name; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label>Prénom :</label><br>
                            <input type="text" autocomplete="off" name="firstname" placeholder="<?php echo $firstname; ?>" disabled />
                        </div>
                        <div class="form-group">
                            <label>Sélectionnez une date</label><br>
                            <input type="datetime-local" name="date_start" id='date_start'" required>
                        </div>
                        <div class=" form-group">
                            <label>Type de consultation</label>
                            <select name="type_consultation" id="type_consultation" required>
                                <option value="">--Choisissez le type de consultation--</option>
                                <option value="Consultation en ligne">Consultation en ligne</option>
                                <option value="Dermatologie">Dermatologie</option>
                                <option value="Cardiologie">Cardiologie</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Dites-nous quelques mots</label><br>
                            <input type="text" id="message_consultation" name="message_consultation" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn  bg-green" value="Prendre rendez-vous">
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="image_4"><img src="images/img-4.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    include('php/footer.php');
    ?>

    <!-- Bootstrap core JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <!-- Javascript files-->
    <!-- Javascript files-->
    <script src="./js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#rdv_succes').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, attend 5 secondes, puis le fait disparaître en fondu
        });
    </script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.0.0.min.js"></script>
    <script src="./js/plugin.js"></script>
    <!-- sidebar -->
    <script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./js/custom.js"></script>
    <!-- javascript -->
    <script src="../js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</body>

</html>