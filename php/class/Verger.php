<?php
// Définit un verger
class Verger implements JsonSerializable {
    //données privées de la classe
    private $_idVerger;
    private $_nomVerger;
    private $_superficie;
    private $_arbresParHectare;
    private $_nomProducteur;
    private $_libelleVariete;
    private $_idCommune;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $nom, $superficie, $arbresParHectare, $nomProducteur, $libelleVariete, $idCommune) {
        $instance = new self();
        $instance->fillValues($id, $nom, $superficie, $arbresParHectare, $nomProducteur, $libelleVariete, $idCommune);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $nom, $superficie, $arbresParHectare, $nomProducteur, $libelleVariete, $idCommune) {
        $this->_idVerger = $id;
        $this->_nomVerger = $nom;
        $this->_superficie = $superficie;
        $this->_arbresParHectare = $arbresParHectare;
        $this->_nomProducteur = $nomProducteur;
        $this->_libelleVariete = $libelleVariete;
        $this->_idCommune = $idCommune;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idVerger = $row->idVerger;
        $this->_nomVerger = $row->nomVerger;
        $this->_superficie = $row->superficie;
        $this->_arbresParHectare = $row->arbresParHectare;
        $this->_nomProducteur = $row->nomProducteur;
        $this->_libelleVariete = $row->libelle;
        $this->_idCommune = $row->idCommune;
    }
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idVerger;
                break;
            case 'nom':
                return $this->_nomVerger;
                break;
            case 'superficie':
                return $this->_superficie;
                break;
            case 'arbresParHectare':
                return $this->_arbresParHectare;
                break;
            case 'nomProducteur':
                return $this->_nomProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteurVerger($this);
                break;
            case 'libelleVariete':
                return $this->_libelleVariete;
                break;
            case 'variete':
                return DBLayer::getVarieteVerger($this);
                break;
            case 'idCommune':
                return $this->_idCommune;
                break;
            case 'commune':
                return DBLayer::getCommuneVerger($this);
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_nomVerger;
    }
    
    public function jsonSerialize() {
        return array('id' => $this->_idVerger, 'nom' => $this->_nomVerger, 'superficie' => $this->_superficie, 'arbresParHectare' => $this->_arbresParHectare, 'nomProducteur' => $this->_nomProducteur, 'libelleVariete' => $this->_libelleVariete, 'idCommune' => $this->_idCommune);
    }
}
?>