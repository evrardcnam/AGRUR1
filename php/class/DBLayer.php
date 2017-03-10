<?php
/**
 * @file DBLayer.php
 * @brief Couche d'accès aux données de l'application.
 * @author Lucidiot
 * Comprend l'ensemble des méthodes d'interaction avec la base de données. Pour des raisons de cohérence, de maintenabilité et de sécurité, l'accès aux données ne devrait être effectué qu'à travers ce fichier, et toute requête supplémentaire devrait faire l'objet d'une nouvelle méthode.
 */
/*! @class DBQueryResult
 * @brief Résultat de requête SELECT.
 * Résultat de requête MySQL "SELECT" renvoyé par DBLayer::query($sql)
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
 * Valider qu'une date suit un format donné.
 * @param string $date
 *   Chaîne de caractères contenant une date.
 * @param string $format
 *   Chaîne de caractères décrivant un format de date à suivre.
 * @return bool
 *   Capacité de PHP à comprendre la date fournie et à la traduire dans le format indiqué.
 */
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/*! @class DBLayer
 * @brief Couche d'accès aux données de l'application.
 * Contient des méthodes de lecture et d'écriture dans la base de données.
 */
class DBLayer {
	public function __construct() {}

	/**
	 * @brief Fonction de connexion à la base de données.
	 * @warning Pour des raisons de sécurité, cette méthode ne devrait jamais être utilisée par les méthodes de la classe directement. Les méthodes DBLayer::query() et DBLayer::preparedQuery() l'exécutent automatiquement.
	 * La fonction utilise les constantes DB_HOST, DB_USER, DB_PASSWORD et DB_DB pour connaître respectivement l'IP du serveur, le nom d'utilisateur, le mot de passe et la base de données où se connecter.
	 * Ces constantes devraient être définies dans le fichier de configuration config.php.
	 * En cas d'échec de connexion, la fonction interrompt l'exécution du script.
	 * @return mysqli
	 *   Connexion établie à la base de données.
	 */
	private static function dbconnect() {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if (!$conn || $conn->connect_error) {
			die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}
		return $conn;
	}
	
