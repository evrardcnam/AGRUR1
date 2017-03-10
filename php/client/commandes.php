<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_CLIENT) exit('Accès refusé');
$cli = AuthManager::getUser()->client; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Commandes</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-3">Lot</div>
            <div class="col-xs-6 col-sm-3">Conditionnement</div>
            <div class="col-xs-6 col-sm-2">Statut</div>
            <div class="col-xs-6 col-sm-2">Date de cond.</div>
            <div class="col-xs-6 col-sm-2">Date d'envoi</div>
        </div>
        <?php foreach(DBLayer::getCommandesClient($cli) as $c) { ?><div class="row">
            <div class="col-xs-6 col-sm-3"><a href="php/client/bdc.php?id=<?php echo $c->num ?>" target="_blank"><span class="glyphicon glyphicon-print"></span></a> <?php echo $c->lot->code; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $c->cond->libelle; ?></div>
            <div class="col-xs-6 col-sm-2 <?php echo ($c->packaged ? ($c->sent ? 'major' : 'true') : 'false') ?>">
                <?php echo ($c->packaged ? ($c->sent ? 'Expédié' : 'Conditionné') : 'En attente') ?>
            </div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->packaged ? $c->dateCond : '&mdash;'; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->sent ? $c->dateEnvoi : '&mdash;'; ?></div>
        </div><?php } ?>
    </div>
</div>