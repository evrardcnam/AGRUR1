$(function() {
    updateEditLinks();
    $("a#add").click(function() {
        $.post('php/api.php?action=post_validation', {
            nomProducteur: $("input#oldName").val(),
            idCertification: $("#valCert").val(),
            dateObtention: $("input#valDate").val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                $(".rowtable").find(".row:last").before(
                    '<div class="row" data-id="' + data.new_id +
                    '"><div class="col-xs-12 col-sm-8">' + $("#valCert").find(":selected").text() +
                    '</div><div class="col-xs-6 col-sm-2">' + $("#valDate").val() +
                    '</div><div class="col-xs-6 col-sm-2 actions"><a href="#" data-id="' + data.new_id +
                    '" class="delete danger">Supprimer</a></div></div>');
                $("input#newLabel").val('');
                updateEditLinks();
            } else if(data.status == "403") {
                if(confirm("La connexion à l'interface d'administration a été perdue. Voulez-vous être redirigé vers la page de connexion ?"))
                    window.location.replace('/index.php');
            } else {
                alert("Une erreur s'est produite lors de l'insertion : '" + data.text + "'\nContactez le support de VDEV.");
                console.log(data);
            }
        }, 'json');
    });
});

function updateEditLinks() {
    $("a.delete").click(function() { // Confirmer la suppression
        if(!confirm("Voulez-vous vraiment supprimer cet élément ?\nCette action est irréversible.")) return;
        $.post('php/api.php?action=delete_validation', {
            id: $(this).attr('data-id'),
            name: $("input#oldName").val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                $('.row[data-id="' + data.del_id + '"]').remove();
                updateEditLinks();
            } else if(data.status == "403") {
                if(confirm("La connexion à l'interface d'administration a été perdue. Voulez-vous être redirigé vers la page de connexion ?"))
                    window.location.replace('/index.php');
            } else {
                alert("Une erreur s'est produite lors de la suppression : '" + data.text + "'\nContactez le support de VDEV.");
                console.log(data);
            }
        }, 'json');
    });
}