<?php
// Fichier: remember_me.php
// Mémorisation du pseudo avec cookies

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_pseudo'])) {
        $pseudo = $_POST['pseudo'] ?? '';
        
        if (!empty($pseudo)) {
            // Enregistrer le pseudo dans un cookie pour 7 jours
            setcookie('user_pseudo', $pseudo, time() + (86400 * 7), '/');
        }
        
        // Rediriger vers la même page pour éviter la resoumission du formulaire
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['forget_pseudo'])) {
        // Supprimer le cookie en définissant une date d'expiration dans le passé
        setcookie('user_pseudo', '', time() - 3600, '/');
        
        // Rediriger vers la même page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Récupérer le pseudo stocké (s'il existe)
$savedPseudo = $_COOKIE['user_pseudo'] ?? '';
$hasPseudo = !empty($savedPseudo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuy - Mon Profil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .remember-me-section {
            padding: 2rem 0;
            background-color: #f9fafb;
            min-height: 70vh;
        }
        
        .remember-me-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .remember-me-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #1f2937;
        }
        
        .welcome-message {
            background-color: #ecfdf5;
            color: #064e3b;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .welcome-icon {
            font-size: 2rem;
            color: #10b981;
            margin-bottom: 0.5rem;
        }
        
        .remember-me-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .remember-me-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4b5563;
        }
        
        .remember-me-form input[type="text"] {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        .remember-me-form input[type="text"]:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }
        
        .remember-me-button {
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
        
        .remember-me-button:hover {
            background-color: #1d4ed8;
        }
        
        .forget-me-button {
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
        
        .forget-me-button:hover {
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
            <section class="remember-me-section">
                <div class="container-inner">
                    <div class="remember-me-card">
                        <h1 class="remember-me-title">Mon Profil</h1>
                        
                        <?php if ($hasPseudo): ?>
                            <div class="welcome-message">
                                <div class="welcome-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h2>Bienvenue, <?php echo htmlspecialchars($savedPseudo); ?> !</h2>
                                
                                <form method="POST" action="">
                                    <button type="submit" name="forget_pseudo" class="forget-me-button">
                                        <i class="fas fa-user-times"></i> Oublier mon pseudo
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form class="remember-me-form" method="POST" action="">
                                <div class="form-group">
                                    <label for="pseudo">Votre pseudo</label>
                                    <input type="text" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" required>
                                </div>
                                
                                <button type="submit" name="submit_pseudo" class="remember-me-button">
                                    <i class="fas fa-save"></i> Enregistrer mon pseudo
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <div style="margin-top: 2rem; text-align: center;">
                            <a href="index.php" class="nav-link">
                                <i class="fas fa-arrow-left"></i> Retour à l'accueil
                            </a>
                        </div>
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