<?php
/**
 * @class Client
 * @brief Décrit un client.
 */
class Client implements JsonSerializable {
    //données privées de la classe
    private $_idClient;
    private $_nomClient;
    private $_adresseClient;
    private $_nomResAchats;
    private $_idUser;
    
    public function __construct(){
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du client dans la base de données.
     * @param string $nom
     *   Nom du client.
     * @param string $adresse
     *   Adresse du client.
     * @param string $nomRes
     *   Nom du responsable des achats du client.
     * @param int $idUser
     *   Identifiant unique de l'utilisateur associé au client.
     * @return Client
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $nom, $adresse, $nomRes, $idUser) {
        $instance = new self();
        $instance->fillValues($id, $nom, $adresse, $nomRes, $idUser);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un client.
     * @return Client
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
     *   Identifiant unique du client dans la base de données.
     * @param string $nom
     *   Nom du client.
     * @param string $adresse
     *   Adresse du client.
     * @param string $nomRes
     *   Nom du responsable des achats du client.
     * @param int $idUser
     *   Identifiant unique de l'utilisateur associé au client.
     */
    protected function fillValues($id, $nom, $adresse, $nomRes, $idUser) {
        $this->_idClient = $id;
        $this->_nomClient = $nom;
        $this->_adresseClient = $adresse;
        $this->_nomResAchats = $nomRes;
        $this->_idUser = $idUser;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un client.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idClient = $row->idClient;
        $this->_nomClient = $row->nomClient;
        $this->_adresseClient = $row->adresseClient;
        $this->_nomResAchats = $row->nomResAchats;
        $this->_idUser = $row->idUser;
    }
    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
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
    
    /**
     * @brief Conversion en chaîne de caractères
     * @return string Instance sous forme de chaîne de caractères.
     */
    public function __toString(){
        return $this->_nomClient;
    }

    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idClient, 'nom' => $this->_nomClient, 'adresse' => $this->adresse, 'nomResAchats' => $this->_nomResAchats, 'idUser' => $this->_idUser);
    }
}
?>