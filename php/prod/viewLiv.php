<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_PRODUCTEUR) exit('Accès refusé');
if(!isset($_GET['id'])) exit('Paramètre manquant');
$p = AuthManager::getUser()->producteur;
$l = DBLayer::getLivraison($_GET['id']);
if($l->verger->idProducteur != $p->id) exit('Accès refusé'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Livraison</h1></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Verger</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->verger->nom; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Date de livraison</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->date; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Type de produit</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->type; ?></div>
    </div>
    <h2>Lots</h2>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-3">Code</div>
            <div class="col-xs-6 col-sm-3">Calibre</div>
            <div class="col-xs-6 col-sm-3">Quantité</div>
            <div class="col-xs-6 col-sm-3">Statut</div>
        </div>
        <?php foreach(DBLayer::getLotsLivraison($l) as $o) {
            $class = 'false'; $text = 'En attente'; $c = DBLayer::getCommandeLot($o);
            if(isset($c)) { $class = $c->sent ? 'major' : 'true';
                $text = $c->packaged ? ($c->sent ? 'Expédié' : 'Conditionné') : 'Commandé'; } ?>
        <div class="row">
            <div class="col-xs-6 col-sm-3"><?php echo $o->code; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $o->calibre; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $o->quantite; ?></div>
            <div class="col-xs-6 col-sm-3 <?php echo $class ?>"><?php echo $text ?></div>
        </div>
        <?php } ?>
    </div>
</div>