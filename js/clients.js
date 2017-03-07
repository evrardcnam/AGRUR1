$(function() {
    updateEditLinks();
    $("a#add").click(function() {
        if(!$("input#newName").val()) { showMessage("Erreur de saisie", "Veuillez indiquer un nom de client.", "Retour"); return; }
        if(!$("input#newAddress").val()) { showMessage("Erreur de saisie", "Veuillez indiquer une adresse de client.", "Retour"); return; }
        if(!$("input#newResp").val()) { showMessage("Erreur de saisie", "Veuillez indiquer un nom de responsable des achats.", "Retour"); return; }
        $.post('php/api.php?action=post_client', {
            nom: $("input#newName").val(),
            adresse: $("input#newAddress").val(),
            nomResAchats: $("input#newResp").val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                $(".rowtable").find(".row:last").before(
                    '<div class="row" data-id="' + data.new_id +
                    '"><div class="col-xs-12 col-sm-3">' + $("input#newName").val() +
                    '</div><div class="col-xs-12 col-sm-4">' + $("input#newAddress").val() +
                    '</div><div class="col-xs-12 col-sm-3">' + $("input#newResp").val() +
                    '</div><div class="col-xs-6 col-sm-2 actions"><a href="#" data-id="' + data.new_id +
                    '" class="edit">Modifier</a><br /><a href="#" data-id="' + data.new_id +
                    '" class="delete danger">Supprimer</a></div></div>');
                $("input#newName").val('');
                $("input#newAddress").val('');
                $("input#newResp").val('');
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
    $("a.save").off().click(function() { // Enregistrement d'une modification en cours
        var id = $(this).attr('data-id');
        var row = '.row[data-id="' + id + '"]';
        if(!$(row + ' .col-sm-3:first input').val()) { showMessage("Erreur de saisie", "Veuillez indiquer un nom de client.", "Retour"); return; }
        if(!$(row + ' .col-sm-4 input').val()) { showMessage("Erreur de saisie", "Veuillez indiquer une adresse de client.", "Retour"); return; }
        if(!$(row + ' .col-sm-3:last input').val()) { showMessage("Erreur de saisie", "Veuillez indiquer un nom de responsable des achats.", "Retour"); return; }
        $.post('php/api.php?action=put_client', {
            id: id,
            nom: $(row + ' .col-sm-3:first input').val(),
            adresse: $(row + ' .col-sm-4 input').val(),
            nomResAchats: $(row + ' .col-sm-3:last input').val()
        }, function(data, status, xhr) {
            if(data.status == "200") {
                var row = '.row[data-id="' + data.id + '"]';
                $(row + ' .col-sm-3:first').html($(row + ' .col-sm-3:first input').val());
                $(row + ' .col-sm-4').html($(row + ' .col-sm-4 input').val());
                $(row + ' .col-sm-3:last').html($(row + ' .col-sm-3:last input').val());
                $(row + ' .actions').html('<a href="#" data-id="' + data.id + '" class="edit">Modifier</a><br /><a href="#" data-id="' + data.id + '" class="delete danger">Supprimer</a>');
                updateEditLinks();
            } else if(data.status == "403") window.location.replace('/index.php');
            else {
                showMessage("Erreur","Une erreur s'est produite lors de l'insertion : <code>" + data.text + "</code><br />Contactez le support de VDEV.","Retour");
                console.log(data);
            }
        }, 'json');
    });
    $("a.edit").off().click(function() { // Afficher le formulaire de modification
        var id = $(this).attr('data-id');
        var row = '.row[data-id="' + id + '"]';
        $(row + ' .col-sm-3:first').html('<input type="text" class="form-control" required value="'
            + $(row + ' .col-sm-3:first').text() + '">');
        $(row + ' .col-sm-4').html('<input type="text" class="form-control" required value="'
            + $(row + ' .col-sm-4').text() + '">');
        $(row + ' .col-sm-3:last').html('<input type="text" class="form-control" required value="'
            + $(row + ' .col-sm-3:last').text() + '">');
        $(row + ' .actions').html('<a href="#" data-id="' + id + '" class="save">Enregistrer</a>');
        updateEditLinks();
    });
    $("a.delete").off().click(function() { // Confirmer la suppression
        $this = $(this);
        showConfirm({
            title: 'Attention',
            message: 'Voulez-vous vraiment supprimer cet élément ?<br />Cette opération est irréversible.',
            buttons: [ {type: 'danger', label: 'Supprimer', value: 'confirm'}, {type:'primary', label:'Annuler', value:'cancel'} ]
        }, function(value) {
            if(value != 'confirm') return;
            $.post('php/api.php?action=delete_client', {
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