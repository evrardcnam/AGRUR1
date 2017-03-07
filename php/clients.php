<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé"); ?>
<script type="text/javascript" src="js/clients.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Clients</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-3">Nom</div>
            <div class="col-xs-12 col-sm-4">Adresse</div>
            <div class="col-xs-12 col-sm-3">Responsable des achats</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getClients() as $c) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($c->id); ?>">
            <div class="col-xs-12 col-sm-3"><?php echo $c->nom ?></div>
            <div class="col-xs-12 col-sm-4"><?php echo $c->adresse ?></div>
            <div class="col-xs-12 col-sm-3"><?php echo $c->nomResAchats ?></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" data-id="<?php echo htmlspecialchars($c->id); ?>" class="edit">Modifier</a><br />
                <a href="#" data-id="<?php echo htmlspecialchars($c->id); ?>" class="delete danger">Supprimer</a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-xs-12 col-sm-3"><input type="text" id="newName" class="form-control" required></div>
            <div class="col-xs-12 col-sm-4"><input type="text" id="newAddress" class="form-control" required></div>
            <div class="col-xs-12 col-sm-3"><input type="text" id="newResp" class="form-control" required></div>
            <div class="col-xs-6 col-sm-2 actions">
                <a href="#" id="add">Insérer</a><br />
            </div>
        </div>
    </div>
</div>