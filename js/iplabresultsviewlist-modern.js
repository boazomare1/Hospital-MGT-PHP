// IP Lab Results View List Modern JavaScript
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
    
    // Initialize lab results functionality
    initializeLabResults();
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

function initializeLabResults() {
    // Initialize lab results functionality
    const labResultCards = document.querySelectorAll('.lab-result-card');
    labResultCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
}

// Lab results management functions
function viewLabResult(resultId) {
    // View detailed lab result
    console.log('Viewing lab result:', resultId);
    showAlert('Opening lab result details...', 'info');
}

function printLabResult(resultId) {
    // Print lab result
    console.log('Printing lab result:', resultId);
    showAlert('Printing lab result...', 'info');
}

function downloadLabResult(resultId) {
    // Download lab result as PDF
    console.log('Downloading lab result:', resultId);
    showAlert('Downloading lab result...', 'info');
}

function filterLabResults(status) {
    // Filter lab results by status
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach(row => {
        const statusCell = row.querySelector('.status-badge');
        if (statusCell) {
            const rowStatus = statusCell.textContent.toLowerCase();
            if (status === 'all' || rowStatus.includes(status.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

function searchLabResults(searchTerm) {
    // Search lab results
    const rows = document.querySelectorAll('.data-table tbody tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(term)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
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
window.viewLabResult = viewLabResult;
window.printLabResult = printLabResult;
window.downloadLabResult = downloadLabResult;
window.filterLabResults = filterLabResults;
window.searchLabResults = searchLabResults;
