$(function() {
    $(".rightlink a").on('click', function() {
        if($("#newPass").val() != $("#newPassConfirm").val()) {
            console.log('nope');
            showMessage("Erreur" ,"Le nouveau mot de passe et la confirmation du nouveau mot de passe ne correspondent pas.", "Retour");
            console.log('end');
            return; }
        console.log('send');
        sent = {
            oldPass: $("#oldPass").val(),
            newPass: $("#newPass").val()
        }
        $.post("php/resetPassword.php", sent, function(data) {
            $("#content").html(data);
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});