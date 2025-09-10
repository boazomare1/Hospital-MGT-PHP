// Approve Additional Package Items Modern JavaScript
let allPackageData = [];
let filteredPackageData = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchForm, locationSelect, wardSelect;
let packageTable, sidebarToggle, leftSidebar, menuToggle;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupAutoHideAlerts();
    setupFormValidation();
    setupPackageActions();
});

function initializeElements() {
    searchForm = document.getElementById('searchForm');
    locationSelect = document.getElementById('location');
    wardSelect = document.getElementById('ward');
    packageTable = document.getElementById('packageTable');
    sidebarToggle = document.getElementById('sidebarToggle');
    leftSidebar = document.getElementById('leftSidebar');
    menuToggle = document.getElementById('menuToggle');
}

function setupEventListeners() {
    // Form submission
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Location change
    if (locationSelect) {
        locationSelect.addEventListener('change', handleLocationChange);
    }
    
    // Ward change
    if (wardSelect) {
        wardSelect.addEventListener('change', handleWardChange);
    }
    
    // Package actions
    setupPackageActions();
}

function setupSidebarToggle() {
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                leftSidebar.classList.remove('active');
            }
        }
    });
}

function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

function setupFormValidation() {
    // Add real-time validation for required fields
    if (locationSelect) {
        locationSelect.addEventListener('blur', validateLocation);
    }
}

function validateLocation(e) {
    const input = e.target;
    const value = input.value.trim();
    
    if (value === '') {
        showFieldError(input, 'Location selection is required');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

function showFieldError(input, message) {
    clearFieldError(input);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.75rem';
    errorDiv.style.marginTop = '0.25rem';
    
    input.parentNode.appendChild(errorDiv);
    input.style.borderColor = '#dc2626';
}

function clearFieldError(input) {
    const errorDiv = input.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
    input.style.borderColor = '';
}

function setupPackageActions() {
    // Setup action buttons for each package row
    const viewApproveButtons = document.querySelectorAll('.view-approve-btn');
    viewApproveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const patientcode = this.getAttribute('data-patientcode');
            const visitcode = this.getAttribute('data-visitcode');
            const patientlocation = this.getAttribute('data-patientlocation');
            const menuid = this.getAttribute('data-menuid');
            
            if (patientcode && visitcode) {
                openPackageApproval(patientcode, visitcode, patientlocation, menuid);
            }
        });
    });
}

function handleFormSubmit(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    const submitBtn = e.target.querySelector('input[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Searching...';
        submitBtn.classList.add('loading');
    }
    
    return true;
}

function validateForm() {
    let isValid = true;
    
    if (locationSelect && !validateLocation({ target: locationSelect })) {
        isValid = false;
    }
    
    return isValid;
}

function handleLocationChange(e) {
    const selectedLocation = e.target.value;
    // Update location display
    updateLocationDisplay(selectedLocation);
    
    // Update ward options based on location
    updateWardOptions(selectedLocation);
    
    // Trigger search if form is already submitted
    if (searchForm && searchForm.querySelector('input[name="cbfrmflag1"]')) {
        searchForm.submit();
    }
}

function handleWardChange(e) {
    const selectedWard = e.target.value;
    // Additional ward-specific logic can be added here
    console.log('Ward changed to:', selectedWard);
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    if (locationDisplay) {
        // This would typically make an AJAX call to get location name
        // For now, we'll just show the code
        locationDisplay.innerHTML = `<strong>Location:</strong> ${locationCode}`;
    }
}

function updateWardOptions(locationCode) {
    if (!wardSelect) return;
    
    // Clear existing options
    wardSelect.innerHTML = '<option value="">Select Ward</option>';
    
    // This would typically make an AJAX call to get ward options
    // For now, we'll simulate with some common wards
    const commonWards = [
        { value: 'ward1', name: 'General Ward' },
        { value: 'ward2', name: 'ICU' },
        { value: 'ward3', name: 'Emergency Ward' },
        { value: 'ward4', name: 'Surgery Ward' }
    ];
    
    commonWards.forEach(ward => {
        const option = document.createElement('option');
        option.value = ward.value;
        option.textContent = ward.name;
        wardSelect.appendChild(option);
    });
}

