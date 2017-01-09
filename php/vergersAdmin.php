<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé");
if(isset($_GET["delete"])) DBLayer::removeVerger(DBLayer::getVerger(htmlspecialchars_decode($_GET["delete"])));
else if(isset($_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["nomProducteur"], $_POST["libelleVariete"], $_POST["idCommune"])) {
    if(isset($_POST["edit"])) exit(DBLayer::setVerger($_POST["edit"], Verger::fromValues($_POST["edit"], $_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["nomProducteur"], $_POST["libelleVariete"], $_POST["idCommune"])));
    else exit(DBLayer::addVerger(Verger::fromValues(null, $_POST["nom"], $_POST["superficie"], $_POST["arbresParHectare"], $_POST["nomProducteur"], $_POST["libelleVariete"], $_POST["idCommune"])));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Vergers</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editVerger.php" class="slavePage">Ajouter</a></div>
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
            <div class="col-xs-6 col-sm-3"><?php echo $v->nomProducteur; ?></div>
            <div class="col-xs-6 col-sm-5"><?php echo $v->nom; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $v->libelleVariete; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $v->commune->nom; ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/editVerger.php?edit=<?php echo htmlspecialchars($v->id); ?>" class="slavePage">Modifier</a><br />
                <a data-link="php/vergersAdmin.php?delete=<?php echo htmlspecialchars($v->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>