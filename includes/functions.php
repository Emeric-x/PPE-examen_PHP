<?php

require_once 'mesClasses/Cdao.php';
require_once 'mesClasses/Ctri.php';

function getDb()
{
    return new PDO(
        "mysql:host=localhost;dbname=gsb_frais;charset=utf8",
        "root",
        "",
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
}

function getAnneeMois()
{
    return date("Ym");
}

function prepareChaineHtml($schaine)
{
    //return trim(htmlspecialchars($schaine));
    //$text = htmlentities($chaine, ENT_NOQUOTES, "UTF-8");
    //$text = htmlspecialchars_decode($text, ENT_NOQUOTES, "UTF-8");
    $text = utf8_decode($schaine); //$schaine est en utf8 et va etre mis en iso
    return $text;
}

function moisEnFrancais($schaine)
{
    $lesMois = array(

        'January'   => 'Janvier',
        'February'  => 'Février',
        'March'     => 'Mars',
        'April'     => 'Avril',
        'May'       => 'Mai',
        'June'      => 'Juin',
        'July'      => 'Juillet',
        'August'    => 'Août',
        'September' => 'Septembre',
        'October'   => 'Octobre',
        'November'  => 'Novembre',
        'December'  => 'Décembre',
    );

    return $lesMois[$schaine];
}

/*
 function filtre_int_get($item)
 {
     return $reponse = filter_var($item, FILTER_VALIDATE_INT); // retourne soit false ou la valeur entière
         
 }*/

function wrap($stexte)
{
    $texte = wordwrap($stexte, 100, "<br>", false);
    // wordwrap = Retourne la chaîne fournie coupée à la longueur spécifiée.
    // false = un mot qui commence en dessous de 100 et continue après 100 alors il ne sera pas coupé (à l'inverse de true)
    return $texte;
}

function texte_explode($sauteur)
{
    // explode : Scinde une chaîne de caractères en segments (scinde selon le caractère spécifié, ici caractère vide)
    $words = explode(" ", $sauteur);
    $acronym = "";

    foreach ($words as $w) {
        $acronym .= $w[0];
    }

    return $acronym;
}

function getObjetTrie($sattribut, $socoll)
{
    $otrie = new Ctri();
    $ocollTrie = $otrie->TriTableau($socoll, $sattribut);

    return $ocollTrie;
}

// hash les mdp
/*foreach ($tabVisiteurs as $ovisiteur){
    $mdp_hash = hash('sha512', $ovisiteur->mdp).'<br>';
    
    $query = "UPDATE visiteur v SET v.mdp_hash = '".$mdp_hash."' WHERE v.login = '".$ovisiteur->login."'";
    $odao->update($query);
}*/
