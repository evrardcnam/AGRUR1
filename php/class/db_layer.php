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
	public static function getProducteurs() {
		$results = $this->query("SELECT * FROM producteur ORDER BY nomProducteur ASC");
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
	public static function getProducteur(string $nom) {
		$results = $this->query("SELECT * FROM producteur WHERE nomProducteur LIKE " . $nom . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Producteur($results[0]); }
	}

	// Obtenir tous les clients
	public static function getClients() {
		$results = $this->query("SELECT * FROM client ORDER BY idClient ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Client($result);
			}
			return $object_results;
		}
	}

	// Obtenir un client par son nom
	public static function getClient(string $nom) {
		$results = $this->query("SELECT * FROM client WHERE nomClient LIKE " . $nom . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Client($results[0]); }
	}

	// Obtenir toutes les certifications
	public static function getCertifications() {
		$results = $this->query("SELECT * FROM certification ORDER BY libelleCertification ASC");
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
	public static function getCommandes() {
		$results = $this->query("SELECT * FROM commande ORDER BY numCommande ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Commande($result);
			}
			return $object_results;
		}
	}

	// Obtenir tous les conditionnements
	public static function getConditionnements() {
		$results = $this->query("SELECT * FROM conditionnement ORDER BY libelleConditionnement ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Conditionnement($result);
			}
			return $object_results;
		}
	}

	// Obtenir tous les lots
	public static function getLots() {
		$results = $this->query("SELECT * FROM lot ORDER BY codeLot ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Lot($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les livraisons
	public static function getLivraisons() {
		$results = $this->query("SELECT * FROM livraison ORDER BY idVerger ASC, dateLivraison DESC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Livraison($result);
			}
			return $object_results;
		}
	}

	// Obtenir tous les vergers
	public static function getVergers() {
		$results = $this->query("SELECT * FROM verger ORDER BY nomProducteur ASC, nomVerger ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Verger($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les variétés
	public static function getVarietes() {
		$results = $this->query("SELECT * FROM variete ORDER BY libelle ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Variete($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les communes
	public static function getCommunes() {
		$results = $this->query("SELECT * FROM commune ORDER BY nomCommune ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Commune($result);
			}
			return $object_results;
		}
	}

	// Obtenir toutes les certifications validées pour un producteur
	public static function getCertificationsValidees(Producteur $p) {
		$results = $this->query("SELECT C.idCertification, C.libelleCertification, O.dateObtention FROM certification C, obtient O WHERE O.idCertification = C.idCertification AND O.nomProducteur LIKE " . $p->nom . " ORDER BY libelleCertification ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new CertObtenue($result);
			}
			return $object_results;
		}
	}

	// Obtenir le lot d'une commande
	public static function getLotCommande(Commande $c) {
		$results = $this->query("SELECT * FROM lot WHERE numCommande = " . $c->num . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Lot($results[0]); }
	}

	// Obtenir le conditionnement d'une commande
	public static function getConditionnementCommande(Commande $c) {
		$results = $this->query("SELECT D.idConditionnement, D.libelleConditionnement, D.poids FROM conditionnement D, commande C WHERE C.idConditionnement = D.idConditionnement AND numCommande = " . $c->num . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Conditionnement($results[0]); }
	}

	// Obtenir le conditionnement d'une commande
	public static function getClientCommande(Commande $c) {
		return getClient($c->nomClient);
	}

	// Obtenir tous les lots d'une livraison
	public static function getLotsLivraison(Livraison $l) {
		$results = $this->query("SELECT * FROM lot WHERE idLivraison = " . $l->id . " ORDER BY codeLot ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Lot($result);
			}
			return $object_results;
		}
	}

	// Obtenir le verger d'origine d'une livraison
	public static function getVergerLivraison(Livraison $l) {
		$results = $this->query("SELECT * FROM verger WHERE idVerger = " . $l->idVerger . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Verger($results[0]); }
	}

	// Obtenir le producteur auquel appartient un verger
	public static function getProducteurVerger(Verger $v) {
		return getProducteur($v->nomProducteur);
	}

	// Obtenir la variété cultivée dans un verger
	public static function getVarieteVerger(Verger $v) {
		$results = $this->query("SELECT * FROM variete WHERE libelle = " . $v->libelleVariete . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Variete($results[0]); }
	}

	// Obtenir la commune où se trouve un verger
	public static function getCommuneVerger(Verger $v) {
		$results = $this->query("SELECT * FROM commune WHERE idCommune = " . $v->idCommune . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Commune($results[0]); }
	}

	// Connexion à la base de données. Action réalisée par les autres fonctions internes.
	private static function dbconnect() {
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if ($conn->connect_error) {
			die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}
		return $conn;
	}
	
	// Exécuter une requête sur la base de données.
	private static function query(string $sql) {
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