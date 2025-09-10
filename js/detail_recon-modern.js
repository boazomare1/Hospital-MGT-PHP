// Detail Recon Report - Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Detail Recon Report - Modern JavaScript loaded');
    
    // Initialize modern features
    initSearchFunctionality();
    initTableInteractivity();
    initFormValidation();
    initResponsiveFeatures();
    initAnimations();
    initSummaryCalculations();
    
    // Show loading completion
    setTimeout(() => {
        document.body.classList.remove('loading');
    }, 500);
});

// Search functionality for the data table
function initSearchFunctionality() {
    const searchInput = document.getElementById('transactionSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            let visibleCount = 0;
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const shouldShow = text.includes(searchTerm);
                row.style.display = shouldShow ? '' : 'none';
                
                // Add highlight effect
                if (shouldShow && searchTerm) {
                    row.classList.add('search-highlight');
                    visibleCount++;
                } else {
                    row.classList.remove('search-highlight');
                    if (shouldShow) visibleCount++;
                }
            });
            
            // Update visible row count
            updateVisibleRowCount(visibleCount, tableRows.length);
        });
    }
}

// Table interactivity
function initTableInteractivity() {
    const table = document.querySelector('.data-table');
    if (table) {
        // Add hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
        
        // Make table headers sortable (basic implementation)
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (index > 0) { // Skip first column (No.)
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => sortTable(index));
                header.title = 'Click to sort';
            }
        });
    }
}

// Form validation
function initFormValidation() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const dateFrom = document.getElementById('ADate1');
            const dateTo = document.getElementById('ADate2');
            
            if (!dateFrom || !dateFrom.value) {
                e.preventDefault();
                showAlert('Please select a "Date From"', 'error');
                return false;
            }
            
            if (!dateTo || !dateTo.value) {
                e.preventDefault();
                showAlert('Please select a "Date To"', 'error');
                return false;
            }
            
            // Show loading indicator
            showLoadingIndicator();
        });
    }
}

// Responsive features
function initResponsiveFeatures() {
    // Mobile table scroll indicator
    const table = document.querySelector('.data-table');
    if (table && window.innerWidth <= 1400) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-scroll-wrapper';
        wrapper.innerHTML = '<div class="scroll-hint">← Scroll horizontally to see more columns →</div>';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    }
    
    // Responsive form adjustments
    window.addEventListener('resize', handleResize);
    handleResize(); // Initial call
}

// Handle window resize
function handleResize() {
    const formRows = document.querySelectorAll('.form-row');
    formRows.forEach(formRow => {
        if (window.innerWidth <= 768) {
            formRow.style.gridTemplateColumns = '1fr';
        } else {
            formRow.style.gridTemplateColumns = '1fr 1fr';
        }
    });
}

// Initialize animations
function initAnimations() {
    // Animate cards
    const cards = document.querySelectorAll('.form-section, .data-table-section');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Fade in table rows with stagger effect
    setTimeout(() => {
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach((row, index) => {
            if (index < 50) { // Only animate first 50 rows for performance
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 30);
            }
        });
    }, 1000);
}

// Initialize summary calculations
function initSummaryCalculations() {
    // Calculate and display summary if data exists
    setTimeout(() => {
        calculateSummary();
    }, 1500);
}

// Calculate summary statistics
function calculateSummary() {
    const table = document.querySelector('.data-table tbody');
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    let totalAmount = 0;
    let transactionCount = 0;
    const departmentTotals = {};
    const locationTotals = {};
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length >= 16) {
            // Amount is typically in column 15 (index 15)
            const amountText = cells[15]?.textContent.trim().replace(/[^0-9.-]/g, '');
            const amount = parseFloat(amountText) || 0;
            totalAmount += amount;
            transactionCount++;
            
            // Department totals
            const department = cells[9]?.textContent.trim() || 'Unknown';
            departmentTotals[department] = (departmentTotals[department] || 0) + amount;
            
            // Location totals
            const location = cells[1]?.textContent.trim() || 'Unknown';
            locationTotals[location] = (locationTotals[location] || 0) + amount;
        }
    });
    
    // Create summary cards if they don't exist
    if (transactionCount > 0) {
        createSummaryCards(totalAmount, transactionCount, departmentTotals, locationTotals);
    }
}

