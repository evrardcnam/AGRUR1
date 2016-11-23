<?php

// Définit un conditionnement
class Conditionnement { 

  //données privées de la classe
  private $_idConditionnement;
  private $_libelleConditionnement;
  private $_poids;

  // Constructeur de la classe depuis la couche d'accès aux données
  public function __construct(DBQueryResult $result){
    $this->_idConditionnement = $result->idConditionnement;
    $this->_libelleConditionnement = $result->libelleConditionnement;
    $this->_poids = $result->poids;
  }
  
  // Accesseur
  public function __get($var){
    switch ($var){
      case 'id':
        return $this->_idConditionnement;
        break;
      case 'libelle':
        return $this->_libelleConditionnement;
        break;
      case 'poids':
        return $this->_poids;
        break; 
      default:
        return null;
        break;
    }
  }
  
  // Conversion en chaînes de caractères
  public function __toString(){
    return $this->_libelleConditionnement;
  }
}
?>