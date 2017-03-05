<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_CLIENT) exit('Accès refusé');
if(!isset($_SESSION["panier"])) $_SESSION["panier"] = array();
if(isset($_GET["action"])) {
    switch($_GET["action"]) {
        case 'add':
            if(isset($_POST["idLot"], $_POST["idConditionnement"])) exit($_SESSION["panier"][$_POST["idLot"]] = $_POST["idConditionnement"]);
            else exit("Paramètre manquant");
            break;
        case 'delete':
            if(isset($_GET["idLot"])) unset($_SESSION["panier"][$_GET["idLot"]]);
            else exit("Paramètre manquant");
            break;
        case 'submit':
            $idClient = AuthManager::getUser()->client->id;
            foreach ($_SESSION["panier"] as $idLot => $idConditionnement) {
                DBLayer::addCommande(Commande::fromValues(null, null, null, $idClient, $idLot, $idConditionnement));
            } $_SESSION["panier"] = array();
            header("Location: commandes.php"); break;
        case 'reset':
            $_SESSION["panier"] = array(); break;
    }
} ?>
<div class="container">
    <?php if(count($_SESSION["panier"]) < 1) { ?>
        <div class="row">
            <div class="col-sm-12"><h1>Panier</h1></div>
        </div>
        <p>Le panier est vide. Consultez les lots disponibles pour en ajouter au panier.</p>
    <?php } else { ?>
        <div class="row">
            <div class="col-sm-6"><h1>Panier</h1></div>
            <div class="col-sm-6 rightlink">
                <a class="sliderPage" data-link="php/client/panier.php?action=reset"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Tout supprimer</button></a>&nbsp;
                <a class="slavePage" data-link="php/client/panier.php?action=submit"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-credit-card"></span> Commander</button></a>
            </div>
        </div><div class="rowtable">
        <div class="row">
            <div class="col-xs-4 col-sm-2">Code</div>
            <div class="col-xs-4 col-sm-2">Calibre</div>
            <div class="col-xs-4 col-sm-2">Quantité</div>
            <div class="col-xs-4 col-sm-2">Variété</div>
            <div class="col-xs-4 col-sm-3">Conditionnement</div>
            <div class="col-xs-4 col-sm-1">Actions</div>
        </div>
        <?php foreach($_SESSION["panier"] as $idLot => $idConditionnement) {
            $l = DBLayer::getLot($idLot); $v = $l->livraison->verger;
        ?><div class="row">
            <div class="col-xs-4 col-sm-2"><?php echo $l->code; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $l->calibre; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $l->quantite; ?></div>
            <div class="col-xs-4 col-sm-2"><?php echo $v->variete->libelle; ?></div>
            <div class="col-xs-4 col-sm-3"><?php echo DBLayer::getConditionnement($idConditionnement)->libelle; ?></div>
            <div class="col-xs-4 col-sm-1" style="text-align:right"><a class="sliderPage" data-link="php/client/panier.php?action=delete&idLot=<?php echo $idLot; ?>"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></a></div>
        </div><?php } ?>

    </div><?php } ?>
</div>