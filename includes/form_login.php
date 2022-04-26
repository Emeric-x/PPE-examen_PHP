<?php
require_once './mesClasses/Cvisiteurs.php';
require_once './mesClasses/Cdao.php';
require_once 'includes/functions.php';

// connexion via form
if (isset($_POST['username']) && isset($_POST['pwd'])) {
    $lesVisiteurs = Cvisiteurs::GetInstance();
    $ovisiteur = $lesVisiteurs->verifierInfosConnexion($_POST['username'], $_POST['pwd']);

    if ($ovisiteur) {
        $_SESSION['visitauth'] = serialize($ovisiteur);
        header('Location: liste_visiteur.php');
    } else {
        $errorMsg = "Login/Mot de passe incorrect";
    }
}

// connexion via ppe angular
if(isset($_GET['sLogin']) && isset($_GET['sMdp'])){
    $lesVisiteurs = Cvisiteurs::GetInstance();
    $ovisiteur = $lesVisiteurs->verifierInfosConnexion($_GET['sLogin'], $_GET['sMdp']);

    if ($ovisiteur) {
        $_SESSION['visitauth'] = serialize($ovisiteur);
        header('Location: medicaments_mois.php');
    } else {
        $errorMsg = "Login/Mot de passe incorrect";
    }
}

?>
<div class="bg-img">
    <h2 title="cnx">Connexion lab GSB</h2>

    <div class="containerForm">
        <form action="" method="post">
            <div class="<?= !empty($errorMsg) ? 'has-error form-group' : 'form-group' ?>">
                <label class="control-label" for="username"><b>Login</b></label>
                <input type="text" class="form-control" id="username" placeholder="Entrez un login" name="username" required="">
            </div>
            <br>
            <div class="<?= !empty($errorMsg) ? 'has-error form-group' : 'form-group' ?>">
                <label class="control-label" for="pwd"><b>Password</b></label>
                <input type="password" class="form-control" id="pwd" placeholder="Entrez un mot de passe" name="pwd" required=""><br>
            </div>
            <button type="submit" class="btn">Envoyer</button>
        </form>
    </div>

</div>
<p title="copyright">Copyright © GSB</p>