// IP Drug Consumption Report Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    // Sidebar toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Form validation
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Date picker initialization
    initializeDatePickers();
    
    // Auto-complete functionality
    initializeAutocomplete();
});

function validateForm() {
    const wardSelect = document.getElementById('maternityward');
    const detailedRadio = document.getElementById('detailed');
    const summaryRadio = document.getElementById('summary');
    
    if (!wardSelect.value) {
        alert('Please Select Any Wards');
        wardSelect.focus();
        return false;
    }
    
    if (!detailedRadio.checked && !summaryRadio.checked) {
        alert('Please Select any Report type');
        return false;
    }
    
    return true;
}

function initializeDatePickers() {
    // Initialize date pickers if they exist
    const dateInputs = document.querySelectorAll('.date-picker');
    dateInputs.forEach(input => {
        if (typeof addDatePicker === 'function') {
            addDatePicker(input.id);
        }
    });
}

function initializeAutocomplete() {
    // Auto-complete is handled by jQuery in the PHP file
    // This function can be extended for additional functionality
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} alert-icon"></i>
            ${message}
        `;
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Export functions for global access
window.showAlert = showAlert;
