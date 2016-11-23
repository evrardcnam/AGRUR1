<?php

<<<<<<< HEAD
// Définit une commune
class Commune { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Commune{ 
>>>>>>> master

  //données privées de la classe
  private $_idCommune;
  private $_nomCommune;
  private $_communeAoc;

<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_idCommune = $result->idCommune;
    $this->_nomCommune = $result->nomCommune;
    $this->_communeAoc = $result->communeAoc;
  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
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
  
<<<<<<< HEAD
  // Conversion en chaînes de caractères
=======
  //méthode permettant de convertir la classe en une chaine de caractère
>>>>>>> master
  public function __toString(){
    return $this->_nomCommune;
  }
}
?>