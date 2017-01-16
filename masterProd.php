<!DOCTYPE html>
<html>
    <head>
		<title>AGRUR - Espace Producteur</title>
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
						<li><a id="home" class="slavePage" data-link="php/accueilProd.php">Accueil</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Production <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" data-link="php/vergersProd.php">Vergers</a></li>
								<li><a class="slavePage" data-link="php/livraisons.php">Livraisons</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vente <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a class="slavePage" data-link="php/clients.php">Clientèle</a></li>
								<li><a class="slavePage" data-link="php/commandes.php">Commandes</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav pull-right">
						<li><a href="javascript:logout();"><span class="glyphicon glyphicon-off"></span></a></li>
					</ul>
				</div>
			</nav>
			<div id="content">
			</div>
		</div>
	</body>
</html>