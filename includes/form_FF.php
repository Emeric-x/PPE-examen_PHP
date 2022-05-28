<?php

$errorMsg = null;
$successMsg = null;

$oFraisForfaits = CfraisForfaits::GetInstance();

if (isset($_POST['btnFF'])) {
    if (isset($_POST["ETPQte"]) && isset($_POST["KMQte"]) && isset($_POST["NUIQte"]) && isset($_POST["REPQte"])) {
        $oLigneFFs = CligneFFs::GetInstance();
        try {
            foreach($oFraisForfaits->ocollFraisForfait as $unFraisForfait){
                $oLigneFFs->insertLigneFF($unFraisForfait->IdFraisForfait, $_POST[$unFraisForfait->IdFraisForfait."Qte"]);
            }
            echo 'Insertion réussie !';
        } catch (Exception $ex) {
            $errorMsg = "Erreur lors de l'insertion dans la base." . $ex->getMessage() . " Prévenir l'administrateur.";
        }
    }
}

?>

<div class="container">
    <h3>
        <p class="text-primary page-header">Saisie des frais forfaitaires <span class="text-primary glyphicon glyphicon-pencil"></span></p>
    </h3>
    <br>
    <form id="formFF" class="form-horizontal" role="form" method="POST" action="<?= $formAction ?>">
        <?php
        foreach ($oFraisForfaits->ocollFraisForfait as $unFraisForfait) {
        ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="forfaitEtape"><?php echo $unFraisForfait->Libelle ?> :</label>
                <div class="col-sm-10">
                    <input class="form-control" <?php echo "name='" . $unFraisForfait->Id . "Qte'" ?> value="0" required="required" type="number" min="0" step="1" style="width: 49%; float: left; margin-right: 15px">
                    <input class="form-control" <?php echo "name='" . $unFraisForfait->Id . "Mt'" ?> <?php echo "placeholder='" . $unFraisForfait->Montant . "'" ?> readonly style="width: 49%">
                </div>
            </div>
        <?php
        }
        ?>
        <!--
        <div class="form-group">
            <label class="control-label col-sm-2" for="forfaitEtape">Forfait étape :</label>
            <div class="col-sm-10">
                <input class="form-control" name="forfaitEtape" value="0" required="required" type="number" min="0" step="1" style="width: 49%; float: left; margin-right: 15px">
                <input class="form-control" name="forfaitEtapeQte" placeholder="110" readonly style="width: 49%">
            </div>
        </div>    
        <div class="form-group">
            <label class="control-label col-sm-2" for="fraisKilometrique">Frais kilométrique :</label>
            <div class="col-sm-10">
                <input class="form-control" name="fraisKilometrique" value="0" required="required" type="number" min="0" step="1" style="width: 49%; float: left; margin-right: 15px">
                <input class="form-control" name="fraisKilometriqueQte" placeholder="0.62" readonly style="width: 49%">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="nuiteeHotel">Nuitée hôtel :</label>
            <div class="col-sm-10">
                <input class="form-control" name="nuiteeHotel" value="0" required="required" type="number" min="0" step="1" style="width: 49%; float: left; margin-right: 15px">
                <input class="form-control" name="nuiteeHotelQte" placeholder="80" readonly style="width: 49%">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="repasRestaurant">Repas restaurant :</label>
            <div class="col-sm-10">
                <input class="form-control" name="repasRestaurant" value="0" required="required" type="number" min="0" step="1" style="width: 49%; float: left; margin-right: 15px">
                <input class="form-control" name="repasRestaurantQte" placeholder="25" readonly style="width: 49%">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="btnFF" class="btn btn-default">Enregistrer</button>
            </div>
        </div>-->
    </form>
</div>