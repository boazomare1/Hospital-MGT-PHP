// Employee Favorites Modern JavaScript - Matching vat.php standards

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize form functionality
    initializeForms();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize employee details toggles
    initializeEmployeeDetails();
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
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
        });
    });
    
    // Handle checkbox changes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Add visual feedback
            const permissionItem = this.closest('.permission-item');
            if (permissionItem) {
                if (this.checked) {
                    permissionItem.style.borderColor = '#27ae60';
                    permissionItem.style.backgroundColor = '#f8fff9';
                } else {
                    permissionItem.style.borderColor = '#dee2e6';
                    permissionItem.style.backgroundColor = '#ffffff';
                }
            }
        });
    });
}

// Autocomplete functionality
function initializeAutocomplete() {
    // Initialize autocomplete for employee search
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput && typeof AutoSuggestControl !== 'undefined') {
        try {
            const oTextbox = new AutoSuggestControl(searchInput, new StateSuggestions());
        } catch (error) {
            console.log('Autocomplete initialization failed:', error);
        }
    }
}

// Employee details functionality
function initializeEmployeeDetails() {
    // All employee details are initially hidden
    const detailRows = document.querySelectorAll('.employee-details-row');
    detailRows.forEach(row => {
        row.style.display = 'none';
    });
}

function toggleEmployeeDetails(employeeId) {
    const detailRow = document.getElementById('employeeDetails' + employeeId);
    const expandBtn = document.querySelector(`button[onclick="toggleEmployeeDetails(${employeeId})"]`);
    
    if (detailRow && expandBtn) {
        if (detailRow.style.display === 'none') {
            // Show details
            detailRow.style.display = 'table-row';
            expandBtn.innerHTML = '<i class="fas fa-chevron-up"></i> Hide Details';
            expandBtn.classList.add('expanded');
            
            // Scroll to details
            setTimeout(() => {
                detailRow.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'nearest' 
                });
            }, 100);
        } else {
            // Hide details
            detailRow.style.display = 'none';
            expandBtn.innerHTML = '<i class="fas fa-chevron-down"></i> Show Details';
            expandBtn.classList.remove('expanded');
        }
    }
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

// Form validation
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            field.style.borderColor = '#dee2e6';
        }
    });
    
    return isValid;
}

// Handle form submission with validation
function handleFormSubmit(form) {
    if (validateForm(form)) {
        // Add loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        }
        
        return true;
    } else {
        showAlert('Please fill in all required fields.', 'error');
        return false;
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + S to save
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        const activeForm = document.querySelector('form:not([style*="display: none"])');
        if (activeForm) {
            const submitBtn = activeForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.click();
            }
        }
    }
    
    // Escape to close modals/details
    if (e.key === 'Escape') {
        const openDetails = document.querySelector('.employee-details-row[style*="display: table-row"]');
        if (openDetails) {
            const employeeId = openDetails.id.replace('employeeDetails', '');
            toggleEmployeeDetails(employeeId);
        }
    }
});

// Auto-save functionality for checkboxes
function autoSaveFavorites(checkbox) {
    const form = checkbox.closest('form');
    if (form) {
        // Add a small delay to prevent too many requests
        clearTimeout(checkbox.autoSaveTimeout);
        checkbox.autoSaveTimeout = setTimeout(() => {
            // Here you could implement auto-save functionality
            console.log('Auto-saving favorites...');
        }, 1000);
    }
}

// Initialize auto-save for checkboxes
document.addEventListener('change', function(e) {
    if (e.target.type === 'checkbox' && e.target.name === 'is_fav[]') {
        autoSaveFavorites(e.target);
    }
});

// Smooth scrolling for better UX
function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Handle window load
window.addEventListener('load', function() {
    // Initialize any components that need the page to be fully loaded
    console.log('Employee Favorites page loaded successfully');
    
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
window.toggleEmployeeDetails = toggleEmployeeDetails;
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.toggleSidebar = toggleSidebar;

