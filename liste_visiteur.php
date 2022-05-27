<html>
<?php
require_once 'includes/head.php';
require_once './mesClasses/Cvisiteurs.php';
require_once 'includes/functions.php';

session_start();

$oemploye = unserialize($_SESSION['visitauth']);

?>

<body>
    <?php
    $ovisiteurs = Cvisiteurs::GetInstance();
    $ocollVisit = $ovisiteurs->ocollVisiteur;
    $ocollTrieByNom = getObjetTrie('Nom', $ocollVisit);

    $ocollTrieByVille = getObjetTrie('Ville', $ocollVisit);
    $tabVille = array();
    foreach ($ocollTrieByVille as $ovisiteur) {
        $tabVille[] = $ovisiteur->Ville;
    }

    $ocollVilles = array_unique($tabVille, SORT_REGULAR);
    ?>


    <div class="container">
        <?php
        if ($oCurrentVisiteur != null) {
        ?>
            <header title="listevisiteur"></header>

            <?php require_once 'includes/navBar.php' ?>

            <br>

            <p title="tabvisiteur">Trier les employés : </p>
            <div title="choix">
                <form id="formulaire" method="post">
                    <label for="listeChoixVille">Filtrer selon la ville : </label>
                    <select id="listeChoixVille" name="listeChoixVille">
                        <option selected value="toutes">Toutes</option>
                        <?php
                        foreach ($ocollVilles as $ville) { ?>
                            <option id="<?php $ville ?>"><?php echo $ville; ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <br>

                    <label for="partieNom">Fitrer selon le nom : </label>
                    <input type="text" name="partieNom">

                    <input type="radio" name="drone" value="debut">Début

                    <input type="radio" name="drone" value="fin">Fin

                    <input type="radio" name="drone" value="n'importe">Dans la chaîne

                    <br>

                    <input class="btn" type="submit" value="Filtrer">
                </form>
            </div>
            <?php
            /*$debutFin = "debut";
                $partieNom = "a";
                $ville = "toutes";
                if (isset($_GET['drone']) && isset($_GET['partieNom'])){
                    $debutFin = $_GET['drone'];
                    $partieNom = $_GET['partieNom'];
                    
                }*/
            if (isset($_POST['drone']) && isset($_POST['partieNom']) && isset($_POST['listeChoixVille'])) {
                $afficheVisiteur = $ovisiteurs->getTabVisiteursParNomEtVille($_POST['drone'], $_POST['partieNom'], $_POST['listeChoixVille']);
            ?>

                <br>
                <p title="tabvisiteur">Tableau des employés de GSB situés à <?php echo "<b style='border-bottom:2px solid black; width:50px'>" . $_POST['listeChoixVille'] . "</b>" ?> : ( <?php echo count($afficheVisiteur); ?> )</p>
                <table class="table table-condensed">
                    <thead title="entetetabvisiteur">
                        <tr>
                            <th>ID</th>
                            <th>LOGIN</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>VILLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($afficheVisiteur as $ovisiteur) {
                            $i++;
                            if ($i % 2 < 1) { ?>
                                <tr class="ligneTabVisitColor">
                                    <td><?php echo $ovisiteur->Id ?></td>
                                    <td><?php echo $ovisiteur->Login ?></td>
                                    <td><?php echo $ovisiteur->Nom ?></td>
                                    <td><?php echo $ovisiteur->Prenom ?></td>
                                    <td><?php echo $ovisiteur->Ville ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td><?php echo $ovisiteur->Id ?></td>
                                    <td><?php echo $ovisiteur->Login ?></td>
                                    <td><?php echo $ovisiteur->Nom ?></td>
                                    <td><?php echo $ovisiteur->Prenom ?></td>
                                    <td><?php echo $ovisiteur->Ville ?></td>
                                </tr>

                        <?php

                            }
                        }


                        ?>
                    </tbody>
                </table>


            <?php } else {
            ?>
                <p title="tabvisiteur">Tableau des employés de GSB : ( <?php echo count($ocollTrieByNom); ?> )</p>
                <table class="table table-condensed">
                    <thead title="entetetabvisiteur">
                        <tr>
                            <th>ID</th>
                            <th>LOGIN</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>VILLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($ocollTrieByNom as $ovisiteur) {
                            $i++;
                            if ($i % 2 < 1) { ?>
                                <tr class="ligneTabVisitColor">
                                    <td><?php echo $ovisiteur->Id ?></td>
                                    <td><?php echo $ovisiteur->Login ?></td>
                                    <td><?php echo $ovisiteur->Nom ?></td>
                                    <td><?php echo $ovisiteur->Prenom ?></td>
                                    <td><?php echo $ovisiteur->Ville ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td><?php echo $ovisiteur->Id ?></td>
                                    <td><?php echo $ovisiteur->Login ?></td>
                                    <td><?php echo $ovisiteur->Nom ?></td>
                                    <td><?php echo $ovisiteur->Prenom ?></td>
                                    <td><?php echo $ovisiteur->Ville ?></td>
                                </tr>

                        <?php

                            }
                        }


                        ?>
                    </tbody>
                </table>
        <?php }
        } else {
            header('Location: seConnecter.php?isAuth=false');
        } ?>
    </div>
</body>

</html>