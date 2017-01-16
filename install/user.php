<?php if(isset($_POST["user"], $_POST["pass"])) {
    require_once('../php/config.php');
    DBLayer::addUtilisateur(Utilisateur::fromValues(null, $_POST["user"], "admin", null), $_POST["pass"]);
    header('Location: end.php');
    exit();
} ?>
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
                        <li><a>Base de données</a></li>
                        <li class="active"><a>Compte utilisateur</a></li>
                        <li><a>Fin</a></li>
                    </ul>
                </div>
			</nav>
            <div id="content">
                <h1>Configuration d'un compte administrateur</h1>
                <p>L'accès à l'intranet AGRUR sans compte utilisateur déjà défini est, puisque c'est un intranet, impossible. Pour réduire les incidents de sécurité, aucun utilisateur n'est créé par défaut. Cette étape permet de définir un premier compte administrateur à utiliser.</p>
                <form action="user.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="user" class="col-xs-4 col-sm-2 control-label">Nom d'utilisateur</label>
                        <div class="col-xs-8 col-sm-10">
                            <input type="text" class="form-control" id="user" name="user" placeholder="Nom d'utilisateur" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pass" class="col-xs-4 col-sm-2 control-label">Mot de passe</label>
                        <div class="col-xs-8 col-sm-10">
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Mot de passe" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="reset" class="btn btn-danger">Remise à zéro</button>
                            <button type="submit" class="btn btn-primary">Créer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>