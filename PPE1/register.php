<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoriser les requêtes CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "root", "smartbuy", 8889);

// Vérifier la connexion
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erreur de connexion: " . $conn->connect_error]));
}

// Récupérer les données envoyées
$data = json_decode(file_get_contents("php://input"), true);

// Si aucune donnée n'est reçue
if (!$data) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue"]);
    exit;
}

// Extraire les données
$firstName = $conn->real_escape_string($data['first_name']);
$lastName = $conn->real_escape_string($data['last_name']);
$email = $conn->real_escape_string($data['email']);
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hachage sécurisé
$created_at = date('Y-m-d H:i:s');

// Vérifier si l'email existe déjà
$check = $conn->query("SELECT * FROM utilisateurs WHERE email = '$email'");
if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé"]);
    exit;
}

// CHOISIR UNE SEULE TABLE - utilisateurs ou users
// Insérer l'utilisateur dans la table 'utilisateurs'
$sql = "INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, date_creation) 
        VALUES ('$firstName', '$lastName', '$email', '$password', '$created_at')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Compte créé avec succès"]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur: " . $conn->error]);
}

$conn->close();
?>