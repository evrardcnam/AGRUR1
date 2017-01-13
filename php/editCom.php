<?php require_once "config.php";
$id = ""; $dateCond = null; $dateEnvoi = null; $idClient = ""; $idCond = ""; $idLot = "";
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $c = DBLayer::getCommande($id);
    $dateCond = $c->dateCond;
    $dateEnvoi = $c->dateEnvoi;
    $idClient = $c->idClient;
    $idCond = $c->idCond;
    $idLot = $c->idLot;
} ?>
<script type="text/javascript" src="js/editCom.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Édition d'une commande</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <input type="hidden" id="id" value="<?php echo $id; ?>" />
        <div class="form-group">
            <label for="comLot" class="col-sm-2 control-label">Lot</label>
            <div class="col-sm-4">
                <select id="comLot" class="form-control">
                    <?php foreach (DBLayer::getLots() as $l) {
                        echo '<option value="' . $l->id . ($l->id == $idLot ? '" selected' : '"') . '>' . $l->code . '</option>';
                    } ?>
                </select>
            </div>
            <label for="comCond" class="col-sm-2 control-label">Conditionnement</label>
            <div class="col-sm-4">
                <select id="comCond" class="form-control">
                    <?php foreach (DBLayer::getConditionnements() as $c) {
                        echo '<option value="' . $c->id . ($c->id == $idCond ? '" selected' : '"') . '>' . $c->libelle . '</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="comClient" class="col-sm-2 control-label">Client</label>
            <div class="col-sm-10">
                <select id="comClient" class="form-control">
                    <?php foreach (DBLayer::getClients() as $c) {
                        echo '<option value="' . $c->id . ($c->id == $idClient ? '" selected' : '"') . '>' . $c->nom . '</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3"><div class="checkbox">
                <label>
                    <input type="checkbox" id="comConditioned" <?php if(!empty($dateCond)) echo "checked"; ?> /> Conditionné
                </label>
            </div></div>
            <label for="comConditionedDate" class="col-sm-3 control-label">Date de conditionnement</label>
            <div class="col-sm-4">
                <input type="date" id="comConditionedDate" class="form-control" value="<?php echo $dateCond; ?>" <?php if(empty($dateCond)) echo "disabled"; ?> />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4"><div class="checkbox">
                <label>
                    <input type="checkbox" id="comSent" <?php if(!empty($dateEnvoi)) echo "checked"; ?> /> Expédié
                </label>
            </div></div>
            <label for="comSentDate" class="col-sm-2 control-label">Date d'expédition</label>
            <div class="col-sm-4">
                <input type="date" id="comSentDate" class="form-control" value="<?php echo $dateEnvoi; ?>" <?php if(empty($dateEnvoi)) echo "disabled"; ?> />
            </div>
        </div>
    </form>
</div>