<?php
/**
 * Définit un utilisateur
 */
class Utilisateur implements JsonSerializable {
    // Données privées de la classe
    private $_id;
    private $_name;
    private $_admin;
    private $_idProducteur;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $name, $admin, $idProducteur) {
        $instance = new self();
        $instance->fillValues($id, $name, $admin, $idProducteur);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $name, $admin, $idProducteur) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_admin = $admin;
        $this->_idProducteur = $idProducteur;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->id;
        $this->_name = $row->name;
        $this->_admin = $row->admin;
        $this->_idProducteur = $row->idProducteur;
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
            case 'admin':
                return $this->_admin;
                break;
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteurUtilisateur($this);
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
        $arr = array('id' => $this->_id, 'nom' => $this->_name, 'admin' => $this->_admin);
        if(!$this->admin) $arr["idProducteur"] = $this->_idProducteur;
        return $arr;
    }
}
?>