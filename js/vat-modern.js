// VAT Master Modern JavaScript
let allVATRecords = [];
let filteredVATRecords = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let locationSelect, vatidInput, nameInput, flagSelect, submitBtn, vatTableBody, searchInput, searchBtn, clearBtn;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

function initializeElements() {
    locationSelect = document.getElementById('location');
    vatidInput = document.getElementById('vatid');
    nameInput = document.getElementById('name');
    flagSelect = document.getElementById('flag');
    submitBtn = document.getElementById('Submit');
    vatTableBody = document.getElementById('vatTableBody');
    searchInput = document.getElementById('searchInput');
    searchBtn = document.getElementById('searchBtn');
    clearBtn = document.getElementById('clearBtn');
}

function setupEventListeners() {
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (searchBtn) {
        searchBtn.addEventListener('click', () => handleSearch(searchInput.value));
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', clearSearch);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce((e) => handleSearch(e.target.value), 300));
    }
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

function initializePagination() {
    if (!vatTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = vatTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allVATRecords = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 5) {
            return {
                auto_number: row.querySelector('a[href*="anum="]')?.getAttribute('href')?.match(/anum=([^&]+)/)?.[1] || '',
                vat_id: cells[1]?.textContent?.trim() || '',
                vat_name: cells[2]?.textContent?.trim() || '',
                flag: cells[3]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredVATRecords = [...allVATRecords];
    applyPagination();
    updatePagination();
}

function applyPagination() {
    if (!vatTableBody) return;
    
    const rows = vatTableBody.querySelectorAll('tr');
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

function updatePagination() {
    const totalPages = Math.ceil(filteredVATRecords.length / itemsPerPage);
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (!paginationContainer) return;
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `<button class="btn btn-outline" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            paginationHTML += `<button class="btn btn-primary" disabled>${i}</button>`;
        } else if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
            paginationHTML += `<button class="btn btn-outline" onclick="changePage(${i})">${i}</button>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
            paginationHTML += `<span class="pagination-ellipsis">...</span>`;
        }
    }
    
    // Next button
    paginationHTML += `<button class="btn btn-outline" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
    
    paginationContainer.innerHTML = paginationHTML;
}

function changePage(page) {
    const totalPages = Math.ceil(filteredVATRecords.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    applyPagination();
    updatePagination();
}

function handleSearch(searchTerm) {
    if (!searchTerm.trim()) {
        filteredVATRecords = [...allVATRecords];
    } else {
        const term = searchTerm.toLowerCase();
        filteredVATRecords = allVATRecords.filter(vat => 
            vat.vat_id.toLowerCase().includes(term) ||
            vat.vat_name.toLowerCase().includes(term) ||
            vat.flag.toLowerCase().includes(term)
        );
    }
    
    currentPage = 1;
    applyPagination();
    updatePagination();
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    filteredVATRecords = [...allVATRecords];
    currentPage = 1;
    applyPagination();
    updatePagination();
}

function handleFormSubmit(event) {
    const location = locationSelect.value;
    const vatid = vatidInput.value.trim();
    const name = nameInput.value.trim();
    const flag = flagSelect.value;
    
    if (!location) {
        alert('Please select a location.');
        event.preventDefault();
        locationSelect.focus();
        return false;
    }
    
    if (!vatid) {
        alert('Please enter a VAT ID.');
        event.preventDefault();
        vatidInput.focus();
        return false;
    }
    
    if (!name) {
        alert('Please enter a VAT name.');
        event.preventDefault();
        nameInput.focus();
        return false;
    }
    
    if (!flag) {
        alert('Please select a flag.');
        event.preventDefault();
        flagSelect.focus();
        return false;
    }
    
    if (name.length > 500) {
        alert('VAT name cannot exceed 500 characters.');
        event.preventDefault();
        return false;
    }
    
    return true;
}

// Search VAT function for inline search
function searchVAT(searchTerm) {
    if (!searchTerm.trim()) {
        // Show all rows
        const rows = vatTableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
        return;
    }
    
    const term = searchTerm.toLowerCase();
    const rows = vatTableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 4) {
            const vatId = cells[1]?.textContent.toLowerCase();
            const vatName = cells[2]?.textContent.toLowerCase();
            const flag = cells[3]?.textContent.toLowerCase();
            if (vatId.includes(term) || vatName.includes(term) || flag.includes(term)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}

// Clear search function for inline search
function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    const rows = vatTableBody.querySelectorAll('tr');
    rows.forEach(row => row.style.display = '');
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

// Export to Excel function
function exportToExcel() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
            // Skip action columns
            if (j === cols.length - 1 && i > 0) continue;
            
            let text = cols[j].innerText.replace(/,/g, ';');
            row.push('"' + text + '"');
        }
        
        csv.push(row.join(','));
    }
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'vat_records_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Reset form function
function resetForm() {
    if (nameInput) {
        nameInput.value = '';
    }
    if (flagSelect) {
        flagSelect.value = '';
    }
    nameInput.focus();
}

// Confirm delete function
function confirmDelete(vatId, autoNumber) {
    if (confirm(`Are you sure you want to delete the VAT record "${vatId}"?`)) {
        window.location.href = `vat.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate function
function confirmActivate(vatId, autoNumber) {
    if (confirm(`Are you sure you want to activate the VAT record "${vatId}"?`)) {
        window.location.href = `vat.php?st=activate&anum=${autoNumber}`;
    }
}

// Utility function for debouncing
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

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Form validation enhancement
if (nameInput && flagSelect) {
    function validateForm() {
        const name = nameInput.value.trim();
        const flag = flagSelect.value;
        const submitBtn = document.getElementById('Submit');
        
        if (name.length > 0 && flag !== '') {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    }
    
    nameInput.addEventListener('input', validateForm);
    flagSelect.addEventListener('change', validateForm);
    
    // Initial validation
    validateForm();
}

// Enhanced flag selection styling
if (flagSelect) {
    flagSelect.addEventListener('change', function() {
        if (this.value) {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.backgroundColor = 'var(--background-primary)';
        } else {
            this.style.borderColor = 'var(--border-color)';
        }
    });
}

// Enhanced name input styling
if (nameInput) {
    nameInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value.length > 0) {
            this.style.borderColor = 'var(--medstar-primary)';
        } else {
            this.style.borderColor = 'var(--border-color)';
        }
    });
}

// Enhanced location selection styling
if (locationSelect) {
    locationSelect.addEventListener('change', function() {
        if (this.value) {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.backgroundColor = 'var(--background-primary)';
        } else {
            this.style.borderColor = 'var(--border-color)';
        }
    });
}

