// Inpatient Billing Details - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
    
    setupSidebarToggle();
    setupEventListeners();
});

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

function setupEventListeners() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmission);
    }
}

function handleFormSubmission(event) {
    const form = event.target;
    
    if (!validateForm(form)) {
        showAlert('Please fill in all required fields', 'error');
        return;
    }
    
    showLoadingOverlay('Searching for billing details...');
    form.submit();
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('error');
            isValid = false;
        } else {
            field.classList.remove('error');
        }
    });
    
    return isValid;
}

function showLoadingOverlay(message = 'Loading...') {
    const overlay = document.getElementById('imgloader');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

function showAlert(message, type = 'info') {
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="fas fa-info-circle alert-icon"></i>
        <span>${message}</span>
    `;
    
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.appendChild(alertDiv);
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

function refreshPage() {
    showLoadingOverlay('Refreshing page...');
    window.location.reload();
}

function exportToExcel() {
    showAlert('Exporting to Excel...', 'info');
}

function exportResults() {
    showAlert('Exporting results...', 'info');
}

function printResults() {
    showAlert('Preparing results for printing...', 'info');
}

function viewDetails(visitCode) {
    showAlert(`Viewing details for visit: ${visitCode}`, 'info');
}

function printBill(visitCode) {
    showAlert(`Printing bill for visit: ${visitCode}`, 'info');
}

window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.exportResults = exportResults;
window.printResults = printResults;
window.viewDetails = viewDetails;
window.printBill = printBill;