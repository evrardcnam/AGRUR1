<?php
/**
 * @class Conditionnement
 * @brief Décrit un mode de conditionnement pour une commande.
 */
class Conditionnement implements JsonSerializable {
    //données privées de la classe
    private $_idConditionnement;
    private $_libelleConditionnement;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du conditionnement dans la base de données.
     * @param string $libelle
     *   Libellé du conditionnement.
     * @return Conditionnement
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $libelle) {
        $instance = new self();
        $instance->fillValues($id, $libelle);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un conditionnement.
     * @return Conditionnement
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
     *   Identifiant unique du conditionnement dans la base de données.
     * @param string $libelle
     *   Libellé du conditionnement.
     */
    protected function fillValues($id, $libelle) {
        $this->_idConditionnement = $id;
        $this->_libelleConditionnement = $libelle;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un conditionnement.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idConditionnement = $row->idConditionnement;
        $this->_libelleConditionnement = $row->libelleConditionnement;
    }
    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idConditionnement;
                break;
            case 'libelle':
                return $this->_libelleConditionnement;
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
        return $this->_libelleConditionnement;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idConditionnement, 'libelle' => $this->_libelleConditionnement);
    }
}
?>