<?php
/**
 * Définit un utilisateur
 */
class Utilisateur {
    // Données privées de la classe
    private $_id;
    private $_name;
    private $_admin;
    private $_nomProducteur;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($id, $name, $admin, $nomProducteur) {
        $instance = new self();
        $instance->fillValues($id, $name, $admin, $nomProducteur);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($id, $name, $admin, $nomProducteur) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_admin = $admin;
        $this->_nomProducteur = $nomProducteur;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->id;
        $this->_name = $row->name;
        $this->_admin = $row->admin;
        $this->_nomProducteur = $row->nomProducteur;
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
            case 'nomProducteur':
                return $this->_nomProducteur;
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
}
?>