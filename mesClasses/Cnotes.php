<?php

class Cnote
{
    public $id_note;
    public $texte;
    
    function __construct($sid_note, $stexte)
    {
        $this->id_note = $sid_note;
        $this->texte = $stexte;
    }
}


class Cnotes
{
    public $ocollNotes;
    private static $Instance = null;

    public function __construct() // constructeur en public pour pouvoir récupérer les notes mises à jour une fois modifiées
    {
        $this->ocollNotes = json_decode(file_get_contents("http://localhost:59906/api/Medicament/GetAllNotes"));
    }

    public static function GetInstance()
    {
        if(self::$Instance == null)
        {
            self::$Instance = new Cnotes();
            return self::$Instance;
        }

        return self::$Instance;
    }

    public function GetNoteByIdMed($sid_visit, $sid_med)
    {
        foreach($this->ocollNotes as $oUneNote)
        {
            if($oUneNote->Id_med == $sid_med && $oUneNote->Id_visit == $sid_visit)
            {
                return $oUneNote;
            }
        }
        return null;
    }


    public function UpdateNoteVisiteur($sInsertOrUpdate, $sText, $sId_visit, $sId_med)
    {
        /*
        * création d'un tableau associatif (clé = champ de la table note) représentant la note
        * puis passage des données au format json en POST
        * de sorte à pouvoir passer un text comprenant des espaces 
        * (car dans l'url impossible)
        */
        $postdata = json_encode(array(
            'id' => $sInsertOrUpdate, // obligé de spécifier un id pour que la désérialisation en objet note fonctionne (je crois que on peut mettre 0 comme valeur pour id sans avoir d'impact apres)
            'id_visit' => $sId_visit,
            'id_med' => $sId_med,
            'note' => $sText
        ));

        $opts = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ));

        $context = stream_context_create($opts);

        file_get_contents("http://localhost:59906/api/Medicament/UpdateNote", false, $context);
    }
}
