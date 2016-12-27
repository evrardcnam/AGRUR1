<?php
/**
 * Résultat de requête SELECT exécutée par DBLayer.
 */
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

/**
 * Couche d'accès aux données
 */
class DBLayer {
	public function __construct() {}

	/**
	 * Fonction de connexion à la base de données.
	 * N'est utilisée que par les fonctions internes et ne doit pas être exploitée directement par les fonctions publiques. 
	 */
	private static function dbconnect() {
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if (!$conn || $conn->connect_error) {
			die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}
		return $conn;
	}
	
	/**
	 * Exécuter une requête sur la base de données. 
	 * Ne doit en aucun cas être utilisé directement sur une page. 
	 */
	private static function query($sql) {
		$res = mysqli_query(DBLayer::dbconnect(), $sql);
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

	/**
	 * Obtenir tous les producteurs.
	 */
	public static function getProducteurs() {
		$results = DBLayer::query("SELECT * FROM producteur ORDER BY nomProducteur ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Producteur($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un producteur spécifique par son nom 
	 */
	public static function getProducteur($nom) {
		$results = DBLayer::query("SELECT * FROM producteur WHERE nomProducteur LIKE " . $nom . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Producteur($results[0]); }
	}

	/**
	 * Obtenir tous les clients 
	 */
	public static function getClients() {
		$results = DBLayer::query("SELECT * FROM client ORDER BY idClient ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Client($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un client par son nom 
	 */
	public static function getClient($nom) {
		$results = DBLayer::query("SELECT * FROM client WHERE nomClient LIKE " . $nom . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Client($results[0]); }
	}

	/**
	 * Obtenir toutes les certifications 
	 */
	public static function getCertifications() {
		$results = DBLayer::query("SELECT * FROM certification ORDER BY libelleCertification ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Certification($result);
			}
			return $object_results;
		}
	}
	
	/**
	 * Obtenir toutes les commandes 
	 */
	public static function getCommandes() {
		$results = DBLayer::query("SELECT * FROM commande ORDER BY numCommande ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Commande($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir tous les conditionnements 
	 */
	public static function getConditionnements() {
		$results = DBLayer::query("SELECT * FROM conditionnement ORDER BY libelleConditionnement ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Conditionnement($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir tous les lots 
	 */
	public static function getLots() {
		$results = DBLayer::query("SELECT * FROM lot ORDER BY codeLot ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Lot($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les livraisons 
	 */
	public static function getLivraisons() {
		$results = DBLayer::query("SELECT * FROM livraison ORDER BY idVerger ASC, dateLivraison DESC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Livraison($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir tous les vergers 
	 */
	public static function getVergers() {
		$results = DBLayer::query("SELECT * FROM verger ORDER BY nomProducteur ASC, nomVerger ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Verger($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les variétés 
	 */
	public static function getVarietes() {
		$results = DBLayer::query("SELECT * FROM variete ORDER BY libelle ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Variete($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les communes 
	 */
	public static function getCommunes() {
		$results = DBLayer::query("SELECT * FROM commune ORDER BY nomCommune ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Commune($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les certifications validées pour un producteur spécifique 
	 */
	public static function getCertificationsValidees(Producteur $p) {
		$results = DBLayer::query("SELECT C.idCertification, C.libelleCertification, O.dateObtention FROM certification C, obtient O WHERE O.idCertification = C.idCertification AND O.nomProducteur LIKE " . $p->nom . " ORDER BY libelleCertification ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new CertObtenue($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir les utilisateurs.
	 */
	public static function getUtilisateurs() {
		$results = DBLayer::query("SELECT id, name, admin, nomProducteur FROM users ORDER BY name ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Utilisateur($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un utilisateur par son pseudonyme.
	 */
	public static function getUtilisateur($pseudo) {
		$results = DBLayer::query("SELECT id, name, admin FROM users WHERE name LIKE " . $pseudo . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Utilisateur($results[0]); }
	}

	/**
	 * Obtenir le lot associé à une commande. 
	 */
	public static function getLotCommande(Commande $c) {
		$results = DBLayer::query("SELECT * FROM lot WHERE numCommande = " . $c->num . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Lot($results[0]); }
	}

	/**
	 * Obtenir le conditionnement associé à une commande. 
	 */
	public static function getConditionnementCommande(Commande $c) {
		$results = DBLayer::query("SELECT D.idConditionnement, D.libelleConditionnement, D.poids FROM conditionnement D, commande C WHERE C.idConditionnement = D.idConditionnement AND numCommande = " . $c->num . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Conditionnement($results[0]); }
	}

	/**
	 * Obtenir le client associé à une commande. 
	 */
	public static function getClientCommande(Commande $c) {
		return getClient($c->nomClient);
	}

	/**
	 * Obtenir tous les lots associés à une livraison. 
	 */
	public static function getLotsLivraison(Livraison $l) {
		$results = DBLayer::query("SELECT * FROM lot WHERE idLivraison = " . $l->id . " ORDER BY codeLot ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = new Lot($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir le verger auquel une livraison est associée. 
	 */
	public static function getVergerLivraison(Livraison $l) {
		$results = DBLayer::query("SELECT * FROM verger WHERE idVerger = " . $l->idVerger . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Verger($results[0]); }
	}

	/**
	 * Obtenir le producteur auquel est associé un verger 
	 */
	public static function getProducteurVerger(Verger $v) {
		return getProducteur($v->nomProducteur);
	}

	/**
	 * Obtenir la variété associée au verger
	 */
	public static function getVarieteVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM variete WHERE libelle = " . $v->libelleVariete . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Variete($results[0]); }
	}

	/**
	 * Obtenir la commune d'un verger.' 
	 */
	public static function getCommuneVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM commune WHERE idCommune = " . $v->idCommune . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Commune($results[0]); }
	}

	/**
	 * Obtenir l'utilisateur associé à un producteur.'
	 */
	public static function getUtilisateurProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT id,name,admin FROM users WHERE id = " . $p->idUtilisateur . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Utilisateur($results[0]); }
	}

	/**
	 * Obtenir le producteur associé à un utilisateur.'
	 */
	public static function getProducteurUtilisateur(Utilisateur $u) {
		$results = DBLayer::query("SELECT * FROM producteur WHERE idUser = " . $u->id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return new Producteur($results[0]); }
	}

	/**
	 * Vérifier le mot de passe d'un utilisateur par rapport à une saisie.
	 */
	public static function checkPassword(Utilisateur $u, $pass) {
		if($u == null) return false;
		$results = DBLayer::query("SELECT pass FROM users WHERE idUser = " . $u->id . " LIMIT 0,1");
		return password_verify($pass, $results[0]->pass);
	}
}
?>