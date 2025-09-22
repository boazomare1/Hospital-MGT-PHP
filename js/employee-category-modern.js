// Modern Employee Category JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initSidebar();
    
    // Initialize form functionality
    initFormHandlers();
    
    // Initialize table functionality
    initTableFeatures();
    
    // Initialize search functionality
    initSearchFeatures();
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
    // Form submission
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    }
    
    // Real-time validation
    const categoryInput = document.getElementById('category');
    if (categoryInput) {
        categoryInput.addEventListener('input', function() {
            validateCategoryField(this);
        });
        
        categoryInput.addEventListener('blur', function() {
            validateCategoryField(this);
        });
    }
}

// Table functionality
function initTableFeatures() {
    // Add table enhancements
    const categoriesTable = document.getElementById('categoriesTable');
    const deletedTable = document.getElementById('deletedTable');
    
    if (categoriesTable) {
        addTableSorting(categoriesTable);
        addRowHighlighting(categoriesTable);
    }
    
    if (deletedTable) {
        addTableSorting(deletedTable);
        addRowHighlighting(deletedTable);
    }
}

// Search functionality
function initSearchFeatures() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTable(this.value);
        });
    }
}

// Validation functions
function validateForm() {
    const categoryInput = document.getElementById('category');
    if (!categoryInput) return false;
    
    return validateCategoryField(categoryInput);
}

function validateCategoryField(field) {
    const value = field.value.trim();
    
    // Clear previous errors
    clearFieldError(field);
    
    if (!value) {
        showFieldError(field, 'Category name is required');
        return false;
    }
    
    if (value.length > 100) {
        showFieldError(field, 'Category name must be 100 characters or less');
        return false;
    }
    
    // Check for special characters (optional validation)
    const specialChars = /[<>'"&]/;
    if (specialChars.test(value)) {
        showFieldError(field, 'Category name contains invalid characters');
        return false;
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    // Remove existing error message
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.75rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
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

// Utility functions
function refreshPage() {
    window.location.reload();
}

function clearForm() {
    const form = document.getElementById('form1');
    if (form) {
        form.reset();
        
        // Clear all error states
        const errorFields = form.querySelectorAll('.form-input.error');
        errorFields.forEach(field => {
            clearFieldError(field);
        });
        
        showAlert('Form has been cleared.', 'info');
    }
}

function exportCategories() {
    const table = document.getElementById('categoriesTable');
    if (!table) return;
    
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const data = rows.map(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 2) {
            return {
                category: cells[1].textContent.trim()
            };
        }
        return null;
    }).filter(item => item !== null);
    
    const csvContent = "Category\n" + data.map(item => `"${item.category}"`).join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    
    const a = document.createElement('a');
    a.href = url;
    a.download = 'employee_categories.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    showAlert('Categories exported successfully.', 'success');
}

// Search functionality
function toggleSearch() {
    const searchContainer = document.getElementById('searchContainer');
    if (searchContainer) {
        const isVisible = searchContainer.style.display !== 'none';
        searchContainer.style.display = isVisible ? 'none' : 'block';
        
        if (!isVisible) {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
            }
        }
    }
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        filterTable('');
    }
}

function filterTable(searchTerm) {
    const table = document.getElementById('categoriesTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const categoryCell = row.querySelector('td:nth-child(2)');
        if (categoryCell) {
            const categoryText = categoryCell.textContent.toLowerCase();
            const matches = categoryText.includes(term);
            row.style.display = matches ? '' : 'none';
        }
    });
    
    // Update summary count
    updateFilteredCount();
}

function updateFilteredCount() {
    const table = document.getElementById('categoriesTable');
    if (!table) return;
    
    const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
    const count = visibleRows.length;
    
    // Update summary if it exists
    const summaryItem = document.querySelector('.summary-item');
    if (summaryItem) {
        const countSpan = summaryItem.querySelector('strong');
        if (countSpan) {
            countSpan.textContent = count;
        }
    }
}

// Table enhancements
function addTableSorting(table) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Skip actions column
        if (index === 0 || index === 2) return;
        
        header.style.cursor = 'pointer';
        header.style.userSelect = 'none';
        header.innerHTML += ' <i class="fas fa-sort sort-icon"></i>';
        
        header.addEventListener('click', function() {
            sortTable(table, index);
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        return isAscending ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
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
            if (!this.classList.contains('deleted-row')) {
                this.style.backgroundColor = '#f8fafc';
            } else {
                this.style.backgroundColor = '#fef2f2';
            }
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'all 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
        });
    });
}

// Legacy function compatibility
function Process1() {
    return validateForm();
}

function funcDeleteCategory() {
    return confirm('Are you sure you want to delete this category?');
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + F for search
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        toggleSearch();
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const searchContainer = document.getElementById('searchContainer');
        if (searchContainer && searchContainer.style.display !== 'none') {
            clearSearch();
            toggleSearch();
        }
    }
    
    // Ctrl + R for refresh
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
});

// Auto-save functionality (optional)
function initAutoSave() {
    const categoryInput = document.getElementById('category');
    if (!categoryInput) return;
    
    let autoSaveTimeout;
    
    categoryInput.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Auto-save logic would go here
            console.log('Auto-saving category data...');
        }, 2000);
    });
}

// Initialize auto-save
document.addEventListener('DOMContentLoaded', function() {
    initAutoSave();
});

// Form progress indicator
function updateFormProgress() {
    const categoryInput = document.getElementById('category');
    if (!categoryInput) return;
    
    const value = categoryInput.value.trim();
    const progress = value.length > 0 ? 100 : 0;
    
    console.log(`Form completion: ${progress}%`);
}

// Initialize form progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const categoryInput = document.getElementById('category');
    if (categoryInput) {
        categoryInput.addEventListener('input', updateFormProgress);
    }
});

// Print functionality
function printCategories() {
    window.print();
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Employee Category Management System initialized');
    
    // Show success message if redirected from successful submission
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('st') === 'success') {
        showAlert('Category added successfully!', 'success');
    }
    
    // Add confirmation for delete links
    const deleteLinks = document.querySelectorAll('a[href*="st=del"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!funcDeleteCategory()) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // Add confirmation for activate links
    const activateLinks = document.querySelectorAll('a[href*="st=activate"]');
    activateLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to activate this category?')) {
                e.preventDefault();
                return false;
            }
        });
    });
});

// Add CSS for error states
const style = document.createElement('style');
style.textContent = `
    .form-input.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
    
    .sort-icon {
        opacity: 0.5;
        margin-left: 0.5rem;
    }
    
    .data-table th:hover .sort-icon {
        opacity: 1;
    }
`;
document.head.appendChild(style);

