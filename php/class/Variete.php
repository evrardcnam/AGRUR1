<?php
// Définit une variété
class Variete implements JsonSerializable {
    //données privées de la classe
    private $_id;
    private $_libelle;
    private $_varieteAoc;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $libelle, $aoc) {
        $instance = new self();
        $instance->fillValues($id, $libelle, $aoc);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($id, $libelle, $aoc) {
        $this->_id = $id;
        $this->_libelle = $libelle;
        $this->_communeAoc = $aoc;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->idVariete;
        $this->_libelle = $row->libelle;
        $this->_communeAoc = $row->varieteAoc;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_id;
                break;
            case 'libelle':
                return $this->_libelle;
                break;
            case 'aoc':
            case 'varieteAoc':
                return $this->_varieteAoc;
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_libelle;
    }
    
    public function jsonSerialize() {
        return array('id' => $this->_id, 'libelle' => $this->_libelle, 'aoc' => $this->_varieteAoc);
    }
}
?>