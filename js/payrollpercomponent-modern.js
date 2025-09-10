// Payroll Per Component Modern JavaScript
let allEmployeeRecords = [];
let filteredEmployeeRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchemployeeInput, searchmonthSelect, searchyearSelect, searchcomponentSelect, submitBtn, form1;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeAutoSuggest();
    setupFormValidation();
});

function initializeElements() {
    searchemployeeInput = document.getElementById('searchemployee');
    searchmonthSelect = document.getElementById('searchmonth');
    searchyearSelect = document.getElementById('searchyear');
    searchcomponentSelect = document.getElementById('searchcomponent');
    submitBtn = document.querySelector('.submit-btn');
    form1 = document.getElementById('form1');
}

function setupEventListeners() {
    if (form1) {
        form1.addEventListener('submit', handleFormSubmit);
    }
    
    if (searchemployeeInput) {
        searchemployeeInput.addEventListener('input', debounce(handleEmployeeSearch, 300));
    }
    
    if (searchmonthSelect) {
        searchmonthSelect.addEventListener('change', validateForm);
    }
    
    if (searchyearSelect) {
        searchyearSelect.addEventListener('change', validateForm);
    }
    
    if (searchcomponentSelect) {
        searchcomponentSelect.addEventListener('change', validateForm);
    }
}

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

function initializeAutoSuggest() {
    if (typeof AutoSuggestControl !== 'undefined' && searchemployeeInput) {
        try {
            var oTextbox = new AutoSuggestControl(searchemployeeInput, new StateSuggestions());
        } catch (error) {
            console.log('AutoSuggest not available:', error);
        }
    }
}

function setupFormValidation() {
    // Real-time form validation
    const inputs = [searchemployeeInput, searchmonthSelect, searchyearSelect, searchcomponentSelect];
    
    inputs.forEach(input => {
        if (input) {
            input.addEventListener('input', validateForm);
            input.addEventListener('change', validateForm);
        }
    });
    
    // Initial validation
    validateForm();
}

function validateForm() {
    const month = searchmonthSelect ? searchmonthSelect.value : '';
    const year = searchyearSelect ? searchyearSelect.value : '';
    const component = searchcomponentSelect ? searchcomponentSelect.value : '';
    
    if (submitBtn) {
        if (month && year) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        }
    }
}

function handleFormSubmit(event) {
    const month = searchmonthSelect ? searchmonthSelect.value : '';
    const year = searchyearSelect ? searchyearSelect.value : '';
    const employee = searchemployeeInput ? searchemployeeInput.value.trim() : '';
    const component = searchcomponentSelect ? searchcomponentSelect.value : '';
    
    // Basic validation
    if (!month) {
        alert('Please select a month.');
        event.preventDefault();
        if (searchmonthSelect) searchmonthSelect.focus();
        return false;
    }
    
    if (!year) {
        alert('Please select a year.');
        event.preventDefault();
        if (searchyearSelect) searchyearSelect.focus();
        return false;
    }
    
    // Show loading state
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
        submitBtn.disabled = true;
    }
    
    return true;
}

function handleEmployeeSearch(searchTerm) {
    // This would typically make an AJAX call to search for employees
    // For now, we'll just log the search term
    console.log('Searching for employee:', searchTerm);
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

// Export to Excel function
function exportToExcel() {
    const reportSection = document.querySelector('.report-results-section');
    if (!reportSection) {
        alert('No report data available to export.');
        return;
    }
    
    let csv = [];
    const tables = reportSection.querySelectorAll('.data-table');
    
    tables.forEach((table, tableIndex) => {
        const rows = table.querySelectorAll('tr');
        
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll('td, th');
            
            for (let j = 0; j < cols.length; j++) {
                let text = cols[j].innerText.replace(/,/g, ';');
                row.push('"' + text + '"');
            }
            
            csv.push(row.join(','));
        }
        
        // Add separator between tables
        if (tableIndex < tables.length - 1) {
            csv.push('');
        }
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'payroll_per_component_report.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Reset form function
function resetForm() {
    if (searchemployeeInput) {
        searchemployeeInput.value = '';
    }
    if (searchmonthSelect) {
        searchmonthSelect.value = '';
    }
    if (searchyearSelect) {
        searchyearSelect.value = '';
    }
    if (searchcomponentSelect) {
        searchcomponentSelect.value = '';
    }
    
    validateForm();
    
    if (searchemployeeInput) {
        searchemployeeInput.focus();
    }
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

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Enhanced input styling
function enhanceInputStyling() {
    const inputs = document.querySelectorAll('.form-input');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.boxShadow = '0 0 0 3px rgba(30, 64, 175, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = 'var(--border-color)';
            this.style.boxShadow = 'none';
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = 'var(--medstar-primary)';
            } else {
                this.style.borderColor = 'var(--border-color)';
            }
        });
    });
}

// Initialize enhanced styling
document.addEventListener('DOMContentLoaded', function() {
    enhanceInputStyling();
});

// Print functionality
function printReport() {
    const reportSection = document.querySelector('.report-results-section');
    if (!reportSection) {
        alert('No report data available to print.');
        return;
    }
    
    const printWindow = window.open('', '_blank');
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Payroll Per Component Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .report-header { margin-bottom: 20px; }
                .info-item { margin-bottom: 10px; }
            </style>
        </head>
        <body>
            ${reportSection.innerHTML}
        </body>
        </html>
    `;
    
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + R for refresh
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    // Ctrl + E for export
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }
    
    // Ctrl + P for print
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        printReport();
    }
});

// Form auto-save functionality
function autoSaveForm() {
    const formData = {
        searchemployee: searchemployeeInput ? searchemployeeInput.value : '',
        searchmonth: searchmonthSelect ? searchmonthSelect.value : '',
        searchyear: searchyearSelect ? searchyearSelect.value : '',
        searchcomponent: searchcomponentSelect ? searchcomponentSelect.value : ''
    };
    
    localStorage.setItem('payrollPerComponentForm', JSON.stringify(formData));
}

function loadSavedForm() {
    const savedData = localStorage.getItem('payrollPerComponentForm');
    if (savedData) {
        try {
            const formData = JSON.parse(savedData);
            
            if (searchemployeeInput && formData.searchemployee) {
                searchemployeeInput.value = formData.searchemployee;
            }
            if (searchmonthSelect && formData.searchmonth) {
                searchmonthSelect.value = formData.searchmonth;
            }
            if (searchyearSelect && formData.searchyear) {
                searchyearSelect.value = formData.searchyear;
            }
            if (searchcomponentSelect && formData.searchcomponent) {
                searchcomponentSelect.value = formData.searchcomponent;
            }
        } catch (error) {
            console.log('Error loading saved form data:', error);
        }
    }
}

// Initialize auto-save
document.addEventListener('DOMContentLoaded', function() {
    loadSavedForm();
    
    // Auto-save every 30 seconds
    setInterval(autoSaveForm, 30000);
    
    // Auto-save on form change
    const formInputs = document.querySelectorAll('#form1 input, #form1 select');
    formInputs.forEach(input => {
        input.addEventListener('change', autoSaveForm);
    });
});

// Clear saved form data
function clearSavedForm() {
    localStorage.removeItem('payrollPerComponentForm');
    resetForm();
}