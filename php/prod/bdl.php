<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if((AuthManager::loginStatus() != U_PRODUCTEUR && AuthManager::loginStatus() != U_ADMIN) || !isset($_GET["id"])) exit('Accès refusé');
$l = DBLayer::getLivraison($_GET["id"]);
$v = $l->verger; $p = $v->producteur;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bon de livraison</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript">$(function() { window.print(); });</script>
	</head>
    <body>
        <img src="../../img/logo.png" alt="Logo AGRUR" style="float:left;" />
        <h1 class="clearfix" style="text-align:center; font-family:Arial, sans-serif;">BON DE LIVRAISON</h1>
        <div class="row">
            <div class="col-xs-6">
                <p><strong>Producteur</strong><br />
                <?php echo $p->nom; ?><br />
                <?php echo $p->adresse; ?></p>
            </div>
            <div class="col-xs-6"><strong>Livraison <?php echo $l->id ?></strong></div>
        </div>
        <p><br /></p>
        <table class="table table-bordered"><tbody>
            <tr>
                <th>Verger</th>
                <td><?php echo $v->nom.', '.$v->superficie.' ha, '.$v->commune->nom.($v->commune->aoc ? ' (valide AOC)' : ''); ?></td>
            </tr>
            <tr>
                <th>Variété</th>
                <td><?php echo $v->variete->libelle.($v->variete->aoc ? ' (valide AOC)' : '') ?></td>
            </tr>
            <tr>
                <th>Date d'arrivée</th>
                <td><?php echo $l->date; ?></td>
            </tr>
            <tr>
                <th>Type de produit</th>
                <td><?php echo $l->type; ?></td>
            </tr>
        </tbody></table>
        <p><br /></p>
        <table class="table table-bordered"><tbody>
            <tr><th>Code</th><th>Calibre</th><th>Unités</th></tr>
            <?php foreach(DBLayer::getLotsLivraison($l) as $o) { ?>
                <tr><td><?php echo $o->code; ?></td><td><?php echo $o->calibre; ?></td><td><?php echo $o->quantite; ?></td></tr>
            <?php } ?>
    </body>
</html>
