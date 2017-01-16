<?php require_once("..\config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() != U_CLIENT) exit('Accès refusé');
if(isset($_POST["idLot"], $_POST["idConditionnement"]))
    exit(DBLayer::addCommande(Commande::fromValues(null, null, null, AuthManager::getUser()->client->id, $_POST["idLot"], $_POST["idConditionnement"])));
else if(!isset($_GET["id"])) exit("Paramètre manquant");
$l = DBLayer::getLot($_GET["id"]);
$v = $l->livraison->verger;
?>
<script type="text/javascript" src="js/comLot.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Lot <?php echo $l->code; ?></h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Commander</a></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Variété</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $v->variete->libelle; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Calibre</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->calibre; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Quantité</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->quantite; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Date d'arrivée</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->livraison->date; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Type de produit</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $l->livraison->type; ?></div>
    </div>
    <h2>Origine</h2>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Producteur</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $v->producteur->nom . ' &mdash; ' . $v->producteur->adresse; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Verger</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $v->nom . ', ' . $v->superficie . ' hectares'; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Commune</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $v->commune->nom; ?></div>
    </div>
    <h2>Commande</h2>
    <form class="form-horizontal">
        <input type="hidden" id="idLot" value="<?php echo $l->id; ?>" />
        <div class="form-group">
            <label for="comCond" class="col-sm-2 control-label">Conditionnement</label>
            <div class="col-sm-4">
                <select id="comCond" class="form-control">
                    <?php foreach (DBLayer::getConditionnements() as $c) {
                        echo '<option value="' . $c->id . ($c->id == $idCond ? '" selected' : '"') . '>' . $c->libelle . '</option>';
                    } ?>
                </select>
            </div>
        </div>
    </form>
</div>