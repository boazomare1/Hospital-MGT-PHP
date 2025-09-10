// ICD Master Modern JavaScript

// Global variables
let currentPage = 1;
let itemsPerPage = 10;
let allICDs = [];
let filteredICDs = [];

// DOM elements
let diseaseInput;
let chapterInput;
let icdNameInput;
let icdCodeInput;
let submitBtn;
let icdTableBody;
let deletedICDTableBody;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

// Initialize DOM elements
function initializeElements() {
    diseaseInput = document.getElementById('disease');
    chapterInput = document.getElementById('chapter');
    icdNameInput = document.getElementById('icdname');
    icdCodeInput = document.getElementById('icdcode');
    submitBtn = document.getElementById('Submit');
    icdTableBody = document.getElementById('icdTableBody');
    deletedICDTableBody = document.getElementById('deletedGenericNameTableBody');
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }

    // Input validation
    if (diseaseInput) {
        diseaseInput.addEventListener('input', validateDiseaseInput);
    }
    
    if (chapterInput) {
        chapterInput.addEventListener('input', validateChapterInput);
    }
    
    if (icdNameInput) {
        icdNameInput.addEventListener('input', validateICDNameInput);
    }
    
    if (icdCodeInput) {
        icdCodeInput.addEventListener('input', validateICDCodeInput);
    }

    // Search functionality
    const searchBtn = document.getElementById('searchbutton');
    if (searchBtn) {
        searchBtn.addEventListener('click', handleSearch);
    }

    const searchInput = document.getElementById('icdsearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleSearch();
            }
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
    if (!icdTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = icdTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allICDs = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 6) {
            return {
                auto_number: row.querySelector('button[onclick*="confirmDelete"]')?.getAttribute('onclick')?.match(/anum=([^'"]+)/)?.[1] || '',
                disease: cells[1]?.textContent?.trim() || '',
                chapter: cells[2]?.textContent?.trim() || '',
                icdname: cells[3]?.textContent?.trim() || '',
                icdcode: cells[4]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredICDs = [...allICDs];
    
    // Apply pagination to existing table
    applyPagination();
    updatePagination();
}

// Apply pagination to the existing table
function applyPagination() {
    if (!icdTableBody) return;
    
    const rows = icdTableBody.querySelectorAll('tr');
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
    
    const disease = diseaseInput.value.trim();
    const chapter = chapterInput.value.trim();
    const icdName = icdNameInput.value.trim();
    const icdCode = icdCodeInput.value.trim();
    
    if (!disease) {
        showAlert('Please enter Group Name.', 'error');
        diseaseInput.focus();
        return;
    }
    
    if (!chapter) {
        showAlert('Please enter Group Code.', 'error');
        chapterInput.focus();
        return;
    }
    
    if (chapter.length > 10) {
        showAlert('Group Code should have maximum 10 characters.', 'error');
        chapterInput.focus();
        return;
    }
    
    if (!icdName) {
        showAlert('Please enter ICD Name.', 'error');
        icdNameInput.focus();
        return;
    }
    
    if (!icdCode) {
        showAlert('Please enter ICD Code.', 'error');
        icdCodeInput.focus();
        return;
    }
    
    if (icdCode.length > 10) {
        showAlert('ICD Code should have maximum 10 characters.', 'error');
        icdCodeInput.focus();
        return;
    }
    
    // Submit the form
    event.target.submit();
}

// Validate disease input
function validateDiseaseInput() {
    const disease = diseaseInput.value.trim();
    
    if (disease.length > 100) {
        showAlert('Group Name must be 100 characters or less.', 'error');
        diseaseInput.value = disease.substring(0, 100);
    }
}

// Validate chapter input
function validateChapterInput() {
    const chapter = chapterInput.value.trim();
    
    if (chapter.length > 10) {
        showAlert('Group Code must be 10 characters or less.', 'error');
        chapterInput.value = chapter.substring(0, 10);
    }
}

// Validate ICD name input
function validateICDNameInput() {
    const icdName = icdNameInput.value.trim();
    
    if (icdName.length > 100) {
        showAlert('ICD Name must be 100 characters or less.', 'error');
        icdNameInput.value = icdName.substring(0, 100);
    }
}

// Validate ICD code input
function validateICDCodeInput() {
    const icdCode = icdCodeInput.value.trim();
    
    if (icdCode.length > 10) {
        showAlert('ICD Code must be 10 characters or less.', 'error');
        icdCodeInput.value = icdCode.substring(0, 10);
    }
}

// Handle search
function handleSearch() {
    const searchInput = document.getElementById('icdsearch');
    const searchTerm = searchInput.value.trim();
    
    if (!searchTerm) {
        showAlert('Please enter a search term.', 'error');
        searchInput.focus();
        return;
    }
    
    // Use the modern search functionality
    searchICDs(searchTerm);
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
function confirmDelete(icdName, autoNumber) {
    if (confirm(`Are you sure you want to delete the ICD "${icdName}"?`)) {
        window.location.href = `addicd.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate action
function confirmActivate(icdName, autoNumber) {
    if (confirm(`Are you sure you want to activate the ICD "${icdName}"?`)) {
        window.location.href = `addicd.php?st=act&anum=${autoNumber}`;
    }
}

// Utility function to escape HTML
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Reset form
function resetForm() {
    if (diseaseInput) diseaseInput.value = '';
    if (chapterInput) chapterInput.value = '';
    if (icdNameInput) icdNameInput.value = '';
    if (icdCodeInput) icdCodeInput.value = '';
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
    csvContent += "Group Name,Group Code,ICD Name,ICD Code,Status\n";
    
    // Add data rows
    allICDs.forEach(icd => {
        csvContent += `"${icd.disease}","${icd.chapter}","${icd.icdname}","${icd.icdcode}","Active"\n`;
    });
    
    // Create download link
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "icd_master.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('ICD data exported to CSV successfully.', 'success');
}

// Search functionality
function searchICDs(searchTerm) {
    if (!searchTerm) {
        filteredICDs = [...allICDs];
    } else {
        filteredICDs = allICDs.filter(icd => 
            icd.disease.toLowerCase().includes(searchTerm.toLowerCase()) ||
            icd.chapter.toLowerCase().includes(searchTerm.toLowerCase()) ||
            icd.icdname.toLowerCase().includes(searchTerm.toLowerCase()) ||
            icd.icdcode.toLowerCase().includes(searchTerm.toLowerCase())
        );
    }
    
    currentPage = 1;
    applyPagination();
    updatePagination();
}

// Clear search
function clearSearch() {
    const searchInput = document.getElementById('icdsearch');
    if (searchInput) {
        searchInput.value = '';
    }
    searchICDs('');
}

// Pagination functions
function goToPage(page) {
    currentPage = page;
    applyPagination();
    updatePagination();
}

function updatePagination() {
    const totalPages = Math.ceil(filteredICDs.length / itemsPerPage);
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (!paginationContainer) return;
    
    let paginationHTML = '';
    
    // Show items info
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredICDs.length);
    paginationHTML += `
        <div style="margin-bottom: 1rem; color: var(--text-secondary); font-size: 0.875rem;">
            Showing ${startItem} to ${endItem} of ${filteredICDs.length} ICD entries
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
    if (icdTableBody) {
        icdTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading ICD data...</p>
                </td>
            </tr>
        `;
    }
}

// Show error state
function showError(message) {
    if (icdTableBody) {
        icdTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${message}</p>
                </td>
            </tr>
        `;
    }
}
