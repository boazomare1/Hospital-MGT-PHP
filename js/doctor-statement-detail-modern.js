/**
 * Doctor Statement Detail - Modern JavaScript
 * Enhanced functionality for doctor statement detail page
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
    
    // Initialize export functionality
    initializeExportFeatures();
    
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
    const searchForm = document.querySelector('form[name="cbform1"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
                return false;
            }
            showLoadingOverlay('Searching Doctor Statements...');
        });
    }
    
    // Form reset functionality
    const resetButton = document.getElementById('resetbutton');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            resetSearchForm();
        });
    }
    
    // Auto-format date inputs
    initializeDateInputs();
    
    // Enhanced autocomplete
    initializeAutocompleteEnhancements();
}

function validateSearchForm() {
    const doctorInput = document.getElementById('searchsuppliername');
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    let isValid = true;
    let errorMessage = '';
    
    // Clear previous errors
    clearFormErrors();
    
    // Validate doctor selection
    if (!doctorInput || doctorInput.value.trim() === '') {
        showFormError(doctorInput, 'Please select a doctor');
        isValid = false;
    }
    
    // Validate date range
    if (dateFromInput && dateToInput) {
        const dateFrom = new Date(dateFromInput.value);
        const dateTo = new Date(dateToInput.value);
        
        if (dateFrom > dateTo) {
            showFormError(dateToInput, 'End date must be after start date');
            isValid = false;
        }
        
        // Check if date range is too large (more than 1 year)
        const daysDiff = Math.ceil((dateTo - dateFrom) / (1000 * 60 * 60 * 24));
        if (daysDiff > 365) {
            showFormError(dateToInput, 'Date range cannot exceed 1 year');
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert('Please correct the form errors before proceeding.', 'error');
    }
    
    return isValid;
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

function resetSearchForm() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.reset();
        clearFormErrors();
        
        // Reset to default dates
        const today = new Date();
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(today.getMonth() - 1);
        
        const dateFromInput = document.getElementById('ADate1');
        const dateToInput = document.getElementById('ADate2');
        
        if (dateFromInput) {
            dateFromInput.value = formatDate(oneMonthAgo);
        }
        if (dateToInput) {
            dateToInput.value = formatDate(today);
        }
        
        showAlert('Form has been reset', 'info');
    }
}

function initializeDateInputs() {
    const dateInputs = document.querySelectorAll('input[type="text"][readonly]');
    dateInputs.forEach(input => {
        if (input.id.includes('Date')) {
            // Add date picker enhancement
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--medstar-primary)';
            });
            
            input.addEventListener('blur', function() {
                this.style.borderColor = 'var(--border-color)';
            });
        }
    });
}

function initializeAutocompleteEnhancements() {
    const doctorInput = document.getElementById('searchsuppliername');
    if (doctorInput) {
        // Add loading state for autocomplete
        doctorInput.addEventListener('input', function() {
            if (this.value.length > 2) {
                this.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23666\' stroke-width=\'2\'%3E%3Ccircle cx=\'12\' cy=\'12\' r=\'10\'/%3E%3Cpath d=\'M12 6v6l4 2\'/%3E%3C/svg%3E")';
                this.style.backgroundRepeat = 'no-repeat';
                this.style.backgroundPosition = 'right 0.5rem center';
                this.style.backgroundSize = '1rem';
            } else {
                this.style.backgroundImage = 'none';
            }
        });
    }
}

/**
 * Table Enhancements
 */
function initializeTableEnhancements() {
    const table = document.querySelector('.modern-table');
    if (!table) return;
    
    // Add sorting functionality
    initializeTableSorting(table);
    
    // Add row highlighting
    initializeRowHighlighting(table);
    
    // Add responsive table wrapper
    wrapTableForResponsiveness(table);
    
    // Add aging analysis highlighting
    initializeAgingAnalysis(table);
}

function initializeTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Skip non-sortable columns
        if (header.textContent.includes('No.') || 
            header.textContent.includes('Doctor') || 
            header.textContent.includes('Patient')) {
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

function initializeAgingAnalysis(table) {
    const agingColumns = [13, 14, 15, 16, 17, 18]; // Column indices for aging periods
    
    agingColumns.forEach(columnIndex => {
        const cells = table.querySelectorAll(`tbody tr td:nth-child(${columnIndex + 1})`);
        cells.forEach(cell => {
            const value = parseFloat(cell.textContent.replace(/[^\d.-]/g, ''));
            if (!isNaN(value) && value > 0) {
                // Add aging class based on column
                const columnHeader = table.querySelector(`th:nth-child(${columnIndex + 1})`);
                if (columnHeader) {
                    const headerText = columnHeader.textContent.toLowerCase();
                    if (headerText.includes('30')) {
                        cell.classList.add('aging-30');
                    } else if (headerText.includes('60')) {
                        cell.classList.add('aging-60');
                    } else if (headerText.includes('90')) {
                        cell.classList.add('aging-90');
                    } else if (headerText.includes('120')) {
                        cell.classList.add('aging-120');
                    } else if (headerText.includes('180') && !headerText.includes('+')) {
                        cell.classList.add('aging-180');
                    } else if (headerText.includes('180+')) {
                        cell.classList.add('aging-180-plus');
                    }
                }
            }
        });
    });
}

/**
 * Export Functionality
 */
function initializeExportFeatures() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            exportToExcel();
        });
    }
}

function exportToExcel() {
    showLoadingOverlay('Preparing Excel Export...');
    
    // Simulate export process
    setTimeout(() => {
        hideLoadingOverlay();
        showAlert('Excel export has been initiated. The file will download shortly.', 'success');
        
        // Trigger actual export
        const exportUrl = document.querySelector('.export-btn')?.href;
        if (exportUrl) {
            window.open(exportUrl, '_blank');
        }
    }, 1500);
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
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
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
window.resetSearchForm = resetSearchForm;