	/**
	 * @brief Exécuter une requête sur la base de données.
	 * Cette fonction permet l'exécution d'une requête simple dans la base de données.
	 * @warning La sécurisation de la requête n'est pas directement assurée. Pour des requêtes comprenant des données saisies directement par l'utilisateur, utilisez DBLayer::preparedQuery().
	 * @param string $sql
	 *   Requête SQL à exécuter.
	 * @return mixed
	 *   Si la requête est de type SELECT, renvoie un tableau, éventuellement vide, de DBQueryResult correspondants aux enregistrements retournés.
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
	 * @brief Exécuter une requête préparée sur la base de données.
	 * Permet l'exécution d'une requête préparée à une itération.
	 * Il est à noter que cette fonction n'utilise pas les requêtes préparées dans leur but initial : les requêtes préparées sont normalement destinées à réaliser en grand nombre les mêmes requêtes en en modifiant certains paramètres.
	 * Ici, les requêtes préparées sont utilisées dans un but détourné que leur ont trouvé certains développeurs, c'est-à-dire prévenir notamment les injections SQL.
	 * Cette fonction ne renvoie pas de résultat. Pour exécuter une requête SELECT, utilisez en conséquence DBLayer::query().
	 * @param string $sql
	 *   Requête SQL à exécuter. Des points d'interrogation (?) désignent les paramètres à passer à la requête.
	 * @param string $types
	 *   Types des données à insérer dans la requête.
	 *   Chaque paramètre est désigné dans l'ordre de son écriture dans la requête préparée par un caractère :
	 *   - **i** désigne un nombre entier.
	 *   - **d** désigne un nombre décimal.
	 *   - **s** désigne une chaîne de caractères.
	 *   - **b** désigne un type *BLOB* de MySQL.
	 *   Si un paramètre n'a pas de type dans cette liste, comme par exemple une date, utiliser **s**.
	 * @param string $values
	 *   Données à insérer dans la requête.
	 * @return mixed
	 *   Si la requête est un INSERT et que la table concernée n'a qu'un seul champ comme clé primaire, renvoie l'identifiant de la dernière ligne insérée. Sinon, renvoie true si l'opération a réussi. Dans tous les cas, renvoie false si la requête a échoué.
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
	 * @brief Obtenir tous les producteurs.
	 * @return array
	 *   Renvoie un tableau d'objets Producteur correspondant aux producteurs connus dans la base de données.
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
	 * @brief Obtenir un producteur par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique du producteur à rechercher.
	 * @return Producteur
	 *   Renvoie un objet Producteur correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getProducteur($id) {
		$results = DBLayer::query('SELECT * FROM producteur WHERE idProducteur=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Producteur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir tous les clients.
	 * @return array
	 *   Renvoie un tableau d'objets Client correspondant aux clients connus dans la base de données.
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
	 * @brief Obtenir un client par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique du client à rechercher.
	 * @return Client
	 *   Renvoie un objet Client correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getClient($id) {
		$results = DBLayer::query('SELECT * FROM client WHERE idClient=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Client::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir toutes les certifications.
	 * @return array
	 *   Renvoie un tableau d'objets Certification correspondant aux certifications connues dans la base de données.
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
	 * @brief Obtenir une certification par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique de la certification à rechercher.
	 * @return Certification
	 *   Renvoie un objet Certification correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getCertification($id) {
		$results = DBLayer::query('SELECT * FROM certification WHERE idCertification=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Certification::fromResult($results[0]); }
	}
	
	/**
	 * @brief Obtenir toutes les commandes.
	 * @return array
	 *   Renvoie un tableau d'objets Commande correspondant aux commandes connues dans la base de données.
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
	 * @brief Obtenir une commande par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique de la commande à rechercher.
	 * @return Commande
	 *   Renvoie un objet Commande correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getCommande($id) {
		$results = DBLayer::query("SELECT * FROM commande WHERE `numCommande`=" . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Commande::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir tous les conditionnements.
	 * @return array
	 *   Renvoie un tableau d'objets Conditionnement correspondant aux conditionnements connus dans la base de données.
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
	 * @brief Obtenir un conditionnement par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique du conditionnement à rechercher.
	 * @return Conditionnement
	 *   Renvoie un objet Conditionnement correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getConditionnement($id) {
		$results = DBLayer::query("SELECT * FROM conditionnement WHERE `idConditionnement`=" . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Conditionnement::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir tous les lots.
	 * @return array
	 *   Renvoie un tableau d'objets Lot correspondant aux lots connus dans la base de données.
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
	 * @brief Obtenir tous les lots n'ayant pas été commandés.
	 * @return array
	 *   Renvoie un tableau d'objets Lot correspondant aux lots connus dans la base de données et n'ayant pas de commande associée.
	 */
	public static function getLotsStock() {
		$results = DBLayer::query("SELECT * FROM lot WHERE numCommande IS NULL ORDER BY codeLot ASC");
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
	 * @brief Obtenir un lot par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique du lot à rechercher.
	 * @return Lot
	 *   Renvoie un objet Lot correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getLot($id) {
		$results = DBLayer::query("SELECT * FROM lot WHERE idLot = " . $id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Lot::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir toutes les livraisons.
	 * @return array
	 *   Renvoie un tableau d'objets Livraison correspondant aux livraisons connues dans la base de données.
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
	 * @brief Obtenir une livraison par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique de la livraison à rechercher.
	 * @return Livraison
	 *   Renvoie un objet Livraison correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getLivraison($id) {
		$results = DBLayer::query("SELECT l.idLivraison, l.dateLivraison, l.typeProduit, l.idVerger, count(o.idLot) AS nbLots FROM livraison l LEFT OUTER JOIN lot o ON l.idLivraison = o.idLivraison GROUP BY l.idLivraison HAVING l.idLivraison = " . $id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Livraison::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir tous les vergers.
	 * @return array
	 *   Renvoie un tableau d'objets Verger correspondant aux vergers connus dans la base de données.
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
	 * @brief Obtenir un verger par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique du verger à rechercher.
	 * @return Verger
	 *   Renvoie un objet Verger correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getVerger($id) {
		$results = DBLayer::query("SELECT * FROM verger WHERE idVerger = " . $id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Verger::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir toutes les variétés.
	 * @return array
	 *   Renvoie un tableau d'objets Variete correspondant aux variétés connues dans la base de données.
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
	 * @brief Obtenir toutes les communes.
	 * @return array
	 *   Renvoie un tableau d'objets Commune correspondant aux communes connues dans la base de données.
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
	 * @brief Obtenir toutes les certifications validées pour un producteur spécifique.
	 * @param Producteur $p
	 *   Producteur dont les certifications validées sont à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets CertObtenue correspondant aux certifications validées par le producteur dans la base de données.
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
	 * @brief Obtenir tous les utilisateurs.
	 * @return array
	 *   Renvoie un tableau d'objets Utilisateur correspondant aux utilisateurs connus dans la base de données.
	 */
	public static function getUtilisateurs() {
		$results = DBLayer::query("SELECT * FROM users ORDER BY name ASC");
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
	 * @brief Obtenir un utilisateur par son pseudonyme.
	 * @param string $pseudo
	 *   Pseudonyme de l'utilisateur à rechercher.
	 * @return Utilisateur
	 *   Objet Utilisateur correspondant à la recherche, ou null si le pseudonyme ne correspond à aucun utilisateur de la base de données.
	 */
	public static function getUtilisateurPseudo($pseudo) {
		$results = DBLayer::query('SELECT * FROM users WHERE name LIKE "' . $pseudo . '" LIMIT 0,1');
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un utilisateur par son identifiant unique.
	 * @param int $id
	 *   Identifiant unique de l'utilisateur à rechercher.
	 * @return Utilisateur
	 *   Renvoie un objet Utilisateur correspondant, ou null si l'identifiant unique ne correspond à aucune entrée dans la base de données.
	 */
	public static function getUtilisateurId($id) {
		$results = DBLayer::query('SELECT * FROM users WHERE id=' . $id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un lot associé à une commande.
	 * @param Commande $c
	 *   Commande associée au lot à rechercher.
	 * @return Lot
	 *   Renvoie un objet Lot correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getLotCommande(Commande $c) {
		$results = DBLayer::query("SELECT * FROM lot WHERE idLot = " . $c->idLot . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Lot::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un conditionnement associé à une commande.
	 * @param Commande $c
	 *   Commande associée au conditionnement à rechercher.
	 * @return Conditionnement
	 *   Renvoie un objet Conditionnement correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getConditionnementCommande(Commande $c) {
		$results = DBLayer::query("SELECT * FROM conditionnement WHERE idConditionnement = " . $c->idCond . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Conditionnement::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un client associé à une commande.
	 * @param Commande $c
	 *   Commande associée au client à rechercher.
	 * @return Client
	 *   Renvoie un objet Client correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getClientCommande(Commande $c) {
		return getClient($c->idClient);
	}
	
	/**
	 * @brief Obtenir une commande associée à un lot.
	 * @param Lot $l
	 *   Lot associé à la Commande à rechercher.
	 * @return Commande
	 *   Renvoie un objet Commande correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getCommandeLot(Lot $l) {
		$results = DBLayer::query("SELECT * FROM commande WHERE `idLot`=" . $l->id . ' LIMIT 0,1');
		if (!$results) { return null; }
		else { return Commande::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir tous les lots associés à une livraison.
	 * @param Livraison $l
	 *   Livraison associée aux lots à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Lot correspondant aux lots connus dans la base de données associés à la livraison.
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
	 * @brief Obtenir un verger associé à une livraison.
	 * @param Livraison $l
	 *   Livraison associée au verger à rechercher.
	 * @return Verger
	 *   Renvoie un objet Verger correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getVergerLivraison(Livraison $l) {
		$results = DBLayer::query("SELECT * FROM verger WHERE idVerger = " . $l->idVerger . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Verger::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un producteur associé à un verger.
	 * @param Verger $v
	 *   Verger associé au producteur à rechercher.
	 * @return Producteur
	 *   Renvoie un objet Producteur correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getProducteurVerger(Verger $v) {
		return DBLayer::getProducteur($v->idProducteur);
	}

	/**
	 * @brief Obtenir tous les vergers associés à un producteur.
	 * @param Producteur $p
	 *   Producteur associé aux vergers à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Verger correspondant aux vergers connus dans la base de données associés au producteur.
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
	 * @brief Obtenir une variété associée à un verger.
	 * @param Verger $v
	 *   Verger associé à la variété à rechercher.
	 * @return Variete
	 *   Renvoie un objet Variete correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getVarieteVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM variete WHERE idVariete = " . $v->idVariete . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Variete::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir une commune associée à un verger.
	 * @param Verger $v
	 *   Verger associé à la commune à rechercher.
	 * @return Commune
	 *   Renvoie un objet Commune correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getCommuneVerger(Verger $v) {
		$results = DBLayer::query("SELECT * FROM commune WHERE idCommune = " . $v->idCommune . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Commune::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un utilisateur associé à un producteur.
	 * @param Producteur $p
	 *   Producteur associé à l'utilisateur à rechercher.
	 * @return Utilisateur
	 *   Renvoie un objet Utilisateur correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getUtilisateurProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT * FROM users WHERE id = " . $p->idUtilisateur . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un producteur associé à un utilisateur.
	 * @param Utilisateur $u
	 *   Utilisateur associé à l'utilisateur à rechercher.
	 * @return Producteur
	 *   Renvoie un objet Producteur correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getProducteurUtilisateur(Utilisateur $u) {
		$results = DBLayer::query("SELECT * FROM producteur WHERE idUser = " . $u->id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Producteur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un utilisateur associé à un client.
	 * @param Client $c
	 *   Client associé à l'utilisateur à rechercher.
	 * @return Utilisateur
	 *   Renvoie un objet Utilisateur correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getUtilisateurClient(Client $c) {
		$results = DBLayer::query("SELECT * FROM users WHERE idClient = " . $c->idClient . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Utilisateur::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir un client associé à un utilisateur.
	 * @param Utilisateur $u
	 *   Utilisateur associé à l'utilisateur à rechercher.
	 * @return Client
	 *   Renvoie un objet Client correspondant, ou null si le critère de recherche ne correspond à aucune entrée dans la base de données.
	 */
	public static function getClientUtilisateur(Utilisateur $u) {
		$results = DBLayer::query("SELECT * FROM client WHERE idUser = " . $u->id . " LIMIT 0,1");
		if (!$results) { return null; }
		else { return Client::fromResult($results[0]); }
	}

	/**
	 * @brief Obtenir toutes les commandes associées à un client.
	 * @param Client $c
	 *   Client associé aux commandes à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Commande correspondant aux commandes connues dans la base de données et associées au client.
	 */
	public static function getCommandesClient(Client $c) {
		$results = DBLayer::query("SELECT * FROM commande WHERE idClient = " . $c->id);
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
	 * @brief Obtenir toutes les commandes associées aux vergers d'un producteur.
	 * @param Producteur $p
	 *   Producteur dont les vergers sont associés aux commandes à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Commande correspondant aux commandes connues dans la base de données et associées aux vergers du producteur.
	 */
	public static function getCommandesProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT * FROM commande LEFT JOIN lot ON commande.idLot = lot.idLot LEFT JOIN livraison ON lot.idLivraison = livraison.idLivraison LEFT JOIN verger ON livraison.idVerger = verger.idVerger WHERE verger.idProducteur = " . $p->id);
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
	 * @brief Obtenir toutes les livraisons associées aux vergers d'un producteur.
	 * @param Producteur $p
	 *   Producteur dont les vergers sont associés aux livraisons à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Livraison correspondant aux livraisons connues dans la base de données et associées aux vergers du producteur.
	 */
	public static function getLivraisonsProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT l.idLivraison, l.dateLivraison, l.typeProduit, l.idVerger, count(o.idLot) AS nbLots FROM livraison l LEFT OUTER JOIN lot o ON l.idLivraison = o.idLivraison LEFT JOIN verger ON l.idVerger = verger.idVerger WHERE verger.idProducteur = " . $p->id . " GROUP BY l.idLivraison ORDER BY l.idVerger ASC, l.dateLivraison DESC");
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
	 * @brief Obtenir tous les clients associés aux commandes de lots de vergers d'un producteur.
	 * @param Producteur $p
	 *   Producteur dont les commandes de lots de ses vergers sont associés aux clients à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Client correspondant aux clients connus dans la base de données et associés aux commandes de lots de vergers du producteur.
	 */
	public static function getClientsProducteur(Producteur $p) {
		$results = DBLayer::query("SELECT DISTINCT client.* FROM client LEFT JOIN commande ON commande.idClient = client.idClient LEFT JOIN lot ON commande.idLot = lot.idLot LEFT JOIN livraison ON lot.idLivraison = livraison.idLivraison LEFT JOIN verger ON livraison.idVerger = verger.idVerger WHERE verger.idProducteur = ".$p->id." ORDER BY client.nomClient ASC");
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
	 * @brief Obtenir toutes les commandes non expédiées associées à un client.
	 * @param Client $c
	 *   Client associé aux commandes à rechercher.
	 * @return array
	 *   Renvoie un tableau d'objets Commande correspondant aux commandes non expédiées connues dans la base de données et associées au client.
	 */
	public static function getCommandesUnsentClient(Client $c) {
		$results = DBLayer::query("SELECT * FROM commande WHERE idClient = " . $c->id . " AND dateEnvoie IS NULL ORDER BY dateConditionnement DESC");
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
	 * @brief Vérifier le mot de passe d'un utilisateur par rapport à une saisie.
	 * @param Utilisateur $u
	 *   Utilisateur dont le mot de passe est à vérifier.
	 * @param string $pass
	 *   Mot de passe en clair à comparer au hash de mot de passe de l'utilisateur.
	 * @return bool
	 *   Validité du mot de passe saisi par rapport au hash de mot de passe de l'utilisateur.
	 */
	public static function checkPassword(Utilisateur $u, $pass) {
		if($u == null) return false;
		$results = DBLayer::query("SELECT pass FROM users WHERE id = " . $u->id . " LIMIT 0,1");
		return password_verify($pass, $results[0]->pass);
	}

	/**
	 * @brief Ajouter un producteur dans la base de données.
	 * @param Producteur $p
	 *   Producteur dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique du producteur nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addProducteur(Producteur $p) {
		if(!isset($p)) return false;
		return DBLayer::preparedQuery("INSERT INTO producteur(nomProducteur,adresseProducteur,adherent,dateAdhesion) VALUES (?,?,?,?)",
			"ssis", $p->nom, $p->adresse, $p->adherent, $p->dateAdhesion);
	}
	
	/**
	 * @brief Ajouter un client dans la base de données.
	 * @param Client $c
	 *   Client dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique du client nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO client(nomClient,adresseClient,nomResAchats) VALUES (?,?,?)",
			"sss", $c->nom, $c->adresse, $c->nomResAchats);
	}

	/**
	 * @brief Ajouter une certification dans la base de données.
	 * @param Certification $c
	 *   Certification dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la certification nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO certification(libelleCertification) VALUES (?)", "s", $c->libelle);
	}

	/**
	 * @brief Ajouter une commande dans la base de données.
	 * @param Commande $c
	 *   Commande dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la commande nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addCommande(Commande $c) {
		if(!isset($c)) return false;
		var_dump($c);
		return DBLayer::preparedQuery("INSERT INTO commande(dateConditionnement,dateEnvoie,idConditionnement,idLot,idClient) VALUES (?,?,?,?,?)",
			"ssisi", validateDate($c->dateCond, 'Y-m-d') ? $c->dateCond : null, validateDate($c->dateEnvoi, 'Y-m-d') ? $c->dateEnvoi : null, $c->idCond, $c->idLot, $c->idClient);
	}

	/**
	 * @brief Ajouter un conditionnement dans la base de données.
	 * @param Conditionnement $c
	 *   Conditionnement dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique du conditionnement nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO conditionnement(libelleConditionnement) VALUES (?)", "s", $c->libelle);
	}

	/**
	 * @brief Ajouter un lot dans la base de données.
	 * @param Lot $l
	 *   Lot dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique du lot nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("INSERT INTO lot(codeLot,calibreLot,quantite,idLivraison,numCommande) VALUES (?,?,?,?,?)",
			"ssiii", $l->code, $l->calibre, $l->quantite, $l->idLivraison, $l->numCommande);
	}

	/**
	 * @brief Ajouter une livraison dans la base de données.
	 * @param Livraison $l
	 *   Livraison dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la livraison nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("INSERT INTO livraison(idLivraison,dateLivraison,typeProduit,idVerger) VALUES (?,?,?,?)",
			"issi", $l->id, $l->date, $l->type, $l->idVerger);
	}

	/**
	 * @brief Ajouter un verger dans la base de données.
	 * @param Verger $v
	 *   Verger dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique du verger nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("INSERT INTO verger(idVerger,nomVerger,superficie,arbresParHectare,idVariete,idCommune,idProducteur) VALUES (?,?,?,?,?,?,?)",
			"isiiiii", $v->id, $v->nom, $v->superficie, $v->arbresParHectare, $v->idVariete, $v->idCommune, $v->idProducteur);
	}

	/**
	 * @brief Ajouter une variété dans la base de données.
	 * @param Variete $v
	 *   Variété dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la variété nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("INSERT INTO variete(libelle,varieteAoc) VALUES (?,?)",
			"si", $v->libelle, $v->aoc);
	}

	/**
	 * @brief Ajouter une commune dans la base de données.
	 * @param Commune $c
	 *   Commune dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la commune nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO commune(nomCommune,communeAoc) VALUES (?,?)",
			"si", $c->nom, $c->aoc);
	}

	/**
	 * @brief Ajouter une validation de certification dans la base de données.
	 * @param CertObtenue $c
	 *   Validation de certification dont les informations sont à enregistrer en base de données.
	 * @return mixed
	 *   Renvoie l'identifiant unique de la validation de certification nouvellement insérée, ou FALSE si l'insertion a échoué.
	 */
	public static function addCertObtenue(CertObtenue $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("INSERT INTO obtient(idCertification,idProducteur,dateObtention) VALUES (?,?,?)",
			"iis", $c->id, $c->idProducteur, $c->date);
	}

	/**
	 * @brief Ajouter un utilisateur dans la base de données.
	 * @param Utilisateur $u
	 *   Utilisateur dont les informations sont à enregistrer en base de données.
	 * @param $pass
	 *   Mot de passe en clair du nouvel utilisateur.
	 * @return mixed
	 *   Renvoie l'identifiant unique de l'utilisateur nouvellement inséré, ou FALSE si l'insertion a échoué.
	 */
	public static function addUtilisateur(Utilisateur $u, $pass) {
		if(!isset($u) || empty($pass)) return false;
		return DBLayer::preparedQuery("INSERT INTO users(name,pass,role,idProducteur,idClient) VALUES (?,?,?,?,?)",
			"sssii", $u->nom, DBLayer::generate_hash($pass, 11), $u->role, $u->role == 'producteur' ? $u->idProducteur : null, $u->role == 'client' ? $u->idClient : null);
	}

	/**
	 * @brief Mettre à jour un producteur dans la base de données.
	 * @param Producteur $p
	 *   Producteur dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setProducteur(Producteur $p) {
		if(!isset($nom, $p)) return false;
		return DBLayer::preparedQuery("UPDATE producteur SET `nomProducteur`=?,`adresseProducteur`=?,`adherent`=?,`dateAdhesion`=? WHERE `idProducteur`=?",
			"ssisi", $p->nom, $p->adresse, $p->adherent, $p->dateAdhesion, $p->id);
	}
	
	/**
	 * @brief Mettre à jour un client dans la base de données.
	 * @param Client $c
	 *   Client dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE client SET `nomClient`=?,`adresseClient`=?,`nomResAchats`=? WHERE `idClient`=?",
			"sssi", $c->nom, $c->adresse,$c->nomResAchats, $c->id);
	}

	/**
	 * @brief Mettre à jour une certification dans la base de données.
	 * @param Certification $c
	 *   Certification dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE certification SET `libelleCertification`=? WHERE `idCertification`=?",
			"si", $c->libelle, $c->id);
	}

	/**
	 * @brief Mettre à jour une commande dans la base de données.
	 * @param Commande $c
	 *   Commande dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setCommande(Commande $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE commande SET `dateConditionnement`=?, `dateEnvoie`=?, `idConditionnement`=?, `idLot`=?, `idClient`=? WHERE `numCommande`=?",
			"ssiiii", $c->dateCond, $c->dateEnvoi, $c->idCond, $c->idLot, $c->idClient, $c->num);
	}

	/**
	 * @brief Mettre à jour un conditionnement dans la base de données.
	 * @param Conditionnement $c
	 *   Conditionnement dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE conditionnement SET `libelleConditionnement`=? WHERE `idConditionnement`=?",
			"si", $c->libelle, $c->id);
	}

	/**
	 * @brief Mettre à jour un lot dans la base de données.
	 * @param Lot $l
	 *   Lot dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("UPDATE lot SET `codeLot`=?, `calibreLot`=?, `quantite`=?, `idLivraison`=? WHERE `idLot`=?",
			"ssiii", $l->code, $l->calibre, $l->quantite, $l->idLivraison, $l->id);
	}

	/**
	 * @brief Mettre à jour une livraison dans la base de données.
	 * @param Livraison $l
	 *   Livraison dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("UPDATE livraison SET `dateLivraison`=?, `typeProduit`=?, `idVerger`=? WHERE `idLivraison`=?",
			"ssii", $l->date, $l->type, $l->idVerger, $l->id);
	}

	/**
	 * @brief Mettre à jour un verger dans la base de données.
	 * @param Verger $v
	 *   Verger dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("UPDATE verger SET `nomVerger`=?, `superficie`=?, `arbresParHectare`=?, `idVariete`=?, `idCommune`=?, `idProducteur`=? WHERE `idVerger`=?",
			"siiiiii", $v->nom, $v->superficie, $v->arbresParHectare, $v->idVariete, $v->idCommune, $v->idProducteur, $v->id);
	}

	/**
	 * @brief Mettre à jour une variété dans la base de données.
	 * @param Variete $v
	 *   Variété dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("UPDATE variete SET `libelle`=?, `varieteAoc`=? WHERE `idVariete`=?",
			"sii", $v->libelle, $v->aoc, $v->id);
	}

	/**
	 * @brief Mettre à jour une commune dans la base de données.
	 * @param Commune $c
	 *   Commune dont les informations sont à mettre à jour en base de données.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("UPDATE commune SET `nomCommune`=?, `communeAoc`=? WHERE `idCommune`=?",
			"sii", $c->nom, $c->aoc, $c->id);
	}

	/**
	 * @brief Mettre à jour un utilisateur dans la base de données.
	 * @param Utilisateur $u
	 *   Utilisateur dont les informations sont à mettre à jour en base de données.
	 * @param string|null $pass
	 *   Nouveau mot de passe en clair à définir pour cet utilisateur. Si le mot de passe est vide ou vaut NULL, il ne sera pas mis à jour.
	 * @return bool
	 *   État de réussite de la mise à jour.
	 */
	public static function setUtilisateur(Utilisateur $u, $pass) {
		if(!isset($u, $pass)) return false;
		return DBLayer::preparedQuery("UPDATE users SET `name`=?, `pass`=?, `role`=?, `idProducteur`=?, `idClient`=? WHERE `id`=?",
			"sssiii", $u->nom, empty($pass) ? null : DBLayer::generate_hash($pass, 11), $u->role, $u->role == 'producteur' ? $u->idProducteur : null, $u->role == 'client' ? $u->idClient : null, $u->id);
	}

	/**
	 * @brief Supprimer un producteur de la base de données.
	 * @param Producteur $p
	 *   Producteur à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeProducteur(Producteur $p) {
		if(!isset($p)) return false;
		return DBLayer::preparedQuery("DELETE FROM producteur WHERE idProducteur=?", "i", $p->id);
	}
	
	/**
	 * @brief Supprimer un client de la base de données.
	 * @param Client $c
	 *   Client à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeClient(Client $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM client WHERE `idClient`=?", "i", $c->id);
	}

	/**
	 * @brief Supprimer une certification de la base de données.
	 * @param Certification $c
	 *   Certification à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeCertification(Certification $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM certification WHERE `idCertification`=?", "i", $c->id);
	}

	/**
	 * @brief Supprimer une commande de la base de données.
	 * @param Commande $c
	 *   Commande à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeCommande(Commande $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM commande WHERE `numCommande`=?", "i", $c->num);
	}

	/**
	 * @brief Supprimer un conditionnement de la base de données.
	 * @param Conditionnement $c
	 *   Conditionnement à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeConditionnement(Conditionnement $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM conditionnement WHERE `idConditionnement`=?", "i", $c->id);
	}

	/**
	 * @brief Supprimer un lot de la base de données.
	 * @param Lot $l
	 *   Lot à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeLot(Lot $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("DELETE FROM lot WHERE `idLot`=?", "i", $l->id);
	}

	/**
	 * @brief Supprimer une livraison de la base de données.
	 * @param Livraison $l
	 *   Livraison à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeLivraison(Livraison $l) {
		if(!isset($l)) return false;
		return DBLayer::preparedQuery("DELETE FROM livraison WHERE `idLivraison`=?", "i", $l->id);
	}

	/**
	 * @brief Supprimer un verger de la base de données.
	 * @param Verger $v
	 *   Verger à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeVerger(Verger $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("DELETE FROM verger WHERE `idVerger`=?", "i", $v->id);
	}

	/**
	 * @brief Supprimer une variété de la base de données.
	 * @param Variete $v
	 *   Variété à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeVariete(Variete $v) {
		if(!isset($v)) return false;
		return DBLayer::preparedQuery("DELETE FROM variete WHERE `idVariete`=?", "i", $v->id);
	}

	/**
	 * @brief Supprimer une commune de la base de données.
	 * @param Commune $c
	 *   Commune à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeCommune(Commune $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM commune WHERE `idCommune`=?", "i", $c->id);
	}

	/**
	 * @brief Supprimer une validation de certification de la base de données.
	 * @param CertObtenue $c
	 *   Validation de certification à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeCertObtenue(CertObtenue $c) {
		if(!isset($c)) return false;
		return DBLayer::preparedQuery("DELETE FROM obtient WHERE `idCertification`=? AND `idProducteur`=?",
			"ii", $c->id, $c->idProducteur);
	}

	/**
	 * @brief Supprimer un utilisateur de la base de données.
	 * @param Utilisateur $u
	 *   Utilisateur à supprimer de la base de données.
	 * @return bool
	 *   État de réussite de la suppression.
	 */
	public static function removeUtilisateur(Utilisateur $u) {
		if(!isset($u)) return false;
		return DBLayer::preparedQuery("DELETE FROM users WHERE `id`=?", "i", $u->id);
	}

	/**
	 * @brief Générer un hachage sécurisé pour un mot de passe donné.
	 * Utilise l'algorithme Blowfish pour créer un mot de passe de manière sécurisée, avec un salt généré directement.
	 * @param string $password
	 *   Mot de passe en clair à crypter.
	 * @param int $cost
	 *   Passé à l'algorithme Blowfish. Le coût détermine le niveau de sécurité du hash mais aussi le coût en termes de performances.
	 * @return string
	 *   Hachage du mot de passe.
	 */
	private static function generate_hash($password, $cost=11){
		/* To generate the salt, first generate enough random bytes. Because
			* base64 returns one character for each 6 bits, the we should generate
			* at least 22*6/8=16.5 bytes, so we generate 17. Then we get the first
			* 22 base64 characters
			*/
		$salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
		/* As blowfish takes a salt with the alphabet ./A-Za-z0-9 we have to
			* replace any '+' in the base64 string with '.'. We don't have to do
			* anything about the '=', as this only occurs when the b64 string is
			* padded, which is always after the first 22 characters.
			*/
		$salt=str_replace("+",".",$salt);
		/* Next, create a string that will be passed to crypt, containing all
			* of the settings, separated by dollar signs
			*/
		$param='$'.implode('$',array(
				"2a", //select the less secure version of blowfish (<PHP 5.3.7)
				// chosen to help compatibility with jBCrypt
				str_pad($cost,2,"0",STR_PAD_LEFT), //add the cost in two digits
				$salt //add the salt
		));
		//now do the actual hashing
		return crypt($password,$param);
	}
}
?>