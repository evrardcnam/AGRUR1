<?php
// Définit une commune
class Commune implements JsonSerializable {
    //données privées de la classe
    private $_idCommune;
    private $_nomCommune;
    private $_communeAoc;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $nom, $aoc) {
        $instance = new self();
        $instance->fillValues($id, $nom, $aoc);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($id, $nom, $aoc) {
        $this->_idCommune = $id;
        $this->_nomCommune = $nom;
        $this->_communeAoc = $aoc;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idCommune = $row->idCommune;
        $this->_nomCommune = $row->nomCommune;
        $this->_communeAoc = $row->communeAoc;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idCommune;
                break;
            case 'nom':
                return $this->_nomCommune;
                break;
            case 'aoc':
            case 'communeAoc':
                return $this->_communeAoc;
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_nomCommune;
    }

    public function jsonSerialize() {
        return array('id' => $this->_idCommune, 'nom' => $this->_nomCommune, 'aoc' => $this->_communeAoc);
    }
}
?>