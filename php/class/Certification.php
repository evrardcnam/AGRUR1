<?php
/**
 * @file Certification.php
 * Classe de certification.
 */
/*! @class Certification
 * @brief Décrit une certification pouvant être validée par des producteurs.
 */
class Certification implements JsonSerializable {
    private $_idCertification;
    private $_libelleCertification;

    public function __construct() {
    }
    
    /**
     * @brief Instancier la classe depuis des valeurs données
     * @param int $idCertification
     *   Identifiant unique de la certification dans la base de données.
     * @param string $libelleCertification
     *   Libellé de la certification.
     * @return Certification
     *   Nouvelle instance initialisée avec les valeurs indiquées.
     */
    public static function fromValues($idCertification, $libelleCertification) {
        $instance = new self();
        $instance->fillValues($idCertification, $libelleCertification);
        return $instance;
    }

    /**
     * @brief Instancier la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une certification.
     * @return Certification
     *   Nouvelle instance initialisée avec le résultat de requête.
     */
    public static function fromResult(DBQueryResult $row) {
        $instance = new self();
        $instance->fillRow($row);
        return $instance;
    }
    
    /**
     * @brief Constructeur de la classe depuis des valeurs données
     * @param int $idCertification
     *   Identifiant unique de la certification dans la base de données.
     * @param string $libelleCertification
     *   Libellé de la certification.
     */
    protected function fillValues($idCertification, $libelleCertification) {
        $this->_idCertification = $idCertification;
        $this->_libelleCertification = $libelleCertification;
    }

    /**
     * @brief Constructeur de la classe depuis un résultat de requête SELECT
     * @param DBQueryResult $row
     *   Résultat de requête SELECT compatible avec une certification.
     */
    protected function fillRow(DBQueryResult $row) {
        $this->_idCertification = $row->idCertification;
        $this->_libelleCertification = $row->libelleCertification;
    }
    
    /**
     * @brief Obtenir une variable de la classe.
     * @param string $var Variable à obtenir.
     * @return mixed Valeur de la variable choisie.
     */
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
    /**
     * @brief Conversion en chaîne de caractères
     * @return string Instance sous forme de chaîne de caractères.
     */
    public function __toString(){
        return $this->_libelleCertification;
    }

    /**
     * @brief Sérialisation de la classe au format JSON.
     * @return string Instance sérialisée au format JSON.
     */
    public function jsonSerialize() {
        return array('id' => $this->_idCertification, 'libelle' => $this->_libelleCertification);
    }
}
?>