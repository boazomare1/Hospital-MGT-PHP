/* Pharmacy Item Master Modern JavaScript */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeFormValidation();
    initializeTableSorting();
    initializeSearch();
    initializeAlerts();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = menuToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-bars';
            } else {
                icon.className = 'fas fa-times';
            }
        });
    }
    
    if (sidebarToggle && leftSidebar) {
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
}

// Form validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    // Validate item code format
    const itemCodeField = form.querySelector('#itemcode');
    if (itemCodeField && itemCodeField.value.trim()) {
        const itemCode = itemCodeField.value.trim();
        if (!/^[A-Z0-9]+$/.test(itemCode)) {
            showFieldError(itemCodeField, 'Item code should contain only uppercase letters and numbers');
            isValid = false;
        }
    }
    
    // Validate numeric fields
    const numericFields = form.querySelectorAll('input[name="rateperunit2"], input[name="costprice"], input[name="minimumstock"], input[name="maximumstock"], input[name="rol"], input[name="roq"], input[name="ipmarkup"], input[name="spmarkup"]');
    
    numericFields.forEach(field => {
        if (field.value.trim() && isNaN(parseFloat(field.value))) {
            showFieldError(field, 'Please enter a valid number');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Table sorting functionality
function initializeTableSorting() {
    const sortableHeaders = document.querySelectorAll('.sortable-header');
    
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const column = this.id;
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Determine sort direction
            const isAscending = this.classList.contains('sort-asc');
            
            // Clear all sort classes
            sortableHeaders.forEach(h => {
                h.classList.remove('sort-asc', 'sort-desc');
                const arrows = h.querySelectorAll('.sort-arrows i');
                arrows.forEach(arrow => arrow.classList.remove('active'));
            });
            
            // Set new sort class
            if (isAscending) {
                this.classList.add('sort-desc');
                this.querySelector('.sort-arrows .fa-sort-up').classList.add('active');
            } else {
                this.classList.add('sort-asc');
                this.querySelector('.sort-arrows .fa-sort-down').classList.add('active');
            }
            
            // Sort rows
            rows.sort((a, b) => {
                const aVal = getCellValue(a, column);
                const bVal = getCellValue(b, column);
                
                // Handle numeric values
                if (!isNaN(aVal) && !isNaN(bVal)) {
                    return isAscending ? bVal - aVal : aVal - bVal;
                }
                
                // Handle text values
                const comparison = aVal.toString().localeCompare(bVal.toString());
                return isAscending ? -comparison : comparison;
            });
            
            // Reorder rows in table
            rows.forEach(row => tbody.appendChild(row));
            
            // Update hidden sort field if exists
            const sortField = document.getElementById('sortfunc');
            if (sortField) {
                sortField.value = column + (isAscending ? '_desc' : '_asc');
            }
        });
    });
}

function getCellValue(row, column) {
    const cellIndex = getColumnIndex(column);
    if (cellIndex === -1) return '';
    
    const cell = row.children[cellIndex];
    if (!cell) return '';
    
    const text = cell.textContent.trim();
    
    // Try to parse as number
    const num = parseFloat(text);
    return isNaN(num) ? text : num;
}

function getColumnIndex(column) {
    const headers = {
        'category': 3,
        'pharmacyitem': 4,
        'generic': 11,
        'phtype': 12
    };
    
    return headers[column] || -1;
}

// Search functionality
function initializeSearch() {
    const searchInputs = document.querySelectorAll('input[type="text"]');
    
    searchInputs.forEach(input => {
        // Add debounced search
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                performSearch();
            }, 500);
        });
    });
}

function performSearch() {
    // This would typically make an AJAX request to search
    // For now, we'll just show a loading state
    const loadingOverlay = document.getElementById('wait');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
        
        // Simulate search delay
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
        }, 1000);
    }
}

// Alert management
function initializeAlerts() {
    // Auto-hide success alerts after 5 seconds
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Show loading state
    const loadingOverlay = document.getElementById('wait');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    // Create a form to submit export request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'pharmacyitem1.php';
    
    const exportInput = document.createElement('input');
    exportInput.type = 'hidden';
    exportInput.name = 'export';
    exportInput.value = 'excel';
    form.appendChild(exportInput);
    
    // Add current search parameters
    const currentParams = new URLSearchParams(window.location.search);
    for (const [key, value] of currentParams) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    // Hide loading state after a delay
    setTimeout(() => {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }, 2000);
}

