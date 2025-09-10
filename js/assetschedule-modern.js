// Asset Schedule Modern JavaScript
// Handles sidebar, form validation, table enhancements, and responsive functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeTableEnhancements();
    initializeSearchFunctionality();
    initializeResponsiveDesign();
    initializeTouchSupport();
});

// Sidebar Management
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            updateSidebarToggleIcon();
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

function updateSidebarToggleIcon() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (sidebarToggle) {
        const icon = sidebarToggle.querySelector('i');
        if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-chevron-right';
        } else {
            icon.className = 'fas fa-chevron-left';
        }
    }
}

// Menu Toggle for Mobile
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });
    }
}

// Form Validation
function initializeFormValidation() {
    const searchForm = document.querySelector('.search-filter-form');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (!validateSearchForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
        
        // Real-time validation
        const inputs = searchForm.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldValidation(this);
            });
        });
    }
}

function validateSearchForm() {
    const location = document.getElementById('location');
    const searchMonth = document.getElementById('search_month');
    const searchYear = document.getElementById('search_year');
    
    let isValid = true;
    
    // Validate location
    if (location && location.value.trim() === '') {
        markFieldAsInvalid(location, 'Location is required');
        isValid = false;
    }
    
    // Validate month
    if (searchMonth && searchMonth.value.trim() === '') {
        markFieldAsInvalid(searchMonth, 'Month is required');
        isValid = false;
    }
    
    // Validate year
    if (searchYear && searchYear.value.trim() === '') {
        markFieldAsInvalid(searchYear, 'Year is required');
        isValid = false;
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && value === '') {
        markFieldAsInvalid(field, 'This field is required');
        return false;
    }
    
    // Specific validation for year field
    if (field.id === 'search_year') {
        const year = parseInt(value);
        const currentYear = new Date().getFullYear();
        if (year < currentYear - 10 || year > currentYear + 5) {
            markFieldAsInvalid(field, 'Year must be between ' + (currentYear - 10) + ' and ' + (currentYear + 5));
            return false;
        }
    }
    
    markFieldAsValid(field);
    return true;
}

