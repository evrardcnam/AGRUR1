<?php require_once "config.php"; header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Producteurs</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="editProd.php" class="slavePage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-6 col-sm-3">Nom</div>
            <div class="col-xs-6 col-sm-5">Adresse</div>
            <div class="col-xs-6 col-sm-2">Adhésion</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getProducteurs() as $p) { ?><div class="row">
            <div class="col-xs-6 col-sm-3"><?php echo $p->nom; ?></div>
            <div class="col-xs-6 col-sm-5"><?php echo $p->adresse; ?></div>
            <div class="col-xs-6 col-sm-2 <?php echo $p->adherent ? "true" : "false"; ?>"><?php echo ($p->adherent ? $p->dateAdhesion : "Non"); ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="editProd.php?edit=<?php echo htmlspecialchars($p->nom); ?>" class="slavePage">Modifier</a><br />
                <a data-link="editProd.php?delete=<?php echo htmlspecialchars($p->nom); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>