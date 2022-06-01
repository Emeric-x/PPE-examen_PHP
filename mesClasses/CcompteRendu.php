<?php

require_once './fpdf183/fpdf.php';

class CcompteRendu
{
    public $id;
    public $id_visit;
    public $lienFichier;
    public $sanneeMois;
    public $libelle;

    function __construct($sid, $sid_visit, $slienFichier, $sanneeMois, $slibelle)
    {
        $this->id = $sid;
        $this->id_visit = $sid_visit;
        $this->lienFichier = $slienFichier;
        $this->anneeMois = $sanneeMois;
        $this->libelle = $slibelle;
    }
}

class CcompteRendus
{
    public $ocollCompteRendus;
    private static $Instance = null;

    private function __construct()
    {
        try {
            $this->ocollCompteRendus = json_decode(file_get_contents("http://localhost:59906/api/CompteRendu/GetAllCompteRendu"));
        } catch (PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }

    public static function GetInstance()
    {
        if (self::$Instance == null) {
            self::$Instance = new CcompteRendus();
            return self::$Instance;
        }

        return self::$Instance;
    }

    function generatePDF($sresumeCR, $sLibelleCR)
    {
        $oCurrentVisiteur = unserialize($_SESSION['visitauth']);
        $AnneeMois = getAnneeMois();

        //creation pdf
        ob_get_clean();
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // parametre police
        $pdf->SetFont("Arial", "", 12);
        $pdf->SetTextColor(0, 0, 0);

        //header
        $pdf->Cell(0, 10, "Compte-rendu de " . $oCurrentVisiteur->Nom . " " . $oCurrentVisiteur->Prenom, 1, 1, "C");

        // saut de ligne 20mm
        $pdf->Ln(20);

        //body
        $date = date('Y-m-d');
        setlocale(LC_TIME, "fr_FR");
        $pdf->Text(8, 38, 'Date : ' . strftime("%A %d %B %G", strtotime($date)));
        $pdf->Text(8, 43, utf8_decode('Libellé : ' . $sLibelleCR));
        $pdf->Text(8, 48, utf8_decode('Résumé de la journée : ' . $sresumeCR)); //utf8_decode pour afficher les caractères accents etc

        //$pdfGenere = $pdf->Output("", utf8_decode("S"));
        $cpt = count($this->ocollCompteRendus) + 1;
        $lienPdf = 'pdfs/' . $oCurrentVisiteur->Nom . $oCurrentVisiteur->Prenom . '-CompteRendu-' . $AnneeMois . '-' . $cpt . '.pdf';
        $pdf->Output('F', $lienPdf);

        $this->insertPdf($oCurrentVisiteur->Id, $lienPdf, $sLibelleCR);
    }

    function insertPdf($sIdVisiteur, $sLienPdf, $sLibelleCR)
    {
        $AnneeMois = getAnneeMois();

        $postdata = json_encode(array(
            'id' => 0,
            'id_visit' => $sIdVisiteur,
            'lienFichier' => $sLienPdf,
            'anneeMois' => $AnneeMois,
            'libelle' => $sLibelleCR
        ));

        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        $context = stream_context_create($opts);

        $this->ocollCompteRendus = json_decode(file_get_contents("http://localhost:59906/api/CompteRendu/InsertCompteRendu", false, $context));
    }

    public function GetCRByIdVisitAndAnneeMois($sIdVisit, $sAnneeMois)
    {
        $ocollCompteRenduRetour = [];
        foreach($this->ocollCompteRendus as $unCompteRendu)
        {
            if($unCompteRendu->Id_visit == $sIdVisit && $unCompteRendu->AnneeMois == $sAnneeMois){
                $ocollCompteRenduRetour[] = $unCompteRendu;
            }
        }

        return $ocollCompteRenduRetour;
    }
}
