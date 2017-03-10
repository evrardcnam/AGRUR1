<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if((AuthManager::loginStatus() != U_CLIENT && AuthManager::loginStatus() != U_ADMIN) || !isset($_GET["id"])) exit('Accès refusé');
$c = DBLayer::getCommande($_GET["id"]);
$cli = $c->client; $lot = $c->lot; $liv = $lot->livraison; $v = $liv->verger; $p = $v->producteur;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bon de commande</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript">$(function() { window.print(); });</script>
	</head>
    <body>
        <img src="../../img/logo.png" alt="Logo AGRUR" style="float:left;" />
        <h1 class="clearfix" style="text-align:center; font-family:Arial, sans-serif;">BON DE COMMANDE</h1>
        <div class="row">
            <div class="col-xs-6">
                <p><strong>Producteur</strong><br />
                <?php echo $p->nom; ?><br />
                <?php echo $p->adresse; ?></p>
            </div>
            <div class="col-xs-6">
                <p><strong>Destinataire</strong><br />
                <?php echo $cli->nomResAchats; ?><br />
                <?php echo $cli->nom; ?><br />
                <?php echo $cli->adresse; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6"><strong>Commande <?php echo $c->num; ?></strong></div>
            <div class="col-xs-6"><strong>Lot <?php echo $lot->code ?></strong></div>
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
                <th>Calibre</th>
                <td><?php echo $lot->calibre; ?></td>
            </tr>
            <tr>
                <th>Unités</th>
                <td><?php echo $lot->quantite; ?></td>
            </tr>
            <tr>
                <th>Date d'arrivée</th>
                <td><?php echo $liv->date; ?></td>
            </tr>
            <tr>
                <th>Type de produit</th>
                <td><?php echo $liv->type; ?></td>
            </tr>
            <tr>
                <th>Conditionnement</th>
                <td><?php echo $c->cond->libelle; ?></td>
            </tr>
        </tbody></table>
        <p><br /></p>
        <table class="table table-bordered"><tbody>
            <tr>
                <th class="col-sm-3">Statut</th>
                <th class="col-sm-3">Validé par</th>
                <th class="col-sm-3">Validé le</th>
                <th class="col-sm-3">Signature</th>
            </tr>
            <tr><td>Conditionnement</td><td></td><td></td><td></td></tr>
            <tr><td>Expédition</td><td></td><td></td><td></td></tr>
        </tbody></table>
    </body>
</html>
