<?php

// Définit une variété
class Variete { 

  //données privées de la classe
  private $_libelle;
  private $_varieteAoc;
   
  // Constructeur de la classe depuis la couche d'accès aux données
  public function __construct(DBQueryResult $result){
    $this->_libelle = $result->libelle;
    $this->_varieteAoc = $result->varieteAoc;
  }
  
  // Accesseur
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
  
  // Conversion en chaînes de caractères
  public function __toString(){
    return $this->_libelle;
  }
}
?>