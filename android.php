<?php
require_once("php/config.php");
// Point d'entrée pour les interactions avec l'application Android AGRUR3
if(!isset($_GET["action"])) exit();
switch($_GET["action"]) {
    case "auth":
        header('Content-Type: text/plain');
        if(!isset($_POST["login"], $_POST["password"])) exit();
        echo AuthManager::login($_POST["login"], $_POST["password"], false)
            ? 1 : 0;
        break;
    case "get_communes":
        header('Content-Type: application/json');
        echo json_encode(DBLayer::getCommunes());
        break;
    case "get_varietes":
        header('Content-Type: application/json');
        echo json_encode(DBLayer::getVarietes());
        break;
    case "get_producteurs":
        header('Content-Type: application/json');
        echo json_encode(DBLayer::getProducteurs());
        break;
    case "get_vergers":
        header('Content-Type: application/json');
        echo json_encode(DBLayer::getVergers());
        break;
    case "post_producteur":
        header('Content-Type: text/plain');
        if(!isset($_POST["nom"], $_POST["adresse"], $_POST["adherent"],
            $_POST["dateAdhesion"])) exit();
        echo DBLayer::addProducteur(Producteur::fromValues(null, $_POST["nom"],
            $_POST["adresse"], $_POST["adherent"], $_POST["dateAdhesion"],
            null)) ? 1 : 0;
        break;
    case "post_verger":
        header('Content-Type: text/plain');
        if(!isset($_POST["nom"], $_POST["superficie"],
            $_POST["arbresParHectare"], $_POST["idProducteur"],
            $_POST["idCommune"], $_POST["idVariete"])) exit();
        echo DBLayer::addVerger(Verger::fromValues(null, $_POST["nom"],
            $_POST["superficie"], $_POST["arbresParHectare"],
            $_POST["idProducteur"], $_POST["idVariete"], $_POST["idCommune"]))
            ? 1 : 0;
        break;
    default:
        exit();
}
?>