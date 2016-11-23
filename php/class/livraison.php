<?php

<<<<<<< HEAD
// Définit une livraison
class Livraison { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Livraison{ 
>>>>>>> master

  //données privées de la classe
  private $_idLivraison;
  private $_dateLivraison;
  private $_typeProduit;
  private $_quantiteLivree;

<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_idLivraison = $result->idLivraison;
    $this->_dateLivraison = $result->dateLivraison;
    $this->_typeProduit = $result->typeProduit;
    $this->_quantiteLivree = $result->quantiteLivree;

  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
  public function __get($var){
    switch ($var){
      case 'id':
        return $this->_idLivraison;
        break;
      case 'dateLivraison':
        return $this->_dateLivraison;
        break;
      case 'type':
        return $this->_typeProduit;
        break;
      case 'quantiteLivree':
        return $this->_quantiteLivree;
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
    return $this->_idLivraison;
  }
}
?>