// Asset New Entry Modern JavaScript
// Based on vat.php and other modernized files functionality approach

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeResponsiveDesign();
    initializeFormEnhancements();
});

// Sidebar functionality
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Menu toggle functionality
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    
    if (menuToggle) {
        // Show/hide menu toggle based on screen size
        function toggleMenuVisibility() {
            if (window.innerWidth <= 1024) {
                menuToggle.style.display = 'block';
            } else {
                menuToggle.style.display = 'none';
            }
        }
        
        toggleMenuVisibility();
        window.addEventListener('resize', toggleMenuVisibility);
    }
}

// Form validation
function initializeFormValidation() {
    const assetForm = document.querySelector('.asset-form');
    
    if (assetForm) {
        assetForm.addEventListener('submit', function(event) {
            const itemName = document.getElementById('itemname');
            const costPrice = document.getElementById('costprice');
            const entryDate = document.getElementById('entrydate');
            const category = document.getElementById('category');
            const startYear = document.getElementById('startyear');
            
            let isValid = true;
            let errorMessage = '';
            
            // Validate item name
            if (!itemName.value.trim()) {
                isValid = false;
                errorMessage = 'Please enter an item name.';
                itemName.focus();
            }
            
            // Validate cost price
            if (!costPrice.value.trim()) {
                isValid = false;
                errorMessage = 'Please enter a cost price.';
                costPrice.focus();
            } else if (isNaN(parseFloat(costPrice.value.replace(/[^0-9\.]+/g,"")))) {
                isValid = false;
                errorMessage = 'Please enter a valid cost price.';
                costPrice.focus();
            }
            
            // Validate entry date
            if (!entryDate.value) {
                isValid = false;
                errorMessage = 'Please select an entry date.';
                entryDate.focus();
            }
            
            // Validate category
            if (!category.value) {
                isValid = false;
                errorMessage = 'Please select a category.';
                category.focus();
            }
            
            // Validate start year
            if (!startYear.value) {
                isValid = false;
                errorMessage = 'Please select a start year.';
                startYear.focus();
            }
            
            if (!isValid) {
                event.preventDefault();
                showAlert(errorMessage, 'error');
            }
        });
    }
}

// Form enhancements
function initializeFormEnhancements() {
    // Auto-uppercase for item name
    const itemNameInput = document.getElementById('itemname');
    if (itemNameInput) {
        itemNameInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }
    
    // Category change handler
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const categoryId = selectedOption.dataset.id;
            const categoryIdInput = document.getElementById('category_id');
            if (categoryIdInput) {
                categoryIdInput.value = categoryId;
            }
        });
    }
    
    // Cost price and salvage validation
    const costPriceInput = document.getElementById('costprice');
    const salvageInput = document.getElementById('salvage');
    
    if (costPriceInput) {
        costPriceInput.addEventListener('blur', function() {
            validateCostPrice();
        });
    }
    
    if (salvageInput) {
        salvageInput.addEventListener('blur', function() {
            validateSalvage();
        });
    }
    
    // Set default entry date to today
    const entryDateInput = document.getElementById('entrydate');
    if (entryDateInput) {
        const today = new Date().toISOString().split('T')[0];
        entryDateInput.value = today;
    }
}

// Validate cost price
function validateCostPrice() {
    const costPriceInput = document.getElementById('costprice');
    const salvageInput = document.getElementById('salvage');
    
    if (!costPriceInput || !salvageInput) return;
    
    const costPrice = parseFloat(costPriceInput.value.replace(/[^0-9\.]+/g,""));
    const salvage = parseFloat(salvageInput.value.replace(/[^0-9\.]+/g,""));
    
    if (isNaN(costPrice)) {
        showAlert('Please enter a valid cost price.', 'error');
        costPriceInput.focus();
        return false;
    }
    
    if (!isNaN(salvage) && costPrice < salvage) {
        showAlert('Purchase Price cannot be less than Salvage Value.', 'error');
        costPriceInput.value = '';
        costPriceInput.focus();
        return false;
    }
    
    // Format cost price
    costPriceInput.value = formatMoney(costPrice);
    return true;
}

// Validate salvage value
function validateSalvage() {
    const costPriceInput = document.getElementById('costprice');
    const salvageInput = document.getElementById('salvage');
    
    if (!costPriceInput || !salvageInput) return;
    
    const costPrice = parseFloat(costPriceInput.value.replace(/[^0-9\.]+/g,""));
    const salvage = parseFloat(salvageInput.value.replace(/[^0-9\.]+/g,""));
    
    if (isNaN(salvage)) {
        showAlert('Please enter a valid salvage value.', 'error');
        salvageInput.focus();
        return false;
    }
    
    if (!isNaN(costPrice) && salvage > costPrice) {
        showAlert('Salvage Value cannot be more than Purchase Price.', 'error');
        salvageInput.value = '';
        salvageInput.focus();
        return false;
    }
    
    // Format salvage value
    salvageInput.value = formatMoney(salvage);
    return true;
}

