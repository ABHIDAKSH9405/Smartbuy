<?php
// Fichier: visit_counter.php
// Compteur de visites utilisant des cookies

// Définir la durée du cookie (30 jours)
$cookieExpiration = time() + (86400 * 30);

// Vérifier si le cookie existe déjà
if (isset($_COOKIE['visit_count'])) {
    // Incrémenter le compteur
    $visitCount = $_COOKIE['visit_count'] + 1;
} else {
    // Première visite
    $visitCount = 1;
}

// Mettre à jour le cookie
setcookie('visit_count', $visitCount, $cookieExpiration, '/');

// Fonction pour afficher le compteur de visites
function displayVisitCounter() {
    global $visitCount;
    echo '<div class="visit-counter">';
    echo 'Vous avez visité notre site ' . $visitCount . ' fois';
    echo '</div>';
}
?>