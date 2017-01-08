# AGRUR1 [![Gitter](https://img.shields.io/badge/chat-on%20gitter-blue.svg)](https://gitter.im/PPEVDEV/SiteAgrur)
Situation 1 du PPE 2ème année : Application web de gestion des approvisionnements et ventes pour une coopérative de noix à Grenoble.

## Installation

Testé sous XAMPP 5.6.28 (Apache 2.4.23, PHP 5.6.28, MariaDB 10.1.19)

1. Exécutez les requêtes de `CREATE_DB.sql` sur votre serveur de base de données.
2. Placez tous les fichiers, à l'exception de `CREATE_DB.sql`, `docconfig`, `README.md` et `LICENSE` (qui ne sont pas utilisés par le site) dans le répertoire exploité par Apache (le plus souvent `www` ou `htdocs`).
3. Éditez les constantes dans `php/config.php` pour définir les identifiants que l'application va utiliser pour se connecter à la base de données. L'utilisateur MySQL doit avoir les droits d'accès SELECT, INSERT, UPDATE et DELETE.
4. Accédez à `index.php` et connectez-vous avec les identifiants administrateur par défaut : Utilisateur `vdev`, mot de passe `vdev`.