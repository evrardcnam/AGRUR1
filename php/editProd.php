<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé");
$id = ""; $nom = ""; $adresse = ""; $adherent = false; $dateAdh = ""; $idUser = "NULL";
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $p = DBLayer::getProducteur($id);
    $nom = $p->nom;
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
        <input type="hidden" id="id" name="edit" value="<?php echo $id; ?>" />
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
    <div class="row">
        <div class="col-xs-12"><h2>Certifications validées</h2></div>
    </div>
    <?php if(isset($_GET['edit'])) { ?>
    <script type="text/javascript" src="js/editCertObtenue.js"></script>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-8">Nom</div>
            <div class="col-xs-6 col-sm-2">Date d'obtention</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getCertificationsValidees($p) as $c) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($c->id); ?>">
            <div class="col-xs-12 col-sm-8"><?php echo $c->libelle; ?></div>
            <div class="col-xs-6 col-sm-2"><?php echo $c->date; ?></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" data-id="<?php echo htmlspecialchars($c->id); ?>" class="delete danger">Supprimer</a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-8"><select id="valCert" class="form-control">
            <?php foreach (DBLayer::getCertifications() as $c) {
                echo '<option value="' . $c->id . '">' . $c->libelle . '</option>';
            } ?>
            </select></div>
            <div class="col-xs-6 col-sm-2"><input type="date" id="valDate" class="form-control" required></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" id="add">Insérer</a><br />
            </div>
        </div>
    </div>
    <?php } else { ?><p>Enregistrez le producteur et rouvrez-le en modification pour pouvoir valider des certifications.</p><?php } ?>
</div>