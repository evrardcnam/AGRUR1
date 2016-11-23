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
	// Connexion à la base de données. Action réalisée par les autres fonctions internes.
	private function dbconnect() {
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if ($conn->connect_error) {
			die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}     
		return $conn;
	}
	
	// Exécuter une requête sur la base de données.
	// Pour plus de sécurité, préférer l'utilisation d'un mysqli_stmt s'il y a des saisies utilisateur à prendre en compte.
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
		while ($row = mysql_fetch_array($res)){
			$result = new DBQueryResult();
			foreach ($row as $k=>$v){
				$result->$k = $v;
			}
			$results[] = $result;
		}
		return $results;      
	}

	// Exécuter une requête sur la base de données de manière sécurisée (requête préparée).
	private function query(mysqli_stmt $stmt) {
		$this->dbconnect();
		$res = $stmt->execute();
		if ($res) {
			// Si ce n'est pas un SELECT, échec.
			if (strpos($sql,'SELECT') === false) { return true; }
		} else { // Pas de résultats
			if (strpos($sql,'SELECT') === false) { return false; }
			else { return null; }
		}
		$results = array();
		while ($row = $res->fetch_row()) {
			$result = new DBQueryResult();
			foreach ($row as $k=>$v) {
				$result->$k = $v;
			}
			$results[] = $result;
		}
		return $results;      
	}
}
?>