<?php
/**
 * @class CertObtenue
 * @brief Décrit une validation de certification par un producteur.
 */
class CertObtenue extends Certification implements JsonSerializable {
    //données privées de la classe
    private $_dateObtention;
    private $_idProducteur;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $idCertification
     *   Identifiant unique de la certification validée dans la base de données.
     * @param string $libelleCertification
     *   Libellé de la certification validée.
     * @param int $idProducteur
     *   Identifiant unique du producteur ayant validé la certification.
     * @param string $dateObtention
     *   Date de validation de la certification.
     * @return CertObtenue
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($idCertification, $libelleCertification, $idProducteur, $dateObtention) {
        $instance = new self();
        $instance->fillValues($idCertification, $libelleCertification, $idProducteur, $dateObtention);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une validation de certification.
     * @return CertObtenue
     *   Nouvelle instance initialisée avec le résultat de requête.
     */
    public static function fromResult(DBQueryResult $row){
        $instance = new self();
        $instance->fillRow($row);
        return $instance;
    }

    /**
     * @brief Constructeur de la classe depuis des valeurs données
     * @param int $idCertification
     *   Identifiant unique de la certification validée dans la base de données.
     * @param string $libelleCertification
     *   Libellé de la certification validée.
     * @param int $idProducteur
     *   Identifiant unique du producteur ayant validé la certification.
     * @param string $dateObtention
     *   Date de validation de la certification.
     */
    protected function fillValues($idCertification, $libelleCertification, $idProducteur, $dateObtention) {
        parent::fillValues($idCertification, $libelleCertification);
        $this->_dateObtention = $dateObtention;
        $this->_idProducteur = $idProducteur;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une validation de certification.
     */
    protected function fillRow(DBQueryResult $row) {
        parent::fillRow($row);
        $this->_dateObtention = $row->dateObtention;
        $this->_idProducteur = $row->idProducteur;
    }

    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
    public function __get($var){
        switch ($var){
            case 'date':
            case 'dateObtention':
                return $this->_dateObtention;
                break;
            case 'idProducteur':
                return $this->_idProducteur;
                break;
            case 'producteur':
                return DBLayer::getProducteur($this->_idProducteur);
                break;
            default:
                return parent::__get($var);
                break;
        }
    }
    
    /**
     * @brief Conversion en chaîne de caractères
     * @return string Instance sous forme de chaîne de caractères.
     */
    public function __toString(){
        return $super->__toString();
    }

    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        $a = parent::jsonSerialize();
        $a['date'] = $this->_dateObtention;
        $a['idProducteur'] = $this->_idProducteur;
        return $a;
    }
}
?>