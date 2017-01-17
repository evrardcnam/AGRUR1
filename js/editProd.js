$(function() {
    $(".rightlink a").on('click', function() {
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
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
    $("input#prodAdh").change(function() {
        $("input#prodAdhDate").prop("disabled", !$("input#prodAdh").is(":checked"));
    });
});