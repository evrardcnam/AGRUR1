<?php
/**
 * @class Variete
 * @brief Décrit une variété de noix.
 */
class Variete implements JsonSerializable {
    //données privées de la classe
    private $_id;
    private $_libelle;
    private $_varieteAoc;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique de la variété dans la base de données.
     * @param string $libelle
     *   Libellé de la variété.
     * @param bool $aoc
     *   Validité de la variété pour l'appellation d'origine contrôlée.
     * @return Variete
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $libelle, $aoc) {
        $instance = new self();
        $instance->fillValues($id, $libelle, $aoc);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une variété.
     * @return Variete
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
     *   Identifiant unique de la variété dans la base de données.
     * @param string $libelle
     *   Libellé de la variété.
     * @param bool $aoc
     *   Validité de la variété pour l'appellation d'origine contrôlée.
     */
    protected function fillValues($id, $libelle, $aoc) {
        $this->_id = $id;
        $this->_libelle = $libelle;
        $this->_varieteAoc = $aoc;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une variété.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_id = $row->idVariete;
        $this->_libelle = $row->libelle;
        $this->_varieteAoc = $row->varieteAoc;
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
            case 'libelle':
                return $this->_libelle;
                break;
            case 'aoc':
            case 'varieteAoc':
                return $this->_varieteAoc;
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
        return $this->_libelle;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_id, 'libelle' => $this->_libelle, 'aoc' => $this->_varieteAoc);
    }
}
?>