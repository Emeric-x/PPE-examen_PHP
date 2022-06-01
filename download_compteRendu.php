<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Compte Rendu</title>
    <?php
    require_once 'includes/head.php';
    require_once 'mesClasses/Cvisiteurs.php';
    require_once 'includes/functions.php';
    require_once 'mesClasses/CcompteRendu.php';
    ?>
</head>

<body>
    <div class="container">

        <header title="rapport"></header>

        <br>
        <br>
        <br>

        <?php

        if (isset($_GET['loginChef']) && isset($_GET['mdpChef']) && isset($_GET['idVisit'])) {
            $chefRegion = json_decode(file_get_contents("http://localhost:59906/api/Authentification/verification_objChef/" . $_GET['loginChef'] . "/" . $_GET['mdpChef']));

            if ($chefRegion != null) {
                $ovisiteurs = Cvisiteurs::GetInstance();
                $oCompteRendus = CcompteRendus::GetInstance();
                $AnneeMois = getAnneeMois();

                $oVisiteur = $ovisiteurs->GetVisiteurById($_GET['idVisit']);
                $ocollComptesRendus = $oCompteRendus->GetCRByIdVisitAndAnneeMois($oVisiteur->Id, $AnneeMois);

                echo "<h2>Voici les comptes rendus déposés par " . $oVisiteur->Nom . " " . $oVisiteur->Prenom . " pour le mois de " . moisEnFrancais(date('F')) . ".</h2>";
        ?>

                <br>
                <br>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Libellé</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($ocollComptesRendus as $unCompteRendu) { ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $unCompteRendu->Libelle; ?></td>
                                <td><?php echo "<a href='pdfs/".$oVisiteur->Nom.$oVisiteur->Prenom."-CompteRendu-".$AnneeMois."-".$unCompteRendu->Id.".pdf' download>Télécharger</a>"; ?></td>
                            </tr>
                        <?php
                            $i++;
                        }

                        ?>
                    </tbody>
                </table>

        <?php
            } else {
                header('Location: seConnecter.php?isAuth=false');
            }
        }

        ?>
    </div>
</body>

</html>