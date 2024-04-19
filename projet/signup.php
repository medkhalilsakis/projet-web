<?php
require 'connexion.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case 'GET': break;
    case 'POST': 
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input["ncin"]) || !isset($input["nom"]) || !isset($input["prenom"]) || !isset($input["date_de_naissance"]) || !isset($input["genre"]) || !isset($input["adresse"]) || !isset($input["gouvernorat"]) || !isset($input["code_postal"]) || !isset($input["numero_telephone"]) || !isset($input["username"]) || !isset($input["email"]) || !isset($input["password"])) {
            http_response_code(400);
            $msg = ["erreur" => "tous les champs sont requis"];
            echo json_encode($msg);
            exit();
        }else{
            ajoutCompte($input);
        }
        break;
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
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

    $adress = $adr . ", " . $code_postal . ", " . $gouv;

    $requete = "INSERT INTO Client (ncin, nom, prenom, date_de_naissance, genre, adresse, num_tel, username, email, mot_de_passe) VALUES(:ncin, :nom, :prenom, :dt, :gr, :adr, :num_tel, :username, :email, :pwd_hash)";    

    $prepared = $connexion->prepare($requete);

    $prepared->bindParam(":ncin", $ncin);
    $prepared->bindParam(":nom", $nom);
    $prepared->bindParam(":prenom", $prenom);
    $prepared->bindParam(":dt", $dt);
    $prepared->bindParam(":gr", $gr);
    $prepared->bindParam(":adr", $adress);
    $prepared->bindParam(":num_tel", $num_tel);
    $prepared->bindParam(":email", $email);
    $prepared->bindParam(":username", $username);
    $prepared->bindParam(":pwd_hash", $pwd_hash);

    $resultat = $prepared->execute();

    if($resultat == false)
    {
        http_response_code(400);
        $msg = ["erreur" => "requete sql erronée"];
        echo json_encode($msg);
    }
    else
    {
        $msg = ["message" => "compte créé avec succès"];
        echo json_encode($msg);
    }
}

?>