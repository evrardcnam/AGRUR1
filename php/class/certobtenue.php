<?php
// Définit une certification obtenue par un producteur
class CertObtenue extends Certification {
    //données privées de la classe
    private $_dateObtention;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        $super($result);
        $this->_dateObtention = $result->dateObtention;
    }
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'date':
                return $this->_dateObtention;
                break;
            default:
                return $super->__get($var);
                break;
    }
}
// Conversion en chaînes de caractères
public function __toString(){
    return $super->__toString();
}
}
?>