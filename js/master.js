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
        if($(this).hasClass("danger") && !confirm("Voulez-vous vraiment effectuer cette action ?\nCette opération est irréversible.")) return;
        showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
}

$(function() { // Code exécuté une fois la page chargée
    // Affichage éventuel d'une page d'accueil
    if($("a.slavePage#home").length) {
        showPage($("a.slavePage#home").attr("data-link"));
        
    }
    $("a.slavePage").click(function() {
        $("li.active").removeClass("active");
        $(this).parent().addClass("active");
        showPage($(this).attr("data-link"));
    }).attr("href","#").removeClass("slavePage");
})