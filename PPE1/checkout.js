// Variables globales
let cart = [];
let subTotal = 0;
let shippingCost = 0;
let taxRate = 0.2; // 20% de TVA

// Fonction pour charger le panier depuis le localStorage
function loadCart() {
    const savedCart = localStorage.getItem('phonetech_cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartBadge();
        renderCheckoutItems();
        calculateTotals();
    } else {
        // Rediriger vers la page d'accueil si le panier est vide
        window.location.href = 'index.php';
    }
}

// Mettre à jour le badge du panier
function updateCartBadge() {
    const desktopBadge = document.getElementById('cartBadge');
    const mobileBadge = document.getElementById('mobileCartBadge');
    
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    
    if (desktopBadge) {
        desktopBadge.textContent = totalItems;
    }
    
    if (mobileBadge) {
        mobileBadge.textContent = totalItems;
    }
}

// Afficher les articles du panier dans la page de checkout
function renderCheckoutItems() {
    const checkoutItemsContainer = document.getElementById('checkoutItems');
    
    if (!checkoutItemsContainer || !cart.length) {
        return;
    }
    
    // Vider le conteneur
    checkoutItemsContainer.innerHTML = '';
    
    // Ajouter chaque article du panier
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

// Calculer les totaux (sous-total, livraison, TVA, total)
function calculateTotals() {
    // Calculer la livraison (gratuite si commande > 50€, sinon 4.99€)
    shippingCost = subTotal > 50 ? 0 : 4.99;
    
    // Calculer la TVA
    const taxAmount = subTotal * taxRate;
    
    // Calculer le total
    const total = subTotal + shippingCost;
    
    // Mettre à jour les éléments HTML
    document.getElementById('subtotal').textContent = `${subTotal.toFixed(2)} €`;
    document.getElementById('shipping').textContent = `${shippingCost.toFixed(2)} €`;
    document.getElementById('tax').textContent = `${taxAmount.toFixed(2)} €`;
    document.getElementById('total').textContent = `${total.toFixed(2)} €`;
}

// Format du numéro de carte avec espaces
function formatCardNumber(input) {
    // Supprimer tous les caractères non-numériques
    let value = input.value.replace(/\D/g, '');
    
    // Ajouter un espace tous les 4 chiffres
    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    
    // Mettre à jour la valeur du champ
    input.value = value;
}

// Format de la date d'expiration (MM/AA)
function formatExpiryDate(input) {
    // Supprimer tous les caractères non-numériques
    let value = input.value.replace(/\D/g, '');
    
    // Ajouter un slash après les deux premiers chiffres
    if (value.length > 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
    }
    
    // Mettre à jour la valeur du champ
    input.value = value;
}

// Validation du formulaire de paiement
function validateForm() {
    let isValid = true;
    
    // Valider le nom du titulaire
    const cardName = document.getElementById('cardName');
    if (!cardName.value.trim()) {
        setError(cardName, 'Veuillez entrer le nom du titulaire de la carte');
        isValid = false;
    } else {
        setSuccess(cardName);
    }
    
    // Valider le numéro de carte
    const cardNumber = document.getElementById('cardNumber');
    const cardNumberValue = cardNumber.value.replace(/\s/g, '');
    if (!cardNumberValue || cardNumberValue.length < 16) {
        setError(cardNumber, 'Veuillez entrer un numéro de carte valide');
        isValid = false;
    } else {
        setSuccess(cardNumber);
    }
    
    // Valider la date d'expiration
    const expiryDate = document.getElementById('expiryDate');
    const expiryValue = expiryDate.value;
    const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
    if (!expiryRegex.test(expiryValue)) {
        setError(expiryDate, 'Format invalide (MM/AA)');
        isValid = false;
    } else {
        // Vérifier si la carte n'est pas expirée
        const [month, year] = expiryValue.split('/');
        const expiryDate = new Date(2000 + parseInt(year), parseInt(month) - 1);
        const today = new Date();
        
        if (expiryDate < today) {
            setError(document.getElementById('expiryDate'), 'Carte expirée');
            isValid = false;
        } else {
            setSuccess(document.getElementById('expiryDate'));
        }
    }
    
    // Valider le CVV
    const cvv = document.getElementById('cvv');
    if (!cvv.value || cvv.value.length < 3) {
        setError(cvv, 'CVV invalide');
        isValid = false;
    } else {
        setSuccess(cvv);
    }
    
    // Valider le nom complet
    const fullName = document.getElementById('fullName');
    if (!fullName.value.trim()) {
        setError(fullName, 'Veuillez entrer votre nom complet');
        isValid = false;
    } else {
        setSuccess(fullName);
    }
    
    // Valider l'adresse
    const address = document.getElementById('address');
    if (!address.value.trim()) {
        setError(address, 'Veuillez entrer votre adresse');
        isValid = false;
    } else {
        setSuccess(address);
    }
    
    // Valider le code postal
    const zipCode = document.getElementById('zipCode');
    if (!zipCode.value || zipCode.value.length < 5) {
        setError(zipCode, 'Code postal invalide');
        isValid = false;
    } else {
        setSuccess(zipCode);
    }
    
    // Valider la ville
    const city = document.getElementById('city');
    if (!city.value.trim()) {
        setError(city, 'Veuillez entrer votre ville');
        isValid = false;
    } else {
        setSuccess(city);
    }
    
    // Valider le téléphone
    const phone = document.getElementById('phone');
    if (!phone.value.trim() || phone.value.trim().length < 10) {
        setError(phone, 'Veuillez entrer un numéro de téléphone valide');
        isValid = false;
    } else {
        setSuccess(phone);
    }
    
    // Valider l'email
    const email = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        setError(email, 'Veuillez entrer une adresse email valide');
        isValid = false;
    } else {
        setSuccess(email);
    }
    
    return isValid;
}

