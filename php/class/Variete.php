<?php
// Définit une variété
class Variete {
    //données privées de la classe
    private $_libelle;
    private $_varieteAoc;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($libelle, $aoc) {
        $instance = new self();
        $instance->fillValues($libelle, $aoc);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($libelle, $aoc) {
        $_libelle = $libelle;
        $_communeAoc = $aoc;
    }

    protected function fillRow(DBQueryResult $row) {
        $_libelle = $row->libelle;
        $_communeAoc = $row->varieteAoc;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
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
}
?>