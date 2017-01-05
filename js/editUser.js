$(function() {
    $(".rightlink a").on('click', function() {
        sent = {
            nom: $("#userName").val(),
            pass: $("#userPass").val(),
            admin: $("#userAdmin").is(":checked"),
            nomProducteur: $("#userProd").val()
        }
        if($("#id").val() != "") sent.id = $("#id").val();
        $.post("php/utilisateurs.php", sent, function(data) {
            showPage('php/utilisateurs.php');
        }).fail(function() {
            alert("Une erreur s'est produite lors de l'enregistrement. Vérifiez les données saisies, réessayez ultérieurement ou contactez le support technique.");
        });
    });
    $("input#userAdmin").change(function() {
        $("select#userProd").prop("disabled", $("input#userAdmin").is(":checked"));
    });
});