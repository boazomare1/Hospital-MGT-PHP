/**
 * Interface Machine Modern JavaScript
 * Handles interactive elements for the interface machine management system
 */

$(document).ready(function() {
    // Initialize the application
    initializeApp();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initialize form functionality
    initializeFormFeatures();
});

/**
 * Initialize the application
 */
function initializeApp() {
    console.log('Interface Machine Modern JS initialized');
    
    // Check if sidebar should be collapsed by default on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    }
    
    // Setup form validation
    setupFormValidation();
    
    // Initialize machine features
    initializeMachineFeatures();
}

/**
 * Setup event listeners
 */
function setupEventListeners() {
    // Floating menu toggle
    $('#menuToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Sidebar toggle button
    $('#sidebarToggle').on('click', function() {
        toggleSidebar();
    });
    
    // Form submission
    $('#form1').on('submit', function(e) {
        if (!validateMachineForm()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Auto-hide alerts
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    });
    
    // Real-time form validation
    $('#machine').on('input', function() {
        validateMachineName($(this));
        updateCharacterCount();
    });
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl + / to focus machine name
        if (e.ctrlKey && e.which === 191) {
            e.preventDefault();
            $('#machine').focus();
        }
        
        // Escape to clear form
        if (e.which === 27) {
            clearForm();
        }
        
        // Ctrl + S to submit
        if (e.ctrlKey && e.which === 83) {
            e.preventDefault();
            $('#form1').submit();
        }
    });
}

/**
 * Toggle sidebar visibility
 */
function toggleSidebar() {
    const sidebar = $('.left-sidebar');
    const toggleIcon = $('#sidebarToggle i');
    
    sidebar.toggleClass('collapsed');
    
    // Update toggle icon
    if (sidebar.hasClass('collapsed')) {
        toggleIcon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
    } else {
        toggleIcon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
    }
    
    // Store preference
    localStorage.setItem('sidebarCollapsed', sidebar.hasClass('collapsed'));
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    // Real-time validation for machine name
    $('#machine').on('blur', function() {
        validateMachineName($(this));
    });
    
    // Character count display
    updateCharacterCount();
}

/**
 * Initialize form features
 */
function initializeFormFeatures() {
    // Add character count display
    addCharacterCountDisplay();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Auto-focus first input
    $('#machine').focus();
}

/**
 * Initialize machine features
 */
function initializeMachineFeatures() {
    // Add row hover effects
    $('.data-table tbody tr').hover(
        function() {
            $(this).addClass('hover-effect');
        },
        function() {
            $(this).removeClass('hover-effect');
        }
    );
    
    // Initialize action button tooltips
    $('.action-btn').each(function() {
        const btn = $(this);
        const title = btn.attr('title');
        if (title) {
            btn.attr('data-tooltip', title);
        }
    });
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    $('[data-tooltip]').each(function() {
        const element = $(this);
        const tooltip = element.attr('data-tooltip');
        element.attr('title', tooltip);
    });
}

/**
 * Validate machine form
 */
function validateMachineForm() {
    const machineField = $('#machine');
    
    clearFieldError(machineField);
    
    let isValid = true;
    
    if (machineField.val().trim() === '') {
        showFieldError(machineField, 'Please enter a machine name');
        machineField.focus();
        isValid = false;
    } else if (machineField.val().trim().length > 100) {
        showFieldError(machineField, 'Machine name must be 100 characters or less');
        machineField.focus();
        isValid = false;
    }
    
    return isValid;
}

/**
 * Validate machine name
 */
function validateMachineName(field) {
    const value = field.val().trim();
    
    clearFieldError(field);
    
    if (value.length > 100) {
        showFieldError(field, 'Machine name must be 100 characters or less');
        return false;
    }
    
    if (value.length > 0 && value.length < 2) {
        showFieldError(field, 'Machine name must be at least 2 characters');
        return false;
    }
    
    return true;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.addClass('error');
    field.after(`<div class="field-error">${message}</div>`);
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    field.removeClass('error');
    field.siblings('.field-error').remove();
}

/**
 * Show alert message
 */
