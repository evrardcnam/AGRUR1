<?php
// Définit un producteur
class Producteur {
//données privées de la classe
private $_nomProducteur;
private $_dateAdhesion;
private $_adherent;
private $_adresseProducteur;
// Constructeur de la classe depuis la couche d'accès aux données
public function __construct(DBQueryResult $result){
$this->_nomProducteur = $result->nomProducteur;
$this->_dateAdhesion = $result->dateAdhesion;
$this->_adherent = $result->adherent;
$this->_adresseProducteur = $result->adresseProducteur;
}
// Accesseur
public function __get($var){
switch ($var){
case 'nom':
return $this->_nomProducteur;
break;
case 'dateAdhesion':
return $this->_dateAdhesion;
break;
case 'adherent':
return $this->_adherent;
break;
case 'adresse':
return $this->_adresseProducteur;
break;
default:
return null;
break;
}
}
// Conversion en chaînes de caractères
public function __toString(){
return $this->_nomProducteur;
}
}
?>