// Définir un état d'erreur pour un champ
function setError(input, message) {
    const formGroup = input.parentElement;
    const errorMessage = formGroup.querySelector('.form-error-message');
    
    formGroup.classList.remove('success');
    formGroup.classList.add('error');
    errorMessage.textContent = message;
}

// Définir un état de succès pour un champ
function setSuccess(input) {
    const formGroup = input.parentElement;
    
    formGroup.classList.remove('error');
    formGroup.classList.add('success');
}

// Simuler le traitement du paiement
function processPayment() {
    return new Promise((resolve) => {
        // Simuler un délai de traitement
        setTimeout(() => {
            // 90% de chance de succès, 10% d'échec pour simulation
            const success = Math.random() < 0.9;
            resolve(success);
        }, 2000);
    });
}

// Générer un numéro de commande aléatoire
function generateOrderNumber() {
    const prefix = 'SMB';
    const randomPart = Math.floor(10000 + Math.random() * 90000);
    return `${prefix}-${randomPart}`;
}

// Afficher le message de succès
function showSuccessMessage() {
    const orderNumber = generateOrderNumber();
    document.getElementById('orderNumber').textContent = orderNumber;
    document.getElementById('successMessage').classList.add('active');
    document.getElementById('checkoutContent').style.display = 'none';
    
    // Mettre à jour les étapes du checkout
    const steps = document.querySelectorAll('.checkout-step');
    steps[2].classList.add('active');
    
    // Vider le panier
    localStorage.removeItem('phonetech_cart');
    cart = [];
}

// Initialisation du menu mobile
function initializeMobileMenu() {
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileNav = document.getElementById('mobileNav');
    const menuIcon = document.getElementById('menuIcon');
    
    if (mobileMenuButton && mobileNav && menuIcon) {
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
    }
}

// Rediriger vers la page d'accueil en cas de clic sur les icônes du panier ou du compte
function setupNavLinks() {
    // Rediriger vers la page d'accueil pour le panier
    const cartLinks = [
        document.getElementById('cartLink'),
        document.getElementById('mobileCartLink')
    ];
    
    cartLinks.forEach(link => {
        if (link) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = 'index.php';
            });
        }
    });
    
    // Rediriger vers la page d'accueil pour le compte
    const userLinks = [
        document.getElementById('userAccountLink'),
        document.getElementById('mobileUserAccountLink')
    ];
    
    userLinks.forEach(link => {
        if (link) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = 'index.php';
            });
        }
    });
}

// Initialiser les événements
document.addEventListener('DOMContentLoaded', () => {
    // Charger le panier
    loadCart();
    
    // Initialiser le menu mobile
    initializeMobileMenu();
    
    // Configurer les liens de navigation
    setupNavLinks();
    
    // Mettre à jour l'année dans le footer
    const currentYearElement = document.getElementById('currentYear');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }
    
    // Formatage du numéro de carte
    const cardNumberInput = document.getElementById('cardNumber');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            formatCardNumber(this);
        });
    }
    
    // Formatage de la date d'expiration
    const expiryDateInput = document.getElementById('expiryDate');
    if (expiryDateInput) {
        expiryDateInput.addEventListener('input', function() {
            formatExpiryDate(this);
        });
    }
    
    // Gérer la soumission du formulaire
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Valider le formulaire
            if (!validateForm()) {
                // Faire défiler jusqu'au premier champ en erreur
                const firstError = document.querySelector('.form-group.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Ajouter la classe loading au bouton
            const orderButton = document.getElementById('orderButton');
            orderButton.classList.add('loading');
            orderButton.disabled = true;
            
            // Traiter le paiement
            const paymentSuccess = await processPayment();
            
            // Réactiver le bouton
            orderButton.classList.remove('loading');
            orderButton.disabled = false;
            
            if (paymentSuccess) {
                // Afficher le message de succès
                showSuccessMessage();
            } else {
                // Afficher un message d'erreur
                alert('Une erreur est survenue lors du traitement de votre paiement. Veuillez réessayer.');
            }
        });
    }
});