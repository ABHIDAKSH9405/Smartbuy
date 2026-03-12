// Fonctionnalités du compte utilisateur
let userModal;
let currentUser = null;

// Mettre à jour l'interface utilisateur après connexion/déconnexion
function updateUserInterface() {
    const desktopUserIcon = document.querySelector('.tool-link .fa-user');
    const mobileUserText = document.querySelector('.mobile-tool-link:first-child');
    
    if (currentUser) {
        // Utilisateur connecté
        if (desktopUserIcon) {
            desktopUserIcon.classList.remove('fa-user');
            desktopUserIcon.classList.add('fa-user-check');
        }
        
        if (mobileUserText) {
            mobileUserText.innerHTML = `<i class="fas fa-user-check"></i> ${currentUser.firstName}`;
        }
    } else {
        // Utilisateur non connecté
        if (desktopUserIcon) {
            desktopUserIcon.classList.remove('fa-user-check');
            desktopUserIcon.classList.add('fa-user');
        }
        
        if (mobileUserText) {
            mobileUserText.innerHTML = `<i class="fas fa-user"></i> Mon compte`;
        }
    }
}

// Créer la modal du compte utilisateur
function createUserModal() {
    const modal = document.createElement('div');
    modal.id = 'userModal';
    modal.className = 'user-modal';
    
    modal.innerHTML = `
        <div class="user-modal-content">
            <div class="user-modal-header">
                <h3 id="userModalTitle">Créer un compte</h3>
                <button id="closeUserButton" class="close-user-button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="user-modal-body">
                <!-- Formulaire de création de compte -->
                <form id="registerForm" class="user-form active">
                    <div class="form-group">
                        <label for="firstName">Prénom</label>
                        <input type="text" id="firstName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Nom</label>
                        <input type="text" id="lastName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email</label>
                        <input type="email" id="registerEmail" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPassword">Mot de passe</label>
                        <input type="password" id="registerPassword" class="form-input" required>
                        <small>Le mot de passe doit contenir au moins 8 caractères</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirmer le mot de passe</label>
                        <input type="password" id="confirmPassword" class="form-input" required>
                    </div>
                    <div class="form-group checkbox">
                        <input type="checkbox" id="termsAccept" required>
                        <label for="termsAccept">J'accepte les conditions générales d'utilisation</label>
                    </div>
                    <div class="form-error" id="registerError"></div>
                    <button type="submit" class="submit-button">Créer mon compte</button>
                    
                    <div class="form-switch">
                        Déjà inscrit ? <a href="#" id="switchToLogin">Se connecter</a>
                    </div>
                </form>
                
                <!-- Formulaire de connexion -->
                <form id="loginForm" class="user-form">
                    <div class="form-group">
                        <label for="loginEmail">Email</label>
                        <input type="email" id="loginEmail" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Mot de passe</label>
                        <input type="password" id="loginPassword" class="form-input" required>
                    </div>
                    <div class="form-group checkbox">
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe">Se souvenir de moi</label>
                    </div>
                    <div class="form-error" id="loginError"></div>
                    <button type="submit" class="submit-button">Se connecter</button>
                    
                    <div class="form-options">
                        <a href="#" id="forgotPassword">Mot de passe oublié ?</a>
                    </div>
                    
                    <div class="form-switch">
                        Pas encore de compte ? <a href="#" id="switchToRegister">S'inscrire</a>
                    </div>
                </form>
                
                <!-- Profil utilisateur (quand connecté) -->
                <div id="userProfile" class="user-profile">
                    <div class="profile-header">
                        <i class="fas fa-user-circle profile-icon"></i>
                        <div class="profile-name" id="profileName"></div>
                        <div class="profile-email" id="profileEmail"></div>
                    </div>
                    
                    <div class="profile-actions">
                        <a href="#" class="profile-action">
                            <i class="fas fa-shopping-bag"></i>
                            Mes commandes
                        </a>
                        <a href="#" class="profile-action">
                            <i class="fas fa-heart"></i>
                            Mes favoris
                        </a>
                        <a href="#" class="profile-action">
                            <i class="fas fa-map-marker-alt"></i>
                            Mes adresses
                        </a>
                        <a href="#" class="profile-action">
                            <i class="fas fa-cog"></i>
                            Paramètres du compte
                        </a>
                    </div>
                    
                    <button id="logoutButton" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                        Se déconnecter
                    </button>
                </div>
                
                <!-- Formulaire de récupération de mot de passe -->
                <form id="forgotPasswordForm" class="user-form">
                    <p>Entrez votre adresse email pour recevoir un lien de réinitialisation du mot de passe.</p>
                    <div class="form-group">
                        <label for="resetEmail">Email</label>
                        <input type="email" id="resetEmail" class="form-input" required>
                    </div>
                    <div class="form-error" id="resetError"></div>
                    <button type="submit" class="submit-button">Envoyer le lien</button>
                    
                    <div class="form-switch">
                        <a href="#" id="backToLogin">Retour à la connexion</a>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Ajouter les événements
    const closeButton = document.getElementById('closeUserButton');
    closeButton.addEventListener('click', toggleUserModal);
    
    // Fermer la modal en cliquant en dehors du contenu
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            toggleUserModal();
        }
    });
    
    // Basculer entre les formulaires
    const switchToLogin = document.getElementById('switchToLogin');
    const switchToRegister = document.getElementById('switchToRegister');
    const forgotPasswordLink = document.getElementById('forgotPassword');
    const backToLoginLink = document.getElementById('backToLogin');
    
    switchToLogin.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('login');
    });
    
    switchToRegister.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('register');
    });
    
    forgotPasswordLink.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('forgot');
    });
    
    backToLoginLink.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('login');
    });
    
    // Soumettre les formulaires
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        registerUser();
    });
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        loginUser();
    });
    
    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        resetPassword();
    });
    
    // Déconnexion
    const logoutButton = document.getElementById('logoutButton');
    logoutButton.addEventListener('click', function() {
        logoutUser();
    });
    
    return modal;
}

// Afficher un formulaire spécifique
function showForm(formType) {
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const userProfile = document.getElementById('userProfile');
    const modalTitle = document.getElementById('userModalTitle');
    
    // Cacher tous les formulaires
    registerForm.classList.remove('active');
    loginForm.classList.remove('active');
    forgotPasswordForm.classList.remove('active');
    userProfile.classList.remove('active');
    
    // Afficher le formulaire demandé
    switch(formType) {
        case 'register':
            registerForm.classList.add('active');
            modalTitle.textContent = 'Créer un compte';
            break;
        case 'login':
            loginForm.classList.add('active');
            modalTitle.textContent = 'Se connecter';
            break;
        case 'forgot':
            forgotPasswordForm.classList.add('active');
            modalTitle.textContent = 'Récupération de mot de passe';
            break;
        case 'profile':
            userProfile.classList.add('active');
            modalTitle.textContent = 'Mon compte';
            updateProfileInfo();
            break;
    }
}

// Mettre à jour les informations du profil
function updateProfileInfo() {
    if (!currentUser) return;
    
    const profileName = document.getElementById('profileName');
    const profileEmail = document.getElementById('profileEmail');
    
    profileName.textContent = `${currentUser.firstName} ${currentUser.lastName}`;
    profileEmail.textContent = currentUser.email;
}

// Basculer l'affichage de la modal du compte
function toggleUserModal() {
    if (!userModal) {
        userModal = createUserModal();
    }
    
    userModal.classList.toggle('active');
    
    if (userModal.classList.contains('active')) {
        document.body.style.overflow = 'hidden'; // Empêcher le défilement du corps
        
        // Afficher le formulaire approprié
        if (currentUser) {
            showForm('profile');
        } else {
            showForm('login');
        }
    } else {
        document.body.style.overflow = ''; // Réactiver le défilement
    }
}

// Enregistrer un nouvel utilisateur - version placeholder pour SQL
// Enregistrer un nouvel utilisateur
function registerUser() {
    // Récupérer les valeurs
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('registerEmail').value.trim();
    const password = document.getElementById('registerPassword').value;
    const errorElement = document.getElementById('registerError');
    
    // Validation basique
    if (!firstName || !lastName || !email || !password) {
        errorElement.textContent = 'Veuillez remplir tous les champs obligatoires.';
        return;
    }
    
    // Données à envoyer
    const userData = {
        first_name: firstName,
        last_name: lastName,
        email: email,
        password: password
    };
    
    // Afficher message d'attente
    errorElement.textContent = 'Création du compte en cours...';
    
    // Envoi au serveur
    fetch('http://localhost:8888/smartbuy/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Succès
            alert('Compte créé avec succès!');
            showForm('login');
        } else {
            // Erreur
            errorElement.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        errorElement.textContent = 'Erreur de connexion au serveur.';
    });
}

// Attacher la fonction au formulaire quand le document est chargé
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Empêcher la soumission normale du formulaire
            registerUser();
        });
    }
});

// Connecter un utilisateur - version placeholder pour SQL
// Connecter un utilisateur
function loginUser() {
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;
    const rememberMe = document.getElementById('rememberMe').checked;
    const errorElement = document.getElementById('loginError');
    
    // Réinitialiser le message d'erreur
    errorElement.textContent = '';
    
    // Valider le formulaire
    if (!email || !password) {
        errorElement.textContent = 'Veuillez remplir tous les champs.';
        return;
    }
    
    // Préparer les données pour l'envoi
    const loginData = {
        email: email,
        password: password,
        remember_me: rememberMe
    };
    
    // Envoi des données au serveur
    fetch('http://localhost:8888/smartbuy/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loginData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Stocker les informations de l'utilisateur dans currentUser
            currentUser = {
                id: data.user.id,
                firstName: data.user.first_name,
                lastName: data.user.last_name,
                email: data.user.email
            };
            
            // Si "Se souvenir de moi" est coché, stocker les informations dans localStorage
            if (rememberMe) {
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
            }
            
            // Mettre à jour l'interface
            updateUserInterface();
            
            // Afficher le profil
            showForm('profile');
        } else {
            // Afficher le message d'erreur
            errorElement.textContent = data.message;
        }
    })
    .catch(error => {
        errorElement.textContent = 'Une erreur est survenue. Veuillez réessayer plus tard.';
        console.error('Erreur:', error);
    });
}

// Déconnecter l'utilisateur - version placeholder pour SQL
function logoutUser() {
    // Dans votre implémentation SQL, vous devrez gérer la déconnexion côté serveur
    console.log('Déconnexion - à implémenter avec votre back-end');
    
    // Réinitialiser l'utilisateur courant
    currentUser = null;
    
    // Mettre à jour l'interface
    updateUserInterface();
    
    // Fermer la modal
    toggleUserModal();
}

// Réinitialiser le mot de passe - version placeholder pour SQL
function resetPassword() {
    const email = document.getElementById('resetEmail').value.trim();
    const errorElement = document.getElementById('resetError');
    
    // Réinitialiser le message d'erreur
    errorElement.textContent = '';
    
    // Valider le formulaire
    if (!email) {
        errorElement.textContent = 'Veuillez entrer votre adresse email.';
        return;
    }
    
    // Placeholder - à remplacer par votre implémentation SQL
    console.log('Réinitialisation de mot de passe pour:', email);
    
    // Simuler un succès pour le test
    alert(`Cette fonction sera connectée à votre serveur. Un email de réinitialisation serait envoyé à ${email} dans une implémentation réelle.`);
    
    // Revenir au formulaire de connexion
    showForm('login');
}

// Mobile Menu Toggle
const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileNav = document.getElementById('mobileNav');
const menuIcon = document.getElementById('menuIcon');

mobileMenuButton.addEventListener('click', () => {
    mobileNav.classList.toggle('active');
    
    // Change icon based on menu state
    if (mobileNav.classList.contains('active')) {
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
    } else {
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
    }
});

// Carousel functionality
const carouselSlides = document.querySelectorAll('.carousel-slide');
const carouselDots = document.querySelectorAll('.carousel-dot');
const prevButton = document.getElementById('prevSlide');
const nextButton = document.getElementById('nextSlide');
let currentSlide = 0;

// Initialize the carousel
function initializeCarousel() {
    carouselSlides[0].classList.add('active');
}

// Show a specific slide
function showSlide(index) {
    // Hide all slides
    carouselSlides.forEach(slide => {
        slide.classList.remove('active');
    });
    
    // Show the selected slide
    carouselSlides[index].classList.add('active');
    
    // Update dots
    carouselDots.forEach(dot => {
        dot.classList.remove('active');
    });
    carouselDots[index].classList.add('active');
    
    // Update current slide index
    currentSlide = index;
}

// Next slide
function nextSlide() {
    let newIndex = currentSlide + 1;
    if (newIndex >= carouselSlides.length) {
        newIndex = 0;
    }
    showSlide(newIndex);
}

// Previous slide
function prevSlide() {
    let newIndex = currentSlide - 1;
    if (newIndex < 0) {
        newIndex = carouselSlides.length - 1;
    }
    showSlide(newIndex);
}

// Event listeners for carousel buttons
nextButton.addEventListener('click', nextSlide);
prevButton.addEventListener('click', prevSlide);

// Event listeners for carousel dots
carouselDots.forEach(dot => {
    dot.addEventListener('click', () => {
        const slideIndex = parseInt(dot.getAttribute('data-index'));
        showSlide(slideIndex);
    });
});

// Initialiser les événements pour les boutons du compte
function initializeUserButtons() {
    // Pour le bouton du compte desktop
    const desktopUserButton = document.querySelector('.tool-link .fa-user').parentNode;
    if (desktopUserButton) {
        desktopUserButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleUserModal();
        });
    }
    
    // Pour le bouton du compte mobile
    const mobileUserButton = document.querySelector('.mobile-tool-link:first-child');
    if (mobileUserButton) {
        mobileUserButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleUserModal();
        });
    }
}

// Set current year in footer
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Base de données des produits (smartphones)
const products = [
    {
        id: 1,
        name: "Samsung Galaxy S25",
        price: 999.99,
        rating: 4.5,
        image: "https://www.samsungshop.tn/28306-large_default/galaxy-s25-ultra-prix-tunisie.jpg",
        brand: "Samsung",
        category: "Smartphone"
    },
    {
        id: 2,
        name: "Apple iPhone 16 pro max",
        price: 1199.99,
        rating: 4.2,
        image: "https://m.media-amazon.com/images/I/6104qhRgADL.jpg",
        brand: "Apple",
        category: "Smartphone"
    },
    {
        id: 3,
        name: "Google Pixel 9",
        price: 899.99,
        rating: 4.7,
        image: "https://cartronics.be/62207-large_default/google-pixel-9-pro-xl.jpg",
        brand: "Google",
        category: "Smartphone"
    },
    {
        id: 4,
        name: "Xiaomi 15 Pro",
        price: 799.99,
        rating: 4.3,
        image: "https://msfsale.cl/wp-content/uploads/2024/12/xiaomi-15-pro-web.jpg",
        brand: "Xiaomi",
        category: "Smartphone"
    },
        
];

// Fonction de recherche
function searchProducts(query) {
    if (!query || query.trim() === "") {
        return [];
    }
    
    query = query.toLowerCase().trim();
    
    return products.filter(product => {
        return (
            product.name.toLowerCase().includes(query) ||
            product.brand.toLowerCase().includes(query) ||
            product.category.toLowerCase().includes(query)
        );
    });
}

// Créer un élément de résultat de recherche
function createSearchResultElement(product) {
    const element = document.createElement('div');
    element.className = 'search-result-item';
    element.innerHTML = `
        <img src="${product.image}" alt="${product.name}" class="search-result-img">
        <div class="search-result-info">
            <h4 class="search-result-name">${product.name}</h4>
            <p class="search-result-price">${product.price.toFixed(2)} €</p>
        </div>
    `;
    
    // Ajouter un événement de clic pour ajouter au panier
    element.addEventListener('click', () => {
        addToCart(product);
        hideSearchResults(); // Cacher les résultats après avoir cliqué
    });
    
    return element;
}

// Afficher les résultats de recherche
function displaySearchResults(results, container) {
    container.innerHTML = ''; // Vider le conteneur
    
    if (results.length === 0) {
        const noResults = document.createElement('div');
        noResults.className = 'no-search-results';
        noResults.textContent = 'Aucun produit trouvé';
        container.appendChild(noResults);
        return;
    }
    
    results.forEach(product => {
        const resultElement = createSearchResultElement(product);
        container.appendChild(resultElement);
    });
}

// Cacher les résultats de recherche
function hideSearchResults() {
    const searchResultsContainers = document.querySelectorAll('.search-results-container');
    searchResultsContainers.forEach(container => {
        container.innerHTML = '';
    });
}

// Initialiser la fonctionnalité de recherche
function initializeSearch() {
    // Pour la recherche desktop
    const desktopSearchInput = document.querySelector('.search-input');
    const desktopSearchContainer = document.createElement('div');
    desktopSearchContainer.className = 'search-results-container';
    desktopSearchInput.parentNode.appendChild(desktopSearchContainer);
    
    desktopSearchInput.addEventListener('input', function() {
        const query = this.value;
        const results = searchProducts(query);
        
        if (query.trim() === '') {
            hideSearchResults();
        } else {
            displaySearchResults(results, desktopSearchContainer);
        }
    });
    
    desktopSearchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSearchResults();
        }
    });
    
    // Pour la recherche mobile
    const mobileSearchInput = document.querySelector('.mobile-search-input');
    const mobileSearchContainer = document.createElement('div');
    mobileSearchContainer.className = 'search-results-container mobile';
    mobileSearchInput.parentNode.appendChild(mobileSearchContainer);
    
    mobileSearchInput.addEventListener('input', function() {
        const query = this.value;
        const results = searchProducts(query);
        
        if (query.trim() === '') {
            hideSearchResults();
        } else {
            displaySearchResults(results, mobileSearchContainer);
        }
    });
    
    mobileSearchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSearchResults();
        }
    });
    
    // Fermer les résultats en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container') && 
            !e.target.closest('.mobile-search') && 
            !e.target.closest('.search-results-container')) {
            hideSearchResults();
        }
    });
}

// Fonctionnalités du panier
let cart = [];

// Charger le panier depuis le localStorage
function loadCart() {
    const savedCart = localStorage.getItem('phonetech_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartBadge();
    }
}

// Sauvegarder le panier dans le localStorage
function saveCart() {
    localStorage.setItem('phonetech_cart', JSON.stringify(cart));
    updateCartBadge();
}

// Mettre à jour le badge du panier
function updateCartBadge() {
    const desktopBadge = document.querySelector('.cart-badge');
    const mobileBadge = document.querySelector('.mobile-tool-link:nth-child(2)');
    
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    
    if (desktopBadge) {
        desktopBadge.textContent = totalItems;
    }
    
    if (mobileBadge) {
        mobileBadge.textContent = `Panier (${totalItems})`;
    }
}

// Ajouter un produit au panier
function addToCart(product) {
    // Vérifier si le produit est déjà dans le panier
    const existingItemIndex = cart.findIndex(item => item.id === product.id);
    
    if (existingItemIndex !== -1) {
        // Le produit existe déjà, augmenter la quantité
        cart[existingItemIndex].quantity += 1;
    } else {
        // Ajouter le nouveau produit au panier
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }
    
    saveCart();
    
    // Afficher une notification
    showCartNotification(product.name);
}

// Supprimer un produit du panier
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    
    if (cartModal.classList.contains('active')) {
        displayCartItems();
    }
}

// Modifier la quantité d'un produit
function updateCartItemQuantity(productId, newQuantity) {
    const itemIndex = cart.findIndex(item => item.id === productId);
    
    if (itemIndex !== -1) {
        if (newQuantity <= 0) {
            removeFromCart(productId);
        } else {
            cart[itemIndex].quantity = newQuantity;
            saveCart();
            
            if (cartModal.classList.contains('active')) {
                displayCartItems();
            }
        }
    }
}

// Afficher une notification d'ajout au panier
function showCartNotification(productName) {
    // Créer l'élément de notification s'il n'existe pas
    let notification = document.getElementById('cartNotification');
    
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'cartNotification';
        notification.className = 'cart-notification';
        document.body.appendChild(notification);
    }
    
    // Mettre à jour le contenu
    notification.textContent = `${productName} ajouté au panier`;
    
    // Afficher la notification
    notification.classList.add('active');
    
    // Cacher la notification après 3 secondes
    setTimeout(() => {
        notification.classList.remove('active');
    }, 3000);
}

// Créer la modal du panier
function createCartModal() {
    const modal = document.createElement('div');
    modal.id = 'cartModal';
    modal.className = 'cart-modal';
    
    modal.innerHTML = `
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h3>Votre panier</h3>
                <button id="closeCartButton" class="close-cart-button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="cartItems" class="cart-items">
                <!-- Les articles du panier seront ajoutés ici dynamiquement -->
            </div>
            <div class="cart-modal-footer">
                <div class="cart-total">
                    <span>Total:</span>
                    <span id="cartTotal">0.00 €</span>
                </div>
                <button id="checkoutButton" class="checkout-button">
                    Passer la commande
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Ajouter les événements
    const closeButton = document.getElementById('closeCartButton');
    closeButton.addEventListener('click', toggleCartModal);
    
    // Fermer la modal en cliquant en dehors du contenu
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            toggleCartModal();
        }
    });
    
    // Événement pour le bouton de commande
    // Événement pour le bouton de commande
