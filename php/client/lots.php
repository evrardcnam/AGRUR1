<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(!AuthManager::loginStatus()) exit('Accès refusé'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Lots disponibles</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-4 col-sm-2">Code</div>
            <div class="col-xs-4 col-sm-2">Calibre</div>
            <div class="col-xs-4 col-sm-2">Quantité</div>
            <div class="col-xs-4 col-sm-2">Variété</div>
            <div class="col-xs-4 col-sm-2">Commune</div>
            <div class="col-xs-4 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getLotsStock() as $l) {
            $v = $l->livraison->verger;
            ?><div class="row">
            <div class="col-xs-4 col-sm-2"><?php echo $l->code; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $l->calibre; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $l->quantite; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $v->variete->libelle; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $v->commune->nom; ?></div>
            <div class="col-xs-4 col-sm-2"><a class="sliderPage" data-link="php/client/comLot.php?id=<?php echo $l->id; ?>"><button type="button" class="btn btn-warning">Commander</button></a></div>
        </div><?php } ?>
    </div>
</div>