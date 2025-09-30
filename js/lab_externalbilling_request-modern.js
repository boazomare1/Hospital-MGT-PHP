// Lab External Billing Request Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeDatePickers();
    initializeFormValidation();
    initializeSearch();
    initializeLabItems();
    initializeDiseaseItems();
    initializeCalculations();
});

// Sidebar functionality
function initializeSidebar() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const floatingToggle = document.querySelector('.floating-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (floatingToggle) {
        floatingToggle.addEventListener('click', toggleSidebar);
    }
    
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
    }
}

// Date picker initialization
function initializeDatePickers() {
    // Initialize date pickers if datetimepicker is available
    if (typeof $.fn.datetimepicker !== 'undefined') {
        $('.date-picker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1
        });
    }
}

// Form validation
function initializeFormValidation() {
    const form = document.querySelector('form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'This field is required');
                isValid = false;
            } else {
                clearFieldError(field);
            }
        });
        
        // Validate patient selection
        const patientField = document.querySelector('input[name="patientname"]');
        if (patientField && !patientField.value.trim()) {
            showFieldError(patientField, 'Please select a patient');
            isValid = false;
        }
        
        return isValid;
    }
    
    function showFieldError(field, message) {
        clearFieldError(field);
        field.style.borderColor = '#e74c3c';
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#e74c3c';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
    
    function clearFieldError(field) {
        field.style.borderColor = '';
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchInput && searchBtn) {
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            // Add loading state
            searchBtn.classList.add('loading');
            searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            
            // Simulate search (replace with actual search logic)
            setTimeout(() => {
                searchBtn.classList.remove('loading');
                searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
                // Perform actual search here
            }, 1000);
        }
    }
}

// Lab items management
function initializeLabItems() {
    const addLabBtn = document.querySelector('.add-lab-item');
    const labContainer = document.querySelector('.lab-items-container');
    
    if (addLabBtn && labContainer) {
        addLabBtn.addEventListener('click', addLabItem);
    }
    
    function addLabItem() {
        const labSection = document.createElement('div');
        labSection.className = 'lab-section';
        labSection.innerHTML = `
            <div class="lab-section-title">
                <i class="fas fa-flask"></i>
                Lab Item
                <button type="button" class="btn btn-danger btn-sm remove-lab-item" style="margin-left: auto;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="lab-item-grid">
                <div class="form-group">
                    <label class="form-label">Lab Item</label>
                    <input type="text" name="labitem[]" class="lab-item-input" placeholder="Enter lab item name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Rate</label>
                    <input type="number" name="labrate[]" class="lab-item-input lab-rate-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <button type="button" class="btn btn-primary add-lab-item">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        `;
        
        labContainer.appendChild(labSection);
        
        // Add event listeners to new elements
        const removeBtn = labSection.querySelector('.remove-lab-item');
        const addBtn = labSection.querySelector('.add-lab-item');
        
        if (removeBtn) {
            removeBtn.addEventListener('click', () => labSection.remove());
        }
        
        if (addBtn) {
            addBtn.addEventListener('click', addLabItem);
        }
        
        // Recalculate totals
        calculateTotals();
    }
    
    // Remove lab item functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-lab-item')) {
            e.target.closest('.lab-section').remove();
            calculateTotals();
        }
    });
}

// Disease items management
function initializeDiseaseItems() {
    const addDiseaseBtn = document.querySelector('.add-disease-item');
    const diseaseContainer = document.querySelector('.disease-items-container');
    
    if (addDiseaseBtn && diseaseContainer) {
        addDiseaseBtn.addEventListener('click', addDiseaseItem);
    }
    
    function addDiseaseItem() {
        const diseaseSection = document.createElement('div');
        diseaseSection.className = 'disease-section';
        diseaseSection.innerHTML = `
            <div class="disease-section-title">
                Disease Item
                <button type="button" class="btn btn-danger btn-sm remove-disease-item" style="margin-left: auto;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="disease-grid">
                <div class="disease-type">Disease Type:</div>
                <div class="form-group">
                    <input type="text" name="diseasetype[]" class="form-input" placeholder="Enter disease type" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Rate</label>
                    <input type="number" name="diseaserate[]" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <button type="button" class="btn btn-primary add-disease-item">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        `;
        
        diseaseContainer.appendChild(diseaseSection);
        
        // Add event listeners to new elements
        const removeBtn = diseaseSection.querySelector('.remove-disease-item');
        const addBtn = diseaseSection.querySelector('.add-disease-item');
        
        if (removeBtn) {
            removeBtn.addEventListener('click', () => diseaseSection.remove());
        }
        
        if (addBtn) {
            addBtn.addEventListener('click', addDiseaseItem);
        }
        
        // Recalculate totals
        calculateTotals();
    }
    
    // Remove disease item functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-disease-item')) {
            e.target.closest('.disease-section').remove();
            calculateTotals();
        }
    });
}

// Calculations
function initializeCalculations() {
    // Add event listeners to all rate inputs
    document.addEventListener('input', function(e) {
        if (e.target.name === 'labrate[]' || e.target.name === 'diseaserate[]') {
            calculateTotals();
        }
    });
    
    // Initial calculation
    calculateTotals();
}

function calculateTotals() {
    let labTotal = 0;
    let diseaseTotal = 0;
    
    // Calculate lab items total
    const labRates = document.querySelectorAll('input[name="labrate[]"]');
    labRates.forEach(input => {
        const rate = parseFloat(input.value) || 0;
        labTotal += rate;
    });
    
    // Calculate disease items total
    const diseaseRates = document.querySelectorAll('input[name="diseaserate[]"]');
    diseaseRates.forEach(input => {
        const rate = parseFloat(input.value) || 0;
        diseaseTotal += rate;
    });
    
    const grandTotal = labTotal + diseaseTotal;
    
    // Update total display
    const totalElement = document.querySelector('.total-section');
    if (totalElement) {
        totalElement.innerHTML = `
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Lab Items Total:</span>
                <span>₹${labTotal.toFixed(2)}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span>Disease Items Total:</span>
                <span>₹${diseaseTotal.toFixed(2)}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 700; border-top: 2px solid var(--medstar-primary); padding-top: 0.5rem;">
                <span>Grand Total:</span>
                <span>₹${grandTotal.toFixed(2)}</span>
            </div>
        `;
    }
}

// Patient search functionality
function initializePatientSearch() {
    const patientInput = document.querySelector('input[name="patientname"]');
    if (!patientInput) return;
    
    let searchTimeout;
    
    patientInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                searchPatients(query);
            }, 300);
        } else {
            hidePatientSuggestions();
        }
    });
    
    function searchPatients(query) {
        // Implement patient search AJAX call here
        // This would typically make a request to a PHP endpoint
        console.log('Searching for patients:', query);
    }
    
    function hidePatientSuggestions() {
        const suggestions = document.querySelector('.patient-suggestions');
        if (suggestions) {
            suggestions.remove();
        }
    }
}

// Export functionality
function initializeExport() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Implement export functionality
            console.log('Exporting data...');
        });
    }
}

// Utility functions
function showAlert(message, type = 'success') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(amount);
}

// Initialize all components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializePatientSearch();
    initializeExport();
});
