// Active Users Report Modern JavaScript

// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 0;
let totalRecords = 0;
let allActiveUsers = [];
let filteredActiveUsers = [];
let currentFilters = {};

// DOM elements
let activeUsersTableBody;
let paginationInfo;
let prevPageBtn;
let nextPageBtn;
let pageNumbersContainer;
let itemsPerPageSelect;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    loadInitialData();
});

// Initialize DOM elements
function initializeElements() {
    activeUsersTableBody = document.getElementById('activeUsersTableBody');
    paginationInfo = document.getElementById('paginationInfo');
    prevPageBtn = document.getElementById('prevPage');
    nextPageBtn = document.getElementById('nextPage');
    pageNumbersContainer = document.getElementById('pageNumbers');
    itemsPerPageSelect = document.getElementById('itemsPerPage');
}

// Setup event listeners
function setupEventListeners() {
    // Search input debouncing
    const searchInputs = ['userSearch', 'employeeSearch'];
    searchInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', debounce(function() {
                applyFilters();
            }, 300));
        }
    });

    // Items per page change
    if (itemsPerPageSelect) {
        itemsPerPageSelect.addEventListener('change', function() {
            itemsPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
            updatePagination();
        });
    }

    // Sidebar toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

// Load initial data
function loadInitialData() {
    showLoading();
    fetchActiveUsers();
}

// Fetch active users data from API
function fetchActiveUsers() {
    const params = new URLSearchParams({
        page: currentPage,
        limit: itemsPerPage,
        ...currentFilters
    });

    fetch(`get_active_users.php?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allActiveUsers = data.activeUsers;
                filteredActiveUsers = data.activeUsers;
                totalRecords = data.pagination.total;
                totalPages = data.pagination.pages;
                
                // Update summary cards
                updateSummaryCards(data);
                
                renderTable();
                updatePagination();
                hideLoading();
            } else {
                showError(data.message || 'Error loading data');
                hideLoading();
            }
        })
        .catch(error => {
            console.error('Error fetching active users:', error);
            showError('Error loading data. Please try again.');
            hideLoading();
        });
}

// Update summary cards
function updateSummaryCards(data) {
    const totalUsersElement = document.getElementById('totalUsers');
    const totalActiveUsersElement = document.getElementById('totalActiveUsers');
    const topDepartmentElement = document.getElementById('topDepartment');
    
    if (totalUsersElement) {
        totalUsersElement.textContent = data.totalUsers || 0;
    }
    
    if (totalActiveUsersElement) {
        totalActiveUsersElement.textContent = data.totalActiveUsers || 0;
    }
    
    if (topDepartmentElement && data.departments && data.departments.length > 0) {
        const topDept = data.departments[0];
        topDepartmentElement.textContent = `${topDept.name} (${topDept.count})`;
    }
}

// Apply filters
function applyFilters() {
    currentFilters = {
        searchUser: document.getElementById('userSearch')?.value || '',
        searchEmployee: document.getElementById('employeeSearch')?.value || ''
    };
    
    currentPage = 1;
    fetchActiveUsers();
}

// Render the table
function renderTable() {
    if (!activeUsersTableBody) return;
    
    if (allActiveUsers.length === 0) {
        activeUsersTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="no-data">
                    <i class="fas fa-users"></i>
                    <p>No active users found matching the current filters.</p>
                </td>
            </tr>
        `;
        return;
    }
    
    activeUsersTableBody.innerHTML = allActiveUsers.map((user, index) => {
        const serialNumber = (currentPage - 1) * itemsPerPage + index + 1;
        
        return `
            <tr>
                <td>${serialNumber}</td>
                <td>
                    <div class="user-info">
                        <div class="user-name">${escapeHtml(user.employeename)}</div>
                        <div class="user-username">@${escapeHtml(user.username)}</div>
                    </div>
                </td>
                <td>${escapeHtml(user.employeecode)}</td>
                <td>${escapeHtml(user.department)}</td>
                <td>${escapeHtml(user.designation)}</td>
                <td>
                    <div class="login-info">
                        <div class="login-time">${formatDateTime(user.logintime)}</div>
                        <div class="session-duration">${user.session_duration}</div>
                    </div>
                </td>
                <td>
                    <span class="status-badge active">${user.status}</span>
                </td>
            </tr>
        `;
    }).join('');
}

// Update pagination controls
function updatePagination() {
    if (!paginationInfo || !prevPageBtn || !nextPageBtn || !pageNumbersContainer) return;
    
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, totalRecords);
    
    paginationInfo.textContent = `Showing ${startItem} to ${endItem} of ${totalRecords} items`;
    
    // Update previous/next buttons
    prevPageBtn.disabled = currentPage <= 1;
    nextPageBtn.disabled = currentPage >= totalPages;
    
    // Generate page numbers
    pageNumbersContainer.innerHTML = '';
    
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.textContent = i;
        pageBtn.className = i === currentPage ? 'active' : '';
        pageBtn.onclick = () => goToPage(i);
        pageNumbersContainer.appendChild(pageBtn);
    }
}

// Navigation functions
function previousPage() {
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
}

function nextPage() {
    if (currentPage < totalPages) {
        goToPage(currentPage + 1);
    }
}

function goToPage(page) {
    currentPage = page;
    fetchActiveUsers();
}

// Clear all filters
function clearFilters() {
    const searchInputs = ['userSearch', 'employeeSearch'];
    searchInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.value = '';
        }
    });
    
    currentFilters = {};
    currentPage = 1;
    fetchActiveUsers();
}

// Refresh data
function refreshData() {
    fetchActiveUsers();
}

// Export to Excel
function exportToExcel() {
    // Create CSV content
    let csvContent = "data:text/csv;charset=utf-8,";
    
    // Add headers
    csvContent += "S.No.,Employee Name,Username,Employee Code,Department,Designation,Login Time,Session Duration,Status\n";
    
    // Add data
    filteredActiveUsers.forEach((user, index) => {
        const row = [
            index + 1,
            user.employeename,
            user.username,
            user.employeecode,
            user.department,
            user.designation,
            formatDateTime(user.logintime),
            user.session_duration,
            user.status
        ].map(field => `"${field}"`).join(',');
        
        csvContent += row + "\n";
    });
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "active_users_report.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Show loading state
function showLoading() {
    if (activeUsersTableBody) {
        activeUsersTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading active users data...</p>
                </td>
            </tr>
        `;
    }
}

// Hide loading state
function hideLoading() {
    // Loading state is cleared when renderTable() is called
}

// Show error message
function showError(message) {
    if (activeUsersTableBody) {
        activeUsersTableBody.innerHTML = `
            <tr>
                <td colspan="7" class="no-data">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${escapeHtml(message)}</p>
                </td>
            </tr>
        `;
    }
}

// Utility functions
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDateTime(dateString) {
    if (!dateString) return '';
    try {
        const date = new Date(dateString);
        return date.toLocaleString();
    } catch (e) {
        return dateString;
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
