<?php require_once("config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() == U_CLIENT) {
    $c = AuthManager::getUser()->client;
?>
<div class="container">
    <h1><?php echo $c->nom; ?></h1>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Adresse</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $c->adresse; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Responsable des achats</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $c->nomResAchats; ?></div>
    </div>
    <div class="row">
        <div class="col-sm-8"><h1>Commandes en cours</h1></div>
        <div class="col-sm-4 rightlink"><a data-link="php/commandes.php" class="slavePage">Toutes les commandes</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-4">Lot</div>
            <div class="col-xs-5">Conditionnement</div>
            <div class="col-xs-3">Statut</div>
        </div>
        <?php foreach(DBLayer::getCommandesUnsentClient($c) as $com) { ?><div class="row">
            <div class="col-xs-4"><?php echo $com->lot->code; ?></div>
            <div class="col-xs-5"><?php echo $com->cond->libelle; ?></div>
            <div class="col-xs-3 <?php echo ($com->conditioned ? ($com->sent ? 'major' : 'true') : 'false') ?>">
                <?php echo ($com->conditioned ? ($com->sent ? 'Expédié' : 'Conditionné') : 'En attente') ?>
            </div>
        </div><?php } ?>
    </div>
</div>
<?php } else { echo 'Accès refusé'; } ?>