function openPackageApproval(patientcode, visitcode, patientlocation, menuid) {
    const url = `ippackageadditionalitemsapproval.php?patientcode=${encodeURIComponent(patientcode)}&visitcode=${encodeURIComponent(visitcode)}&patientlocation=${encodeURIComponent(patientlocation)}&menuid=${encodeURIComponent(menuid)}`;
    window.open(url, '_blank');
    showNotification(`Opening package approval for patient ${patientcode}`, 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#d1fae5' : '#dbeafe'};
        color: ${type === 'error' ? '#991b1b' : type === 'success' ? '#065f46' : '#1e40af'};
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 10000;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

function exportToPDF() {
    const url = `print_approveaddpkgitemspdf.php?location=${locationSelect?.value || ''}`;
    window.open(url, '_blank');
    showNotification('PDF export initiated', 'success');
}

function exportToExcel() {
    const url = `print_approveaddpkgitemsexcel.php?location=${locationSelect?.value || ''}`;
    window.open(url, '_blank');
    showNotification('Excel export initiated', 'success');
}

function printPage() {
    window.print();
}

function refreshPage() {
    window.location.reload();
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All search criteria will be cleared.')) {
        if (locationSelect) locationSelect.value = '';
        if (wardSelect) wardSelect.value = '';
        
        // Clear all field errors
        const fieldErrors = document.querySelectorAll('.field-error');
        fieldErrors.forEach(error => error.remove());
        
        showNotification('Form reset successfully', 'success');
    }
}

function updatePackageCount() {
    const visibleRows = document.querySelectorAll('.package-table tbody tr:not([style*="display: none"])').length;
    const packageCountElement = document.querySelector('.package-count');
    if (packageCountElement) {
        packageCountElement.textContent = visibleRows;
    }
}

// Utility functions
function formatDateForInput(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced package status functions
function getPackageStatusClass(status) {
    const statusLower = status.toLowerCase();
    if (statusLower.includes('approved')) return 'approved';
    if (statusLower.includes('pending')) return 'pending';
    if (statusLower.includes('rejected')) return 'rejected';
    if (statusLower.includes('processing')) return 'processing';
    return 'pending';
}

function updatePackageStatus(visitcode, newStatus) {
    // This would typically make an AJAX call to update the status
    showNotification(`Package for visit ${visitcode} status updated to ${newStatus}`, 'success');
    
    // Update the UI
    const statusCell = document.querySelector(`[data-visitcode="${visitcode}"] .package-status`);
    if (statusCell) {
        statusCell.textContent = newStatus;
        statusCell.className = `package-status ${getPackageStatusClass(newStatus)}`;
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to search
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        if (searchForm) {
            searchForm.submit();
        }
    }
    
    // Ctrl/Cmd + P to print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printPage();
    }
    
    // Ctrl/Cmd + F to search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        if (locationSelect) {
            locationSelect.focus();
        }
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const rows = document.querySelectorAll('.package-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        updatePackageCount();
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .notification-close {
        background: none;
        border: none;
        cursor: pointer;
        color: inherit;
        padding: 0;
        margin-left: auto;
    }
    
    .field-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    .package-table tr.highlight {
        background: rgba(59, 130, 246, 0.1) !important;
        animation: highlight 0.5s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background: rgba(59, 130, 246, 0.3); }
        100% { background: rgba(59, 130, 246, 0.1); }
    }
    
    .package-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .package-table tbody tr:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .view-approve-btn {
        position: relative;
        overflow: hidden;
    }
    
    .view-approve-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .view-approve-btn:hover::before {
        left: 100%;
    }
    
    .package-patientcode,
    .package-visitcode {
        position: relative;
        overflow: hidden;
    }
    
    .package-patientcode::before,
    .package-visitcode::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(6, 182, 212, 0.1), transparent);
        transition: left 0.5s;
    }
    
    .package-patientcode:hover::before,
    .package-visitcode:hover::before {
        left: 100%;
    }
`;
document.head.appendChild(style);

// Initialize package data on page load
window.addEventListener('load', function() {
    // Count total package items
    const totalPackages = document.querySelectorAll('.package-table tbody tr').length;
    const packageCountElement = document.querySelector('.package-count');
    if (packageCountElement) {
        packageCountElement.textContent = totalPackages;
    }
    
    // Add row highlighting on click
    const tableRows = document.querySelectorAll('.package-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove highlight from other rows
            tableRows.forEach(r => r.classList.remove('highlight'));
            // Add highlight to clicked row
            this.classList.add('highlight');
        });
    });
    
    // Setup AJAX location function
    setupAjaxLocation();
    
    // Setup ward selection function
    setupWardSelection();
});

function setupAjaxLocation() {
    // Setup AJAX location function for compatibility
    window.ajaxlocationfunction = function(val) {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                const locationDisplay = document.getElementById("ajaxlocation");
                if (locationDisplay) {
                    locationDisplay.innerHTML = xmlhttp.responseText;
                }
            }
        };
        
        xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
        xmlhttp.send();
    };
}

function setupWardSelection() {
    // Setup ward selection function for compatibility
    window.funcSubTypeChange1 = function() {
        const locationValue = document.getElementById('location').value;
        const wardSelect = document.getElementById('ward');
        
        if (!wardSelect) return;
        
        // Clear existing options
        wardSelect.innerHTML = '<option value="">Select Ward</option>';
        
        // This would typically make an AJAX call to get ward options based on location
        // For now, we'll simulate with some common wards
        const commonWards = [
            { value: 'ward1', name: 'General Ward' },
            { value: 'ward2', name: 'ICU' },
            { value: 'ward3', name: 'Emergency Ward' },
            { value: 'ward4', name: 'Surgery Ward' }
        ];
        
        commonWards.forEach(ward => {
            const option = document.createElement('option');
            option.value = ward.value;
            option.textContent = ward.name;
            wardSelect.appendChild(option);
        });
    };
}

// Form validation function for compatibility
function funcvalidcheck() {
    const locationSelect = document.getElementById('location');
    if (locationSelect && locationSelect.value === '') {
        showNotification('Please select a location', 'error');
        return false;
    }
    return true;
}

// Disable enter key function for compatibility
function disableEnterKey() {
    if (event.keyCode == 13) {
        return false;
    }
    return true;
}

