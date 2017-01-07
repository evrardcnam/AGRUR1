<?php
require_once 'config.php';
if(AuthManager::loginStatus() != U_ADMIN) exit(json_encode(array("status" => "403", "text" => "Forbidden")));
$result = array("status" => "400", "text" => "Bad Request");
$success = array("status" => "200", "text" => "OK");
$notfound = array("status" => "404", "text" => "Not Found");
$conflict = array("status" => "409", "text" => "Conflict");

$possible_requests = array( "post_client", "post_certification", "post_validation", "post_commande", "post_conditionnement", "post_lot", "post_verger", "post_variete", "post_commune",
    "put_client", "put_certification", "put_commande", "put_conditionnement", "put_lot", "put_verger", "put_variete", "put_commune",
    "delete_client", "delete_certification", "delete_validation", "delete_commande", "delete_conditionnement", "delete_lot", "delete_verger", "delete_variete", "delete_commune");

if(isset($_GET["action"]) && in_array($_GET["action"], $possible_requests)) {
    switch($_GET["action"]) {
        case "post_certification":
            if(!isset($_POST["libelle"])) break;
            DBLayer::addCertification(Certification::fromValues(null, $_POST["libelle"]));
            $result = $success; break;
            break;
        case "put_certification":
            if(!isset($_POST["id"], $_POST["libelle"])) break;
            if(!$DBLayer::setCertification(Certification::fromValues($_POST["id"], $_POST["libelle"]))) {
                $result = $notfound; break;
            }
            $result = $success; break;
        case "delete_certification":
            if(!isset($_POST["id"])) break;
            $c = DBLayer::getCertification($_POST["id"]);
            if(!$c) { $result = $notfound; break; }
            DBLayer::removeCertification($c);
            $result = $success; break;
    }
}
exit(json_encode($result));
?>