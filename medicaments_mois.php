<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicaments du mois</title>

    <?php

    session_start();
    require_once 'includes/head.php';

    ?>
</head>

<body>
    <div class="container">
        <header title="listevisiteur"></header>

        <?php require_once 'includes/navBar.php'; ?>
        <br>
        <br>

        <div id="affichagePresenters"></div>

        <?php
        if (isset($_GET['sSuccessMsg'])) //vérifie si le booléen existe, (et il existe bien si on a cliqué sur le bouton sauvegarder note, auquel cas on le récupère en get càd dans l'url direct) et affiche l'alerte
        {
            echo "<script>alert('Votre note a bien été modifiée !')</script>";
        }
        ?>
    </div>

</body>

<script src=includes/script.js></script>
<script src="lib/jquery/jquery.min.js"></script>

</html>