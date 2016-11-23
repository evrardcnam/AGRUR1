<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Verger{ 

  //données privées de la classe
  private $_idVerger;
  private $_nomVerger;
  private $_superficie;
  private $_arbreParHectare;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_idVerger = $result->idVerger;
    $this->_nomVerger = $result->nomVerger;
    $this->_superficie = $result->superficie;
    $this->_arbreParHectare = $result->arbreParHectare;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'id':
        return $this->_idVerger;
        break;
      case 'nom':
        return $this->_nomVerger;
        break;
      case 'superficie':
        return $this->_superficie;
        break;
      case 'arbreParHectare':
        return $this->_arbreParHectare;
        break;  
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_nomVerger;
  }
}
?>