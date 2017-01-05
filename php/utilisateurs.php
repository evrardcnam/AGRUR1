<?php require_once "config.php";
if(isset($_GET["delete"])) DBLayer::removeUtilisateur(DBLayer::getUtilisateurId(htmlspecialchars_decode($_GET["delete"])));
else if(isset($_POST["nom"], $_POST["pass"], $_POST["admin"], $_POST["nomProducteur"])) {
    if(isset($_POST["id"])) exit(DBLayer::setUtilisateur(Utilisateur::fromValues($_POST["id"], $_POST["nom"], $_POST["admin"] == "true", $_POST["nomProducteur"]), $_POST["pass"])); 
    else exit(DBLayer::addUtilisateur(Utilisateur::fromValues(null, $_POST["nom"], $_POST["admin"] == "true", $_POST["nomProducteur"]), $_POST["pass"]));
}
header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Utilisateurs</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="php/editUser.php" class="slavePage">Ajouter</a></div>
    </div>
    <div class="rowtable">
        <div class="row">
            <div class="col-xs-12 col-sm-7">Nom</div>
            <div class="col-xs-6 col-sm-3">Associé à</div>
            <div class="col-xs-6 col-sm-2">Actions</div>
        </div>
        <?php foreach(DBLayer::getUtilisateurs() as $u) { ?><div class="row">
            <div class="col-xs-12 col-sm-7"><?php echo $u->nom; ?></div>
            <div class="col-xs-6 col-sm-3 <?php echo $u->admin ? 'major' : ($u->nomProducteur == null ? 'false' : 'true'); ?>"><?php echo $u->admin ? 'Administrateur' : ($u->nomProducteur ?: 'Aucun'); ?></div>
            <div class="col-xs-6 col-sm-2">
                <a data-link="php/editUser.php?edit=<?php echo htmlspecialchars($u->id); ?>" class="slavePage">Modifier</a><br />
                <a data-link="php/utilisateurs.php?delete=<?php echo htmlspecialchars($u->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>