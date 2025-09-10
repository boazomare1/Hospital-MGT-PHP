// Bill Enquiry Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupFormValidation();
    setupBillTypeToggle();
    setupLocationDependency();
    setupExportPrint();
    setupTableInteractions();
});

// Sidebar Toggle Functionality
function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

// Form Validation
function setupFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
}

function validateForm() {
    const billtype = document.getElementById('billtype');
    const location = document.getElementById('location');
    const searchpatientcode = document.getElementById('searchpatientcode');
    const searchvisitcode = document.getElementById('searchvisitcode');
    const searchbillnumber = document.getElementById('searchbillnumber');
    
    let isValid = true;
    clearErrors();
    
    // At least one search criteria should be provided
    const hasSearchCriteria = searchpatientcode.value.trim() || 
                             searchvisitcode.value.trim() || 
                             searchbillnumber.value.trim();
    
    if (!hasSearchCriteria) {
        showError(searchpatientcode, 'Please provide at least one search criteria');
        isValid = false;
    }
    
    // Validate location
    if (location && !location.value) {
        showError(location, 'Please select a location');
        isValid = false;
    }
    
    // Validate bill type
    if (billtype && !billtype.value) {
        showError(billtype, 'Please select a bill type');
        isValid = false;
    }
    
    return isValid;
}

function showError(field, message) {
    clearError(field);
    
    field.style.borderColor = '#dc3545';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearError(field) {
    field.style.borderColor = '';
    
    const existingError = field.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(error => error.remove());
    
    const fields = document.querySelectorAll('.form-control, .search-input');
    fields.forEach(field => {
        field.style.borderColor = '';
    });
}

// Bill Type Toggle
function setupBillTypeToggle() {
    const billtypeSelect = document.getElementById('billtype');
    
    if (billtypeSelect) {
        billtypeSelect.addEventListener('change', function() {
            updateBillTypeDisplay(this.value);
        });
        
        // Initialize bill type display if pre-selected
        if (billtypeSelect.value) {
            updateBillTypeDisplay(billtypeSelect.value);
        }
    }
}

function updateBillTypeDisplay(billType) {
    const billTypeDisplay = document.getElementById('billTypeDisplay');
    
    if (!billTypeDisplay) return;
    
    const typeNames = {
        '1': 'OP (Outpatient)',
        '2': 'IP (Inpatient)',
        '3': 'Advance Deposit',
        '4': 'Allocation'
    };
    
    billTypeDisplay.innerHTML = `<strong>Bill Type:</strong> ${typeNames[billType] || 'All Types'}`;
}

// Location Dependency
function setupLocationDependency() {
    const locationSelect = document.getElementById('location');
    
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            updateLocationDisplay(this.value);
        });
        
        // Initialize location display if pre-selected
        if (locationSelect.value) {
            updateLocationDisplay(locationSelect.value);
        }
    }
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    
    if (!locationDisplay || !locationCode) return;
    
    // Fetch location name via AJAX
    fetch(`ajax/ajaxgetlocationname.php?loccode=${locationCode}`)
        .then(response => response.text())
        .then(data => {
            locationDisplay.innerHTML = `<strong>Location:</strong> ${data}`;
        })
        .catch(error => {
            console.error('Error fetching location name:', error);
            locationDisplay.innerHTML = '<strong>Location:</strong> Selected';
        });
}

// Export and Print Functionality
function setupExportPrint() {
    const exportBtn = document.getElementById('exportBtn');
    const printBtn = document.getElementById('printBtn');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportReport();
        });
    }
    
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            printReport();
        });
    }
}

function exportReport() {
    const form = document.querySelector('form[name="cbform1"]');
    if (!form) return;
    
    // Create a temporary form for export
    const exportForm = form.cloneNode(true);
    exportForm.action = 'export_billenquiry.php';
    exportForm.target = '_blank';
    exportForm.method = 'POST';
    
    // Add export type
    const exportType = document.createElement('input');
    exportType.type = 'hidden';
    exportType.name = 'export_type';
    exportType.value = 'excel';
    exportForm.appendChild(exportType);
    
    // Submit the form
    document.body.appendChild(exportForm);
    exportForm.submit();
    document.body.removeChild(exportForm);
}

function printReport() {
    // Hide sidebar and buttons for printing
    const sidebar = document.getElementById('leftSidebar');
    const btnGroup = document.querySelector('.btn-group');
    const filterContainer = document.querySelector('.filter-container');
    
    const originalSidebarDisplay = sidebar ? sidebar.style.display : '';
    const originalBtnGroupDisplay = btnGroup ? btnGroup.style.display : '';
    const originalFilterDisplay = filterContainer ? filterContainer.style.display : '';
    
    if (sidebar) sidebar.style.display = 'none';
    if (btnGroup) btnGroup.style.display = 'none';
    if (filterContainer) filterContainer.style.display = 'none';
    
    // Print the page
    window.print();
    
    // Restore original display values
    if (sidebar) sidebar.style.display = originalSidebarDisplay;
    if (btnGroup) btnGroup.style.display = originalBtnGroupDisplay;
    if (filterContainer) filterContainer.style.display = originalFilterDisplay;
}

// Table Interactions
function setupTableInteractions() {
    // Add row click handlers for better UX
    const tableRows = document.querySelectorAll('.modern-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove active class from other rows
            tableRows.forEach(r => r.classList.remove('active'));
            // Add active class to clicked row
            this.classList.add('active');
        });
    });
    
    // Add hover effects
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        row.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.backgroundColor = '';
            }
        });
    });
}

// Utility Functions
function showLoading() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.id = 'loadingOverlay';
    loadingOverlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    const loadingContent = document.createElement('div');
    loadingContent.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    `;
    
    loadingContent.innerHTML = `
        <div class="loading-spinner"></div>
        <div>Searching bills...</div>
    `;
    
    loadingOverlay.appendChild(loadingContent);
    document.body.appendChild(loadingOverlay);
}

function hideLoading() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.remove();
    }
}

// Form submission with loading
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function() {
            showLoading();
        });
    }
});

// Auto-refresh functionality (optional)
function setupAutoRefresh() {
    const autoRefreshCheckbox = document.getElementById('autoRefresh');
    let refreshInterval;
    
    if (autoRefreshCheckbox) {
        autoRefreshCheckbox.addEventListener('change', function() {
            if (this.checked) {
                refreshInterval = setInterval(function() {
                    const form = document.querySelector('form[name="cbform1"]');
                    if (form && form.querySelector('input[name="cbfrmflag1"]').value) {
                        form.submit();
                    }
                }, 30000); // Refresh every 30 seconds
            } else {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            }
        });
    }
}

// Initialize auto-refresh if checkbox exists
document.addEventListener('DOMContentLoaded', setupAutoRefresh);