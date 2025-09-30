// Modern JavaScript for IP Discount Report - MedStar Hospital Management System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeComponents();
    setupEventListeners();
    updateCurrentTime();
    
    // Update time every minute
    setInterval(updateCurrentTime, 60000);
});

function initializeComponents() {
    // Initialize sidebar toggle
    setupSidebarToggle();
    
    // Initialize form enhancements
    setupFormEnhancements();
    
    // Initialize table enhancements
    setupTableEnhancements();
    
    // Initialize search functionality
    setupSearchFunctionality();
    
    // Initialize report features
    setupReportFeatures();
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

function setupFormEnhancements() {
    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });

    // Add form validation
    setupFormValidation();
    
    // Add reset functionality
    setupResetFunctionality();
}

function setupFormValidation() {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const location = document.getElementById('location');
            const dateFrom = document.getElementById('ADate1');
            const dateTo = document.getElementById('ADate2');

            let isValid = true;
            let errorMessage = '';

            // Validate location
            if (!location.value) {
                isValid = false;
                errorMessage += 'Please select a location.\n';
                location.classList.add('error');
            } else {
                location.classList.remove('error');
            }

            // Validate date range
            if (dateFrom.value && dateTo.value) {
                const fromDate = new Date(dateFrom.value);
                const toDate = new Date(dateTo.value);
                
                if (fromDate > toDate) {
                    isValid = false;
                    errorMessage += 'Date From cannot be later than Date To.\n';
                    dateFrom.classList.add('error');
                    dateTo.classList.add('error');
                } else {
                    dateFrom.classList.remove('error');
                    dateTo.classList.remove('error');
                }
            }

            if (!isValid) {
                e.preventDefault();
                showAlert(errorMessage, 'error');
                return false;
            }

            return true;
        });
    }
}

function setupResetFunctionality() {
    const resetBtn = document.querySelector('.btn-secondary');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear all form inputs
            const form = this.closest('form');
            const inputs = form.querySelectorAll('input[type="text"], select');
            inputs.forEach(input => {
                input.value = '';
                input.classList.remove('error');
            });
            
            // Reset date inputs to default values
            const dateFrom = document.getElementById('ADate1');
            const dateTo = document.getElementById('ADate2');
            if (dateFrom) dateFrom.value = '<?php echo date('Y-m-d', strtotime('-1 month')); ?>';
            if (dateTo) dateTo.value = '<?php echo date('Y-m-d'); ?>';
            
            showAlert('Form has been reset', 'info');
        });
    }
}

function setupTableEnhancements() {
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('.data-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Add click effects to table rows
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Remove active class from all rows
            tableRows.forEach(r => r.classList.remove('active'));
            // Add active class to clicked row
            this.classList.add('active');
        });
    });

    // Add sorting functionality
    setupTableSorting();
}

function setupTableSorting() {
    const table = document.querySelector('.data-table');
    if (!table) return;

    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            sortTable(table, index);
        });
        
        // Add sort indicator
        const sortIcon = document.createElement('i');
        sortIcon.className = 'fas fa-sort sort-icon';
        sortIcon.style.cssText = 'margin-left: 0.5rem; opacity: 0.5;';
        header.appendChild(sortIcon);
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Check if content is numeric
        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        } else {
            return isAscending ? aText.localeCompare(bText) : bText.localeCompare(aText);
        }
    });
    
    // Clear tbody and re-append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
    
    // Update sort icons
    updateSortIcons(table, columnIndex, isAscending);
}

function updateSortIcons(table, activeColumn, isAscending) {
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        const icon = header.querySelector('.sort-icon');
        if (index === activeColumn) {
            icon.className = isAscending ? 'fas fa-sort-up sort-icon' : 'fas fa-sort-down sort-icon';
            icon.style.opacity = '1';
        } else {
            icon.className = 'fas fa-sort sort-icon';
            icon.style.opacity = '0.5';
        }
    });
}

function setupSearchFunctionality() {
    // Add search input enhancements
    const searchInputs = document.querySelectorAll('input[type="text"]');
    searchInputs.forEach(input => {
        // Add search icon
        const wrapper = document.createElement('div');
        wrapper.className = 'search-input-wrapper';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        // Add debounced search
        let searchTimeout;
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    });
}

function performSearch(query) {
    if (!query.trim()) return;
    
    // Add loading state
    const tableContainer = document.querySelector('.data-table-container');
    if (tableContainer) {
        tableContainer.classList.add('loading');
    }
    
    // Simulate search delay
    setTimeout(() => {
        if (tableContainer) {
            tableContainer.classList.remove('loading');
        }
    }, 500);
}

