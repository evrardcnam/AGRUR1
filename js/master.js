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
            alert("Une erreur s'est produite.\n" + err + "\nContactez le support VDEV en décrivant cette erreur et le parcours effectué pour l'atteindre.");
        }
    });
}

// Mise à jour des liens de pages esclaves
function updateLinks() {
    $("a.slavePage").click(function() {
        showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
}

$(function() { // Code exécuté une fois la page chargée
    // Affichage éventuel d'une page d'accueil
    if($("a.slavePage#home").length) { showPage($("a.slavePage#home").attr("data-link")); }
    updateLinks();
})