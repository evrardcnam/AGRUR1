﻿<!DOCTYPE html>
<html>
	<head>
		<title>Administration AGRUR</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Production <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" href="producteurs.php">Producteurs</a></li>
								<li><a class="slavePage" href="vergers.php">Vergers</a><li>
								<li><a class="slavePage" href="varietes.php">Variétés</a></li>
								<li><a class="slavePage" href="livraisons.php">Livraisons</a></li>
								<li><a class="slavePage" href="lots.php">Lots</a></li>
								<li><a class="slavePage" href="conditionnements.php">Conditionnements</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clientèle <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" href="clients.php">Clients</a></li>
								<li><a class="slavePage" href="commandes.php">Commandes</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" href="utilisateurs.php">Utilisateurs</a></li>
								<li><a class="slavePage" href="communes.php">Communes</a></li>
								<li><a class="slavePage" href="certifications.php">Certifications</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</body>
</html>