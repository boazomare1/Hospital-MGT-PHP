// Consultation Refund List Modern JavaScript

// DOM Elements
let patientInput, patientcodeInput, visitcodeInput, dateFromInput, dateToInput, submitBtn, resetBtn, searchForm;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeFormValidation();
    initializePage();
});

function initializeElements() {
    patientInput = document.getElementById('patient');
    patientcodeInput = document.getElementById('patientcode');
    visitcodeInput = document.getElementById('visitcode');
    dateFromInput = document.getElementById('ADate1');
    dateToInput = document.getElementById('ADate2');
    submitBtn = document.querySelector('button[name="Submit"]');
    resetBtn = document.getElementById('resetbutton');
    searchForm = document.querySelector('form[name="cbform1"]');
}

function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    if (resetBtn) {
        resetBtn.addEventListener('click', resetForm);
    }
    
    if (dateFromInput) {
        dateFromInput.addEventListener('blur', validateDateRange);
    }
    
    if (dateToInput) {
        dateToInput.addEventListener('blur', validateDateRange);
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

function initializeFormValidation() {
    if (!searchForm) return;
    
    const inputs = searchForm.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    
    clearFieldError(field);
    
    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    if (fieldName === 'ADate1' && !value) {
        showFieldError(field, 'Please select a start date');
        return false;
    }
    
    if (fieldName === 'ADate2' && !value) {
        showFieldError(field, 'Please select an end date');
        return false;
    }
    
    return true;
}

function validateDateRange() {
    if (!dateFromInput || !dateToInput) return;
    
    const fromDate = new Date(dateFromInput.value);
    const toDate = new Date(dateToInput.value);
    
    if (dateFromInput.value && dateToInput.value && fromDate > toDate) {
        showFieldError(dateToInput, 'End date must be after start date');
        return false;
    }
    
    return true;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function handleFormSubmit(event) {
    const dateFrom = dateFromInput.value.trim();
    const dateTo = dateToInput.value.trim();
    
    clearAllFieldErrors();
    
    let isValid = true;
    
    if (!dateFrom) {
        showFieldError(dateFromInput, 'Please select a start date');
        isValid = false;
    }
    
    if (!dateTo) {
        showFieldError(dateToInput, 'Please select an end date');
        isValid = false;
    }
    
    if (dateFrom && dateTo) {
        const fromDate = new Date(dateFrom);
        const toDate = new Date(dateTo);
        
        if (fromDate > toDate) {
            showFieldError(dateToInput, 'End date must be after start date');
            isValid = false;
        }
    }
    
    if (!isValid) {
        event.preventDefault();
        return false;
    }
    
    showLoadingState();
    return true;
}

function clearAllFieldErrors() {
    const errorFields = searchForm.querySelectorAll('.error');
    errorFields.forEach(field => {
        clearFieldError(field);
    });
}

function showLoadingState() {
    if (searchForm) {
        searchForm.classList.add('loading');
        
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        }
    }
}

function hideLoadingState() {
    if (searchForm) {
        searchForm.classList.remove('loading');
        
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
        }
    }
}

function resetForm() {
    if (searchForm) {
        searchForm.reset();
        clearAllFieldErrors();
        hideLoadingState();
    }
}

function initializePage() {
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            if (j === cols.length - 1 && i > 0) continue;
            
            let text = cols[j].innerText.replace(/,/g, ';');
            row.push('"' + text + '"');
        }
        
        csv.push(row.join(','));
    }
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'consultation_refund_list_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function printReport() {
    window.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        printReport();
    }
    
    if (e.ctrlKey && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }
    
    if (e.key === 'Escape') {
        hideLoadingState();
    }
});

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

// Enhanced table interactions
document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('.data-table');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-1px)';
                this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    }
});

// Backward compatibility functions
function cbsuppliername1() {
    if (searchForm) {
        searchForm.submit();
    }
}

// Enhanced refund processing
function processRefund(patientcode, visitcode) {
    if (confirm(`Are you sure you want to process refund for patient ${patientcode} with visit code ${visitcode}?`)) {
        const refundBtn = event.target.closest('.action-btn');
        if (refundBtn) {
            refundBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            refundBtn.disabled = true;
        }
        
        window.location.href = `consultationrefund.php?patientcode=${patientcode}&visitcode=${visitcode}`;
    }
}

// Add click handlers to refund buttons
document.addEventListener('DOMContentLoaded', function() {
    const refundButtons = document.querySelectorAll('.action-btn.refund');
    refundButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            const urlParams = new URLSearchParams(href.split('?')[1]);
            const patientcode = urlParams.get('patientcode');
            const visitcode = urlParams.get('visitcode');
            
            if (patientcode && visitcode) {
                processRefund(patientcode, visitcode);
            }
        });
    });
});