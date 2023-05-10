<?php
// Initialiser la session
session_start();
 
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
      <!-- Font Awesome icons (free version)-->
      <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
      
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    </head>
    <body>

      
      <?php require('php/nav.php') ?>
      <?php
                            if (isset($_SESSION['conn_success_message'])) {
                                // Afficher le message de réussite
                                $message = '<div id="conn_succes_login" class="conn_succes_login">' . $_SESSION['conn_success_message'] . '</div>';
                                // Annuler le message de réussite pour éviter de l'afficher à nouveau
                                unset($_SESSION['conn_success_message']);
                                // Afficher le message dans une div
                                echo $message;
                            }
                            ?>

      <!-- banner section start -->
      <div class="banner_section">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 padding_0">
              <div id="main_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="banner_bg">
                      <div class="banner_taital_main">
                        <h1 class="banner_taital">Fournir des soins de santé appropriés <br>
                        soins de santé pour  <br>
                        personnes âgées et les enfants</h1>
                        <p class="long_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati dolorem vero voluptatibus </p>
                        <div class="btn_main">
                          <div class="about_us"><a href="about.php">A propos</a></div>
                          <div class="about_bt"><a href="calendar.php">Prendre rendez-vous</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="banner_bg">
                      <div class="banner_taital_main">
                      <h1 class="banner_taital">Fournir des soins de santé appropriés <br>
                        soins de santé pour  <br>
                        personnes âgées et les enfants</h1>
                        <p class="long_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati dolorem vero voluptatibus </p>
                        <div class="btn_main">
                          <div class="about_us"><a href="#">À propos de nous</a></div>
                          <div class="about_bt"><a href="#">Obtenir un rendez-vous</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="banner_bg">
                      <div class="banner_taital_main">
                        <h1 class="banner_taital">Lorem ipsum dolor sit amet<br>
                        soins de santé pour  
                        <br>seniors et enfants</h1>
                        <p class="long_text">Il est établi depuis longtemps qu'un lecteur sera distrait par le contenu lisible d'une page lorsqu'il regarde sa mise en page. L'intérêt de l'utilisation du Lorem Ipsum</p>
                        <div class="btn_main">
                          <div class="about_us"><a href="#">À propos de nous</a></div>
                          <div class="about_bt"><a href="#">Obtenir un rendez-vous</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                  <i class="fa fa-angle-left"></i></a>
                <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-md-6 padding_0">
              <div class="banner_img"></div>
            </div>
          </div>
        </div>
      </div>



      <!-- banner section end -->
      <!-- about section start -->
      <div class="about_section layout_padding">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="about_taital">
                <h4 class="about_text">A propos de</h4>
                <h1 class="highest_text">Les plus hauts fournissent des soins de santé</h1>
                <p class="lorem_text">Il est établi depuis longtemps qu'un lecteur sera distrait par le contenu lisible d'une page lorsqu'il regarde sa mise en page. L'intérêt d'utiliser le Lorem Ipsum est qu'il présente une distribution plus ou moins normale des lettres, par opposition au Lorem Ipsum est qu'il présente une distribution plus ou moins normale des lettres, par opposition au Lorem Ipsum est qu'il présente une distribution plus ou moins normale des lettres, par opposition au Lorem Ipsum est qu'il présente une distribution plus ou moins normale des lettres, par opposition à la mise en page. L'intérêt d'utiliser le Lorem Ipsum est qu'il présente une distribution plus ou moins normale des lettres, par opposition à la mise en page.</p>
                <div class="read_bt"><a href="#">Lire la suite</a></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="image_2" href="#"><img src="images/img-2.png"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- about section end -->
      <!-- care section start -->
      <div class="care_section layout_padding">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="image_3" href="#"><img src="images/img-3.png"></div>
            </div>
            <div class="col-md-6">
              <div class="care_taital">
                <h4 class="finest_text">Le meilleur patient</h4>
                <h1 class="care_text">Soins et commodités</h1>
                <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,tempor Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                <div class="read_bt_2"><a href="#">Read More</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- care section end -->
      <!-- services section start -->
      <div class="services_section layout_padding">
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
              <div class="call_box">
                <div class="call_image"><img src="images/call-icon.png"></div>
                <h2 class="emergency_text">Cas d'urgence</h2>
                <h1 class="call_text">1-800-400-5768</h1>
                <p class="dolor_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod  </p>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="call_box active">
                <div class="call_image"><img src="images/time-seat-icon.png"></div>
                <h2 class="emergency_text">Horaire des médecins</h2>
                <h1 class="call_text">1-800-400-5768</h1>
                <p class="dolor_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod  </p>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="call_box">
                <div class="call_image"><img src="images/time-seat-icon.png"></div>
                <h2 class="emergency_text">Heures d'ouverture</h2>
                <h1 class="call_text">1-800-400-5768</h1>
                <p class="dolor_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod  </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- services section end -->
      <!-- doctor section start -->
      <div class="doctor_section layout_padding">
        <div class="container">
          <div class="row">
            <div class="col-md-6 padding_top0">
              <h4 class="about_text">Meilleur laboratoire</h4>
                <h1 class="highest_text">Tests disponibles</h1>
                <p class="lorem_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur </p>
                <div class="read_main">
                  <div class="read_bt"><a href="#">Lire la suite</a></div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="image_4"><img src="images/img-4.png"></div>
            </div>
          </div>
        </div>
      </div>
      <?php  require ('php/footer.php')?>
    <!-- copyright section end -->
      
    <!-- Javascript files-->
    <script>
        $(document).ready(function() {
            $('#succes_register').hide().fadeIn(1000).delay(3000).fadeOut(1000); // Cache l'élément, le fait apparaître en fondu, attend 5 secondes, puis le fait disparaître en fondu
        });
    </script>
     <script>
       $(document).ready(function() {
    var $successMsg = $('#conn_succes_login'); // stocker l'élément dans une variable pour éviter de le rechercher à chaque fois
    
    $successMsg.hide().fadeIn(3500, function() { // masquer l'élément, le faire apparaître en fondu et ajouter une fonction de rappel
        setTimeout(function() { // attendre 3 secondes avant de faire disparaître l'élément
            $successMsg.fadeOut(400); // faire disparaître l'élément en fondu
        }, 1500);
    });
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