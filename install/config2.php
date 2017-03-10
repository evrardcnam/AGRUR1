<?php
if(!isset($_POST["server"], $_POST["user"], $_POST["pass"], $_POST["db"])) { header('Location: config.php'); exit(); } ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Installation de l'intranet AGRUR</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link type ="text/css" rel="stylesheet" href="../css/master.css">
	</head>
	<body>
		<div id="global">
            <nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">AGRUR </a>
					</div>
					<ul class="nav navbar-nav">
						<li><a>Introduction</a></li>
                        <li><a>Prérequis</a></li>
                        <li class="active"><a>Base de données</a></li>
                        <li><a>Compte utilisateur</a></li>
                        <li><a>Fin</a></li>
                    </ul>
                </div>
			</nav>
            <div id="content">
                <?php $database = @mysqli_connect($_POST['server'],$_POST['user'],$_POST['pass']);
                    if(!$database) { ?>
                    <h1>Erreur de connexion au serveur</h1>
                    <p>Une erreur s'est produite lors de la connexion au serveur de base de données <code><?php echo $_POST['server']; ?></code> avec le nom d'utilisateur <code><?php echo $_POST['user']; ?></code>.</p>
                    <a href="config.php"><button type="button" class="btn btn-warning">Étape précédente</button></a>
                <?php } else if(!($database->select_db($_POST['db']))) { ?>
                    <h1>Erreur de connexion à la base de données</h1>
                    <p>Une erreur s'est produite lors de la connexion à la base de données <code><?php echo $_POST['db']; ?></code>. Le nom du serveur et les identifiants sont valides.<p>
                    <pre><?php echo mysqli_error_list(); ?></pre>
                    <a href="config.php"><button type="button" class="btn btn-warning">Étape précédente</button></a>
                <?php } else {
                    try {
                        $config = file_get_contents('../php/config.php');
                        $config = str_replace("###HOST###", $_POST["server"], $config);
                        $config = str_replace("###USER###", $_POST["user"], $config);
                        $config = str_replace("###PASSWORD###", $_POST["pass"], $config);
                        $config = str_replace("###DB###", $_POST["db"], $config);
                        file_put_contents('../php/config.php', $config);
                    } catch (Exception $e) {  ?>
                        <h1>Erreur à l'enregistrement de la configuration</h1>
                        <p>La connexion à la base de données du serveur avec les identifiants spécifiés a réussi. Cependant, l'enregistrement des identifiants dans le fichier de configuration de l'application a échoué.</p>
                        <pre><?php echo $e->getMessage(); ?></pre>
                        <h2>Aide au dépannage</h2>
                        <ol>
                            <li>Assurez-vous que vous disposez d'une copie complète et à jour de l'intranet AGRUR.</li>
                            <li>Assurez-vous que votre serveur est conforme aux <a href="check.php">prérequis</a> de l'application.</li>
                            <li>Tentez à nouveau la configuration automatique.</li>
                            <li>Si rien ne fonctionne, suivez les instructions d'installation manuelle du fichier <a href="../README.md">README</a>.</li>
                            <li>Contactez le support technique de l'application ou l'équipe de développement.</li>
                        </ol>
                        <a href="index.php"><button type="button" class="btn btn-danger">Recommencer l'installation</button></a>
                    <?php exit(); } try {
                        set_time_limit(300);
                        if(!$database->multi_query(file_get_contents('CREATE_DB.sql'))) throw new Exception();
                        while ($database->next_result()) {;}
                    } catch (Exception $e) { ?>
                        <h1>Erreur lors de la préparation de la base</h1>
                        <p>La connexion à la base de données du serveur avec les identifiants spécifiés a réussi. Cependant, la préparation automatique de la base de données a échoué.</p>
                        <pre><?php echo $e->getMessage(); ?></pre>
                        <h2>Aide au dépannage</h2>
                        <ol>
                            <li>Par mesure de précaution, videz la base de données concernée avant toute nouvelle action.</li>
                            <li>Assurez-vous que l'utilisateur spécifié dispose des droits suffisants pour la création de la base de données.</li>
                            <li>Assurez-vous que vous disposez d'une copie complète et à jour de l'intranet AGRUR.</li>
                            <li>Assurez-vous que votre serveur est conforme aux <a href="check.php">prérequis</a> de l'application.</li>
                            <li>Tentez à nouveau la configuration automatique.</li>
                            <li>Si rien ne fonctionne, suivez les instructions d'installation manuelle du fichier <a href="../README.md">README</a>.</li>
                            <li>Contactez le support technique de l'application ou l'équipe de développement.</li>
                        </ol>
                        <a href="index.php"><button type="button" class="btn btn-danger">Recommencer l'installation</button></a>
                    <?php exit(); } ?>
                    <h1>Configuration de la base de données réussie</h1>
                    <p>Les identifiants spécifiés ont été correctement enregistrés et la base de données a été initialisée avec succès. Bravo !<br />
                    Vous pouvez passer à la dernière étape de la configuration en cliquant sur le bouton ci-dessous.</p>
                    <a href="user.php"><button type="button" class="btn btn-primary">Étape suivante</button></a>
                <?php } ?>
            </div>
        </div>
    </body>
</html>