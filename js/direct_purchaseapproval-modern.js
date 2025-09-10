// Direct Purchase Approval - Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Direct Purchase Approval - Modern JavaScript loaded');
    
    // Initialize modern features
    initSearchFunctionality();
    initTableInteractivity();
    initFormValidation();
    initApprovalFunctionality();
    initResponsiveFeatures();
    initAnimations();
    
    // Show loading completion
    setTimeout(() => {
        document.body.classList.remove('loading');
    }, 500);
});

// Search functionality
function initSearchFunctionality() {
    const searchInput = document.getElementById('requestSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const purchaseCards = document.querySelectorAll('.purchase-card');
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            let visibleCount = 0;
            
            // Search through cards
            purchaseCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const shouldShow = text.includes(searchTerm);
                card.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow && searchTerm) {
                    card.classList.add('search-highlight');
                    visibleCount++;
                } else {
                    card.classList.remove('search-highlight');
                    if (shouldShow) visibleCount++;
                }
            });
            
            // Search through table rows
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const shouldShow = text.includes(searchTerm);
                row.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow && searchTerm) {
                    row.classList.add('search-highlight');
                } else {
                    row.classList.remove('search-highlight');
                }
            });
            
            // Update visible count
            updateVisibleCount(purchaseCards.length > 0 ? visibleCount : tableRows.length);
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
        
        // Make table headers sortable
        const headers = table.querySelectorAll('th');
        headers.forEach((header, index) => {
            if (index > 0) { // Skip first column
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
            const location = document.getElementById('location');
            
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
            
            if (!location || !location.value) {
                e.preventDefault();
                showAlert('Please select a location', 'error');
                return false;
            }
            
            // Show loading indicator
            showLoadingIndicator();
        });
    }
}

// Approval functionality
function initApprovalFunctionality() {
    // Handle approval checkboxes
    const approvalCheckboxes = document.querySelectorAll('.approval-checkbox');
    approvalCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.purchase-card');
            if (card) {
                if (this.checked) {
                    card.classList.add('selected-for-approval');
                    card.style.borderLeftColor = '#28a745';
                } else {
                    card.classList.remove('selected-for-approval');
                    card.style.borderLeftColor = '#3498db';
                }
            }
            
            updateApprovalCount();
        });
    });
    
    // Handle approval form submission
    const approvalForm = document.querySelector('form[name="form11"]');
    if (approvalForm) {
        approvalForm.addEventListener('submit', function(e) {
            const selectedCheckboxes = document.querySelectorAll('.approval-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                e.preventDefault();
                showAlert('Please select at least one purchase request to approve', 'warning');
                return false;
            }
            
            // Confirm approval
            if (!confirm(`Are you sure you want to approve ${selectedCheckboxes.length} purchase request(s)?`)) {
                e.preventDefault();
                return false;
            }
            
            showLoadingIndicator();
        });
    }
    
    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const approvalCheckboxes = document.querySelectorAll('.approval-checkbox');
            approvalCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    }
}

// Update approval count
function updateApprovalCount() {
    const selectedCheckboxes = document.querySelectorAll('.approval-checkbox:checked');
    const totalCheckboxes = document.querySelectorAll('.approval-checkbox');
    
    let counter = document.getElementById('approval-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'approval-counter';
        counter.className = 'approval-counter';
        const tableHeader = document.querySelector('.table-header');
        if (tableHeader) {
            tableHeader.appendChild(counter);
        }
    }
    
    counter.textContent = `Selected: ${selectedCheckboxes.length} of ${totalCheckboxes.length}`;
}

// Responsive features
function initResponsiveFeatures() {
    // Mobile table scroll indicator
    const table = document.querySelector('.data-table');
    if (table && window.innerWidth <= 768) {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-scroll-wrapper';
        wrapper.innerHTML = '<div class="scroll-hint">← Scroll to see more →</div>';
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
    const cards = document.querySelectorAll('.form-section, .data-table-section, .purchase-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Fade in table rows
    setTimeout(() => {
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach((row, index) => {
            if (index < 20) { // Only animate first 20 rows for performance
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            }
        });
    }, 1000);
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
            <p>Processing Request...</p>
        </div>
    `;
    document.body.appendChild(indicator);
}

// Sort table
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
}

// Update visible count
function updateVisibleCount(count) {
    let counter = document.getElementById('visible-counter');
    if (!counter) {
        counter = document.createElement('div');
        counter.id = 'visible-counter';
        counter.className = 'visible-counter';
        const tableHeader = document.querySelector('.table-header');
        if (tableHeader) {
            tableHeader.appendChild(counter);
        }
    }
    
    counter.textContent = `Showing ${count} items`;
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
        
        // Open excel export URL (you may need to create this)
        window.open(`direct_purchaseapproval_excel.php?${params.toString()}`, '_blank');
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

// Enhanced ajaxlocationfunction
window.ajaxlocationfunction = function(val) {
    // Call original function if it exists
    if (typeof originalAjaxLocationFunction === 'function') {
        originalAjaxLocationFunction(val);
    }
    
    // Update current location display
    setTimeout(() => {
        const locationSpan = document.getElementById('ajaxlocation');
        if (locationSpan) {
            const select = document.getElementById('location');
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.value !== 'All') {
                locationSpan.textContent = selectedOption.text;
            }
        }
    }, 1000);
};

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

.selected-for-approval {
    background: rgba(40, 167, 69, 0.1) !important;
    border-left-color: #28a745 !important;
}

.search-highlight {
    background-color: rgba(255, 235, 59, 0.3) !important;
}

.approval-counter, .visible-counter {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

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
}

.sort-asc::after { content: ' ↑'; }
.sort-desc::after { content: ' ↓'; }

@keyframes slideInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
`;

// Inject custom CSS
const styleSheet = document.createElement('style');
styleSheet.textContent = customCSS;
document.head.appendChild(styleSheet);

console.log('Direct Purchase Approval - Modern JavaScript fully loaded');

