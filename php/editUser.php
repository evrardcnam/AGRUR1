<?php require_once "config.php";
$id = ""; $nom = ""; $admin = false; $idProd = "";
if(isset($_GET['edit'])) {
    $id = htmlspecialchars_decode($_GET['edit']);
    $u = DBLayer::getUtilisateurId($id);
    $nom = $u->nom;
    $admin = $u->admin;
    $idProd = $u->idProducteur;
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
            <div class="col-sm-offset-2 col-sm-3"><div class="checkbox">
                <label>
                    <input type="checkbox" id="userAdmin" <?php if($admin) echo "checked"; ?> /> Administrateur
                </label>
            </div></div>
            <label for="userProd" class="col-sm-3 control-label">Producteur associé</label>
            <div class="col-sm-4">
                <select id="userProd" class="form-control" <?php if($admin) echo "disabled"; ?>>
                    <?php foreach (DBLayer::getProducteurs() as $p) {
                        echo '<option value="' . $p->id . ($p->id == $idProd ? '" selected' : '"') . '>' . $p->nom . '</option>';
                    } ?>
                </select>
            </div>
        </div>
    </form>
</div>