// Afficher le contenu d'une page
function showPage(href) {
    $.ajax({
        type: "GET",
        url: href,
        dataType: 'json',
        contentType: "text/html",
        crossDomain:'true',
        success: function (data) {
            $("#content").html(data);
        }
    });
}

$(function() { // Code exécuté une fois la page chargée
    // Affichage éventuel d'une page d'accueil
    if($("a.slavePage#home").length) { showPage($("a.slavePage#home").attr("href")); }
    $("a.slavePage").attr("href", function() { // Association des liens
        return "javascript:showPage('" + $(this).attr("href") + "')";
    });
})