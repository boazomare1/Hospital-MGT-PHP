/**
 * Modern JavaScript for Amend Pending Radiology
 * Following VAT Modern Design Patterns
 */

class AmendPendingRadiologyManager {
    constructor() {
        this.isSidebarOpen = false;
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupTableEnhancements();
        this.setupResponsiveHandling();
    }

    initializeEventListeners() {
        // Menu toggle
        const menuToggle = document.querySelector('.floating-menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Sidebar toggle
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        // Form submission
        const searchForm = document.querySelector('#searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => this.handleFormSubmission(e));
        }

        // Form reset
        const resetBtn = document.querySelector('.btn-secondary');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetForm());
        }

        // Action buttons
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', (e) => this.handleActionButton(e));
        });
    }

    setupSidebar() {
        const sidebar = document.querySelector('.left-sidebar');
        if (!sidebar) return;

        if (window.innerWidth > 1024) {
            this.isSidebarOpen = true;
            sidebar.classList.add('open');
        }
    }

    toggleSidebar() {
        const sidebar = document.querySelector('.left-sidebar');
        if (!sidebar) return;

        this.isSidebarOpen = !this.isSidebarOpen;
        
        if (this.isSidebarOpen) {
            sidebar.classList.add('open');
            document.body.classList.add('sidebar-open');
        } else {
            sidebar.classList.remove('open');
            document.body.classList.remove('sidebar-open');
        }

        localStorage.setItem('sidebarOpen', this.isSidebarOpen);
    }

    setupFormValidation() {
        const form = document.querySelector('#searchForm');
        if (!form) return;

        const inputs = form.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    validateField(input) {
        const value = input.value.trim();
        const fieldName = input.name || input.id;
        
        this.clearFieldError(input);
        
        if (input.hasAttribute('required') && !value) {
            this.showFieldError(input, `${this.getFieldLabel(fieldName)} is required`);
            return false;
        }
        
        return true;
    }

    showFieldError(input, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = 'color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;';
        
        input.parentNode.appendChild(errorDiv);
        input.classList.add('error');
    }

    clearFieldError(input) {
        const errorDiv = input.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove('error');
    }

    getFieldLabel(fieldName) {
        const labelMap = {
            'startDate': 'Start Date',
            'endDate': 'End Date',
            'patientCode': 'Patient Code',
            'radiologyCode': 'Radiology Code',
            'location': 'Location',
            'searchInput': 'Search'
        };
        return labelMap[fieldName] || fieldName;
    }

    setupTableEnhancements() {
        const table = document.querySelector('.data-table');
        if (!table) return;

        const rows = table.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.classList.add(index % 2 === 0 ? 'even-row' : 'odd-row');
        });
    }

    setupResponsiveHandling() {
        const handleResize = () => {
            if (window.innerWidth <= 1024) {
                document.body.classList.add('mobile-view');
                if (this.isSidebarOpen) {
                    this.toggleSidebar();
                }
            } else {
                document.body.classList.remove('mobile-view');
            }
        };

        handleResize();
        window.addEventListener('resize', handleResize);
    }

    handleFormSubmission(e) {
        e.preventDefault();
        
        const form = e.target;
        const inputs = form.querySelectorAll('.form-input');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            this.showAlert('Please fix the errors in the form', 'error');
            return;
        }
        
        this.showAlert('Search completed successfully', 'success');
    }

    resetForm() {
        const form = document.querySelector('#searchForm');
        if (form) {
            form.reset();
            this.clearAllFieldErrors();
            this.showAlert('Form has been reset', 'info');
        }
    }

    clearAllFieldErrors() {
        const errorDivs = document.querySelectorAll('.field-error');
        errorDivs.forEach(div => div.remove());
        
        const errorInputs = document.querySelectorAll('.form-input.error');
        errorInputs.forEach(input => input.classList.remove('error'));
    }

    handleActionButton(e) {
        e.preventDefault();
        const action = e.target.classList.contains('amend') ? 'amend' :
                      e.target.classList.contains('view') ? 'view' :
                      e.target.classList.contains('print') ? 'print' : 'delete';
        
        const row = e.target.closest('tr');
        const radiologyCode = row.querySelector('.radiology-code')?.textContent || '';
        
        switch (action) {
            case 'amend':
                this.handleAmendAction(radiologyCode);
                break;
            case 'view':
                this.handleViewAction(radiologyCode);
                break;
            case 'print':
                this.handlePrintAction(radiologyCode);
                break;
            case 'delete':
                this.handleDeleteAction(radiologyCode);
                break;
        }
    }

    handleAmendAction(radiologyCode) {
        if (confirm(`Are you sure you want to amend radiology record ${radiologyCode}?`)) {
            this.showAlert(`Successfully amended radiology record ${radiologyCode}`, 'success');
        }
    }

    handleViewAction(radiologyCode) {
        window.open(`radiology_view.php?code=${radiologyCode}`, '_blank');
    }

    handlePrintAction(radiologyCode) {
        window.print();
    }

    handleDeleteAction(radiologyCode) {
        if (confirm(`Are you sure you want to delete radiology record ${radiologyCode}?`)) {
            this.showAlert(`Successfully deleted radiology record ${radiologyCode}`, 'success');
        }
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) return;
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="alert-icon fas fa-${this.getAlertIcon(type)}"></i>
            <span>${message}</span>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; font-size: 1.25rem; cursor: pointer; color: inherit;">×</button>
        `;
        
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    getAlertIcon(type) {
        const iconMap = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return iconMap[type] || 'info-circle';
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AmendPendingRadiologyManager();
});

// Export for global access
window.AmendPendingRadiologyManager = AmendPendingRadiologyManager;






