<?php
// Définit un producteur
class Producteur {
    //données privées de la classe
    private $_nomProducteur;
    private $_dateAdhesion;
    private $_adherent;
    private $_adresseProducteur;
    private $_idUtilisateur;
    
    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($nom, $adresse, $adherent, $date, $idUser) {
        $instance = new self();
        $instance->fillValues($nom, $adresse, $adherent, $date, $idUser);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($nom, $adresse, $adherent, $date, $idUser) {
        $this->_nomProducteur = $nom;
        $this->_adresseProducteur = $adresse;
        $this->_adherent = $adherent;
        $this->_dateAdhesion = $date;
        $this->_idUtilisateur = $idUser;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_nomProducteur = $row->nomProducteur;
        $this->_dateAdhesion = $row->dateAdhesion;
        $this->_adherent = $row->adherent;
        $this->_adresseProducteur = $row->adresseProducteur;
        $this->_idUtilisateur = $row->idUser;
    }

    // Accesseur
    public function __get($var){
        switch ($var){
            case 'nom':
                return $this->_nomProducteur;
                break;
            case 'dateAdhesion':
                return $this->_dateAdhesion;
                break;
            case 'adherent':
                return $this->_adherent;
                break;
            case 'adresse':
                return $this->_adresseProducteur;
                break;
            case 'certifications':
                return DBLayer::getCertificationsValidees($this);
                break;
            case 'idUtilisateur':
            case 'idUser':
                return $this->_idUtilisateur;
            case 'utilisateur':
            case 'user':
                return DBLayer::getUtilisateurProducteur($this);
            default:
                return null;
                break;
        }
    }
    // Conversion en chaînes de caractères
    public function __toString(){
        return $this->_nomProducteur;
    }
}
?>