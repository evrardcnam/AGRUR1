<?php require_once "config.php";
if(isset($_GET["delete"])) DBLayer::removeLivraison(DBLayer::getLivraison(htmlspecialchars_decode($_GET["delete"])));
else if(isset($_POST["idVerger"], $_POST["type"], $_POST["date"])) {
    if(isset($_POST["id"])) exit(DBLayer::setLivraison(Livraison::fromValues($_POST["id"], $_POST["date"], $_POST["type"], null, $_POST["idVerger"]))); 
    else exit(DBLayer::addLivraison(Livraison::fromValues(null, $_POST["date"], $_POST["type"], null, $_POST["idVerger"])));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Livraisons</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editLiv.php" class="sliderPage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-3">Verger</div>
            <div class="col-xs-6 col-sm-3">Date de livraison</div>
            <div class="col-xs-6 col-sm-3">Type de produit</div>
            <div class="col-xs-6 col-sm-1">Lots</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getLivraisons() as $l) { ?><div class="row">
            <div class="col-xs-12 col-sm-3"><a href="php/prod/bdl.php?id=<?php echo $l->id ?>" target="_blank"><span class="glyphicon glyphicon-print"></span></a> <?php echo $l->verger->nom; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $l->date; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $l->type; ?></div>
            <div class="col-xs-6 col-sm-1"><?php echo $l->nbLots; ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/editLiv.php?edit=<?php echo htmlspecialchars($l->id); ?>" class="slavePage">Modifier</a><br />
                <a data-link="php/livraisons.php?delete=<?php echo htmlspecialchars($l->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>