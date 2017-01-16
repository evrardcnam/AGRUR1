<?php
// Définit un lot
class Lot implements JsonSerializable {
    //données privées de la classe
    private $_idLot;
    private $_codeLot;
    private $_calibreLot;
    private $_quantite;
    private $_idLivraison;
    private $_numCommande;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande) {
        $instance = new self();
        $instance->fillValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande) {
        $this->_idLot = $id;
        $this->_codeLot = $code;
        $this->_calibreLot = $calibre;
        $this->_quantite = $quantite; 
        $this->_idLivraison = $idLivraison;
        $this->_numCommande = $numCommande;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idLot = $row->idLot;
        $this->_codeLot = $row->codeLot;
        $this->_calibreLot = $row->calibreLot;
        $this->_quantite = $row->quantite;
        $this->_idLivraison = $row->idLivraison;
        $this->_numCommande = $row->numCommande;
    }

    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idLot;
            case 'code':
                return $this->_codeLot;
                break;
            case 'calibre':
                return $this->_calibreLot;
                break;
            case 'quantite':
                return $this->_quantite;
                break;
            case 'idLivraison':
                return $this->_idLivraison;
                break;
            case 'livraison':
                return DBLayer::getLivraison($this->_idLivraison);
                break;
            case 'numCommande':
                return $this->_numCommande;
                break;
            case 'commande':
                return DBLayer::getCommande($this->_numCommande);
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_codeLot;
    }
    
    public function jsonSerialize() {
        return array('id' => $this->_idLot, 'code' => $this->_codeLot, 'calibre' => $this->_calibreLot, 'quantite' => $this->_quantite, 'idLivraison' => $this->_idLivraison, 'numCommande' => $this->_numCommande);
    }
}
?>