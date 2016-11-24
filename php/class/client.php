<?php
// Définit un client
class Client {
    //données privées de la classe
    private $_nomClient;
    private $_adresseClient;
    private $_nomResAchats;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result){
        $this->_nomClient = $result->nomClient;
        $this->_adresseClient = $result->adresseClient;
        $this->_nomResAchats = $result->nomResAchats;
    }
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'nom':
                return $this->_nomClient;
                break;
            case 'adresseClient':
                return $this->_adresseClient;
                break;
            case 'nomResAchats':
                return $this->_nomResAchats;
                break;
            default:
                return null;
                break;
    }
}
// Conversion en chaînes de caractères
public function __toString(){
    return $this->_nomClient;
}
}
?>