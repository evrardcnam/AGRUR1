<?php require_once "config.php";
if(isset($_GET["user"])) {
    if(AuthManager::forceLogin(DBLayer::getUtilisateurId($_GET['user']))) {
        switch(AuthManager::loginStatus()) {
            case U_ADMIN: header("Location: ../masterAdmin.php"); break;
            case U_PRODUCTEUR: header("Location: ../masterProd.php"); break;
            case U_CLIENT: header("Location: ../masterClient.php"); break;
            default: header("Location: ../index.php"); break;
        }
        exit();
    }
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12"><h1>Changer d'utilisateur</h1></div>
    </div>
    <p>Le changement d'utilisateur permet à un administrateur de se connecter en tant que quelqu'un d'autre sans avoir recours à un mot de passe, par exemple à des fins de support technique ou de contrôle de permissions. <strong>Attention !</strong> Si le nouvel utilisateur n'est pas administrateur, il sera nécessaire de se déconnecter puis de se reconnecter pour retourner au compte administrateur.</p>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-6">Pseudonyme</div>
            <div class="col-xs-6 col-sm-4">Rôle</div>
            <div class="col-xs-6 col-sm-2">Action</div>
        </div>
        <?php foreach(DBLayer::getUtilisateurs() as $u) { ?><div class="row">
            <div class="col-xs-12 col-sm-6"><?php echo $u->nom; ?></div>
            <div class="col-xs-6 col-sm-4 <?php echo $u->role == 'admin' ? 'major' : ($u->idProducteur == null && $u->idClient == null ? 'false' : 'true'); ?>">
                <?php switch($u->role) {
                    case 'admin': echo 'Administrateur'; break;
                    case 'producteur': echo 'Producteur (' . $u->producteur->nom . ')'; break;
                    case 'client': echo 'Client (' . $u->client->nom . ')'; break;
                    default: echo 'Aucun'; break;
                } ?>
            </div><div class="col-xs-6 col-sm-2">
                <a href="php/changeUser.php?user=<?php echo $u->id; ?>"><button type="button" class="btn btn-warning">Se connecter</button></a>
            </div>
        </div><?php } ?>
    </div>
</div>