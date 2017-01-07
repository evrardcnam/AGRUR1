<?php
// Définit une certification
class Certification implements JsonSerializable {
    //données privées de la classe
    private $_idCertification;
    private $_libelleCertification;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($idCertification, $libelleCertification) {
        $instance = new self();
        $instance->fillValues($idCertification, $libelleCertification);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($idCertification, $libelleCertification) {
        $this->_idCertification = $idCertification;
        $this->_libelleCertification = $libelleCertification;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idCertification = $row->idCertification;
        $this->_libelleCertification = $row->libelleCertification;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idCertification;
                break;
            case 'libelle':
                return $this->_libelleCertification;
                break;
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_libelleCertification;
    }

    public function jsonSerialize() {
        return array('id' => $this->_idCertification, 'libelle' => $this->_libelleCertification);
    }
}
?>