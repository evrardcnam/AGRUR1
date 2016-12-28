<?php
// Définit une certification obtenue par un producteur
class CertObtenue extends Certification {
    //données privées de la classe
    private $_dateObtention;
    private $_nomProducteur;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        parent::__construct($result);
        $this->_dateObtention = $result->dateObtention;
        $this->_nomProducteur = $result->nomProducteur;
    }
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'date':
            case 'dateObtention':
                return $this->_dateObtention;
                break;
            case 'nomProducteur':
                return $this->_nomProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteur($this->_nomProducteur);
                break;
            default:
                return parent::__get($var);
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $super->__toString();
    }
}
?>