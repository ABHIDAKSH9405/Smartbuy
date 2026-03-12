<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Désactiver l'affichage des erreurs en production
// error_reporting(0);

// Autoriser les requêtes CORS depuis votre site
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Récupérer les données envoyées en POST (format JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Si la méthode n'est pas POST ou si les données ne sont pas au format JSON
if ($_SERVER["REQUEST_METHOD"] !== "POST" || $data === null) {
    echo json_encode([
        "success" => false,
        "message" => "Méthode non autorisée ou format de données invalide"
    ]);
    exit;
}

// Paramètres de connexion à la base de données
$host = "localhost";
$port = 8889;        // Changez 3307 en 8889
$dbname = "smartbuy";
$username = "root";  
$password = "root";  // Changez "" en "root"

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    
    // Validation des données reçues
    if (!isset($data["email"]) || !isset($data["password"]) || 
        empty(trim($data["email"])) || empty($data["password"])) {
        echo json_encode([
            "success" => false,
            "message" => "Email et mot de passe requis"
        ]);
        exit;
    }
    
    $email = trim($data["email"]);
    $password = $data["password"];
    
    // Rechercher l'utilisateur par email
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user["mot_de_passe"])) {
        // Mettre à jour la date de dernière connexion
        $updateStmt = $pdo->prepare("UPDATE utilisateurs SET derniere_connexion = ? WHERE id = ?");
        $updateStmt->execute([date('Y-m-d H:i:s'), $user["id"]]);
    
        // Créer un tableau avec les informations de l'utilisateur
        $userData = [
            "id" => $user["id"],
            "first_name" => $user["prenom"],  // Garder first_name comme clé pour JS
            "last_name" => $user["nom"],     // Garder last_name comme clé pour JS
            "email" => $user["email"]
        ];
        
        echo json_encode([
            "success" => true,
            "message" => "Connexion réussie",
            "user" => $userData
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Email ou mot de passe incorrect"
        ]);
    }
    
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur lors de la connexion: " . $e->getMessage()
        // Version production: "message" => "Une erreur est survenue lors de la connexion"
    ]);
}
?>