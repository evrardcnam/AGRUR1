<?php

<<<<<<< HEAD
// Définit une certification
class Certification { 
=======
// Exemple de classe pouvant extraire un résultat de requête 
class Certification{ 
>>>>>>> master

  //données privées de la classe
  private $_idCertification;
  private $_libelleCertification;
   
<<<<<<< HEAD
  // Constructeur de la classe depuis la couche d'accès aux données
=======
  //constructeur de la classe servant à faire le lien entre la couche d'accées aux données et la classe.
>>>>>>> master
  public function __construct(DBQueryResult $result){
    $this->_idCertification = $result->idCertification;
    $this->_libelleCertification = $result->libelleCertification;
  }
  
<<<<<<< HEAD
  // Accesseur
=======
  //méthode permettant de retourner les valeurs
>>>>>>> master
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
  
<<<<<<< HEAD
  // Conversion en chaînes de caractères
=======
  //méthode permettant de convertir la classe en une chaine de caractère
>>>>>>> master
  public function __toString(){
    return $this->_libelleCertification;
  }
}
?>