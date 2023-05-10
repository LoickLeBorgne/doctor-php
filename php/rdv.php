<?php

// Initialiser la session

session_start();

// Vérification de la connexion en tant qu'administrateur

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");  // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    exit();
}
// Inclure le fichier de configuration de la BDD

require_once "config.php";

// Définir des variables et les initialiser avec des valeurs vides

$date_start = "";
$date_start_err = "";


// Traitement des données du formulaire lors de son envoi
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = trim($_POST["id"]);

    if (!empty($_POST['delete_rdv'])) { 
        // Vérifier si delete_rdv est activé
        // Préparer une déclaration de suppression
        $sql = "DELETE FROM rdv WHERE id = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lier des variables à l'instruction préparée en tant que paramètres
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Définir les paramètres
            $param_id = $id;

            // Tentative d'exécution de l'instruction préparée
            if (mysqli_stmt_execute($stmt)) {
                header('location: rdv.php');
                $_SESSION["succes_delete_rdv"] = 'Vous avez bien supprimé le rendez-vous';
                exit();
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["succes_delete_rdv"] = 'Le rendez-vous a été supprimé avec succès.';
                    header('location: rdv.php');
                    exit();
                } else {
                    echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
                }
            } else {
                echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
            }

            // Fermer la déclaration
            mysqli_stmt_close($stmt);
        }
    } else {
        $date_start = trim($_POST["date_start"]);

        if (empty(trim($_POST["date_start"]))) {
            $date_start_err = 'Veuillez sélectionner une date.';
        } else {
            $date_start = trim($_POST["date_start"]);
        }

        if (empty($date_start)) {
            $_SESSION['date_error'] = "Veuillez sélectionner une date.";
            header("location: rdv.php");
            exit();
        }


        // Vérifier les erreurs de saisie avant de mettre à jour la base de données
        if (empty($date_start_err)) {
            // Préparer une déclaration de mise à jour
            $sql = "UPDATE rdv SET date_start = ? WHERE id = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Lier des variables à l'instruction préparée en tant que paramètres
                mysqli_stmt_bind_param($stmt, "si", $param_date_start, $param_id);

                // Set parameters
                $param_id = $id;
                $param_date_start = $date_start;

                // Tentative d'exécution de l'instruction préparée
                if (mysqli_stmt_execute($stmt)) {

                    header('location: rdv.php');
                    $_SESSION["succes_modify_rdv"] = 'Vous avez bien réussi à modifier la date du rendez-vous';
                    exit();
                } else {

                    echo "Oups ! Un problème s'est produit. Veuillez réessayer plus tard.";
                }

                // Fermer la déclaration
                mysqli_stmt_close($stmt);
            }
        }
    }
}

// Récupérer les informations relatives à l'utilisateur
// On viens sélectionner le nom, prénom, la date du rendez-vous dans la BDD avec l'id du client (BDD = BASE DE DONNEES) pour pouvoir l'afficher avec une variable


$sql = "SELECT name, firstname, date_start FROM rdv WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"],);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $firstname, $date_start);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// On viens sélectionner le nom, prénom, la date du rendez-vous et on affiche la date en format 01/03/2023 et non en 03-01-2023


$sql = "SELECT id, name, firstname, date_format(date_start,'%d/%m/%Y à %H:%i') AS date_start, type_consultation, message_consultation FROM rdv";
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
    <!-- fevicon -->
    <link rel="icon" href="/images/fevicon.png" type="image/gif" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
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
            <h1 class="blog_text">Gérer les rendez-vous</h1>
            <div class="row">
                <?php
                if (isset($_SESSION['succes_modify_rdv'])) {
                    // Afficher le message de réussite
                    $message = '<div id="succes_modify_rdv" class="succes_modify_rdv">' . $_SESSION['succes_modify_rdv'] . '</div>';
                    // Annuler le message de réussite pour éviter de l'afficher à nouveau
                    unset($_SESSION['succes_modify_rdv']);
                    // Afficher le message dans une div
                    echo $message;
                }
                ?>

                <?php
                if (isset($_SESSION['date_error'])) {
                    // Afficher le message de réussite
                    $date_error = '<div id="date_error_modify_rdv" class="date_error_modify_rdv">' . $_SESSION['date_error'] . '</div>';
                    // Annuler le message de réussite pour éviter de l'afficher à nouveau
                    unset($_SESSION['date_error']);
                    // Afficher le message dans une div
                    echo $date_error;
                }
                ?>


                <?php if (isset($_SESSION["succes_delete_rdv"])) : ?>
                    <div class="succes_modify_rdv">
                        <?php echo $_SESSION["succes_delete_rdv"]; ?>
                    </div>
                    <?php unset($_SESSION["succes_delete_rdv"]); ?>
                <?php endif; ?>


                <table class="table table-striped tr-admin text-center">
                    <thead>
                        <tr>
                            <th scope="col">ID_CLIENT</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Date</th>
                            <th scope="col">Type de consultation</th>
                            <th scope="col">Message du patient</th>
                            <th scope="col">Gérer les rendez-vous</th>
                        </tr>
                    </thead>
                    <?php
                    // Boucle pour afficher les résultats avec l'id,le nom,le prénom, la date du rendez-vous, le type de consultation, et le message du client
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $name = $row["name"];
                        $firstname = $row["firstname"];
                        $date = $row["date_start"];
                        $type_consultation = $row["type_consultation"];
                        $message_consultation = $row["message_consultation"];
                        // Affichage des résultats dans une ligne du tableau
                        echo "<tr>";
                        echo "<th scope='row'>$id</th>";
                        echo "<td>$name</td>";
                        echo "<td>$firstname</td>";
                        echo "<td>$date</td>";
                        echo "<td>$type_consultation</td>";
                        echo "<td>$message_consultation</td>";
                        echo  '<td> 
                        <form action="" method="POST" name="' . $id . '">
                            <div class="login-form">

                                <div class="form-group">
                                <input type="hidden" name="id" value="' . $id . '">
                                </div>

                                <div class="form-group <?php echo (!empty($date_start_err)) ? "has-error" : ""; ?>
                                 <input type="datetime-local" id="date_start" name="date_start" value="<?php echo $date_start; ?>">
                                </div>

                                <div class="form-group">
                                <input type="submit" class="btn btn-rdv modify-rdv form-group" value="Modifier la date">
                               </div>

                                <div class="form-group">
                                 <input type="submit" class="btn btn-rdv delete-rdv" name="delete_rdv" value="Supprimer le rendez-vous">
                                 </div>

                            </div>
                        </form>
                        </td>';

                        echo "</tr>";
                    }
                    ?>


                </table>
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