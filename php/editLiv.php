<?php require_once "config.php";
$id = ""; $idVerger = null; $typeProduit = ""; $dateLiv = ""; $qteLivree = 0;
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $l = DBLayer::getLivraison($id);
    $idVerger = $l->idVerger;
    $qteLivree = $l->quantite;
    $dateLiv = $l->date;
    $typeProduit = $l->type;
} ?>
<script type="text/javascript" src="js/editLiv.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Édition d'une livraison</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <input type="hidden" id="id" value="<?php echo $id; ?>" />
        <div class="form-group">
            <label for="livVerger" class="col-sm-2 control-label">Verger</label>
            <div class="col-sm-10">
                <select id="livVerger" class="form-control">
                    <?php foreach (DBLayer::getVergers() as $v) {
                        echo '<option value="' . $v->id . ($v->id == $idVerger ? '" selected' : '"') . '>' . $v->nom . " (" . $v->nomProducteur . ')</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="livType" class="col-sm-2 control-label">Type de produit</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="livType" placeholder="Type de produit" required value="<?php echo $typeProduit; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="livDate" class="col-sm-2 control-label">Date de livraison</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="livDate" placeholder="Date de livraison" value="<?php echo $dateLiv; ?>" />
            </div>
            <label for="livQte" class="col-sm-2 control-label">Quantité livrée</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="livQte" placeholder="Quantité livrée" min="1" value="<?php echo $qteLivree; ?>" />
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xs-12"><h2>Lots</h2></div>
    </div>
    <?php if(isset($_GET['edit'])) { ?>
    <script type="text/javascript" src="js/editLot.js"></script>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-4">Code</div>
            <div class="col-xs-6 col-sm-6">Calibre</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getLotsLivraison($l) as $o) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($o->code); ?>">
            <div class="col-xs-6 col-sm-4"><?php echo $o->code; ?></div>
            <div class="col-xs-6 col-sm-6"><?php echo $o->calibre; ?></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" data-id="<?php echo htmlspecialchars($o->code); ?>" class="edit">Modifier</a>
                <a href="#" data-id="<?php echo htmlspecialchars($o->code); ?>" class="delete danger">Supprimer</a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-6 col-sm-4"><input type="text" id="lotCode" class="form-control" required></div>
            <div class="col-xs-6 col-sm-6"><input type="text" id="lotCalibre" class="form-control" required></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" id="add">Insérer</a><br />
            </div>
        </div>
    </div>
    <?php } else { ?><p>Enregistrez la livraison et rouvrez-la en modification pour pouvoir ajouter des lots.</p><?php } ?>
</div>