// Form helper functions
function additem1process1() {
    const form = document.getElementById('form1');
    if (!form) return true;
    
    // Validate required fields
    const requiredFields = ['categoryname', 'itemname', 'itemcode'];
    
    for (const fieldName of requiredFields) {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field && !field.value.trim()) {
            alert(`Please fill in the ${fieldName.replace('name', '')} field.`);
            field.focus();
            return false;
        }
    }
    
    // Validate item code format
    const itemCodeField = form.querySelector('#itemcode');
    if (itemCodeField && itemCodeField.value.trim()) {
        const itemCode = itemCodeField.value.trim();
        if (!/^[A-Z0-9]+$/.test(itemCode)) {
            alert('Item code should contain only uppercase letters and numbers.');
            itemCodeField.focus();
            return false;
        }
    }
    
    // Show loading state
    const loadingOverlay = document.getElementById('wait');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    return true;
}

function process1backkeypress1() {
    // Allow backspace and delete keys
    return true;
}

function spl() {
    // Allow special characters for item names
    return true;
}

function fixed2() {
    // Handle formula change
    const formulaSelect = document.getElementById('formula');
    if (formulaSelect) {
        const selectedValue = formulaSelect.value;
        // Add any specific logic for formula changes
        console.log('Formula changed to:', selectedValue);
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + S to save form
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        const form = document.querySelector('form');
        if (form) {
            form.submit();
        }
    }
    
    // Escape to close sidebar
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && !sidebar.classList.contains('collapsed')) {
            sidebar.classList.add('collapsed');
        }
    }
});

// Responsive table handling
function handleResponsiveTable() {
    const table = document.querySelector('.pharmacy-table');
    if (!table) return;
    
    const container = table.closest('.table-container');
    if (!container) return;
    
    // Add horizontal scroll indicator if needed
    if (table.scrollWidth > container.clientWidth) {
        container.classList.add('has-horizontal-scroll');
    }
}

// Initialize responsive table on load and resize
window.addEventListener('load', handleResponsiveTable);
window.addEventListener('resize', handleResponsiveTable);

