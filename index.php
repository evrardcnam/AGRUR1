<?php require_once('php/config.php'); $err = false;
	if(isset($_GET["logout"])) {
		AuthManager::logout();
		header("Location: index.php");
	}
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
		} else {
			header("refresh:5;url=index.php");
			?>
			<html><head><title>Erreur</title></head><body><h1>Connexion échouée</h1><p>Vos identifiants sont incorrects ou vous n'êtes pas encore inscrit. Si le problème persiste, contactez le webmestre.<br />Vous serez redirigé dans quelques instants, sinon, <a href="index.php">cliquez ici.</a></p></body></html>
		<?php exit(); } } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Site Agrur</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="css/login.css" />
</head>

<body>
	<form class="formulaire" method="post">
	<p>
		<img src="img/logo.png" alt="Logo Agrur" /><br />
		<input type="text" class="form-control compte" name="compte" id="compte" placeholder="Nom d'utilisateur" maxlength="10" />
		<input type="password" class="form-control compte" name="motdepasse" id="motdepasse" placeholder="Mot de passe" maxlength="10" /><br />
		<button class="btn">Connexion</button>
	</p>
    </form>
</body>

<footer>
	<p>
		powered by VDEV
	</p>
</footer>
</html>