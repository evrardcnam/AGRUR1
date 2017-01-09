<?php require_once "config.php";
$id = ""; $nom = ""; $superficie = 0; $arbresParHectare = 0; $nomProducteur = ""; $libelleVariete = ""; $idCommune = "";
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $v = DBLayer::getVerger($id);
    $nom = $v->nom;
    $superficie = $v->superficie;
    $arbresParHectare = $v->arbresParHectare;
    $nomProducteur = $v->nomProducteur;
    $libelleVariete = $v->libelleVariete;
    $idCommune = $v->idCommune;
} ?>
<script type="text/javascript" src="js/editVerger.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Édition d'un verger</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <input type="hidden" id="id" value="<?php echo $id; ?>" />
        <div class="form-group">
            <label for="verProd" class="col-sm-2 control-label">Producteur</label>
            <div class="col-sm-10">
                <select id="verProd" class="form-control">
                    <?php foreach (DBLayer::getProducteurs() as $p) {
                        echo '<option value="' . $p->nom . ($p->nom == $nomProducteur ? '" selected' : '"') . '>' . $p->nom . '</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="verName" class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="verName" placeholder="Nom du verger" required value="<?php echo $nom; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="verSup" class="col-sm-2 control-label">Superficie</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="verSup" placeholder="Superficie (hectares)" required min="0" value="<?php echo $superficie; ?>">
            </div>
            <label for="verArbres" class="col-sm-2 control-label">Arbres par ha</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="verArbres" placeholder="Arbres par hectare" required min="0" value="<?php echo $arbresParHectare; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="verVar" class="col-sm-2 control-label">Variété</label>
            <div class="col-sm-4">
                <select id="verVar" class="form-control">
                    <?php foreach (DBLayer::getVarietes() as $v) {
                        echo '<option value="' . $v->libelle . ($v->libelle == $libelleVariete ? '" selected' : '"') . '>' . $v->libelle . '</option>';
                    } ?>
                </select>
            </div>
            <label for="verCom" class="col-sm-2 control-label">Commune</label>
            <div class="col-sm-4">
                <select id="verCom" class="form-control">
                    <?php foreach (DBLayer::getCommunes() as $c) {
                        echo '<option value="' . $c->id . ($c->id == $idCommune ? '" selected' : '"') . '>' . $c->nom . '</option>';
                    } ?>
                </select>
            </div>
        </div>
    </form>
</div>