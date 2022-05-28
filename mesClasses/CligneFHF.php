<?php

class CligneFHF
{
    public $id;
    public $idVisiteur;
    public $mois;
    public $libelle;
    public $date;
    public $montant;
    
    function __construct($sid, $sidVisiteur, $smois, $slibelle, $sdate, $smontant) 
    {
        $this->id = $sid;
        $this->idVisiteur = $sidVisiteur;
        $this->mois = $smois;
        $this->libelle = $slibelle;
        $this->date = $sdate;
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
}

