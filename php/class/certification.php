<?php

// Exemple de classe pouvant extraire un résultat de requête 
class Certification{ 

  //données privées de la classe
  private $_idCertification;
  private $_libelleCertification;
   
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
  public function __construct(DBQueryResult $result){
    $this->_idCertification = $result->idCertification;
    $this->_libelleCertification = $result->libelleCertification;
  }
  
  //méthode permettant de retourner les valeurs
  public function __get($var){
    switch ($var){
      case 'id':
        return $this->_idCertification;
        break;
      case 'libelle':
        return $this->_libelleCertification;
        break; 
      default:
        return null;
        break;
    }
  }
  
  //méthode permettant de convertir la classe en une chaine de caractère
  public function __toString(){
    return $this->_libelleCertification;
  }
}
?>