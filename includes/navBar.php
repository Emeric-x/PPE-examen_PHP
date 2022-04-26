<html>
<?php
require_once 'includes/head.php';
require_once './mesClasses/Cvisiteurs.php';

$oemploye = unserialize($_SESSION['visitauth']);

// obtenir la page active
$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>

<body>

  <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <!-- Brand -->
    <a class="navbar-brand" href="#">
      <abbr title="Galaxy Swiss Bourdin">GSB</abbr> Company
      <img src="img/gsb_logo2.png" alt="Galaxy Swiss Bourdin">
    </a>

    <!-- Links -->
    <ul class="navbar-nav">
      <li class="nav-item" <?= $curPageName == "espace_visiteur.php" ? "class='nav-item active'" : "class='nav-item'" ?>>
        <a class="nav-link" href="liste_visiteur.php">Accueil</a>
      </li>

      <!-- Dropdown -->
      <li class="nav-item dropdown" <?= $curPageName == "liste_visiteur.php" || $curPageName == "liste_visiteur.php" || $curPageName == "liste_medicaments.php" ? "class='nav-item dropdown active'" : "class='nav-item dropdown'" ?>>
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Listes
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="liste_visiteur.php">Liste des employés</a>
          <a class="dropdown-item" href="liste_medicaments.php">Liste des médicaments</a>
          <a class="dropdown-item" href="medicaments_mois.php">Médicaments à présenter</a>
        </div>
      </li>
      <!-- Dropdown -->
      <li class="nav-item dropdown" <?= $curPageName == "saisirFicheFrais.php" || $curPageName == "compte_rendu.php" ? "class='nav-item dropdown active'" : "class='nav-item dropdown'" ?>>
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          Mes saisies
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="saisirFicheFrais.php">Saisir mes frais</a>
          <a class="dropdown-item" href="compte_rendu.php">Saisir mon compte-rendu</a>
        </div>
      </li>

      <!-- Links -->
      <li class="nav-item">
        <a class="nav-link" href="espace_visiteur.php"><span class="glyphicon glyphicon-user"></span> Bienvenue <?php echo $oemploye->Nom ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a>
      </li>
    </ul>
  </nav>
</body>

</html>