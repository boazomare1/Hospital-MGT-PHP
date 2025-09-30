/* IP Account Wise List Modern JavaScript */

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeModernFeatures();
    initializeSidebar();
    initializeFormValidation();
    initializeTableInteractions();
    initializeAjaxFunctions();
});

// Initialize all modern features
function initializeModernFeatures() {
    // Add fade-in animation to main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.classList.add('fade-in');
    }
    
    // Initialize tooltips for better UX
    initializeTooltips();
    
    // Add loading states to forms
    initializeLoadingStates();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
}

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            // Update toggle icon
            const icon = menuToggle.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-bars';
            } else {
                icon.className = 'fas fa-times';
            }
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.add('collapsed');
        }
    });
}

// Form validation and enhancement
function initializeFormValidation() {
    const searchForm = document.querySelector('.search-form');
    if (!searchForm) return;
    
    // Real-time validation
    const dateInputs = searchForm.querySelectorAll('input[type="text"]');
    dateInputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateDateInput(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
    
    // Form submission validation
    searchForm.addEventListener('submit', function(e) {
        if (!validateSearchForm()) {
            e.preventDefault();
        }
    });
    
    // Auto-submit on Enter key
    const locationSelect = document.getElementById('location');
    if (locationSelect) {
        locationSelect.addEventListener('change', function() {
            // Auto-submit when location changes
            setTimeout(() => {
                if (validateSearchForm()) {
                    searchForm.submit();
                }
            }, 500);
        });
    }
}

// Validate individual date input
function validateDateInput(input) {
    const value = input.value.trim();
    const datePattern = /^\d{4}-\d{2}-\d{2}$/;
    
    if (value && !datePattern.test(value)) {
        showFieldError(input, 'Please enter a valid date (YYYY-MM-DD)');
        return false;
    }
    
    clearFieldError(input);
    return true;
}

// Validate search form
function validateSearchForm() {
    const fromDate = document.getElementById('ADate1');
    const toDate = document.getElementById('ADate2');
    const location = document.getElementById('location');
    
    let isValid = true;
    
    // Validate dates
    if (fromDate && !validateDateInput(fromDate)) {
        isValid = false;
    }
    
    if (toDate && !validateDateInput(toDate)) {
        isValid = false;
    }
    
    // Validate date range
    if (fromDate && toDate && fromDate.value && toDate.value) {
        const fromDateObj = new Date(fromDate.value);
        const toDateObj = new Date(toDate.value);
        
        if (fromDateObj > toDateObj) {
            showFieldError(toDate, 'End date must be after start date');
            isValid = false;
        }
    }
    
    // Validate location
    if (location && !location.value) {
        showFieldError(location, 'Please select a location');
        isValid = false;
    }
    
    return isValid;
}

// Show field error
function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('error');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Table interactions
function initializeTableInteractions() {
    const tableRows = document.querySelectorAll('.ipaccount-table tbody tr');
    
    tableRows.forEach(row => {
        // Add click handler for row selection
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on a link or button
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON') {
                return;
            }
            
            // Toggle row selection
            this.classList.toggle('selected');
            
            // Update selection count
            updateSelectionCount();
        });
        
        // Add hover effect
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') {
            return;
        }
        
        const selectedRow = document.querySelector('.ipaccount-table tbody tr.selected');
        if (!selectedRow) return;
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                const nextRow = selectedRow.nextElementSibling;
                if (nextRow) {
                    selectedRow.classList.remove('selected');
                    nextRow.classList.add('selected');
                    nextRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                const prevRow = selectedRow.previousElementSibling;
                if (prevRow) {
                    selectedRow.classList.remove('selected');
                    prevRow.classList.add('selected');
                    prevRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
                break;
        }
    });
}

// Update selection count
function updateSelectionCount() {
    const selectedRows = document.querySelectorAll('.ipaccount-table tbody tr.selected');
    const count = selectedRows.length;
    
    // You can add a selection counter display here if needed
    console.log(`${count} rows selected`);
}

// Initialize AJAX functions
function initializeAjaxFunctions() {
    // Enhanced location AJAX function
    window.ajaxlocationfunction = function(val) {
        if (!val) return;
        
        const ajaxLocation = document.getElementById('ajaxlocation');
        if (!ajaxLocation) return;
        
        // Show loading state
        ajaxLocation.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        // Create XMLHttpRequest
        let xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                ajaxLocation.innerHTML = xmlhttp.responseText;
                
                // Add success animation
                ajaxLocation.classList.add('fade-in');
                setTimeout(() => {
                    ajaxLocation.classList.remove('fade-in');
                }, 300);
            } else if (xmlhttp.readyState === 4) {
                ajaxLocation.innerHTML = '<span style="color: #dc2626;">Error loading location</span>';
            }
        };
        
        xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
        xmlhttp.send();
    };
}

