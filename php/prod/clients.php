<?php require_once "../config.php";
if(AuthManager::loginStatus() != U_PRODUCTEUR) exit("Accès refusé");
$p = AuthManager::getUser()->producteur; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><h1>Clients</h1></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-3">Nom</div>
            <div class="col-xs-12 col-sm-6">Adresse</div>
            <div class="col-xs-12 col-sm-3">Responsable des achats</div>
        </div>
        <?php foreach(DBLayer::getClientsProducteur($p) as $c) { ?>
        <div class="row" data-id="<?php echo htmlspecialchars($c->id); ?>">
            <div class="col-xs-12 col-sm-3"><?php echo $c->nom ?></div>
            <div class="col-xs-12 col-sm-6"><?php echo $c->adresse ?></div>
            <div class="col-xs-12 col-sm-3"><?php echo $c->nomResAchats ?></div>
        </div>
        <?php } ?>
    </div>
</div>