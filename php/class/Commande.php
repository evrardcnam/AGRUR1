<?php
/**
 * @class Commande
 * @brief Définit une commande d'un lot par un client.
 */
class Commande implements JsonSerializable
{
    //données privées de la classe
    private $_numCommande;
    private $_dateConditionnement;
    private $_dateEnvoie;
    private $_idClient;
    private $_idLot;
    private $_idConditionnement;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $num
     *   Numéro de commande, utilisé comme identifiant unique dans la base de données.
     * @param string|null $dateCond
     *   Date de conditionnement de la commande. NULL si non conditionné.
     * @param string|null $dateEnvoi
     *   Date d'envoi de la commande. NULL si non expédié.
     * @param int $idClient
     *   Identifiant unique du client ayant passé la commande.
     * @param int $idLot
     *   Identifiant unique du lot concerné par la commande.
     * @param int $idCond
     *   Identifiant unique du mode de conditionnement de la commande.
     * @return Commande
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond) {
        $instance = new self();
        $instance->fillValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une commande.
     * @return Commande
     *   Nouvelle instance initialisée avec le résultat de requête.
     */
    public static function fromResult(DBQueryResult $row) {
        $instance = new self();
        $instance->fillRow($row);
        return $instance;
    }

    /**
     * @brief Constructeur de la classe depuis des valeurs données
     * @param int $num
     *   Numéro de commande, utilisé comme identifiant unique dans la base de données.
     * @param string|null $dateCond
     *   Date de conditionnement de la commande. NULL si non conditionné.
     * @param string|null $dateEnvoi
     *   Date d'envoi de la commande. NULL si non expédié.
     * @param int $idClient
     *   Identifiant unique du client ayant passé la commande.
     * @param int $idLot
     *   Identifiant unique du lot concerné par la commande.
     * @param int $idCond
     *   Identifiant unique du mode de conditionnement de la commande.
     */
    protected function fillValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond) {
        $this->_numCommande = $num;
        $this->_dateConditionnement = $dateCond;
        $this->_dateEnvoie = $dateEnvoi;
        $this->_idClient = $idClient;
        $this->_idLot = $idLot;
        $this->_idConditionnement = $idCond;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une commande.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_numCommande = $row->numCommande;
        $this->_dateConditionnement = $row->dateConditionnement;
        $this->_dateEnvoie = $row->dateEnvoie;
        $this->_idClient = $row->idClient;
        $this->_idLot = $row->idLot;
        $this->_idConditionnement = $row->idConditionnement;
    }
    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var)
    {
        switch ($var) {
            case 'num':
            case 'numCommande':
                return $this->_numCommande;
                break;
            case 'dateCond':
            case 'dateConditionnement':
                return $this->_dateConditionnement;
                break;
            case 'dateEnvoi':
            case 'dateEnvoie':
                return $this->_dateEnvoie;
                break;
            case 'idClient':
                return $this->_idClient;
                break;
            case 'client':
                return DBLayer::getClient($this->_idClient);
                break;
            case 'idLot':
                return $this->_idLot;
                break;
            case 'lot':
                return DBLayer::getLotCommande($this);
                break;
            case 'idCond':
            case 'idConditionnement':
                return $this->_idConditionnement;
                break;
            case 'cond':
            case 'conditionnement':
                return DBLayer::getConditionnementCommande($this);
            case 'packaged':
                return $this->_dateConditionnement != null && $this->_dateConditionnement != "" && $this->_dateConditionnement != "0000-00-00";
                break;
            case 'sent':
                return $this->_dateEnvoie != null && $this->_dateEnvoie != "" && $this->_dateEnvoie != "0000-00-00";
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
    public function __toString()
    {
        return $this->_numCommande;
    }

    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('num' => $this->_numCommande, 'dateConditionnement' => $this->_dateConditionnement, 'dateEnvoi' => $this->_dateEnvoie, 'idClient' => $this->_idClient, 'idLot' => $this->_idLot,'idCond' => $this->_idConditionnement);
    }
}