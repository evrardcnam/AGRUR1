<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_PRODUCTEUR) exit('Accès refusé');
$p = AuthManager::getUser()->producteur; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Commandes</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-2">Lot</div>
            <div class="col-xs-6 col-sm-2">Conditionnement</div>
            <div class="col-xs-6 col-sm-2">Client</div>
            <div class="col-xs-6 col-sm-2">Statut</div>
            <div class="col-xs-6 col-sm-2">Date de cond.</div>
            <div class="col-xs-6 col-sm-2">Date d'envoi</div>
        </div>
        <?php foreach(DBLayer::getCommandesProducteur($p) as $c) { ?><div class="row">
            <div class="col-xs-6 col-sm-2"><?php echo $c->lot->code; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->cond->libelle; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->client->nom; ?></div>
            <div class="col-xs-6 col-sm-2 <?php echo ($c->conditioned ? ($c->sent ? 'major' : 'true') : 'false') ?>">
                <?php echo ($c->conditioned ? ($c->sent ? 'Expédié' : 'Conditionné') : 'En attente') ?>
            </div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->conditioned ? $c->dateCond : '&mdash;'; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->sent ? $c->dateEnvoi : '&mdash;'; ?></div>
        </div><?php } ?>
    </div>
</div>