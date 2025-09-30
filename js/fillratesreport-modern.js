// Fill Rates Report Modern JavaScript - Matching vat.php standards

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForms();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize radio button functionality
    initializeRadioButtons();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (sidebar && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('collapsed');
        } else {
            sidebar.classList.add('collapsed');
        }
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
    }
}

// Form functionality
function initializeForms() {
    // Handle form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Add loading state to submit buttons
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
            }
        });
    });
    
    // Handle form validation
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
            }
        });
    }
}

// Autocomplete functionality
function initializeAutocomplete() {
    // Initialize autocomplete for provider search
    const searchInput = document.getElementById('searchsuppliername1');
    if (searchInput && typeof AutoSuggestControl1 !== 'undefined') {
        try {
            const oTextbox = new AutoSuggestControl1(searchInput, new StateSuggestions1());
        } catch (error) {
            console.log('Autocomplete initialization failed:', error);
        }
    }
}

// Date picker functionality
function initializeDatePickers() {
    // Initialize date pickers if the functions are available
    if (typeof NewCssCal !== 'undefined') {
        // Date pickers are already initialized via the existing scripts
        console.log('Date pickers initialized');
    }
}

// Radio button functionality
function initializeRadioButtons() {
    const allRadio = document.getElementById('bytype1');
    const providerRadio = document.getElementById('bytype2');
    const searchInput = document.getElementById('searchsuppliername1');
    
    if (allRadio && providerRadio && searchInput) {
        allRadio.addEventListener('change', function() {
            if (this.checked) {
                checkprovider('0');
            }
        });
        
        providerRadio.addEventListener('change', function() {
            if (this.checked) {
                checkprovider('1');
            }
        });
        
        // Set initial state based on hidden field value
        const searchPaymentCode = document.getElementById('searchpaymentcode');
        if (searchPaymentCode) {
            const value = searchPaymentCode.value;
            if (value === '0') {
                allRadio.checked = true;
                checkprovider('0');
            } else if (value === '1') {
                providerRadio.checked = true;
                checkprovider('1');
            }
        }
    }
}

// Provider check function (from original code)
function checkprovider(byid) {
    const id = byid;
    const searchInput = document.getElementById('searchsuppliername1');
    const searchSubtypeAnum = document.getElementById('searchsubtypeanum1');
    const searchPaymentCode = document.getElementById('searchpaymentcode');
    
    if (id == 0) {
        if (searchInput) {
            searchInput.readOnly = true;
            searchInput.value = '';
        }
        if (searchSubtypeAnum) {
            searchSubtypeAnum.value = '';
        }
        if (searchPaymentCode) {
            searchPaymentCode.value = id;
        }
    } else {
        if (searchInput) {
            searchInput.readOnly = false;
        }
        if (searchPaymentCode) {
            searchPaymentCode.value = id;
        }
    }
}

// Form validation
function validateSearchForm() {
    const fromDate = document.getElementById('ADate1');
    const toDate = document.getElementById('ADate2');
    const providerRadio = document.getElementById('bytype2');
    const searchInput = document.getElementById('searchsuppliername1');
    
    let isValid = true;
    let errorMessage = '';
    
    // Validate date range
    if (fromDate && toDate) {
        const fromDateValue = new Date(fromDate.value);
        const toDateValue = new Date(toDate.value);
        
        if (fromDateValue > toDateValue) {
            errorMessage += 'From date cannot be greater than To date. ';
            isValid = false;
        }
        
        // Check if dates are not too far in the past (optional validation)
        const oneYearAgo = new Date();
        oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
        
        if (fromDateValue < oneYearAgo) {
            if (!confirm('The selected date range is more than one year old. Do you want to continue?')) {
                isValid = false;
            }
        }
    }
    
    // Validate provider selection
    if (providerRadio && providerRadio.checked) {
        if (searchInput && searchInput.value.trim() === '') {
            errorMessage += 'Please select a provider when "Provider" option is selected. ';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert(errorMessage.trim(), 'error');
    }
    
    return isValid;
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // This would typically trigger an Excel export
    // For now, we'll just show a message
    showAlert('Excel export functionality would be implemented here.', 'info');
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle')} alert-icon"></i>
            <span>${message}</span>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 5000);
    }
}

