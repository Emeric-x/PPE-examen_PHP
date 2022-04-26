<?php 

require_once 'mesClasses/Ctri.php';
require_once 'includes/functions.php';

class Cmedicament
{
    public $id;
    public $nom;
    public $photo;
    public $description;
    public $categorie;

    function __construct($sid, $snom, $sphoto, $sdescription, $scategorie)
    {
        $this->id = $sid;
        $this->nom = $snom;
        $this->photo = $sphoto;
        $this->description = $sdescription;
        $this->categorie = $scategorie;
    }
}

class Cmedicaments
{
    public $ocollMedicaments;
    private static $Instance = null;

    private function __construct()
    {
        try
        {
            $this->ocollMedicaments = json_decode(file_get_contents("http://localhost:59906/api/Medicament/GetAllMedicaments"));
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
            self::$Instance = new Cmedicaments;
            return self::$Instance;
        }

        return self::$Instance;
    }

    function GetMedicamentById($sId)
    {
        foreach($this->ocollMedicaments as $oUnMedicament)
        {
            if($oUnMedicament->Id == $sId)
            {
                return $oUnMedicament;
            }
        }

        return null;
    }

    /*function getMedicamentsTrie($attribut)
    {
        $otrie = new Ctri();
        $ocollMedicamentsTrie = $otrie->TriTableau($this->ocollMedicaments, $attribut);
        return $ocollMedicamentsTrie;
    }*/

    function getTabMedicamentsParNomEtCategorie($sdebutFin,$spartieNom,$scategorie)
    {
        $tabMedicamentsByCategorieNom = null ;
        
        foreach ($this->ocollMedicaments as $omedicament) {
            
            if((strtolower($omedicament->categorie) == strtolower($scategorie)) || $scategorie == 'toutes')
            {
                if($spartieNom != '*')
                {
                    if($sdebutFin == "debut")
                    {
                        $nomExtrait = substr($omedicament->nom,0,strlen($spartieNom));

                        if(strtolower($nomExtrait) == strtolower($spartieNom))
                        {
                            $tabMedicamentsByCategorieNom[] = $omedicament;
                        }                                      
                    }
                    if($sdebutFin == "fin")
                    {

                        $nomExtrait = substr($omedicament->nom,-strlen($spartieNom),strlen($spartieNom));

                       if(strtolower($nomExtrait) == strtolower($spartieNom))
                        {
                            $tabMedicamentsByCategorieNom[] = $omedicament;
                        }

                    } 

                    if($sdebutFin == "nimporte")
                    {
                        $i = 0;
                        $tab = str_split($omedicament->nom);
                        foreach ($tab as $caract) 
                        {
                            $nomExtrait = substr($omedicament->nom,$i,strlen($spartieNom));

                            if(strtolower($nomExtrait) == strtolower($spartieNom))
                            {
                                $tabMedicamentsByCategorieNom[] = $omedicament;
                                break;
                            } 

                            $i++;
                        }


                    }
                }else{$tabMedicamentsByCategorieNom[] = $omedicament;}
                
            }
            
        }
        
       
        
        return $tabMedicamentsByCategorieNom;
    }

    function getAttributMedicaments($sattribut)
    {
        $ocollAttribut = getObjetTrie($sattribut, $this->ocollMedicaments);
        $tabAttribut = array();
        foreach($ocollAttribut as $omedicament){
            $tabAttribut[] = $omedicament->$sattribut;
        }
        
        $ocollAttribut = array_unique($tabAttribut, SORT_REGULAR);

        return $ocollAttribut;
    }
}

?>