<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Commande{ 

  //données privées de la classe
  private $_numCommande;
  private $_dateEnvoie;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_numCommande = $result->numCommande;
    $this->_dateEnvoie = $result->dateEnvoie;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
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
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_numCommande;
  }
}
?>