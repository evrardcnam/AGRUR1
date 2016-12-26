<?php
/**
 * Définit un utilisateur
 */
class Utilisateur {
    // Données privées de la classe
    private $_id;
    private $_name;
    private $_admin;
    /**
     * Constructeur de la classe depuis la couche d'accès aux données
     */
    public function __construct(DBQueryResult $result){
        $this->_id = $result->id;
        $this->_name = $result->name;
        $this->_admin = $result->admin;
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