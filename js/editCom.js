$(function() {
    $(".rightlink a").on('click', function() {
        sent = {
            dateConditionnement: $("#comConditioned").is(":checked") ? $("#comConditionedDate").val() : null,
            dateEnvoi: $("#comSent").is(":checked") ? $("#comSentDate").val() : null,
            idClient: $("#comClient").val(),
            idLot: $("#comLot").val(),
            idConditionnement: $("#comCond").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/commandes.php", sent, function(data) {
            console.log(data);
            showPage('php/commandes.php');
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
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
    function updateDateFields() {
        $("input#comSentDate").prop("disabled", !$("input#comSent").is(":checked"));
        $("input#comConditionedDate").prop("disabled", !$("input#comConditioned").is(":checked"));
    }
});