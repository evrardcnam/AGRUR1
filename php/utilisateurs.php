<?php require_once "config.php";
if(AuthManager::loginStatus() != U_ADMIN) exit("Accès refusé");
if(isset($_GET["delete"])) DBLayer::removeUtilisateur(DBLayer::getUtilisateurId(htmlspecialchars_decode($_GET["delete"])));
else if(isset($_POST["nom"], $_POST["pass"], $_POST["role"], $_POST["idProducteur"], $_POST["idClient"])) {
    if(isset($_POST["id"])) exit(DBLayer::setUtilisateur(Utilisateur::fromValues($_POST["id"], $_POST["nom"], $_POST["role"], $_POST["idProducteur"], $_POST["idClient"]), $_POST["pass"])); 
    else exit(DBLayer::addUtilisateur(Utilisateur::fromValues(null, $_POST["nom"], $_POST["role"], $_POST["idProducteur"], $_POST["idClient"]), $_POST["pass"]));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Utilisateurs</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editUser.php" class="sliderPage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-6">Pseudonyme</div>
            <div class="col-xs-6 col-sm-4">Rôle</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
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
                <a data-link="php/editUser.php?edit=<?php echo htmlspecialchars($u->id); ?>" class="sliderPage">Modifier</a><br />
                <a data-link="php/utilisateurs.php?delete=<?php echo htmlspecialchars($u->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>