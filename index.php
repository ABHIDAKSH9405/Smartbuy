<?php
// Inclure le compteur de visites
require_once 'visit_counter.php';
// Inclure le gestionnaire de session
require_once 'session_handler.php';

// Connexion à la base de données pour récupérer les produits
$host = "localhost";
$port = 8889;
$dbname = "smartbuy";
$username = "root";
$password = "root";

$products = [];

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    // Récupérer les produits depuis la base de données
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY date_creation DESC");
    $products = $stmt->fetchAll();

} catch (PDOException $e) {
    // En cas d'erreur, on continue avec un tableau vide
    error_log("Erreur DB: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLanguage(); ?>">

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuy - Boutique en ligne</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php generateDynamicStyles(); ?>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="header-container">
                <div class="header-flex">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="#" class="logo-link">
                            SmartBuy
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="desktop-nav">
                        <a href="index.php" class="nav-link">Catégories</a>
                        <a href="index.php" class="nav-link">Nouveautés</a>
                        <a href="index.php" class="nav-link">Promotions</a>
                        <a href="vendre.php" class="nav-link">Vendre</a>
                        <a href="index.php" class="nav-link">Contact</a>
                    </nav>

                    <!-- Search, User, Cart -->
                    <div class="desktop-tools">
                        <div class="search-container">
                            <input
                                type="text"
                                placeholder="Rechercher..."
                                class="search-input" />
                            <i class="fas fa-search search-icon"></i>
                        </div>
                        <a href="#" class="tool-link">
                            <i class="fas fa-user"></i>
                        </a>
                        <a href="#" class="tool-link cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">
                                0
                            </span>
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button
                        class="mobile-menu-button"
                        id="mobileMenuButton">
                        <i class="fas fa-bars" id="menuIcon"></i>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div class="mobile-nav" id="mobileNav">
                    <div class="mobile-search">
                        <input
                            type="text"
                            placeholder="Rechercher..."
                            class="mobile-search-input" />
                        <i class="fas fa-search mobile-search-icon"></i>
                    </div>
                    <nav class="mobile-nav-links">
                        <a href="index.php" class="mobile-nav-link">Smartphones</a>
                        <a href="index.php" class="mobile-nav-link">Accessoires</a>
                        <a href="index.php" class="mobile-nav-link">Promotions</a>
                        <a href="index.php" class="mobile-nav-link">Contact</a>
                        <a href="preferences.php" class="mobile-nav-link">Préférences</a>
                        <a href="remember_me.php" class="mobile-nav-link">Mon Profil</a>
                        <div class="mobile-tools">
                            <a href="#" class="mobile-tool-link">
                                <i class="fas fa-user"></i>
                                Mon compte
                            </a>
                            <a href="#" class="mobile-tool-link">
                                <i class="fas fa-shopping-cart"></i>
                                Panier (3)
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Banner Carousel -->
            <section class="hero-section">
                <div class="carousel-container">
                    <div class="carousel-slide" data-id="1">
                        <div class="carousel-overlay"></div>
                        <img src="https://www.darty.com/assets/animco/4/43603e71-51c9-48ac-81a5-7b52d97472d9.jpeg" alt="Nouvelle Collection" class="carousel-img" />
                        <div class="carousel-content">
                            <h2 class="carousel-title">Nouvelle Collection</h2>
                            <p class="carousel-description">Découvrez nos nouveautés pour cette saison</p>
                            <a href="#" class="carousel-button">Découvrir</a>
                        </div>
                    </div>
                    <div class="carousel-slide" data-id="2">
                        <div class="carousel-overlay"></div>
                        <img src="https://picsum.photos/1200/401" alt="Soldes d'Été" class="carousel-img" />
                        <div class="carousel-content">
                            <h2 class="carousel-title">Soldes d'Été</h2>
                            <p class="carousel-description">Jusqu'à 50% de réduction sur des centaines d'articles</p>
                            <a href="#" class="carousel-button">Découvrir</a>
                        </div>
                    </div>
                    <div class="carousel-slide" data-id="3">
                        <div class="carousel-overlay"></div>
                        <img src="https://picsum.photos/1200/402" alt="Livraison Gratuite" class="carousel-img" />
                        <div class="carousel-content">
                            <h2 class="carousel-title">Livraison Gratuite</h2>
                            <p class="carousel-description">Pour toute commande supérieure à 50€</p>
                            <a href="#" class="carousel-button">Découvrir</a>
                        </div>
                    </div>

                    <button class="carousel-prev" id="prevSlide">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <button class="carousel-next" id="nextSlide">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="carousel-dots">
                        <button class="carousel-dot active" data-index="0"></button>
                        <button class="carousel-dot" data-index="1"></button>
                        <button class="carousel-dot" data-index="2"></button>
                    </div>
                </div>
            </section>

            <!-- Featured Products -->
            <section class="products-section">
                <div class="container-inner">
                    <h2 class="section-title white">Smartphones populaires</h2>
                    <div class="products-grid">
                        <?php
                        // Produits statiques par défaut si aucun produit dans la BDD
                        $defaultProducts = [
                            [
                                'id' => 1,
                                'nom' => 'Samsung Galaxy S25',
                                'prix' => 999.99,
                                'image' => 'https://www.samsungshop.tn/28306-large_default/galaxy-s25-ultra-prix-tunisie.jpg',
                                'nouveaute' => 1
                            ],
                            [
                                'id' => 2,
                                'nom' => 'Apple iPhone 16 Pro Max',
                                'prix' => 1199.99,
                                'image' => 'https://m.media-amazon.com/images/I/6104qhRgADL.jpg',
                                'nouveaute' => 1
                            ],
                            [
                                'id' => 3,
                                'nom' => 'Google Pixel 9',
                                'prix' => 899.99,
                                'image' => 'https://cartronics.be/62207-large_default/google-pixel-9-pro-xl.jpg',
                                'nouveaute' => 1
                            ],
                            [
                                'id' => 4,
                                'nom' => 'Xiaomi 15 Pro',
                                'prix' => 799.99,
                                'image' => 'https://msfsale.cl/wp-content/uploads/2024/12/xiaomi-15-pro-web.jpg',
                                'nouveaute' => 1
                            ]
                        ];

                        // Utiliser les produits de la BDD s'ils existent, sinon les produits par défaut
                        $displayProducts = !empty($products) ? $products : $defaultProducts;

                        // Afficher chaque produit
                        foreach ($displayProducts as $product):
                            // Déterminer le badge à afficher
                            $badge = 'Nouveau';
                            if (isset($product['nouveaute']) && $product['nouveaute'] == 1) {
                                $badge = 'Nouveau';
                            } elseif (isset($product['en_vedette']) && $product['en_vedette'] == 1) {
                                $badge = 'En vedette';
                            }
                        ?>
                        <div class="product-card" data-id="<?php echo htmlspecialchars($product['id']); ?>">
                            <div class="product-img-container">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" class="product-img" />
                                <div class="product-badge"><?php echo htmlspecialchars($badge); ?></div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['nom']); ?></h3>
                                <div class="product-rating">
                                    <div class="stars">★★★★☆</div>
                                    <span class="rating-count"><?php echo isset($product['note']) ? '(' . number_format($product['note'], 1) . ')' : '(4.5)'; ?></span>
                                </div>
                                <div class="product-price"><?php echo number_format($product['prix'], 2, ',', ' '); ?> €</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="products-more">
                        <a href="#" class="more-button">Voir plus de produits</a>
                    </div>
                </div>
            </section>

            <!-- Special Offers -->
            <section class="offers-section">
                <div class="container-inner">
                    <h2 class="section-title">Offres spéciales</h2>
                    <div class="offers-grid">
                        <div class="offer-card">
                            <div class="offer-content">
                                <div class="offer-img-container">
                                    <img src="https://picsum.photos/300/304" alt="Pack Complet Audio" class="offer-img" />
                                </div>
                                <div class="offer-info">
                                    <div class="offer-tag">Offre limitée</div>
                                    <h3 class="offer-title">Pack Galaxy S25 Ultra</h3>
                                    <p class="offer-description">Profitez de notre offre exceptionnelle comprenant le Galaxy S25 Ultra avec écouteurs Galaxy Buds et une coque de protection.</p>
                                    <div class="offer-price">
                                        <span class="current-price">299.99 €</span>
                                        <span class="original-price">399.99 €</span>
                                        <span class="discount-badge">-25%</span>
                                    </div>
                                    <a href="#" class="offer-button">En profiter</a>
                                </div>
                            </div>
                        </div>

                        <div class="offer-card">
                            <div class="offer-content">
                                <div class="offer-img-container">
                                    <img src="https://picsum.photos/300/305" alt="Smartphone Premium" class="offer-img" />
                                </div>
                                <div class="offer-info">
                                    <div class="offer-tag">Fin de série</div>
                                    <h3 class="offer-title">iPhone 15 Pro Max</h3>
                                    <p class="offer-description">Dernières pièces disponibles pour l'iPhone 15 Pro Max avec son appareil photo professionnel et sa puce A17 Pro.</p>
                                    <div class="offer-price">
                                        <span class="current-price">699.99 €</span>
                                        <span class="original-price">899.99 €</span>
                                        <span class="discount-badge">-22%</span>
                                    </div>
                                    <a href="#" class="offer-button">En profiter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Newsletter -->
            <section class="newsletter-section">
                <div class="container-inner">
                    <h2 class="newsletter-title">Inscrivez-vous à notre newsletter</h2>
                    <p class="newsletter-description">Recevez en avant-première les annonces de nouveaux smartphones et nos offres exclusives directement dans votre boîte mail.</p>
                    <form class="newsletter-form">
                        <input
                            type="email"
                            placeholder="Votre adresse email"
                            class="newsletter-input"
                            required />
                        <button type="submit" class="newsletter-button">S'inscrire</button>
                    </form>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container-inner">
                <div class="footer-grid">
                    <div class="footer-column">
                        <h3 class="footer-title">BoutiqueNext</h3>
                        <p class="footer-description">Votre boutique en ligne pour tous vos besoins en électronique, mode, maison et bien plus encore.</p>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>

                    <div class="footer-column">
                        <h3 class="footer-title">Catégories</h3>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Smartphones Android</a></li>
                            <li><a href="#" class="footer-link">iPhones</a></li>
                            <li><a href="#" class="footer-link">Coques & Protection</a></li>
                            <li><a href="#" class="footer-link">Chargeurs</a></li>
                            <li><a href="#" class="footer-link">Écouteurs & Audio</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h3 class="footer-title">Aide & Information</h3>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Service client</a></li>
                            <li><a href="#" class="footer-link">Livraison</a></li>
                            <li><a href="#" class="footer-link">Retours & Remboursements</a></li>
                            <li><a href="#" class="footer-link">FAQ</a></li>
                            <li><a href="#" class="footer-link">Conditions générales</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h3 class="footer-title">Contact</h3>
                        <address class="footer-address">
                            <p>12 Rue du Commerce</p>
                            <p>75001 Paris, France</p>
                            <p class="footer-spacer">
                                <a href="mailto:contact@boutiquenext.fr" class="footer-link">contact@boutiquenext.fr</a>
                            </p>
                            <p>
                                <a href="tel:+33123456789" class="footer-link">+33 (0)1 23 45 67 89</a>
                            </p>
                        </address>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p class="footer-date">&copy; <span id="currentYear"></span> PhoneTech. Tous droits réservés.</p>
                </div>
            </div>
            <?php displayVisitCounter(); ?>
        </footer>
    </div>

    <script src="script.js"></script>
</body>

</html>