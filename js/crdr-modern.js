/**
 * Credit/Debit Adjustment Modern JavaScript
 * Handles modern interactions and functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize modern functionality
    initializeSidebar();
    initializeFormValidation();
    initializeTableInteractions();
    initializeResponsiveFeatures();
    initializeAutocomplete();
});

/**
 * Initialize sidebar functionality
 */
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const floatingToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        });
    }
    
    if (floatingToggle && sidebar) {
        floatingToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !floatingToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const form = document.querySelector('.adjustment-form');
    const dateFromInput = document.getElementById('ADate1');
    const dateToInput = document.getElementById('ADate2');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateDateRange()) {
                e.preventDefault();
                showAlert('Please ensure "Date From" is before "Date To"', 'error');
            }
        });
    }
    
    // Real-time date validation
    if (dateFromInput && dateToInput) {
        [dateFromInput, dateToInput].forEach(input => {
            input.addEventListener('change', validateDateRange);
        });
    }
}

/**
 * Validate date range
 */
function validateDateRange() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
        const fromDate = new Date(dateFrom.value);
        const toDate = new Date(dateTo.value);
        
        if (fromDate > toDate) {
            showAlert('Date From must be before Date To', 'error');
            return false;
        }
    }
    return true;
}

/**
 * Initialize table interactions
 */
function initializeTableInteractions() {
    const table = document.querySelector('.adjustment-table');
    
    if (table) {
        // Add hover effects to rows
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
    
    // Initialize check all functionality
    const checkAll = document.getElementById('checkall');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.chkalloc');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                if (this.checked) {
                    triggerCheckboxChange(checkbox);
                }
            });
        });
    }
}

/**
 * Initialize responsive features
 */
function initializeResponsiveFeatures() {
    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('leftSidebar');
        const floatingToggle = document.getElementById('menuToggle');
        
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            if (floatingToggle) {
                floatingToggle.style.display = 'none';
            }
        } else {
            if (floatingToggle) {
                floatingToggle.style.display = 'block';
            }
        }
    });
    
    // Initialize on load
    window.dispatchEvent(new Event('resize'));
}

/**
 * Initialize autocomplete functionality
 */
function initializeAutocomplete() {
    // Enhanced autocomplete for subtype search
    const subtypeInput = document.getElementById('searchsuppliername');
    if (subtypeInput) {
        subtypeInput.addEventListener('input', function() {
            // Trigger existing autocomplete functionality
            if (typeof $ !== 'undefined' && $.fn.autocomplete) {
                // jQuery autocomplete is already initialized
            }
        });
    }
    
    // Enhanced autocomplete for account search
    const accountInput = document.getElementById('searchaccountname');
    if (accountInput) {
        accountInput.addEventListener('input', function() {
            // Trigger existing autocomplete functionality
            if (typeof $ !== 'undefined' && $.fn.autocomplete) {
                // jQuery autocomplete is already initialized
            }
        });
    }
}

/**
 * Show alert message
 */
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    
    if (alertContainer) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        
        const iconClass = type === 'success' ? 'check-circle' : 
                         type === 'error' ? 'exclamation-triangle' : 'info-circle';
        
        alertDiv.innerHTML = `
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        `;
        
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertDiv);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
}

/**
 * Refresh the page
 */
function refreshPage() {
    // Show loading state
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('loading');
    }
    
    // Reload page
    window.location.reload();
}

/**
 * Export to Excel functionality
 */
function exportToExcel() {
    showAlert('Export functionality will be available after data is loaded', 'info');
}

/**
 * Format currency for display
 */
