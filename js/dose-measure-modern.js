/**
 * Dose Measure Master - Modern JavaScript
 * Enhanced functionality for dose measure management page
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeModernFeatures();
});

function initializeModernFeatures() {
    // Initialize sidebar toggle
    initializeSidebarToggle();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Initialize table enhancements
    initializeTableEnhancements();
    
    // Initialize responsive features
    initializeResponsiveFeatures();
    
    // Initialize loading states
    initializeLoadingStates();
}

/**
 * Sidebar Toggle Functionality
 */
function initializeSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateMenuToggleIcon();
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateMenuToggleIcon();
        });
    }
    
    // Auto-collapse sidebar on mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
}

function updateMenuToggleIcon() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const icon = menuToggle?.querySelector('i');
    
    if (icon && sidebar) {
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-bars';
        } else {
            icon.className = 'fas fa-times';
        }
    }
}

/**
 * Form Enhancements
 */
function initializeFormEnhancements() {
    // Form validation
    const addForm = document.querySelector('form[name="form1"]');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            if (!validateDoseMeasureForm()) {
                e.preventDefault();
                return false;
            }
            showLoadingOverlay('Adding Dose Measure...');
        });
    }
    
    // Auto-format input
    const doseInput = document.getElementById('drug_inst');
    if (doseInput) {
        doseInput.addEventListener('input', function() {
            formatDoseMeasureInput(this);
        });
        
        doseInput.addEventListener('blur', function() {
            validateDoseMeasureInput(this);
        });
    }
}

function validateDoseMeasureForm() {
    const doseInput = document.getElementById('drug_inst');
    
    // Clear previous errors
    clearFormErrors();
    
    if (!doseInput || doseInput.value.trim() === '') {
        showFormError(doseInput, 'Please enter a dose measure');
        return false;
    }
    
    if (doseInput.value.length > 100) {
        showFormError(doseInput, 'Dose measure cannot exceed 100 characters');
        return false;
    }
    
    // Check for special characters
    const specialChars = /[<>\"'&]/;
    if (specialChars.test(doseInput.value)) {
        showFormError(doseInput, 'Dose measure contains invalid characters');
        return false;
    }
    
    return true;
}

function formatDoseMeasureInput(input) {
    let value = input.value.trim();
    
    // Remove extra spaces
    value = value.replace(/\s+/g, ' ');
    
    // Capitalize first letter of each word
    value = value.toLowerCase().replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
    
    input.value = value;
}

function validateDoseMeasureInput(input) {
    const value = input.value.trim();
    
    if (value.length > 100) {
        showFormError(input, 'Dose measure cannot exceed 100 characters');
        return false;
    }
    
    return true;
}

function showFormError(input, message) {
    if (!input) return;
    
    // Add error class
    input.classList.add('error');
    
    // Create error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    // Insert error message
    input.parentNode.appendChild(errorDiv);
}

function clearFormErrors() {
    const errorInputs = document.querySelectorAll('.form-input.error');
    errorInputs.forEach(input => {
        input.classList.remove('error');
    });
    
    const errorMessages = document.querySelectorAll('.form-error');
    errorMessages.forEach(message => {
        message.remove();
    });
}

/**
 * Table Enhancements
 */
function initializeTableEnhancements() {
    const tables = document.querySelectorAll('.modern-table');
    tables.forEach(table => {
        // Add sorting functionality
        initializeTableSorting(table);
        
        // Add row highlighting
        initializeRowHighlighting(table);
        
        // Add responsive table wrapper
        wrapTableForResponsiveness(table);
    });
}

function initializeTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Skip action columns
        if (header.textContent.includes('Actions') || 
            header.textContent.includes('Edit') || 
            header.textContent.includes('Delete')) {
            return;
        }
        
        header.style.cursor = 'pointer';
        header.style.userSelect = 'none';
        header.innerHTML += ' <i class="fas fa-sort" style="opacity: 0.5; margin-left: 0.5rem;"></i>';
        
        header.addEventListener('click', function() {
            sortTable(table, index);
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Determine sort direction
    const isAscending = !table.dataset.sortDirection || table.dataset.sortDirection === 'desc';
    table.dataset.sortDirection = isAscending ? 'asc' : 'desc';
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex]?.textContent.trim() || '';
        const bValue = b.cells[columnIndex]?.textContent.trim() || '';
        
        // Handle numeric values
        const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Handle text values
        return isAscending ? 
            aValue.localeCompare(bValue) : 
            bValue.localeCompare(aValue);
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort indicators
    updateSortIndicators(table, columnIndex, isAscending);
}

function updateSortIndicators(table, columnIndex, isAscending) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        const icon = header.querySelector('i');
        if (index === columnIndex) {
            icon.className = isAscending ? 'fas fa-sort-up' : 'fas fa-sort-down';
            icon.style.opacity = '1';
        } else {
            icon.className = 'fas fa-sort';
            icon.style.opacity = '0.5';
        }
    });
}

function initializeRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
}

function wrapTableForResponsiveness(table) {
    if (table.parentNode.classList.contains('table-responsive')) return;
    
    const wrapper = document.createElement('div');
    wrapper.className = 'table-responsive';
    wrapper.style.overflowX = 'auto';
    wrapper.style.borderRadius = 'var(--border-radius)';
    wrapper.style.boxShadow = 'var(--shadow-light)';
    
    table.parentNode.insertBefore(wrapper, table);
    wrapper.appendChild(table);
}

/**
 * Action Button Enhancements
 */
function initializeActionButtons() {
    // Delete confirmation
    const deleteButtons = document.querySelectorAll('a[href*="st=del"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirmDelete()) {
                e.preventDefault();
                return false;
            }
            showLoadingOverlay('Deleting Dose Measure...');
        });
    });
    
    // Activate confirmation
    const activateButtons = document.querySelectorAll('a[href*="st=activate"]');
    activateButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirmActivate()) {
                e.preventDefault();
                return false;
            }
            showLoadingOverlay('Activating Dose Measure...');
        });
    });
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this dose measure? This action cannot be undone.');
}

function confirmActivate() {
    return confirm('Are you sure you want to activate this dose measure?');
}

/**
 * Responsive Features
 */
function initializeResponsiveFeatures() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResponsiveLayout();
    });
    
    // Initial responsive setup
    handleResponsiveLayout();
}

function handleResponsiveLayout() {
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    
    if (window.innerWidth <= 768) {
        // Mobile layout
        if (sidebar) {
            sidebar.classList.add('collapsed');
        }
        if (menuToggle) {
            menuToggle.style.display = 'flex';
        }
    } else {
        // Desktop layout
        if (sidebar) {
            sidebar.classList.remove('collapsed');
        }
        if (menuToggle) {
            menuToggle.style.display = 'none';
        }
    }
}

/**
 * Loading States
 */
function initializeLoadingStates() {
    // Add loading states to form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('input[type="submit"], button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
        });
    });
}

function showLoadingOverlay(message = 'Loading...') {
    // Remove existing overlay
    hideLoadingOverlay();
    
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.className = 'loading-overlay';
    
    overlay.innerHTML = `
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>${message}</strong></p>
            <p>Please wait...</p>
        </div>
    `;
    
    document.body.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

/**
 * Alert System
 */
function showAlert(message, type = 'info', duration = 5000) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const iconMap = {
        success: 'check-circle',
        error: 'exclamation-triangle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    alert.innerHTML = `
        <i class="fas fa-${iconMap[type] || 'info-circle'} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; font-size: 1.2rem;">&times;</button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after duration
    if (duration > 0) {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, duration);
    }
}

/**
 * Utility Functions
 */
function formatText(text) {
    return text.toLowerCase().replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}

function sanitizeInput(input) {
    return input.replace(/[<>\"'&]/g, '');
}

/**
 * Page Refresh Functionality
 */
function refreshPage() {
    showLoadingOverlay('Refreshing Page...');
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

/**
 * Print Functionality
 */
function printPage() {
    window.print();
}

/**
 * Export Functions (Global)
 */
window.refreshPage = refreshPage;
window.printPage = printPage;
window.showAlert = showAlert;
window.confirmDelete = confirmDelete;
window.confirmActivate = confirmActivate;






