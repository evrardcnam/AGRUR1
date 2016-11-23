<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Producteur{ 

  //données privées de la classe
  private $_nomProducteur;
  private $_dateAdhesion;
  private $_adherent;
  private $_adresseProducteur;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_nomProducteur = $result->nomProducteur;
    $this->_dateAdhesion = $result->dateAdhesion;
    $this->_adherent = $result->adherent;
    $this->_adresseProducteur = $result->adresseProducteur;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'nom':
        return $this->_nomProducteur;
        break;
      case 'dateAdhesion':
        return $this->_dateAdhesion;
        break;
      case 'adherent':
        return $this->_adherent;
        break;
      case 'adresse':
        return $this->_adresseProducteur;
        break;  
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_nomProducteur;
  }
}
?>