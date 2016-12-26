<?php
/**
 * Gestionnaire de connexion à l'intranet
 */
class AuthManager {
    /**
     * Connexion avec un nom d'utilisateur et un mot de passe.
     */
    public static function login($name, $pass) {
        $user = DBLayer::getUtilisateur($name);
        if(!$user) return false; // Utilisateur inconnu
        if(!$user->checkPassword($pass)) return false; // Mot de passe incorrect
        session_start();
        $_SESSION['user'] = $user;
    }

    /**
     * Obtient l'état de connexion d'un utilisateur.
     * false si aucun utilisateur n'est connecté pour la session active, sinon retourne le rôle de l'utilisateur.
     * Le rôle de l'utilisateur est U_ADMIN s'il est administrateur ou U_PRODUCTEUR s'il est producteur.
     */
    public static function isLoggedOn() {
        if(!($_SESSION['user'] instanceof Utilisateur)) return false;
        else if ($_SESSION['user']->admin) return U_ADMIN;
        else return U_PRODUCTEUR; 
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public static function logout() {
        $_SESSION['user'] = null;
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
?>