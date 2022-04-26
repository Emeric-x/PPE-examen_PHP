<?php

require_once 'mesClasses/Ctri.php';

class Cemploye
{
    public $id;
    public $login;
    public $nom;
    public $prenom;
    public $mdp;
    public $mdp_hash;
    public $ville;
    public $adresse;
    public $cp;
    public $dateEmbauche;

    function __construct($sid, $slogin, $snom, $sprenom, $smdp, $smdp_hash, $sville, $sadresse, $scp, $sdateEmbauche) //s pour send param envoyé
    {

        $this->id = $sid;
        $this->login = $slogin;
        $this->nom = $snom;
        $this->prenom = $sprenom;
        $this->mdp = $smdp;
        $this->mdp_hash = $smdp_hash;
        $this->ville = $sville;
        $this->adresse = $sadresse;
        $this->cp = $scp;
        $this->dateEmbauche = $sdateEmbauche;
    }
}

class Cvisiteur extends Cemploye
{
    function __construct($sid, $slogin, $snom, $sprenom, $mdp, $smdp_hash, $sville, $sadresse, $scp, $sdateEmbauche)
    {
        parent::__construct($sid, $slogin, $snom, $sprenom, $mdp, $smdp_hash, $sville, $sadresse, $scp, $sdateEmbauche);
    }
}


class Cvisiteurs
{
    public $ocollVisiteur;
    private static $Instance = null;

    private function __construct()
    {

        try 
        {
            $this->ocollVisiteur = json_decode(file_get_contents("http://localhost:59906/api/Employe/GetAllVisiteurs"));
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
            self::$Instance = new Cvisiteurs;
            return self::$Instance;
        }

        return self::$Instance;
    }

    function verifierInfosConnexion($susername, $spwd)
    {
        foreach ($this->ocollVisiteur as $ovisiteur) {
            if ($ovisiteur->Login == $susername && $ovisiteur->Mdp_hash == hash('sha512', $spwd)) {
                return $ovisiteur;
            }
        }
        return null;
    }

    /*function getVisiteursTrie($attribut)
    {
        $otrie = new Ctri();
        $ocollVisiteursTrie = $otrie->TriTableau($this->ocollVisiteur, $attribut);
        return $ocollVisiteursTrie;
       //return $this->ocollVisiteur;
     
    }*/

    function getTabVisiteursParNomEtVille($sdebutFin, $spartieNom, $sville)
    {
        $tabVisiteursByVilleNom = null;

        foreach ($this->ocollVisiteur as $ovisiteur) {

            if ((strtolower($ovisiteur->Ville) == strtolower($sville)) || $sville == 'toutes') {
                if ($spartieNom != '*') {
                    if ($sdebutFin == "debut") {
                        $nomExtrait = substr($ovisiteur->Nom, 0, strlen($spartieNom));

                        if (strtolower($nomExtrait) == strtolower($spartieNom)) {
                            $tabVisiteursByVilleNom[] = $ovisiteur;
                        }
                    }
                    if ($sdebutFin == "fin") {

                        $nomExtrait = substr($ovisiteur->Nom, -strlen($spartieNom), strlen($spartieNom));

                        if (strtolower($nomExtrait) == strtolower($spartieNom)) {
                            $tabVisiteursByVilleNom[] = $ovisiteur;
                        }
                    }

                    if ($sdebutFin == "nimporte") {
                        $i = 0;
                        $tab = str_split($ovisiteur->Nom);
                        foreach ($tab as $caract) {
                            $nomExtrait = substr($ovisiteur->Nom, $i, strlen($spartieNom));

                            if (strtolower($nomExtrait) == strtolower($spartieNom)) {
                                $tabVisiteursByVilleNom[] = $ovisiteur;
                                break;
                            }

                            $i++;
                        }
                    }
                } else {
                    $tabVisiteursByVilleNom[] = $ovisiteur;
                }
            }
        }



        return $tabVisiteursByVilleNom;
    }
}
