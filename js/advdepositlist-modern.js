// Advance Deposit List Modern JavaScript

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupEventListeners();
    initializeSearch();
    enhanceFormStyling();
    enhanceTableInteractions();
    handleResponsiveTable();
});

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

function setupEventListeners() {
    // Add any additional event listeners here
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.boxShadow = '0 0 0 3px rgba(30, 64, 175, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.boxShadow = 'none';
            if (!this.value && this.tagName !== 'SELECT') {
                this.style.borderColor = 'var(--border-color)';
            }
        });
    });
}

function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            searchTable(this.value);
        }, 300));
    }
}

function searchTable(searchTerm) {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    const term = searchTerm.toLowerCase().trim();
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let shouldShow = false;
        
        if (term === '') {
            shouldShow = true;
        } else {
            cells.forEach(cell => {
                const text = cell.textContent.toLowerCase();
                if (text.includes(term)) {
                    shouldShow = true;
                }
            });
        }
        
        row.style.display = shouldShow ? '' : 'none';
    });
    
    updateRowNumbers();
    updateSummaryStats();
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    const table = document.getElementById('depositTable');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        updateRowNumbers();
        updateSummaryStats();
    }
}

function updateRowNumbers() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => 
        row.style.display !== 'none'
    );
    
    visibleRows.forEach((row, index) => {
        const firstCell = row.querySelector('td:first-child');
        if (firstCell) {
            firstCell.textContent = index + 1;
        }
    });
}

function updateSummaryStats() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => 
        row.style.display !== 'none'
    );
    
    // Update summary if summary section exists
    const summarySection = document.querySelector('.summary-section');
    if (summarySection) {
        const patientCount = visibleRows.length;
        const patientCountElement = summarySection.querySelector('.summary-value:last-child');
        if (patientCountElement) {
            patientCountElement.textContent = patientCount;
        }
    }
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll('td, th');
        
        for (let j = 0; j < cols.length; j++) {
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
        link.setAttribute('download', 'advance_deposit_list.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
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

// Enhanced form styling
function enhanceFormStyling() {
    const form = document.querySelector('.search-form');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--medstar-primary)';
            this.style.boxShadow = '0 0 0 3px rgba(30, 64, 175, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.boxShadow = 'none';
            if (!this.value && this.tagName !== 'SELECT') {
                this.style.borderColor = 'var(--border-color)';
            }
        });
    });
}

// Enhanced table interactions
function enhanceTableInteractions() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// Responsive table handling
function handleResponsiveTable() {
    const tableContainer = document.querySelector('.table-container');
    if (!tableContainer) return;
    
    let isScrolling = false;
    let startX;
    let scrollLeft;
    
    tableContainer.addEventListener('mousedown', (e) => {
        isScrolling = true;
        startX = e.pageX - tableContainer.offsetLeft;
        scrollLeft = tableContainer.scrollLeft;
    });
    
    tableContainer.addEventListener('mouseleave', () => {
        isScrolling = false;
    });
    
    tableContainer.addEventListener('mouseup', () => {
        isScrolling = false;
    });
    
    tableContainer.addEventListener('mousemove', (e) => {
        if (!isScrolling) return;
        e.preventDefault();
        const x = e.pageX - tableContainer.offsetLeft;
        const walk = (x - startX) * 2;
        tableContainer.scrollLeft = scrollLeft - walk;
    });
}

// Print functionality
function printReport() {
    window.print();
}

// Export to PDF (placeholder for future implementation)
function exportToPDF() {
    alert('PDF export functionality will be implemented in the next version.');
}

