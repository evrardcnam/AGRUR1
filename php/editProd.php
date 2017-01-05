<?php require_once "config.php";
$nom = ""; $adresse = ""; $adherent = false; $dateAdh = ""; $idUser = "NULL";
if(isset($_GET['edit'])) {
    $nom = htmlspecialchars_decode($_GET['edit']);
    $p = DBLayer::getProducteur($nom);
    $adresse = $p->adresse;
    $adherent = $p->adherent;
    $dateAdh = $p->dateAdhesion;
    $idUser = $p->idUser;
} ?>
<script type="text/javascript" src="js/editProd.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Édition d'un producteur</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <input type="hidden" id="oldName" name="edit" value="<?php echo $nom; ?>" />
        <input type="hidden" id="idUser" name="idUser" value="<?php echo $idUser; ?>" />
        <div class="form-group">
            <label for="prodName" class="col-sm-1 control-label">Nom</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="prodName" placeholder="Nom du producteur" required value="<?php echo $nom; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="prodAddress" class="col-sm-1 control-label">Adresse</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="prodAddress" placeholder="Adresse du producteur" required value="<?php echo $adresse; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-5"><div class="checkbox">
                <label>
                    <input type="checkbox" id="prodAdh" <?php if($adherent) echo "checked"; ?> /> Adhérent
                </label>
            </div></div>
            <label for="prodAdhDate" class="col-sm-2 control-label">Date d'adhésion</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="prodAdhDate" placeholder="Date d'adhésion" value="<?php echo $dateAdh; ?>" <?php if(!$adherent) echo "disabled"; ?>>
            </div>
        </div>
    </form>
</div>