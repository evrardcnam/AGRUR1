<?php
/**
 * @class Lot
 * @brief Décrit un lot.
 */
class Lot implements JsonSerializable {
    //données privées de la classe
    private $_idLot;
    private $_codeLot;
    private $_calibreLot;
    private $_quantite;
    private $_idLivraison;
    private $_numCommande;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $id
     *   Identifiant unique du lot dans la base de données.
     * @param string $code
     *   Code du lot.
     * @param string $calibre
     *   Calibre du lot.
     * @param int $quantite
     *   Quantité d'unités du lot.
     * @param int $idLivraison
     *   Identifiant unique de la livraison contenant ce lot.
     * @param int $numCommande
     *   Numéro unique de la commande associée à ce lot.
     * @return Lot
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande) {
        $instance = new self();
        $instance->fillValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un lot.
     * @return Lot
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
     *   Identifiant unique du lot dans la base de données.
     * @param string $code
     *   Code du lot.
     * @param string $calibre
     *   Calibre du lot.
     * @param int $quantite
     *   Quantité d'unités du lot.
     * @param int $idLivraison
     *   Identifiant unique de la livraison contenant ce lot.
     * @param int $numCommande
     *   Numéro unique de la commande associée à ce lot.
     */
    protected function fillValues($id, $code, $calibre, $quantite, $idLivraison, $numCommande) {
        $this->_idLot = $id;
        $this->_codeLot = $code;
        $this->_calibreLot = $calibre;
        $this->_quantite = $quantite; 
        $this->_idLivraison = $idLivraison;
        $this->_numCommande = $numCommande;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec un lot.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idLot = $row->idLot;
        $this->_codeLot = $row->codeLot;
        $this->_calibreLot = $row->calibreLot;
        $this->_quantite = $row->quantite;
        $this->_idLivraison = $row->idLivraison;
        $this->_numCommande = $row->numCommande;
    }

    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'id':
                return $this->_idLot;
            case 'code':
                return $this->_codeLot;
                break;
            case 'calibre':
                return $this->_calibreLot;
                break;
            case 'quantite':
                return $this->_quantite;
                break;
            case 'idLivraison':
                return $this->_idLivraison;
                break;
            case 'livraison':
                return DBLayer::getLivraison($this->_idLivraison);
                break;
            case 'numCommande':
                return $this->_numCommande;
                break;
            case 'commande':
                return DBLayer::getCommande($this->_numCommande);
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
        return $this->_codeLot;
    }
    
    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idLot, 'code' => $this->_codeLot, 'calibre' => $this->_calibreLot, 'quantite' => $this->_quantite, 'idLivraison' => $this->_idLivraison, 'numCommande' => $this->_numCommande);
    }
}
?>