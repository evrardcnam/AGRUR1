<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Commune{ 

  //données privées de la classe
  private $_idCommune;
  private $_nomCommune;
  private $_communeAoc;

  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_idCommune = $result->idCommune;
    $this->_nomCommune = $result->nomCommune;
    $this->_communeAoc = $result->communeAoc;
  }
  
  //méthode permettant de retourner les valeurs
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
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_nomCommune;
  }
}
?>