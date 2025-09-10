// IP Admission Summary Report Modern JavaScript

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    setupSidebarToggle();
    setupEventListeners();
    initializeSearch();
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
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--medstar-primary)';
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.style.borderColor = 'var(--border-color)';
            }
        });
    });
    
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = 'var(--medstar-primary)';
                this.style.backgroundColor = 'var(--background-primary)';
            } else {
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
    const table = document.getElementById('admissionTable');
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
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    const table = document.getElementById('admissionTable');
    if (table) {
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
        updateRowNumbers();
    }
}

function updateRowNumbers() {
    const table = document.getElementById('admissionTable');
    if (!table) return;
    
    const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => 
        row.style.display !== 'none'
    );
    
    visibleRows.forEach((row, index) => {
        const firstCell = row.querySelector('td:first-child div');
        if (firstCell) {
            firstCell.textContent = index + 1;
        }
    });
}

function refreshPage() {
    window.location.reload();
}

function exportToExcel() {
    const table = document.getElementById('admissionTable');
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
        link.setAttribute('download', 'ip_admission_summary_report.csv');
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

// Form validation
function validateForm() {
    const dateFrom = document.getElementById('ADate1');
    const dateTo = document.getElementById('ADate2');
    
    if (!dateFrom.value || !dateTo.value) {
        alert('Please select both start and end dates.');
        return false;
    }
    
    const startDate = new Date(dateFrom.value);
    const endDate = new Date(dateTo.value);
    
    if (startDate > endDate) {
        alert('Start date cannot be after end date.');
        return false;
    }
    
    return true;
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

// Initialize enhanced form styling
document.addEventListener('DOMContentLoaded', function() {
    enhanceFormStyling();
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

// Enhanced table interactions
function enhanceTableInteractions() {
    const table = document.getElementById('admissionTable');
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

// Initialize table enhancements
document.addEventListener('DOMContentLoaded', function() {
    enhanceTableInteractions();
});

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

// Initialize responsive table handling
document.addEventListener('DOMContentLoaded', function() {
    handleResponsiveTable();
});

// Print functionality
function printReport() {
    window.print();
}

// Export to PDF (placeholder for future implementation)
function exportToPDF() {
    alert('PDF export functionality will be implemented in the next version.');
}

// Enhanced date picker functionality
function enhanceDatePickers() {
    const dateInputs = document.querySelectorAll('.date-input');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = 'var(--medstar-primary)';
                this.style.backgroundColor = 'var(--background-primary)';
            }
        });
    });
}

// Initialize date picker enhancements
document.addEventListener('DOMContentLoaded', function() {
    enhanceDatePickers();
});

// Summary statistics calculation
function calculateSummaryStats() {
    const table = document.getElementById('admissionTable');
    if (!table) return;
    
    const visibleRows = Array.from(table.querySelectorAll('tbody tr')).filter(row => 
        row.style.display !== 'none'
    );
    
    // Update summary if summary section exists
    const summarySection = document.querySelector('.summary-section');
    if (summarySection) {
        const visitCount = visibleRows.length;
        const visitCountElement = summarySection.querySelector('.summary-value');
        if (visitCountElement) {
            visitCountElement.textContent = visitCount;
        }
    }
}

// Initialize summary statistics
document.addEventListener('DOMContentLoaded', function() {
    calculateSummaryStats();
});

// Enhanced search with filters
function advancedSearch() {
    const searchInput = document.getElementById('searchInput');
    const locationSelect = document.getElementById('location');
    const wardSelect = document.getElementById('ward');
    
    if (!searchInput || !locationSelect || !wardSelect) return;
    
    const searchTerm = searchInput.value.toLowerCase().trim();
    const locationFilter = locationSelect.value;
    const wardFilter = wardSelect.value;
    
    const table = document.getElementById('admissionTable');
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
        
        // Location filter
        if (locationFilter !== 'All' && locationFilter !== '') {
            const locationCell = cells[1]; // Location is in second column
            if (locationCell && !locationCell.textContent.includes(locationFilter)) {
                shouldShow = false;
            }
        }
        
        // Ward filter
        if (wardFilter !== '') {
            const wardCell = cells[11]; // Ward is in 12th column
            if (wardCell && !wardCell.textContent.includes(wardFilter)) {
                shouldShow = false;
            }
        }
        
        row.style.display = shouldShow ? '' : 'none';
    });
    
    updateRowNumbers();
    calculateSummaryStats();
}

// Initialize advanced search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const locationSelect = document.getElementById('location');
    const wardSelect = document.getElementById('ward');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(advancedSearch, 300));
    }
    
    if (locationSelect) {
        locationSelect.addEventListener('change', advancedSearch);
    }
    
    if (wardSelect) {
        wardSelect.addEventListener('change', advancedSearch);
    }
});

