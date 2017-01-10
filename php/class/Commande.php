<?php
// Définit une commande
class Commande implements JsonSerializable
{
    //données privées de la classe
    private $_numCommande;
    private $_dateEnvoie;
    private $_idClient;
    private $_codeLot;
    private $_idConditionnement;

    public function __construct() {
    }
    
    // Constructeur de la classe depuis l'extérieur
    public static function fromValues($num, $date, $idClient, $codeLot, $idCond) {
        $instance = new self();
        $instance->fillValues($num, $date, $idClient, $codeLot, $idCond);
        return $instance;
    }

    // Constructeur de la classe depuis la couche d'accès aux données
    public static function fromResult(DBQueryResult $result) {
        $instance = new self();
        $instance->fillRow($result);
        return $instance;
    }

    protected function fillValues($num, $date, $idClient, $codeLot, $idCond) {
        $this->_numCommande = $num;
        $this->_dateEnvoie = $date;
        $this->_idClient = $idClient;
        $this->_codeLot = $codeLot;
        $this->_idConditionnement = $idCond;
    }

    protected function fillRow(DBQueryResult $row) {
        $this->_numCommande = $row->numCommande;
        $this->_dateEnvoie = $row->dateEnvoie;
        $this->_idClient = $row->idClient;
        $this->_codeLot = $row->codeLot;
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
            case 'date':
            case 'dateEnvoie':
                return $this->_dateEnvoie;
                break;
            case 'idClient':
                return $this->_idClient;
                break;
            case 'client':
                return DBLayer::getClient($this->_idClient);
                break;
            case 'codeLot':
                return $this->_codeLot;
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
        return array('num' => $this->_numCommande, 'date' => $this->_dateEnvoie, 'idClient' => $this->_idClient, 'codeLot' => $this->_codeLot,'idCond' => $this->_idConditionnement);
    }
}