$(function() {
    $(".rightlink a").on('click', function() {
        sent = {
            idVerger: $("#livVerger").val(),
            type: $("#livType").val(),
            date: $("#livDate").val(),
            quantite: $("#livQte").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/livraisons.php", sent, function(data) {
            showPage('php/livraisons.php');
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
        });
    });
});