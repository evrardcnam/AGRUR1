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
                        <li class="active"><a>Prérequis</a></li>
                        <li><a>Base de données</a></li>
                        <li><a>Compte utilisateur</a></li>
                        <li><a>Fin</a></li>
                    </ul>
                </div>
			</nav>
            <?php
                // Check PHP Version
                $phpversion = phpversion();
                $phpok = $phpversion > 5;
                $phpcolor = $phpok ? 'true' : 'false';
                // Try checking MySQL version
                function mysqlversion() { 
                    $output = shell_exec('mysql -V');    
                    preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
                    return @$version[0]?$version[0]:-1; 
                }
                $mysqlversion=mysqlversion();
                $mysqlcolor=$mysqlversion < 5 ? ($mysqlversion == -1 ? 'major' : 'false') : 'true';
                $mysqlmessage=$mysqlversion == -1 ? "Non vérifiable automatiquement" : ('MySQL ' . $mysqlversion);
                $safe = ini_get("safe_mode");
                $safecolor = $safe ? 'false' : 'true';
                $_SESSION["test"] = true;
                $sessioncolor = $_SESSION["test"] ? 'true' : 'false';
            ?>
            <div id="content">
                <h1>Vérification des prérequis</h1>
                <p>L'assistant va vérifier automatiquement si votre serveur dispose d'une configuration compatible pour les fonctionnalités de l'intranet.</p>
                <div class="rowtable">
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">Prérequis</div>
                        <div class="col-xs-4 col-sm-2">Disponibilité</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">PHP 5 ou ultérieur</div>
                        <div class="col-xs-4 col-sm-2 <?php echo $phpcolor ?>">PHP <?php echo $phpversion; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">MySQL 5 ou ultérieur</div>
                        <div class="col-xs-4 col-sm-2 <?php echo $mysqlcolor ?>"><?php echo $mysqlmessage; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">Sessions PHP</div>
                        <div class="col-xs-4 col-sm-2 <?php echo $sessioncolor ?>"><?php echo $sessioncolor == 'true' ? 'Disponible' : 'Indisponible' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 col-sm-4">Mode sans échec de PHP</div>
                        <div class="col-xs-4 col-sm-2 <?Php echo $safecolor ?>"><?php echo $safe ? 'Désactivé' : 'Activé' ?></div>
                    </div>
                </div>
                <p>Si tous les éléments nécessaires à l'installation et l'exploitation du service sont disponibles, vous pouvez passer à l'étape suivante. Sinon, vérifiez vos fichiers de configuration ou mettez à jour vos logiciels serveur.</p>
                <a href="index.php"><button class="btn btn-default">Précédent</button></a> <a href="check.php"><button class="btn btn-warning">Revérifier</button></a>
                <?php if($phpok && $mysqlcolor != 'false' && $safecolor == 'true' && $sessioncolor == 'true') { ?>
                    <a href="config.php"><button class="btn btn-primary">Étape suivante</button></a>
                <?php } ?>
                <?php if($mysqlversion == -1) { ?>
                    <div class="alert alert-warning" role="alert"><strong>Attention !</strong> La compatibilité de MySQL n'a pas pu être vérifiée automatiquement suite à l'impossibilité pour l'assistant d'obtenir automatiquement la version du serveur MySQL.<br />
                    Afin d'éviter tout problème à l'avenir, il est recommandé de s'assurer que vous disposez de <strong>MySQL 5.0 ou ultérieur</strong> et du moteur de base de données <strong>InnoDB</strong>.</div>
                <?php } ?>
            </div>
        </div>
    </body>
</html>