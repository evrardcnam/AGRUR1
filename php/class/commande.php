<?php
// Définit une commande
class Commande
{
    //données privées de la classe
    private $_numCommande;
    private $_dateEnvoie;
    // Constructeur de la classe depuis la couche d'accès aux données
    public function __construct(DBQueryResult $result)
    {
        $this->_numCommande = $result->numCommande;
        $this->_dateEnvoie = $result->dateEnvoie;
    }
    // Accesseur
    public function __get($var)
    {
        switch ($var) {
            case '_num':
                return $this->_numCommande;
                break;
            case '_dateEnvoie':
                return $this->_dateEnvoie;
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