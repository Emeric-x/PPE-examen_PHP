<?php

class CligneFHF
{
    public $id;
    public $idVisiteur;
    public $mois;
    public $libelle;
    public $date;
    public $montant;
    
    /*function __construct($sid, $sidVisiteur, $smois, $slibelle, $sdate, $smontant) 
    {
        $this->id = $sid;
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->libelle = $slibelle;
        $this->date = $sdate;
        $this->montant = $smontant;
    }*/
}

class CligneFHFs
{
    public $ocollLFHF;
    
    public function __construct()
    {
        try
        {
            //$query = "SELECT * FROM lignefraishorsforfait";
            
            /* je remplace la requete ci-dessus par l'appel de la procédure stockée qui fait la requete */
            $query = 'call SELECTLFHF()';
            $odao = new Cdao();
            $tabLFHF = $odao->gettabDataFromSql($query);
            $this->ocollLFHF = array();
            
            foreach ($tabLFHF as $oLFHF){
                $this->ocollLFHF[] = $oLFHF;
            }
            
            unset($odao);
            
        } catch (Exception $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }
    
    public function insertFHF($slibelle, $smontant){
        $libelle = prepareChaineHtml($slibelle);
        $montant = prepareChaineHtml($smontant);
        $ovisiteur = unserialize($_SESSION['visitauth']);
        $idVisiteur = $ovisiteur->id;
        $dateSaisie = ('Y-m-d');
        $mois = getAnneeMois();
        
        /*$query = "INSERT INTO lignefraishorsforfait(libelle, montant) VALUES ('".$slibelle."', '".$smontant."');";*/
        
        $query = "call INSERTLFHF('".$idVisiteur."','".$mois."','".$libelle."','".$dateSaisie."','".$montant."')";
        $odao = new Cdao();
        $odao->insert($query);
        unset($odao);
    }
    
    public function deleteFHF($sidLigne){
        $query = "DELETE FROM `lignefraishorsforfait` WHERE `id` = ".$sidLigne.";";
        $odao = new Cdao();
        $odao->delete($query);
        unset($odao);
    }
    
    public function getFHFByIdVisiteurMois($sidVisiteur, $smois){
        $query = "SELECT * FROM lignefraishorsforfait WHERE idVisiteur='".$sidVisiteur."' AND mois='".$smois."' ;";
        $odao = new Cdao();
        $visiteurs = $odao->getTabObjetFromSql($query, 'CligneFHF');
        
        return $visiteurs;
    }
    
    public function getNbreLFHF($sidVisiteur){
        $mois = getAnneeMois();
        $odao = new Cdao();
        $squery = "call NBRELFHFBYVISITEURMOIS ('".$sidVisiteur."','".$mois."', @nbre)";
        $res = $odao->getParamOutPS($squery);
        
        return $res;
    }
}

