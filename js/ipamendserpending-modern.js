// IP Amend Service Pending Modern JavaScript
let allServiceRecords = [];
let filteredServiceRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchForm, locationSelect, patientNameInput, patientCodeInput, visitCodeInput, dateFromInput, dateToInput;
let serviceTableBody, searchInput, clearBtn;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeTableFunctionality();
    setupFormValidation();
    setupAutoHideAlerts();
});

function initializeElements() {
    searchForm = document.getElementById('searchForm');
    locationSelect = document.getElementById('location');
    patientNameInput = document.getElementById('patientname');
    patientCodeInput = document.getElementById('patientcode');
    visitCodeInput = document.getElementById('visitcode');
    dateFromInput = document.getElementById('ADate1');
    dateToInput = document.getElementById('ADate2');
    serviceTableBody = document.getElementById('serviceTableBody');
    searchInput = document.getElementById('searchInput');
    clearBtn = document.getElementById('clearBtn');
}

function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce((e) => handleSearch(e.target.value), 300));
    }
    
    // Setup form input listeners for real-time validation
    if (patientNameInput) {
        patientNameInput.addEventListener('input', validatePatientName);
    }
    
    if (patientCodeInput) {
        patientCodeInput.addEventListener('input', validatePatientCode);
    }
    
    if (visitCodeInput) {
        visitCodeInput.addEventListener('input', validateVisitCode);
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

function initializeTableFunctionality() {
    if (!serviceTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = serviceTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allServiceRecords = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 7) {
            return {
                serialNumber: cells[0]?.textContent?.trim() || '',
                consultationDate: cells[1]?.textContent?.trim() || '',
                patientCode: cells[2]?.textContent?.trim() || '',
                visitCode: cells[3]?.textContent?.trim() || '',
                patientName: cells[4]?.textContent?.trim() || '',
                accountName: cells[5]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredServiceRecords = [...allServiceRecords];
}

function setupFormValidation() {
    // Real-time validation for patient name
    if (patientNameInput) {
        patientNameInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value && value.length < 2) {
                showFieldError(this, 'Patient name must be at least 2 characters long');
            } else {
                clearFieldError(this);
            }
        });
    }
    
    // Real-time validation for patient code
    if (patientCodeInput) {
        patientCodeInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value && !/^[A-Z0-9-]+$/i.test(value)) {
                showFieldError(this, 'Patient code can only contain letters, numbers, and hyphens');
            } else {
                clearFieldError(this);
            }
        });
    }
    
    // Real-time validation for visit code
    if (visitCodeInput) {
        visitCodeInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value && !/^[A-Z0-9-]+$/i.test(value)) {
                showFieldError(this, 'Visit code can only contain letters, numbers, and hyphens');
            } else {
                clearFieldError(this);
            }
        });
    }
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.style.borderColor = '#dc2626';
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    field.style.borderColor = '';
}

function validatePatientName() {
    const value = patientNameInput.value.trim();
    if (value && value.length < 2) {
        showFieldError(patientNameInput, 'Patient name must be at least 2 characters long');
        return false;
    }
    clearFieldError(patientNameInput);
    return true;
}

function validatePatientCode() {
    const value = patientCodeInput.value.trim();
    if (value && !/^[A-Z0-9-]+$/i.test(value)) {
        showFieldError(patientCodeInput, 'Patient code can only contain letters, numbers, and hyphens');
        return false;
    }
    clearFieldError(patientCodeInput);
    return true;
}

function validateVisitCode() {
    const value = visitCodeInput.value.trim();
    if (value && !/^[A-Z0-9-]+$/i.test(value)) {
        showFieldError(visitCodeInput, 'Visit code can only contain letters, numbers, and hyphens');
        return false;
    }
    clearFieldError(visitCodeInput);
    return true;
}

function handleFormSubmit(event) {
    // Validate required fields
    const location = locationSelect.value;
    const dateFrom = dateFromInput.value;
    const dateTo = dateToInput.value;
    
    if (!location) {
        alert('Please select a location.');
        event.preventDefault();
        locationSelect.focus();
        return false;
    }
    
    if (!dateFrom) {
        alert('Please select a start date.');
        event.preventDefault();
        dateFromInput.focus();
        return false;
    }
    
    if (!dateTo) {
        alert('Please select an end date.');
        event.preventDefault();
        dateToInput.focus();
        return false;
    }
    
    // Validate date range
    if (new Date(dateFrom) > new Date(dateTo)) {
        alert('Start date cannot be after end date.');
        event.preventDefault();
        dateFromInput.focus();
        return false;
    }
    
    // Validate optional fields if they have values
    if (patientNameInput.value.trim() && !validatePatientName()) {
        event.preventDefault();
        return false;
    }
    
    if (patientCodeInput.value.trim() && !validatePatientCode()) {
        event.preventDefault();
        return false;
    }
    
    if (visitCodeInput.value.trim() && !validateVisitCode()) {
        event.preventDefault();
        return false;
    }
    
    return true;
}

