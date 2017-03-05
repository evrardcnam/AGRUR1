$(function() {
    $(($("#id").val() == "" ? "#slider " : "") + ".rightlink a").on('click', function() {
        if(!$("#livVerger").val()) { showMessage("Erreur de saisie", "Aucun verger de provenance n'a été sélectionné pour la livraison.", "Retour"); return; }
        if(!$("#livType").val()) { showMessage("Erreur de saisie", "Aucun type de produit n'a été saisi pour la livraison.", "Retour"); return; }
        if(!$("#livDate").val()) { showMessage("Erreur de saisie", "Aucune date de livraison n'a été saisie pour la livraison.", "Retour"); return; }
        sent = {
            idVerger: $("#livVerger").val(),
            type: $("#livType").val(),
            date: $("#livDate").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/livraisons.php", sent, function(data) {
            $("#slider").remove();
            showPage('php/livraisons.php');
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});