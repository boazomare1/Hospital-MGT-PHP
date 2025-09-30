// IP Visit Entry New Modern JavaScript
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

    // Initialize autocomplete
    initializeAutocomplete();
    
    // Initialize patient search
    initializePatientSearch();
    
    // Initialize visit form
    initializeVisitForm();
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
    
    // Validate patient selection
    const patientCode = document.getElementById('patientcode');
    if (patientCode && !patientCode.value) {
        showAlert('Please select a patient', 'error');
        patientCode.focus();
        return false;
    }
    
    return true;
}

function initializeAutocomplete() {
    // Auto-complete functionality is handled by existing PHP includes
    // This function can be extended for additional functionality
}

function initializePatientSearch() {
    const patientSearch = document.getElementById('patientcode');
    if (patientSearch) {
        patientSearch.addEventListener('change', function() {
            if (this.value) {
                loadPatientDetails(this.value);
            }
        });
    }
}

function loadPatientDetails(patientCode) {
    // Load patient details when patient is selected
    // This would typically make an AJAX call to get patient information
    console.log('Loading patient details for:', patientCode);
    
    // Show loading state
    const patientInfoCard = document.getElementById('patientInfoCard');
    if (patientInfoCard) {
        patientInfoCard.innerHTML = `
            <div class="patient-info-header">
                <div class="patient-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="patient-details">
                    <h4>Loading...</h4>
                    <p>Please wait while we fetch patient details</p>
                </div>
            </div>
        `;
    }
}

function initializeVisitForm() {
    // Initialize visit form functionality
    const visitForm = document.querySelector('.visit-form');
    if (visitForm) {
        // Add form field listeners
        const formFields = visitForm.querySelectorAll('.form-control');
        formFields.forEach(field => {
            field.addEventListener('change', function() {
                validateField(this);
            });
        });
    }
}

function validateField(field) {
    // Validate individual form fields
    const value = field.value.trim();
    const fieldName = field.previousElementSibling.textContent;
    
    if (field.hasAttribute('required') && !value) {
        showAlert(`${fieldName} is required`, 'error');
        field.classList.add('error');
        return false;
    } else {
        field.classList.remove('error');
        return true;
    }
}

function createNewVisit() {
    // Create new visit entry
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        // Add hidden field to indicate new visit
        const hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = 'frmflag1';
        hiddenField.value = 'frmflag1';
        form.appendChild(hiddenField);
        
        // Submit form
        form.submit();
    }
}

function searchPatient() {
    // Search for patient
    const patientCode = document.getElementById('patientcode');
    if (patientCode && patientCode.value) {
        loadPatientDetails(patientCode.value);
    } else {
        showAlert('Please enter a patient code', 'error');
    }
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
window.createNewVisit = createNewVisit;
window.searchPatient = searchPatient;
