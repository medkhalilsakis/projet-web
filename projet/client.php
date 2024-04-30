<?php

require "connexion.php";
header("Content-type:application/json");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method){
    case 'GET':
        $ncin = $_GET['ncin'];
        afficherClient($ncin);
        break;

    case 'DELETE':
        $ncin = $_GET['ncin'];
        supprimerClient($ncin);
        break;

    default: 
        $msg = ["msg" => "method not allowed"];
        echo json_encode($msg);
        break;
}

function afficherClient($ncin){
    global $connexion;
    $requete = "SELECT * FROM client WHERE ncin = :ncin";
    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":ncin", $ncin);
    $resultat = $prepared->execute();

    if($resultat){
        $sql = $prepared->fetchAll(PDO::FETCH_ASSOC);
        if (empty($sql)) {
            echo json_encode(["message" => "Aucun client trouvé pour ce NCIN"]);
        }else{
            echo json_encode($sql);
        }
    }else{
        //http_response_code(400);
        $msg = ["msg" => "requete sql erronée"];
        echo json_encode($msg);
    }
}


function supprimerClient($ncin){
    global $connexion;
    $requete = "DELETE FROM client WHERE ncin = :ncin";
    $prepared = $connexion->prepare($requete);
    $prepared->bindParam(":ncin", $ncin);
    $resultat = $prepared->execute();

    if($resultat){
        $req2="DELETE FROM compte WHERE ncin = :ncin";
        $prepared2 = $connexion->prepare($req2);
        $prepared2->bindParam(":ncin", $ncin);
        $resultat2 = $prepared2->execute();
        if($resultat2){
            http_response_code(201);
            echo json_encode(["msg" => "Suppression effectuée"]);
        }else{
            echo json_encode(["msg" => "erreur lors du suppression du compte"]);
        }
    }else{
        echo json_encode(["msg" => "Erreur lors du suppression"]);
    }
}