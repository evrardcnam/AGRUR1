<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Lot{ 

  //données privées de la classe
  private $_codeLot;
  private $_calibreLot;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_codeLot = $result->codeLot;
    $this->_calibreLot = $result->calibreLot;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'code':
        return $this->_codeLot;
        break;
      case 'calibre':
        return $this->_calibreLot;
        break; 
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_codeLot;
  }
}
?>