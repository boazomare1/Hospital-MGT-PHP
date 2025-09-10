// Approved RFP List Modern JavaScript
let allRfpData = [];
let filteredRfpData = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let rfpTable, searchInput, clearBtn, dateFromInput, dateToInput;
let sidebarToggle, leftSidebar, menuToggle;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupAutoHideAlerts();
    setupRfpSearch();
    setupRfpFilters();
    setupRfpActions();
});

function initializeElements() {
    rfpTable = document.getElementById('rfpTable');
    searchInput = document.getElementById('searchInput');
    clearBtn = document.getElementById('clearBtn');
    dateFromInput = document.getElementById('dateFrom');
    dateToInput = document.getElementById('dateTo');
    sidebarToggle = document.getElementById('sidebarToggle');
    leftSidebar = document.getElementById('leftSidebar');
    menuToggle = document.getElementById('menuToggle');
}

function setupEventListeners() {
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', handleSearch);
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }
    
    // Date filters
    if (dateFromInput) {
        dateFromInput.addEventListener('change', handleDateFilter);
    }
    
    if (dateToInput) {
        dateToInput.addEventListener('change', handleDateFilter);
    }
    
    // RFP actions
    setupRfpActions();
}

function setupSidebarToggle() {
    if (sidebarToggle) {
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
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!leftSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                leftSidebar.classList.remove('active');
            }
        }
    });
}

function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

function setupRfpSearch() {
    // Enhanced RFP search functionality
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.toLowerCase();
            filterRfpData(searchTerm);
        }, 300));
    }
}

function setupRfpFilters() {
    // Setup date range filters
    if (dateFromInput && dateToInput) {
        // Set default date range (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
        
        dateFromInput.value = formatDateForInput(thirtyDaysAgo);
        dateToInput.value = formatDateForInput(today);
        
        // Apply initial filter
        handleDateFilter();
    }
}

function setupRfpActions() {
    // Setup action buttons for each RFP row
    const viewButtons = document.querySelectorAll('.view-btn');
    viewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const docno = this.getAttribute('data-docno');
            if (docno) {
                viewRfpDetails(docno);
            }
        });
    });
}

function handleSearch(value) {
    const searchTerm = value.toLowerCase();
    const rows = document.querySelectorAll('.rfp-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    updateSearchResults(rows.length);
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    
    const rows = document.querySelectorAll('.rfp-table tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
    
    updateSearchResults(rows.length);
}

function handleDateFilter() {
    const dateFrom = dateFromInput ? dateFromInput.value : '';
    const dateTo = dateToInput ? dateToInput.value : '';
    
    if (dateFrom && dateTo) {
        filterRfpByDate(dateFrom, dateTo);
    }
}

function filterRfpByDate(dateFrom, dateTo) {
    const rows = document.querySelectorAll('.rfp-table tbody tr');
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    
    rows.forEach(row => {
        const dateCell = row.querySelector('.rfp-date');
        if (dateCell) {
            const rowDate = new Date(dateCell.textContent);
            if (rowDate >= fromDate && rowDate <= toDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
    
    updateSearchResults(rows.length);
}

function filterRfpData(searchTerm) {
    const rows = document.querySelectorAll('.rfp-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    updateSearchResults(visibleCount);
}

function updateSearchResults(count) {
    const resultsInfo = document.getElementById('searchResults');
    if (resultsInfo) {
        resultsInfo.textContent = `Showing ${count} approved RFPs`;
    }
}

function viewRfpDetails(docno) {
    const url = `viewapprovedrfp.php?docno=${encodeURIComponent(docno)}`;
    window.open(url, '_blank');
    showNotification(`Opening RFP details for ${docno}`, 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#d1fae5' : '#dbeafe'};
        color: ${type === 'error' ? '#991b1b' : type === 'success' ? '#065f46' : '#1e40af'};
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 10000;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

function exportToPDF() {
    const url = `print_approvedrfplistpdf.php?datefrom=${dateFromInput?.value || ''}&dateto=${dateToInput?.value || ''}`;
    window.open(url, '_blank');
    showNotification('PDF export initiated', 'success');
}

function exportToExcel() {
    const url = `print_approvedrfplistexcel.php?datefrom=${dateFromInput?.value || ''}&dateto=${dateToInput?.value || ''}`;
    window.open(url, '_blank');
    showNotification('Excel export initiated', 'success');
}

function printPage() {
    window.print();
}

function refreshPage() {
    window.location.reload();
}

function resetFilters() {
    if (confirm('Are you sure you want to reset all filters?')) {
        if (searchInput) searchInput.value = '';
        if (dateFromInput) dateFromInput.value = '';
        if (dateToInput) dateToInput.value = '';
        
        const rows = document.querySelectorAll('.rfp-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        
        updateSearchResults(rows.length);
        showNotification('Filters reset successfully', 'success');
    }
}

// Utility functions
function formatDateForInput(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced RFP status functions
function getRfpStatusClass(status) {
    const statusLower = status.toLowerCase();
    if (statusLower.includes('approved')) return 'approved';
    if (statusLower.includes('pending')) return 'pending';
    if (statusLower.includes('rejected')) return 'rejected';
    if (statusLower.includes('draft')) return 'draft';
    return 'pending';
}

function updateRfpStatus(docno, newStatus) {
    // This would typically make an AJAX call to update the status
    showNotification(`RFP ${docno} status updated to ${newStatus}`, 'success');
    
    // Update the UI
    const statusCell = document.querySelector(`[data-docno="${docno}"] .rfp-status`);
    if (statusCell) {
        statusCell.textContent = newStatus;
        statusCell.className = `rfp-status ${getRfpStatusClass(newStatus)}`;
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F to search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Ctrl/Cmd + P to print
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printPage();
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        clearSearch();
    }
    
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshPage();
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .notification-close {
        background: none;
        border: none;
        cursor: pointer;
        color: inherit;
        padding: 0;
        margin-left: auto;
    }
    
    .rfp-table tr.highlight {
        background: rgba(59, 130, 246, 0.1) !important;
        animation: highlight 0.5s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background: rgba(59, 130, 246, 0.3); }
        100% { background: rgba(59, 130, 246, 0.1); }
    }
    
    .rfp-status {
        position: relative;
    }
    
    .rfp-status::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .rfp-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .rfp-table tbody tr:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

// Initialize RFP data on page load
window.addEventListener('load', function() {
    // Count total RFPs
    const totalRfps = document.querySelectorAll('.rfp-table tbody tr').length;
    const rfpCountElement = document.querySelector('.rfp-count');
    if (rfpCountElement) {
        rfpCountElement.textContent = totalRfps;
    }
    
    // Update search results
    updateSearchResults(totalRfps);
    
    // Add row highlighting on click
    const tableRows = document.querySelectorAll('.rfp-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove highlight from other rows
            tableRows.forEach(r => r.classList.remove('highlight'));
            // Add highlight to clicked row
            this.classList.add('highlight');
        });
    });
});