// Initialize tooltips
function initializeTooltips() {
    const elementsWithTooltips = document.querySelectorAll('[title]');
    
    elementsWithTooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            showTooltip(this);
        });
        
        element.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });
}

// Show tooltip
function showTooltip(element) {
    const tooltip = document.createElement('div');
    tooltip.className = 'modern-tooltip';
    tooltip.textContent = element.title;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
    
    // Remove original title to prevent default tooltip
    element.setAttribute('data-original-title', element.title);
    element.removeAttribute('title');
}

// Hide tooltip
function hideTooltip() {
    const tooltip = document.querySelector('.modern-tooltip');
    if (tooltip) {
        // Restore original title
        const element = document.querySelector('[data-original-title]');
        if (element) {
            element.title = element.getAttribute('data-original-title');
            element.removeAttribute('data-original-title');
        }
        
        tooltip.remove();
    }
}

// Initialize loading states
function initializeLoadingStates() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            showLoadingOverlay();
        });
    });
}

// Show loading overlay
function showLoadingOverlay() {
    const overlay = document.getElementById('imgloader');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

// Hide loading overlay
function hideLoadingOverlay() {
    const overlay = document.getElementById('imgloader');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Initialize keyboard shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Only handle shortcuts when not in form inputs
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') {
            return;
        }
        
        // Ctrl/Cmd + S - Search
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.submit();
            }
        }
        
        // Ctrl/Cmd + R - Refresh
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            refreshPage();
        }
        
        // Escape - Clear selections
        if (e.key === 'Escape') {
            const selectedRows = document.querySelectorAll('.ipaccount-table tbody tr.selected');
            selectedRows.forEach(row => {
                row.classList.remove('selected');
            });
        }
    });
}

// Utility functions
function refreshPage() {
    showLoadingOverlay();
    window.location.reload();
}

function exportToExcel() {
    // Create a simple CSV export
    const table = document.querySelector('.ipaccount-table');
    if (!table) {
        alert('No data to export');
        return;
    }
    
    let csv = '';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => {
            return '"' + cell.textContent.replace(/"/g, '""') + '"';
        });
        csv += rowData.join(',') + '\n';
    });
    
    // Download CSV
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'ip_account_list_' + new Date().toISOString().split('T')[0] + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Enhanced form reset
function resetForm() {
    const form = document.querySelector('.search-form');
    if (form) {
        form.reset();
        
        // Clear any validation errors
        const errorFields = form.querySelectorAll('.error');
        errorFields.forEach(field => {
            clearFieldError(field);
        });
        
        // Reset location display
        const ajaxLocation = document.getElementById('ajaxlocation');
        if (ajaxLocation) {
            // You might want to reset this to default location
            ajaxLocation.textContent = 'Select Location';
        }
        
        // Clear table results
        const resultsSection = document.querySelector('.results-section');
        if (resultsSection) {
            resultsSection.style.display = 'none';
        }
    }
}

// Performance monitoring
function initializePerformanceMonitoring() {
    // Monitor page load time
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`Page loaded in ${loadTime.toFixed(2)}ms`);
        
        // Hide loading overlay after page load
        hideLoadingOverlay();
    });
    
    // Monitor form submission time
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const startTime = performance.now();
            
            // This will be called after the form submission completes
            setTimeout(() => {
                const endTime = performance.now();
                console.log(`Form submitted in ${(endTime - startTime).toFixed(2)}ms`);
            }, 100);
        });
    });
}

// Initialize performance monitoring
document.addEventListener('DOMContentLoaded', initializePerformanceMonitoring);

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
    
    // You could send this to a logging service
    // logError(e.error);
});

// Add CSS for modern tooltip
const tooltipCSS = `
.modern-tooltip {
    position: absolute;
    background: #1f2937;
    color: white;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    font-size: 0.8rem;
    z-index: 10000;
    pointer-events: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modern-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 4px solid transparent;
    border-top-color: #1f2937;
}

.ipaccount-table tbody tr.selected {
    background: rgba(30, 64, 175, 0.1) !important;
    border-left: 4px solid var(--medstar-primary);
}

.form-input.error,
.form-select.error {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.field-error {
    color: #dc2626;
    font-size: 0.8rem;
    margin-top: 0.25rem;
    font-weight: 500;
}
`;

// Inject CSS
const style = document.createElement('style');
style.textContent = tooltipCSS;
document.head.appendChild(style);


