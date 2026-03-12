<?php
// ============================================================================
// PROCESS_SELL.PHP - Traitement de l'ajout de produit
// ============================================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");

// Vérifier que c'est bien une requête POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Méthode non autorisée"
    ]);
    exit;
}

// Paramètres de connexion à la base de données
$host = "localhost";
$port = 8889;
$dbname = "smartbuy";
$username = "root";
$password = "root";

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    // Récupérer les données du formulaire
    $productName = isset($_POST['productName']) ? trim($_POST['productName']) : '';
    $productBrand = isset($_POST['productBrand']) ? trim($_POST['productBrand']) : '';
    $productPrice = isset($_POST['productPrice']) ? floatval($_POST['productPrice']) : 0;
    $productCondition = isset($_POST['productCondition']) ? trim($_POST['productCondition']) : '';
    $productDescription = isset($_POST['productDescription']) ? trim($_POST['productDescription']) : '';

    // Validation des données
    if (empty($productName) || empty($productBrand) || $productPrice <= 0 || empty($productCondition) || empty($productDescription)) {
        echo json_encode([
            "success" => false,
            "message" => "Tous les champs sont requis"
        ]);
        exit;
    }

    // Gestion de l'upload d'image
    $imagePath = '';

    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';

        // Créer le dossier uploads s'il n'existe pas
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Informations du fichier
        $fileTmpPath = $_FILES['productImage']['tmp_name'];
        $fileName = $_FILES['productImage']['name'];
        $fileSize = $_FILES['productImage']['size'];
        $fileType = $_FILES['productImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Extensions autorisées
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Vérifier la taille (max 5MB)
            if ($fileSize <= 5 * 1024 * 1024) {
                // Créer un nom de fichier unique
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;

                // Déplacer le fichier
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imagePath = 'uploads/' . $newFileName;
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Erreur lors de l'upload de l'image"
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "La taille de l'image ne doit pas dépasser 5MB"
                ]);
                exit;
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Format d'image non autorisé. Utilisez JPG, PNG ou WEBP"
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Veuillez ajouter une image du produit"
        ]);
        exit;
    }

    // Générer un slug à partir du nom du produit
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $productName)));

    // Pour la marque, on va chercher si elle existe déjà dans la table marques
    // Si la table marques n'existe pas, on met NULL pour marque_id
    $marque_id = null;

    // Insérer le produit dans la base de données
    $sql = "INSERT INTO produits (
        nom,
        slug,
        description,
        prix,
        stock,
        image,
        en_vedette,
        nouveaute,
        marque_id,
        date_creation
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $productName,
        $slug,
        $productDescription,
        $productPrice,
        1, // stock: 1 par défaut (produit d'occasion unique)
        $imagePath,
        0, // en_vedette: 0 par défaut
        1, // nouveaute: 1 car c'est un nouveau produit ajouté
        $marque_id // marque_id: NULL pour l'instant
    ]);

    $productId = $pdo->lastInsertId();

    // Retourner la réponse de succès
    echo json_encode([
        "success" => true,
        "message" => "Produit ajouté avec succès",
        "product_id" => $productId
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur de base de données: " . $e->getMessage()
    ]);
}
?>
