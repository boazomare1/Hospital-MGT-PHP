// Asset Entry List Modern JavaScript
// Based on vat.php and other modernized files functionality approach

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeSidebar();
    initializeMenuToggle();
    initializeResponsiveDesign();
    initializeTableEnhancements();
    initializePagination();
    initializeSearchFunctionality();
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

// Table enhancements
function initializeTableEnhancements() {
    const table = document.querySelector('.assets-table');
    if (!table) return;
    
    // Add row hover effects
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Add sorting functionality
    initializeTableSorting();
}

// Table sorting functionality
function initializeTableSorting() {
    const tableHeaders = document.querySelectorAll('.assets-table th');
    
    tableHeaders.forEach((header, index) => {
        if (index < tableHeaders.length - 1) { // Exclude actions column
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(index);
            });
            
            // Add sort indicator
            header.innerHTML += ' <i class="fas fa-sort sort-indicator"></i>';
        }
    });
}

// Sort table by column
function sortTable(columnIndex) {
    const table = document.querySelector('.assets-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Get current sort direction
    const currentDirection = table.dataset.sortDirection === 'asc' ? 'desc' : 'asc';
    table.dataset.sortDirection = currentDirection;
    
    // Update sort indicators
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        const indicator = header.querySelector('.sort-indicator');
        if (indicator) {
            indicator.className = 'fas sort-indicator';
            if (index === columnIndex) {
                indicator.classList.add(currentDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
            } else {
                indicator.classList.add('fa-sort');
            }
        }
    });
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        // Handle different data types
        let aNum = parseFloat(aValue.replace(/[^0-9.-]+/g, ''));
        let bNum = parseFloat(bValue.replace(/[^0-9.-]+/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            // Numeric comparison
            return currentDirection === 'asc' ? aNum - bNum : bNum - aNum;
        } else {
            // String comparison
            if (currentDirection === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update row numbers
    updateRowNumbers();
}

// Update row numbers after sorting
function updateRowNumbers() {
    const rows = document.querySelectorAll('.assets-table tbody tr');
    rows.forEach((row, index) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = index + 1;
        }
    });
}

// Pagination functionality
function initializePagination() {
    const itemsPerPage = 25;
    const tableBody = document.getElementById('assetsTableBody');
    
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    
    if (totalPages > 1) {
        createPaginationControls(totalPages, itemsPerPage);
        showPage(1, itemsPerPage);
    }
}

// Create pagination controls
function createPaginationControls(totalPages, itemsPerPage) {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    let paginationHTML = '<div class="pagination">';
    
    // Previous button
    paginationHTML += `
        <button class="pagination-btn" onclick="changePage(-1, ${itemsPerPage})" id="prevBtn">
            <i class="fas fa-chevron-left"></i> Previous
        </button>
    `;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
            <button class="pagination-btn" onclick="goToPage(${i}, ${itemsPerPage})" data-page="${i}">
                ${i}
            </button>
        `;
    }
    
    // Next button
    paginationHTML += `
        <button class="pagination-btn" onclick="changePage(1, ${itemsPerPage})" id="nextBtn">
            Next <i class="fas fa-chevron-right"></i>
        </button>
    `;
    
    paginationHTML += '</div>';
    container.innerHTML = paginationHTML;
    
    // Set initial active page
    updateActivePageButton(1);
}

// Show specific page
function showPage(page, itemsPerPage) {
    const tableBody = document.getElementById('assetsTableBody');
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
    
    // Update pagination state
    updatePaginationState(page, Math.ceil(rows.length / itemsPerPage));
}

// Go to specific page
function goToPage(page, itemsPerPage) {
    showPage(page, itemsPerPage);
}

// Change page (previous/next)
function changePage(direction, itemsPerPage) {
    const activeButton = document.querySelector('.pagination-btn.active');
    if (!activeButton) return;
    
    const currentPage = parseInt(activeButton.dataset.page);
    const newPage = currentPage + direction;
    
    if (newPage >= 1) {
        const totalPages = Math.ceil(document.querySelectorAll('#assetsTableBody tr').length / itemsPerPage);
        if (newPage <= totalPages) {
            goToPage(newPage, itemsPerPage);
        }
    }
}

// Update active page button
function updateActivePageButton(activePage) {
    const buttons = document.querySelectorAll('.pagination-btn[data-page]');
    buttons.forEach(btn => btn.classList.remove('active'));
    
    const activeButton = document.querySelector(`[data-page="${activePage}"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Update pagination state
function updatePaginationState(currentPage, totalPages) {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (prevBtn) {
        prevBtn.disabled = currentPage <= 1;
        prevBtn.style.opacity = currentPage <= 1 ? '0.5' : '1';
    }
    
    if (nextBtn) {
        nextBtn.disabled = currentPage >= totalPages;
        nextBtn.style.opacity = currentPage >= totalPages ? '0.5' : '1';
    }
}

// Search functionality
function initializeSearchFunctionality() {
    const searchInput = document.getElementById('searchitem');
    if (!searchInput) return;
    
    // Debounced search function
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });
    
    // Clear search on form submit
    const searchForm = document.querySelector('.search-filter-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function() {
            // Reset pagination when searching
            setTimeout(() => {
                initializePagination();
            }, 100);
        });
    }
}

// Perform search
function performSearch(searchTerm) {
    const tableBody = document.getElementById('assetsTableBody');
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm.toLowerCase());
        row.style.display = isVisible ? '' : 'none';
        
        if (isVisible) visibleCount++;
    });
    
    // Show search results message
    showSearchResults(visibleCount, searchTerm);
}

// Show search results
function showSearchResults(count, searchTerm) {
    let messageContainer = document.getElementById('searchResultsMessage');
    
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'searchResultsMessage';
        messageContainer.className = 'search-results-message';
        messageContainer.style.cssText = 'padding: 1rem; margin: 1rem 0; background: #e3f2fd; border-radius: 8px; color: #1976d2;';
        
        const tableSection = document.querySelector('.assets-table-section');
        if (tableSection) {
            tableSection.insertBefore(messageContainer, tableSection.firstChild);
        }
    }
    
    if (searchTerm.trim()) {
        messageContainer.innerHTML = `
            <i class="fas fa-search"></i>
            Found ${count} asset${count !== 1 ? 's' : ''} matching "${searchTerm}"
        `;
        messageContainer.style.display = 'block';
    } else {
        messageContainer.style.display = 'none';
    }
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('searchitem');
    if (searchInput) {
        searchInput.value = '';
        performSearch('');
    }
    
    // Reset month and year to current
    const monthSelect = document.getElementById('search_month');
    const yearSelect = document.getElementById('search_year');
    
    if (monthSelect) {
        monthSelect.value = new Date().getMonth() + 1;
    }
    if (yearSelect) {
        yearSelect.value = new Date().getFullYear();
    }
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

// Refresh page functionality
function refreshPage() {
    location.reload();
}

// Export to Excel functionality
function exportToExcel() {
    // Implementation for exporting asset data to Excel
    showAlert('Export functionality will be implemented here.', 'info');
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

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

// Initialize additional functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure all elements are loaded
    setTimeout(() => {
        // Additional initializations if needed
    }, 100);
});

// Export functions to global scope for inline HTML usage
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;
window.clearSearch = clearSearch;
window.goToPage = goToPage;
window.changePage = changePage;




