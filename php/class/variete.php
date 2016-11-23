<?php

<<<<<<< HEAD
// Définit une variété
class Variete { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Variete{ 
>>>>>>> master

  //données privées de la classe
  private $_libelle;
  private $_varieteAoc;
   
<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_libelle = $result->libelle;
    $this->_varieteAoc = $result->varieteAoc;
  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
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
  
<<<<<<< HEAD
  // Conversion en chaînes de caractères
=======
  //méthode permettant de convertir la classe en une chaine de caractère
>>>>>>> master
  public function __toString(){
    return $this->_libelle;
  }
}
?>