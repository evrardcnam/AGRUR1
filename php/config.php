<?php
// Ajouter la couche d'accès aux données
require_once(dirname(dirname(__FILE__)) . '/php/class/DBLayer.php');
spl_autoload_register(function ($class_name) {
    include dirname(dirname(__FILE__)) . '/php/class/' . $class_name . '.php';
});
// Constantes d'identification pour la base de données
// Les ###NOM### sont des éléments remplacés automatiquement par l'assistant d'installation.
define('DB_HOST', '###HOST###');
define('DB_USER', '###USER###');
define('DB_PASSWORD', '###PASSWORD###');
define('DB_DB', '###DB###');
?>