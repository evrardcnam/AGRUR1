<?php
// Définit un lot
class Lot {
    //données privées de la classe
    private $_codeLot;
    private $_calibreLot;
    private $_idLivraison;
    private $_numCommande;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($code, $calibre, $idLivraison, $numCommande) {
        $instance = new self();
        $instance->fillValues($code, $calibre, $idLivraison, $numCommande);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($code, $calibre, $idLivraison, $numCommande) {
        $this->_codeLot = $code;
        $this->_calibreLot = $calibre;
        $this->_idLivraison = $idLivraison;
        $this->_numCommande = $numCommande;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_codeLot = $row->codeLot;
        $this->_calibreLot = $row->calibreLot;
        $this->_idLivraison = $row->idLivraison;
        $this->_numCommande = $row->numCommande;
    }

    // Accesseur
    public function __get($var){
        switch ($var){
            case 'code':
                return $this->_codeLot;
                break;
            case 'calibre':
                return $this->_calibreLot;
                break;
            case 'idLivraison':
                return $this->_idLivraison;
                break;
            case 'numCommande':
                return $this->_numCommande;
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_codeLot;
    }
}
?>