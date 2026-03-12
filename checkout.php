<?php
// ============================================================================
// TRAITEMENT DES COMMANDES - INSERTION DANS LA BASE DE DONNÉES
// ============================================================================

// Vérifier si c'est une requête AJAX POST pour traiter la commande
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
    header("Content-Type: application/json; charset=UTF-8");
    
    // Récupérer les données JSON
    $data = json_decode(file_get_contents("php://input"), true);
    
    if ($data === null) {
        echo json_encode([
            "success" => false,
            "message" => "Format de données invalide"
        ]);
        exit;
    }
    
    // Paramètres de connexion - ADAPTER À VOTRE CONFIGURATION
    $host = "localhost";
    $port = 8889;           // MODIFIER SELON VOTRE CONFIGURATION
    $dbname = "smartbuy";
    $username = "root";
    $password = "root";     // MODIFIER SELON VOTRE CONFIGURATION
    
    try {
        // Connexion à la base de données
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        
        // Validation des données
        if (!isset($data["cart"]) || !is_array($data["cart"]) || empty($data["cart"])) {
            echo json_encode([
                "success" => false,
                "message" => "Panier vide ou invalide"
            ]);
            exit;
        }
        
        // Extraire les données
        $cart = $data["cart"];
        $totals = $data["totals"];
        $utilisateur_id = isset($data["user_id"]) ? $data["user_id"] : null;
        
        // Générer un numéro de commande unique
        $numero_commande = "SMB-" . strtoupper(substr(uniqid(), -8));
        
        // Montants
        $sous_total = floatval($totals["subtotal"]);
        $frais_livraison = floatval($totals["shipping"]);
        $tva = floatval($totals["tax"]);
        $total = floatval($totals["total"]);
        $mode_paiement = "carte_bancaire";
        $statut = "en_attente";
        $date_actuelle = date('Y-m-d H:i:s');
        
        // TRANSACTION - Garantit l'intégrité des données
        $pdo->beginTransaction();
        
        try {
            // ============================================================
            // INSERTION DANS LA TABLE commandes
            // ============================================================
            $sqlCommande = "INSERT INTO commandes (
                utilisateur_id, 
                numero_commande, 
                statut, 
                total, 
                sous_total, 
                frais_livraison, 
                tva, 
                mode_paiement, 
                adresse_id, 
                date_creation, 
                date_modification
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmtCommande = $pdo->prepare($sqlCommande);
            $stmtCommande->execute([
                $utilisateur_id,
                $numero_commande,
                $statut,
                $total,
                $sous_total,
                $frais_livraison,
                $tva,
                $mode_paiement,
                null,
                $date_actuelle,
                $date_actuelle
            ]);
            
            // Récupérer l'ID de la commande créée
            $commande_id = $pdo->lastInsertId();
            
            // ============================================================
            // INSERTION DANS LA TABLE details_commande
            // ============================================================
            $sqlDetail = "INSERT INTO details_commande (
                commande_id, 
                produit_id, 
                nom_produit, 
                prix_produit, 
                quantite
            ) VALUES (?, ?, ?, ?, ?)";
            
            $stmtDetail = $pdo->prepare($sqlDetail);
            
            foreach ($cart as $item) {
                $produit_id = isset($item["id"]) ? $item["id"] : null;
                $nom_produit = $item["name"];
                $prix_produit = floatval($item["price"]);
                $quantite = intval($item["quantity"]);
                
                $stmtDetail->execute([
                    $commande_id,
                    $produit_id,
                    $nom_produit,
                    $prix_produit,
                    $quantite
                ]);
            }
            
            // Valider la transaction
            $pdo->commit();
            
            // Retourner le succès
            echo json_encode([
                "success" => true,
                "message" => "Commande enregistrée avec succès",
                "order_number" => $numero_commande,
                "order_id" => $commande_id
            ]);
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de l'enregistrement: " . $e->getMessage()
            ]);
            exit;
        }
        
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erreur de connexion: " . $e->getMessage()
        ]);
        exit;
    }
}

// ============================================================================
// SI CE N'EST PAS UNE REQUÊTE AJAX, AFFICHER LA PAGE HTML NORMALE
// ============================================================================

