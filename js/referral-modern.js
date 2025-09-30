/**
 * Internal Referral List Modern JavaScript
 * Handles modern interactions and functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize modern functionality
    initializeSidebar();
    initializeFormValidation();
    initializeTableInteractions();
    initializeResponsiveFeatures();
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
    const form = document.querySelector('.search-form');
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
    const table = document.querySelector('.referral-table');
    
    if (table) {
        // Add hover effects to rows
        const rows = table.querySelectorAll('.referral-row');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
        
        // Add click-to-highlight functionality
        rows.forEach(row => {
            row.addEventListener('click', function() {
                // Remove previous selection
                rows.forEach(r => r.classList.remove('selected'));
                // Add selection to current row
                this.classList.add('selected');
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
    const dateFrom = document.getElementById('ADate1')?.value;
    const dateTo = document.getElementById('ADate2')?.value;
    
    if (!dateFrom || !dateTo) {
        showAlert('Please select date range before exporting', 'error');
        return;
    }
    
    // Show loading state
    showAlert('Preparing export...', 'info');
    
    // Open export URL in new window
    const exportUrl = `print_internalreferallist.php?cbfrmflag1=cbfrmflag1&&ADate1=${dateFrom}&&ADate2=${dateTo}`;
    window.open(exportUrl, '_blank');
    
    // Show success message after a delay
    setTimeout(() => {
        showAlert('Export completed successfully!', 'success');
    }, 2000);
}

/**
 * Format date for display
 */
function formatDate(dateString) {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Search functionality
 */
function performSearch() {
    const form = document.querySelector('.search-form');
    if (form) {
        // Add loading state
        const submitBtn = form.querySelector('.submit-btn');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            submitBtn.disabled = true;
            
            // Reset after form submission
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        }
        
        form.submit();
    }
}

/**
 * Reset form
 */
function resetForm() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        
        // Reset to default dates
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (dateFrom && dateTo) {
            const today = new Date();
            const oneMonthAgo = new Date();
            oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
            
            dateFrom.value = oneMonthAgo.toISOString().split('T')[0];
            dateTo.value = today.toISOString().split('T')[0];
        }
        
        showAlert('Form reset successfully', 'info');
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
    
    // Ctrl/Cmd + E: Export
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }
    
    // Ctrl/Cmd + /: Toggle sidebar
    if ((e.ctrlKey || e.metaKey) && e.key === '/') {
        e.preventDefault();
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            sidebar.classList.toggle('open');
        }
    }
});

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Custom tooltip implementation if needed
        });
    });
}

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
    });
}

// Initialize performance monitoring
initializePerformanceMonitoring();




