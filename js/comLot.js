$(function() {
    $("#slider .rightlink a").on('click', function() {
        if(!$("#comCond").val()) { showMessage("Erreur de saisie", "Aucun conditionnement n'a été sélectionné pour la commande.", "Retour"); return; }
        sent = {
            idLot: $("#idLot").val(),
            idConditionnement: $("#comCond").val()
        }
        $.post("php/client/comLot.php", sent, function(data) {
            $("#slider").remove();
            showPage('php/client/commandes.php');
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});