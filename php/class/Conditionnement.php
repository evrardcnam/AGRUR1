<?php
// Définit un conditionnement
class Conditionnement implements JsonSerializable {
    //données privées de la classe
    private $_idConditionnement;
    private $_libelleConditionnement;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $libelle) {
        $instance = new self();
        $instance->fillValues($id, $libelle);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($id, $libelle) {
        $this->_idConditionnement = $id;
        $this->_libelleConditionnement = $libelle;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idConditionnement = $row->idConditionnement;
        $this->_libelleConditionnement = $row->libelleConditionnement;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idConditionnement;
                break;
            case 'libelle':
                return $this->_libelleConditionnement;
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_libelleConditionnement;
    }
    
    public function jsonSerialize() {
        return array('id' => $this->_idConditionnement, 'libelle' => $this->_libelleConditionnement);
    }
}
?>