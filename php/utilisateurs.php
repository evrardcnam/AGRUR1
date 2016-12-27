<?php require_once "config.php"; header('Content-Type: text/html; charset=utf-8'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Utilisateurs</h1></div>
        <div class="col-sm-2 rightlink"><a data-link="editUser.php" class="slavePage">Ajouter</a></div>
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
                <a data-link="editUser.php?edit=<?php echo htmlspecialchars($u->id); ?>" class="slavePage">Modifier</a><br />
                <a data-link="editUser.php?delete=<?php echo htmlspecialchars($u->id); ?>" class="slavePage danger">Supprimer</a>
            </div>
        </div><?php } ?>
    </div>
</div>