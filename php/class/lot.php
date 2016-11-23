<?php

<<<<<<< HEAD
// Définit un lot
class Lot { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Lot{ 
>>>>>>> master

  //données privées de la classe
  private $_codeLot;
  private $_calibreLot;
   
<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_codeLot = $result->codeLot;
    $this->_calibreLot = $result->calibreLot;
  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
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
  
<<<<<<< HEAD
  // Conversion en chaînes de caractères
=======
  //méthode permettant de convertir la classe en une chaine de caractère
>>>>>>> master
  public function __toString(){
    return $this->_codeLot;
  }
}
?>