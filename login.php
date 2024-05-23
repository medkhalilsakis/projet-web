<?php
require 'connexion.php'; // Inclure le fichier de connexion à la base de données
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        break;
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if (!isset($input["username"]) || !isset($input["password"])) {
            http_response_code(400);
            $msg = ["error" => "Tous les champs sont requis"];
            echo json_encode($msg);
            exit();
        } else {
            login($input);
        }
        break;
}

function login($input)
{
    global $connexion;

    $username = $input["username"];
    $password = $input["password"];

    $query = "SELECT * FROM Client WHERE username = :username";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['mot_de_passe'])) {
            // Mot de passe correct, connexion réussie
            http_response_code(200);
            $msg = ["message" => "Connexion réussie"];
            echo json_encode($msg);
        } else {
            // Mot de passe incorrect
            http_response_code(401);
            $msg = ["error" => "Identifiants invalides"];
            echo json_encode($msg);
        }
    } else {
        // Utilisateur non trouvé
        http_response_code(404);
        $msg = ["error" => "Utilisateur non trouvé"];
        echo json_encode($msg);
    }
}
?>
