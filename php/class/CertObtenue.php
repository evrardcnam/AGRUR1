<?php
// Définit une certification obtenue par un producteur
class CertObtenue extends Certification implements JsonSerializable {
    //données privées de la classe
    private $_dateObtention;
    private $_nomProducteur;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($idCertification, $libelleCertification, $nomProducteur, $dateObtention) {
        $instance = new self();
        $instance->fillValues($idCertification, $libelleCertification, $nomProducteur, $dateObtention);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result){
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($idCertification, $libelleCertification, $nomProducteur, $dateObtention) {
        parent::fillValues($idCertification, $libelleCertification);
        $this->_dateObtention = $dateObtention;
        $this->_nomProducteur = $nomProducteur;
    }

    protected function fillRow(DBQueryResult $row) {
        parent::fillRow($row);
        $this->_dateObtention = $row->dateObtention;
        $this->_nomProducteur = $row->nomProducteur;
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

    public function jsonSerialize() {
        $a = parent::jsonSerialize();
        $a['date'] = $this->_dateObtention;
        $a['nomProducteur'] = $this->_nomProducteur;
    }
}
?>