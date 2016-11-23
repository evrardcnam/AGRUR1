<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Conditionnement{ 

  //données privées de la classe
  private $_idConditionnement;
  private $_libelleConditionnement;
  private $_poids;

  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_idConditionnement = $result->idConditionnement;
    $this->_libelleConditionnement = $result->libelleConditionnement;
    $this->_poids = $result->poids;
  }
  
  //méthode permettant de retourner les valeurs
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
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_libelleConditionnement;
  }
}
?>