// Auto-save form data to localStorage
function initializeAutoSave() {
    const form = document.getElementById('form1');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`pharmacy_form_${input.name}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }
        
        // Save data on change
        input.addEventListener('input', function() {
            localStorage.setItem(`pharmacy_form_${input.name}`, input.value);
        });
    });
    
    // Clear saved data on successful form submission
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem(`pharmacy_form_${input.name}`);
        });
    });
}

// Initialize auto-save
document.addEventListener('DOMContentLoaded', initializeAutoSave);

// Enhanced error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    
    // Show user-friendly error message
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-error';
        errorAlert.innerHTML = `
            <i class="fas fa-exclamation-triangle alert-icon"></i>
            <span>An error occurred. Please refresh the page and try again.</span>
        `;
        alertContainer.appendChild(errorAlert);
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            errorAlert.remove();
        }, 10000);
    }
});

// Performance monitoring
function initializePerformanceMonitoring() {
    // Monitor form submission performance
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const startTime = performance.now();
            
            // Monitor how long the form takes to submit
            const checkSubmission = setInterval(() => {
                if (document.readyState === 'complete') {
                    const endTime = performance.now();
                    const duration = endTime - startTime;
                    
                    if (duration > 5000) { // More than 5 seconds
                        console.warn('Form submission took longer than expected:', duration + 'ms');
                    }
                    
                    clearInterval(checkSubmission);
                }
            }, 100);
        });
    });
}

// Initialize performance monitoring
document.addEventListener('DOMContentLoaded', initializePerformanceMonitoring);

// Pagination functionality
function changeRecordsPerPage(limit) {
    const url = new URL(window.location);
    url.searchParams.set('limit', limit);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
}

// Deleted items pagination functionality
function changeDeletedRecordsPerPage(limit) {
    const url = new URL(window.location);
    url.searchParams.set('deleted_limit', limit);
    url.searchParams.set('deleted_page', '1'); // Reset to first page
    window.location.href = url.toString();
}

// Enhanced pagination with AJAX (optional)
function loadPage(page, limit = null) {
    const loadingOverlay = document.getElementById('wait');
    if (loadingOverlay) {
        loadingOverlay.style.display = 'flex';
    }
    
    const url = new URL(window.location);
    url.searchParams.set('page', page);
    if (limit) {
        url.searchParams.set('limit', limit);
    }
    
    // For now, just redirect to the new URL
    // In the future, this could be enhanced to load content via AJAX
    window.location.href = url.toString();
}

// Quick navigation to specific page
function goToPage(pageNumber) {
    const limit = document.getElementById('recordsPerPage')?.value || 10;
    loadPage(pageNumber, limit);
}

// Keyboard navigation for pagination
document.addEventListener('keydown', function(e) {
    // Only handle pagination shortcuts when not in form inputs
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') {
        return;
    }
    
    // Left arrow - previous page
    if (e.key === 'ArrowLeft') {
        const prevBtn = document.querySelector('.pagination-btn-prev');
        if (prevBtn && !prevBtn.classList.contains('pagination-btn-disabled')) {
            e.preventDefault();
            prevBtn.click();
        }
    }
    
    // Right arrow - next page
    if (e.key === 'ArrowRight') {
        const nextBtn = document.querySelector('.pagination-btn-next');
        if (nextBtn && !nextBtn.classList.contains('pagination-btn-disabled')) {
            e.preventDefault();
            nextBtn.click();
        }
    }
    
    // Home - first page
    if (e.key === 'Home' && e.ctrlKey) {
        e.preventDefault();
        const firstBtn = document.querySelector('.pagination-btn-first');
        if (firstBtn && !firstBtn.classList.contains('pagination-btn-disabled')) {
            firstBtn.click();
        }
    }
    
    // End - last page
    if (e.key === 'End' && e.ctrlKey) {
        e.preventDefault();
        const lastBtn = document.querySelector('.pagination-btn-last');
        if (lastBtn && !lastBtn.classList.contains('pagination-btn-disabled')) {
            lastBtn.click();
        }
    }
});

// Pagination statistics
function updatePaginationStats() {
    const paginationText = document.querySelector('.pagination-text');
    if (paginationText) {
        const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
        const limit = new URLSearchParams(window.location.search).get('limit') || 10;
        
        // This would need to be updated with actual total count from server
        console.log(`Current page: ${currentPage}, Records per page: ${limit}`);
    }
}

// Initialize pagination enhancements
function initializePagination() {
    // Add click handlers for pagination numbers
    const paginationNumbers = document.querySelectorAll('.pagination-number');
    paginationNumbers.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const pageNumber = this.textContent;
            goToPage(pageNumber);
        });
    });
    
    // Add keyboard shortcuts info
    const paginationControls = document.querySelector('.pagination-controls');
    if (paginationControls && !document.querySelector('.pagination-help')) {
        const helpDiv = document.createElement('div');
        helpDiv.className = 'pagination-help';
        helpDiv.innerHTML = `
            <small style="color: var(--text-secondary); font-size: 0.75rem;">
                <i class="fas fa-keyboard"></i> 
                Use ← → arrows for navigation, Ctrl+Home/End for first/last page
            </small>
        `;
        paginationControls.appendChild(helpDiv);
    }
}

// Initialize pagination when DOM is ready
document.addEventListener('DOMContentLoaded', initializePagination);

// Action button functions
function deleteItem(autoNumber) {
    if (confirm('Are you sure you want to delete this pharmacy item? This action cannot be undone.')) {
        // Show loading state
        const loadingOverlay = document.getElementById('wait');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
        
        // Redirect to delete action
        window.location.href = `pharmacyitem1.php?st=del&&anum=${autoNumber}`;
    }
}

function activateItem(autoNumber) {
    if (confirm('Are you sure you want to activate this deleted pharmacy item?')) {
        // Show loading state
        const loadingOverlay = document.getElementById('wait');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
        
        // Redirect to activate action
        window.location.href = `pharmacyitem1.php?st=activate&&anum=${autoNumber}`;
    }
}

// Enhanced table interactions
function initializeTableInteractions() {
    // Add row selection functionality
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't trigger row selection if clicking on action buttons
            if (e.target.closest('.btn-action')) {
                return;
            }
            
            // Toggle row selection
            this.classList.toggle('row-selected');
        });
    });
    
    // Add keyboard navigation for table rows
    tableRows.forEach((row, index) => {
        row.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            } else if (e.key === 'ArrowDown' && index < tableRows.length - 1) {
                e.preventDefault();
                tableRows[index + 1].focus();
            } else if (e.key === 'ArrowUp' && index > 0) {
                e.preventDefault();
                tableRows[index - 1].focus();
            }
        });
        
        // Make rows focusable
        row.setAttribute('tabindex', '0');
    });
}

// Initialize table interactions
document.addEventListener('DOMContentLoaded', initializeTableInteractions);
