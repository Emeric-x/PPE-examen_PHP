<?php

class CligneFF
{
    public $idVisiteur;
    public $mois;
    public $idFraisForfait;
    public $quantite;
    
    function __construct($sidVisiteur, $smois, $sidFraisForfait, $squantite) 
    {
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->idFraisForfait = $sidFraisForfait;
        $this->quantite = $squantite;
    }
}

class CligneFFs
{
    public $ocollLFF;
    
    public function __construct()
    {
        try
        {
            $query = "SELECT * FROM lignefraisforfait";
            $odao = new Cdao();
            $tabLFF = $odao->gettabDataFromSql($query);
            $this->ocollLFF = array();
            
            foreach ($tabLFF as $oLFF){
                $this->ocollLFF[] = $oLFF;
            }
            
            unset($odao);
            
        } catch (Exception $ex) {
            $msg = 'ERREUR PDO dans ' . $ex->getFile() . ' L.' . $ex->getLine() . ' : ' . $ex->getMessage();
            die($msg);
        }
    }
    
    public function insertFF($sforfaitEtape, $sfraisKilometrique, $snuiteeHotel, $srepasRestaurant){
        $ovisiteur = unserialize($_SESSION['visitauth']);
        $idVisiteur = $ovisiteur->id;
        $mois = getAnneeMois();
        
        
        $tabIdFraisForfait = array();
        $tabIdFraisForfait = ["REP", "NUI", "KM", "ETP"];
        $tabFraisForfait = array();
        $tabFraisForfait = [$sforfaitEtape, $sfraisKilometrique, $snuiteeHotel, $srepasRestaurant];
        $i=0;
        foreach ($tabFraisForfait as $unFraisForfait){
            $odao = new Cdao();
            $query = "call INSERTLFF ('".$idVisiteur."','".$mois."','".$tabIdFraisForfait[$i]."','".$unFraisForfait."')";
            $odao->insert($query);
            
            $i++;
        }
        $i=0;
        
    }
    
}