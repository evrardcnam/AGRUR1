<?php
// Définit une livraison
class Livraison {
    //données privées de la classe
    private $_idLivraison;
    private $_dateLivraison;
    private $_typeProduit;
    private $_quantiteLivree;
    private $_nbLots;
    private $_idVerger;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $date, $type, $quantite, $nbLots, $idVerger) {
        $instance = new self();
        $instance->fillValues($id, $date, $type, $quantite, $nbLots, $idVerger);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $date, $type, $quantite, $nbLots, $idVerger) {
        $this->_idLivraison = $id;
        $this->_dateLivraison = $date;
        $this->_typeProduit = $type;
        $this->_quantiteLivree = $quantite;
        $this->_nbLots = $nbLots;
        $this->_idVerger = $idVerger;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idLivraison = $row->idLivraison;
        $this->_dateLivraison = $row->dateLivraison;
        $this->_typeProduit = $row->typeProduit;
        $this->_quantiteLivree = $row->quantiteLivree;
        $this->_nbLots = $row->nbLots;
        $this->_idVerger = $row->idVerger;
    }

    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idLivraison;
                break;
            case 'date':
                return $this->_dateLivraison;
                break;
            case 'type':
                return $this->_typeProduit;
                break;
            case 'quantite':
                return $this->_quantiteLivree;
                break;
            case 'nbLots':
                return $this->_nbLots;
                break;
            case 'lots':
                return DBLayer::getLotsLivraison($this);
                break;
            case 'idVerger':
                return $this->_idVerger;
                break;
            case 'verger':
                return DBLayer::getVergerLivraison($this);
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_idLivraison;
    }
}
?>