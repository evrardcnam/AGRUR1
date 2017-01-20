<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé");
if(isset($_GET["delete"])) DBLayer::removeCommande(Commande::fromValues($_GET["delete"], null, null, null, null, null));
else if(isset($_POST["dateConditionnement"], $_POST["dateEnvoi"], $_POST["idClient"], $_POST["idLot"], $_POST["idConditionnement"])) {
    if(isset($_POST["num"])) exit(DBLayer::setCommande(Commande::fromValues($_POST["num"], $_POST["dateConditionnement"], $_POST["dateEnvoi"], $_POST["idClient"], $_POST["idLot"], $_POST["idConditionnement"])));
    else exit(DBLayer::addCommande(Commande::fromValues(null, $_POST["dateConditionnement"], $_POST["dateEnvoi"], $_POST["idClient"], $_POST["idLot"], $_POST["idConditionnement"])));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Commandes</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editCom.php" class="sliderPage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-2">Lot</div>
            <div class="col-xs-6 col-sm-3">Conditionnement</div>
            <div class="col-xs-12 col-sm-3">Client</div>
            <div class="col-xs-6 col-sm-2">Statut</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getCommandes() as $c) { ?><div class="row">
            <div class="col-xs-6 col-sm-2"><?php echo $c->lot->code; ?></div>
            <div class="col-xs-6 col-sm-3"><?php echo $c->cond->libelle; ?></div>
            <div class="col-xs-12 col-sm-3"><?php echo $c->client->nom; ?></div>
            <div class="col-xs-6 col-sm-2 <?php echo ($c->conditioned ? ($c->sent ? 'major' : 'true') : 'false') ?>">
                <?php echo ($c->conditioned ? ($c->sent ? 'Expédié' : 'Conditionné') : 'En attente') ?>
            </div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/editCom.php?edit=<?php echo htmlspecialchars($c->num); ?>" class="sliderPage">Modifier</a><br />
                <a data-link="php/commandes.php?delete=<?php echo htmlspecialchars($c->num); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>