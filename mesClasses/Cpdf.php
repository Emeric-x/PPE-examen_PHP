<?php

require_once './fpdf183/fpdf.php';

class Cpdf
{
    public $id;
    public $id_visiteur;
    public $fichier;
    public $date;
    public $sanneeMois;

    function __construct($sid, $sid_visiteur, $sfichier, $sdate, $sanneeMois)
    {
        $this->id = $sid;
        $this->id_visiteur = $sid_visiteur;
        $this->fichier = $sfichier;
        $this->date = $sdate;
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

    // peut-etre faire une classe outil pour cette fonction
    function generatePDF($sauteurCR, $sresumeCR)
    {
        ob_get_clean();
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();

        $pdf->SetFont("Arial", "", 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10, "Compte-rendu de ".$sauteurCR, 1,1,"C");
        $pdf->Ln(20); // saut de ligne 20mm
        $date = date('Y-m-d'); // Date du jour
        setlocale(LC_TIME, "fr_FR");
        //echo strftime("%A %d %B %G", strtotime($date));  Mercredi 26 octobre 2016
        $pdf->Text(28,38,'Date : '.strftime("%A %d %B %G", strtotime($date))); // afficher la date ici
        $pdf->Text(8,43, utf8_decode('Résumé de la journée : '.$sresumeCR)); //utf8_decode pour afficher les caractères accents etc

        $pdfGenere = $pdf->Output("", utf8_decode("S"));

        $a = new Cpdfs();
        $a->insertPdf($sauteurCR, $pdfGenere);
    }
    
    function insertPdf($ssauteurCR, $spdfGenere)
    {
        $odaoAdd = new Cdao();
        $queryAdd = "INSERT INTO `pdf_visiteur` (`auteur`, `fichier`) VALUES ('".$ssauteurCR."', '".$spdfGenere."');";
        $odaoAdd->insert($queryAdd);
    }

    function affiche_Allpdf()
    {
        $odaoAffiche = new Cdao();
        $queryAffiche = "SELECT * FROM pdf_visiteur ORDER BY date desc";

        return $odaoAffiche->gettabDataFromSql($queryAffiche);
    }

    function affiche_pdfPerso($snomvisiteur)
    {
        $odaoAffiche = new Cdao();
        $queryAffiche = "SELECT * FROM pdf_visiteur WHERE auteur LIKE '%".$snomvisiteur."%' ORDER BY date desc";

        return $odaoAffiche->gettabDataFromSql($queryAffiche);
    }
}

?>
