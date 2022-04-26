<?php

require_once './mesClasses/Cmedicaments.php';
require_once 'includes/functions.php';

class Cpresenter

{
    public $id_med;
    public $id_visit;
    public $id_medecin;
    public $anneMois;

    function __construct($sid_med, $sid_visit, $sid_medecin, $sanneeMois)
    {
        $this->id_med = $sid_med;
        $this->id_visit = $sid_visit;
        $this->id_medecin = $sid_medecin;
        $this->anneeMois = $sanneeMois;
    }
}

class Cpresenters
{
    public $ocollPresenter;
    private static $Instance = null;

    private function __construct()
    {
        try
        {
            $this->ocollPresenter = json_decode(file_get_contents("http://localhost:59906/api/Medicament/GetAllPresenters"));
        }
        catch(PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }

    public static function GetInstance()
    {
        if(self::$Instance == null)
        {
            self::$Instance = new Cpresenters();
            return self::$Instance;
        }

        return self::$Instance;
    }

    function GetPresenterByAnneeMoisAndIdVisiteur($sIdVisiteur)
    {
        $ocollPresenter = null;
        $omedicaments = Cmedicaments::GetInstance();

        foreach($this->ocollPresenter as $oUnPresenter)
        {
            if($oUnPresenter->Id_visit == $sIdVisiteur && $oUnPresenter->AnneeMois == date('Ym'))
            {
                $ocollPresenter[] = $omedicaments->GetMedicamentById($oUnPresenter->Id_med);
            }
        }

        return $ocollPresenter;
    }
}
?>