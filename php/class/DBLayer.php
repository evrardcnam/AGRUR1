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
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
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
	 * Exécuter une requête préparée sur la base de données. Ne retournera pas de résultat.
	 * Utiliser query() pour des requêtes SELECT ou requiérant un résultat.
	 * Ne doit en aucun cas être utilisé directement sur une page.
	 */
	private static function preparedQuery($sql, $types, ...$values) {
		$db = DBLayer::dbconnect();
		$stmt = $db->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_param($types, ...$values);
		$ret = $stmt->execute();
		$stmt->close();
		if(strpos($sql, 'INSERT' === false)) return $ret;
		else return $db->insert_id;
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
				$object_results[] = Producteur::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un producteur spécifique par son identifiant unique 
	 */
	public static function getProducteur($id) {
		$results = DBLayer::query('SELECT * FROM producteur WHERE idProducteur=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Producteur::fromResult($results[0]); }
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
				$object_results[] = Client::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un client par son identifiant unique 
	 */
	public static function getClient($id) {
		$results = DBLayer::query('SELECT * FROM client WHERE idClient=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Client::fromResult($results[0]); }
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
				$object_results[] = Certification::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir une certification par son identifiant unique
	 */
	public static function getCertification($id) {
		$results = DBLayer::query('SELECT * FROM certification WHERE idCertification=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Certification::fromResult($results[0]); }
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
				$object_results[] = Commande::fromResult($result);
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
				$object_results[] = Conditionnement::fromResult($result);
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
				$object_results[] = Lot::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les livraisons 
	 */
	public static function getLivraisons() {
		$results = DBLayer::query("SELECT l.idLivraison, l.dateLivraison, l.typeProduit, l.idVerger, count(o.idLot) AS nbLots FROM livraison l LEFT OUTER JOIN lot o ON l.idLivraison = o.idLivraison GROUP BY l.idLivraison ORDER BY l.idVerger ASC, l.dateLivraison DESC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = Livraison::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir une livraison par son identifiant unique 
	 */
	public static function getLivraison($id) {
		$results = DBLayer::query("SELECT l.idLivraison, l.dateLivraison, l.typeProduit, l.idVerger, count(o.idLot) AS nbLots FROM livraison l LEFT OUTER JOIN lot o ON l.idLivraison = o.idLivraison GROUP BY l.idLivraison HAVING l.idLivraison = " . $id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Livraison::fromResult($results[0]); }
	}

	/**
	 * Obtenir tous les vergers 
	 */
	public static function getVergers() {
		$results = DBLayer::query("SELECT * FROM verger ORDER BY idProducteur ASC, nomVerger ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = Verger::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un verger par son identifiant unique
	 */
	public static function getVerger($id) {
		$results = DBLayer::query("SELECT * FROM verger WHERE idVerger = " . $id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Verger::fromResult($results[0]); }
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
				$object_results[] = Variete::fromResult($result);
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
				$object_results[] = Commune::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir toutes les certifications validées pour un producteur spécifique.
	 */
	public static function getCertificationsValidees(Producteur $p) {
		$results = DBLayer::query('SELECT C.idCertification, C.libelleCertification, O.dateObtention, O.idProducteur FROM certification C INNER JOIN obtient O ON O.idCertification = C.idCertification WHERE O.idProducteur=' . $p->id . ' ORDER BY libelleCertification ASC');
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = CertObtenue::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir les utilisateurs.
	 */
	public static function getUtilisateurs() {
		$results = DBLayer::query("SELECT id, name, admin, idProducteur FROM users ORDER BY name ASC");
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = Utilisateur::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir un utilisateur par son pseudonyme.
	 */
	public static function getUtilisateurPseudo($pseudo) {
		$results = DBLayer::query('SELECT id, name, admin, idProducteur FROM users WHERE name LIKE "' . $pseudo . '" LIMIT 0,1');
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * Obtenir un utilisateur par son pseudonyme.
	 */
	public static function getUtilisateurId($id) {
		$results = DBLayer::query('SELECT id, name, admin, idProducteur FROM users WHERE id=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * Obtenir le lot associé à une commande. 
	 */
	public static function getLotCommande(Commande $c) {
		$results = DBLayer::query("SELECT * FROM lot WHERE numCommande = " . $c->num . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Lot::fromResult($results[0]); }
	}

	/**
	 * Obtenir le conditionnement associé à une commande. 
	 */
	public static function getConditionnementCommande(Commande $c) {
		$results = DBLayer::query("SELECT idConditionnement, libelleConditionnement, poids FROM conditionnement WHERE idConditionnement = " . $c->idCond . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Conditionnement::fromResult($results[0]); }
	}

	/**
	 * Obtenir le client associé à une commande. 
	 */
	public static function getClientCommande(Commande $c) {
		return getClient($c->idClient);
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
				$object_results[] = Lot::fromResult($result);
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
		else { return Verger::fromResult($results[0]); }
	}

	/**
	 * Obtenir le producteur auquel est associé un verger 
	 */
	public static function getProducteurVerger(Verger $v) {
		return DBLayer::getProducteur($v->idProducteur);
	}

	/**
	 * Obtenir les vergers d'un producteur
	 */
	public static function getVergersProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT * FROM verger WHERE idProducteur=" . $p->id);
		if (!$results) { return $results; }
		else {
			$object_results = array();
			foreach ($results as $result){
				$object_results[] = Verger::fromResult($result);
			}
			return $object_results;
		}
	}

	/**
	 * Obtenir la variété associée au verger
	 */
	public static function getVarieteVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM variete WHERE idVariete = " . $v->idVariete . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Variete::fromResult($results[0]); }
	}

	/**
	 * Obtenir la commune d'un verger.' 
	 */
	public static function getCommuneVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM commune WHERE idCommune = " . $v->idCommune . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Commune::fromResult($results[0]); }
	}

	/**
	 * Obtenir l'utilisateur associé à un producteur.'
	 */
	public static function getUtilisateurProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT id,name,admin FROM users WHERE id = " . $p->idUtilisateur . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * Obtenir le producteur associé à un utilisateur.'
	 */
	public static function getProducteurUtilisateur(Utilisateur $u) {
		$results = DBLayer::query("SELECT * FROM producteur WHERE idUser = " . $u->id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Producteur::fromResult($results[0]); }
	}

	/**
	 * Vérifier le mot de passe d'un utilisateur par rapport à une saisie.
	 */
	public static function checkPassword(Utilisateur $u, $pass) {
		if($u == null) return false;
		$results = DBLayer::query("SELECT pass FROM users WHERE id = " . $u->id . " LIMIT 0,1");
		return password_verify($pass, $results[0]->pass);
	}

	/**
	 * Ajouter un producteur dans la base de données.
	 */
	public static function addProducteur(Producteur $p) {
		if(!isset($p)) return false;
		return DBLayer::preparedQuery("INSERT INTO producteur(nomProducteur,adresseProducteur,adherent,dateAdhesion) VALUES (?,?,?,?)",
			"ssis", $p->nom, $p->adresse, $p->adherent, $p->dateAdhesion);
	}
	
	/**
	 * Ajouter un client dans la base de données.
	 */
	public static function addClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO client(nomClient,adresseClient,nomResAchats) VALUES (?,?,?)",
			"sss", $c->nom, $c->adresse, $c->nomResAchats);
	}

	/**
	 * Ajouter une certification dans la base de données.
	 */
	public static function addCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO certification(libelleCertification) VALUES (?)", "s", $c->libelle);
	}

	/**
	 * Ajouter une commande dans la base de données.
	 */
	public static function addCommande(Commande $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO commande(dateConditionnement,dateEnvoie,idConditionnement,idLot,idClient) VALUES (?,?,?,?)",
			"ssisi", $c->dateCond, $c->dateEnvoi, $c->idCond, $c->idLot, $c->idClient);
	}

	/**
	 * Ajouter un conditionnement dans la base de données.
	 */
	public static function addConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO conditionnement(libelleConditionnement,poids) VALUES (?,?)",
			"isd", $c->libelle, $c->poids);
	}

	/**
	 * Ajouter un lot dans la base de données.
	 */
	public static function addLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("INSERT INTO lot(codeLot,calibreLot,quantite,idLivraison,numCommande) VALUES (?,?,?,?,?)",
			"ssiii", $l->code, $l->calibre, $l->quantite, $l->idLivraison, $l->numCommande);
	}

	/**
	 * Ajouter une livraison dans la base de données.
	 */
	public static function addLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("INSERT INTO livraison(idLivraison,dateLivraison,typeProduit,idVerger) VALUES (?,?,?,?)",
			"issi", $l->id, $l->date, $l->type, $l->idVerger);
	}

	/**
	 * Ajouter un verger dans la base de données.
	 */
	public static function addVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("INSERT INTO verger(idVerger,nomVerger,superficie,arbresParHectare,idVariete,idCommune,idProducteur) VALUES (?,?,?,?,?,?,?)",
			"isiiiii", $v->id, $v->nom, $v->superficie, $v->arbresParHectare, $v->idVariete, $v->idCommune, $v->idProducteur);
	}

	/**
	 * Ajouter une variété dans la base de données.
	 */
	public static function addVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("INSERT INTO variete(libelle,varieteAoc) VALUES (?,?)",
			"si", $v->libelle, $v->aoc);
	}

	/**
	 * Ajouter une commune dans la base de données.
	 */
	public static function addCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO commune(nomCommune,communeAoc) VALUES (?,?)",
			"si", $c->nom, $c->aoc);
	}

	/**
	 * Ajouter une validation de certification dans la base de données.
	 */
	public static function addCertObtenue(CertObtenue $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO obtient(idCertification,idProducteur,dateObtention) VALUES (?,?,?)",
			"iis", $c->id, $c->idProducteur, $c->date);
	}

	/**
	 * Ajouter un utilisateur dans la base de données.
	 */
	public static function addUtilisateur(Utilisateur $u, $pass) {
		if(!isset($u) || empty($pass)) return false;
		return DBLayer::preparedQuery("INSERT INTO users(name,pass,admin,idProducteur) VALUES (?,?,?,?)",
			"ssii", $u->nom, crypt($pass), $u->admin, $u->admin ? null : $u->idProducteur);
	}

	/**
	 * Mettre à jour un producteur dans la base de données.
	 */
	public static function setProducteur(Producteur $p) {
		if(!isset($nom, $p)) return false;
		return DBLayer::preparedQuery("UPDATE producteur SET `nomProducteur`=?,`adresseProducteur`=?,`adherent`=?,`dateAdhesion`=? WHERE `idProducteur`=?",
			"ssisi", $p->nom, $p->adresse, $p->adherent, $p->dateAdhesion, $p->id);
	}
	
	/**
	 * Mettre à jour un client dans la base de données.
	 */
	public static function setClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE client SET `nomClient`=?,`adresseClient`=?,`nomResAchats`=? WHERE `idClient`=?",
			"sssi", $c->nom, $c->adresse,$c->nomResAchats, $c->id);
	}

	/**
	 * Mettre à jour une certification dans la base de données.
	 */
	public static function setCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE certification SET `libelleCertification`=? WHERE `idCertification`=?",
			"si", $c->libelle, $c->id);
	}

	/**
	 * Mettre à jour une commande dans la base de données.
	 */
	public static function setCommande(Commande $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE commande SET `dateConditionnement`=?, `dateEnvoie`=?, `idConditionnement`=?, `idLot`=?, `idClient`=? WHERE `numCommande`=?",
			"ssiiii", $c->dateCond, $c->dateEnvoi, $c->idCond, $c->idLot, $c->idClient, $c->num);
	}

	/**
	 * Mettre à jour un conditionnement dans la base de données.
	 */
	public static function setConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE conditionnement SET `libelleConditionnement`=?, `poids`=? WHERE `idConditionnement`=?",
			"sdi", $c->libelle, $c->poids, $c->id);
	}

	/**
	 * Mettre à jour un lot dans la base de données.
	 */
	public static function setLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("UPDATE lot SET `codeLot`=?, `calibreLot`=?, `quantite`=?, `idLivraison`=? WHERE `idLot`=?",
			"ssiii", $l->code, $l->calibre, $l->quantite, $l->idLivraison, $l->id);
	}

	/**
	 * Mettre à jour une livraison dans la base de données.
	 */
	public static function setLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("UPDATE livraison SET `dateLivraison`=?, `typeProduit`=?, `idVerger`=? WHERE `idLivraison`=?",
			"ssii", $l->date, $l->type, $l->idVerger, $l->id);
	}

	/**
	 * Mettre à jour un verger dans la base de données.
	 */
	public static function setVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("UPDATE verger SET `nomVerger`=?, `superficie`=?, `arbresParHectare`=?, `idVariete`=?, `idCommune`=?, `idProducteur`=? WHERE `idVerger`=?",
			"siiiiii", $v->nom, $v->superficie, $v->arbresParHectare, $v->idVariete, $v->idCommune, $v->idProducteur, $v->id);
	}

	/**
	 * Mettre à jour une variété dans la base de données.
	 */
	public static function setVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("UPDATE variete SET `libelle`=?, `varieteAoc`=? WHERE `idVariete`=?",
			"sii", $v->libelle, $v->aoc, $v->id);
	}

	/**
	 * Mettre à jour une commune dans la base de données.
	 */
	public static function setCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE commune SET `nomCommune`=?, `communeAoc`=? WHERE `idCommune`=?",
			"sii", $c->nom, $c->aoc, $c->id);
	}

	/**
	 * Mettre à jour un utilisateur dans la base de données.
	 */
	public static function setUtilisateur(Utilisateur $u, $pass) {
		if(!isset($u, $pass)) return false;
		return DBLayer::preparedQuery("UPDATE users SET `name`=?, `pass`=?, `admin`=?, `idProducteur`=? WHERE `id`=?",
			"ssiii", $u->nom, empty($pass) ? null : crypt($pass), $u->admin, $u->admin ? null : $u->idProducteur, $u->id);
	}

	/**
	 * Ajouter un producteur dans la base de données.
	 */
	public static function removeProducteur(Producteur $p) {
		if(!isset($p)) return false;
		return DBLayer::preparedQuery("DELETE FROM producteur WHERE idProducteur=?", "i", $p->id);
	}
	
	/**
	 * Ajouter un client dans la base de données.
	 */
	public static function removeClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM client WHERE `idClient`=?", "i", $c->id);
	}

	/**
	 * Ajouter une certification dans la base de données.
	 */
	public static function removeCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM certification WHERE `idCertification`=?", "i", $c->id);
	}

	/**
	 * Ajouter une commande dans la base de données.
	 */
	public static function removeCommande(Commande $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM commande WHERE `numCommande`=?", "i", $c->num);
	}

	/**
	 * Ajouter un conditionnement dans la base de données.
	 */
	public static function removeConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM conditionnement WHERE `idConditionnement`=?", "i", $c->id);
	}

	/**
	 * Ajouter un lot dans la base de données.
	 */
	public static function removeLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("DELETE FROM lot WHERE `idLot`=?", "i", $l->id);
	}

	/**
	 * Ajouter une livraison dans la base de données.
	 */
	public static function removeLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("DELETE FROM livraison WHERE `idLivraison`=?", "i", $l->id);
	}

	/**
	 * Ajouter un verger dans la base de données.
	 */
	public static function removeVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("DELETE FROM verger WHERE `idVerger`=?", "i", $v->id);
	}

	/**
	 * Ajouter une variété dans la base de données.
	 */
	public static function removeVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("DELETE FROM variete WHERE `idVariete`=?", "i", $v->id);
	}

	/**
	 * Ajouter une commune dans la base de données.
	 */
	public static function removeCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM commune WHERE `idCommune`=?", "i", $c->id);
	}

	/**
	 * Ajouter une validation de certification dans la base de données.
	 */
	public static function removeCertObtenue(CertObtenue $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM obtient WHERE `idCertification`=? AND `idProducteur`=?",
			"ii", $c->id, $c->idProducteur);
	}

	/**
	 * Ajouter un utilisateur dans la base de données.
	 */
	public static function removeUtilisateur(Utilisateur $u) {
		if(!isset($u)) return false;
		return DBLayer::preparedQuery("DELETE FROM users WHERE `id`=?", "i", $u->id);
	}
}
?>