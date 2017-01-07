<?php require_once "config.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Certifications</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-10">Nom</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getCertifications() as $c) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($c->id); ?>">
            <div class="col-xs-12 col-sm-10"><?php echo $c->libelle; ?></div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" data-id="<?php echo htmlspecialchars($c->id); ?>" class="edit">Modifier</a><br />
                <a href="#" data-id="<?php echo htmlspecialchars($c->id); ?>" class="delete danger">Supprimer</a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-10"><input type="text" id="newLabel" class="form-control" required></div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="add">Insérer</a><br />
            </div>
        </div>
    </div>
</div>