function formatCurrency(amount) {
    if (!amount || amount === '') return '0.00';
    
    const numAmount = parseFloat(amount.toString().replace(/,/g, ''));
    return numAmount.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

/**
 * Calculate totals
 */
function calculateTotals() {
    const totalPending = document.getElementById('totalPending');
    const totalBalance = document.getElementById('totalBalance');
    const totalAdjAmt = document.getElementById('totaladjamt');
    
    let pendingTotal = 0;
    let balanceTotal = 0;
    let adjTotal = 0;
    
    // Calculate from table rows
    const rows = document.querySelectorAll('#rowinsert tr');
    rows.forEach(row => {
        const pendingCell = row.querySelector('.pending-amount');
        const balanceCell = row.querySelector('.balance-amount');
        const adjCell = row.querySelector('.adj-amount');
        
        if (pendingCell) {
            pendingTotal += parseFloat(pendingCell.textContent.replace(/,/g, '') || 0);
        }
        
        if (balanceCell) {
            balanceTotal += parseFloat(balanceCell.textContent.replace(/,/g, '') || 0);
        }
        
        if (adjCell) {
            adjTotal += parseFloat(adjCell.value.replace(/,/g, '') || 0);
        }
    });
    
    // Update totals
    if (totalPending) totalPending.textContent = formatCurrency(pendingTotal);
    if (totalBalance) totalBalance.textContent = formatCurrency(balanceTotal);
    if (totalAdjAmt) totalAdjAmt.value = formatCurrency(adjTotal);
}

/**
 * Trigger checkbox change event
 */
function triggerCheckboxChange(checkbox) {
    const event = new Event('change', { bubbles: true });
    checkbox.dispatchEvent(event);
}

/**
 * Enhanced validation for adjustment form
 */
function validateAdjustmentForm() {
    const subtypeAnum = document.getElementById('searchsupplieranum').value;
    const accountCode = document.getElementById('searchaccountcode').value;
    const totalAdjAmt = document.getElementById('totaladjamt').value;
    
    if (!subtypeAnum) {
        showAlert('Please select a subtype!', 'error');
        return false;
    }
    
    if (!accountCode) {
        showAlert('Please select a target account!', 'error');
        return false;
    }
    
    if (!totalAdjAmt || parseFloat(totalAdjAmt.replace(/,/g, '')) <= 0) {
        showAlert('Please select at least one invoice for adjustment!', 'error');
        return false;
    }
    
    return true;
}

/**
 * Enhanced search functionality
 */
function performSearch() {
    if (!validateAdjustmentForm()) {
        return false;
    }
    
    // Show loading state
    showLoadingOverlay();
    
    // Trigger existing search functionality
    const searchBtn = document.getElementById('searchbillno');
    if (searchBtn) {
        searchBtn.click();
    }
    
    return true;
}

/**
 * Show loading overlay
 */
function showLoadingOverlay() {
    const overlay = document.getElementById('imgloader');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

/**
 * Hide loading overlay
 */
function hideLoadingOverlay() {
    const overlay = document.getElementById('imgloader');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

/**
 * Enhanced checkbox functionality
 */
function updateCheckboxBehavior() {
    // Override existing checkbox functions with enhanced versions
    window.updatebox = function(varSerialNumber, billamt, totalcount1) {
        // Enhanced checkbox update logic
        const checkbox = document.getElementById(`acknowpending${varSerialNumber}`);
        const adjAmount = document.getElementById(`adjamount${varSerialNumber}`);
        const balanceAmount = document.getElementById(`balamount${varSerialNumber}`);
        
        if (checkbox && checkbox.checked) {
            adjAmount.value = formatCurrency(billamt);
            balanceAmount.value = '0.00';
        } else {
            adjAmount.value = '0.00';
            balanceAmount.value = formatCurrency(billamt);
        }
        
        calculateTotals();
    };
}

/**
 * Enhanced total amount validation
 */
function validateTotalAmount() {
    const totalAdjAmt = document.getElementById('totaladjamt');
    const receivableAmount = document.getElementById('receivableamount');
    
    if (totalAdjAmt && receivableAmount) {
        const adjAmount = parseFloat(totalAdjAmt.value.replace(/,/g, '') || 0);
        const receivable = parseFloat(receivableAmount.value.replace(/,/g, '') || 0);
        
        if (adjAmount > receivable) {
            showAlert('Allocated amount cannot exceed receivable amount', 'error');
            return false;
        }
    }
    
    return true;
}

/**
 * Enhanced form submission
 */
function enhancedFormSubmission() {
    if (!validateAdjustmentForm()) {
        return false;
    }
    
    if (!validateTotalAmount()) {
        return false;
    }
    
    const confirmed = confirm('Are you sure you want to process this adjustment?');
    if (!confirmed) {
        return false;
    }
    
    showLoadingOverlay();
    return true;
}

/**
 * Initialize enhanced functionality
 */
function initializeEnhancedFeatures() {
    // Override existing functions with enhanced versions
    updateCheckboxBehavior();
    
    // Add enhanced form submission
    const submitBtn = document.getElementById('submit1');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            if (!enhancedFormSubmission()) {
                e.preventDefault();
                hideLoadingOverlay();
            }
        });
    }
    
    // Add enhanced search functionality
    const searchBtn = document.getElementById('searchbillno');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            if (!performSearch()) {
                e.preventDefault();
                hideLoadingOverlay();
            }
        });
    }
}

/**
 * Keyboard shortcuts
 */
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R: Refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    // Ctrl/Cmd + S: Search
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        performSearch();
    }
    
    // Ctrl/Cmd + /: Toggle sidebar
    if ((e.ctrlKey || e.metaKey) && e.key === '/') {
        e.preventDefault();
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            sidebar.classList.toggle('open');
        }
    }
    
    // Enter key on form inputs
    if (e.key === 'Enter' && e.target.classList.contains('form-input')) {
        const form = e.target.closest('form');
        if (form) {
            const submitBtn = form.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.click();
            }
        }
    }
});

/**
 * Performance monitoring
 */
function initializePerformanceMonitoring() {
    // Monitor page load time
    window.addEventListener('load', function() {
        const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
        console.log(`Page loaded in ${loadTime}ms`);
        
        // Show performance warning for slow loads
        if (loadTime > 3000) {
            showAlert('Page loading is slower than usual. Please check your connection.', 'info');
        }
        
        // Hide loading overlay after page load
        hideLoadingOverlay();
    });
}

/**
 * Initialize all enhanced features
 */
function initializeAllFeatures() {
    initializeEnhancedFeatures();
    initializePerformanceMonitoring();
    
    // Recalculate totals when page loads
    setTimeout(calculateTotals, 1000);
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeAllFeatures();
});

// Legacy function compatibility
window.FuncPopup = function() {
    showLoadingOverlay();
};

window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;




