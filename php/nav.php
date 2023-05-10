<div class="header_section">
  <nav class="destop_header navbar navbar-expand-lg navbar-light bg-light">
    <div class="logo"></div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./services.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./calendar.php">Prendre rendez-vous</a>
        </li>
        <li class="nav-item">
          <a class="logo_main" href="./index.php"><img src="images/logo.png"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./about.php">A propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./news.php">Actualité</a>
        </li>
        <?php
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          echo '<li class="nav-item"><span class="username-color nav-link">Bonjour, ' . $_SESSION["username"] . '</span></li>';
          echo '<li class="nav-item"><a class="nav-link" href="./profil.php">Paramètre <i class="fa-solid fa-gear"></i></a></li>';
          echo '<li class="nav-item"><a class="nav-link" href="./php/logout.php">Se déconnecter <i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>';
        } else {
          // Vérifier si n'est pas connecté alors on affiche un bouton pour s'inscrire ou se connecter si il possède déjà un compte sur le site web

          echo '<li class="nav-item active"><a class="nav-link" href="./login.php">Se connecter</a></li>';
          echo '<li class="nav-item "><a class="nav-link" href="./register.php">S\'inscrire</a></li>';
        }
        ?>
      </ul>
    </div>
  </nav>
  <nav class="mobile_header navbar navbar-expand-lg navbar-light bg-light">
    <div class="logo"><a href="index.php"><img src="images/logo.png"></a></div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent2">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./services.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./calendar.php">Prendre rendez-vous</a>
        </li>
        <li class="nav-item">
          <a class="logo_main" href="./index.php"><img src="images/logo.png"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./about.php">A propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./news.php">Actualité</a>
        </li>
        <?php
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          echo '<li class="nav-item"><a class="nav-link" href="./profil.php">Paramètre <i class="fa-solid fa-gear"></i></a></li>';
          echo '<li class="nav-item"><a class="nav-link" href="./php/logout.php">Se déconnecter <i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>';
          echo '<li class="nav-item"><a class="nav-link " href="./profil.php"><span class="username-color">Bonjour, ' . $_SESSION["username"] . '</span></a></li>';
        } else {
          echo '<li class="nav-item active"><a class="nav-link" href="./login.php">Se connecter</a></li>';
          echo '<li class="nav-item "><a class="nav-link" href="./register.php">S\'inscrire</a></li>';
        }
        ?>
      </ul>
    </div>
  </nav>
</div>
<!-- header section end -->