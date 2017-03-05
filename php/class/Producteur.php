<?php
/**
 * @class Producteur
 * @brief Décrit un producteur de noix.
 */
class Producteur implements JsonSerializable {
    //données privées de la classe
    private $_idProducteur;
    private $_nomProducteur;
    private $_dateAdhesion;
    private $_adherent;
    private $_adresseProducteur;
    private $_idUtilisateur;
    
    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du producteur dans la base de données.
     * @param string $nom
     *   Nom du producteur.
     * @param string $adresse
     *   Adresse du producteur.
     * @param bool $adherent
     *   État d'adhésion du producteur à AGRUR.
     * @param string|null $date
     *   Date d'adhésion du producteur à AGRUR. NULL si le producteur n'est pas adhérent.
     * @param int $idUser
     *   Identifiant unique de l'utilisateur associé au producteur.
     * @return Producteur
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $nom, $adresse, $adherent, $date, $idUser) {
        $instance = new self();
        $instance->fillValues($id, $nom, $adresse, $adherent, $date, $idUser);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un producteur.
     * @return Producteur
     *   Nouvelle instance initialisée avec le résultat de requête.
     */
    public static function fromResult(DBQueryResult $row) {
        $instance = new self();
        $instance->fillRow($row);
        return $instance;
    }

    /**
     * @brief Constructeur de la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du producteur dans la base de données.
     * @param string $nom
     *   Nom du producteur.
     * @param string $adresse
     *   Adresse du producteur.
     * @param bool $adherent
     *   État d'adhésion du producteur à AGRUR.
     * @param string|null $date
     *   Date d'adhésion du producteur à AGRUR. NULL si le producteur n'est pas adhérent.
     * @param int $idUser
     *   Identifiant unique de l'utilisateur associé au producteur.
     */
    protected function fillValues($id, $nom, $adresse, $adherent, $date, $idUser) {
        $this->_idProducteur = $id;
        $this->_nomProducteur = $nom;
        $this->_adresseProducteur = $adresse;
        $this->_adherent = $adherent;
        $this->_dateAdhesion = $date;
        $this->_idUtilisateur = $idUser;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un producteur.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idProducteur = $row->idProducteur;
        $this->_nomProducteur = $row->nomProducteur;
        $this->_dateAdhesion = $row->dateAdhesion;
        $this->_adherent = $row->adherent;
        $this->_adresseProducteur = $row->adresseProducteur;
        $this->_idUtilisateur = $row->idUser;
    }

    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
            case 'idProducteur':
                return $this->_idProducteur;
                break;
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

    /**
     * @brief Conversion en chaîne de caractères
     * @return string Instance sous forme de chaîne de caractères.
     */
    public function __toString(){
        return $this->_nomProducteur;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        $arr = array('id' => $this->_idProducteur, 'nom' => $this->_nomProducteur, 'adherent' => $this->_adherent, 'adresse' => $this->_adresseProducteur, 'idUser' => $this->_idUtilisateur);
        if($this->_adherent) $arr["dateAdhesion"] = $this->_dateAdhesion;
    }
}
?>