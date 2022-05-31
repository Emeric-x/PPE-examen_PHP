<?php

require_once './fpdf183/fpdf.php';

class Cpdf
{
    public $id;
    public $id_visit;
    public $fichier;
    public $sanneeMois;

    function __construct($sid, $sid_visit, $sfichier, $sanneeMois)
    {
        $this->id = $sid;
        $this->id_visit = $sid_visit;
        $this->fichier = $sfichier;
        $this->anneeMois = $sanneeMois;
    }

}

class Cpdfs
{
    public $ocollPdfs;
    private static $Instance = null;

    private function __construct()
    {
        try 
        {
            $this->ocollPdfs = json_decode(file_get_contents("http://localhost:59906/api/CompteRendu/GetAllCompteRendu"));
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
            self::$Instance = new Cpdfs;
            return self::$Instance;
        }

        return self::$Instance;
    }

    function generatePDF($sresumeCR)
    {
        $oCurrentVisiteur = unserialize($_SESSION['visitauth']);

        ob_get_clean();
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();

        $pdf->SetFont("Arial", "", 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10, "Compte-rendu de ".$oCurrentVisiteur->Nom." ".$oCurrentVisiteur->Prenom, 1,1,"C");
        $pdf->Ln(20); // saut de ligne 20mm
        $date = date('Y-m-d'); // Date du jour
        setlocale(LC_TIME, "fr_FR");
        //echo strftime("%A %d %B %G", strtotime($date));  Mercredi 26 octobre 2016
        $pdf->Text(28,38,'Date : '.strftime("%A %d %B %G", strtotime($date))); // afficher la date ici
        $pdf->Text(8,43, utf8_decode('Résumé de la journée : '.$sresumeCR)); //utf8_decode pour afficher les caractères accents etc

        $pdfGenere = $pdf->Output("", utf8_decode("S"));

        $a = new Cpdfs();
        $a->insertPdf($oCurrentVisiteur->Id, $pdfGenere);
    }
    
    function insertPdf($sIdVisiteur, $spdfGenere)
    {
        $AnneeMois = getAnneeMois();

        $postdata = json_encode(array(
            'id' => count($this->ocollPdfs)+1,
            'id_visit' => $sIdVisiteur,
            'fichier' => $spdfGenere,
            'anneeMois' => $AnneeMois
        ));

        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        $context = stream_context_create($opts);

        file_get_contents("http://localhost:59906/api/CompteRendu/InsertCompteRendu", false, $context);
    }
}

?>
