/**
 * Modern JavaScript for Credit Note List - creditnotelist.php
 * Enhanced UI interactions, form validation, and dynamic functionality
 */

class CreditNoteListManager {
    constructor() {
        this.init();
        this.bindEvents();
        this.initializeComponents();
    }

    init() {
        console.log('Credit Note List Manager initialized');
        this.setupKeyboardShortcuts();
        this.initializeTable();
        this.setupFilters();
        this.loadInitialData();
    }

    bindEvents() {
        // Form submission events
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => this.handleFormSubmit(e));
        });

        // Input validation events
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', (e) => this.validateField(e.target));
            input.addEventListener('input', (e) => this.clearFieldError(e.target));
        });

        // Button events
        const buttons = document.querySelectorAll('button, .btn');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => this.handleButtonClick(e));
        });

        // Table events
        const table = document.querySelector('.credit-note-table, table');
        if (table) {
            this.setupTableEvents(table);
        }

        // Search functionality
        const searchInput = document.querySelector('.search-input, input[type="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.handleSearch(e));
        }

        // Filter events
        const filterInputs = document.querySelectorAll('.filter-control, .form-control');
        filterInputs.forEach(input => {
            input.addEventListener('change', (e) => this.handleFilterChange(e));
        });

        // Pagination events
        const paginationButtons = document.querySelectorAll('.pagination-btn');
        paginationButtons.forEach(button => {
            button.addEventListener('click', (e) => this.handlePagination(e));
        });

        // Action button events
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(button => {
            button.addEventListener('click', (e) => this.handleActionClick(e));
        });
    }

    initializeComponents() {
        this.setupDatePickers();
        this.setupTooltips();
        this.setupModals();
        this.initializeNotifications();
    }

    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + F for search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('.search-input, input[type="search"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }

            // Ctrl/Cmd + R for refresh
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                this.refreshData();
            }

            // Escape to close modals/notifications
            if (e.key === 'Escape') {
                this.closeModals();
                this.hideNotifications();
            }
        });
    }

    initializeTable() {
        const table = document.querySelector('.credit-note-table, table');
        if (!table) return;

        // Add sorting functionality
        const headers = table.querySelectorAll('th[data-sortable]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', (e) => this.sortTable(e));
        });

        // Add row hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', (e) => this.highlightRow(e.target));
            row.addEventListener('mouseleave', (e) => this.unhighlightRow(e.target));
        });

        // Add click events for row selection
        rows.forEach(row => {
            row.addEventListener('click', (e) => this.selectRow(e.target));
        });
    }

    setupTableEvents(table) {
        // Double-click to view details
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('dblclick', (e) => this.viewCreditNoteDetails(e));
        });
    }

    setupFilters() {
        const filterForm = document.querySelector('.credit-note-filters, .filter-form');
        if (filterForm) {
            // Auto-submit on filter change
            const filterInputs = filterForm.querySelectorAll('select, input[type="date"]');
            filterInputs.forEach(input => {
                input.addEventListener('change', () => {
                    this.applyFilters();
                });
            });
        }
    }

    setupDatePickers() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            // Set default date ranges
            if (input.name && input.name.includes('from')) {
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                input.value = firstDay.toISOString().split('T')[0];
            }
            if (input.name && input.name.includes('to')) {
                const today = new Date();
                input.value = today.toISOString().split('T')[0];
            }
        });
    }

    setupTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', (e) => this.showTooltip(e));
            element.addEventListener('mouseleave', (e) => this.hideTooltip(e));
        });
    }

    setupModals() {
        // Initialize any existing modals
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const closeButtons = modal.querySelectorAll('.modal-close, .btn-close');
            closeButtons.forEach(button => {
                button.addEventListener('click', () => this.closeModal(modal));
            });
        });
    }

    initializeNotifications() {
        // Create notification container if it doesn't exist
        if (!document.querySelector('.notification-container')) {
            const container = document.createElement('div');
            container.className = 'notification-container';
            container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                pointer-events: none;
            `;
            document.body.appendChild(container);
        }
    }

    handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        
        if (!this.validateForm(form)) {
            this.showNotification('Please correct the errors in the form', 'error');
            return;
        }

        this.showLoading();
        
        // Simulate form submission
        setTimeout(() => {
            this.hideLoading();
            this.showNotification('Form submitted successfully', 'success');
            this.resetForm(form);
        }, 1500);
    }

    validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name || field.id;
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = `${this.getFieldLabel(field)} is required`;
        }

        // Email validation
        if (field.type === 'email' && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }

        // Date validation
        if (field.type === 'date' && value) {
            const date = new Date(value);
            const today = new Date();
            if (date > today) {
                isValid = false;
                errorMessage = 'Date cannot be in the future';
            }
        }

        // Number validation
        if (field.type === 'number' && value) {
            const num = parseFloat(value);
            if (isNaN(num) || num < 0) {
                isValid = false;
                errorMessage = 'Please enter a valid positive number';
            }
        }

        // Custom validation for credit note specific fields
        if (fieldName && fieldName.includes('amount') && value) {
            const amount = parseFloat(value);
            if (isNaN(amount) || amount <= 0) {
                isValid = false;
                errorMessage = 'Amount must be greater than 0';
            }
        }

        this.setFieldValidation(field, isValid, errorMessage);
        return isValid;
    }

    setFieldValidation(field, isValid, errorMessage) {
        const formGroup = field.closest('.form-group, .filter-group');
        if (!formGroup) return;

        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');
        
        // Remove existing feedback
        const existingFeedback = formGroup.querySelector('.form-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        if (isValid) {
            field.classList.add('is-valid');
        } else {
            field.classList.add('is-invalid');
            const feedback = document.createElement('div');
            feedback.className = 'form-feedback invalid-feedback';
            feedback.textContent = errorMessage;
            formGroup.appendChild(feedback);
        }
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const formGroup = field.closest('.form-group, .filter-group');
        if (formGroup) {
            const feedback = formGroup.querySelector('.form-feedback');
            if (feedback) {
                feedback.remove();
            }
        }
    }

    getFieldLabel(field) {
        const label = field.closest('.form-group, .filter-group')?.querySelector('label, .form-label, .filter-label');
        return label ? label.textContent.trim() : field.name || field.id || 'Field';
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    handleButtonClick(e) {
        const button = e.target.closest('button, .btn');
        if (!button) return;

        const action = button.dataset.action || button.className;
        
        switch (action) {
            case 'btn-primary':
            case 'submit':
                // Handle primary action
                break;
            case 'btn-secondary':
            case 'cancel':
                this.handleCancel();
                break;
            case 'btn-success':
            case 'approve':
                this.handleApprove(button);
                break;
            case 'btn-error':
            case 'delete':
                this.handleDelete(button);
                break;
            case 'btn-warning':
            case 'edit':
                this.handleEdit(button);
                break;
            default:
                // Handle other button actions
                break;
        }
    }

    handleActionClick(e) {
        e.preventDefault();
        const button = e.target.closest('.action-btn');
        if (!button) return;

        const action = button.dataset.action || button.className;
        const row = button.closest('tr');
        const creditNoteId = row?.dataset.id || button.dataset.id;

        switch (action) {
            case 'action-btn-view':
                this.viewCreditNote(creditNoteId);
                break;
            case 'action-btn-edit':
                this.editCreditNote(creditNoteId);
                break;
            case 'action-btn-delete':
                this.deleteCreditNote(creditNoteId);
                break;
            case 'action-btn-approve':
                this.approveCreditNote(creditNoteId);
                break;
        }
    }

    handleSearch(e) {
        const searchTerm = e.target.value.toLowerCase();
        const table = document.querySelector('.credit-note-table, table');
        if (!table) return;

        const rows = table.querySelectorAll('tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visibleCount++;
        });

        this.updateSearchResults(visibleCount, rows.length);
    }

    handleFilterChange(e) {
        this.applyFilters();
    }

    applyFilters() {
        this.showLoading();
        
        // Simulate filter application
        setTimeout(() => {
            this.hideLoading();
            this.showNotification('Filters applied successfully', 'success');
            this.updateTableData();
        }, 1000);
    }

    handlePagination(e) {
        e.preventDefault();
        const button = e.target.closest('.pagination-btn');
        if (!button || button.disabled) return;

        const page = button.dataset.page;
        this.loadPage(page);
    }

    sortTable(e) {
        const header = e.target.closest('th');
        const table = header.closest('table');
        const column = Array.from(header.parentNode.children).indexOf(header);
        const isAscending = header.dataset.sort === 'asc';
        
        // Update sort indicators
        table.querySelectorAll('th').forEach(th => {
            th.dataset.sort = '';
            th.classList.remove('sort-asc', 'sort-desc');
        });
        
        header.dataset.sort = isAscending ? 'desc' : 'asc';
        header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
        
        this.sortTableRows(table, column, isAscending);
    }

    sortTableRows(table, column, ascending) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aVal = a.children[column]?.textContent.trim() || '';
            const bVal = b.children[column]?.textContent.trim() || '';
            
            // Try to parse as numbers
            const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ''));
            const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ''));
            
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return ascending ? aNum - bNum : bNum - aNum;
            }
            
            // String comparison
            return ascending ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });
        
        rows.forEach(row => tbody.appendChild(row));
    }

    highlightRow(row) {
        row.style.backgroundColor = 'var(--bg-secondary)';
    }

    unhighlightRow(row) {
        row.style.backgroundColor = '';
    }

    selectRow(row) {
        // Remove selection from other rows
        const table = row.closest('table');
        table.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
        
        // Add selection to current row
        row.classList.add('selected');
    }

    viewCreditNoteDetails(e) {
        const row = e.target.closest('tr');
        const creditNoteId = row?.dataset.id;
        if (creditNoteId) {
            this.viewCreditNote(creditNoteId);
        }
    }

    viewCreditNote(id) {
        this.showLoading();
        
        // Simulate API call
        setTimeout(() => {
            this.hideLoading();
            this.showNotification(`Viewing credit note ${id}`, 'info');
            // In a real application, this would open a modal or navigate to a detail page
        }, 1000);
    }

    editCreditNote(id) {
        this.showLoading();
        
        setTimeout(() => {
            this.hideLoading();
            this.showNotification(`Editing credit note ${id}`, 'info');
            // In a real application, this would open an edit form
        }, 1000);
    }

    deleteCreditNote(id) {
        if (confirm('Are you sure you want to delete this credit note?')) {
            this.showLoading();
            
            setTimeout(() => {
                this.hideLoading();
                this.showNotification(`Credit note ${id} deleted successfully`, 'success');
                this.removeTableRow(id);
            }, 1000);
        }
    }

    approveCreditNote(id) {
        this.showLoading();
        
        setTimeout(() => {
            this.hideLoading();
            this.showNotification(`Credit note ${id} approved successfully`, 'success');
            this.updateCreditNoteStatus(id, 'approved');
        }, 1000);
    }

    handleCancel() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            this.resetForm(form);
        });
        this.showNotification('Operation cancelled', 'info');
    }

    handleApprove(button) {
        const row = button.closest('tr');
        const id = row?.dataset.id;
        if (id) {
            this.approveCreditNote(id);
        }
    }

    handleDelete(button) {
        const row = button.closest('tr');
        const id = row?.dataset.id;
        if (id) {
            this.deleteCreditNote(id);
        }
    }

    handleEdit(button) {
        const row = button.closest('tr');
        const id = row?.dataset.id;
        if (id) {
            this.editCreditNote(id);
        }
    }

    updateSearchResults(visible, total) {
        const resultsInfo = document.querySelector('.search-results-info');
        if (resultsInfo) {
            resultsInfo.textContent = `Showing ${visible} of ${total} credit notes`;
        }
    }

    updateTableData() {
        // Simulate table data update
        const table = document.querySelector('.credit-note-table, table');
        if (table) {
            // Add loading animation to table rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.style.opacity = '1';
                    }, 100);
                }, index * 50);
            });
        }
    }

    loadPage(page) {
        this.showLoading();
        
        setTimeout(() => {
            this.hideLoading();
            this.showNotification(`Loaded page ${page}`, 'info');
            this.updatePagination(page);
        }, 1000);
    }

    updatePagination(currentPage) {
        const paginationButtons = document.querySelectorAll('.pagination-btn');
        paginationButtons.forEach(button => {
            button.classList.remove('active');
            if (button.dataset.page === currentPage) {
                button.classList.add('active');
            }
        });
    }

    removeTableRow(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
            }, 300);
        }
    }

    updateCreditNoteStatus(id, status) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            const statusCell = row.querySelector('.status-badge');
            if (statusCell) {
                statusCell.className = `status-badge status-${status}`;
                statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            }
        }
    }

    resetForm(form) {
        form.reset();
        const fields = form.querySelectorAll('.is-valid, .is-invalid');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
        const feedbacks = form.querySelectorAll('.form-feedback');
        feedbacks.forEach(feedback => feedback.remove());
    }

    refreshData() {
        this.showLoading();
        
        setTimeout(() => {
            this.hideLoading();
            this.showNotification('Data refreshed successfully', 'success');
            this.loadInitialData();
        }, 1000);
    }

    loadInitialData() {
        // Simulate loading initial data
        const table = document.querySelector('.credit-note-table, table');
        if (table) {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.style.opacity = '1';
                }, index * 100);
            });
        }
    }

    showLoading() {
        if (!document.querySelector('.loading-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = '<div class="loading-spinner"></div>';
            document.body.appendChild(overlay);
        }
    }

    hideLoading() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    showNotification(message, type = 'info') {
        const container = document.querySelector('.notification-container') || document.body;
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.pointerEvents = 'auto';
        
        container.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    hideNotifications() {
        const notifications = document.querySelectorAll('.notification');
        notifications.forEach(notification => {
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        });
    }

    showTooltip(e) {
        const element = e.target;
        const tooltipText = element.dataset.tooltip;
        if (!tooltipText) return;

        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = tooltipText;
        tooltip.style.cssText = `
            position: absolute;
            background: var(--gray-800);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        `;

        document.body.appendChild(tooltip);

        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';

        setTimeout(() => {
            tooltip.style.opacity = '1';
        }, 10);

        element._tooltip = tooltip;
    }

    hideTooltip(e) {
        const element = e.target;
        if (element._tooltip) {
            element._tooltip.remove();
            delete element._tooltip;
        }
    }

    closeModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            this.closeModal(modal);
        });
    }

    closeModal(modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new CreditNoteListManager();
});

// Export for potential use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CreditNoteListManager;
}