// Create summary cards
function createSummaryCards(totalAmount, transactionCount, departmentTotals, locationTotals) {
    const dataTableSection = document.querySelector('.data-table-section');
    if (!dataTableSection) return;
    
    // Check if summary already exists
    if (document.querySelector('.summary-cards')) return;
    
    const summaryHTML = `
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Total Transactions</h4>
                <div class="amount">${transactionCount.toLocaleString()}</div>
            </div>
            <div class="summary-card">
                <h4>Total Amount</h4>
                <div class="amount">₹${totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
            </div>
            <div class="summary-card">
                <h4>Average Amount</h4>
                <div class="amount">₹${(totalAmount / transactionCount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
            </div>
            <div class="summary-card">
                <h4>Departments</h4>
                <div class="amount">${Object.keys(departmentTotals).length}</div>
            </div>
        </div>
    `;
    
    dataTableSection.insertAdjacentHTML('afterbegin', summaryHTML);
    
    // Animate summary cards
    const summaryCards = document.querySelectorAll('.summary-card');
    summaryCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Utility Functions

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
}

// Get alert icon based on type
function getAlertIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Show loading indicator
function showLoadingIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'loading-overlay';
    indicator.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Processing Report...</p>
        </div>
    `;
    document.body.appendChild(indicator);
}

// Sort table (basic implementation)
function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Determine sort direction
    const currentDirection = table.dataset.sortDirection || 'asc';
    const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
    table.dataset.sortDirection = newDirection;
    
    // Sort rows
    rows.sort((a, b) => {
        const aValue = a.children[columnIndex].textContent.trim();
        const bValue = b.children[columnIndex].textContent.trim();
        
        // Check if values are numeric
        const aNum = parseFloat(aValue.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bValue.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return newDirection === 'asc' ? aNum - bNum : bNum - aNum;
        } else {
            return newDirection === 'asc' 
                ? aValue.localeCompare(bValue)
                : bValue.localeCompare(aValue);
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
    
    // Update header indicators
    const headers = table.querySelectorAll('th');
    headers.forEach(header => header.classList.remove('sort-asc', 'sort-desc'));
    headers[columnIndex].classList.add(`sort-${newDirection}`);
    
    showAlert(`Table sorted by ${headers[columnIndex].textContent} (${newDirection})`, 'info');
}

// Update visible row count
function updateVisibleRowCount(visibleCount, totalCount) {
    let counter = document.getElementById('row-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'row-counter';
        counter.className = 'row-counter';
        const tableHeader = document.querySelector('.table-header');
        if (tableHeader) {
            tableHeader.appendChild(counter);
        }
    }
    
    counter.textContent = `Showing ${visibleCount} of ${totalCount} transactions`;
}

// Refresh page function
function refreshPage() {
    window.location.reload();
}

// Export to Excel function
function exportToExcel() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        // Get form data
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Open excel export URL
        window.open(`detail_recon_xl.php?${params.toString()}`, '_blank');
    } else {
        showAlert('Please search for data first', 'warning');
    }
}

// Global function compatibility
window.refreshPage = refreshPage;
window.exportToExcel = exportToExcel;

// Preserve original functions if they exist
if (typeof ajaxlocationfunction === 'function') {
    window.originalAjaxLocationFunction = ajaxlocationfunction;
}

if (typeof disableEnterKey === 'function') {
    window.originalDisableEnterKey = disableEnterKey;
}

// Add custom CSS for modern features
const customCSS = `
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: slideInDown 0.3s ease;
}

.alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
.alert-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
.alert-warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
.alert-info { background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8; }

.alert-close {
    background: none;
    border: none;
    margin-left: auto;
    cursor: pointer;
    opacity: 0.7;
}

.alert-close:hover { opacity: 1; }

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    text-align: center;
}

.loading-spinner i {
    font-size: 2rem;
    color: #3498db;
    margin-bottom: 1rem;
}

.table-scroll-wrapper {
    position: relative;
    overflow-x: auto;
}

.scroll-hint {
    text-align: center;
    color: #7f8c8d;
    font-size: 0.8rem;
    padding: 0.5rem;
    background: rgba(127, 140, 141, 0.1);
    border-radius: 5px;
    margin-bottom: 0.5rem;
}

.sort-asc::after { content: ' ↑'; }
.sort-desc::after { content: ' ↓'; }

.row-counter {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

@keyframes slideInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
`;

// Inject custom CSS
const styleSheet = document.createElement('style');
styleSheet.textContent = customCSS;
document.head.appendChild(styleSheet);

console.log('Detail Recon Report - Modern JavaScript fully loaded');

