# AGRUR1 [![Gitter](https://img.shields.io/badge/chat-on%20gitter-blue.svg)](https://gitter.im/PPEVDEV/SiteAgrur)
Situation 1 du PPE 2ème année : Application web de gestion des approvisionnements et ventes pour une coopérative de noix à Grenoble.

## Installation automatique

1. Placez tous les fichiers dans le répertoire exploité par Apache (le plus souvent `www` ou `htdocs`).

## Installation manuelle

Testé sous XAMPP 5.6.28 (Apache 2.4.23, PHP 5.6.28, MariaDB 10.1.19)

1. Exécutez les requêtes de `CREATE_DB.sql` sur votre serveur de base de données.
2. Placez tous les fichiers dans le répertoire exploité par le serveur Web (le plus souvent `www` ou `htdocs`).
3. Éditez les constantes dans `php/config.php` pour définir les identifiants que l'application va utiliser pour se connecter à la base de données. L'utilisateur MySQL doit avoir les droits d'accès SELECT, INSERT, UPDATE et DELETE.
4. Ajoutez un enregistrement à la table `users` : le champ `name` sera votre nom d'utilisateur, `pass` votre mot de passe (encrypté avec [bcrypt](http://fipi.ch/php-online/hash-bcrypt.php) et un _cost_ de 11). Définissez `admin` à 1 et laissez `idProducteur` à `NULL`.
5. Accédez à `index.php` et connectez-vous avec les identifiants que vous venez de définir.