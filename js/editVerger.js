$(function() {
    $("#slider .rightlink a").on('click', function() {
        if(!$("#verName").val()) { showMessage("Erreur de saisie", "Aucun nom de verger n'a été saisi.", "Retour"); return; }
        if(!$("#verSup").val()) { showMessage("Erreur de saisie", "Aucune superificie n'a été saisie.", "Retour"); return; }
        if(!$("#verArbres").val()) { showMessage("Erreur de saisie", "Aucune densité d'arbres n'a été saisie.", "Retour"); return; }
        if(!$("#verProd").val()) { showMessage("Erreur de saisie", "Aucun producteur n'a été sélectionné comme propriétaire.", "Retour"); return; }
        if(!$("#verVar").val()) { showMessage("Erreur de saisie", "Aucue variété n'a été sélectionnée.", "Retour"); return; }
        if(!$("#verCom").val()) { showMessage("Erreur de saisie", "Aucue commune n'a été sélectionnée.", "Retour"); return; }
        sent = {
            nom: $("#verName").val(),
            superficie: $("#verSup").val(),
            arbresParHectare: $("#verArbres").val(),
            idProducteur: $("#verProd").val(),
            idVariete: $("#verVar").val(),
            idCommune: $("#verCom").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/vergers.php", sent, function(data) {
            $("#slider").remove();
            showPage('php/vergers.php');
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
});