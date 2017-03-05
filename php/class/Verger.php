<?php
/**
 * @class Verger
 * @brief Décrit un verger.
 */
class Verger implements JsonSerializable {
    //données privées de la classe
    private $_idVerger;
    private $_nomVerger;
    private $_superficie;
    private $_arbresParHectare;
    private $_idProducteur;
    private $_idVariete;
    private $_idCommune;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du verger dans la base de données.
     * @param string $nom
     *   Nom du verger.
     * @param int $superficie
     *   Superficie du verger en hectares.
     * @param int $arbresParHectare
     *   Nombre d'arbres par hectare.
     * @param int $idProducteur
     *   Identifiant unique du producteur exploitant ce verger.
     * @param int $idVariete
     *   Identifiant unique de la variété exploitée dans ce verger.
     * @param int $idCommune
     *   Identifiant unique de la commune où se situe ce verger.
     * @return Verger
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune) {
        $instance = new self();
        $instance->fillValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un verger.
     * @return Verger
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
     *   Identifiant unique du verger dans la base de données.
     * @param string $nom
     *   Nom du verger.
     * @param int $superficie
     *   Superficie du verger en hectares.
     * @param int $arbresParHectare
     *   Nombre d'arbres par hectare.
     * @param int $idProducteur
     *   Identifiant unique du producteur exploitant ce verger.
     * @param int $idVariete
     *   Identifiant unique de la variété exploitée dans ce verger.
     * @param int $idCommune
     *   Identifiant unique de la commune où se situe ce verger.
     */
    protected function fillValues($id, $nom, $superficie, $arbresParHectare, $idProducteur, $idVariete, $idCommune) {
        $this->_idVerger = $id;
        $this->_nomVerger = $nom;
        $this->_superficie = $superficie;
        $this->_arbresParHectare = $arbresParHectare;
        $this->_idProducteur = $idProducteur;
        $this->_idVariete = $idVariete;
        $this->_idCommune = $idCommune;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un verger.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idVerger = $row->idVerger;
        $this->_nomVerger = $row->nomVerger;
        $this->_superficie = $row->superficie;
        $this->_arbresParHectare = $row->arbresParHectare;
        $this->_idProducteur = $row->idProducteur;
        $this->_idVariete = $row->idVariete;
        $this->_idCommune = $row->idCommune;
    }

    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idVerger;
                break;
            case 'nom':
                return $this->_nomVerger;
                break;
            case 'superficie':
                return $this->_superficie;
                break;
            case 'arbresParHectare':
                return $this->_arbresParHectare;
                break;
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteurVerger($this);
                break;
            case 'idVariete':
                return $this->_idVariete;
                break;
            case 'variete':
                return DBLayer::getVarieteVerger($this);
                break;
            case 'idCommune':
                return $this->_idCommune;
                break;
            case 'commune':
                return DBLayer::getCommuneVerger($this);
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
        return $this->_nomVerger;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idVerger, 'nom' => $this->_nomVerger, 'superficie' => $this->_superficie, 'arbresParHectare' => $this->_arbresParHectare, 'idProducteur' => $this->_idProducteur, 'idVariete' => $this->_idVariete, 'idCommune' => $this->_idCommune);
    }
}
?>