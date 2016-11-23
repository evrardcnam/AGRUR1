<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Client{ 

  //données privées de la classe
  private $_nomClient;
  private $_adresseClient;
  private $_nomResAchats;

  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_nomClient = $result->nomClient;
    $this->_adresseClient = $result->adresseClient;
    $this->_nomResAchats = $result->nomResAchats;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'nom':
        return $this->_nomClient;
        break;
      case 'adresseClient':
        return $this->_adresseClient;
        break;
      case 'nomResAchats':
        return $this->_nomResAchats;
        break; 
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_nomClient;
  }
}
?>