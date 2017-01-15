$(function() {
    $(".rightlink a").on('click', function() {
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
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
        });
    });
    $('input[name="userRole"]').change(function() {
        $("select#userProd").prop("disabled", $('input[name="userRole"]:checked').val() != 'producteur');
        $("select#userClient").prop("disabled", $('input[name="userRole"]:checked').val() != 'client');
    });
});