const checkoutButton = document.getElementById('checkoutButton');
checkoutButton.addEventListener('click', function() {
    // Vérification temporairement désactivée pour tests
    // if (!currentUser) {
    //     alert('Veuillez vous connecter pour passer commande');
    //     toggleCartModal();
    //     toggleUserModal();
    //     return;
    // }
    
    if (cart.length === 0) {
        alert('Votre panier est vide');
        return;
    }
    
    // Rediriger vers la page de commande (modifié pour HTML)
    window.location.href = '/Smartbuy/checkout.php';
});
    
    return modal;
}

// Afficher les articles du panier
function displayCartItems() {
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotalElement = document.getElementById('cartTotal');
    
    if (!cartItemsContainer) return;
    
    cartItemsContainer.innerHTML = '';
    
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<div class="empty-cart">Votre panier est vide</div>';
        cartTotalElement.textContent = '0.00 €';
        return;
    }
    
    let total = 0;
    
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cart-item';
        cartItemElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
            <div class="cart-item-details">
                <h4 class="cart-item-name">${item.name}</h4>
                <div class="cart-item-price">${item.price.toFixed(2)} €</div>
                <div class="cart-item-quantity">
                    <button class="quantity-btn minus" data-id="${item.id}">-</button>
                    <span class="quantity-value">${item.quantity}</span>
                    <button class="quantity-btn plus" data-id="${item.id}">+</button>
                </div>
            </div>
            <div class="cart-item-subtotal">
                <span>${itemTotal.toFixed(2)} €</span>
            </div>
            <button class="remove-item-btn" data-id="${item.id}">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        cartItemsContainer.appendChild(cartItemElement);
    });
    
    // Mettre à jour le total
    cartTotalElement.textContent = `${total.toFixed(2)} €`;
    
    // Ajouter les événements pour les boutons de quantité et de suppression
    document.querySelectorAll('.quantity-btn.minus').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            const currentItem = cart.find(item => item.id === productId);
            if (currentItem) {
                updateCartItemQuantity(productId, currentItem.quantity - 1);
            }
        });
    });
    
    document.querySelectorAll('.quantity-btn.plus').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            const currentItem = cart.find(item => item.id === productId);
            if (currentItem) {
                updateCartItemQuantity(productId, currentItem.quantity + 1);
            }
        });
    });
    
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            removeFromCart(productId);
        });
    });
}

