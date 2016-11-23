<?php

// Définit une commune
class Commune { 

  //données privées de la classe
  private $_idCommune;
  private $_nomCommune;
  private $_communeAoc;

  // Constructeur de la classe depuis la couche d'accès aux données
  public function __construct(DBQueryResult $result){
    $this->_idCommune = $result->idCommune;
    $this->_nomCommune = $result->nomCommune;
    $this->_communeAoc = $result->communeAoc;
  }
  
  // Accesseur
  public function __get($var){
    switch ($var){
      case 'id':
        return $this->_idCommune;
        break;
      case 'nom':
        return $this->_nomCommune;
        break;
      case 'communeAoc':
        return $this->_communeAoc;
        break; 
      default:
        return null;
        break;
    }
  }
  
  // Conversion en chaînes de caractères
  public function __toString(){
    return $this->_nomCommune;
  }
}
?>