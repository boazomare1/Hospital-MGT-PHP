// Lab Test By Date Report Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeDatePickers();
    initializeFormValidation();
    initializeSearch();
    initializeExport();
    initializeSummaryCards();
});

// Sidebar functionality
function initializeSidebar() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const floatingToggle = document.querySelector('.floating-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (floatingToggle) {
        floatingToggle.addEventListener('click', toggleSidebar);
    }
    
    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
    }
}

// Date picker initialization
function initializeDatePickers() {
    // Initialize date pickers if datetimepicker is available
    if (typeof $.fn.datetimepicker !== 'undefined') {
        $('.date-picker').datetimepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1
        });
    }
}

// Form validation
function initializeFormValidation() {
    const form = document.querySelector('form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
    
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'This field is required');
                isValid = false;
            } else {
                clearFieldError(field);
            }
        });
        
        // Validate date range
        const fromDate = document.querySelector('input[name="fromdate"]');
        const toDate = document.querySelector('input[name="todate"]');
        
        if (fromDate && toDate && fromDate.value && toDate.value) {
            const fromDateObj = new Date(fromDate.value.split('-').reverse().join('-'));
            const toDateObj = new Date(toDate.value.split('-').reverse().join('-'));
            
            if (fromDateObj > toDateObj) {
                showFieldError(fromDate, 'From date cannot be greater than To date');
                isValid = false;
            }
        }
        
        return isValid;
    }
    
    function showFieldError(field, message) {
        clearFieldError(field);
        field.style.borderColor = '#e74c3c';
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.color = '#e74c3c';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.marginTop = '0.25rem';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
    
    function clearFieldError(field) {
        field.style.borderColor = '';
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchInput && searchBtn) {
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            // Add loading state
            searchBtn.classList.add('loading');
            searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            
            // Filter table rows
            const table = document.querySelector('.data-table');
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                let visibleCount = 0;
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm.toLowerCase())) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show no results message if needed
                showNoResultsMessage(visibleCount === 0);
            }
            
            // Reset button state
            setTimeout(() => {
                searchBtn.classList.remove('loading');
                searchBtn.innerHTML = '<i class="fas fa-search"></i> Search';
            }, 1000);
        }
    }
    
    function showNoResultsMessage(show) {
        let noResults = document.querySelector('.no-results-message');
        
        if (show && !noResults) {
            noResults = document.createElement('div');
            noResults.className = 'no-results-message';
            noResults.style.textAlign = 'center';
            noResults.style.padding = '2rem';
            noResults.style.color = 'var(--text-secondary)';
            noResults.innerHTML = '<i class="fas fa-search" style="font-size: 2rem; margin-bottom: 1rem; color: var(--border-color);"></i><h3>No results found</h3><p>Try adjusting your search criteria</p>';
            
            const table = document.querySelector('.data-table');
            if (table) {
                table.parentNode.appendChild(noResults);
            }
        } else if (!show && noResults) {
            noResults.remove();
        }
    }
}

// Export functionality
function initializeExport() {
    const exportBtn = document.querySelector('.export-btn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            exportToExcel();
        });
    }
    
    function exportToExcel() {
        const table = document.querySelector('.data-table');
        if (!table) return;
        
        // Add loading state
        const originalText = exportBtn.innerHTML;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
        exportBtn.disabled = true;
        
        // Create workbook
        const wb = XLSX.utils.table_to_book(table, {sheet: "Lab Test Report"});
        
        // Generate filename with current date
        const today = new Date();
        const dateStr = today.toISOString().split('T')[0];
        const filename = `lab_test_report_${dateStr}.xlsx`;
        
        // Download file
        XLSX.writeFile(wb, filename);
        
        // Reset button state
        setTimeout(() => {
            exportBtn.innerHTML = originalText;
            exportBtn.disabled = false;
        }, 1000);
    }
}

// Summary cards functionality
function initializeSummaryCards() {
    updateSummaryCards();
}

function updateSummaryCards() {
    const table = document.querySelector('.data-table');
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');
    let totalTests = 0;
    let completedTests = 0;
    let pendingTests = 0;
    let totalRevenue = 0;
    
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            totalTests++;
            
            // Count completed tests (assuming status column)
            const statusCell = row.querySelector('td:nth-child(6)'); // Adjust index as needed
            if (statusCell && statusCell.textContent.toLowerCase().includes('completed')) {
                completedTests++;
            } else {
                pendingTests++;
            }
            
            // Calculate revenue (assuming amount column)
            const amountCell = row.querySelector('td:nth-child(5)'); // Adjust index as needed
            if (amountCell) {
                const amount = parseFloat(amountCell.textContent.replace(/[^\d.-]/g, '')) || 0;
                totalRevenue += amount;
            }
        }
    });
    
    // Update summary cards
    updateSummaryCard('total-tests', totalTests);
    updateSummaryCard('completed-tests', completedTests);
    updateSummaryCard('pending-tests', pendingTests);
    updateSummaryCard('total-revenue', totalRevenue, true);
}

function updateSummaryCard(cardId, value, isCurrency = false) {
    const card = document.getElementById(cardId);
    if (card) {
        const valueElement = card.querySelector('.summary-card-value');
        if (valueElement) {
            if (isCurrency) {
                valueElement.textContent = formatCurrency(value);
            } else {
                valueElement.textContent = value.toLocaleString();
            }
        }
    }
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR'
    }).format(amount);
}

function showAlert(message, type = 'success') {
    const alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Initialize all components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Additional initialization can be added here
});
