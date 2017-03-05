$(function() {
    $(($("#id").val() == "" ? "#slider " : "") + ".rightlink a").on('click', function() {
        if(!$("#prodName").val()) { showMessage("Erreur de saisie", "Aucun nom de producteur n'a été saisi.", "Retour"); return; }
        if(!$("#prodAddress").val()) { showMessage("Erreur de saisie", "Aucune adresse de producteur n'a été saisie.", "Retour"); return; }
        if($("input#prodAdh").is(":checked") && !$("#prodAdhDate").val()) { showMessage("Erreur de saisie", "Aucune date d'adhésion n'a été définie, alors que le producteur est indiqué comme adhérent.", "Retour"); return; }
        sent = {
            nom: $("#prodName").val(),
            adresse: $("#prodAddress").val(),
            adherent: $("input#prodAdh").is(":checked"),
            dateAdhesion: $("#prodAdhDate").val(),
            idUser: $("#idUser").val()
        }
        if($("#id").val() != "") sent.edit = $("#id").val();
        $.post("php/producteurs.php", sent, function(data) {
            showPage('php/producteurs.php');
            $("#slider").remove();
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
    $("input#prodAdh").change(function() {
        $("input#prodAdhDate").prop("disabled", !$("input#prodAdh").is(":checked"));
    });
});