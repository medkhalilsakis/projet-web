<?php

require "connexion.php";
header("Content-type:application/json");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method){
    case 'GET':
        $ncin = $_GET['ncin'];
        afficherVehicule($ncin);
        break;
    
    case 'DELETE':
        $num_immatriculation = $_GET['num_immatriculation'];
        SupprimerVehicule($num_immatriculation);
        break;

    case 'POST':
        $data = file_get_contents("php://input");
        $inputs = json_decode($data, true);
        ajouterVehicule($inputs);
        break;
    
    case 'PUT':
        $data = file_get_contents("php://input");
        $inputs = json_decode($data, true);
        modifierVehicule($inputs);
        break;

    default: break;
}

function afficherVehicule($ncin){
    global $connexion;
    $requete = "SELECT * FROM vehicule WHERE ncin_client = :ncin";
    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":ncin", $ncin);
    $resultat = $prepared->execute();

    if($resultat){
        $sql = $prepared->fetchAll(PDO::FETCH_ASSOC);
        if (empty($sql)) {
            echo json_encode(["message" => "Aucun véhicule trouvé pour ce NCIN"]);
        }else{
            echo json_encode($sql);
        }
    }else{
        //http_response_code(400);
        $msg = ["msg" => "requete sql erronée"];
        echo json_encode($msg);
    }
}
function SupprimerVehicule($num_immatriculation){
    global $connexion;
    $requete = "DELETE FROM vehicule WHERE num_immatriculation = :num_immatriculation";
    $prepared = $connexion->prepare($requete);
    $prepared->bindParam(":num_immatriculation", $num_immatriculation);
    $resultat = $prepared->execute();

    if($resultat){
        echo json_encode(["message" => "Suppression effectuée"]);
    }else{
        echo json_encode(["message" => "Erreur lors du suppression"]);
    }
}
function ajouterVehicule($inputs){
    global $connexion;

    $numimm = $inputs["num_immatriculation"];
    $marque = $inputs["marque"];
    $type = $inputs["type"];
    $nbr_places = $inputs["nbr_places"];
    $ncin = $inputs["ncin_client"];
    $dt = date('Y-m-d');

    $sql = "SELECT num_immatriculation FROM vehicule WHERE num_immatriculation = :numimm";
    $prepared = $connexion->prepare($sql);

    $prepared->bindParam(":numimm", $numimm);

    $resultat =  $prepared->execute();

    if($resultat){
        $r = $prepared->rowCount();
        if($r>0){
            //http_response_code(204);
            echo json_encode(["msg" => "Véhicule existe déja"]);
        }else{
            $requete = "INSERT INTO vehicule (num_immatriculation, marque, type, nbr_places, ncin_client, date_ajout) VALUES(:numimm, :marque, :type, :nbr_places, :ncin, :dt)";    

            $prepared2 = $connexion->prepare($requete);

            $prepared2->bindParam(":numimm", $numimm);
            $prepared2->bindParam(":marque", $marque);
            $prepared2->bindParam(":type", $type);
            $prepared2->bindParam(":nbr_places", $nbr_places);
            $prepared2->bindParam("ncin", $ncin);
            $prepared2->bindParam(":dt", $dt);

            $resultat2 = $prepared2->execute();

            if($resultat2){
                http_response_code(201);
                echo json_encode(["msg" => "Ajout du vehicule avec succés"]);
            }else{
                echo json_encode(["msg" => "Erreur lors de l'ajout"]);
            }
        }
    }else{
        echo json_encode(["msg" => "Erreur interne"]);
    }
}
function modifierVehicule($inputs){
    global $connexion;

    $oldimm = $inputs["ancien_num_imm"];
    $numimm = $inputs["num_immatriculation"];
    $marque = $inputs["marque"];
    $type = $inputs["type"];
    $nbr_places = $inputs["nbr_places"];

    $sql = "SELECT num_immatriculation FROM vehicule WHERE num_immatriculation = :oldnumimm";
    $prepared = $connexion->prepare($sql);

    $prepared->bindParam(":oldnumimm", $oldimm);

    $resultat =  $prepared->execute();

    if($resultat){
        $r = $prepared->rowCount();
        if($r<=0){
            //http_response_code(204);
            echo json_encode(["msg" => "Véhicule n'existe pas"]);
        }else{
            $requete = "UPDATE vehicule SET num_immatriculation = :numimm, marque = :marque, type = :type, nbr_places = :nbr_places WHERE num_immatriculation=:oldnumimm";    

            $prepared2 = $connexion->prepare($requete);

            $prepared2->bindParam(":oldnumimm", $oldimm);
            $prepared2->bindParam(":numimm", $numimm);
            $prepared2->bindParam(":marque", $marque);
            $prepared2->bindParam(":type", $type);
            $prepared2->bindParam(":nbr_places", $nbr_places);

            $resultat2 = $prepared2->execute();

            if($resultat2){
                http_response_code(201);
                echo json_encode(["msg" => "Modification des informations avec succés"]);
            }else{
                echo json_encode(["msg" => "Erreur lors du modification"]);
            }
        }
    }else{
        echo json_encode(["msg" => "Erreur interne"]);
    }
}
?>