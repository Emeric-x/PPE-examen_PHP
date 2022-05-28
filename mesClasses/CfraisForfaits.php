<?php

class CfraisForfait
{
    public $id;
    public $libelle;
    public $montant;

    function __construct($sid, $slibelle, $smontant)
    {
        $this->id = $sid;
        $this->libelle = $slibelle;
        $this->montant = $smontant;
    }
} 

class CfraisForfaits
{
    public $ocollFraisForfait;
    private static $Instance = null;

    private function __construct()
    {
        try 
        {
            $this->ocollFraisForfait = json_decode(file_get_contents("http://localhost:59906/api/FicheFrais/GetAllFraisForfaits"));
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
            self::$Instance = new CfraisForfaits;
            return self::$Instance;
        }

        return self::$Instance;
    }
}

?>