<?php
require_once 'mesClasses/Cvisiteurs.php'; 

class Ctri {
    
  
    function TriTableau($stabAtrier,$sattribut)
    {
       // La fonction ord ne fonctionne qu'avec les code ASCII jusqu'à 127
       // Afin d'éviter des erreurs je prépare une collection type dico 
	   // avec les lettres accentuées en clef et la lettre minuscule correspondante en valeur
          $ocollaccent = array ( // limité au e à des fins de simplification
            "é"=>"e",
            "è"=>"e",
            "ë"=>"e",
            "É"=>"e",
            "È"=>"e", //ctrl alt 7 puis Maj e 
            ); 
        
        $estTrie=false; 
        $longueur_tableau = count($stabAtrier); 
        
        
         //for ($x = 0; $x < $longueur_tableau - 1 && !$estTrie; $x++)
        for ($x = 0; !$estTrie; $x++)
        {
            $estTrie=true; 
            
            for ($i = 0; $i < $longueur_tableau - 1; $i++)
            {
                $tabVisiteur1 = (array)$stabAtrier[$i];
                $x1 = substr($tabVisiteur1[$sattribut],0,1);//substr($stabAtrier[$i]->login,0,1);
                $tabVisiteur2 = (array)$stabAtrier[$i + 1];
                $x2 = substr($tabVisiteur2[$sattribut],0,1);//substr($stabAtrier[$i+1]->login, 0, 1);
                $caract_minuscule = strtolower($x1);
                $caract_minuscule2 = strtolower($x2);
                
                $longueurNom1 = strlen($tabVisiteur1[$sattribut]);
               
                /* Je vérifie si le caractère pris est un caractère accentué 
                 * - si oui alors je le remplace par la lettre minuscule sans accent correspondante 
                 * - sinon je conserve le caractère tel quel */
                if (array_key_exists($caract_minuscule, $ocollaccent))
                    {
                        $caract_minuscule = $ocollaccent[$caract_minuscule];
                    }
                if (array_key_exists($caract_minuscule2, $ocollaccent))
                    {
                        $caract_minuscule2 = $ocollaccent[$caract_minuscule2];
                    }
                /* je vérifie l'ordre (ord) dans la table ASCII du premier caractère de chaque mot
                 si le premier à un ordre supérieur au deuxième il faut permuter */
                if (ord($caract_minuscule) > ord($caract_minuscule2) )
                    {
                        $this->permutation($stabAtrier, $i); 
                        
                        $estTrie=false; 
                    }
                /* Si il est égal il faut comparer les autres caractères */
                if (ord($caract_minuscule) == ord($caract_minuscule2))
                    {
                        for ($z=1; $z< $longueurNom1; $z++) // z=1 car je commence la comparaison sur le deuxième le premier a déjà été testé
                        {
                            $x=substr($tabVisiteur1[$sattribut], $z, 1);
                            
                            /* les caractères du deuxième mot sont prélevés dans un try..catch car la longueur 
                             * du mot n°2 peut être inférieur à la longueur du mot n°1 et ainsi occasionner une exception que nous devons gérer*/
                            try
                            {
                                $y=substr($tabVisiteur2[$sattribut], $z, 1);                   
                            } 
                            catch (Exception $ex) 
                            {
                                /* Le mot devant se trouver après est celui le plus long exemple coco cocotte cocotte se trouve après coco
                                 * aussi si coco est le après il faut que je le place avant
                                 * pour cela je choisis un caractère dont le numéro d'ordre est avant les minuscules de l'alaphabet 
                                 * Le caratère "!" est un bon choix  */
                                $y='!';
                            }
                            $caract_minuscule = strtolower($x);
                            $caract_minuscule2 = strtolower($y);
                           
                            
                            // Je vérifie si il y a correspondance avec une lettre accentuée du dictionnaire
                            if (array_key_exists($caract_minuscule, $ocollaccent))
                            {
                                    $caract_minuscule = $ocollaccent[$caract_minuscule];
                                }
                            if (array_key_exists($caract_minuscule2, $ocollaccent))
                            {
                                    $caract_minuscule2 = $ocollaccent[$caract_minuscule2];
                                }
                            
                            // Si égaux alors on continue la boucle sur les autres caractères
                            if (ord($caract_minuscule) > ord($caract_minuscule2) )
                            {
                                // ils ne sont pas dans l'ordre, je permeute puis sors
                                $this->permutation($stabAtrier, $i); 

                                $estTrie=false; 
                                
                                break; // je sors de la comparaison des caractère à partir du deuxième pour passer sur le mot suivant
                            }
                            else 
                            {
                                // ils sont dans l'ordre je sors sans permuter - si ils sont égaux je continue à itérer
                                    if (ord($caract_minuscule) < ord($caract_minuscule2))
                                        {
                                            break ; // je sors de la comparaison des caractères à partir du deuxième pour passer sur le mot suivant
                                        }
                            }
                        }
                    } 
            }
        }
        return $stabAtrier;
    }
         
    public function permutation(&$stabAtrier, $si)
        {
            $temp = $stabAtrier[$si]; 
            $stabAtrier[$si]=$stabAtrier[$si+1]; 
            $stabAtrier[$si+1]= $temp; 
        }
}
