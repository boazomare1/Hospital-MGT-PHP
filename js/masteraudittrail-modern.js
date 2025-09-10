// Master Audit Trail Modern JavaScript
// Based on vat.php functionality approach

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeMenuToggle();
    initializeFormValidation();
    initializeSearchFunctionality();
    initializeResponsiveDesign();
});

// Sidebar functionality
function initializeSidebar() {
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const menuToggle = document.getElementById('menuToggle');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// Menu toggle functionality
function initializeMenuToggle() {
    const menuToggle = document.getElementById('menuToggle');
    
    if (menuToggle) {
        // Show/hide menu toggle based on screen size
        function toggleMenuVisibility() {
            if (window.innerWidth <= 1024) {
                menuToggle.style.display = 'block';
            } else {
                menuToggle.style.display = 'none';
            }
        }
        
        toggleMenuVisibility();
        window.addEventListener('resize', toggleMenuVisibility);
    }
}

// Form validation
function initializeFormValidation() {
    const searchForm = document.querySelector('.search-form');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            const auditType = document.getElementById('auditype');
            const itemName = document.getElementById('itemname');
            const dateFrom = document.getElementById('ADate1');
            const dateTo = document.getElementById('ADate2');
            
            let isValid = true;
            let errorMessage = '';
            
            // Validate audit type selection
            if (!auditType.value) {
                isValid = false;
                errorMessage = 'Please select an audit type.';
            }
            
            // Validate date range
            if (dateFrom.value && dateTo.value) {
                const fromDate = new Date(dateFrom.value);
                const toDate = new Date(dateTo.value);
                
                if (fromDate > toDate) {
                    isValid = false;
                    errorMessage = 'Date From cannot be later than Date To.';
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                showAlert(errorMessage, 'error');
            }
        });
    }
}

// Search functionality
function initializeSearchFunctionality() {
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        // Debounced search function
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    }
}

// Perform search
function performSearch(searchTerm) {
    const tableBody = document.getElementById('auditTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
    });
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        performSearch('');
    }
}

// Show alert messages
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} fade-in`;
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 'info-circle';
    
    alertDiv.innerHTML = `
        <i class="fas fa-${iconClass} alert-icon"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    alertContainer.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 5000);
}

// Refresh page functionality
function refreshPage() {
    location.reload();
}

// Export to Excel functionality
function exportToExcel() {
    // Implementation for exporting audit data to Excel
    showAlert('Export functionality will be implemented here.', 'info');
}

// Responsive design initialization
function initializeResponsiveDesign() {
    // Handle window resize events
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('leftSidebar');
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('open');
        }
    });
    
    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        addTouchSupport();
    }
}

// Add touch support for mobile
function addTouchSupport() {
    const sidebar = document.getElementById('leftSidebar');
    let startX = 0;
    let currentX = 0;
    
    sidebar.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    });
    
    sidebar.addEventListener('touchmove', function(e) {
        currentX = e.touches[0].clientX;
        const diffX = startX - currentX;
        
        if (Math.abs(diffX) > 50) {
            if (diffX > 0) {
                // Swipe left - close sidebar
                sidebar.classList.remove('open');
            } else {
                // Swipe right - open sidebar
                sidebar.classList.add('open');
            }
        }
    });
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Table sorting functionality
function initializeTableSorting() {
    const tableHeaders = document.querySelectorAll('.data-table th[data-sortable]');
    
    tableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const column = this.dataset.column;
            const direction = this.dataset.direction === 'asc' ? 'desc' : 'asc';
            
            // Update all headers
            tableHeaders.forEach(h => h.dataset.direction = '');
            this.dataset.direction = direction;
            
            // Sort table
            sortTable(column, direction);
        });
    });
}

// Sort table by column
function sortTable(column, direction) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.querySelector(`td[data-${column}]`)?.textContent || '';
        const bValue = b.querySelector(`td[data-${column}]`)?.textContent || '';
        
        if (direction === 'asc') {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
}

// Pagination functionality
function initializePagination() {
    const itemsPerPage = 25;
    const tableBody = document.getElementById('auditTableBody');
    
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    
    if (totalPages > 1) {
        createPaginationControls(totalPages, itemsPerPage);
    }
}

// Create pagination controls
function createPaginationControls(totalPages, itemsPerPage) {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    let paginationHTML = '<div class="pagination">';
    
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
            <button class="pagination-btn" onclick="goToPage(${i}, ${itemsPerPage})">
                ${i}
            </button>
        `;
    }
    
    paginationHTML += '</div>';
    container.innerHTML = paginationHTML;
}

// Go to specific page
function goToPage(page, itemsPerPage) {
    const tableBody = document.getElementById('auditTableBody');
    const rows = tableBody.querySelectorAll('tr');
    
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    rows.forEach((row, index) => {
        if (index >= startIndex && index < endIndex) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update active page button
    updateActivePageButton(page);
}

// Update active page button
function updateActivePageButton(activePage) {
    const buttons = document.querySelectorAll('.pagination-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    const activeButton = document.querySelector(`.pagination-btn:nth-child(${activePage})`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Initialize all functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure all elements are loaded
    setTimeout(() => {
        initializeTableSorting();
        initializePagination();
    }, 100);
});

// Export functions to global scope for inline HTML usage
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.clearSearch = clearSearch;
window.goToPage = goToPage;




