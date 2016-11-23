<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Livraison{ 

  //données privées de la classe
  private $_idLivraison;
  private $_dateLivraison;
  private $_typeProduit;
  private $_quantiteLivree;

  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_idLivraison = $result->idLivraison;
    $this->_dateLivraison = $result->dateLivraison;
    $this->_typeProduit = $result->typeProduit;
    $this->_quantiteLivree = $result->quantiteLivree;

  }
  
  //méthode permettant de retourner les valeurs
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
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_idLivraison;
  }
}
?>