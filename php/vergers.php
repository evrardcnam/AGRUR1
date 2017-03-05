<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé");
if(isset($_GET["delete"])) DBLayer::removeVerger(DBLayer::getVerger(htmlspecialchars_decode($_GET["delete"])));
else if(isset($_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["idProducteur"], $_POST["idVariete"], $_POST["idCommune"])) {
    if(isset($_POST["id"])) exit(DBLayer::setVerger(Verger::fromValues($_POST["id"], $_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["idProducteur"], $_POST["idVariete"], $_POST["idCommune"])));
    else exit(DBLayer::addVerger(Verger::fromValues(null, $_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["idProducteur"], $_POST["idVariete"], $_POST["idCommune"])));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Vergers</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editVerger.php" class="sliderPage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-3">Producteur</div>
            <div class="col-xs-6 col-sm-3">Nom</div>
            <div class="col-xs-6 col-sm-2">Variété</div>
            <div class="col-xs-6 col-sm-2">Commune</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getVergers() as $v) { ?><div class="row">
            <div class="col-xs-6 col-sm-3"><?php echo $v->producteur->nom; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $v->nom; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $v->variete->libelle; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo DBLayer::getCommuneVerger($v)->nom; ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/editVerger.php?edit=<?php echo htmlspecialchars($v->id); ?>" class="sliderPage">Modifier</a><br />
                <a data-link="php/vergers.php?delete=<?php echo htmlspecialchars($v->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>