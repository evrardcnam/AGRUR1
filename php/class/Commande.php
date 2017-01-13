<?php
// Définit une commande
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
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond) {
        $instance = new self();
        $instance->fillValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($num, $dateCond, $dateEnvoi, $idClient, $idLot, $idCond) {
        $this->_numCommande = $num;
        $this->_dateConditionnement = $dateCond;
        $this->_dateEnvoie = $dateEnvoi;
        $this->_idClient = $idClient;
        $this->_idLot = $idLot;
        $this->_idConditionnement = $idCond;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_numCommande = $row->numCommande;
        $this->_dateConditionnement = $row->dateConditionnement;
        $this->_dateEnvoie = $row->dateEnvoie;
        $this->_idClient = $row->idClient;
        $this->_idLot = $row->idLot;
        $this->_idConditionnement = $row->idConditionnement;
    }
    
    // Accesseur
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
            case 'conditioned':
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
    // Conversion en chaînes de caractères
    public function __toString()
    {
        return $this->_numCommande;
    }

    public function jsonSerialize() {
        return array('num' => $this->_numCommande, 'dateConditionnement' => $this->_dateConditionnement, 'dateEnvoi' => $this->_dateEnvoie, 'idClient' => $this->_idClient, 'idLot' => $this->_idLot,'idCond' => $this->_idConditionnement);
    }
}