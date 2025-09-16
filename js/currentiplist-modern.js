/**
 * Modern JavaScript for Current IP List
 */

class CurrentIPListManager {
    constructor() {
        this.form = null;
        this.searchInputs = [];
        this.dataTable = null;
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.initializeSidebar();
        this.initializeDataTable();
    }

    initializeElements() {
        this.form = document.getElementById('searchForm');
        this.searchInputs = document.querySelectorAll('.form-input, .form-select');
        this.dataTable = document.getElementById('dataTable');
    }

    setupEventListeners() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleFormSubmit(e));
        }

        // Search inputs with debouncing
        this.searchInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.debounce(() => {
                    this.performSearch();
                }, 300)();
            });
        });

        // Date inputs
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', () => {
                this.validateDateRange();
            });
        });
    }

    initializeSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const leftSidebar = document.getElementById('leftSidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (sidebarToggle && leftSidebar) {
            sidebarToggle.addEventListener('click', () => {
                leftSidebar.classList.toggle('collapsed');
                this.updateSidebarIcon();
            });
        }

        if (menuToggle && leftSidebar) {
            menuToggle.addEventListener('click', () => {
                leftSidebar.classList.toggle('collapsed');
                this.updateSidebarIcon();
            });
        }
    }

    updateSidebarIcon() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const leftSidebar = document.getElementById('leftSidebar');
        
        if (sidebarToggle && leftSidebar) {
            const icon = sidebarToggle.querySelector('i');
            if (leftSidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        }
    }

    initializeDataTable() {
        if (this.dataTable) {
            this.setupTableSorting();
            this.setupTableFiltering();
        }
    }

    setupTableSorting() {
        const headers = this.dataTable.querySelectorAll('th[data-sortable="true"]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                this.sortTable(header);
            });
        });
    }

    setupTableFiltering() {
        // Add search functionality for table
        const searchInput = document.getElementById('tableSearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterTable(e.target.value);
            });
        }
    }

    sortTable(header) {
        const column = header.dataset.column;
        const tbody = this.dataTable.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        const isAscending = header.classList.contains('sort-asc');
        
        // Remove existing sort classes
        this.dataTable.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Add new sort class
        header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = this.getCellValue(a, column);
            const bValue = this.getCellValue(b, column);
            
            if (isAscending) {
                return bValue.localeCompare(aValue, undefined, { numeric: true });
            } else {
                return aValue.localeCompare(bValue, undefined, { numeric: true });
            }
        });
        
        // Reorder rows in table
        rows.forEach(row => tbody.appendChild(row));
    }

    getCellValue(row, column) {
        const cell = row.querySelector(`[data-column="${column}"]`);
        return cell ? cell.textContent.trim() : '';
    }

    filterTable(searchTerm) {
        const tbody = this.dataTable.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(searchTerm.toLowerCase());
            row.style.display = matches ? '' : 'none';
        });
    }

    handleFormSubmit(e) {
        if (!this.validateForm()) {
            e.preventDefault();
            return false;
        }
        
        this.showLoading();
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Validate date range
        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');
        
        if (dateFrom && dateTo) {
            if (dateFrom.value && dateTo.value) {
                const fromDate = new Date(dateFrom.value);
                const toDate = new Date(dateTo.value);
                
                if (fromDate > toDate) {
                    errors.push('From date cannot be greater than To date');
                    isValid = false;
                }
            }
        }

        if (!isValid) {
            this.showAlert(errors.join('<br>'), 'error');
        }

        return isValid;
    }

    validateDateRange() {
        const dateFrom = document.getElementById('dateFrom');
        const dateTo = document.getElementById('dateTo');
        
        if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
            const fromDate = new Date(dateFrom.value);
            const toDate = new Date(dateTo.value);
            
            if (fromDate > toDate) {
                this.showFieldError(dateTo, 'To date must be after From date');
                return false;
            } else {
                this.clearFieldError(dateTo);
            }
        }
        
        return true;
    }

    showFieldError(input, message) {
        this.clearFieldError(input);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = `
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        `;
        errorDiv.textContent = message;
        
        input.parentNode.appendChild(errorDiv);
        input.style.borderColor = '#dc2626';
    }

    clearFieldError(input) {
        const existingError = input.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        input.style.borderColor = '';
    }

    performSearch() {
        // Implement real-time search functionality
        console.log('Performing search...');
    }

    showLoading() {
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        }
    }

    hideLoading() {
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
        }
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} alert-icon"></i>
            <span>${message}</span>
        `;

        alertContainer.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    debounce(func, wait) {
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
}

// Global functions
function refreshPage() {
    window.location.reload();
}

function resetForm() {
    if (window.currentIPListManager) {
        const form = document.getElementById('searchForm');
        if (form) {
            form.reset();
        }
    }
}

function printIPList() {
    window.print();
}

function exportIPList() {
    console.log('Exporting IP list...');
}

function viewPatientDetails(patientId) {
    window.open(`patientdetails.php?id=${patientId}`, '_blank');
}

function editPatient(patientId) {
    window.location.href = `editpatient.php?id=${patientId}`;
}

function printReceipt(patientId) {
    window.open(`print_payment_receipt1.php?patientid=${patientId}`, '_blank');
}

function dischargePatient(patientId) {
    if (confirm('Are you sure you want to discharge this patient?')) {
        window.location.href = `dischargepatient.php?id=${patientId}`;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const currentIPListManager = new CurrentIPListManager();
    window.currentIPListManager = currentIPListManager;
});