// Basculer l'affichage de la modal du panier
let cartModal;

function toggleCartModal() {
    if (!cartModal) {
        cartModal = createCartModal();
    }
    
    cartModal.classList.toggle('active');
    
    if (cartModal.classList.contains('active')) {
        document.body.style.overflow = 'hidden'; // Empêcher le défilement du corps
        displayCartItems();
    } else {
        document.body.style.overflow = ''; // Réactiver le défilement
    }
}

// Ajouter des événements pour les boutons du panier
function initializeCartButtons() {
    // Pour le bouton du panier desktop
    const desktopCartButton = document.querySelector('.cart-icon');
    if (desktopCartButton) {
        desktopCartButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleCartModal();
        });
    }
    
    // Pour le bouton du panier mobile
    const mobileCartButton = document.querySelector('.mobile-tool-link:nth-child(2)');
    if (mobileCartButton) {
        mobileCartButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleCartModal();
        });
    }
    
    // Ajouter des événements pour les boutons "Ajouter au panier" dans les produits de la page
    // Cela pourrait être implémenté dans une mise à jour future
}

// Initialiser les événements pour ajouter des produits au panier depuis la page principale
function initializeAddToCartButtons() {
    // Cette fonction serait utilisée si vous ajoutiez des boutons "Ajouter au panier" 
    // directement sur les cartes de produits sur la page principale
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', () => {
    initializeCarousel();
    initializeSearch();
    loadCart();
    initializeCartButtons();
    initializeUserButtons();
});