function handleSearch(searchTerm) {
    if (!searchTerm.trim()) {
        // Show all rows
        const rows = serviceTableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
        return;
    }
    
    const term = searchTerm.toLowerCase();
    const rows = serviceTableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 6) {
            const patientCode = cells[2]?.textContent.toLowerCase();
            const visitCode = cells[3]?.textContent.toLowerCase();
            const patientName = cells[4]?.textContent.toLowerCase();
            const accountName = cells[5]?.textContent.toLowerCase();
            
            if (patientCode.includes(term) || 
                visitCode.includes(term) || 
                patientName.includes(term) || 
                accountName.includes(term)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    const rows = serviceTableBody.querySelectorAll('tr');
    rows.forEach(row => row.style.display = '');
}

// Legacy Functions (keeping for compatibility)
function ajaxlocationfunction(val) { 
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("ajaxlocation").innerHTML = xmlhttp.responseText;
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

function cbcustomername1() {
    document.cbform1.submit();
}

function disableEnterKey(varPassed) {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    var key;
    if (window.event) {
        key = window.event.keyCode;
    } else {
        key = e.which;
    }

    if (key == 13) {
        return false;
    } else {
        return true;
    }
}

function loadprintpage1(banum) {
    var banum = banum;
    window.open("print_bill1_op1.php?billautonumber=" + banum + "", "Window" + banum + "", 'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
}

// Enhanced Functions
function printPage() {
    window.print();
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

function exportToCSV() {
    const table = document.querySelector('.data-table');
    if (!table) {
        showNotification('No data to export', 'error');
        return;
    }
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Skip action columns
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
        link.setAttribute('download', 'ip_service_pending.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showNotification('CSV exported successfully', 'success');
    }
}

function viewPatientDetails(patientcode, visitcode) {
    // Enhanced patient details view with modal or new window
    const url = `patient_details.php?patientcode=${encodeURIComponent(patientcode)}&visitcode=${encodeURIComponent(visitcode)}`;
    window.open(url, 'PatientDetails', 'width=800,height=600,scrollbars=yes,resizable=yes');
}

function printConsultation(patientcode, visitcode) {
    // Enhanced print consultation with proper formatting
    const url = `print_consultation.php?patientcode=${encodeURIComponent(patientcode)}&visitcode=${encodeURIComponent(visitcode)}`;
    window.open(url, 'PrintConsultation', 'width=800,height=600,scrollbars=yes,resizable=yes');
}

function viewServiceDetails(patientcode, visitcode) {
    // Enhanced service details view
    const url = `service_details.php?patientcode=${encodeURIComponent(patientcode)}&visitcode=${encodeURIComponent(visitcode)}`;
    window.open(url, 'ServiceDetails', 'width=1000,height=700,scrollbars=yes,resizable=yes');
}

// Utility Functions
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

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.backgroundColor = '#10b981';
            break;
        case 'error':
            notification.style.backgroundColor = '#ef4444';
            break;
        case 'warning':
            notification.style.backgroundColor = '#f59e0b';
            break;
        default:
            notification.style.backgroundColor = '#3b82f6';
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Enhanced form reset functionality
function resetForm() {
    if (searchForm) {
        searchForm.reset();
    }
    
    // Clear any field errors
    const fieldErrors = document.querySelectorAll('.field-error');
    fieldErrors.forEach(error => error.remove());
    
    // Reset input borders
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.style.borderColor = '';
    });
    
    // Focus on first input
    if (locationSelect) {
        locationSelect.focus();
    }
    
    showNotification('Form reset successfully', 'success');
}

// Enhanced table row highlighting
function highlightRow(row) {
    row.style.backgroundColor = '#fef3c7';
    setTimeout(() => {
        row.style.backgroundColor = '';
    }, 2000);
}

// Enhanced action button functionality
function enhanceActionButtons() {
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
}

// Initialize enhanced features
document.addEventListener('DOMContentLoaded', function() {
    enhanceActionButtons();
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + P for print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            printPage();
        }
        
        // Ctrl/Cmd + E for export
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            exportToCSV();
        }
        
        // Ctrl/Cmd + F for search focus
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
    });
});


