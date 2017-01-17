$(function() {
    updateEditLinks();
    $("a#add").click(function() {
        $.post('php/api.php?action=post_validation', {
            idProducteur: $("input#id").val(),
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
            } else if(data.status == "403") window.location.replace('/index.php');
            else {
                showMessage("Erreur" ,"Une erreur s'est produite lors de l'insertion : <code>" + data.text + "</code><br />Contactez le support de VDEV.", "Retour");
                console.log(data);
            }
        }, 'json');
    });
});

function updateEditLinks() {
    $("a.delete").click(function() { // Confirmer la suppression
        $this = $(this);
        showConfirm({
            title: 'Attention',
            message: 'Voulez-vous vraiment supprimer cet élément ?<br />Cette opération est irréversible.',
            buttons: [ {type: 'danger', label: 'Supprimer', value: 'confirm'}, {type:'primary', label:'Annuler', value:'cancel'} ]
        }, function(value) {
            if(value != 'confirm') return;
            $.post('php/api.php?action=delete_validation', {
                id: $this.attr('data-id'),
                id2: $("input#id").val()
            }, function(data, status, xhr) {
                if(data.status == "200") {
                    $('.row[data-id="' + data.del_id + '"]').remove();
                    updateEditLinks();
                } else if(data.status == "403") window.location.replace('/index.php');
                else {
                    showMessage("Erreur","Une erreur s'est produite lors de la suppression : <code>" + data.text + "</code><br />Contactez le support de VDEV.","Retour");
                    console.log(data);
                }
            }, 'json');
        });
    });
}