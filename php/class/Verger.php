<?php
// Définit un verger
class Verger implements JsonSerializable {
    //données privées de la classe
    private $_idVerger;
    private $_nomVerger;
    private $_superficie;
    private $_arbresParHectare;
    private $_idProducteur;
    private $_idVariete;
    private $_idCommune;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune) {
        $instance = new self();
        $instance->fillValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune) {
        $this->_idVerger = $id;
        $this->_nomVerger = $nom;
        $this->_superficie = $superficie;
        $this->_arbresParHectare = $arbresParHectare;
        $this->_idProducteur = $idProducteur;
        $this->_idVariete = $idVariete;
        $this->_idCommune = $idCommune;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idVerger = $row->idVerger;
        $this->_nomVerger = $row->nomVerger;
        $this->_superficie = $row->superficie;
        $this->_arbresParHectare = $row->arbresParHectare;
        $this->_idProducteur = $row->idProducteur;
        $this->_idVariete = $row->idVariete;
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
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteurVerger($this);
                break;
            case 'idVariete':
                return $this->_idVariete;
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
        return array('id' => $this->_idVerger, 'nom' => $this->_nomVerger, 'superficie' => $this->_superficie, 'arbresParHectare' => $this->_arbresParHectare, 'idProducteur' => $this->_idProducteur, 'idVariete' => $this->_idVariete, 'idCommune' => $this->_idCommune);
    }
}
?>