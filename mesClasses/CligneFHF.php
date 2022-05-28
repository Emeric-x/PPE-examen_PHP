<?php

class CligneFHF
{
    public $id;
    public $idVisiteur;
    public $mois;
    public $libelle;
    public $montant;
    
    function __construct($sid, $sidVisiteur, $smois, $slibelle, $smontant) 
    {
        $this->id = $sid;
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->libelle = $slibelle;
        $this->montant = $smontant;
    }
}

class CligneFHFs
{
    public $ocollLigneFHF;
    private static $Instance = null;

    private function __construct()
    {
        try 
        {
            $this->ocollLigneFHF = json_decode(file_get_contents("http://localhost:59906/api/FicheFrais/GetAllLigneFHF"));
        } 
        catch (PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }

    public static function GetInstance()
    {
        if(self::$Instance == null)
        {
            self::$Instance = new CligneFHFs;
            return self::$Instance;
        }

        return self::$Instance;
    }

    public function insertLigneFHF($sLibelle, $sMontant)
    {
        $oCurrentVisiteur = unserialize($_SESSION['visitauth']);
        $AnneeMois = getAnneeMois();

        $postdata = json_encode(array(
            'id' => 0,
            'idVisiteur' => $oCurrentVisiteur->Id,
            'mois' => $AnneeMois,
            'libelle' => $sLibelle,
            'montant' => $sMontant
        ));

        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        $context = stream_context_create($opts);

        file_get_contents("http://localhost:59906/api/FicheFrais/InsertLigneFHF", false, $context);
    }

    public function GetLigneFHFByIdVisitMois($sidVisiteur, $sMois)
    {
        $ocollLigneFHFretour = [];
        
        foreach($this->ocollLigneFHF as $oLigneFHF){
            if($oLigneFHF->IdVisiteur == $sidVisiteur && $oLigneFHF->Mois == $sMois){
                $ocollLigneFHFretour[] = $oLigneFHF;
            }
        }

        return $ocollLigneFHFretour;
    }
}

