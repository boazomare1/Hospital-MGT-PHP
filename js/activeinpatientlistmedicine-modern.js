// Active Inpatient List Medicine Modern JavaScript
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
    
    // Initialize active inpatient functionality
    initializeActiveInpatients();
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

function initializeActiveInpatients() {
    // Initialize active inpatient functionality
    const patientCards = document.querySelectorAll('.patient-card');
    patientCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
}

// Active inpatient management functions
function viewPatientDetails(patientId) {
    // View patient details
    console.log('Viewing patient details:', patientId);
    showAlert('Loading patient details...', 'info');
}

function prescribeMedicine(patientId) {
    // Prescribe medicine to patient
    console.log('Prescribing medicine to patient:', patientId);
    showAlert('Opening prescription form...', 'info');
}

function viewPatientHistory(patientId) {
    // View patient medical history
    console.log('Viewing patient history:', patientId);
    showAlert('Loading patient history...', 'info');
}

function dischargePatient(patientId) {
    // Discharge patient
    console.log('Discharging patient:', patientId);
    showAlert('Processing discharge...', 'info');
}

function filterPatients(status) {
    // Filter patients by status
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

function searchPatients(searchTerm) {
    // Search patients
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

function generatePatientReport() {
    // Generate patient report
    const table = document.querySelector('.data-table');
    if (table) {
        // Create CSV content
        let csv = [];
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const rowData = Array.from(cells).map(cell => cell.textContent.trim());
            csv.push(rowData.join(','));
        });
        
        // Download CSV
        const csvContent = csv.join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'active_inpatient_report.csv';
        a.click();
        window.URL.revokeObjectURL(url);
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
window.viewPatientDetails = viewPatientDetails;
window.prescribeMedicine = prescribeMedicine;
window.viewPatientHistory = viewPatientHistory;
window.dischargePatient = dischargePatient;
window.filterPatients = filterPatients;
window.searchPatients = searchPatients;
window.generatePatientReport = generatePatientReport;
