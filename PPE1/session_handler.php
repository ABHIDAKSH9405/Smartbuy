<?php
// Fichier: session_handler.php
// Gestion des sessions et application des préférences

// Démarrer la session
session_start();

// Fonction pour obtenir le thème actuel
function getCurrentTheme() {
    return $_SESSION['theme'] ?? 'default';
}

// Fonction pour obtenir la langue actuelle
function getCurrentLanguage() {
    return $_SESSION['language'] ?? 'fr';
}

// Fonction pour obtenir le nombre de produits par page
function getProductsPerPage() {
    return $_SESSION['products_per_page'] ?? 12;
}

// Fonction pour générer le CSS dynamique basé sur les préférences
function generateDynamicStyles() {
    $theme = getCurrentTheme();
    
    echo '<style>';
    
    if ($theme === 'dark') {
        echo 'body { background-color: #121212; color: #f0f0f0; }';
        echo '.header { background-color: #1f1f1f; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); }';
        echo '.nav-link, .tool-link { color: #f0f0f0; }';
        echo '.product-card, .checkout-card, .preferences-card { background-color: #2d2d2d; color: #f0f0f0; }';
        echo '.product-name, .checkout-card-title, .preferences-title { color: #f0f0f0; }';
        echo '.search-input, .newsletter-input, .form-input { background-color: #3d3d3d; color: #f0f0f0; border-color: #555; }';
    } elseif ($theme === 'light') {
        echo 'body { background-color: #ffffff; color: #333333; }';
        echo '.header { background-color: #f8f9fa; }';
        echo '.product-card { box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); }';
        echo '.products-section { background-color: #f1f5f9; }';
    }
    
    echo '</style>';
}

// Fonction pour afficher le sélecteur de préférences simplifié
function displayPreferencesLink() {
    echo '<div class="preferences-link">';
    echo '<a href="preferences.php" title="Préférences"><i class="fas fa-cog"></i></a>';
    echo '</div>';
}
?>