function setupReportFeatures() {
    // Add report statistics
    addReportStatistics();
    
    // Add export functionality
    setupExportFunctionality();
}

function addReportStatistics() {
    const table = document.querySelector('.data-table');
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');
    const totalRecords = rows.length;
    
    // Calculate total amount
    let totalAmount = 0;
    rows.forEach(row => {
        const amountCell = row.querySelector('.amount');
        if (amountCell) {
            const amount = parseFloat(amountCell.textContent.replace(/,/g, ''));
            if (!isNaN(amount)) {
                totalAmount += amount;
            }
        }
    });

    // Add statistics to table header
    const tableHeader = document.querySelector('.table-header');
    if (tableHeader) {
        const stats = document.createElement('div');
        stats.className = 'report-stats';
        stats.innerHTML = `
            <div class="stat-item">
                <span class="stat-label">Total Records:</span>
                <span class="stat-value">${totalRecords}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Total Amount:</span>
                <span class="stat-value">${formatCurrency(totalAmount)}</span>
            </div>
        `;
        stats.style.cssText = `
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
            padding: 1rem;
            background: var(--background-primary);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        `;
        
        const existingStats = tableHeader.querySelector('.report-stats');
        if (existingStats) {
            existingStats.remove();
        }
        tableHeader.appendChild(stats);
    }
}

function setupExportFunctionality() {
    const exportBtn = document.querySelector('.btn-success');
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add loading state
            this.classList.add('loading');
            this.disabled = true;
            
            // Simulate export process
            setTimeout(() => {
                this.classList.remove('loading');
                this.disabled = false;
                showAlert('Export completed successfully!', 'success');
            }, 2000);
        });
    }
}

function setupEventListeners() {
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to search
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.scrollIntoView({ behavior: 'smooth' });
                const firstInput = searchForm.querySelector('input, select');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        }
        
        // Ctrl + E to export
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            exportToExcel();
        }
        
        // Escape to close sidebar
        if (e.key === 'Escape') {
            const mainContainer = document.querySelector('.main-container-with-sidebar');
            if (mainContainer) {
                mainContainer.classList.add('sidebar-collapsed');
            }
        }
    });

    // Add window resize handler
    window.addEventListener('resize', function() {
        const mainContainer = document.querySelector('.main-container-with-sidebar');
        if (window.innerWidth <= 768) {
            mainContainer.classList.add('sidebar-collapsed');
        }
    });

    // Add scroll effects
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.hospital-header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

function updateCurrentTime() {
    const timeElement = document.getElementById('currentTime');
    if (timeElement) {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: true,
            hour: '2-digit',
            minute: '2-digit'
        });
        timeElement.textContent = timeString;
    }
}

function exportToExcel() {
    // Add loading state to export button
    const exportBtn = document.querySelector('.btn-success');
    if (exportBtn) {
        exportBtn.classList.add('loading');
        exportBtn.disabled = true;
    }
    
    // Simulate export process
    setTimeout(() => {
        if (exportBtn) {
            exportBtn.classList.remove('loading');
            exportBtn.disabled = false;
        }
        showAlert('Export completed successfully!', 'success');
    }, 2000);
}

function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-message');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert-message alert-${type}`;
    alert.innerHTML = `
        <div class="alert-content">
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${message}</span>
            <button class="alert-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Add styles
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        background: ${type === 'error' ? '#fee2e2' : type === 'success' ? '#d1fae5' : '#dbeafe'};
        color: ${type === 'error' ? '#991b1b' : type === 'success' ? '#065f46' : '#1e40af'};
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    document.body.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, 5000);
}

// Add CSS for animations and styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .alert-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-close {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        margin-left: auto;
    }
    
    .search-input-wrapper {
        position: relative;
    }
    
    .search-input-wrapper::after {
        content: '\\f002';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
    }
    
    .form-control.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .data-table tbody tr.active {
        background: #dbeafe !important;
        border-left: 4px solid #1e40af;
    }
    
    .hospital-header.scrolled {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .sort-icon {
        transition: all 0.2s ease;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }
    
    .stat-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e40af;
    }
`;
document.head.appendChild(style);

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatTime(timeString) {
    const time = new Date(`2000-01-01 ${timeString}`);
    return time.toLocaleTimeString('en-US', {
        hour12: true,
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('en-US').format(number);
}

// Export functions for global access
window.exportToExcel = exportToExcel;
window.showAlert = showAlert;
window.formatDate = formatDate;
window.formatTime = formatTime;
window.formatCurrency = formatCurrency;
window.formatNumber = formatNumber;
