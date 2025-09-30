// IP Credit Account Report Modern JavaScript
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
    
    // Initialize credit account functionality
    initializeCreditAccount();
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

function initializeCreditAccount() {
    // Initialize credit account functionality
    const summaryCards = document.querySelectorAll('.summary-card');
    summaryCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
}

// Credit account management functions
function calculateCreditSummary() {
    // Calculate credit account summary
    const totalInvoices = document.getElementById('totalInvoices');
    const totalDeposits = document.getElementById('totalDeposits');
    const outstandingAmount = document.getElementById('outstandingAmount');
    
    if (totalInvoices && totalDeposits && outstandingAmount) {
        const invoices = parseFloat(totalInvoices.textContent) || 0;
        const deposits = parseFloat(totalDeposits.textContent) || 0;
        const outstanding = invoices - deposits;
        
        outstandingAmount.textContent = outstanding.toFixed(2);
        outstandingAmount.className = outstanding >= 0 ? 'amount positive' : 'amount negative';
    }
}

function exportCreditReport() {
    // Export credit account report
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
        a.download = 'credit_account_report.csv';
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
window.calculateCreditSummary = calculateCreditSummary;
window.exportCreditReport = exportCreditReport;
