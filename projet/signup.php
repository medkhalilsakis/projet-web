<?php
require 'connexion.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case 'POST': 
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input["ncin"]) || !isset($input["nom"]) || !isset($input["prenom"]) || !isset($input["date_de_naissance"]) || !isset($input["genre"]) || !isset($input["adresse"]) || !isset($input["gouvernorat"]) || !isset($input["code_postal"]) || !isset($input["numero_telephone"]) || !isset($input["username"]) || !isset($input["email"]) || !isset($input["password"])) {
            //http_response_code(400);
            $msg = ["msg" => "tous les champs sont requis"];
            echo json_encode($msg);
            exit();
        }else{
            if (checkUserExists(trim($input["ncin"]), trim($input["username"]), trim($input["email"]))) {
                //http_response_code(409);
                $msg = ["msg" => "NCIN, nom d'utilisateur ou email déjà utilisé"];
                echo json_encode($msg);
                exit();
            }else{
                ajoutCompte($input);
                exit();
            }
        }
        break;
    default: {
        //http_response_code(204);
        $msg = ["msg" => "method not allowed"];
    }
}

function checkUserExists($ncin, $username, $email) {
    global $connexion;
  
    $requete = "SELECT COUNT(*) FROM client c JOIN compte co ON c.ncin = co.ncin WHERE c.ncin = :ncin OR c.username = :username OR c.email = :email";
    $prepared = $connexion->prepare($requete);
    $prepared->bindParam(":ncin", $ncin);
    $prepared->bindParam(":username", $username);
    $prepared->bindParam(":email", $email);
    $prepared->execute();
  
    $count = $prepared->fetchColumn(); 
    return $count > 0;
}


function ajoutCompte($input){
    global $connexion;

    $ncin = $input["ncin"];
    $nom = $input["nom"];
    $prenom = $input["prenom"];
    $dt = $input["date_de_naissance"];
    $gr = $input["genre"];
    $adr = $input["adresse"];
    $gouv = $input["gouvernorat"];
    $code_postal = $input["code_postal"];
    $num_tel = $input["numero_telephone"];
    $username = $input["username"];
    $email = $input["email"];
    $pwd = $input["password"];
    $avatar = $input["avatar"];
    //$pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

    $adress = $adr . ", " . $code_postal . ", " . $gouv;

    $requete = "INSERT INTO client (ncin, nom, prenom, date_de_naissance, genre, adresse, num_tel, username, email, avatar) VALUES(:ncin, :nom, :prenom, :dt, :gr, :adr, :num_tel, :username, :email, :avatar)";    

    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":ncin", $ncin);
    $prepared->bindParam(":nom", $nom);
    $prepared->bindParam(":prenom", $prenom);
    $prepared->bindParam(":dt", $dt);
    $prepared->bindParam(":gr", $gr);
    $prepared->bindParam(":adr", $adress);
    $prepared->bindParam(":num_tel", $num_tel);
    $prepared->bindParam(":username", $username);
    $prepared->bindParam(":email", $email);
    $prepared->bindParam(":avatar", $avatar);

    $resultat = $prepared->execute();

    if($resultat){
        $requete2 = "INSERT INTO compte (ncin, username, mot_de_passe, roole) VALUES (:ncin, :username, :pwd_hash, 'C')";    
        $prepared2 = $connexion->prepare($requete2);

        $prepared2->bindParam(":ncin", $ncin);
        $prepared2->bindParam(":username", $username);
        $prepared2->bindParam(":pwd_hash", $pwd);

        $resultat2 = $prepared2->execute();
        if($resultat2){
            http_response_code(201);
            $msg = ["msg" => "compte créé avec succès"];
            echo json_encode($msg);
        }else{
            $msg = ["msg" => "Une erreur lors du création du compte"];
            echo json_encode($msg);
        }
    }
    else{
        //http_response_code(400);
        $msg = ["msg" => "requete sql erronée"];
        echo json_encode($msg);
    }
}



  

?>