function markFieldAsInvalid(field, message) {
    field.classList.remove('valid');
    field.classList.add('invalid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#e74c3c';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function markFieldAsValid(field) {
    field.classList.remove('invalid');
    field.classList.add('valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function clearFieldValidation(field) {
    field.classList.remove('invalid', 'valid');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Table Enhancements
function initializeTableEnhancements() {
    const table = document.querySelector('.schedule-table');
    
    if (table) {
        // Add row hover effects
        const tbody = table.querySelector('tbody');
        if (tbody) {
            const rows = tbody.querySelectorAll('tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.cursor = 'pointer';
                });
                
                row.addEventListener('click', function() {
                    // Toggle row selection
                    rows.forEach(r => r.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        }
        
        // Add sorting functionality
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (index < headers.length - 1) { // Exclude actions column
                header.style.cursor = 'pointer';
                header.addEventListener('click', function() {
                    sortTable(index);
                });
                
                // Add sort indicator
                const sortIcon = document.createElement('span');
                sortIcon.className = 'sort-indicator';
                sortIcon.innerHTML = ' <i class="fas fa-sort"></i>';
                sortIcon.style.marginLeft = '0.5rem';
                sortIcon.style.opacity = '0.5';
                header.appendChild(sortIcon);
            }
        });
    }
}

function sortTable(columnIndex) {
    const table = document.querySelector('.schedule-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Get current sort direction
    const header = table.querySelectorAll('th')[columnIndex];
    const sortIcon = header.querySelector('.sort-indicator i');
    const isAscending = !sortIcon.classList.contains('fa-sort-up');
    
    // Update sort indicators
    table.querySelectorAll('.sort-indicator i').forEach(icon => {
        icon.className = 'fas fa-sort';
        icon.style.opacity = '0.5';
    });
    
    if (isAscending) {
        sortIcon.className = 'fas fa-sort-up';
        sortIcon.style.opacity = '1';
    } else {
        sortIcon.className = 'fas fa-sort-down';
        sortIcon.style.opacity = '1';
    }
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        let comparison = 0;
        
        // Handle different data types
        if (columnIndex === 0) { // Row number
            comparison = parseInt(aValue) - parseInt(bValue);
        } else if (columnIndex === 5 || columnIndex === 9) { // Dates
            comparison = new Date(aValue) - new Date(bValue);
        } else if (columnIndex === 6 || columnIndex === 7 || columnIndex === 8 || columnIndex === 10 || columnIndex === 11) { // Numbers
            const aNum = parseFloat(aValue.replace(/[^\d.-]/g, ''));
            const bNum = parseFloat(bValue.replace(/[^\d.-]/g, ''));
            comparison = aNum - bNum;
        } else { // Text
            comparison = aValue.localeCompare(bValue);
        }
        
        return isAscending ? comparison : -comparison;
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
}

// Search Functionality
function initializeSearchFunctionality() {
    const searchInput = document.getElementById('searchitem');
    
    if (searchInput) {
        // Debounced search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
        
        // Clear search
        const clearButton = document.querySelector('button[onclick="clearSearch()"]');
        if (clearButton) {
            clearButton.addEventListener('click', function(e) {
                e.preventDefault();
                clearSearch();
            });
        }
    }
}

function performSearch(searchTerm) {
    const table = document.querySelector('.schedule-table');
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm.toLowerCase());
        
        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
    });
    
    // Show search results message
    showSearchResultsMessage(searchTerm, visibleCount, rows.length);
}

function showSearchResultsMessage(searchTerm, visibleCount, totalCount) {
    let messageContainer = document.getElementById('searchResultsMessage');
    
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'searchResultsMessage';
        messageContainer.className = 'search-results-message';
        messageContainer.style.cssText = `
            background: rgba(52,152,219,0.1);
            color: #3498db;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 500;
        `;
        
        const tableSection = document.querySelector('.schedule-table-section');
        tableSection.insertBefore(messageContainer, tableSection.querySelector('.table-container'));
    }
    
    if (searchTerm.trim() === '') {
        messageContainer.style.display = 'none';
    } else {
        messageContainer.style.display = 'block';
        messageContainer.innerHTML = `
            <i class="fas fa-search"></i>
            Search results for "${searchTerm}": ${visibleCount} of ${totalCount} assets found
        `;
    }
}

function clearSearch() {
    const searchInput = document.getElementById('searchitem');
    if (searchInput) {
        searchInput.value = '';
        performSearch('');
    }
    
    // Hide search results message
    const messageContainer = document.getElementById('searchResultsMessage');
    if (messageContainer) {
        messageContainer.style.display = 'none';
    }
}

// Responsive Design
function initializeResponsiveDesign() {
    // Handle window resize
    window.addEventListener('resize', function() {
        handleResize();
    });
    
    // Initial resize handling
    handleResize();
}

function handleResize() {
    const sidebar = document.getElementById('leftSidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 992) {
        if (sidebar) {
            sidebar.classList.remove('collapsed');
        }
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        }
    } else {
        if (sidebar && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    }
}

// Touch Support
function initializeTouchSupport() {
    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
        
        // Handle touch events for sidebar
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar) {
            let startX = 0;
            let currentX = 0;
            
            sidebar.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchmove', function(e) {
                currentX = e.touches[0].clientX;
            });
            
            sidebar.addEventListener('touchend', function(e) {
                const diff = startX - currentX;
                if (Math.abs(diff) > 50) {
                    if (diff > 0) {
                        sidebar.classList.remove('open');
                    } else {
                        sidebar.classList.add('open');
                    }
                }
            });
        }
    }
}

// Utility Functions
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    
    // Remove existing alerts
    const existingAlerts = alertContainer.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

function getAlertIcon(type) {
    switch (type) {
        case 'error': return 'exclamation-triangle';
        case 'success': return 'check-circle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    // Implementation for Excel export
    showAlert('Export functionality will be implemented here.', 'info');
}

function printSchedule() {
    window.print();
}

// Global functions for legacy compatibility
function ajaxlocationfunction(val) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            const ajaxLocation = document.getElementById("ajaxlocation");
            if (ajaxLocation) {
                ajaxLocation.innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    xmlhttp.open("GET", "ajax/ajaxgetlocationname.php?loccode=" + val, true);
    xmlhttp.send();
}

function viewAssetDetails(assetNum) {
    showAlert(`Viewing asset details for: ${assetNum}`, 'info');
    // Implementation for viewing asset details
}

// Add CSS for validation states
const style = document.createElement('style');
style.textContent = `
    .form-input.valid {
        border-color: #27ae60;
        box-shadow: 0 0 0 3px rgba(39,174,96,0.1);
    }
    
    .form-input.invalid {
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231,76,60,0.1);
    }
    
    .field-error {
        color: #e74c3c;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    .schedule-table tbody tr.selected {
        background: rgba(52,152,219,0.1) !important;
        border-left: 4px solid #3498db;
    }
    
    .sort-indicator {
        margin-left: 0.5rem;
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }
    
    .sort-indicator i {
        font-size: 0.8rem;
    }
    
    .touch-device .floating-menu-toggle {
        display: none;
    }
    
    .alert-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        margin-left: auto;
        padding: 0.25rem;
        border-radius: 4px;
        transition: background 0.3s ease;
    }
    
    .alert-close:hover {
        background: rgba(0,0,0,0.1);
    }
    
    .search-results-message {
        background: rgba(52,152,219,0.1);
        color: #3498db;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: 500;
    }
`;
document.head.appendChild(style);




