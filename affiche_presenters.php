<?php

session_start();

require_once 'includes/functions.php';
require_once 'mesClasses/Cpresenter.php';

$ovisiteur = unserialize($_SESSION['visitauth']);

?>

<div id="medocs_mois">
    <?php
    // nouvel objet car async
    $opresenters = new Cpresenters();
    $ocollPresenters = $opresenters->GetPresenterByAnneeMoisAndIdVisiteur($ovisiteur->Id);

    ?>
    <h1>
        <p title="tabvisiteur">Liste des Médicaments à présenter pour
            <?php
            echo moisEnFrancais(date('F'));
            echo ' ';
            echo date('Y');
            ?>.</p>
    </h1>

    <br>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        if ($ocollPresenters != null) {
            foreach ($ocollPresenters as $omedicament) {
        ?>
                <div class="col">
                    <div class="card h-100">
                        <?php echo "<img class='card-img-top' src='data:image/jpeg;base64," . $omedicament->Photo . "' height=400 width=200>" ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $omedicament->Nom ?></h5>
                            <p class="card-text"><button type="button" onclick="affiche_desc('<?php echo $omedicament->Description ?>')">Description détaillée</button></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a href="<?php echo "affiche_noteVisit.php?id_visit=" . $ovisiteur->Id . "&id_med=" . $omedicament->Id . "" ?>" target="_blank">
                                    <h4 id="note">Note Perso</h4>
                                </a></small>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "Aucun médicament à présenter pour ce mois-ci.";
        }
        ?>
    </div>

</div>