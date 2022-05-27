<?php
require_once 'includes/head.php';
require_once './mesClasses/Cnotes.php';

$id_visit = $_GET['id_visit'];
$id_med = $_GET['id_med'];

/* ici, on fait un nouvel objet pour déclancher une nouvelle fois le contructeur de sorte à bien récupérer 
    les notes récemment modifiées par le visiteur
*/
$onotes = new Cnotes();
$onote = $onotes->GetNoteByIdMed($id_visit, $id_med);

$SuccessMsg = false;
$oCurrentVisiteur = unserialize($_SESSION['visitauth']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Note</title>
</head>


<body>
    <div class="container">
        <?php
        if ($oCurrentVisiteur != null) {
        ?>
            <form id="zoneText" method="POST">
                <h1>Votre note sur le médicament</h1>
                <br>

                <textarea rows="11" cols="100" maxlength="1000" name="texteNote">
<?php // bien laissé collé à gauche pour éviter les espaces blancs dans l'affichage
            if ($onote != null) {
                echo $onote->Note;
            } else {
                echo "";
            }
?>
</textarea>

                <br>
                <br>

                <button type="submit" id="btnSaveNote" name="btnSaveNote">Sauvegarder</button>
            </form>


        <?php

            if (isset($_POST["btnSaveNote"])) {
                if ($onote != null) {
                    $onotes->UpdateNoteVisiteur(0, $_POST["texteNote"], $id_visit, $id_med); // 0 signifie il faut update la note
                } else {
                    $onotes->UpdateNoteVisiteur(1, $_POST["texteNote"], $id_visit, $id_med); // 1 signifie il faut insert la note
                }

                $SuccessMsg = true;

                header('Location: medicaments_mois.php?sSuccessMsg=' . $SuccessMsg);
                // on passe SuccessMsg en parametre pour indiquer le popup de validation sur la page MedicamentMois
                // (car si on le fait ici, le refresh de la page lors du clic du bouton va masquer cette popup)
            }
        } else {
            header('Location: seConnecter.php?isAuth=false');
        }
        ?>
    </div>
</body>

</html>