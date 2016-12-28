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
    /**
     * Constructeur de la classe depuis la couche d'accès aux données
     */
    public function __construct(DBQueryResult $result){
        $this->_id = $result->id;
        $this->_name = $result->name;
        $this->_admin = $result->admin;
        $this->_nomProducteur = $result->nomProducteur;
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
                return DBLayer::getProducteur($this->_nomProducteur);
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