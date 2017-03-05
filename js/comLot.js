$(function() {
    $("#slider .rightlink button.btn-success").on('click', function() { // Commander
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
    $("#slider .rightlink button.btn-primary").on('click', function() { // Ajouter au panier
        if(!$("#comCond").val()) { showMessage("Erreur de saisie", "Aucun conditionnement n'a été sélectionné pour la commande.", "Retour"); return; }
        sent = {
            idLot: $("#idLot").val(),
            idConditionnement: $("#comCond").val()
        }
        $.post("php/client/panier.php?action=add", sent, function(data) {
            $("#slider").remove();
            showSlider('php/client/panier.php');
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'ajout dans le panier. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});