<html>

<?php

require_once 'includes/head.php';
require_once './mesClasses/Cmedicaments.php';
require_once 'includes/functions.php';

session_start();

$oemploye = unserialize($_SESSION['visitauth']);

?>

<body>
    <?php

    $omedicaments = Cmedicaments::GetInstance();
    $ocollMed = $omedicaments->ocollMedicaments;
    $ocollTrie = getObjetTrie('Nom', $ocollMed);

    $ocollCategorie = $omedicaments->getAttributMedicaments('Categorie');

    ?>

    <div class="container">

        <header title="liste_medocs"></header>

        <?php require_once 'includes/navBar.php' ?>
        
        <br>

        <p title="tabvisiteur">Trier les médicaments : </p>
        <div title="choix">
            <form id="formulaire" method="post">
                <label for="listeChoixCategorie">Filtrer selon la catégorie : </label>
                <select id="listeChoixCategorie" name="listeChoixCategorie">
                    <option selected value="toutes">Toutes</option>
                    <?php
                    foreach ($ocollCategorie as $categorie) { ?>
                        <option id="<?php $categorie ?>"><?php echo $categorie; ?></option>
                    <?php } ?>
                </select>
                <br>
                <br>

                <label for="partieNom">Filtrer selon le nom : </label>
                <input type="text" name="partieNom">

                <input type="radio" name="drone" value="debut">Début

                <input type="radio" name="drone" value="fin">Fin

                <input type="radio" name="drone" value="n'importe">Dans la chaîne

                <br>

                <input class="btn" type="submit" value="Filtrer">
            </form>
        </div>

        <?php

        if (isset($_POST['drone']) && isset($_POST['partieNom']) && isset($_POST['listeChoixCategorie'])) {
            $afficheMedicaments = $omedicaments->getTabMedicamentsParNomEtCategorie($_POST['drone'], $_POST['partieNom'], $_POST['listeChoixCategorie']);
        ?>

            <!-- pas besoin de faire cette partie en async car lors du choix ya deja un refresh de la page -->
            <p title="tabvisiteur">Tableau des médicaments de type <?php echo "<b style='border-bottom:2px solid black; width:50px'>" . $_POST['listeChoixCategorie'] . "</b>" ?> disponibles : ( <?php echo count($afficheMedicaments); ?> )</p>
            <table class="table table-condensed">
                <thead title="entetetabvisiteur">
                    <tr>
                        <th>ID</th>
                        <th>NOM</th>
                        <th>IMAGE</th>
                        <th>DESCRIPTION</th>
                        <th>CATEGORIE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($afficheMedicaments as $omedicament) {
                        $i++;
                        if ($i % 2 < 1) { ?>
                            <tr class="ligneTabVisitColor">
                                <td><?php echo $omedicament->Id ?></td>
                                <td><?php echo $omedicament->Nom ?></td>
                                <td><?php echo "<img class='img_medoc' src='data:image/jpeg;base64," . $omedicament->Photo . "'>" ?></td>
                                <td><?php echo $omedicament->Description ?></td>
                                <td><?php echo $omedicament->Categorie ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo $omedicament->Id ?></td>
                                <td><?php echo $omedicament->Nom ?></td>
                                <td><?php echo "<img class='img_medoc' src='data:image/jpeg;base64," . $omedicament->Photo . "'>" ?></td>
                                <td><?php echo $omedicament->Description ?></td>
                                <td><?php echo $omedicament->Categorie ?></td>
                            </tr>
                    <?php
                        }
                    }

                    ?>
                </tbody>
            </table>

        <?php } else { ?>

            <p title="tabvisiteur">Tableau des médicaments disponibles : ( <?php echo count($ocollTrie); ?> )</p>
            <table class="table table-condensed">
                <thead title="entetetabvisiteur">
                    <tr>
                        <th>ID</th>
                        <th>NOM</th>
                        <th>PHOTO</th>
                        <th>DESCRIPTION</th>
                        <th>CATEGORIE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($ocollTrie as $omedicament) {
                        $i++;
                        if ($i % 2 < 1) { ?>
                            <tr class="ligneTabVisitColor">
                                <td><?php echo $omedicament->Id ?></td>
                                <td><?php echo $omedicament->Nom ?></td>
                                <td><?php echo "<img class='img_medoc' src='data:image/jpeg;base64," . $omedicament->Photo . "'>" ?></td>
                                <td><?php echo $omedicament->Description ?></td>
                                <td><?php echo $omedicament->Categorie ?></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo $omedicament->Id ?></td>
                                <td><?php echo $omedicament->Nom ?></td>
                                <td><?php echo "<img class='img_medoc' src='data:image/jpeg;base64," . $omedicament->Photo . "'>" ?></td>
                                <td><?php echo $omedicament->Description ?></td>
                                <td><?php echo $omedicament->Categorie ?></td>
                            </tr>
                    <?php
                        }
                    }

                    ?>
                </tbody>
            </table>

        <?php } ?>

    </div>


    <script src=includes/script.js></script>
    <script src="lib/jquery/jquery.min.js"></script>
</body>

</html>