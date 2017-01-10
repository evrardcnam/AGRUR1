<?php
// Définit une certification obtenue par un producteur
class CertObtenue extends Certification implements JsonSerializable {
    //données privées de la classe
    private $_dateObtention;
    private $_idProducteur;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($idCertification, $libelleCertification, $idProducteur, $dateObtention) {
        $instance = new self();
        $instance->fillValues($idCertification, $libelleCertification, $idProducteur, $dateObtention);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result){
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($idCertification, $libelleCertification, $idProducteur, $dateObtention) {
        parent::fillValues($idCertification, $libelleCertification);
        $this->_dateObtention = $dateObtention;
        $this->_idProducteur = $idProducteur;
    }

    protected function fillRow(DBQueryResult $row) {
        parent::fillRow($row);
        $this->_dateObtention = $row->dateObtention;
        $this->_idProducteur = $row->idProducteur;
    }

    // Accesseur
    public function __get($var){
        switch ($var){
            case 'date':
            case 'dateObtention':
                return $this->_dateObtention;
                break;
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteur($this->_idProducteur);
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
        $a['idProducteur'] = $this->_idProducteur;
        return $a;
    }
}
?>