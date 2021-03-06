<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé"); ?>
<script type="text/javascript" src="js/varietes.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Variétés</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-9">Nom</div>
            <div class="col-xs-6 col-sm-1">A.O.C.</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getVarietes() as $v) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($v->id); ?>">
            <div class="col-xs-12 col-sm-9"><?php echo $v->libelle; ?></div>
            <div class="col-xs-6 col-sm-1 <?php echo $v->aoc ? 'true' : 'false'; ?>"><span class="glyphicon glyphicon-<?php echo $v->aoc ? "ok" : "remove"; ?>"></span></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" data-id="<?php echo htmlspecialchars($v->id); ?>" class="edit">Modifier</a><br />
                <a href="#" data-id="<?php echo htmlspecialchars($v->id); ?>" class="delete danger">Supprimer</a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-9"><input type="text" id="newLabel" class="form-control" required></div>
            <div class="col-xs-6 col-sm-1"><input type="checkbox" id="newAoc" class="form-control" required></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" id="add">Insérer</a><br />
            </div>
        </div>
    </div>
</div>