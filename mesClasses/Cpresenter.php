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
    public $ocollPresenters;
    private static $Instance = null;

    public function __construct()
    {
        try {
            $this->ocollPresenters = json_decode(file_get_contents("http://localhost:59906/api/Medicament/GetAllPresenters"));
        } catch (PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }

    public static function GetInstance()
    {
        if (self::$Instance == null) {
            self::$Instance = new Cpresenters();
            return self::$Instance;
        }

        return self::$Instance;
    }

    function GetPresenterByAnneeMoisAndIdVisiteur($sIdVisiteur)
    {
        $ocollPresenter = [];
        $omedicaments = new Cmedicaments(); // nouvel objet pour async
        $alreadyAdded = false;

        foreach ($this->ocollPresenters as $oUnPresenter) {
            $alreadyAdded = false;
            if ($oUnPresenter->Id_visit == $sIdVisiteur && $oUnPresenter->AnneeMois == date('Ym')) {
                if (count($ocollPresenter) > 0) {
                    foreach($ocollPresenter as $oUnPresenterAdded){
                        if($oUnPresenterAdded->Id == $oUnPresenter->Id_med){
                            $alreadyAdded = true;
                        }
                    }
                    if($alreadyAdded == false){
                        $ocollPresenter[] = $omedicaments->GetMedicamentById($oUnPresenter->Id_med);
                    }
                }else{
                    $ocollPresenter[] = $omedicaments->GetMedicamentById($oUnPresenter->Id_med);
                }
            }
        }

        return $ocollPresenter;
    }
}
