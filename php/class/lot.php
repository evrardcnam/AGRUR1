<?php
// Définit un lot
class Lot {
    //données privées de la classe
    private $_codeLot;
    private $_calibreLot;
    private $_idLivraison;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        $this->_codeLot = $result->codeLot;
        $this->_calibreLot = $result->calibreLot;
        $this->_idLivraison = $result->idLivraison;
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