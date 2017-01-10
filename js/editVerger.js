$(function() {
    $(".rightlink a").on('click', function() {
        sent = {
            nom: $("#verName").val(),
            superficie: $("#verSup").val(),
            arbresParHectare: $("#verArbres").val(),
            idProducteur: $("#verProd").val(),
            idVariete: $("#verVar").val(),
            idCommune: $("#verCom").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/vergersAdmin.php", sent, function(data) {
            showPage('php/vergersAdmin.php');
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
        });
    });
});