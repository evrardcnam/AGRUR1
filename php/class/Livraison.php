<?php
/**
 * @class Livraison
 * @brief Décrit une livraison de noix par un producteur.
 */
class Livraison implements JsonSerializable {
    //données privées de la classe
    private $_idLivraison;
    private $_dateLivraison;
    private $_typeProduit;
    private $_nbLots;
    private $_idVerger;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique de la livraison dans la base de données.
     * @param string $date
     *   Date de la livraison.
     * @param string $type
     *   Type de produit livré.
     * @param int $nbLots
     *   Nombre total de lots livrés.
     * @param int $idVerger
     *   Identifiant unique du verger de provenance de la livraison.
     * @return Livraison
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $date, $type, $nbLots, $idVerger) {
        $instance = new self();
        $instance->fillValues($id, $date, $type, $nbLots, $idVerger);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une livraison.
     * @return Livraison
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
     *   Identifiant unique de la livraison dans la base de données.
     * @param string $date
     *   Date de la livraison.
     * @param string $type
     *   Type de produit livré.
     * @param int $nbLots
     *   Nombre total de lots livrés.
     * @param int $idVerger
     *   Identifiant unique du verger de provenance de la livraison.
     */
    protected function fillValues($id, $date, $type, $nbLots, $idVerger) {
        $this->_idLivraison = $id;
        $this->_dateLivraison = $date;
        $this->_typeProduit = $type;
        $this->_nbLots = $nbLots;
        $this->_idVerger = $idVerger;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une livraison.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idLivraison = $row->idLivraison;
        $this->_dateLivraison = $row->dateLivraison;
        $this->_typeProduit = $row->typeProduit;
        $this->_nbLots = $row->nbLots;
        $this->_idVerger = $row->idVerger;
    }

    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idLivraison;
                break;
            case 'date':
                return $this->_dateLivraison;
                break;
            case 'type':
                return $this->_typeProduit;
                break;
            case 'nbLots':
                return $this->_nbLots;
                break;
            case 'lots':
                return DBLayer::getLotsLivraison($this);
                break;
            case 'idVerger':
                return $this->_idVerger;
                break;
            case 'verger':
                return DBLayer::getVergerLivraison($this);
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
        return $this->_idLivraison;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idLivraison, 'date' => $this->_dateLivraison, 'type' => $this->_typeProduit, 'nbLots' => $this->_nbLots, 'idVerger' => $this->_idVerger);
    }
}
?>