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
      <title>About</title>
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
    <body>
      <!-- header section start -->
      <div class="header_section">
      <?php require('php/nav.php') ?>
      </div>
      <!-- header section end -->
      <!-- about section start -->
      <div class="about_section layout_padding">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="about_taital">
                <h4 class="about_text">A propos</h4>
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
      <!-- footer section start -->
      <!-- info section -->
      <?php  require ('php/footer.php')?>
    <!-- end info section -->
    <!-- footer section end -->
    <!-- copyright section end -->
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