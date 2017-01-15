<?php
/**
 * Définit un utilisateur
 */
class Utilisateur implements JsonSerializable {
    // Données privées de la classe
    private $_id;
    private $_name;
    private $_role;
    private $_idProducteur;
    private $_idClient;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $name, $role, $idProducteur, $idClient) {
        $instance = new self();
        $instance->fillValues($id, $name, $role, $idProducteur, $idClient);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $name, $role, $idProducteur, $idClient) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_role = $role;
        $this->_idProducteur = $idProducteur;
        $this->_idClient = $idClient;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->id;
        $this->_name = $row->name;
        $this->_role = $row->role;
        $this->_idProducteur = $row->idProducteur;
        $this->_idClient = $row->idClient;
    }

    /**
     * Accesseur
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_id;
                break;
            case 'nom':
                return $this->_name;
                break;
            case 'role':
                return $this->_role;
                break;
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteurUtilisateur($this);
                break;
            case 'idClient':
                return $this->_idClient;
                break;
            case 'client':
                return DBLayer::getClientUtilisateur($this);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Vérifie si l'utilisateur a le mot de passe sélectionné.'
     */
    public function checkPassword($pass) {
        return DBLayer::checkPassword($this, $pass);
    }

    /**
     * Conversion en chaîne de caractères
     */
    public function __toString(){
        return $this->_name;
    }
    
    public function jsonSerialize() {
        $arr = array('id' => $this->_id, 'nom' => $this->_name, 'role' => $this->_role);
        if(!$this->role == 'producteur') $arr["idProducteur"] = $this->_idProducteur;
        else if(!$this->role == 'client') $arr["idClient"] = $this->_idClient;
        return $arr;
    }
}
?>