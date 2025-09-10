// Salutation Master Modern JavaScript
let allSalutations = [];
let filteredSalutations = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let salutationInput, genderSelect, submitBtn, salutationTableBody, searchInput, searchBtn, clearBtn;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

function initializeElements() {
    salutationInput = document.getElementById('salutation');
    genderSelect = document.getElementById('gender');
    submitBtn = document.getElementById('submitBtn');
    salutationTableBody = document.getElementById('salutationTableBody');
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
    if (!salutationTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = salutationTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allSalutations = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 4) {
            return {
                auto_number: row.querySelector('a[href*="anum="]')?.getAttribute('href')?.match(/anum=([^&]+)/)?.[1] || '',
                salutation: cells[1]?.textContent?.trim() || '',
                gender: cells[2]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredSalutations = [...allSalutations];
    applyPagination();
    updatePagination();
}

function applyPagination() {
    if (!salutationTableBody) return;
    
    const rows = salutationTableBody.querySelectorAll('tr');
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
    const totalPages = Math.ceil(filteredSalutations.length / itemsPerPage);
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
    const totalPages = Math.ceil(filteredSalutations.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    applyPagination();
    updatePagination();
}

function handleSearch(searchTerm) {
    if (!searchTerm.trim()) {
        filteredSalutations = [...allSalutations];
    } else {
        const term = searchTerm.toLowerCase();
        filteredSalutations = allSalutations.filter(salutation => 
            salutation.salutation.toLowerCase().includes(term) ||
            salutation.gender.toLowerCase().includes(term)
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
    filteredSalutations = [...allSalutations];
    currentPage = 1;
    applyPagination();
    updatePagination();
}

function handleFormSubmit(event) {
    const salutation = salutationInput.value.trim();
    const gender = genderSelect.value;
    
    if (!salutation) {
        alert('Please enter a salutation.');
        event.preventDefault();
        salutationInput.focus();
        return false;
    }
    
    if (!gender) {
        alert('Please select a gender.');
        event.preventDefault();
        genderSelect.focus();
        return false;
    }
    
    if (salutation.length > 100) {
        alert('Salutation cannot exceed 100 characters.');
        event.preventDefault();
        return false;
    }
    
    return true;
}

// Search salutations function for inline search
function searchSalutations(searchTerm) {
    if (!searchTerm.trim()) {
        // Show all rows
        const rows = salutationTableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
        return;
    }
    
    const term = searchTerm.toLowerCase();
    const rows = salutationTableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 3) {
            const salutationText = cells[1].textContent.toLowerCase();
            const genderText = cells[2].textContent.toLowerCase();
            if (salutationText.includes(term) || genderText.includes(term)) {
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
    const rows = salutationTableBody.querySelectorAll('tr');
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
        link.setAttribute('download', 'salutations_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Reset form function
function resetForm() {
    if (salutationInput) {
        salutationInput.value = '';
    }
    if (genderSelect) {
        genderSelect.value = '';
    }
    salutationInput.focus();
}

// Confirm delete function
function confirmDelete(salutationName, autoNumber) {
    if (confirm(`Are you sure you want to delete the salutation "${salutationName}"?`)) {
        window.location.href = `addsalutation1.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate function
function confirmActivate(salutationName, autoNumber) {
    if (confirm(`Are you sure you want to activate the salutation "${salutationName}"?`)) {
        window.location.href = `addsalutation1.php?st=activate&anum=${autoNumber}`;
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
if (salutationInput && genderSelect) {
    function validateForm() {
        const salutation = salutationInput.value.trim();
        const gender = genderSelect.value;
        const submitBtn = document.getElementById('submitBtn');
        
        if (salutation.length > 0 && gender !== '') {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    }
    
    salutationInput.addEventListener('input', validateForm);
    genderSelect.addEventListener('change', validateForm);
    
    // Initial validation
    validateForm();
}

// Enhanced gender selection styling
if (genderSelect) {
    genderSelect.addEventListener('change', function() {
        if (this.value) {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.backgroundColor = 'var(--background-primary)';
        } else {
            this.style.borderColor = 'var(--border-color)';
        }
    });
}

// Enhanced salutation input styling
if (salutationInput) {
    salutationInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value.length > 0) {
            this.style.borderColor = 'var(--medstar-primary)';
        } else {
            this.style.borderColor = 'var(--border-color)';
        }
    });
}

