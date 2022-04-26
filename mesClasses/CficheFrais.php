<?php

require_once 'Cdao.php';
require_once 'Cvisiteurs.php';

class CficheFrais
{
    public $idVisiteur;
    public $mois;
    public $nbJustificatifs;
    public $montantValide;
    public $dateModif;
    public $idEtat;
    
    // avec la méthode getTabObjetFromSql => plus besoin de constructeur ici
    
    /*function __construct($sidVisiteur, $smois, $snbJustificatifs, $smontantValide, $sdateModif, $sidEtat)
    {
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->nbJustificatifs = $snbJustificatifs;
        $this->montantValide = $smontantValide;
        $this->dateModif = $sdateModif;
        $this->idEtat = $sidEtat;
    }*/
}

class CficheFraiss
{
    public $ocollFicheFrais;
    
    public function __construct() 
    {
        $odao = new Cdao();
        $query = "SELECT * FROM fichefrais";
        $tabObjetFF = $odao->getTabObjetFromSql($query, 'CficheFrais');
        $this->ocollFicheFrais = array();
        
        //$visiteur = new Cvisiteurs();
        
        foreach($tabObjetFF as $oficheFrais){
            //$oficheFrais = new CficheFrais($uneficheFrais['idVisiteur'],$uneficheFrais['mois'],$uneficheFrais['nbJustificatifs'],$uneficheFrais['montantValide'],$uneficheFrais['dateModif'],$uneficheFrais['idEtat']);
            $this->ocollFicheFrais[] = $oficheFrais;
            
            /*$idVisiteur = $oficheFrais->idVisiteur; // récupération de l'id visiteur
            $ovisiteur = $visiteur->getVisiteurById($idVisiteur); // objet de type Cvisiteurs correspondant à l'idVisiteur
            $oficheFrais->idVisiteur = $ovisiteur; // ref dans l'objet fiche de frais */
        }
        unset($odao);
        
        
    }
    
    public function verifFicheFrais($sidVisiteur)
    {
        $oFicheFraisByIdVisiteur = null;
        
        foreach($this->ocollFicheFrais as $oficheFrais){
            if($oficheFrais->idVisiteur == $sidVisiteur && $oficheFrais->mois == getAnneeMois()){
                $oFicheFraisByIdVisiteur = $oficheFrais;
            }
        }
        if($oFicheFraisByIdVisiteur == null){
            $this->insertFicheFrais($sidVisiteur);
        }
    }
    
    public function insertFicheFrais($sidVisiteur){
        $odao = new Cdao();
        $mois = getAnneeMois();
        $query = "INSERT INTO fichefrais(idVisiteur, mois, idEtat) VALUES ('".$sidVisiteur."', '".$mois."', 'CR')";
        
        $odao->insert($query);
        unset($odao);
    }
}