// Format numbers with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Calculate percentage with proper formatting
function calculatePercentage(part, total) {
    if (total === 0) return '0.00';
    return (part / total * 100).toFixed(2);
}

// Animate numbers in summary cards
function animateNumbers() {
    const summaryCards = document.querySelectorAll('.summary-card .value');
    summaryCards.forEach(card => {
        const finalValue = card.textContent;
        const numericValue = parseFloat(finalValue.replace(/,/g, ''));
        
        if (!isNaN(numericValue)) {
            animateNumber(card, 0, numericValue, 1000);
        }
    });
}

function animateNumber(element, start, end, duration) {
    const startTime = performance.now();
    const isPercentage = element.textContent.includes('%');
    
    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        const current = start + (end - start) * progress;
        const formatted = isPercentage ? 
            current.toFixed(2) + '%' : 
            formatNumber(Math.floor(current));
        
        element.textContent = formatted;
        
        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        }
    }
    
    requestAnimationFrame(updateNumber);
}

// Handle keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + R to refresh
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    // Ctrl + E to export
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }
    
    // Escape to reset form
    if (e.key === 'Escape') {
        const resetBtn = document.getElementById('resetbutton');
        if (resetBtn) {
            resetBtn.click();
        }
    }
});

// Auto-save form data to localStorage
function autoSaveFormData() {
    const form = document.getElementById('searchForm');
    if (form) {
        const formData = new FormData(form);
        const formObject = {};
        
        for (let [key, value] of formData.entries()) {
            formObject[key] = value;
        }
        
        localStorage.setItem('fillratesreport_form', JSON.stringify(formObject));
    }
}

// Load saved form data
function loadSavedFormData() {
    const savedData = localStorage.getItem('fillratesreport_form');
    if (savedData) {
        try {
            const formObject = JSON.parse(savedData);
            const form = document.getElementById('searchForm');
            
            if (form) {
                Object.keys(formObject).forEach(key => {
                    const element = form.querySelector(`[name="${key}"]`);
                    if (element) {
                        if (element.type === 'radio') {
                            if (element.value === formObject[key]) {
                                element.checked = true;
                            }
                        } else {
                            element.value = formObject[key];
                        }
                    }
                });
                
                // Trigger change events for radio buttons
                const radioButtons = form.querySelectorAll('input[type="radio"]:checked');
                radioButtons.forEach(radio => {
                    if (radio.name === 'bytype') {
                        checkprovider(radio.value);
                    }
                });
            }
        } catch (error) {
            console.log('Error loading saved form data:', error);
        }
    }
}

// Initialize auto-save
function initializeAutoSave() {
    const form = document.getElementById('searchForm');
    if (form) {
        // Save form data on input change
        form.addEventListener('input', function() {
            clearTimeout(form.autoSaveTimeout);
            form.autoSaveTimeout = setTimeout(autoSaveFormData, 1000);
        });
        
        // Save form data on form submission
        form.addEventListener('submit', autoSaveFormData);
    }
}

// Handle window load
window.addEventListener('load', function() {
    // Initialize any components that need the page to be fully loaded
    console.log('Fill Rates Report page loaded successfully');
    
    // Load saved form data
    loadSavedFormData();
    
    // Initialize auto-save
    initializeAutoSave();
    
    // Animate numbers if summary cards exist
    if (document.querySelector('.summary-card')) {
        setTimeout(animateNumbers, 500);
    }
    
    // Show any success messages
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 300);
        }, 3000);
    });
});

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
    showAlert('An error occurred. Please refresh the page and try again.', 'error');
});

// Handle unhandled promise rejections
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
    showAlert('An error occurred. Please refresh the page and try again.', 'error');
});

// Export functions for global access
window.checkprovider = checkprovider;
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.toggleSidebar = toggleSidebar;

