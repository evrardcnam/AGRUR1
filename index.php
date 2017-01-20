<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>AGRUR &mdash; Connexion</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/login.css" />
	<script type="text/javascript" src="js/master.js"></script>
</head>

<body>
	<?php require_once('php/config.php'); $err = false;
	if(isset($_POST["compte"], $_POST["motdepasse"])) {
		if(AuthManager::login($_POST["compte"], $_POST["motdepasse"])) {
			switch(AuthManager::loginStatus()) {
				case U_ADMIN:
					header("Location: masterAdmin.php");
					break;
				case U_PRODUCTEUR:
					header("Location: masterProd.php");
					break;
				case U_CLIENT:
					header("Location: masterClient.php");
					break;
				default:
					header("Location: index.php");
					break;
			}
		} else echo "<script type=\"text/javascript\">$(function(){showMessage(\"Connexion échouée\", \"L'authentification à l'intranet a échoué.<br />Vérifiez que vos identifiants sont corrects. Si vous n'êtes pas encore inscrit, contactez un administrateur d'AGRUR. Si le problème persiste, contactez le support technique de VDEV.\", \"Retour\")});</script>";
	} if(isset($_GET["logout"])) AuthManager::logout(); ?>
	<form class="formulaire" action="index.php" method="post">
		<img src="img/logo.png" alt="Logo Agrur" /><br />
		<input type="text" class="form-control compte" name="compte" id="compte" placeholder="Nom d'utilisateur" />
		<input type="password" class="form-control compte" name="motdepasse" id="motdepasse" placeholder="Mot de passe" /><br />
		<button class="btn login-button">Connexion</button>
    </form>
	<div id="content"></div>
	<?php if(isset($_GET["logout"])) echo "<script type=\"text/javascript\">$(function(){showMessage(\"Déconnecté\", \"Vous avez été déconnecté de l'intranet AGRUR.\", \"Retour\");});</script>"; ?>
</body>

<footer>
	<p>
		powered by VDEV
	</p>
</footer>
</html>