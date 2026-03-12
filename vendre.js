// ========================================================================
// VENDRE.JS - Gestion du formulaire de vente de produit
// ========================================================================

document.addEventListener('DOMContentLoaded', () => {
    // ========================================================================
    // ANNÉE DANS LE FOOTER
    // ========================================================================
    const currentYearElement = document.getElementById('currentYear');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }

    // ========================================================================
    // MOBILE MENU
    // ========================================================================
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

    // ========================================================================
    // DRAG AND DROP IMAGE UPLOAD
    // ========================================================================
    const uploadArea = document.getElementById('uploadArea');
    const productImageInput = document.getElementById('productImage');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImage');
    let selectedFile = null;

    // Click sur la zone pour ouvrir le sélecteur de fichier
    uploadArea.addEventListener('click', () => {
        productImageInput.click();
    });

    // Sélection de fichier via l'input
    productImageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            handleImageFile(file);
        }
    });

    // Drag over
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    // Drag leave
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    // Drop
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');

        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleImageFile(file);
        } else {
            alert('Veuillez sélectionner une image valide (JPG, PNG ou WEBP)');
        }
    });

    // Fonction pour gérer le fichier image
    function handleImageFile(file) {
        // Vérifier la taille (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('La taille de l\'image ne doit pas dépasser 5MB');
            return;
        }

        selectedFile = file;

        // Créer un aperçu
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            uploadArea.style.display = 'none';
            imagePreview.style.display = 'block';

            // Retirer l'erreur si elle existait
            const imageGroup = document.querySelector('#imageUploadContainer').parentElement;
            imageGroup.classList.remove('error');
            imageGroup.classList.add('success');
        };
        reader.readAsDataURL(file);
    }

    // Supprimer l'image
    removeImageBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        selectedFile = null;
        productImageInput.value = '';
        previewImg.src = '';
        uploadArea.style.display = 'block';
        imagePreview.style.display = 'none';

        const imageGroup = document.querySelector('#imageUploadContainer').parentElement;
        imageGroup.classList.remove('success');
    });

    // ========================================================================
    // VALIDATION DU FORMULAIRE
    // ========================================================================
    const sellForm = document.getElementById('sellForm');

    sellForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!validateForm()) {
            const firstError = document.querySelector('.form-group.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Créer FormData pour envoyer les données avec l'image
        const formData = new FormData();
        formData.append('productName', document.getElementById('productName').value.trim());
        formData.append('productBrand', document.getElementById('productBrand').value);
        formData.append('productPrice', document.getElementById('productPrice').value);
        formData.append('productCondition', document.getElementById('productCondition').value);
        formData.append('productDescription', document.getElementById('productDescription').value.trim());

        if (selectedFile) {
            formData.append('productImage', selectedFile);
        }

        // Bouton de soumission
        const submitButton = document.getElementById('submitButton');
        submitButton.classList.add('loading');
        submitButton.disabled = true;

        try {
            const response = await fetch('process_sell.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            submitButton.classList.remove('loading');
            submitButton.disabled = false;

            if (data.success) {
                // Afficher le message de succès
                document.getElementById('successMessage').classList.add('active');
                sellForm.style.display = 'none';

                // Réinitialiser le formulaire
                sellForm.reset();
                selectedFile = null;
                uploadArea.style.display = 'block';
                imagePreview.style.display = 'none';
            } else {
                alert('Erreur: ' + data.message);
            }
        } catch (error) {
            submitButton.classList.remove('loading');
            submitButton.disabled = false;
            alert('Une erreur est survenue lors de l\'envoi du formulaire: ' + error.message);
        }
    });

    // ========================================================================
    // FONCTION DE VALIDATION
    // ========================================================================
    function validateForm() {
        let isValid = true;

        // Nom du produit
        const productName = document.getElementById('productName');
        if (!productName.value.trim()) {
            setError(productName, 'Veuillez entrer le nom du produit');
            isValid = false;
        } else {
            setSuccess(productName);
        }

        // Marque
        const productBrand = document.getElementById('productBrand');
        if (!productBrand.value) {
            setError(productBrand, 'Veuillez sélectionner une marque');
            isValid = false;
        } else {
            setSuccess(productBrand);
        }

        // Prix
        const productPrice = document.getElementById('productPrice');
        const price = parseFloat(productPrice.value);
        if (!productPrice.value || price <= 0) {
            setError(productPrice, 'Veuillez entrer un prix valide');
            isValid = false;
        } else {
            setSuccess(productPrice);
        }

        // État
        const productCondition = document.getElementById('productCondition');
        if (!productCondition.value) {
            setError(productCondition, 'Veuillez sélectionner l\'état du produit');
            isValid = false;
        } else {
            setSuccess(productCondition);
        }

        // Description
        const productDescription = document.getElementById('productDescription');
        if (!productDescription.value.trim() || productDescription.value.trim().length < 20) {
            setError(productDescription, 'La description doit contenir au moins 20 caractères');
            isValid = false;
        } else {
            setSuccess(productDescription);
        }

        // Image
        const imageUploadContainer = document.querySelector('#imageUploadContainer').parentElement;
        if (!selectedFile) {
            setError(imageUploadContainer.querySelector('input'), 'Veuillez ajouter une image du produit');
            isValid = false;
        } else {
            setSuccess(imageUploadContainer.querySelector('input'));
        }

        return isValid;
    }

    function setError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorMessage = formGroup.querySelector('.form-error-message');

        formGroup.classList.remove('success');
        formGroup.classList.add('error');

        if (errorMessage) {
            errorMessage.textContent = message;
        }
    }

    function setSuccess(input) {
        const formGroup = input.closest('.form-group');
        formGroup.classList.remove('error');
        formGroup.classList.add('success');
    }
});
