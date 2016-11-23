<?php

// Définit un verger
class Verger { 

  //données privées de la classe
  private $_idVerger;
  private $_nomVerger;
  private $_superficie;
  private $_arbreParHectare;
   
  // Constructeur de la classe depuis la couche d'accès aux données
  public function __construct(DBQueryResult $result){
    $this->_idVerger = $result->idVerger;
    $this->_nomVerger = $result->nomVerger;
    $this->_superficie = $result->superficie;
    $this->_arbreParHectare = $result->arbreParHectare;
  }
  
  // Accesseur
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
  
  // Conversion en chaînes de caractères
  public function __toString(){
    return $this->_nomVerger;
  }
}
?>