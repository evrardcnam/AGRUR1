// Afficher le contenu d'une page
function showPage(href) {
    $.ajax({
        type: "GET",
        url: href,
        dataType: 'html',
        contentType: "text/html",
        crossDomain:'true',
        success: function (data) {
            $("#content").html(data);
            updateLinks();
        },
        error: function(xhr, err, httperr) {
            showMessage("Erreur" ,"Une erreur s'est produite : <code>" + err + "</code><br />Contactez le support VDEV en décrivant cette erreur et le parcours effectué pour l'atteindre.", "Retour");
        }
    });
}

// Mise à jour des liens de pages esclaves
function updateLinks() {
    $("a.slavePage").click(function() {
        if($(this).hasClass("danger")) {
            $this = $(this);
            showConfirm({
                title: 'Attention',
                message: 'Voulez-vous vraiment effectuer cette action ?<br />Cette opération est irréversible.',
                buttons: [ {type: 'danger', label: 'Confirmer', value: 'confirm'}, {type:'primary', label:'Annuler', value:'cancel'} ]
            }, function(value) {
                if(value == 'confirm') showPage($this.attr("data-link"));
            });
        } else showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
}

// Affichage d'un message
function showMessage(title, message, button) {
    $("#content").append('<div id="modal"><div id="modal-content"><h1>' + title + '</h1><p>' + message + '</p><button type="button" class="btn btn-warning">' + button + '</button></div></div>');
    $("#modal button").click(function() { $("#modal").remove() });
    $("#modal").show();
}

// Affichage d'une boîte de dialogue de confirmation
function showConfirm(data, callback) {
    $("#content").append('<div id="modal"><div id="modal-content"><h1>' + data.title + '</h1><p>' + data.message + '</p></div></div>');
    $(data.buttons).each(function(i, button) { $("#modal-content").append('<button type="button" class="btn btn-' + button.type + '" value="' + button.value + '">' + button.label + '</button>') });
    $("#modal button").click(function() { callback($(this).val()); $("#modal").remove(); });
    $("#modal").show();
}

$(function() { // Code exécuté une fois la page chargée
    // Affichage éventuel d'une page d'accueil
    if($("a.slavePage#home").length) {
        showPage($("a.slavePage#home").attr("data-link"));
        $("a.slavePage#home").parent().addClass("active");
    }
    $("a.slavePage").click(function() {
        $("li.active").removeClass("active");
        $(this).parent().addClass("active");
        showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
})