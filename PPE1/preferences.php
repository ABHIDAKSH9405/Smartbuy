<?php
// Fichier: preferences.php
// Gestion des préférences utilisateur avec sessions

// Démarrer la session
session_start();

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Enregistrer les préférences
    $_SESSION['theme'] = $_POST['theme'] ?? 'default';
    $_SESSION['language'] = $_POST['language'] ?? 'fr';
    $_SESSION['products_per_page'] = $_POST['products_per_page'] ?? 12;
    
    // Rediriger vers la page précédente ou l'accueil
    $redirect = $_POST['redirect'] ?? 'index.php';
    header('Location: ' . $redirect);
    exit;
}

// Récupérer les préférences actuelles
$theme = $_SESSION['theme'] ?? 'default';
$language = $_SESSION['language'] ?? 'fr';
$productsPerPage = $_SESSION['products_per_page'] ?? 12;

// URL de redirection (la page actuelle)
$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuy - Préférences</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .preferences-section {
            padding: 2rem 0;
            background-color: #f9fafb;
            min-height: 70vh;
        }
        
        .preferences-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .preferences-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #1f2937;
        }
        
        .preferences-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .preferences-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4b5563;
        }
        
        .preferences-form select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        .preferences-form select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }
        
        .save-button {
            display: block;
            width: 100%;
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            padding: 0.875rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
        }
        
        .save-button:hover {
            background-color: #1d4ed8;
        }
        
        .reset-button {
            display: block;
            width: 100%;
            background-color: #f3f4f6;
            color: #4b5563;
            font-weight: 600;
            padding: 0.875rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
            margin-top: 1rem;
        }
        
        .reset-button:hover {
            background-color: #e5e7eb;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header (copié de index.html) -->
        <header class="header">
            <div class="header-container">
                <div class="header-flex">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php" class="logo-link">
                            SmartBuy
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="desktop-nav">
                        <a href="index.php" class="nav-link">Catégories</a>
                        <a href="index.php" class="nav-link">Nouveautés</a>
                        <a href="index.php" class="nav-link">Promotions</a>
                        <a href="index.php" class="nav-link">Contact</a>
                        <a href="preferences.php" class="nav-link">Préférences</a>
                        <a href="remember_me.php" class="nav-link">Mon Profil</a>
                    </nav>
                    
                    <!-- Search, User, Cart (copié de index.html) -->
                    <div class="desktop-tools">
                        <div class="search-container">
                            <input
                                type="text"
                                placeholder="Rechercher..."
                                class="search-input"
                            />
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <a href="#" class="tool-link" id="userAccountLink">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="#" class="tool-link cart-icon" id="cartLink">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cartBadge">
                                0
                            </span>
                        </a>
                        <?php displayPreferencesLink(); ?>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button
                        class="mobile-menu-button"
                        id="mobileMenuButton"
                    >
                        <i class="fas fa-bars" id="menuIcon"></i>
                    </button>
                </div>
                
                <!-- Mobile Navigation -->
                <div class="mobile-nav" id="mobileNav">
                    <!-- Contenu mobile copié de index.html -->
                </div>
            </div>
        </header>

        <main>
            <section class="preferences-section">
                <div class="container-inner">
                    <div class="preferences-card">
                        <h1 class="preferences-title">Vos préférences</h1>
                        <form class="preferences-form" method="POST" action="preferences.php">
                            <div class="form-group">
                                <label for="theme">Thème</label>
                                <select id="theme" name="theme">
                                    <option value="default" <?php echo $theme === 'default' ? 'selected' : ''; ?>>Défaut</option>
                                    <option value="dark" <?php echo $theme === 'dark' ? 'selected' : ''; ?>>Sombre</option>
                                    <option value="light" <?php echo $theme === 'light' ? 'selected' : ''; ?>>Clair</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="language">Langue</label>
                                <select id="language" name="language">
                                    <option value="fr" <?php echo $language === 'fr' ? 'selected' : ''; ?>>Français</option>
                                    <option value="en" <?php echo $language === 'en' ? 'selected' : ''; ?>>English</option>
                                    <option value="es" <?php echo $language === 'es' ? 'selected' : ''; ?>>Español</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="products_per_page">Produits par page</label>
                                <select id="products_per_page" name="products_per_page">
                                    <option value="12" <?php echo $productsPerPage == 12 ? 'selected' : ''; ?>>12</option>
                                    <option value="24" <?php echo $productsPerPage == 24 ? 'selected' : ''; ?>>24</option>
                                    <option value="36" <?php echo $productsPerPage == 36 ? 'selected' : ''; ?>>36</option>
                                </select>
                            </div>
                            
                            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                            
                            <button type="submit" class="save-button">Enregistrer les préférences</button>
                            <a href="preferences.php?reset=1" class="reset-button">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer (copié de index.html) -->
        <footer class="footer">
            <!-- Contenu du footer -->
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>