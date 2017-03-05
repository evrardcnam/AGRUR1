<?php require_once "config.php";
if(AuthManager::loginStatus() == false) exit('Accès refusé');
if(isset($_POST['oldPass'], $_POST['newPass'])) {
    if(!AuthManager::getUser()->checkPassword($_POST['oldPass'])) { echo "<script type=\"text/javascript\">$(function() { showMessage(\"Erreur de saisie\", \"Le mot de passe actuel saisi est incorrect.\", \"Retour\"); });</script>"; return; }
    DBLayer::setUtilisateur(AuthManager::getUser(), $_POST["newPass"]);
    echo "<script type=\"text/javascript\">$(function() { showMessage(\"Réussite\", \"Votre mot de passe a été modifié.\", \"Retour\"); });</script>";
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