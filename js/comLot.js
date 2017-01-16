$(function() {
    $(".rightlink a").on('click', function() {
        sent = {
            idLot: $("#idLot").val(),
            idConditionnement: $("#comCond").val()
        }
        $.post("php/client/comLot.php", sent, function(data) {
            console.log(data);
            showPage('php/client/commandes.php');
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
        });
    });
});