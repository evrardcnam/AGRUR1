<?php require_once("../config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_PRODUCTEUR) exit('Accès refusé');
$p = AuthManager::getUser()->producteur; ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12"><h1>Livraisons</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-3">Verger</div>
            <div class="col-xs-6 col-sm-3">Date de livraison</div>
            <div class="col-xs-6 col-sm-3">Type de produit</div>
            <div class="col-xs-6 col-sm-1">Lots</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getLivraisonsProducteur($p) as $l) { ?><div class="row">
            <div class="col-xs-12 col-sm-3"><a href="php/prod/bdl.php?id=<?php echo $l->id ?>" target="_blank"><span class="glyphicon glyphicon-print"></span></a> <?php echo $l->verger->nom; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $l->date; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $l->type; ?></div>
            <div class="col-xs-6 col-sm-1"><?php echo $l->nbLots; ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/prod/viewLiv.php?id=<?php echo htmlspecialchars($l->id); ?>" class="slavePage"><button type="button" class="btn btn-warning">Détails</button></a><br />
            </div>
        </div><?php } ?>
    </div>
</div>