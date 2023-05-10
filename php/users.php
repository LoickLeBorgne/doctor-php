<?php

session_start();

// Vérification de la connexion en tant qu'administrateur

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php"); // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté en tant qu'administrateur
    exit();
}


// Inclure le fichier de configuration de la BDD

require_once "config.php";

// Si le formulaire est envoyé on mets à jour dans la  BDD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $userId = $_POST['id'];
    $action = $_POST['action'];
    if ($action === 'ban') {
        // Bannir l'utilisateur en mettant à jour la base de données
        $stmt = $link->prepare('UPDATE users SET is_banned = 1 WHERE id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    } elseif ($action === 'unban') {
        // Débannir l'utilisateur en mettant à jour la base de données
        $stmt = $link->prepare('UPDATE users SET is_banned = 0 WHERE id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }
}

// Sélectionnez tous les utilisateurs de la base de données
$users_result = $link->query('SELECT * FROM users');


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
            <h1 class="blog_text">Gérer les utilisateur</h1>
            <div class="row">

                <div class="col-lg-12">

                    <table class="users-gestion">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sélectionnez tous les utilisateurs de la base de données
                            $users_result = $link->query('SELECT * FROM users');

                            if ($users_result !== false) {
                                // Affichez chaque utilisateur dans une boucle avec un formulaire de bannissement à côté et son ID avec un input caché
                                while ($user = $users_result->fetch_assoc()) {
                                    $banned = $user['is_banned'] ? 'Banni' : '';
                                    echo '<tr>';
                                    echo '<td>' . $user['name'] . '</td>';
                                    echo '<td>' . $user['firstname'] . '</td>';
                                    echo '<td>';
                                    // SI l'utilisateur est banni on affiche le bouton débannir
                                    if ($user['is_banned']) {
                                        echo '<form method="post" action="">
                                                <input type="hidden" name="id" value="' . $user['id'] . '">
                                                <input type="hidden" name="action" value="unban">
                                                <button class="btn btn-unban" type="submit">Débannir</button>
                                            </form>';
                                            // SI l'utilisateur n'est pas banni on affiche le bouton bannir
                                    } else {
                                        echo '<form method="post" action="">
                                                <input type="hidden" name="id" value="' . $user['id'] . '">
                                                <input type="hidden" name="action" value="ban">
                                                <button class="btn btn-ban" type="submit">Bannir</button>
                                            </form>';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // Message d'erreur si nous ne parvenons pas à récupérer les utilisateurs
                                echo "Une erreur s'est produite lors de la récupération des utilisateurs.";
                            }
                            ?>
                        </tbody>
                    </table>
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