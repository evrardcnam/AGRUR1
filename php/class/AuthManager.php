<?php
/**
 * Gestionnaire de connexion à l'intranet
 */
class AuthManager {
    /**
     * Connexion avec un nom d'utilisateur et un mot de passe.
     */
    public static function login($name, $pass, $cookie) {
        $user = DBLayer::getUtilisateurPseudo($name);
        if(!$user) return false; // Utilisateur inconnu
        if(!$user->checkPassword($pass)) return false; // Mot de passe incorrect
        session_start();
        $_SESSION['user'] = $user;
        if($cookie) setcookie("user", $user, 0, "/", "", false, true);
        return true;
    }
    
    /**
     * Tentative de connexion avec des identifiants stockés en tant que cookie.
     */
    public static function fromCookie() {
        if(isset($_COOKIE['user'])) {
            $_SESSION['user'] = $_COOKIE['user'];
            return true;
        } else return false;
    }

    /**
     * Connexion forcée à un utilisateur.
     */
    public static function forceLogin(Utilisateur $user, $cookie=false) {
        session_start();
        $_SESSION['user'] = $user;
        if($cookie) setcookie("user", $user, 0, "/", "", false, true);
        return true;
    }

    /**
     * Obtient l'état de connexion d'un utilisateur.
     * false si aucun utilisateur n'est connecté pour la session active, sinon retourne le rôle de l'utilisateur.
     * Le rôle de l'utilisateur est U_ADMIN s'il est administrateur, U_PRODUCTEUR s'il est producteur ou U_CLIENT s'il est client.
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
     * Déconnecte l'utilisateur.
     */
    public static function logout($cookie=true) {
        $_SESSION['user'] = null;
        if($cookie) setcookie("user", false, 0, "/", "", false, true);
    }

    /**
     * Obtient l'objet Utilisateur correspondant à l'utilisateur actuellement connecté.
     * Retourne NULL s'il n'y a pas d'utilisateur connecté.
     */
    public static function getUser() {
        return $_SESSION['user'];
    }

    
}

define("U_PRODUCTEUR", 1);
define("U_ADMIN", 2);
define("U_CLIENT", 3);
?>