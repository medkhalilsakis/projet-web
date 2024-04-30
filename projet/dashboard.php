<?php

require "connexion.php";
header("Content-type:application/json");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method){
    case 'GET':
        $ncin = $_GET['ncin'];
        $x = $_GET['T'];
        afficherVoiture($ncin, $x);
        break;
    default: {
        echo json_encode(["msg" => "method not allowed"]);
        break;
    }
}

function afficherVoiture($ncin, $x){
    global $connexion;
    if($x == 1){
        $requete = "SELECT v.num_immatriculation, v.marque, v.type, v.nbr_places, v.date_ajout
        FROM vehicule v
        WHERE v.ncin_client = :ncin";

        $prepared = $connexion->prepare($requete);

        $prepared->bindParam(":ncin", $ncin);
        $resultat = $prepared->execute();

        if($resultat){
            $sql = $prepared->fetchAll(PDO::FETCH_ASSOC);
            if (empty($sql)) {
                echo json_encode(["msg" => "Aucune information trouvé pour ce client"]);
            }else{
                echo json_encode($sql);
            }
        }else{
            //http_response_code(400);
            $msg = ["msg" => "requete sql erronée"];
            echo json_encode($msg);
        }
    }else{
        $requete = "SELECT r.id_rdv, r.date_RDV, r.type_RDV, r.methode_de_paiement, c.nom_centre
        FROM rdv r
        JOIN centre_technique c ON r.id_centre = c.code_centre
        WHERE r.ncin_client = :ncin";        

        $prepared = $connexion->prepare($requete);

        $prepared->bindParam(":ncin", $ncin);
        $resultat = $prepared->execute();

        if($resultat){
            $sql = $prepared->fetchAll(PDO::FETCH_ASSOC);
            if (empty($sql)) {
                echo json_encode(["msg" => "Aucune information trouvé pour ce client"]);
            }else{
                echo json_encode($sql);
            }
        }else{
            //http_response_code(400);
            $msg = ["msg" => "requete sql erronée"];
            echo json_encode($msg);
        }
    }
    
}