<!DOCTYPE html>
<?php session_start(); ?>
<html>
<?php
require_once 'includes/head.php';
require_once 'mesClasses/Cvisiteurs.php';
require_once 'mesClasses/CligneFHF.php';
require_once 'mesClasses/CligneFF.php';
require_once 'mesClasses/CficheFrais.php';
require_once 'mesClasses/CfraisForfaits.php';
require_once 'includes/functions.php';

$oCurrentVisiteur = null;
if (key_exists('visitauth', $_SESSION)) {
    $oCurrentVisiteur = unserialize($_SESSION['visitauth']);
}

if (isset($_GET['idLFHF']) || isset($_POST['btnFHF'])) {
    $_SESSION['successMSG_FF'] = NULL;
}

?>

<body>
    <div class='container'>
        <?php
        if ($oCurrentVisiteur != null) {
        ?>
            <header title="saisirFF">
            </header>

            <?php

            require_once 'includes/navBar.php';

            ?>

            <?php
            $formAction = $_SERVER['PHP_SELF'];
            require_once 'includes/form_FF.php';
            ?>
            <br>
            <?php
            require 'includes/gestion-erreur.php';

            require_once 'includes/form_FHF.php';
            require_once 'includes/afficheFHF.php';
            ?>

            <br>
            <br>
        <?php
            require 'includes/gestion-erreur.php';
        } else {
            header('Location: seConnecter.php?isAuth=false');
        }
        ?>
    </div>
</body>

</html>