// Ajouter en haut du fichier
header('Content-Type: text/html; charset=utf-8');
// Inclure le gestionnaire de session
require_once 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartBuy - Paiement</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="checkout.css">
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
                        <a href="index.html" class="logo-link">
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
                    
                    <!-- Search, User, Cart -->
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
                    <div class="mobile-search">
                        <input
                            type="text"
                            placeholder="Rechercher..."
                            class="mobile-search-input"
                        />
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
                            <a href="#" class="mobile-tool-link" id="mobileUserAccountLink">
                                <i class="fas fa-user"></i>
                                Mon compte
                            </a>
                            <a href="#" class="mobile-tool-link" id="mobileCartLink">
                                <i class="fas fa-shopping-cart"></i>
                                Panier (<span id="mobileCartBadge">0</span>)
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <main>
            <section class="checkout-section">
                <div class="container-inner">
                    <!-- Étapes du checkout -->
                    <div class="checkout-steps">
                        <div class="step-line"></div>
                        <div class="checkout-step active">
                            <div class="step-number">1</div>
                            <div class="step-name">Panier</div>
                        </div>
                        <div class="checkout-step active">
                            <div class="step-number">2</div>
                            <div class="step-name">Paiement</div>
                        </div>
                        <div class="checkout-step">
                            <div class="step-number">3</div>
                            <div class="step-name">Confirmation</div>
                        </div>
                    </div>

                    <div class="success-message" id="successMessage">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Commande confirmée !</h2>
                        <p>Votre commande a été traitée avec succès. Un e-mail de confirmation vous a été envoyé.</p>
                        <p>Numéro de commande : <strong id="orderNumber">SMB-12345</strong></p>
                        <a href="index.php" class="back-to-home">Retour à l'accueil</a>
                    </div>

                    <h1 class="checkout-title">Finaliser votre commande</h1>

                    <div class="checkout-grid" id="checkoutContent">
                        <!-- Détails du paiement -->
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Informations de paiement</h2>
                            
                            <form id="paymentForm" class="payment-form">
                                <div class="form-group">
                                    <label for="cardName">Titulaire de la carte</label>
                                    <input type="text" id="cardName" placeholder="Nom et prénom" required>
                                    <div class="form-error-message">Veuillez entrer le nom du titulaire de la carte</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cardNumber">Numéro de carte</label>
                                    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                    <div class="form-error-message">Veuillez entrer un numéro de carte valide</div>
                                </div>
                                
                                <div class="input-group">
                                    <div class="form-group">
                                        <label for="expiryDate">Date d'expiration</label>
                                        <input type="text" id="expiryDate" placeholder="MM/AA" maxlength="5" required>
                                        <div class="form-error-message">Format invalide (MM/AA)</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" placeholder="123" maxlength="3" required>
                                        <div class="form-error-message">CVV invalide</div>
                                    </div>
                                </div>
                                
                                <h2 class="checkout-card-title" style="margin-top: 2rem;">Adresse de livraison</h2>
                                
                                <div class="form-group">
                                    <label for="fullName">Nom complet</label>
                                    <input type="text" id="fullName" placeholder="Prénom et nom" required>
                                    <div class="form-error-message">Veuillez entrer votre nom complet</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="address">Adresse</label>
                                    <input type="text" id="address" placeholder="Numéro et nom de rue" required>
                                    <div class="form-error-message">Veuillez entrer votre adresse</div>
                                </div>
                                
                                <div class="input-group">
                                    <div class="form-group">
                                        <label for="zipCode">Code postal</label>
                                        <input type="text" id="zipCode" placeholder="75001" maxlength="5" required>
                                        <div class="form-error-message">Code postal invalide</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="city">Ville</label>
                                        <input type="text" id="city" placeholder="Paris" required>
                                        <div class="form-error-message">Veuillez entrer votre ville</div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" placeholder="06 12 34 56 78" required>
                                    <div class="form-error-message">Veuillez entrer un numéro de téléphone valide</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" placeholder="votreemail@exemple.com" required>
                                    <div class="form-error-message">Veuillez entrer une adresse email valide</div>
                                </div>
                                
                                <button type="submit" class="order-button" id="orderButton">
                                    Confirmer la commande
                                </button>
                            </form>
                        </div>
                        
                        <!-- Récapitulatif de commande -->
                        <div class="checkout-card">
                            <h2 class="checkout-card-title">Récapitulatif de la commande</h2>
                            
                            <div class="checkout-items" id="checkoutItems">
                                <!-- Les articles seront ajoutés ici dynamiquement -->
                            </div>
                            
                            <div class="checkout-summary">
                                <div class="summary-row">
                                    <span>Sous-total</span>
                                    <span id="subtotal">0.00 €</span>
                                </div>
                                <div class="summary-row">
                                    <span>Livraison</span>
                                    <span id="shipping">0.00 €</span>
                                </div>
                                <div class="summary-row">
                                    <span>TVA (20%)</span>
                                    <span id="tax">0.00 €</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span id="total">0.00 €</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <p>&copy; <span id="currentYear"></span> PhoneTech. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
    // ========================================================================
    // MODIFICATION CRITIQUE : Envoi vers checkout.php au lieu de process_order.php
    // ========================================================================
    
    // Variables globales
    let cart = [];
    let subTotal = 0;
    let shippingCost = 0;
    let taxRate = 0.2;

    function loadCart() {
        const savedCart = localStorage.getItem('phonetech_cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            updateCartBadge();
            renderCheckoutItems();
            calculateTotals();
        } else {
            window.location.href = 'index.php';
        }
    }

    function updateCartBadge() {
        const desktopBadge = document.getElementById('cartBadge');
        const mobileBadge = document.getElementById('mobileCartBadge');
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        if (desktopBadge) desktopBadge.textContent = totalItems;
        if (mobileBadge) mobileBadge.textContent = totalItems;
    }

    function renderCheckoutItems() {
        const checkoutItemsContainer = document.getElementById('checkoutItems');
        if (!checkoutItemsContainer || !cart.length) return;
        checkoutItemsContainer.innerHTML = '';
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            subTotal += itemTotal;
            const itemElement = document.createElement('div');
            itemElement.className = 'checkout-item';
            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="checkout-item-img">
                <div class="checkout-item-details">
                    <h3 class="checkout-item-name">${item.name}</h3>
                    <p class="checkout-item-price">${item.price.toFixed(2)} €</p>
                    <p class="checkout-item-quantity">Quantité: ${item.quantity}</p>
                </div>
                <div class="checkout-item-total">${itemTotal.toFixed(2)} €</div>
            `;
            checkoutItemsContainer.appendChild(itemElement);
        });
    }

    function calculateTotals() {
        shippingCost = subTotal > 50 ? 0 : 4.99;
        const taxAmount = subTotal * taxRate;
        const total = subTotal + shippingCost;
        document.getElementById('subtotal').textContent = `${subTotal.toFixed(2)} €`;
        document.getElementById('shipping').textContent = `${shippingCost.toFixed(2)} €`;
        document.getElementById('tax').textContent = `${taxAmount.toFixed(2)} €`;
        document.getElementById('total').textContent = `${total.toFixed(2)} €`;
    }

    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        input.value = value;
    }

    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        input.value = value;
    }

    function validateForm() {
        let isValid = true;
        const cardName = document.getElementById('cardName');
        if (!cardName.value.trim()) { setError(cardName, 'Veuillez entrer le nom du titulaire de la carte'); isValid = false; } else { setSuccess(cardName); }
        const cardNumber = document.getElementById('cardNumber');
        const cardNumberValue = cardNumber.value.replace(/\s/g, '');
        if (!cardNumberValue || cardNumberValue.length < 16) { setError(cardNumber, 'Veuillez entrer un numéro de carte valide'); isValid = false; } else { setSuccess(cardNumber); }
        const expiryDate = document.getElementById('expiryDate');
        const expiryValue = expiryDate.value;
        const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
        if (!expiryRegex.test(expiryValue)) { setError(expiryDate, 'Format invalide (MM/AA)'); isValid = false; } else {
            const [month, year] = expiryValue.split('/');
            const expiry = new Date(2000 + parseInt(year), parseInt(month) - 1);
            const today = new Date();
            if (expiry < today) { setError(expiryDate, 'Carte expirée'); isValid = false; } else { setSuccess(expiryDate); }
        }
        const cvv = document.getElementById('cvv');
        if (!cvv.value || cvv.value.length < 3) { setError(cvv, 'CVV invalide'); isValid = false; } else { setSuccess(cvv); }
        const fullName = document.getElementById('fullName');
        if (!fullName.value.trim()) { setError(fullName, 'Veuillez entrer votre nom complet'); isValid = false; } else { setSuccess(fullName); }
        const address = document.getElementById('address');
        if (!address.value.trim()) { setError(address, 'Veuillez entrer votre adresse'); isValid = false; } else { setSuccess(address); }
        const zipCode = document.getElementById('zipCode');
        if (!zipCode.value || zipCode.value.length < 5) { setError(zipCode, 'Code postal invalide'); isValid = false; } else { setSuccess(zipCode); }
        const city = document.getElementById('city');
        if (!city.value.trim()) { setError(city, 'Veuillez entrer votre ville'); isValid = false; } else { setSuccess(city); }
        const phone = document.getElementById('phone');
        if (!phone.value.trim() || phone.value.trim().length < 10) { setError(phone, 'Veuillez entrer un numéro de téléphone valide'); isValid = false; } else { setSuccess(phone); }
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) { setError(email, 'Veuillez entrer une adresse email valide'); isValid = false; } else { setSuccess(email); }
        return isValid;
    }

    function setError(input, message) {
        const formGroup = input.parentElement;
        const errorMessage = formGroup.querySelector('.form-error-message');
        formGroup.classList.remove('success');
        formGroup.classList.add('error');
        errorMessage.textContent = message;
    }

    function setSuccess(input) {
        const formGroup = input.parentElement;
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
    }

    // FONCTION CRITIQUE - Envoi vers checkout.php
    function processPayment(orderData) {
        return new Promise((resolve, reject) => {
            fetch('checkout.php', {  // ENVOI VERS checkout.php
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'  // HEADER POUR IDENTIFIER LA REQUÊTE AJAX
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resolve(data);
                } else {
                    reject(data.message || 'Erreur lors du traitement de la commande');
                }
            })
            .catch(error => {
                reject('Erreur de connexion: ' + error.message);
            });
        });
    }

    function showSuccessMessage(orderNumber) {
        document.getElementById('orderNumber').textContent = orderNumber;
        document.getElementById('successMessage').classList.add('active');
        document.getElementById('checkoutContent').style.display = 'none';
        const steps = document.querySelectorAll('.checkout-step');
        steps[2].classList.add('active');
        localStorage.removeItem('phonetech_cart');
        cart = [];
    }

    function initializeMobileMenu() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileNav = document.getElementById('mobileNav');
        const menuIcon = document.getElementById('menuIcon');
        if (mobileMenuButton && mobileNav && menuIcon) {
            mobileMenuButton.addEventListener('click', () => {
                mobileNav.classList.toggle('active');
                if (mobileNav.classList.contains('active')) {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                } else {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        }
    }

    function setupNavLinks() {
        const cartLinks = [document.getElementById('cartLink'), document.getElementById('mobileCartLink')];
        cartLinks.forEach(link => {
            if (link) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = 'index.php';
                });
            }
        });
        const userLinks = [document.getElementById('userAccountLink'), document.getElementById('mobileUserAccountLink')];
        userLinks.forEach(link => {
            if (link) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = 'index.php';
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
        initializeMobileMenu();
        setupNavLinks();
        const currentYearElement = document.getElementById('currentYear');
        if (currentYearElement) currentYearElement.textContent = new Date().getFullYear();
        const cardNumberInput = document.getElementById('cardNumber');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function() {
                formatCardNumber(this);
            });
        }
        const expiryDateInput = document.getElementById('expiryDate');
        if (expiryDateInput) {
            expiryDateInput.addEventListener('input', function() {
                formatExpiryDate(this);
            });
        }
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!validateForm()) {
                    const firstError = document.querySelector('.form-group.error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }
                const orderButton = document.getElementById('orderButton');
                orderButton.classList.add('loading');
                orderButton.disabled = true;
                const orderData = {
                    cart: cart,
                    totals: {
                        subtotal: subTotal,
                        shipping: shippingCost,
                        tax: subTotal * taxRate,
                        total: subTotal + shippingCost
                    },
                    payment: {
                        cardName: document.getElementById('cardName').value,
                        cardNumber: document.getElementById('cardNumber').value.replace(/\s/g, ''),
                        expiryDate: document.getElementById('expiryDate').value,
                        cvv: document.getElementById('cvv').value
                    },
                    shipping: {
                        fullName: document.getElementById('fullName').value,
                        address: document.getElementById('address').value,
                        zipCode: document.getElementById('zipCode').value,
                        city: document.getElementById('city').value,
                        phone: document.getElementById('phone').value,
                        email: document.getElementById('email').value
                    }
                };
                const savedUser = localStorage.getItem('phonetech_user');
                if (savedUser) {
                    const user = JSON.parse(savedUser);
                    orderData.user_id = user.id;
                }
                try {
                    const response = await processPayment(orderData);
                    orderButton.classList.remove('loading');
                    orderButton.disabled = false;
                    showSuccessMessage(response.order_number);
                } catch (error) {
                    orderButton.classList.remove('loading');
                    orderButton.disabled = false;
                    alert('Une erreur est survenue: ' + error);
                }
            });
        }
    });
    </script>
</body>
</html>