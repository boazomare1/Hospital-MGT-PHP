// Amendment Details Modern JavaScript - Following Hospital Theme
let allAmendmentRecords = [];
let filteredAmendmentRecords = [];
let currentPage = 1;
const itemsPerPage = 20;

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeData();
    setupEventListeners();
    setupFormValidation();
    setupTableSearch();
    updateTotalRecordsCount();
});

// Initialize data
function initializeData() {
    const table = document.getElementById('amendmentTable');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        allAmendmentRecords = Array.from(rows).map(row => ({
            element: row,
            data: extractRowData(row)
        }));
        filteredAmendmentRecords = [...allAmendmentRecords];
        setupPagination();
    }
}

// Extract data from table row
function extractRowData(row) {
    const cells = row.querySelectorAll('td');
    return {
        sno: cells[0]?.textContent?.trim() || '',
        patientCode: cells[1]?.textContent?.trim() || '',
        visitCode: cells[2]?.textContent?.trim() || '',
        patientName: cells[3]?.textContent?.trim() || '',
        itemName: cells[4]?.textContent?.trim() || '',
        rate: cells[5]?.textContent?.trim() || '',
        service: cells[6]?.textContent?.trim() || '',
        date: cells[7]?.textContent?.trim() || '',
        user: cells[8]?.textContent?.trim() || '',
        remarks: cells[9]?.textContent?.trim() || '',
        ipAddress: cells[10]?.textContent?.trim() || '',
        visitType: cells[11]?.textContent?.trim() || ''
    };
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', handleSearch);
    }
    
    // Form reset
    const resetButton = searchForm?.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', handleReset);
    }
    
    // Date validation
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        input.addEventListener('change', validateDateRange);
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', handleKeyboardNavigation);
    
    // Sidebar toggle
    setupSidebarToggle();
}

// Handle search form submission
function handleSearch(event) {
    showLoadingState();
    
    // Add a small delay to show loading state
    setTimeout(() => {
        hideLoadingState();
        showAlert('Search completed successfully!', 'success');
        updateTotalRecordsCount();
    }, 500);
}

// Handle form reset
function handleReset() {
    showAlert('Form has been reset', 'info');
    updateTotalRecordsCount();
}

// Validate date range
function validateDateRange() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (dateFrom.value && dateTo.value && dateFrom.value > dateTo.value) {
        showAlert('Date From cannot be greater than Date To', 'warning');
        dateTo.value = dateFrom.value;
    }
}

// Setup form validation
function setupFormValidation() {
    const form = document.getElementById('searchForm');
    if (!form) return;
    
    form.addEventListener('submit', function(event) {
        const dateFrom = document.getElementById('ADate1');
        const dateTo = document.getElementById('ADate2');
        
        if (!dateFrom.value || !dateTo.value) {
            event.preventDefault();
            showAlert('Please select both start and end dates', 'warning');
            return false;
        }
        
        if (dateFrom.value > dateTo.value) {
            event.preventDefault();
            showAlert('Date From cannot be greater than Date To', 'warning');
            return false;
        }
        
        return true;
    });
}

// Setup table search functionality
function setupTableSearch() {
    const searchInput = document.getElementById('tableSearch');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', debounce(function() {
        const searchTerm = this.value.toLowerCase().trim();
        filterTableRecords(searchTerm);
    }, 300));
}

// Filter table records based on search term
function filterTableRecords(searchTerm) {
    if (!searchTerm) {
        filteredAmendmentRecords = [...allAmendmentRecords];
    } else {
        filteredAmendmentRecords = allAmendmentRecords.filter(record => {
            return Object.values(record.data).some(value => 
                value.toLowerCase().includes(searchTerm)
            );
        });
    }
    
    currentPage = 1;
    setupPagination();
    updateTotalRecordsCount();
    showAlert(`Found ${filteredAmendmentRecords.length} matching records`, 'info');
}

