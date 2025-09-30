// Finalized Bills Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    // Sidebar toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Initialize search and pagination
    initializeSearch();
    initializePagination();
});

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        // Debounced search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    }
    
    // Date range search
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    
    if (fromDate && toDate) {
        fromDate.addEventListener('change', performDateSearch);
        toDate.addEventListener('change', performDateSearch);
    }
}

function initializePagination() {
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    paginationBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.disabled) {
                const page = this.dataset.page;
                goToPage(page);
            }
        });
    });
}

function performSearch(query) {
    console.log('Searching for:', query);
    showAlert(`Searching for: ${query}`, 'info');
    
    // Add actual search functionality here
    // This would typically make an AJAX call to search the database
}

function performDateSearch() {
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    
    if (fromDate && toDate) {
        console.log('Date range search:', fromDate, 'to', toDate);
        showAlert(`Searching from ${fromDate} to ${toDate}`, 'info');
        
        // Add actual date search functionality here
    }
}

function goToPage(page) {
    console.log('Going to page:', page);
    showAlert(`Loading page ${page}...`, 'info');
    
    // Add actual pagination functionality here
    // This would typically make an AJAX call to load the page
}

function exportToExcel() {
    showAlert('Exporting to Excel...', 'info');
    
    // Add Excel export functionality here
    // This would typically generate and download an Excel file
}

function exportToPDF() {
    showAlert('Exporting to PDF...', 'info');
    
    // Add PDF export functionality here
    // This would typically generate and download a PDF file
}

function printList() {
    window.print();
}

function refreshData() {
    showAlert('Refreshing data...', 'info');
    location.reload();
}

function filterByStatus(status) {
    console.log('Filtering by status:', status);
    showAlert(`Filtering by status: ${status}`, 'info');
    
    // Add status filtering functionality here
}

function filterByLocation(location) {
    console.log('Filtering by location:', location);
    showAlert(`Filtering by location: ${location}`, 'info');
    
    // Add location filtering functionality here
}

function viewDetails(recordId) {
    console.log('Viewing details for record:', recordId);
    showAlert(`Loading details for record ${recordId}...`, 'info');
    
    // Add details view functionality here
    // This would typically open a modal or navigate to a details page
}

function editRecord(recordId) {
    console.log('Editing record:', recordId);
    showAlert(`Opening edit form for record ${recordId}...`, 'info');
    
    // Add edit functionality here
    // This would typically open an edit form
}

function deleteRecord(recordId) {
    if (confirm('Are you sure you want to delete this record?')) {
        console.log('Deleting record:', recordId);
        showAlert(`Deleting record ${recordId}...`, 'info');
        
        // Add delete functionality here
        // This would typically make an AJAX call to delete the record
    }
}

function bulkAction(action) {
    const selectedRecords = getSelectedRecords();
    
    if (selectedRecords.length === 0) {
        showAlert('Please select records to perform bulk action', 'error');
        return;
    }
    
    console.log('Bulk action:', action, 'on records:', selectedRecords);
    showAlert(`Performing ${action} on ${selectedRecords.length} records...`, 'info');
    
    // Add bulk action functionality here
}

function getSelectedRecords() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

function selectAll() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    checkboxes.forEach(cb => {
        cb.checked = selectAllCheckbox.checked;
    });
}

function clearFilters() {
    const searchInput = document.getElementById('searchInput');
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    
    if (searchInput) searchInput.value = '';
    if (fromDate) fromDate.value = '';
    if (toDate) toDate.value = '';
    
    showAlert('Filters cleared', 'info');
    performSearch('');
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} alert-icon"></i>
            ${message}
        `;
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Export functions for global access
window.exportToExcel = exportToExcel;
window.exportToPDF = exportToPDF;
window.printList = printList;
window.refreshData = refreshData;
window.filterByStatus = filterByStatus;
window.filterByLocation = filterByLocation;
window.viewDetails = viewDetails;
window.editRecord = editRecord;
window.deleteRecord = deleteRecord;
window.bulkAction = bulkAction;
window.selectAll = selectAll;
window.clearFilters = clearFilters;
