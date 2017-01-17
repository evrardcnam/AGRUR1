$(function() {
    updateEditLinks();
    $("a#add").click(function() {
        $.post('php/api.php?action=post_certification', {
            libelle: $("input#newLabel").val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                $(".rowtable").find(".row:last").before(
                    '<div class="row" data-id="' + data.new_id +
                    '"><div class="col-xs-12 col-sm-10">' + $("input#newLabel").val() +
                    '</div><div class="col-xs-6 col-sm-2 actions"><a href="#" data-id="' + data.new_id +
                    '" class="edit">Modifier</a><br /><a href="#" data-id="' + data.new_id +
                    '" class="delete danger">Supprimer</a></div></div>');
                $("input#newLabel").val('');
                updateEditLinks();
            } else if(data.status == "403") window.location.replace('/index.php');
            else {
                showMessage("Erreur","Une erreur s'est produite lors de l'insertion : <code>" + data.text + "</code><br />Contactez le support de VDEV.","Retour");
                console.log(data);
            }
        }, 'json');
    });
});

function updateEditLinks() {
    $("a.save").click(function() { // Enregistrement d'une modification en cours
        var id = $(this).attr('data-id');
        var row = '.row[data-id="' + id + '"]';
        $.post('php/api.php?action=put_certification', {
            id: id,
            libelle: $(row + ' .col-sm-10 input').val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                var row = '.row[data-id="' + data.id + '"]';
                $(row + ' .col-sm-10').html($(row + ' .col-sm-10 input').val());
                $(row + ' .actions').html('<a href="#" data-id="' + data.id + '" class="edit">Modifier</a><br /><a href="#" data-id="' + data.id + '" class="delete danger">Supprimer</a>');
                updateEditLinks();
            } else if(data.status == "403") window.location.replace('/index.php');
            else {
                showMessage("Erreur","Une erreur s'est produite lors de l'insertion : <code>" + data.text + "</code><br />Contactez le support de VDEV.","Retour");
                console.log(data);
            }
        }, 'json');
    });
    $("a.edit").click(function() { // Afficher le formulaire de modification
        var id = $(this).attr('data-id');
        var row = '.row[data-id="' + id + '"]';
        $(row + ' .col-sm-10').html('<input type="text" class="form-control" required value="'
            + $(row + ' .col-sm-10').text() + '">');
        $(row + ' .actions').html('<a href="#" data-id="' + id + '" class="save">Enregistrer</a>');
        updateEditLinks();
    });
    $("a.delete").click(function() { // Confirmer la suppression
        $this = $(this);
        showConfirm({
            title: 'Attention',
            message: 'Voulez-vous vraiment supprimer cet élément ?<br />Cette opération est irréversible.',
            buttons: [ {type: 'danger', label: 'Supprimer', value: 'confirm'}, {type:'primary', label:'Annuler', value:'cancel'} ]
        }, function(value) {
            if(value != 'confirm') return;
            $.post('php/api.php?action=delete_certification', {
                id: $this.attr('data-id')
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