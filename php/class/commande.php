<?php
// Définit une commande
class Commande
{
    //données privées de la classe
    private $_numCommande;
    private $_dateEnvoie;
    private $_nomClient;
    private $_codeLot;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result)
    {
        $this->_numCommande = $result->numCommande;
        $this->_dateEnvoie = $result->dateEnvoie;
        $this->_nomClient = $result->nomClient;
        $this->_codeLot = $result->codeLot;
    }
    // Accesseur
    public function __get($var)
    {
        switch ($var) {
            case 'num':
                return $this->_numCommande;
                break;
            case 'dateEnvoie':
                return $this->_dateEnvoie;
                break;
            case 'nomClient':
                return $this->_nomClient;
                break;
            case 'client':
                return getClient($_nomClient);
                break;
            case 'codeLot':
                return $this->_codeLot;
                break;
            case 'lot':
                return getLotCommande($_numCommande);
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
}