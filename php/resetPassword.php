<?php require_once "config.php";
if(AuthManager::loginStatus() == false) exit('Accès refusé');
if(isset($_POST['oldPass'], $_POST['newPass'])) {
    if(!AuthManager::getUser()->checkPassword($_POST['oldPass'])) exit('Le mot de passe actuel saisi est incorrect. <a class="slavePage" data-link="resetPassword.php">Réessayer</a>');
    DBLayer::setUtilisateur(AuthManager::getUser(), $_POST["newPass"]);
    exit('Mot de passe modifié avec succès.');
} ?>
<script type="text/javascript" src="js/resetPassword.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-10"><h1>Modification du mot de passe</h1></div>
        <div class="col-sm-2 rightlink"><a href="#">Enregistrer</a></div>
    </div>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="prodAddress" class="col-sm-3 control-label">Mot de passe actuel</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="oldPass" placeholder="Mot de passe actuel" required>
            </div>
        </div><div class="form-group">
            <label for="prodAddress" class="col-sm-3 control-label">Nouveau mot de passe</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="newPass" placeholder="Nouveau mot de passe" required>
            </div>
        </div><div class="form-group">
            <label for="prodAddress" class="col-sm-3 control-label">Confirmer le mot de passe</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="newPassConfirm" placeholder="Confirmation du mot de passe" required>
            </div>
        </div>
    </form>
</div>