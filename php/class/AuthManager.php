<?php
/**
 * @file AuthManager.php
 * @brief Gestionnaire de connexion à l'intranet
 * @author Lucidiot
 */
/*! @class AuthManager
 * @brief Gestionnaire de connexion à l'intranet
 */
class AuthManager {
    /**
     * @brief Connexion avec un nom d'utilisateur et un mot de passe.
     * @param string $name
     *   Pseudonyme saisi.
     * @param string $pass
     *   Mot de passe en clair saisi.
     * @param bool $cookie
     *   Enregistrement comme cookie pour une connexion automatique (option "Se souvenir de moi")
     * @return bool
     *   État de réussite de la connexion.
     */
    public static function login($name, $pass, $cookie) {
        $user = DBLayer::getUtilisateurPseudo($name);
        if(!$user) return false; // Utilisateur inconnu
        if(!$user->checkPassword($pass)) return false; // Mot de passe incorrect
        session_start();
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        if($cookie) setcookie("user", $user, strtotime('+30 days'), "/", "", false, true);
        return true;
    }
    
    /**
     * @brief Tentative de connexion avec des identifiants stockés en tant que cookie.
     * @return bool
     *   État de réussite de la connexion.
     */
    public static function fromCookie() {
        if(isset($_COOKIE['user'])) {
            $_SESSION['user'] = $_COOKIE['user'];
            return true;
        } else return false;
    }

    /**
     * @brief Connexion forcée à un utilisateur.
     * @return bool
     *   État de réussite de la connexion.
     */
    public static function forceLogin(Utilisateur $user, $cookie=false) {
        session_start();
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        if($cookie) setcookie("user", $user, strtotime('+30 days'), "/", "", false, true);
        return true;
    }

    /**
     * @brief Obtient l'état de connexion d'un utilisateur.
     * @return mixed
     *   false si aucun utilisateur n'est connecté pour la session active, sinon retourne le rôle de l'utilisateur.
     *   Le rôle de l'utilisateur est U_ADMIN s'il est administrateur, U_PRODUCTEUR s'il est producteur ou U_CLIENT s'il est client.
     */
    public static function loginStatus() {
        session_start();
        if(!isset($_SESSION['user']) || !($_SESSION['user'] instanceof Utilisateur)) return false;
        else if ($_SESSION['user']->role == 'admin') return U_ADMIN;
        else if ($_SESSION['user']->role == 'producteur') return U_PRODUCTEUR;
        else if ($_SESSION['user']->role == 'client') return U_CLIENT;
        else return false;
    }

    /**
     * @brief Déconnecte l'utilisateur.
     * @param bool $cookie
     *    Supprime ou non la connexion automatique enregistrée en cookie.
     */
    public static function logout($cookie=true) {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        if($cookie) setcookie("user", false, 1, "/", "", false, true);
    }

    /**
     * @brief Obtient l'utilisateur actuellement connecté.
     * @return Utilisateur
     *   Utilisateur actuellement connecté.
     */
    public static function getUser() {
        return $_SESSION['user'];
    }

    /**
     * @brief Vérifie l'existence d'un administrateur dans la base de données.
     * Si l'intranet est ouvert alors qu'il n'existe aucun administrateur sur le système, il devient impossible de gérer l'application.
     * Cette fonction permet d'afficher sur la page de connexion un message proposant la création d'un nouvel administrateur par l'assistant d'installation.
     * @return bool
     *   Présence d'un administrateur dans la base de données.
     */
    public static function checkAdministrators() {
        $users = DBLayer::getUtilisateurs();
        if(count($users) < 1) return false;
        foreach($users as $user) { if($user->role == 'admin') return true; }
        return false;
    }
}

/**
 * @brief Rôle d'utilisateur "producteur".
 * Accorde l'accès aux informations liées au producteur associé à l'utilisateur.
 */
define("U_PRODUCTEUR", 1);
/**
 * @brief Rôle d'utilisateur "administrateur".
 * Accorde l'accès à l'intégralité des données et donne tous les droits.
 */
define("U_ADMIN", 2);
/**
 * @brief Rôle d'utilisateur "client".
 * Accorde l'accès aux informations liées au client associé à l'utilisateur ainsi qu'aux fonctionnalités de commande de lot.
 */
define("U_CLIENT", 3);
?>