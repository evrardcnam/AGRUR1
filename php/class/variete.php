<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Variete{ 

  //données privées de la classe
  private $_libelle;
  private $_varieteAoc;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_libelle = $result->libelle;
    $this->_varieteAoc = $result->varieteAoc;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'ilibelle':
        return $this->_libelle;
        break;
      case 'varieteAoc':
        return $this->_varieteAoc;
        break; 
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_libelle;
  }
}
?>