$(function() {
    $(".rightlink a").on('click', function() {
        if(!$("#oldPass").val()) { showMessage("Erreur de saisie", "Aucun mot de passe actuel n'a été saisi.", "Retour"); return; }
        if(!$("#newPass").val()) { showMessage("Erreur de saisie", "Aucun nouveau mot de passe n'a été saisi.", "Retour"); return; }
        if($("#newPass").val() != $("#newPassConfirm").val()) { showMessage("Erreur de saisie" ,"Le nouveau mot de passe et la confirmation du nouveau mot de passe ne correspondent pas.", "Retour"); return; }
        $.post("php/resetPassword.php", {
            oldPass: $("#oldPass").val(),
            newPass: $("#newPass").val()
        }, function(data) {
            $("#content").html(data);
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});