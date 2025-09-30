// Modern JavaScript for Global Stock Movement Report

$(document).ready(function() {
    // Initialize sidebar toggle
    initializeSidebar();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize autocomplete
    initializeAutocomplete();
    
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
}

// Form validation
function initializeFormValidation() {
    // Real-time validation
    $('#location').on('change', function() {
        if ($(this).val() === '') {
            showFieldError('location', 'Please select a location');
        } else {
            clearFieldError('location');
        }
    });
    
    $('#itemname').on('input', function() {
        if ($(this).val().trim() === '') {
            showFieldError('itemname', 'Please enter item name');
        } else {
            clearFieldError('itemname');
        }
    });
}

// Autocomplete functionality
function initializeAutocomplete() {
    // Item name autocomplete
    if (typeof funcCustomerDropDownSearch1 === 'function') {
        funcCustomerDropDownSearch1();
    }
}

// Main form validation function
function Locationcheck() {
    let isValid = true;
    
    // Clear previous errors
    $('.field-error').remove();
    $('.error').removeClass('error');
    
    // Validate location
    if (document.getElementById("location").value == '') {
        showFieldError('location', 'Please select location');
        document.getElementById("location").focus();
        isValid = false;
    }
    
    // Validate item name
    if (document.getElementById("itemname").value == '') {
        showFieldError('itemname', 'Please enter item name');
        document.getElementById("itemname").focus();
        isValid = false;
    }
    
    if (!isValid) {
        showAlert('Please correct the errors above', 'error');
        return false;
    }
    
    return true;
}

// Store function for AJAX dropdown
function storefunction(loc) {
    const username = document.getElementById("username").value;
    
    if (!loc) {
        document.getElementById("store").innerHTML = '<option value="">Select Store</option>';
        return;
    }
    
    const xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("store").innerHTML = xmlhttp.responseText;
        }
    };
    
    xmlhttp.open("GET", "ajax/ajaxstore.php?loc=" + loc + "&username=" + username, true);
    xmlhttp.send();
}

// Disable enter key function
function disableEnterKey() {
    if (event.keyCode == 8) {
        event.keyCode = 0;
        return event.keyCode;
        return false;
    }
    
    let key;
    if (window.event) {
        key = window.event.keyCode;     //IE
    } else {
        key = event.which;     //firefox
    }
    
    if (key == 13) { // if enter key press
        return false;
    } else {
        return true;
    }
}

// Show field error
function showFieldError(fieldId, message) {
    const field = $('#' + fieldId);
    const errorId = fieldId + '_error';
    
    // Remove existing error
    $('#' + errorId).remove();
    
    // Add error message
    field.after(`<div id="${errorId}" class="field-error">${message}</div>`);
    field.addClass('error');
}

// Clear field error
function clearFieldError(fieldId) {
    const field = $('#' + fieldId);
    const errorId = fieldId + '_error';
    
    $('#' + errorId).remove();
    field.removeClass('error');
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    const alertId = 'alert_' + Date.now();
    
    const alertHTML = `
        <div id="${alertId}" class="alert alert-${type}">
            <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-triangle' : 'info-circle')} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

function autoHideAlerts() {
    setTimeout(() => {
        $('.alert').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Table enhancement functions
function enhanceTable() {
    // Add sorting functionality to table headers
    $('.data-table th').each(function() {
        $(this).css('cursor', 'pointer');
        $(this).append(' <i class="fas fa-sort"></i>');
    });
    
    // Add row highlighting
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover-row');
        },
        function() {
            $(this).removeClass('hover-row');
        }
    );
}

// Initialize table enhancements when results are loaded
$(document).ready(function() {
    if ($('.data-table').length > 0) {
        enhanceTable();
    }
});

// Add CSS for field errors and enhancements
const additionalStyles = `
    <style>
    .field-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .form-input.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
    
    .alert {
        animation: slideIn 0.3s ease-out;
    }
    
    .hover-row {
        background: var(--background-accent) !important;
        transform: scale(1.01);
        transition: all 0.2s ease;
    }
    
    .data-table th:hover {
        background: var(--medstar-primary-light);
        color: white;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: var(--background-accent);
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: var(--medstar-secondary);
        border-radius: 4px;
    }
    
    .table-container::-webkit-scrollbar-thumb:hover {
        background: var(--medstar-primary);
    }
    </style>
`;

// Inject additional styles
document.head.insertAdjacentHTML('beforeend', additionalStyles);


