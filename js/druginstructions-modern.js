// Drug Instructions Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeFormValidation();
    initializeDataTable();
    initializeSearch();
});

// Sidebar functionality - matches vat.php behavior
function initializeSidebar() {
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

// Form validation
function initializeFormValidation() {
    const form = document.getElementById('drugInstructionsForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const drugInstInput = document.getElementById('drug_inst');
        const drugInst = drugInstInput.value.trim();

        if (drugInst === '') {
            e.preventDefault();
            showAlert('Please enter drug instructions.', 'error');
            drugInstInput.focus();
            return false;
        }

        if (drugInst.length > 100) {
            e.preventDefault();
            showAlert('Drug instruction must be 100 characters or less.', 'error');
            drugInstInput.focus();
            return false;
        }
    });
}

// Data table functionality
function initializeDataTable() {
    // Add any table-specific functionality here
    console.log('Data table initialized');
}

// Search functionality
function initializeSearch() {
    // Add search functionality if needed
    console.log('Search initialized');
}

// Show alert messages
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alertClass = `alert-${type}`;
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 'info-circle';

    const alertHTML = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;

    alertContainer.innerHTML = alertHTML;

    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }, 5000);
}

// Confirm delete action
function confirmDelete(instructionName, autoNumber) {
    if (confirm(`Are you sure you want to delete the drug instruction "${instructionName}"?`)) {
        window.location.href = `drug_instructions.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate action
function confirmActivate(instructionName, autoNumber) {
    if (confirm(`Are you sure you want to activate the drug instruction "${instructionName}"?`)) {
        window.location.href = `drug_instructions.php?st=activate&anum=${autoNumber}`;
    }
}

// Reset form
function resetForm() {
    const form = document.getElementById('drugInstructionsForm');
    if (form) {
        form.reset();
        const drugInstInput = document.getElementById('drug_inst');
        if (drugInstInput) {
            drugInstInput.focus();
        }
    }
}

// Refresh page
function refreshPage() {
    location.reload();
}

// Export to Excel
function exportToExcel() {
    const tables = document.querySelectorAll('.data-table');
    let csv = [];
    
    tables.forEach(table => {
        const rows = Array.from(table.querySelectorAll('tr'));
        rows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('th, td'));
            const rowData = cells.map(cell => `"${cell.textContent.trim()}"`).join(',');
            csv.push(rowData);
        });
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'drug_instructions.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

// Utility function for debouncing
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}



