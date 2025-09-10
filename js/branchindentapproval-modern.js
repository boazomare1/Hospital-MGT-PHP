// Branch Indent Approval Modern JavaScript
let allIndentData = [];
let filteredIndentData = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let searchForm, locationSelect, statusSelect, docnoInput;
let indentTable, sidebarToggle, leftSidebar, menuToggle;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupAutoHideAlerts();
    setupFormValidation();
    setupIndentActions();
});

function initializeElements() {
    searchForm = document.getElementById('searchForm');
    locationSelect = document.getElementById('location');
    statusSelect = document.getElementById('searchstatus');
    docnoInput = document.getElementById('docno');
    indentTable = document.getElementById('indentTable');
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
    
    // Status change
    if (statusSelect) {
        statusSelect.addEventListener('change', handleStatusChange);
    }
    
    // Document number input
    if (docnoInput) {
        docnoInput.addEventListener('input', handleDocnoChange);
    }
    
    // Indent actions
    setupIndentActions();
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
    
    if (docnoInput) {
        docnoInput.addEventListener('blur', validateDocno);
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

function validateDocno(e) {
    const input = e.target;
    const value = input.value.trim();
    
    if (value !== '' && value.length < 3) {
        showFieldError(input, 'Document number must be at least 3 characters');
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

function setupIndentActions() {
    // Setup action buttons for each indent row
    const viewApproveButtons = document.querySelectorAll('.view-approve-btn');
    viewApproveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const docno = this.getAttribute('data-docno');
            const status = this.getAttribute('data-status');
            
            if (docno) {
                openIndentApproval(docno, status);
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
    const submitBtn = e.target.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        submitBtn.classList.add('loading');
    }
    
    return true;
}

function validateForm() {
    let isValid = true;
    
    if (locationSelect && !validateLocation({ target: locationSelect })) {
        isValid = false;
    }
    
    if (docnoInput && !validateDocno({ target: docnoInput })) {
        isValid = false;
    }
    
    return isValid;
}

function handleLocationChange(e) {
    const selectedLocation = e.target.value;
    // Update location display
    updateLocationDisplay(selectedLocation);
    
    // Trigger search if form is already submitted
    if (searchForm && searchForm.querySelector('input[name="cbfrmflag1"]')) {
        searchForm.submit();
    }
}

function handleStatusChange(e) {
    const selectedStatus = e.target.value;
    console.log('Status changed to:', selectedStatus);
    
    // Trigger search if form is already submitted
    if (searchForm && searchForm.querySelector('input[name="cbfrmflag1"]')) {
        searchForm.submit();
    }
}

function handleDocnoChange(e) {
    const docnoValue = e.target.value;
    console.log('Document number changed to:', docnoValue);
}

function updateLocationDisplay(locationCode) {
    const locationDisplay = document.getElementById('ajaxlocation');
    if (locationDisplay) {
        // This would typically make an AJAX call to get location name
        // For now, we'll just show the code
        locationDisplay.innerHTML = `<strong>Location:</strong> ${locationCode}`;
    }
}

function openIndentApproval(docno, status) {
    const url = `purchaseindentapproval_one.php?docno=${encodeURIComponent(docno)}&menuid=${encodeURIComponent(menu_id)}`;
    window.open(url, '_blank');
    showNotification(`Opening indent approval for document ${docno}`, 'info');
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
    const url = `print_branchindentapprovalpdf.php?location=${locationSelect?.value || ''}`;
    window.open(url, '_blank');
    showNotification('PDF export initiated', 'success');
}

function exportToExcel() {
    const url = `print_branchindentapprovalexcel.php?location=${locationSelect?.value || ''}`;
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
        if (statusSelect) statusSelect.value = 'Purchase Indent';
        if (docnoInput) docnoInput.value = '';
        
        // Clear all field errors
        const fieldErrors = document.querySelectorAll('.field-error');
        fieldErrors.forEach(error => error.remove());
        
        showNotification('Form reset successfully', 'success');
    }
}

function updateIndentCount() {
    const visibleRows = document.querySelectorAll('.indent-table tbody tr:not([style*="display: none"])').length;
    const indentCountElement = document.querySelector('.indent-count');
    if (indentCountElement) {
        indentCountElement.textContent = visibleRows;
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

// Enhanced indent status functions
function getIndentStatusClass(status) {
    const statusLower = status.toLowerCase();
    if (statusLower.includes('approved')) return 'approved';
    if (statusLower.includes('pending')) return 'pending';
    if (statusLower.includes('rejected')) return 'rejected';
    if (statusLower.includes('processing')) return 'processing';
    return 'pending';
}

function updateIndentStatus(docno, newStatus) {
    // This would typically make an AJAX call to update the status
    showNotification(`Indent for document ${docno} status updated to ${newStatus}`, 'success');
    
    // Update the UI
    const statusCell = document.querySelector(`[data-docno="${docno}"] .indent-status`);
    if (statusCell) {
        statusCell.textContent = newStatus;
        statusCell.className = `indent-status ${getIndentStatusClass(newStatus)}`;
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
        if (docnoInput) {
            docnoInput.focus();
        }
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const rows = document.querySelectorAll('.indent-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        updateIndentCount();
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
    
    .indent-table tr.highlight {
        background: rgba(59, 130, 246, 0.1) !important;
        animation: highlight 0.5s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background: rgba(59, 130, 246, 0.3); }
        100% { background: rgba(59, 130, 246, 0.1); }
    }
    
    .indent-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .indent-table tbody tr:hover {
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
    
    .indent-docno {
        position: relative;
        overflow: hidden;
    }
    
    .indent-docno::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.1), transparent);
        transition: left 0.5s;
    }
    
    .indent-docno:hover::before {
        left: 100%;
    }
    
    .priority-badge {
        position: relative;
        overflow: hidden;
    }
    
    .priority-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .priority-badge:hover::before {
        left: 100%;
    }
`;
document.head.appendChild(style);

// Initialize indent data on page load
window.addEventListener('load', function() {
    // Count total indents
    const totalIndents = document.querySelectorAll('.indent-table tbody tr').length;
    const indentCountElement = document.querySelector('.indent-count');
    if (indentCountElement) {
        indentCountElement.textContent = totalIndents;
    }
    
    // Add row highlighting on click
    const tableRows = document.querySelectorAll('.indent-table tbody tr');
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
