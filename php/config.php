<?php
// Ajouter la couche d'accès aux données
require_once(dirname(dirname(__FILE__)) . '/php/class/DBLayer.php');
spl_autoload_register(function ($class_name) {
    include dirname(dirname(__FILE__)) . '/php/class/' . $class_name . '.php';
});
// Constantes d'identification pour la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'agrur');
define('DB_PASSWORD', "les noix c'est la vie");
define('DB_DB', 'agrur');
?>