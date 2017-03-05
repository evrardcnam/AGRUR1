// Afficher le contenu d'une page
function showPage(href) {
    $.ajax({
        type: "GET",
        url: href,
        dataType: 'html',
        contentType: "text/html",
        crossDomain:'true',
        success: function (data) {
            $("#slider").remove();
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
    $("a.sliderPage").click(function() {
        showSlider($(this).attr("data-link"));
    }).attr("href","#").removeClass("sliderPage");
}

// Affichage d'un message
function showMessage(title, message, button) {
    $("#modal").remove();
    $("#content").append('<div id="modal"><div id="modal-content"><h1>' + title + '</h1><p>' + message + '</p><button type="button" class="btn btn-warning">' + button + '</button></div></div>');
    $("#modal button").click(function() { $("#modal").remove() });
    $("#modal").show();
}

// Affichage d'une boîte de dialogue de confirmation
function showConfirm(data, callback) {
    $("#modal").remove();
    $("#content").append('<div id="modal"><div id="modal-content"><h1>' + data.title + '</h1><p>' + data.message + '</p></div></div>');
    $(data.buttons).each(function(i, button) { $("#modal-content").append('<button type="button" class="btn btn-' + button.type + '" value="' + button.value + '">' + button.label + '</button>') });
    $("#modal button").click(function() { callback($(this).val()); $("#modal").remove(); });
    $("#modal").show();
}

// Affichage d'une page sous la forme d'un slider
function showSlider(href) {
    $.ajax({
        type: "GET",
        url: href,
        dataType: 'html',
        contentType: "text/html",
        crossDomain:'true',
        success: function (data) {
            $("#slider").remove();
            $("#global").append('<div id="slider"><div id="slider-content">' + data + '</div></div>');
            $("#slider").click(function(event) { if(event.target == this) $(this).remove(); }).show();
            updateLinks();
        },
        error: function(xhr, err, httperr) {
            showMessage("Erreur" ,"Une erreur s'est produite : <code>" + err + "</code><br />Contactez le support VDEV en décrivant cette erreur et le parcours effectué pour l'atteindre.", "Retour");
        }
    });
}

$(function() { // Code exécuté une fois la page chargée
    // Affichage éventuel d'une page d'accueil
    if($("a.slavePage#home").length) {
        showPage($("a.slavePage#home").attr("data-link"));
        $("a.slavePage#home").parent().addClass("active");
    }
    $("a.slavePage").click(function() {
        if(!$(this).hasClass("no-active")) { $("li.active").removeClass("active"); $(this).parent().addClass("active"); }
        showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
    $("a.sliderPage").click(function() {
        if(!$(this).hasClass("no-active")) { $("li.active").removeClass("active"); $(this).parent().addClass("active"); }
        showSlider($(this).attr("data-link"));
    }).attr("href","#").removeClass("sliderPage");
})