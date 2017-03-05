<?php
/**
 * @class Utilisateur
 * @brief Définit un utilisateur de l'application.
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
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique de l'utilisateur dans la base de données.
     * @param string $name
     *   Pseudonyme de l'utilisateur.
     * @param string $role
     *   Rôle de l'utilisateur.
     * @param int|null $idProducteur
     *   Identifiant unique du producteur associé à l'utilisateur, le cas échéant.
     * @param int|null $idClient
     *   Identifiant unique du client associé à l'utilisateur, le cas échéant.
     * @return Utilisateur
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $name, $role, $idProducteur, $idClient) {
        $instance = new self();
        $instance->fillValues($id, $name, $role, $idProducteur, $idClient);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un utilisateur.
     * @return Utilisateur
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
     *   Identifiant unique de l'utilisateur dans la base de données.
     * @param string $name
     *   Pseudonyme de l'utilisateur.
     * @param string $role
     *   Rôle de l'utilisateur.
     * @param int|null $idProducteur
     *   Identifiant unique du producteur associé à l'utilisateur, le cas échéant.
     * @param int|null $idClient
     *   Identifiant unique du client associé à l'utilisateur, le cas échéant.
     */
    protected function fillValues($id, $name, $role, $idProducteur, $idClient) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_role = $role;
        $this->_idProducteur = $idProducteur;
        $this->_idClient = $idClient;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un utilisateur.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->id;
        $this->_name = $row->name;
        $this->_role = $row->role;
        $this->_idProducteur = $row->idProducteur;
        $this->_idClient = $row->idClient;
    }

    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
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
     * @brief Vérifie si le mot de passe de l'utilisateur correspond à une saisie.
     * @param string $pass
     *   Mot de passe en clair à comparer au mot de passe de l'utilisateur.
     */
    public function checkPassword($pass) {
        return DBLayer::checkPassword($this, $pass);
    }

    /**
     * @brief Conversion en chaîne de caractères
     * @return string Instance sous forme de chaîne de caractères.
     */
    public function __toString(){
        return $this->_name;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        $arr = array('id' => $this->_id, 'nom' => $this->_name, 'role' => $this->_role);
        if(!$this->role == 'producteur') $arr["idProducteur"] = $this->_idProducteur;
        else if(!$this->role == 'client') $arr["idClient"] = $this->_idClient;
        return $arr;
    }
}
?>