// Setup pagination
function setupPagination() {
    const paginationContainer = document.getElementById('paginationContainer');
    if (!paginationContainer) return;
    
    const totalPages = Math.ceil(filteredAmendmentRecords.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    // Show current page records
    filteredAmendmentRecords.forEach((record, index) => {
        if (index >= startIndex && index < endIndex) {
            record.element.style.display = '';
        } else {
            record.element.style.display = 'none';
        }
    });
    
    // Generate pagination buttons
    generatePaginationButtons(totalPages);
}

// Generate pagination buttons
function generatePaginationButtons(totalPages) {
    const paginationContainer = document.getElementById('paginationContainer');
    if (!paginationContainer) return;
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `<button onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
        <i class="fas fa-chevron-left"></i> Previous
    </button>`;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `<button onclick="goToPage(${i})" class="${i === currentPage ? 'active' : ''}">${i}</button>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += `<span>...</span>`;
        }
    }
    
    // Next button
    paginationHTML += `<button onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
        Next <i class="fas fa-chevron-right"></i>
    </button>`;
    
    paginationContainer.innerHTML = paginationHTML;
}

// Go to specific page
function goToPage(page) {
    const totalPages = Math.ceil(filteredAmendmentRecords.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    setupPagination();
}

// Setup sidebar toggle functionality
function setupSidebarToggle() {
    const sidebar = document.getElementById('leftSidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Check if sidebar should be collapsed by default on smaller screens
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
    }
}

// Setup autocomplete (placeholder for future enhancement)
function setupAutocomplete() {
    // This function can be enhanced with actual autocomplete functionality
    // For now, it's a placeholder
}

// Refresh page
function refreshPage() {
    location.reload();
}

// Search records
function searchRecords(searchTerm) {
    const searchTermLower = searchTerm.toLowerCase().trim();
    const tableBody = document.getElementById('amendmentTableBody');
    
    if (!tableBody) return;
    
    const rows = tableBody.querySelectorAll('tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTermLower)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update record count
    const recordCount = document.getElementById('recordCount');
    if (recordCount) {
        recordCount.textContent = visibleCount;
    }
    
    // Show alert
    if (searchTerm) {
        showAlert(`Found ${visibleCount} matching records`, 'info');
    }
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.value = '';
        searchRecords('');
    }
}

// Show loading state
function showLoadingState() {
    const loading = document.getElementById('loading');
    if (loading) {
        loading.classList.add('show');
    }
}

// Hide loading state
function hideLoadingState() {
    const loading = document.getElementById('loading');
    if (loading) {
        loading.classList.remove('show');
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas ${getAlertIcon(type)}"></i>
        ${message}
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        info: 'fa-info-circle',
        warning: 'fa-exclamation-triangle',
        danger: 'fa-times-circle'
    };
    return icons[type] || icons.info;
}

// Update total records count
function updateTotalRecordsCount() {
    const recordCount = document.getElementById('recordCount');
    if (recordCount) {
        const count = filteredAmendmentRecords.length;
        recordCount.textContent = count.toLocaleString();
    }
}

// Debounce function for search
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

// Export to CSV
function exportToCSV() {
    if (filteredAmendmentRecords.length === 0) {
        showAlert('No records to export', 'warning');
        return;
    }
    
    const headers = [
        'No.', 'Patient Code', 'Visit Code', 'Patient Name', 'Item Name',
        'Rate', 'Service', 'Date', 'User', 'Remarks', 'IP Address', 'Visit Type'
    ];
    
    const csvContent = [
        headers.join(','),
        ...filteredAmendmentRecords.map(record => [
            record.data.sno,
            record.data.patientCode,
            record.data.visitCode,
            record.data.patientName,
            record.data.itemName,
            record.data.rate,
            record.data.service,
            record.data.date,
            record.data.user,
            record.data.remarks,
            record.data.ipAddress,
            record.data.visitType
        ].join(','))
    ].join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `amendment_details_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('CSV export completed successfully!', 'success');
}

// Print report
function printReport() {
    const printWindow = window.open('', '_blank');
    const table = document.getElementById('amendmentTable');
    
    if (!table) {
        showAlert('No data to print', 'warning');
        return;
    }
    
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Amendment Details Report - MedStar</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                h1 { color: #2c3e50; text-align: center; }
                .header { text-align: center; margin-bottom: 30px; }
                @media print { body { margin: 0; } }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🏥 MedStar Hospital Management</h1>
                <h2>Amendment Details Report</h2>
                <p>Generated on: ${new Date().toLocaleString()}</p>
                <p>Total Records: ${filteredAmendmentRecords.length}</p>
            </div>
            ${table.outerHTML}
        </body>
        </html>
    `;
    
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.focus();
    
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
    
    showAlert('Print preview opened', 'info');
}

// View details (placeholder for future enhancement)
function viewDetails(recordId) {
    // This function can be enhanced to show detailed view of a record
    showAlert('View details functionality coming soon!', 'info');
}

// Handle keyboard navigation
function handleKeyboardNavigation(event) {
    // Ctrl + F: Focus search
    if (event.ctrlKey && event.key === 'f') {
        event.preventDefault();
        const searchInput = document.getElementById('tableSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Ctrl + P: Print
    if (event.ctrlKey && event.key === 'p') {
        event.preventDefault();
        printReport();
    }
    
    // Ctrl + E: Export CSV
    if (event.ctrlKey && event.key === 'e') {
        event.preventDefault();
        exportToCSV();
    }
    
    // Ctrl + B: Toggle sidebar
    if (event.ctrlKey && event.key === 'b') {
        event.preventDefault();
        toggleSidebar();
    }
    
    // Escape: Clear search
    if (event.key === 'Escape') {
        const searchInput = document.getElementById('tableSearch');
        if (searchInput) {
            searchInput.value = '';
            filterTableRecords('');
        }
    }
}

// Setup lazy loading (placeholder for future enhancement)
function setupLazyLoading() {
    // This function can be enhanced with actual lazy loading functionality
    // For now, it's a placeholder
}

// Setup auto refresh (placeholder for future enhancement)
function setupAutoRefresh() {
    // This function can be enhanced with actual auto refresh functionality
    // For now, it's a placeholder
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(amount);
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-IN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeData);
} else {
    initializeData();
}
