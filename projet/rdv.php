<?php
require "connexion.php";
header("Content-type:application/json");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method){
    case 'POST':
        $data = file_get_contents("php://input");
        $inputs = json_decode($data, true);
        ajouterRDV($inputs);
        break;
    default: break;
}

function ajouterRDV($inputs){
    global $connexion;
    $dt = $inputs["date"];
    $ncin = $inputs["ncin"];
    $type = $inputs["type_RDV"];

    $requete = "SELECT * FROM rdv WHERE ncin_client = :ncin AND date_RDV = :dt";
    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":ncin", $ncin);
    $prepared->bindParam(":dt", $dt);

    $resultat =  $prepared->execute();

    if($resultat){
        $r = $prepared->rowCount();
        if($r>0){
            //http_response_code(204);
            echo json_encode(["msg" => "RDV existe déja"]);
        }else{

            $requete = "INSERT INTO rdv (date_RDV, temps_RDV, type_RDV, nbr_places, ncin_client, date_ajout) VALUES(:numimm, :marque, :type, :nbr_places, :ncin, :dt)";    

            $prepared2 = $connexion->prepare($requete);

            $prepared2->bindParam(":numimm", $numimm);
            $prepared2->bindParam(":marque", $marque);
            $prepared2->bindParam(":type", $type);
            $prepared2->bindParam(":nbr_places", $nbr_places);
            $prepared2->bindParam("ncin", $ncin);
            $prepared2->bindParam(":dt", $dt);

        }
    }


}