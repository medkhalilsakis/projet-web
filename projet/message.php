<?php
require 'connexion.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case 'POST': 
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input["nom"]) || !isset($input["sujet"]) || !isset($input["message"])) {
            //http_response_code(400);
            echo json_encode(["msg" => "tous les champs sont requis"]);
            exit();
        }else{
            ajoutMessage($input);
            exit();
        }
        break;
    default: {
        //http_response_code(204);
        echo json_encode(["msg" => "method not allowed"]);
        break;
    }
}

function ajoutMessage($input){
    global $connexion;

    $nom = $input["nom"];
    $ncin = $input["ncin"];
    $sujet = $input["sujet"];
    $msg = $input["message"];
    $email = $input["email"];
    $dt = date('Y-m-d');

    if(empty($email) || empty($ncin)){
        $email= NULL;
        $ncin = NULL;
    }

    $requete = "INSERT INTO notification (nom_emetteur, email_emetteur, objet, message, date, ncin_client, id_employe, status) VALUES(:nom, :email, :obj, :msg, :dt, :ncin, NULL, 'A')";    

    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":nom", $nom);
    $prepared->bindParam(":email", $email);
    $prepared->bindParam(":obj", $sujet);
    $prepared->bindParam(":msg", $msg);
    $prepared->bindParam(":dt", $dt);
    $prepared->bindParam(":ncin", $ncin);

    $resultat = $prepared->execute();

    if($resultat){
        http_response_code(201);
        echo json_encode(["success" => "Message envoyee avec succes"]);
    }
    else{
        //http_response_code(400);
        echo json_encode(["msg" => "Echec lors de l'envoie du message"]);
    }
}

?>