// Format money function
function formatMoney(number, places = 2, thousand = ",", decimal = ".") {
    number = number || 0;
    places = !isNaN(places = Math.abs(places)) ? places : 2;
    
    var negative = number < 0 ? "-" : "",
        i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    
    return negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
}

// Show alert messages
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    alertDiv.innerHTML = `
        <i class="fas fa-${iconClass} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Refresh page functionality
function refreshPage() {
    location.reload();
}

// Clear form functionality
function clearForm() {
    const form = document.getElementById('form1');
    if (form) {
        form.reset();
        
        // Reset category ID
        const categoryIdInput = document.getElementById('category_id');
        if (categoryIdInput) {
            categoryIdInput.value = '';
        }
        
        // Set default entry date
        const entryDateInput = document.getElementById('entrydate');
        if (entryDateInput) {
            const today = new Date().toISOString().split('T')[0];
            entryDateInput.value = today;
        }
        
        showAlert('Form cleared successfully.', 'success');
    }
}

// Responsive design initialization
function initializeResponsiveDesign() {
    // Handle window resize events
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('leftSidebar');
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('open');
        }
    });
    
    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        addTouchSupport();
    }
}

// Add touch support for mobile
function addTouchSupport() {
    const sidebar = document.getElementById('leftSidebar');
    let startX = 0;
    let currentX = 0;
    
    sidebar.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    });
    
    sidebar.addEventListener('touchmove', function(e) {
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;
        
        if (Math.abs(diffX) > 50) {
            if (diffX > 0) {
                // Swipe left - close sidebar
                sidebar.classList.remove('open');
            } else {
                // Swipe right - open sidebar
                sidebar.classList.add('open');
            }
        }
    });
}

// Form field enhancement functions
function enhanceFormFields() {
    // Add real-time validation feedback
    const requiredFields = document.querySelectorAll('input[required], select[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            clearFieldValidation(this);
        });
    });
    
    // Add number-only validation for price fields
    const priceFields = document.querySelectorAll('#costprice, #salvage, #accdepreciationvalue');
    priceFields.forEach(field => {
        field.addEventListener('keypress', function(event) {
            if (!isNumber(event)) {
                event.preventDefault();
                return false;
            }
        });
    });
}

// Validate individual field
function validateField(field) {
    const value = field.value.trim();
    const isRequired = field.hasAttribute('required');
    
    if (isRequired && !value) {
        showFieldError(field, 'This field is required.');
        return false;
    }
    
    // Specific field validations
    if (field.id === 'costprice' || field.id === 'salvage') {
        const numValue = parseFloat(value.replace(/[^0-9\.]+/g,""));
        if (isNaN(numValue) || numValue < 0) {
            showFieldError(field, 'Please enter a valid positive number.');
            return false;
        }
    }
    
    if (field.id === 'entrydate') {
        const selectedDate = new Date(value);
        const today = new Date();
        if (selectedDate > today) {
            showFieldError(field, 'Entry date cannot be in the future.');
            return false;
        }
    }
    
    showFieldSuccess(field);
    return true;
}

// Show field error
function showFieldError(field, message) {
    field.classList.remove('success');
    field.classList.add('error');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Show field success
function showFieldSuccess(field) {
    field.classList.remove('error');
    field.classList.add('success');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Clear field validation
function clearFieldValidation(field) {
    field.classList.remove('error', 'success');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Check if input is a valid number
function isNumber(event) {
    const charCode = (event.which) ? event.which : event.keyCode;
    if ((charCode != 46 || event.target.value.indexOf('.') != -1) && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Auto-save form data to localStorage
function initializeAutoSave() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    // Load saved data on page load
    loadSavedFormData();
    
    // Save data on form changes
    form.addEventListener('input', function() {
        saveFormData();
    });
    
    // Save data on form submission
    form.addEventListener('submit', function() {
        clearSavedFormData();
    });
}

// Save form data to localStorage
function saveFormData() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    localStorage.setItem('asset_newentry_form_data', JSON.stringify(data));
}

// Load saved form data from localStorage
function loadSavedFormData() {
    const savedData = localStorage.getItem('asset_newentry_form_data');
    if (!savedData) return;
    
    try {
        const data = JSON.parse(savedData);
        const form = document.getElementById('form1');
        
        for (let key in data) {
            const field = form.querySelector(`[name="${key}"]`);
            if (field && field.type !== 'submit' && field.type !== 'reset') {
                field.value = data[key];
            }
        }
        
        showAlert('Previous form data loaded.', 'info');
    } catch (error) {
        console.error('Error loading saved form data:', error);
    }
}

// Clear saved form data
function clearSavedFormData() {
    localStorage.removeItem('asset_newentry_form_data');
}

// Initialize additional functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure all elements are loaded
    setTimeout(() => {
        enhanceFormFields();
        initializeAutoSave();
    }, 100);
});

// Export functions to global scope for inline HTML usage
window.refreshPage = refreshPage;
window.clearForm = clearForm;
window.formatMoney = formatMoney;
window.validateCostPrice = validateCostPrice;
window.validateSalvage = validateSalvage;




