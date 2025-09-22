// Modern Employee Access Details JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initSidebar();
    
    // Initialize form functionality
    initFormHandlers();
    
    // Initialize autocomplete
    initAutocomplete();
    
    // Initialize table functionality
    initTableFeatures();
});

// Sidebar functionality
function initSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Form handlers
function initFormHandlers() {
    // Employee search form validation
    const searchForm = document.getElementById('selectemployee');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateEmployeeSearch()) {
                e.preventDefault();
            }
        });
    }
    
    // Search input enhancements
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearSearchValidation();
        });
        
        // Add search icon
        const searchContainer = searchInput.parentNode;
        if (!searchContainer.querySelector('.search-icon-container')) {
            const iconContainer = document.createElement('div');
            iconContainer.className = 'search-icon-container';
            iconContainer.innerHTML = '<i class="fas fa-search"></i>';
            searchContainer.style.position = 'relative';
            iconContainer.style.position = 'absolute';
            iconContainer.style.right = '0.75rem';
            iconContainer.style.top = '50%';
            iconContainer.style.transform = 'translateY(-50%)';
            iconContainer.style.color = '#64748b';
            searchContainer.appendChild(iconContainer);
            
            searchInput.style.paddingRight = '2.5rem';
        }
    }
}

// Autocomplete functionality
function initAutocomplete() {
    // Enhanced autocomplete styling
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput && typeof $ !== 'undefined') {
        // Custom autocomplete styling
        $(document).ready(function() {
            $('#searchsuppliername').autocomplete({
                source: 'ajaxemployeenewsearch.php',
                minLength: 3,
                delay: 0,
                html: true,
                select: function(event, ui) {
                    var code = ui.item.id;
                    var employeecode = ui.item.employeecode;
                    var employeename = ui.item.employeename;
                    $('#searchemployeecode').val(employeecode);
                    $('#searchsuppliername').val(employeename);
                    
                    // Add visual feedback
                    showSearchFeedback('Employee selected: ' + employeename);
                },
                open: function() {
                    // Add custom styling to autocomplete dropdown
                    $('.ui-autocomplete').addClass('modern-autocomplete');
                }
            });
        });
    }
}

// Table functionality
function initTableFeatures() {
    // Add table enhancements
    const dataTable = document.querySelector('.data-table');
    if (dataTable) {
        // Add sorting functionality
        addTableSorting(dataTable);
        
        // Add row highlighting
        addRowHighlighting(dataTable);
        
        // Add responsive table wrapper
        wrapTableResponsive(dataTable);
    }
}

// Validation functions
function validateEmployeeSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    if (!searchInput || searchInput.value.trim() === '') {
        showAlert('Please enter an employee name to search.', 'error');
        searchInput.focus();
        return false;
    }
    return true;
}

function clearSearchValidation() {
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput) {
        searchInput.classList.remove('error');
        const errorElement = searchInput.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
    }
}

// Alert system
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertClass = type === 'error' ? 'alert-error' : (type === 'success' ? 'alert-success' : 'alert-info');
    const iconClass = type === 'error' ? 'exclamation-triangle' : (type === 'success' ? 'check-circle' : 'info-circle');
    
    const alertHtml = `
        <div class="alert ${alertClass}">
            <i class="fas fa-${iconClass} alert-icon"></i>
            <span>${message}</span>
        </div>
    `;
    
    alertContainer.innerHTML = alertHtml;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

// Search feedback
function showSearchFeedback(message) {
    showAlert(message, 'success');
}

// Utility functions
function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const exportUrl = document.querySelector('a[href*="print_employeeaccessdetails.php"]');
    if (exportUrl) {
        exportUrl.click();
    } else {
        showAlert('Export functionality not available.', 'error');
    }
}

function clearSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    const hiddenInput = document.getElementById('searchemployeecode');
    
    if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
    }
    
    if (hiddenInput) {
        hiddenInput.value = '';
    }
    
    showAlert('Search cleared.', 'info');
}

// Table enhancements
function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        if (index > 0) { // Skip S.No. column
            header.style.cursor = 'pointer';
            header.style.userSelect = 'none';
            header.innerHTML += ' <i class="fas fa-sort sort-icon"></i>';
            
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
        }
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers
        const aNum = parseFloat(aValue);
        const bNum = parseFloat(bValue);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        } else {
            return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
        }
    });
    
    // Clear tbody and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort direction
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    // Update sort icons
    const headers = table.querySelectorAll('th');
    headers.forEach(header => {
        const icon = header.querySelector('.sort-icon');
        if (icon) {
            icon.className = 'fas fa-sort sort-icon';
        }
    });
    
    const currentHeader = headers[columnIndex];
    const currentIcon = currentHeader.querySelector('.sort-icon');
    if (currentIcon) {
        currentIcon.className = `fas fa-sort-${isAscending ? 'up' : 'down'} sort-icon`;
    }
}

function addRowHighlighting(table) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8fafc';
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
        });
    });
}

function wrapTableResponsive(table) {
    if (!table.parentNode.classList.contains('table-container')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-container';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    }
}

// Legacy function compatibility
function funcEmployeeSelect1() {
    return validateEmployeeSearch();
}

function from1submit1() {
    return validateEmployeeSearch();
}

// Disable enter key function (legacy compatibility)
function disableEnterKey(e) {
    if (e.keyCode === 13) {
        e.preventDefault();
        return false;
    }
}

// Enhanced search functionality
function initEnhancedSearch() {
    const searchInput = document.getElementById('searchsuppliername');
    if (searchInput) {
        // Add search suggestions
        searchInput.addEventListener('focus', function() {
            showSearchSuggestions();
        });
        
        // Add keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('selectemployee').submit();
            }
        });
    }
}

function showSearchSuggestions() {
    // Placeholder for search suggestions
    console.log('Showing search suggestions');
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + F for search focus
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        const searchInput = document.getElementById('searchsuppliername');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Alt + R for refresh
    if (e.altKey && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
    
    // Alt + E for export
    if (e.altKey && e.key === 'e') {
        e.preventDefault();
        exportToExcel();
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const searchInput = document.getElementById('searchsuppliername');
        if (searchInput && document.activeElement === searchInput) {
            clearSearch();
        }
    }
});

// Print functionality
function printPage() {
    window.print();
}

// Responsive menu toggle
function toggleResponsiveMenu() {
    const sidebar = document.getElementById('leftSidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

// Initialize enhanced search
document.addEventListener('DOMContentLoaded', function() {
    initEnhancedSearch();
    
    // Add loading states
    addLoadingStates();
    
    // Initialize tooltips
    initTooltips();
});

function addLoadingStates() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
                submitBtn.disabled = true;
            }
        });
    });
}

function initTooltips() {
    // Add tooltips to action buttons
    const exportBtn = document.querySelector('a[href*="print_employeeaccessdetails.php"]');
    if (exportBtn) {
        exportBtn.title = 'Export to Excel';
    }
    
    const refreshBtn = document.querySelector('button[onclick="refreshPage()"]');
    if (refreshBtn) {
        refreshBtn.title = 'Refresh data (Alt+R)';
    }
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Employee Access Details System initialized');
    
    // Add success message if search was performed
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('frmflag') === 'frmflag') {
        showAlert('Search results displayed below.', 'info');
    }
});

