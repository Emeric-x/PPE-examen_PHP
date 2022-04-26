<?php

$errorMsg = null;
$successMsg = null;

if(isset($_POST['btnFF'])){
    if(isset($_POST["forfaitEtape"]) && isset($_POST["fraisKilometrique"]) && isset($_POST["nuiteeHotel"]) && isset($_POST["repasRestaurant"])){
        $oLigneFFs = new CligneFFs;
        try{
            $oLigneFFs->insertFF($_POST['forfaitEtape'], $_POST['fraisKilometrique'], $_POST['nuiteeHotel'], $_POST['repasRestaurant']);
            echo 'Insertion réussie !';
        } catch (Exception $ex) {
            $errorMsg = "Erreur lors de l'insertion dans la base.".$ex->getMessage()." Prévenir l'administrateur.";
        }
    }
}

?>

<div class="container">
    <h3><p class="text-primary page-header">Saisie des frais forfaitaires <span class="text-primary glyphicon glyphicon-pencil"></span></p></h3>
    <br>
    <form id="formFF" class="form-horizontal" role="form" method="POST" action="<?=$formAction?>">
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
        </div>
    </form>
</div>

