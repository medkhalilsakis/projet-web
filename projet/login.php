<?php
require 'connexion.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case 'GET': break;
    case 'POST': 
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input["username"]) || !isset($input["password"])) {
            http_response_code(400);
            $msg = ["erreur" => "tous les champs sont requis"];
            echo json_encode($msg);
            exit();
        }else{
            try {
                verifCompte($input);
            } catch (Exception $e) {
                http_response_code(500);
                $msg = ["erreur" => "Une erreur interne est survenue: " . $e->getMessage()];
                echo json_encode($msg);
                exit();
            }
        }
        break;
}

function verifCompte($input){
    global $connexion;

    $username = $input["username"];
    $pwd = $input["password"];
    //$pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);


    $requete = "SELECT * FROM compte WHERE username = :user AND mot_de_passe = :pwd";    
    $prepared = $connexion->prepare($requete);
    $prepared->bindParam(":username", $username);
    $prepared->bindParam(":pwd", $pwd);
    $resultat = $prepared->execute();

    if(!$resultat){
        http_response_code(400);
        $msg = ["erreur" => "requete sql erronée"];
        echo json_encode($msg);
        exit();
    }
    else{
        $rows = $prepared->rowCount();
        if ($rows > 0) {
            $msg = ["message" => "Connecté avec succès"];
            echo json_encode($msg);
        } else {
            $msg = ["erreur" => "Identifiants de connexion incorrects"];
            http_response_code(401);
            echo json_encode($msg);
        }
    }
}

?>