<?php

class Cdao
{
    private function getPDO()
    {
        $strConnection = 'mysql:host=localhost;dbname=final_gsb'; // DSN
        $arrExtraParam= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); // demande format utf-8
        $pdo = new PDO($strConnection, 'root', '', $arrExtraParam); // Instancie la connexion
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);// Demande la gestion d'exception car par défaut PDO ne la propose pas 
        return $pdo;
    }
    
    public function gettabDataFromSql($squery)
    {
        $pdo = $this->getPDO();        
        $lesVisiteurs = $pdo->query($squery);                       
        return $lesVisiteurs;
    }
    
    public function getTabObjetFromSql($squery, $stype) //$stype sera le type d'objet que l'on désire
    {
        $lepdo = $this->getPDO();
        
        //prepare() et execute () pour plus de sécurité
        $sth = $lepdo->prepare($squery); //prepare echappe entre autre proprement la requete
        $sth->execute();
        
        $result = $sth->fetchAll(PDO::FETCH_CLASS, $stype); //fetchAll met toutes les données dans un tableau d'objets du type en paramètre
        unset($lepdo);
        
        return $result; //$result est un tableau d'objet du type en parametre comportant tous les objets du type (All de fetchAll)
    }
    
    public function update($squery){
        $pdo = $this->getPDO();        
        $pdo->query($squery);
    }
    
    public function insert($squery){
        $pdo = $this->getPDO();        
        $pdo->query($squery);
    }
    
    public function delete($squery){
        $pdo = $this->getPDO();        
        $pdo->query($squery);
    }
    
    public function getParamOutPS($squery){
        $lepdo = $this->getPDO();
        $nbligne = $lepdo->exec($squery); // exec renvoie le nombre de ligne affectée
        $tabParamSortie = $lepdo->query('select @nbre')->fetchAll();
        
        return $tabParamSortie;
    }
   
}