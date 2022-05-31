<html>

<?php

require_once 'includes/head.php';
require_once './mesClasses/Cmedicaments.php';
require_once './mesClasses/Cpdf.php';

session_start();

$oCurrentVisiteur = unserialize($_SESSION['visitauth']);

?>

<body>

    <div class="container">

        <?php
        if ($oCurrentVisiteur != null) {
        ?>

            <header title="rapport"></header>

            <?php require_once 'includes/navBar.php' ?>

            <br>

            <?php echo "<h2>Bienvenue dans la rédaction des comptes-rendus " . $oCurrentVisiteur->Nom . "!</h2>" ?>

            <div id="compte_rendu">

                <form method="POST" id='formCR'>

                    <label for="auteurCR">Auteur du compte-rendu : </label><br>
                    <input type="text" name="auteurCR" placeholder='<?php echo $oCurrentVisiteur->Nom . " " . $oCurrentVisiteur->Prenom ?>' value='<?php echo $oCurrentVisiteur->Nom . " " . $oCurrentVisiteur->Prenom ?>' READONLY>

                    <br>
                    <br>

                    <label for="resumeCR">Veuillez rediger ci-dessous votre compte-rendu : </label><br>
                    <textarea id="textareaCR" type="text" name="resumeCR" placeholder="Voici mon compte-rendu..." rows="20" cols="" maxlength="3500"></textarea>

                    <br>

                    <button name="btnEnvoyerCR" id="btnEnvoyerCR" style="width:100%" type="submit">
                        <icon class="glyphicon glyphicon-send"></icon> Envoyer
                    </button>

                </form>

                <?php

                if (isset($_POST['resumeCR'])) {
                    if (!empty($_POST['resumeCR'])) {

                        $opdfs = Cpdfs::GetInstance();
                        $opdfs->generatePDF($_POST['resumeCR']);

                        $successmsg = "Votre compte-rendu a été envoyé avec succès !";
                        echo "<script>alert('" . $successmsg . "')</script>";
                    } else {

                        $errormsg = "Veuillez remplir tous les champs svp !";
                        echo "<script>alert('" . $errormsg . "')</script>";
                    }
                }

                ?>

            </div>

        <?php
        } else {
            header('Location: seConnecter.php?isAuth=false');
        }
        ?>

    </div>
</body>

</html>