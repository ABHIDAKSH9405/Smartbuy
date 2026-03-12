<?php
// Inclure le gestionnaire de session
require_once 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLanguage(); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuy - Vendre un produit</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="vendre.css">
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
                        <a href="index.php" class="logo-link">
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
                        <a href="index.php" class="tool-link cart-icon">
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
                        <a href="vendre.php" class="mobile-nav-link">Vendre</a>
                        <a href="index.php" class="mobile-nav-link">Contact</a>
                        <a href="preferences.php" class="mobile-nav-link">Préférences</a>
                        <a href="remember_me.php" class="mobile-nav-link">Mon Profil</a>
                        <div class="mobile-tools">
                            <a href="#" class="mobile-tool-link">
                                <i class="fas fa-user"></i>
                                Mon compte
                            </a>
                            <a href="index.php" class="mobile-tool-link">
                                <i class="fas fa-shopping-cart"></i>
                                Panier (0)
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <!-- Sell Product Section -->
            <section class="sell-section">
                <div class="container-inner">
                    <h1 class="sell-title">Vendre un produit</h1>
                    <p class="sell-description">Remplissez le formulaire ci-dessous pour mettre votre smartphone en vente</p>

                    <div class="success-message" id="successMessage">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Produit ajouté avec succès !</h2>
                        <p>Votre produit a été publié et sera visible dans la section "Smartphones populaires".</p>
                        <a href="index.php" class="back-to-home">Retour à l'accueil</a>
                    </div>

                    <form id="sellForm" class="sell-form" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productName">
                                    <i class="fas fa-mobile-alt"></i>
                                    Nom du produit
                                </label>
                                <input
                                    type="text"
                                    id="productName"
                                    name="productName"
                                    placeholder="Ex: Samsung Galaxy S25 Ultra"
                                    required>
                                <div class="form-error-message">Veuillez entrer le nom du produit</div>
                            </div>

                            <div class="form-group">
                                <label for="productBrand">
                                    <i class="fas fa-tags"></i>
                                    Marque
                                </label>
                                <select id="productBrand" name="productBrand" required>
                                    <option value="">Sélectionner une marque</option>
                                    <option value="Samsung">Samsung</option>
                                    <option value="Apple">Apple</option>
                                    <option value="Google">Google</option>
                                    <option value="Xiaomi">Xiaomi</option>
                                    <option value="OnePlus">OnePlus</option>
                                    <option value="Huawei">Huawei</option>
                                    <option value="Oppo">Oppo</option>
                                    <option value="Realme">Realme</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                <div class="form-error-message">Veuillez sélectionner une marque</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="productPrice">
                                    <i class="fas fa-euro-sign"></i>
                                    Prix (€)
                                </label>
                                <input
                                    type="number"
                                    id="productPrice"
                                    name="productPrice"
                                    placeholder="999.99"
                                    step="0.01"
                                    min="0"
                                    required>
                                <div class="form-error-message">Veuillez entrer un prix valide</div>
                            </div>

                            <div class="form-group">
                                <label for="productCondition">
                                    <i class="fas fa-star"></i>
                                    État
                                </label>
                                <select id="productCondition" name="productCondition" required>
                                    <option value="">Sélectionner l'état</option>
                                    <option value="Neuf">Neuf</option>
                                    <option value="Comme neuf">Comme neuf</option>
                                    <option value="Très bon état">Très bon état</option>
                                    <option value="Bon état">Bon état</option>
                                    <option value="État correct">État correct</option>
                                </select>
                                <div class="form-error-message">Veuillez sélectionner l'état du produit</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productDescription">
                                <i class="fas fa-align-left"></i>
                                Description
                            </label>
                            <textarea
                                id="productDescription"
                                name="productDescription"
                                rows="4"
                                placeholder="Décrivez votre produit en détail..."
                                required></textarea>
                            <div class="form-error-message">Veuillez entrer une description</div>
                        </div>

                        <div class="form-group">
                            <label for="productImage">
                                <i class="fas fa-camera"></i>
                                Image du produit
                            </label>
                            <div class="image-upload-container" id="imageUploadContainer">
                                <input
                                    type="file"
                                    id="productImage"
                                    name="productImage"
                                    accept="image/*"
                                    hidden>
                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Glissez-déposez une image ici ou cliquez pour sélectionner</p>
                                    <span class="upload-hint">JPG, PNG ou WEBP (max. 5MB)</span>
                                </div>
                                <div class="image-preview" id="imagePreview" style="display: none;">
                                    <img id="previewImg" src="" alt="Aperçu">
                                    <button type="button" class="remove-image" id="removeImage">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-error-message">Veuillez ajouter une image du produit</div>
                        </div>

                        <div class="form-info">
                            <i class="fas fa-info-circle"></i>
                            <span>La date de création sera ajoutée automatiquement lors de la publication</span>
                        </div>

                        <button type="submit" class="submit-button" id="submitButton">
                            <i class="fas fa-check"></i>
                            Publier mon produit
                        </button>
                    </form>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container-inner">
                <div class="footer-grid">
                    <div class="footer-column">
                        <h3 class="footer-title">SmartBuy</h3>
                        <p class="footer-description">Votre plateforme de vente et d'achat de smartphones en ligne.</p>
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
                                <a href="mailto:contact@smartbuy.fr" class="footer-link">contact@smartbuy.fr</a>
                            </p>
                            <p>
                                <a href="tel:+33123456789" class="footer-link">+33 (0)1 23 45 67 89</a>
                            </p>
                        </address>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p class="footer-date">&copy; <span id="currentYear"></span> SmartBuy. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="vendre.js"></script>
</body>

</html>