// Consumable by Unit Modern JavaScript
let selectedLocation = '';
let selectedStore = '';

// DOM Elements
let locationSelect, fromstoreSelect, dateFromInput, dateToInput, submitBtn, form;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFormValidation();
    setupKeyboardShortcuts();
});

function initializeElements() {
    locationSelect = document.getElementById('location');
    fromstoreSelect = document.getElementById('fromstore');
    dateFromInput = document.getElementById('ADate1');
    dateToInput = document.getElementById('ADate2');
    submitBtn = document.querySelector('input[name="Submit"]');
    form = document.querySelector('form[name="frmsales"]');
}

function setupEventListeners() {
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
    
    if (fromstoreSelect) {
        fromstoreSelect.addEventListener('change', handleStoreChange);
    }
    
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (form) {
        form.addEventListener('submit', handleFormValidation);
    }
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    }
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-left');
                icon.classList.toggle('fa-chevron-right');
            }
        });
    }
}

function setupFormValidation() {
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
    }
}

function validateForm() {
    let isValid = true;
    const errors = [];
    
    // Validate date range
    if (dateFromInput && dateToInput) {
        const dateFrom = new Date(dateFromInput.value);
        const dateTo = new Date(dateToInput.value);
        
        if (dateFrom > dateTo) {
            errors.push('Date From cannot be greater than Date To');
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function handleFormSubmit(e) {
    if (!validateForm()) {
        e.preventDefault();
        return;
    }
    
    showLoadingState();
    
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Searching...';
    }
}

function handleLocationChange() {
    if (locationSelect) {
        selectedLocation = locationSelect.value;
        loadStoresForLocation(selectedLocation);
    }
}

function handleStoreChange() {
    if (fromstoreSelect) {
        selectedStore = fromstoreSelect.value;
    }
}

function loadStoresForLocation(locationCode) {
    if (!locationCode) {
        clearStoreOptions();
        return;
    }
    
    const username = document.getElementById('username') ? document.getElementById('username').value : '';
    
    if (fromstoreSelect) {
        fromstoreSelect.innerHTML = '<option value="">Loading stores...</option>';
        fromstoreSelect.disabled = true;
    }
    
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (fromstoreSelect) {
                fromstoreSelect.innerHTML = xhr.responseText;
                fromstoreSelect.disabled = false;
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            if (fromstoreSelect) {
                fromstoreSelect.innerHTML = '<option value="">Error loading stores</option>';
                fromstoreSelect.disabled = false;
            }
            showAlert('Error loading stores for selected location.', 'error');
        }
    };
    
    xhr.open('GET', `ajax/ajaxstore.php?loc=${locationCode}&username=${username}`, true);
    xhr.send();
}

function clearStoreOptions() {
    if (fromstoreSelect) {
        fromstoreSelect.innerHTML = '<option value="">Select Store</option>';
        selectedStore = '';
    }
}

function showLoadingState() {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                Searching consumable data, please wait...
            </div>
        `;
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alertClass = `alert-${type}`;
        const iconClass = getIconForAlertType(type);
        
        alertContainer.innerHTML = `
            <div class="alert ${alertClass}">
                <i class="${iconClass}"></i>
                ${message}
            </div>
        `;
        
        if (type === 'success') {
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }
    }
}

function getIconForAlertType(type) {
    const icons = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    return icons[type] || icons['info'];
}

function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.click();
            }
        }
        
        if (e.key === 'Escape') {
            if (confirm('Are you sure you want to clear the form?')) {
                clearForm();
            }
        }
        
        if (e.key === 'F5') {
            e.preventDefault();
            refreshPage();
        }
    });
}

function clearForm() {
    if (locationSelect) {
        locationSelect.value = '';
    }
    
    if (fromstoreSelect) {
        fromstoreSelect.innerHTML = '<option value="">Select Store</option>';
    }
    
    if (dateFromInput) {
        dateFromInput.value = '';
    }
    
    if (dateToInput) {
        dateToInput.value = '';
    }
    
    selectedLocation = '';
    selectedStore = '';
    
    showAlert('Form cleared successfully.', 'success');
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const location = locationSelect ? locationSelect.value : '';
    const fromstore = fromstoreSelect ? fromstoreSelect.value : '';
    const dateFrom = dateFromInput ? dateFromInput.value : '';
    const dateTo = dateToInput ? dateToInput.value : '';
    
    const exportUrl = `print_consumablebyunit.php?fromstore=${fromstore}&location=${location}&ADate1=${dateFrom}&ADate2=${dateTo}&frmflag1=frmflag1`;
    
    window.open(exportUrl, '_blank');
    
    showAlert('Export started. Please check your downloads.', 'success');
}

// Backward compatibility functions
function funcSelectFromStore(id) {
    if (locationSelect) {
        handleLocationChange();
    }
}

function storefunction(loc) {
    selectedLocation = loc;
    loadStoresForLocation(loc);
}

function process1() {
    return validateForm();
}

function disableEnterKey(event) {
    if (event && event.key === 'Enter' && event.ctrlKey) {
        return false;
    }
    return true;
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Consumable by Unit page initialized');
    
    if (dateFromInput && !dateFromInput.value) {
        const today = new Date();
        dateFromInput.value = today.toISOString().split('T')[0];
    }
    
    if (dateToInput && !dateToInput.value) {
        const today = new Date();
        dateToInput.value = today.toISOString().split('T')[0];
    }
    
    showAlert('Welcome to Consumable Report by Unit. Select your criteria and click Search to view the report.', 'info');
});