// Enhanced search with filters
function advancedSearch() {
    const searchInput = document.getElementById('searchInput');
    const customerInput = document.getElementById('customer');
    
    if (!searchInput || !customerInput) return;
    
    const searchTerm = searchInput.value.toLowerCase().trim();
    const customerFilter = customerInput.value.toLowerCase().trim();
    
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let shouldShow = true;
        
        // Text search
        if (searchTerm !== '') {
            let textMatch = false;
            cells.forEach(cell => {
                const text = cell.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    textMatch = true;
                }
            });
            if (!textMatch) shouldShow = false;
        }
        
        // Customer filter (if customer search is active)
        if (customerFilter !== '') {
            const patientNameCell = cells[1]; // Patient name is in second column
            if (patientNameCell && !patientNameCell.textContent.toLowerCase().includes(customerFilter)) {
                shouldShow = false;
            }
        }
        
        row.style.display = shouldShow ? '' : 'none';
    });
    
    updateRowNumbers();
    updateSummaryStats();
}

// Initialize advanced search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const customerInput = document.getElementById('customer');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(advancedSearch, 300));
    }
    
    if (customerInput) {
        customerInput.addEventListener('input', debounce(advancedSearch, 300));
    }
});

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

// Enhanced amount formatting
function formatAmount(amount) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// Update amount displays with proper formatting
function updateAmountDisplays() {
    const amountCells = document.querySelectorAll('.amount-badge');
    amountCells.forEach(cell => {
        const amount = parseFloat(cell.textContent.replace(/[^\d.-]/g, ''));
        if (!isNaN(amount)) {
            cell.textContent = formatAmount(amount);
        }
    });
}

// Initialize amount formatting
document.addEventListener('DOMContentLoaded', function() {
    updateAmountDisplays();
});

// Enhanced table sorting (optional feature)
function sortTable(columnIndex, type = 'text') {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        if (type === 'number') {
            const aNum = parseFloat(aValue.replace(/[^\d.-]/g, '')) || 0;
            const bNum = parseFloat(bValue.replace(/[^\d.-]/g, '')) || 0;
            return aNum - bNum;
        } else {
            return aValue.localeCompare(bValue);
        }
    });
    
    // Reorder rows
    rows.forEach(row => tbody.appendChild(row));
    updateRowNumbers();
}

// Add sorting functionality to table headers
function addTableSorting() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            let type = 'text';
            if (index === 3 || index === 4) { // Amount columns
                type = 'number';
            }
            sortTable(index, type);
        });
        
        // Add sort indicator
        header.innerHTML += ' <i class="fas fa-sort" style="opacity: 0.5;"></i>';
    });
}

// Initialize table sorting
document.addEventListener('DOMContentLoaded', function() {
    addTableSorting();
});

// Enhanced keyboard navigation
function setupKeyboardNavigation() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    table.addEventListener('keydown', (e) => {
        const activeElement = document.activeElement;
        const currentRow = activeElement.closest('tr');
        
        if (!currentRow) return;
        
        let nextRow;
        
        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    nextRow.focus();
                }
                break;
            case 'ArrowUp':
                e.preventDefault();
                nextRow = currentRow.previousElementSibling;
                if (nextRow) {
                    nextRow.focus();
                }
                break;
            case 'Enter':
                e.preventDefault();
                const actionBtn = currentRow.querySelector('.action-btn');
                if (actionBtn) {
                    actionBtn.click();
                }
                break;
        }
    });
}

// Initialize keyboard navigation
document.addEventListener('DOMContentLoaded', function() {
    setupKeyboardNavigation();
});

// Enhanced accessibility
function enhanceAccessibility() {
    const table = document.getElementById('depositTable');
    if (!table) return;
    
    // Add ARIA labels
    table.setAttribute('role', 'table');
    table.setAttribute('aria-label', 'Advance Deposit List');
    
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.setAttribute('scope', 'col');
        header.setAttribute('aria-sort', 'none');
    });
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach((row, rowIndex) => {
        row.setAttribute('role', 'row');
        row.setAttribute('tabindex', '0');
        row.setAttribute('aria-label', `Row ${rowIndex + 1}`);
        
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, cellIndex) => {
            cell.setAttribute('role', 'cell');
            if (cellIndex === 0) { // Row number
                cell.setAttribute('aria-label', `Row ${rowIndex + 1}`);
            }
        });
    });
}

// Initialize accessibility enhancements
document.addEventListener('DOMContentLoaded', function() {
    enhanceAccessibility();
});

