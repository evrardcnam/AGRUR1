<?php require_once("config.php"); header('Content-Type: text/html; charset=utf-8');
if(AuthManager::loginStatus() == U_PRODUCTEUR) {
    $p = AuthManager::getUser()->producteur;
?>
<div class="container">
    <h1><?php echo $p->nom; ?></h1>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Adresse</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $p->adresse; ?></div>
    </div>
    <div class="row datarow">
        <div class="col-xs-12 col-sm-2 name">Adhérent</div>
        <div class="col-xs-12 col-sm-10 value"><?php echo $p->adherent ? "Depuis le " . $p->dateAdhesion : "Non"; ?></div>
    </div>
    <h2>Mes certifications</h2>
    <ul>
        <?php foreach(DBLayer::getCertificationsValidees($p) as $c) { ?>
            <li><?php echo $c->libelle . " (obtenu le " . $c->date . ")"; ?></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>