<?php
// Résultat de requête SELECT.
class DBQueryResult {
private $_results = array();
public function __construct() {}
public function __set($var,$val) {
$this->_results[$var] = $val;
}
public function __get($var){
if (isset($this->_results[$var])) {
return $this->_results[$var];
} else { return null; }
}
}
// Décrit une couche d'accès aux données.
class DBLayer {
	public function __construct() {}

	// Obtenir tous les producteurs
	public function getProducteurs() {
		$results = $this->query("SELECT * FROM Producteur ORDER BY nomProducteur ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Producteur($result);
			}
			return $object_results;
		}
	}

	// Obtient un producteur spécifique.
	public function getProducteur(string $nom) {
		$results = $this->query("SELECT * FROM Producteur WHERE nomProducteur LIKE " . $nom);
		if (!$results) { return null; }
		else {
			$object_results = array();
			return new Producteur($results[0]);
		}
	}

	// Obtenir tous les clients
	public function getClients() {
		$results = $this->query("SELECT * FROM Client ORDER BY idClient ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Client($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les certifications
	public function getCertifications() {
		$results = $this->query("SELECT * FROM Certification ORDER BY libelleCertification ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Certification($result);
			}
			return $object_results;
		}
	}
	
	// Obtenir toutes les commandes
	public function getCommandes() {
		$results = $this->query("SELECT * FROM Commande ORDER BY numCommande ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Certification($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les certifications validées pour un producteur
	public function getCertificationsValidees(Producteur $p) {
		$results = $this->query("SELECT * FROM Certification C, Obtient O WHERE O.idCertification = C.idCertification AND O.nomProducteur LIKE " . $p->nom . " ORDER BY libelleCertification ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new CertObtenue($result);
			}
			return $object_results;
		}
	}

	// Connexion à la base de données. Action réalisée par les autres fonctions internes.
	private function dbconnect() {
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if ($conn->connect_error) {
			die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}
		return $conn;
	}
	
	// Exécuter une requête sur la base de données.
	private function query(string $sql) {
		$this->dbconnect();
		$res = mysql_query($sql);
		if ($res) {
			if (strpos($sql,'SELECT') === false) { return true; }
		} else {
			if (strpos($sql,'SELECT') === false) { return false; }
			else { return null; }
		}
		$results = array();
		while ($row = mysqli_fetch_array($res)){
			$result = new DBQueryResult();
			foreach ($row as $k=>$v){
				$result->$k = $v;
			}
			$results[] = $result;
		}
		return $results;
	}
}
?>