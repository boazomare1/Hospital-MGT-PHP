// Generic Name Master Modern JavaScript

// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let allGenericNames = [];
let filteredGenericNames = [];

// DOM elements
let genericNameInput;
let genericCodeInput;
let submitBtn;
let genericNameTableBody;
let deletedGenericNameTableBody;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

// Initialize DOM elements
function initializeElements() {
    genericNameInput = document.getElementById('genericname');
    genericCodeInput = document.getElementById('genericcode');
    submitBtn = document.getElementById('submitBtn');
    genericNameTableBody = document.getElementById('genericNameTableBody');
    deletedGenericNameTableBody = document.getElementById('deletedGenericNameTableBody');
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const form = document.getElementById('genericNameForm');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }

    // Input validation
    if (genericNameInput) {
        genericNameInput.addEventListener('input', validateGenericNameInput);
    }
    
    if (genericCodeInput) {
        genericCodeInput.addEventListener('input', validateGenericCodeInput);
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

// Setup sidebar toggle functionality
function setupSidebarToggle() {
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

// Initialize pagination with existing table data
function initializePagination() {
    if (!genericNameTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = genericNameTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allGenericNames = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 4) {
            return {
                auto_number: row.querySelector('button[onclick*="confirmDelete"]')?.getAttribute('onclick')?.match(/anum=([^'"]+)/)?.[1] || '',
                genericname: cells[1]?.textContent?.trim() || '',
                genericcode: cells[2]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredGenericNames = [...allGenericNames];
    
    // Apply pagination to existing table
    applyPagination();
    updatePagination();
}

// Apply pagination to the existing table
function applyPagination() {
    if (!genericNameTableBody) return;
    
    const rows = genericNameTableBody.querySelectorAll('tr');
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    rows.forEach((row, index) => {
        if (index >= startIndex && index < endIndex) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Handle form submission
function handleFormSubmit(event) {
    event.preventDefault();
    
    const genericName = genericNameInput.value.trim();
    const genericCode = genericCodeInput.value.trim();
    
    if (!genericName) {
        showAlert('Please enter a generic name.', 'error');
        genericNameInput.focus();
        return;
    }
    
    if (!genericCode) {
        showAlert('Please enter a generic code.', 'error');
        genericCodeInput.focus();
        return;
    }
    
    if (genericName.length > 100) {
        showAlert('Generic name must be 100 characters or less.', 'error');
        genericNameInput.focus();
        return;
    }
    
    if (genericCode.length > 50) {
        showAlert('Generic code must be 50 characters or less.', 'error');
        genericCodeInput.focus();
        return;
    }
    
    // Submit the form
    event.target.submit();
}

// Validate generic name input
function validateGenericNameInput() {
    const genericName = genericNameInput.value.trim();
    
    if (genericName.length > 100) {
        showAlert('Generic name must be 100 characters or less.', 'error');
        genericNameInput.value = genericName.substring(0, 100);
    }
}

// Validate generic code input
function validateGenericCodeInput() {
    const genericCode = genericCodeInput.value.trim();
    
    if (genericCode.length > 50) {
        showAlert('Generic code must be 50 characters or less.', 'error');
        genericCodeInput.value = genericCode.substring(0, 50);
    }
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
    `;

    alertContainer.appendChild(alert);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-triangle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

// Confirm delete action
function confirmDelete(genericName, autoNumber) {
    if (confirm(`Are you sure you want to delete the generic name "${genericName}"?`)) {
        window.location.href = `addgenericname.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate action
function confirmActivate(genericName, autoNumber) {
    if (confirm(`Are you sure you want to activate the generic name "${genericName}"?`)) {
        window.location.href = `addgenericname.php?st=activate&anum=${autoNumber}`;
    }
}

// Utility function to escape HTML
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Format date
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString();
}

// Reset form
function resetForm() {
    if (genericNameInput) {
        genericNameInput.value = '';
    }
    if (genericCodeInput) {
        genericCodeInput.value = '';
    }
    showAlert('Form has been reset.', 'info');
}

// Refresh page
function refreshPage() {
    window.location.reload();
}

// Export to Excel
function exportToExcel() {
    // Create a simple CSV export
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Generic Name,Generic Code,Status,Record Date,Username\n";
    
    // Add data rows
    allGenericNames.forEach(generic => {
        csvContent += `"${generic.genericname}","${generic.genericcode}","${generic.recordstatus || 'Active'}","${generic.recorddate || ''}","${generic.username || ''}"\n`;
    });
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "generic_names.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Generic names exported to CSV successfully.', 'success');
}

// Search functionality
function searchGenericNames(searchTerm) {
    if (!searchTerm) {
        filteredGenericNames = [...allGenericNames];
    } else {
        filteredGenericNames = allGenericNames.filter(generic => 
            generic.genericname.toLowerCase().includes(searchTerm.toLowerCase()) ||
            generic.genericcode.toLowerCase().includes(searchTerm.toLowerCase())
        );
    }
    
    currentPage = 1;
    applyPagination();
    updatePagination();
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    searchGenericNames('');
}

// Pagination functions
function goToPage(page) {
    currentPage = page;
    applyPagination();
    updatePagination();
}

function updatePagination() {
    const totalPages = Math.ceil(filteredGenericNames.length / itemsPerPage);
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (!paginationContainer) return;
    
    let paginationHTML = '';
    
    // Show items info
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredGenericNames.length);
    paginationHTML += `
        <div style="margin-bottom: 1rem; color: var(--text-secondary); font-size: 0.875rem;">
            Showing ${startItem} to ${endItem} of ${filteredGenericNames.length} generic names
        </div>
    `;
    
    // Previous button
    paginationHTML += `
        <button class="btn btn-outline" onclick="goToPage(${currentPage - 1})" 
                ${currentPage === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Previous
        </button>
    `;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `
                <button class="btn ${i === currentPage ? 'btn-primary' : 'btn-outline'}" 
                        onclick="goToPage(${i})">
                    ${i}
                </button>
            `;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += `<span class="pagination-ellipsis">...</span>`;
        }
    }
    
    // Next button
    paginationHTML += `
        <button class="btn btn-outline" onclick="goToPage(${currentPage + 1})" 
                ${currentPage === totalPages ? 'disabled' : ''}>
            Next <i class="fas fa-chevron-right"></i>
        </button>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
}

// Show loading state
function showLoading() {
    if (genericNameTableBody) {
        genericNameTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading generic names...</p>
                </td>
            </tr>
        `;
    }
}

// Show error state
function showError(message) {
    if (genericNameTableBody) {
        genericNameTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${message}</p>
                </td>
            </tr>
        `;
    }
}
