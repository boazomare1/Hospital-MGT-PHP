/**
 * Modern JavaScript for Approval Journal Entries
 */

class ApprovalJournalManager {
    constructor() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupTableEnhancements();
        this.setupResponsiveHandling();
        this.setupApprovalSystem();
    }

    initializeEventListeners() {
        // Menu toggle functionality
        document.getElementById('menuToggle')?.addEventListener('click', () => {
            this.toggleSidebar();
        });

        // Sidebar toggle button
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            this.toggleSidebar();
        });

        // Form submission
        document.getElementById('searchForm')?.addEventListener('submit', (e) => {
            if (!this.validateSearchForm()) {
                e.preventDefault();
            }
        });

        // Export functionality
        document.querySelector('button[onclick="exportToPDF()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.exportToPDF();
        });

        // Export Excel functionality
        document.querySelector('button[onclick="exportToExcel()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.exportToExcel();
        });

        // Print functionality
        document.querySelector('button[onclick="printPage()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.printPage();
        });

        // Refresh functionality
        document.querySelector('button[onclick="refreshPage()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.refreshPage();
        });

        // Reset filters functionality
        document.querySelector('button[onclick="resetForm()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.resetForm();
        });

        // Location change handler
        document.getElementById('location')?.addEventListener('change', (e) => {
            this.handleLocationChange(e.target.value);
        });

        // Date input enhancements
        this.setupDateInputs();
    }

    setupSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        if (!sidebar) return;

        if (window.innerWidth > 1024) {
            sidebar.classList.add('open');
        }
    }

    toggleSidebar() {
        const sidebar = document.getElementById('leftSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const menuToggle = document.getElementById('menuToggle');

        if (!sidebar || !sidebarToggle || !menuToggle) return;

        const isOpen = sidebar.classList.contains('open');
        
        if (isOpen) {
            sidebar.classList.remove('open');
            sidebarToggle.innerHTML = '<i class="fas fa-chevron-right"></i>';
            menuToggle.style.left = '0';
        } else {
            sidebar.classList.add('open');
            sidebarToggle.innerHTML = '<i class="fas fa-chevron-left"></i>';
            menuToggle.style.left = '280px';
        }

        localStorage.setItem('sidebarOpen', !isOpen);
    }

    setupFormValidation() {
        const form = document.getElementById('searchForm');
        if (!form) return;

        const locationSelect = document.getElementById('location');
        const dateFromInput = document.getElementById('ADate1');
        const dateToInput = document.getElementById('ADate2');

        if (locationSelect) {
            locationSelect.addEventListener('blur', () => {
                this.validateLocation(locationSelect);
            });
        }

        if (dateFromInput) {
            dateFromInput.addEventListener('blur', () => {
                this.validateDateFrom(dateFromInput);
            });
        }

        if (dateToInput) {
            dateToInput.addEventListener('blur', () => {
                this.validateDateTo(dateToInput, dateFromInput);
            });
        }
    }

    validateSearchForm() {
        let isValid = true;
        const errors = [];

        // Validate location
        const location = document.getElementById('location');
        if (!location || !location.value) {
            errors.push('Location is required');
            isValid = false;
            this.highlightError(location);
        } else {
            this.removeError(location);
        }

        // Validate date from
        const dateFrom = document.getElementById('ADate1');
        if (!dateFrom || !dateFrom.value) {
            errors.push('Date from is required');
            isValid = false;
            this.highlightError(dateFrom);
        } else {
            this.removeError(dateFrom);
        }

        // Validate date to
        const dateTo = document.getElementById('ADate2');
        if (!dateTo || !dateTo.value) {
            errors.push('Date to is required');
            isValid = false;
            this.highlightError(dateTo);
        } else {
            this.removeError(dateTo);
        }

        // Validate date range
        if (dateFrom && dateTo && dateFrom.value && dateTo.value) {
            const fromDate = new Date(dateFrom.value);
            const toDate = new Date(dateTo.value);
            
            if (fromDate > toDate) {
                errors.push('Date from cannot be after date to');
                isValid = false;
                this.highlightError(dateFrom);
                this.highlightError(dateTo);
            }
        }

        if (!isValid) {
            this.showNotification('Please fix the validation errors before searching.', 'error');
        }

        return isValid;
    }

    validateLocation(input) {
        const value = input.value;
        
        if (!value) {
            this.showFieldError(input, 'Location is required');
            return false;
        }

        this.removeFieldError(input);
        return true;
    }

    validateDateFrom(input) {
        const value = input.value;
        
        if (!value) {
            this.showFieldError(input, 'Date from is required');
            return false;
        }

        if (!this.isValidDate(value)) {
            this.showFieldError(input, 'Please enter a valid date');
            return false;
        }

        this.removeFieldError(input);
        return true;
    }

    validateDateTo(input, dateFromInput) {
        const value = input.value;
        
        if (!value) {
            this.showFieldError(input, 'Date to is required');
            return false;
        }

        if (!this.isValidDate(value)) {
            this.showFieldError(input, 'Please enter a valid date');
            return false;
        }

        if (dateFromInput && dateFromInput.value) {
            const fromDate = new Date(dateFromInput.value);
            const toDate = new Date(value);
            
            if (fromDate > toDate) {
                this.showFieldError(input, 'Date to cannot be before date from');
                return false;
            }
        }

        this.removeFieldError(input);
        return true;
    }

    isValidDate(dateString) {
        const date = new Date(dateString);
        return date instanceof Date && !isNaN(date);
    }

    showFieldError(input, message) {
        this.removeFieldError(input);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.cssText = `
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        
        const icon = document.createElement('i');
        icon.className = 'fas fa-exclamation-circle';
        errorDiv.prepend(icon);
        
        input.parentNode.appendChild(errorDiv);
        input.style.borderColor = '#dc2626';
    }

    removeFieldError(input) {
        const errorDiv = input.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.style.borderColor = '';
    }

    highlightError(input) {
        if (input) {
            input.style.borderColor = '#dc2626';
            input.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
        }
    }

    removeError(input) {
        if (input) {
            input.style.borderColor = '';
            input.style.boxShadow = '';
        }
    }

    setupDateInputs() {
        const dateInputs = document.querySelectorAll('#ADate1, #ADate2');
        
        dateInputs.forEach(input => {
            // Add quick date buttons
            const quickDateContainer = document.createElement('div');
            quickDateContainer.className = 'quick-date-buttons';
            quickDateContainer.style.cssText = `
                display: flex;
                gap: 0.5rem;
                margin-top: 0.5rem;
                flex-wrap: wrap;
            `;
            
            const quickDates = [
                { label: 'Today', days: 0 },
                { label: 'Yesterday', days: -1 },
                { label: 'Last 7 days', days: -7 },
                { label: 'Last 30 days', days: -30 }
            ];
            
            quickDates.forEach(({ label, days }) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = label;
                button.className = 'quick-date-btn';
                button.style.cssText = `
                    padding: 0.25rem 0.5rem;
                    border: 1px solid #e2e8f0;
                    border-radius: 0.375rem;
                    background: white;
                    font-size: 0.75rem;
                    cursor: pointer;
                    transition: all 0.2s ease;
                `;
                
                button.addEventListener('click', () => {
                    const date = new Date();
                    date.setDate(date.getDate() + days);
                    input.value = date.toISOString().split('T')[0];
                    input.dispatchEvent(new Event('change'));
                });
                
                button.addEventListener('mouseenter', () => {
                    button.style.background = '#f1f5f9';
                    button.style.borderColor = '#cbd5e1';
                });
                
                button.addEventListener('mouseleave', () => {
                    button.style.background = 'white';
                    button.style.borderColor = '#e2e8f0';
                });
                
                quickDateContainer.appendChild(button);
            });
            
            input.parentNode.appendChild(quickDateContainer);
        });
    }

    setupTableEnhancements() {
        // Add sorting functionality
        this.setupTableSorting();
        
        // Add search functionality
        this.setupTableSearch();
        
        // Add row actions
        this.setupRowActions();
        
        // Update journal count
        this.updateJournalCount();
    }

    setupTableSorting() {
        const tableHeaders = document.querySelectorAll('.journal-table th');
        
        tableHeaders.forEach(header => {
            if (header.textContent !== 'Action') {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    this.sortTable(header);
                });
                
                // Add sort indicator
                const sortIcon = document.createElement('i');
                sortIcon.className = 'fas fa-sort sort-icon';
                sortIcon.style.cssText = `
                    margin-left: 0.5rem;
                    color: #94a3b8;
                    font-size: 0.75rem;
                `;
                header.appendChild(sortIcon);
            }
        });
    }

    sortTable(header) {
        const table = header.closest('table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        
        // Remove existing sort indicators
        table.querySelectorAll('.sort-icon').forEach(icon => {
            icon.className = 'fas fa-sort sort-icon';
        });
        
        // Update sort indicator
        const sortIcon = header.querySelector('.sort-icon');
        const isAscending = !header.classList.contains('sort-asc');
        
        if (isAscending) {
            sortIcon.className = 'fas fa-sort-up sort-icon';
            header.classList.add('sort-asc');
            header.classList.remove('sort-desc');
        } else {
            sortIcon.className = 'fas fa-sort-down sort-icon';
            header.classList.add('sort-desc');
            header.classList.remove('sort-asc');
        }
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.children[columnIndex]?.textContent || '';
            const bValue = b.children[columnIndex]?.textContent || '';
            
            if (isAscending) {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }

    setupTableSearch() {
        const journalSection = document.querySelector('.journal-list-section');
        if (!journalSection) return;
        
        const header = journalSection.querySelector('.journal-list-header');
        if (!header) return;
        
        const searchContainer = document.createElement('div');
        searchContainer.className = 'table-search';
        searchContainer.style.cssText = `
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.placeholder = 'Search journal entries...';
        searchInput.className = 'search-input';
        searchInput.style.cssText = `
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            min-width: 250px;
        `;
        
        searchInput.addEventListener('input', (e) => {
            this.filterJournalEntries(e.target.value);
        });
        
        searchContainer.appendChild(searchInput);
        header.appendChild(searchContainer);
    }

    filterJournalEntries(searchTerm) {
        const tbody = document.querySelector('.journal-table tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        const searchLower = searchTerm.toLowerCase();
        
        rows.forEach(row => {
            if (row.classList.contains('empty-state')) return;
            
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchLower);
            row.style.display = isVisible ? '' : 'none';
        });
        
        this.updateJournalCount();
    }

    setupRowActions() {
        // Add hover effects and action tooltips
        const actionButtons = document.querySelectorAll('.btn');
        
        actionButtons.forEach(button => {
            // Add tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = button.title || button.getAttribute('title') || 'Action';
            tooltip.style.cssText = `
                position: absolute;
                background: #1e293b;
                color: white;
                padding: 0.5rem;
                border-radius: 0.375rem;
                font-size: 0.75rem;
                white-space: nowrap;
                z-index: 1000;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease;
                transform: translateY(-100%);
                margin-top: -0.5rem;
            `;
            
            button.style.position = 'relative';
            button.appendChild(tooltip);
            
            button.addEventListener('mouseenter', () => {
                tooltip.style.opacity = '1';
            });
            
            button.addEventListener('mouseleave', () => {
                tooltip.style.opacity = '0';
            });
        });
    }

    updateJournalCount() {
        const tbody = document.querySelector('.journal-table tbody');
        if (!tbody) return;
        
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => 
            !row.classList.contains('empty-state') && row.style.display !== 'none'
        );
        
        const countElement = document.querySelector('.journal-count');
        if (countElement) {
            countElement.textContent = visibleRows.length;
        }
    }

    setupApprovalSystem() {
        // Setup approval checkboxes
        const approvalCheckboxes = document.querySelectorAll('.approve-checkbox');
        
        approvalCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    this.handleApproval(e.target);
                }
            });
        });
    }

    handleApproval(checkbox) {
        const docno = checkbox.getAttribute('data-docno');
        const id = checkbox.getAttribute('data-id');
        
        if (!docno || !id) return;
        
        if (confirm(`Are you sure you want to approve journal entry ${docno}?`)) {
            this.approveJournalEntry(docno, id, checkbox);
        } else {
            checkbox.checked = false;
        }
    }

    approveJournalEntry(docno, id, checkbox) {
        // Show loading state
        checkbox.disabled = true;
        checkbox.style.opacity = '0.5';
        
        // Simulate AJAX call (replace with actual implementation)
        setTimeout(() => {
            // Hide the row
            const row = document.getElementById(`itr${docno}`);
            if (row) {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-100%)';
                
                setTimeout(() => {
                    row.remove();
                    this.updateJournalCount();
                    this.showNotification(`Journal entry ${docno} approved successfully`, 'success');
                }, 300);
            }
        }, 1000);
    }

    setupResponsiveHandling() {
        // Handle mobile menu
        if (window.innerWidth <= 1024) {
            const sidebar = document.getElementById('leftSidebar');
            if (sidebar) {
                sidebar.classList.remove('open');
            }
        }
        
        // Handle table responsiveness
        this.setupResponsiveTable();
    }

    setupResponsiveTable() {
        const table = document.querySelector('.journal-table');
        if (!table) return;
        
        if (window.innerWidth <= 768) {
            this.convertTableToCards(table);
        }
    }

    convertTableToCards(table) {
        if (table.classList.contains('converted-to-cards')) return;
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            if (row.classList.contains('empty-state')) return;
            
            const card = document.createElement('div');
            card.className = 'journal-card';
            card.style.cssText = `
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-bottom: 1rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            `;
            
            const cells = row.querySelectorAll('td');
            const headers = table.querySelectorAll('th');
            
            cells.forEach((cell, index) => {
                if (headers[index] && headers[index].textContent !== 'Action') {
                    const field = document.createElement('div');
                    field.className = 'card-field';
                    field.style.cssText = `
                        margin-bottom: 0.5rem;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    `;
                    
                    const label = document.createElement('strong');
                    label.textContent = headers[index].textContent + ':';
                    label.style.color = '#475569';
                    
                    const value = document.createElement('span');
                    value.innerHTML = cell.innerHTML;
                    
                    field.appendChild(label);
                    field.appendChild(value);
                    card.appendChild(field);
                }
            });
            
            // Add actions
            const actionsCell = row.querySelector('td:last-child');
            if (actionsCell) {
                const actionsDiv = document.createElement('div');
                actionsDiv.className = 'card-actions';
                actionsDiv.style.cssText = `
                    margin-top: 1rem;
                    padding-top: 1rem;
                    border-top: 1px solid #e2e8f0;
                    display: flex;
                    gap: 0.5rem;
                `;
                actionsDiv.innerHTML = actionsCell.innerHTML;
                card.appendChild(actionsDiv);
            }
            
            row.parentNode.insertBefore(card, row);
        });
        
        table.classList.add('converted-to-cards');
        table.style.display = 'none';
    }

    handleLocationChange(locationCode) {
        if (!locationCode) return;

        // Show loading state
        this.showLoadingState();

        // Simulate AJAX call (replace with actual implementation)
        setTimeout(() => {
            this.hideLoadingState();
            
            // Update location-dependent fields if needed
            const locationSelect = document.getElementById('location');
            if (locationSelect) {
                const selectedOption = locationSelect.querySelector(`option[value="${locationCode}"]`);
                if (selectedOption) {
                    this.showNotification(`Location changed to: ${selectedOption.textContent}`, 'info');
                }
            }
        }, 500);
    }

    showLoadingState() {
        const submitBtn = document.querySelector('.submit-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        }
    }

    hideLoadingState() {
        const submitBtn = document.querySelector('.submit-btn');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-search"></i> Search';
        }
    }

    exportToPDF() {
        this.showNotification('PDF export functionality will be implemented here', 'info');
    }

    exportToExcel() {
        this.showNotification('Excel export functionality will be implemented here', 'info');
    }

    printPage() {
        window.print();
    }

    refreshPage() {
        if (confirm('Are you sure you want to refresh the page? All unsaved changes will be lost.')) {
            window.location.reload();
        }
    }

    resetForm() {
        if (confirm('Are you sure you want to reset all filters?')) {
            const form = document.getElementById('searchForm');
            if (form) {
                form.reset();
                this.showNotification('Filters reset successfully', 'success');
            }
        }
    }

    showNotification(message, type = 'info') {
        const container = document.getElementById('notificationContainer') || this.createNotificationContainer();
        
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            background: ${this.getNotificationColor(type)};
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideInRight 0.3s ease-out;
            max-width: 400px;
        `;
        
        const icon = document.createElement('i');
        icon.className = this.getNotificationIcon(type);
        
        const messageSpan = document.createElement('span');
        messageSpan.textContent = message;
        
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: auto;
            padding: 0;
            line-height: 1;
        `;
        closeBtn.addEventListener('click', () => {
            this.removeNotification(notification);
        });
        
        notification.appendChild(icon);
        notification.appendChild(messageSpan);
        notification.appendChild(closeBtn);
        
        container.appendChild(notification);
        
        setTimeout(() => {
            this.removeNotification(notification);
        }, 5000);
    }

    createNotificationContainer() {
        const container = document.createElement('div');
        container.id = 'notificationContainer';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(container);
        return container;
    }

    removeNotification(notification) {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    getNotificationColor(type) {
        const colors = {
            success: '#059669',
            error: '#dc2626',
            warning: '#d97706',
            info: '#0891b2'
        };
        return colors[type] || colors.info;
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        return icons[type] || icons.info;
    }
}

// Initialize the manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.approvalJournalManager = new ApprovalJournalManager();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
    
    .sort-icon {
        transition: color 0.2s ease;
    }
    
    .sort-asc .sort-icon,
    .sort-desc .sort-icon {
        color: #2563eb !important;
    }
    
    .quick-date-btn:hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }
`;
document.head.appendChild(style);

// Global functions for legacy compatibility
function ajaxlocationfunction(val) {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.handleLocationChange(val);
    }
}

function approveje(code, id) {
    if (window.approvalJournalManager) {
        const checkbox = document.getElementById(`approved${id}`);
        if (checkbox) {
            checkbox.checked = true;
            window.approvalJournalManager.handleApproval(checkbox);
        }
    }
}

function exportToPDF() {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.exportToPDF();
    }
}

function exportToExcel() {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.exportToExcel();
    }
}

function printPage() {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.printPage();
    }
}

function refreshPage() {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.refreshPage();
    }
}

function resetForm() {
    if (window.approvalJournalManager) {
        window.approvalJournalManager.resetForm();
    }
}



