<?php
/**
 * @class Commune
 * @brief Décrit une commune.
 */
class Commune implements JsonSerializable {
    //données privées de la classe
    private $_idCommune;
    private $_nomCommune;
    private $_communeAoc;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique de la commune dans la base de données.
     * @param string $nom
     *   Nom de la commune.
     * @param bool $aoc
     *   Validité de la commune pour l'appellation d'origine contrôlée.
     * @return Commune
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $nom, $aoc) {
        $instance = new self();
        $instance->fillValues($id, $nom, $aoc);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une commune.
     * @return Commune
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
     *   Identifiant unique de la commune dans la base de données.
     * @param string $nom
     *   Nom de la commune.
     * @param bool $aoc
     *   Validité de la commune pour l'appellation d'origine contrôlée.
     */
    protected function fillValues($id, $nom, $aoc) {
        $this->_idCommune = $id;
        $this->_nomCommune = $nom;
        $this->_communeAoc = $aoc;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une commune.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idCommune = $row->idCommune;
        $this->_nomCommune = $row->nomCommune;
        $this->_communeAoc = $row->communeAoc;
    }
    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idCommune;
                break;
            case 'nom':
                return $this->_nomCommune;
                break;
            case 'aoc':
            case 'communeAoc':
                return $this->_communeAoc;
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
        return $this->_nomCommune;
    }

    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idCommune, 'nom' => $this->_nomCommune, 'aoc' => $this->_communeAoc);
    }
}
?>