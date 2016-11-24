<?php
// Définit une livraison
class Livraison {
    //données privées de la classe
    private $_idLivraison;
    private $_dateLivraison;
    private $_typeProduit;
    private $_quantiteLivree;
    private $_idVerger;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        $this->_idLivraison = $result->idLivraison;
        $this->_dateLivraison = $result->dateLivraison;
        $this->_typeProduit = $result->typeProduit;
        $this->_quantiteLivree = $result->quantiteLivree;
        $this->_idVerger = $result->idVerger;
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
            case 'lots':
                return getLotsLivraison($this);
                break;
            case 'idVerger':
                return $this->_idVerger;
                break;
            case 'verger':
                return getVergerLivraison($this);
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