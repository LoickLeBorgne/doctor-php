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
      <title>Blog</title>
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
      <?php require('php/nav.php') ?>
      <!-- header section end -->
      <!-- services section start -->
      <div class="services_section layout_padding padding_bottom_0">
        <div class="container">
          <h1 class="blog_text">Services</h1>
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
      <!-- footer section start -->
      <!-- info section -->
      <?php  require ('php/footer.php')?>
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