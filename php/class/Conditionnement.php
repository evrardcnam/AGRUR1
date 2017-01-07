<?php
// Définit un conditionnement
class Conditionnement implements JsonSerializable {
    //données privées de la classe
    private $_idConditionnement;
    private $_libelleConditionnement;
    private $_poids;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $libelle, $poids) {
        $instance = new self();
        $instance->fillValues($id, $libelle, $poids);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($id, $libelle, $poids) {
        $_idConditionnement = $id;
        $_libelleConditionnement = $libelle;
        $_poids = $poids;
    }

    protected function fillRow(DBQueryResult $row) {
        $_idConditionnement = $row->idConditionnement;
        $_libelleConditionnement = $row->libelleConditionnement;
        $_poids = $row->poids;
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
            case 'poids':
                return $this->_poids;
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
        return array('id' => $this->_idConditionnement, 'libelle' => $this->_libelleConditionnement, 'poids' => $this->_poids);
    }
}
?>