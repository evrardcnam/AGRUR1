<?php
require_once 'config.php';
if(AuthManager::loginStatus() != U_ADMIN) exit(json_encode(array("status" => "403", "text" => "Forbidden")));
$result = array("status" => "400", "text" => "Bad Request");
$success = array("status" => "200", "text" => "OK");

$possible_requests = array(
    "post_client", "post_certification", "post_validation", "post_conditionnement", "post_lot", "post_variete", "post_commune",
    "put_client", "put_certification", "put_conditionnement", "put_lot", "put_variete", "put_commune",
    "delete_client", "delete_certification", "delete_validation", "delete_conditionnement", "delete_lot", "delete_variete", "delete_commune");

if(isset($_GET["action"]) && in_array($_GET["action"], $possible_requests)) {
    switch($_GET["action"]) {
        case "post_client":
            if(!isset($_POST["nom"], $_POST["adresse"], $_POST["nomResAchats"])) break;
            $id = DBLayer::addClient(Client::fromValues(null, $_POST["nom"], $_POST["adresse"], $_POST["nomResAchats"]));
            $result = $success; $result["new_id"] = $id; break;
        case "post_certification":
            if(!isset($_POST["libelle"])) break;
            $id = DBLayer::addCertification(Certification::fromValues(null, $_POST["libelle"]));
            $result = $success; $result["new_id"] = $id; break;
        case "post_validation":
            if(!isset($_POST["idProducteur"], $_POST["idCertification"], $_POST["dateObtention"])) break;
            DBLayer::addCertObtenue(CertObtenue::fromValues($_POST["idCertification"], null, $_POST["idProducteur"], $_POST["dateObtention"]));
            $result = $success; $result["new_id"] = $_POST["idCertification"]; break;
        case "post_conditionnement":
            if(!isset($_POST["libelle"])) break;
            $id = DBLayer::addConditionnement(Conditionnement::fromValues(null, $_POST["libelle"]));
            $result = $success; $result["new_id"] = $id; break;
        case "post_lot":
            if(!isset($_POST["code"], $_POST["calibre"], $_POST["quantite"], $_POST["idLivraison"])) break;
            $id = DBLayer::addLot(Lot::fromValues(null, $_POST["code"], $_POST["calibre"], $_POST["quantite"], $_POST["idLivraison"], null));
            $result = $success; $result["new_id"] = $id; break;
        case "post_variete":
            if(!isset($_POST["libelle"], $_POST["aoc"])) break;
            $îd = DBLayer::addVariete(Variete::fromValues(null, $_POST["libelle"], $_POST["varieteAoc"]));
            $result = $success; $result["new_id"] = $id; break;
        case "post_commune":
            if(!isset($_POST["nom"], $_POST["aoc"])) break;
            $id = DBLayer::addCommune(Commune::fromValues(null, $_POST["nom"], $_POST["aoc"]));
            $result = $success; $result["new_id"] = $id; break;
        case "put_client":
            if(!isset($_POST["id"], $_POST["nom"], $_POST["adresse"], $_POST["nomResAchats"])) break;
            DBLayer::setClient(Client::fromValues($_POST["id"], $_POST["nom"], $_POST["adresse"], $_POST["nomResAchats"]));
            $result = $success; $result["id"] = $_POST["id"]; break;
        case "put_certification":
            if(!isset($_POST["id"], $_POST["libelle"])) break;
            DBLayer::setCertification(Certification::fromValues($_POST["id"], $_POST["libelle"]));
            $result = $success; $result["id"] = $_POST["id"]; break;
        case "put_conditionnement":
            if(!isset($_POST["id"], $_POST["libelle"])) break;
            DBLayer::setConditionnement(Conditionnement::fromValues($_POST["id"], $_POST["libelle"]));
            $result = $success; $result["id"] = $id; break;
        case "put_lot":
            if(!isset($_POST["id"], $_POST["code"], $_POST["calibre"], $_POST["quantite"], $_POST["idLivraison"])) break;
            DBLayer::setLot(Lot::fromValues($_POST["id"], $_POST["code"], $_POST["calibre"], $_POST["quantite"], $_POST["idLivraison"], null));
            $result = $success; $result["id"] = $_POST["id"]; break;
        case "put_variete":
            if(!isset($_POST["id"], $_POST["libelle"], $_POST["aoc"])) break;
            DBLayer::setVariete(Variete::fromValues($_POST["id"], $_POST["libelle"], $_POST["varieteAoc"]));
            $result = $success; $result["id"] = $_POST["id"]; break;
        case "put_commune":
            if(!isset($_POST["id"], $_POST["nom"], $_POST["aoc"])) break;
            $id = DBLayer::setCommune(Commune::fromValues($_POST["id"], $_POST["nom"], $_POST["aoc"]));
            $result = $success; $result["id"] = $id; break;
        case "delete_client":
            if(!isset($_POST["id"])) break;
            DBLayer::removeClient(Client::fromValues($_POST["id"], null, null, null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_certification":
            if(!isset($_POST["id"])) break;
            $c = DBLayer::getCertification($_POST["id"]);
            DBLayer::removeCertification($c);
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_validation":
            if(!isset($_POST["id"], $_POST["name"])) break;
            DBLayer::removeCertObtenue(CertObtenue::fromValues($_POST["id"], null, $_POST["name"], null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_conditionnement":
            if(!isset($_POST["id"])) break;
            DBLayer::removeConditionnement(Conditionnement::fromValues($_POST["id"], null, null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_lot":
            if(!isset($_POST["id"])) break;
            DBLayer::removeLot(Lot::fromValues($_POST["id"], null, null, null, null, null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_variete":
            if(!isset($_POST["id"])) break;
            DBLayer::removeVariete(Variete::fromValues($_POST["id"], null, null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
        case "delete_commune":
            if(!isset($_POST["id"])) break;
            DBLayer::removeCommune(Commune::fromValues($_POST["id"], null, null));
            $result = $success; $result["del_id"] = $_POST["id"]; break;
    }
}
exit(json_encode($result));
?>