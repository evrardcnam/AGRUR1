<?php
// Définit une certification
class Certification {
    //données privées de la classe
    private $_idCertification;
    private $_libelleCertification;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        $this->_idCertification = $result->idCertification;
        $this->_libelleCertification = $result->libelleCertification;
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
}
?>