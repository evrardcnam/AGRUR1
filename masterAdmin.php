<?php require_once 'php/config.php'; if(AuthManager::loginStatus() != U_ADMIN) header("Location: index.php");
$nom = AuthManager::getUser()->nom; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>AGRUR — <?php echo $nom ?></title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link type ="text/css" rel="stylesheet" href="css/master.css">
		<script type="text/javascript" src="js/master.js"></script>
	</head>
	<body>
		<div id="global">
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">AGRUR </a>
					</div>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Production <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" data-link="php/producteurs.php"><span class="glyphicon glyphicon-flash"></span> Producteurs</a></li>
								<li><a class="slavePage" data-link="php/vergers.php"><span class="glyphicon glyphicon-tree-deciduous"></span> Vergers</a></li>
								<li><a class="slavePage" data-link="php/varietes.php"><span class="glyphicon glyphicon-leaf"></span> Variétés</a></li>
								<li><a class="slavePage" data-link="php/livraisons.php"><span class="glyphicon glyphicon-gift"></span> Livraisons</a></li>
								<li><a class="slavePage" data-link="php/conditionnements.php"><span class="glyphicon glyphicon-barcode"></span> Conditionnements</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart"></span> Clientèle <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" data-link="php/clients.php"><span class="glyphicon glyphicon-briefcase"></span> Clients</a></li>
								<li><a class="slavePage" data-link="php/commandes.php"><span class="glyphicon glyphicon-credit-card"></span> Commandes</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span> Administration <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" data-link="php/utilisateurs.php"><span class="glyphicon glyphicon-user"></span> Utilisateurs</a></li>
								<li><a class="slavePage" data-link="php/communes.php"><span class="glyphicon glyphicon-globe"></span> Communes</a></li>
								<li><a class="slavePage" data-link="php/certifications.php"><span class="glyphicon glyphicon-certificate"></span> Certifications</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav pull-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a class="slavePage" data-link="about.html"><span class="glyphicon glyphicon-info-sign"></span> À propos de</a></li>
								<li role="separator" class="divider"></li>
								<li><a class="user"><span class="username"><?php echo $nom; ?></span> &nbsp; <span class="glyphicon glyphicon-user"></span></a></li>
								<li><a class="slavePage" data-link="php/changeUser.php"><span class="glyphicon glyphicon-transfer"></span> Changer d'utilisateur</a></li>
								<li><a class="sliderPage no-active" data-link="php/resetPassword.php"><span class="glyphicon glyphicon-pencil"></span> Changer de mot de passe</a></li>
								<li><a href="index.php?logout"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<div id="content">
				<h1>Bienvenue chez AGRUR</h1>
				<p>Utilisez les menus ci-dessus pour naviguer sur l'interface d'administration.</p>
			</div>
		</div>
	</body>
</html>