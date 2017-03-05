$(function() {
    $("#slider .rightlink a").on('click', function() {
        if(!$("#userName").val()) { showMessage("Erreur de saisie", "Aucun nom d'utilisateur n'a été défini.", "Retour"); return; }
        if(!$('input[name="userRole"]:checked').length) { showMessage("Erreur de saisie", "Aucun rôle n'a été défini à l'utilisateur.", "Retour"); return; }
        if($('input[name="userRole"]:checked').val() == 'producteur' && !$("#userProd").val()) { showMessage("Erreur de saisie", "Aucun producteur n'a été associé à l'utilisateur, alors qu'il a le rôle Producteur.<br />Un producteur doit être créé avant de pouvoir créer l'utilisateur qui lui est associé.", "Retour"); return; }
        if($('input[name="userRole"]:checked').val() == 'client' && !$("#userClient").val()) { showMessage("Erreur de saisie", "Aucun client n'a été associé à l'utilisateur, alors qu'il a le rôle Client.<br />Un client doit être créé avant de pouvoir créer l'utilisateur qui lui est associé.", "Retour"); return; }
        if($("#id").val() == "" && !$("#userPass").val()) { showMessage("Erreur de saisie", "Aucun mot de passe n'a été défini pour l'utilisateur", "Retour"); return; }
        sent = {
            nom: $("#userName").val(),
            pass: $("#userPass").val(),
            role: $('input[name="userRole"]:checked').val(),
            idProducteur: $('input[name="userRole"]:checked').val() == 'producteur' ? $("#userProd").val() : null,
            idClient: $('input[name="userRole"]:checked').val() == 'client' ? $("#userClient").val() : null
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/utilisateurs.php", sent, function(data) {
            showPage('php/utilisateurs.php');
            $("#slider").remove();
        }).fail(function() {
            showMessage("Erreur" ,"Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.", "Retour");
        });
    });
    $('input[name="userRole"]').change(function() {
        $("select#userProd").prop("disabled", $('input[name="userRole"]:checked').val() != 'producteur');
        $("select#userClient").prop("disabled", $('input[name="userRole"]:checked').val() != 'client');
    });
});