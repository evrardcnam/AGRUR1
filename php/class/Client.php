<?php
// Définit un client
class Client implements JsonSerializable {
    //données privées de la classe
    private $_idClient;
    private $_nomClient;
    private $_adresseClient;
    private $_nomResAchats;
    private $_idUser;
    
    public function __construct(){
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $nom, $adresse, $nomRes, $idUser) {
        $instance = new self();
        $instance->fillValues($id, $nom, $adresse, $nomRes, $idUser);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }
    
    protected function fillValues($id, $nom, $adresse, $nomRes, $idUser) {
        $this->_idClient = $id;
        $this->_nomClient = $nom;
        $this->_adresseClient = $adresse;
        $this->_nomRes = $nomRes;
        $this->_idUser = $idUser;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_idClient = $row->idClient;
        $this->_nomClient = $row->nomClient;
        $this->_adresseClient = $row->adresseClient;
        $this->_nomResAchats = $row->nomResAchats;
        $this->_idUser = $row->idUser;
    }
    
    // Accesseur
    public function __get($var){
        switch ($var){
            case 'id':
            case 'idClient':
                return $this->_idClient;
                break;
            case 'nom':
            case 'nomClient':
                return $this->_nomClient;
                break;
            case 'adresse':
            case 'adresseClient':
                return $this->_adresseClient;
                break;
            case 'nomResAchats':
                return $this->_nomResAchats;
                break;
            case 'idUser':
            case 'idUtilisateur':
                return $this->_idUser;
                break;
            case 'user':
            case 'utilisateur':
                return DBLayer::getUtilisateurClient($this);
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

    public function jsonSerialize() {
        return array('id' => $this->_idClient, 'nom' => $this->_nomClient, 'adresse' => $this->adresse, 'nomResAchats' => $this->_nomResAchats, 'idUser' => $this->_idUser);
    }
}
?>