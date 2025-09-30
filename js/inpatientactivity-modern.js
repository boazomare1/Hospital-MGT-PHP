// Inpatient Activity Modern JavaScript
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

    // Initialize date pickers
    initializeDatePickers();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize activity tracking
    initializeActivityTracking();
});

function validateForm() {
    // Add form validation logic here
    const requiredFields = document.querySelectorAll('[required]');
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            showAlert(`Please fill in ${field.previousElementSibling.textContent}`, 'error');
            field.focus();
            return false;
        }
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
    // Auto-complete functionality is handled by existing PHP includes
    // This function can be extended for additional functionality
}

function initializeActivityTracking() {
    // Initialize activity tracking functionality
    const activityCards = document.querySelectorAll('.activity-card');
    activityCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
}

// Activity management functions
function addActivity(activityType, description) {
    const activityContainer = document.getElementById('activityContainer');
    if (activityContainer) {
        const activityCard = document.createElement('div');
        activityCard.className = 'activity-card';
        activityCard.innerHTML = `
            <h4><i class="fas fa-${getActivityIcon(activityType)}"></i> ${activityType}</h4>
            <p>${description}</p>
            <small>${new Date().toLocaleString()}</small>
        `;
        activityContainer.appendChild(activityCard);
    }
}

function getActivityIcon(activityType) {
    const icons = {
        'Admission': 'user-plus',
        'Discharge': 'user-minus',
        'Medication': 'pills',
        'Procedure': 'stethoscope',
        'Consultation': 'user-md',
        'Lab Test': 'flask',
        'Vital Signs': 'heartbeat'
    };
    return icons[activityType] || 'circle';
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
window.addActivity = addActivity;
