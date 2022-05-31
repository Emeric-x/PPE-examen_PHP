<?php

require_once './fpdf183/fpdf.php';

class CcompteRendu
{
    public $id;
    public $id_visit;
    public $lienFichier;
    public $sanneeMois;

    function __construct($sid, $sid_visit, $slienFichier, $sanneeMois)
    {
        $this->id = $sid;
        $this->id_visit = $sid_visit;
        $this->lienFichier = $slienFichier;
        $this->anneeMois = $sanneeMois;
    }

}

class CcompteRendus
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
            self::$Instance = new CcompteRendus();
            return self::$Instance;
        }

        return self::$Instance;
    }

    function generatePDF($sresumeCR)
    {
        $oCurrentVisiteur = unserialize($_SESSION['visitauth']);
        $AnneeMois = getAnneeMois();

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

        //$pdfGenere = $pdf->Output("", utf8_decode("S"));

        $lienPdf = 'pdfs/'.$oCurrentVisiteur->Nom.$oCurrentVisiteur->Prenom.'-CompteRendu-'.$AnneeMois.'.pdf';
        $pdf->Output('F',$lienPdf);

        $this->insertPdf($oCurrentVisiteur->Id, $lienPdf);
    }
    
    function insertPdf($sIdVisiteur, $sLienPdf)
    {
        $AnneeMois = getAnneeMois();

        $postdata = json_encode(array(
            'id' => 0,
            'id_visit' => $sIdVisiteur,
            'lienFichier' => $sLienPdf,
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
