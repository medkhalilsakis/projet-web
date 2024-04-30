<?php

require "connexion.php";
header("Content-type:application/json");

$method = $_SERVER["REQUEST_METHOD"];
switch ($method){
    case 'POST':
        //récupère les données envoyées par Angular
        $data = file_get_contents("php://input");
        //convertir la chaîne json en format php
        $inputs = json_decode($data, true);
        $e = $inputs["username"];
        $p = $inputs["password"];
        //$phash = password_hash($p, PASSWORD_DEFAULT);
        $msg = [];
        //préparer la requête
        $sql = "SELECT c.ncin, c.nom, c.prenom, co.roole FROM client c JOIN compte co ON c.ncin = co.ncin WHERE co.username = :user AND co.mot_de_passe = :phash";
        $prepared = $connexion->prepare($sql);
        //liaison entre données et requête préparée
        $prepared->bindParam(":user", $e);
        $prepared->bindParam(":phash", $p);
        //exécuter la requête
        $resultat =  $prepared->execute();
        if($resultat == false){
            //http_response_code(204);
            $msg = ["msg" => "requete sql erronée"];
        }else{
            $r = $prepared->rowCount();
            if($r<=0){
                //http_response_code(204);
                $msg = ["msg" => "Client Inexistant"];
            }
            else{
                http_response_code(201);
                $row = $prepared->fetch(PDO::FETCH_ASSOC);
                $fullName = $row['nom'] . ' ' . $row['prenom'];
                $role = $row['roole'];
                $ncin = $row['ncin'];
                $msg = ['success' => true, 'ncin' => $ncin, 'fullName' => $fullName, 'roole' => $role];
            }
        }
        echo json_encode($msg);
        break;
    default: {
        //http_response_code(500);
        $msg = ["msg" => "method not allowed"];
    }
}
?>