function showAlert(type, message) {
    const alertClass = `alert-${type}`;
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-exclamation-triangle' : 
                     type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const alert = `
        <div class="alert ${alertClass}">
            <i class="fas ${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    $('#alertContainer').html(alert);
    
    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);
}

/**
 * Add character count display
 */
function addCharacterCountDisplay() {
    const machineField = $('#machine');
    if (machineField.length) {
        const charCount = $(`
            <div class="character-count">
                <span class="current-count">0</span>/<span class="max-count">100</span> characters
            </div>
        `);
        machineField.after(charCount);
    }
}

/**
 * Update character count
 */
function updateCharacterCount() {
    const machineField = $('#machine');
    const currentCount = machineField.val().length;
    const maxCount = 100;
    
    $('.current-count').text(currentCount);
    
    if (currentCount > maxCount * 0.9) {
        $('.character-count').addClass('warning');
    } else {
        $('.character-count').removeClass('warning');
    }
    
    if (currentCount > maxCount) {
        $('.character-count').addClass('error');
    } else {
        $('.character-count').removeClass('error');
    }
}

/**
 * Refresh page
 */
function refreshPage() {
    showLoadingSpinner();
    setTimeout(function() {
        window.location.reload();
    }, 500);
}

/**
 * Refresh machines
 */
function refreshMachines() {
    refreshPage();
}

/**
 * Clear form
 */
function clearForm() {
    $('#form1')[0].reset();
    $('#machine').val('');
    clearFieldError($('#machine'));
    updateCharacterCount();
}

/**
 * Export machine list
 */
function exportMachineList() {
    // Create CSV content
    const table = document.getElementById('machinesTable');
    const rows = table.querySelectorAll('tbody tr');
    let csvContent = 'Equipment Code,Equipment Name,Type,Status\n';
    
    rows.forEach(function(row) {
        const cells = row.querySelectorAll('td');
        if (cells.length > 1) { // Skip the "no data" row
            const code = cells[1].textContent.trim();
            const name = cells[2].textContent.trim();
            const type = cells[3].textContent.trim();
            const status = cells[4].textContent.trim();
            csvContent += `"${code}","${name}","${type}","${status}"\n`;
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'interface_machines.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('success', 'Machine list exported successfully!');
}

/**
 * Toggle deleted section
 */
function toggleDeletedSection() {
    const section = document.getElementById('deletedSection');
    if (section) {
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }
}

/**
 * Show loading spinner
 */
function showLoadingSpinner() {
    const spinner = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <span>Loading...</span>
        </div>
    `;
    
    $('body').append(spinner);
}

/**
 * Hide loading spinner
 */
function hideLoadingSpinner() {
    $('.loading-spinner').remove();
}

/**
 * Handle window resize
 */
$(window).on('resize', function() {
    // Auto-collapse sidebar on mobile
    if (window.innerWidth <= 768) {
        $('.left-sidebar').addClass('collapsed');
    } else {
        // Restore sidebar state on desktop
        const wasCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (!wasCollapsed) {
            $('.left-sidebar').removeClass('collapsed');
        }
    }
});

/**
 * JavaScript functions for form validation (called from PHP)
 */
function addmachine1process1() {
    return validateMachineForm();
}

function funcDeletemachine(varmachineAutoNumber) {
    var varmachineAutoNumber = varmachineAutoNumber;
    var fRet;
    fRet = confirm('Are you sure want to delete this machine Type ' + varmachineAutoNumber + '?');
    
    if (fRet == true) {
        alert("Interface Machine Entry Delete Completed.");
        return true;
    }
    if (fRet == false) {
        alert("Interface Machine Entry Delete Not Completed.");
        return false;
    }
}

/**
 * Add custom CSS for dynamic elements
 */
$(document).ready(function() {
    // Add custom styles for dynamic elements
    const customStyles = `
        <style>
            .field-error {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }
            
            .field-error::before {
                content: '⚠';
                font-size: 0.75rem;
            }
            
            .form-input.error {
                border-color: #dc3545;
                box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
            }
            
            .loading-spinner {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                font-size: 1.125rem;
                color: #2c5aa0;
            }
            
            .loading-spinner i {
                font-size: 2rem;
                margin-bottom: 1rem;
            }
            
            .hover-effect {
                background-color: #f8f9fa !important;
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            [data-tooltip] {
                position: relative;
            }
            
            [data-tooltip]:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background: #333;
                color: white;
                padding: 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.75rem;
                white-space: nowrap;
                z-index: 1000;
                margin-bottom: 0.25rem;
            }
            
            [data-tooltip]:hover::before {
                content: '';
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                border: 4px solid transparent;
                border-top-color: #333;
                z-index: 1000;
            }
            
            .character-count {
                font-size: 0.75rem;
                color: #6c757d;
                margin-top: 0.25rem;
                text-align: right;
            }
            
            .character-count.warning {
                color: #ffc107;
            }
            
            .character-count.error {
                color: #dc3545;
                font-weight: 600;
            }
            
            .checkbox-group:hover {
                background: #e9ecef;
                border-color: #2c5aa0;
            }
            
            .form-checkbox:checked + .checkbox-label {
                color: #2c5aa0;
            }
            
            .form-checkbox:checked + .checkbox-label i {
                color: #2c5aa0;
                transform: scale(1.1);
            }
            
            .action-btn {
                transition: all 0.2s ease;
            }
            
            .action-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            }
            
            .type-badge i,
            .status-badge i {
                font-size: 0.75rem;
            }
            
            .machine-code {
                transition: all 0.2s ease;
            }
            
            .machine-code:hover {
                background: #2c5aa0;
                color: white;
                transform: scale(1.05);
            }
            
            @media print {
                .loading-spinner {
                    display: none !important;
                }
            }
        </style>
    `;
    
    $('head').append(customStyles);
});

