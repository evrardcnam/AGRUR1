$(function() {
    $("#slider .rightlink a").on('click', function() {
        if(!$("#comClient").val()) { showMessage("Erreur de saisie", "Aucun client n'a été sélectionné pour la commande.", "Retour"); return; }
        if(!$("#comLot").val()) { showMessage("Erreur de saisie", "Aucun lot n'a été sélectionné pour la commande.", "Retour"); return; }
        if(!$("#comCond").val()) { showMessage("Erreur de saisie", "Aucun conditionnement n'a été sélectionné pour la commande.", "Retour"); return; }
        if($("#comConditioned").is(":checked") && !$("#comConditionedDate").val()) { showMessage("Erreur de saisie", "Aucune date de conditionnement n'a été saisie pour la commande, alors qu'elle a été marquée comme conditionnée.", "Retour"); return; }
        if($("#comSent").is(":checked") && !$("#comSentDate").val()) { showMessage("Erreur de saisie", "Aucune date d'expédition n'a été saisie pour la commande, alors qu'elle a été marquée comme expédiée.", "Retour"); return; }
        sent = {
            dateConditionnement: $("#comConditioned").is(":checked") ? $("#comConditionedDate").val() : null,
            dateEnvoi: $("#comSent").is(":checked") ? $("#comSentDate").val() : null,
            idClient: $("#comClient").val(),
            idLot: $("#comLot").val(),
            idConditionnement: $("#comCond").val()
        }
        if($("#id").val() != "") sent.num = $("#id").val();
        $.post("php/commandes.php", sent, function(data) {
            $("#slider").remove();
            showPage('php/commandes.php');
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
    $("input#comSent").change(function() {
        if($("input#comSent").is(":checked")) $("input#comConditioned").prop('checked', true);
        updateDateFields();
    });
    $("input#comConditioned").change(function() {
        if(!$("input#comConditioned").is(":checked")) $("input#comSent").prop('checked', false);
        updateDateFields();
    });
    $("input#comConditionedDate").change(function() {
        updateDateFields();
    });
    function updateDateFields() {
        $("input#comSentDate").prop("disabled", (!$("input#comSent").is(":checked")) || (!$("#comConditionedDate").val()));
        $("input#comSentDate").prop("min", $("#comConditionedDate").val());
        $("input#comConditionedDate").prop("disabled", !$("input#comConditioned").is(":checked"));
    }
});