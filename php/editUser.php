<?php require_once "config.php";
$id = ""; $nom = ""; $role = ""; $idProd = ""; $idClient = "";
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $u = DBLayer::getUtilisateurId($id);
    $nom = $u->nom;
    $role = $u->role;
    $idProd = $u->idProducteur;
    $idClient = $u->idClient;
} ?>
<script type="text/javascript" src="js/editUser.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Édition d'un utilisateur</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <input type="hidden" id="id" value="<?php echo $id; ?>" />
        <div class="form-group">
            <label for="userName" class="col-sm-2 control-label">Pseudonyme</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="userName" placeholder="Pseudonyme" required value="<?php echo $nom; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="prodAddress" class="col-sm-2 control-label">Mot de passe</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="userPass" placeholder="Mot de passe">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3"><div class="radio"><label>
                <input type="radio" name="userRole" id="userIsAdmin" value="admin" <?php if($role == "" || $role == 'admin') echo "checked"; ?> /> Administrateur
            </label></div><div class="radio"><label>
                <input type="radio" name="userRole" id="userIsProd" value="producteur" <?php if($role == 'producteur') echo "checked"; ?> /> Producteur
            </label></div><div class="radio"><label>
                <input type="radio" name="userRole" id="userIsClient" value="client" <?php if($role == 'client') echo "checked"; ?> /> Client
            </label></div></div>
        </div>
        <div class="form-group">
            <label for="userProd" class="col-sm-3 control-label">Producteur associé</label>
            <div class="col-sm-3">
                <select id="userProd" class="form-control" <?php if($role != 'producteur') echo "disabled"; ?>>
                    <?php foreach (DBLayer::getProducteurs() as $p) {
                        echo '<option value="' . $p->id . ($p->id == $idProd ? '" selected' : '"') . '>' . $p->nom . '</option>';
                    } ?>
                </select>
            </div>
            <label for="userClient" class="col-sm-3 control-label">Client associé</label>
            <div class="col-sm-3">
                <select id="userClient" class="form-control" <?php if($role != 'client') echo "disabled"; ?>>
                    <?php foreach (DBLayer::getClients() as $c) {
                        echo '<option value="' . $c->id . ($c->id == $idClient ? '" selected' : '"') . '>' . $c->nom . '</option>';
                    } ?>
                </select>
            </div>
        </div>
    </form>
</div>