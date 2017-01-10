<?php require_once "config.php";
if(AuthManager::loginStatus() != U_PRODUCTEUR) exit("Accès refusé");
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Vergers</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-6">Nom</div>
            <div class="col-xs-6 col-sm-3">Variété</div>
            <div class="col-xs-6 col-sm-3">Commune</div>
        </div>
        <?php foreach(DBLayer::getVergersProducteur(AuthManager::getUser()->producteur) as $v) { ?><div class="row">
            <div class="col-xs-12 col-sm-6"><?php echo $v->nom; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $v->libelleVariete; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $v->commune->nom; ?></div>
        </div><?php } ?>
    </div>
</div>