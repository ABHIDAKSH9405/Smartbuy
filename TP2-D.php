<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "root";
$baseDeDonnees = "smartbuy";
$port = 8889; 

//connexion à la base de données 
$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $baseDeDonnees,$port);

if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}

//insertion d'un utilisateur dans la base de données 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $prenom = ""; // Valeur par défaut pour le prénom
    $mot_de_passe = password_hash("motdepassetemporaire", PASSWORD_DEFAULT); // Mot de passe par défaut sécurisé
    $date_actuelle = date("Y-m-d H:i:s"); // Date actuelle pour date_creation
    $est_admin = 0; // Par défaut, l'utilisateur n'est pas administrateur

    //vérification de l'@ mail
    $sql1 = "SELECT * FROM utilisateurs WHERE email= ?";
    $stmnt = $connexion->prepare($sql1);
    $stmnt->bind_param('s', $email);
    $stmnt->execute();
    $resultat = $stmnt->get_result(); //tous les enregistrements avec @mail == $email

    if($resultat->num_rows > 0){
        echo "<br>Adresse mail déjà utilisée";
    } else {
        // Insertion avec tous les champs nécessaires
        $sql2 = "INSERT INTO utilisateurs (nom, email, prenom, mot_de_passe, date_creation, derniere_connexion, administrateur) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmnt = $connexion->prepare($sql2);
        $stmnt->bind_param('ssssssi', $nom, $email, $prenom, $mot_de_passe, $date_actuelle, $date_actuelle, $est_admin);
        
        if($stmnt->execute()){
            echo "<br> Utilisateur enregistré avec succès.";
        } else {
            echo "<br> Erreur d'enregistrement: " . $stmnt->error;
        }
    }
}

// Affichage des utilisateurs enregistrés (cette partie s'exécutera toujours)
$sql = "SELECT id, nom, prenom, email, date_creation FROM utilisateurs";
$resultat = $connexion->query($sql);

if ($resultat && $resultat->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Date d'inscription</th></tr>";
    while ($row = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nom"] . "</td>";
        echo "<td>" . $row["prenom"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["date_creation"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucun utilisateur enregistré.";
}
?>