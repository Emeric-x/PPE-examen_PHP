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
    public $ocollLigneFF;
    private static $Instance = null;

    private function __construct()
    {
        try 
        {
            $this->ocollLigneFF = json_decode(file_get_contents("http://localhost:59906/api/FicheFrais/GetAllLigneFF"));
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
            self::$Instance = new CligneFFs;
            return self::$Instance;
        }

        return self::$Instance;
    }
    
}