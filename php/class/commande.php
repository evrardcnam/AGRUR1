<?php

<<<<<<< HEAD
// Définit une commande
class Commande { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Commande{ 
>>>>>>> master

  //données privées de la classe
  private $_numCommande;
  private $_dateEnvoie;
   
<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_numCommande = $result->numCommande;
    $this->_dateEnvoie = $result->dateEnvoie;
  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
  public function __get($var){
    switch ($var){
      case '_num':
        return $this->_numCommande;
        break;
      case '_dateEnvoie':
        return $this->_dateEnvoie;
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
    return $this->_numCommande;
  }
}
?>