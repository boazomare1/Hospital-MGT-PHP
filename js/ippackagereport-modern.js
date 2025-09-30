// IP Package Report Modern JavaScript
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
    
    // Initialize package report functionality
    initializePackageReport();
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

function initializePackageReport() {
    // Initialize package report functionality
    const reportCards = document.querySelectorAll('.package-report-card');
    reportCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
}

// Package report management functions
function generatePackageReport() {
    // Generate package report
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
        a.download = 'package_report.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }
}

function filterPackages(criteria) {
    // Filter packages by criteria
    const rows = document.querySelectorAll('.data-table tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (criteria === 'all' || text.includes(criteria.toLowerCase())) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function searchPackages(searchTerm) {
    // Search packages
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

function viewPackageDetails(packageId) {
    // View detailed package information
    console.log('Viewing package details:', packageId);
    showAlert('Loading package details...', 'info');
}

function printPackageReport() {
    // Print package report
    window.print();
}

function exportToPDF() {
    // Export package report to PDF
    console.log('Exporting to PDF...');
    showAlert('Exporting to PDF...', 'info');
}

function emailPackageReport() {
    // Email package report
    console.log('Emailing package report...');
    showAlert('Emailing package report...', 'info');
}

function refreshPackageData() {
    // Refresh package data
    console.log('Refreshing package data...');
    showAlert('Refreshing package data...', 'info');
    
    // Here you would typically reload the data
    // location.reload();
}

function comparePackages() {
    // Compare selected packages
    const selectedCards = document.querySelectorAll('.package-report-card.selected');
    if (selectedCards.length < 2) {
        showAlert('Please select at least 2 packages to compare', 'error');
        return;
    }
    
    console.log('Comparing packages:', selectedCards.length);
    showAlert('Generating comparison report...', 'info');
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
window.generatePackageReport = generatePackageReport;
window.filterPackages = filterPackages;
window.searchPackages = searchPackages;
window.viewPackageDetails = viewPackageDetails;
window.printPackageReport = printPackageReport;
window.exportToPDF = exportToPDF;
window.emailPackageReport = emailPackageReport;
window.refreshPackageData = refreshPackageData;
window.comparePackages = comparePackages;
