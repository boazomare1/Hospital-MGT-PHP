// IP Discharge List Modern JavaScript
let allDischargeRecords = [];
let filteredDischargeRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let locationSelect, wardSelect, searchForm, resultsSection, dataTable;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeData();
});

function initializeElements() {
    locationSelect = document.getElementById('location');
    wardSelect = document.getElementById('ward');
    searchForm = document.getElementById('searchForm');
    resultsSection = document.querySelector('.results-section');
    dataTable = document.querySelector('.data-table');
}

function setupEventListeners() {
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
    
    if (wardSelect) {
        wardSelect.addEventListener('change', handleWardChange);
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

function initializeData() {
    if (!dataTable) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = dataTable.querySelectorAll('tbody tr');
    
    // Convert existing rows to data objects
    allDischargeRecords = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 8) {
            return {
                patientName: cells[1]?.textContent?.trim() || '',
                patientCode: cells[2]?.textContent?.trim() || '',
                doa: cells[3]?.textContent?.trim() || '',
                visitCode: cells[4]?.textContent?.trim() || '',
                ward: cells[5]?.textContent?.trim() || '',
                bed: cells[6]?.textContent?.trim() || '',
                account: cells[7]?.textContent?.trim() || '',
                package: cells[9]?.textContent?.trim() || '',
                type: cells[10]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredDischargeRecords = [...allDischargeRecords];
}

function handleFormSubmit(event) {
    const location = locationSelect.value;
    const ward = wardSelect.value;
    
    if (!location) {
        showAlert('Please select a location.', 'error');
        event.preventDefault();
        locationSelect.focus();
        return false;
    }
    
    if (!ward) {
        showAlert('Please select a ward.', 'error');
        event.preventDefault();
        wardSelect.focus();
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    return true;
}

function handleLocationChange() {
    const locationCode = locationSelect.value;
    if (locationCode) {
        // Call AJAX function to update ward options
        ajaxlocationfunction(locationCode);
        funcSubTypeChange1();
    }
}

function handleWardChange() {
    const ward = wardSelect.value;
    if (ward) {
        // Enable search button or auto-submit
        const submitBtn = searchForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    }
}

// AJAX function for location (from original code)
function ajaxlocationfunction(val) { 
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            const ajaxLocation = document.getElementById("ajaxlocation");
            if (ajaxLocation) {
                ajaxLocation.innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

// Ward change function (from original code)
function funcSubTypeChange1() {
    const locationValue = locationSelect.value;
    if (!locationValue) return;
    
    // This would be populated by PHP in the original implementation
    // For now, we'll just enable the ward selection
    if (wardSelect) {
        wardSelect.disabled = false;
    }
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

// Export to Excel function
function exportToExcel() {
    if (!dataTable) return;
    
    let csv = [];
    const rows = dataTable.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Skip action columns
            if (j === 8 && i > 0) continue;
            
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
        link.setAttribute('download', 'ip_discharge_list_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Show alert function
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = type === 'error' ? 'alert-error' : (type === 'success' ? 'alert-success' : 'alert-info');
    const iconClass = type === 'error' ? 'exclamation-triangle' : (type === 'success' ? 'check-circle' : 'info-circle');
    
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

// Show loading state
function showLoadingState() {
    const submitBtn = searchForm.querySelector('button[type="submit"]');
    if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        submitBtn.disabled = true;
        
        // Reset after 3 seconds (in case of no response)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    }
}

// Enhanced form validation
function validateForm() {
    const location = locationSelect.value;
    const ward = wardSelect.value;
    const submitBtn = searchForm.querySelector('button[type="submit"]');
    
    if (location && ward) {
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
    } else {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
    }
}

// Add validation listeners
if (locationSelect && wardSelect) {
    locationSelect.addEventListener('change', validateForm);
    wardSelect.addEventListener('change', validateForm);
    
    // Initial validation
    validateForm();
}

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
    });
}

// Initialize enhanced styling
document.addEventListener('DOMContentLoaded', function() {
    enhanceInputStyling();
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

// Table row hover effects
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'var(--background-accent)';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
});

// Action button enhancements
document.addEventListener('DOMContentLoaded', function() {
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = 'var(--shadow-medium)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});

// Responsive table handling
function handleResponsiveTable() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    const container = table.closest('.data-table-container');
    if (!container) return;
    
    // Add horizontal scroll indicator
    if (table.scrollWidth > container.clientWidth) {
        container.style.position = 'relative';
        
        // Add scroll indicator
        const indicator = document.createElement('div');
        indicator.className = 'scroll-indicator';
        indicator.innerHTML = '<i class="fas fa-arrows-alt-h"></i> Scroll horizontally to see more columns';
        indicator.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--medstar-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            z-index: 10;
            animation: pulse 2s infinite;
        `;
        
        container.appendChild(indicator);
        
        // Remove indicator after 5 seconds
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 5000);
    }
}

// Initialize responsive table handling
document.addEventListener('DOMContentLoaded', function() {
    handleResponsiveTable();
});

// Add CSS for scroll indicator animation
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
`;
document.head.appendChild(style);
