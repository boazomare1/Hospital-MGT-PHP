// Promotion Master Modern JavaScript
let allPromotions = [];
let filteredPromotions = [];
let currentPage = 1;
const itemsPerPage = 10;

// DOM Elements
let promotionInput, submitBtn, promotionTableBody, searchInput, searchBtn, clearBtn;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializePagination();
});

function initializeElements() {
    promotionInput = document.getElementById('promotion');
    submitBtn = document.getElementById('Submit');
    promotionTableBody = document.getElementById('promotionTableBody');
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
    if (!promotionTableBody) return;
    
    // Get all existing rows from the PHP-generated table
    const existingRows = promotionTableBody.querySelectorAll('tr');
    
    // Convert existing rows to data objects
    allPromotions = Array.from(existingRows).map((row, index) => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 3) {
            return {
                auto_number: row.querySelector('a[href*="anum="]')?.getAttribute('href')?.match(/anum=([^&]+)/)?.[1] || '',
                promotion: cells[1]?.textContent?.trim() || '',
                index: index
            };
        }
        return null;
    }).filter(item => item !== null);
    
    filteredPromotions = [...allPromotions];
    applyPagination();
    updatePagination();
}

function applyPagination() {
    if (!promotionTableBody) return;
    
    const rows = promotionTableBody.querySelectorAll('tr');
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
    const totalPages = Math.ceil(filteredPromotions.length / itemsPerPage);
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
    const totalPages = Math.ceil(filteredPromotions.length / itemsPerPage);
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    applyPagination();
    updatePagination();
}

function handleSearch(searchTerm) {
    if (!searchTerm.trim()) {
        filteredPromotions = [...allPromotions];
    } else {
        const term = searchTerm.toLowerCase();
        filteredPromotions = allPromotions.filter(promotion => 
            promotion.promotion.toLowerCase().includes(term)
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
    filteredPromotions = [...allPromotions];
    currentPage = 1;
    applyPagination();
    updatePagination();
}

function handleFormSubmit(event) {
    const promotion = promotionInput.value.trim();
    
    if (!promotion) {
        alert('Please enter a promotion name.');
        event.preventDefault();
        return false;
    }
    
    if (promotion.length > 100) {
        alert('Promotion name cannot exceed 100 characters.');
        event.preventDefault();
        return false;
    }
    
    return true;
}

// Search promotions function for inline search
function searchPromotions(searchTerm) {
    if (!searchTerm.trim()) {
        // Show all rows
        const rows = promotionTableBody.querySelectorAll('tr');
        rows.forEach(row => row.style.display = '');
        return;
    }
    
    const term = searchTerm.toLowerCase();
    const rows = promotionTableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 2) {
            const promotionName = cells[1].textContent.toLowerCase();
            if (promotionName.includes(term)) {
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
    const rows = promotionTableBody.querySelectorAll('tr');
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
        link.setAttribute('download', 'promotions_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Reset form function
function resetForm() {
    if (promotionInput) {
        promotionInput.value = '';
    }
    promotionInput.focus();
}

// Confirm delete function
function confirmDelete(promotionName, autoNumber) {
    if (confirm(`Are you sure you want to delete the promotion "${promotionName}"?`)) {
        window.location.href = `addpromotion.php?st=del&anum=${autoNumber}`;
    }
}

// Confirm activate function
function confirmActivate(promotionName, autoNumber) {
    if (confirm(`Are you sure you want to activate the promotion "${promotionName}"?`)) {
        window.location.href = `addpromotion.php?st=activate&anum=${autoNumber}`;
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
if (promotionInput) {
    promotionInput.addEventListener('input', function() {
        const value = this.value.trim();
        const submitBtn = document.getElementById('submitBtn');
        
        if (value.length > 0 && value.length <= 100) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
        }
    });
}

