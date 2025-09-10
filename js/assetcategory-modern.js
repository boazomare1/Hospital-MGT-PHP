/**
 * Modern JavaScript for Asset Category Master
 */

class AssetCategoryManager {
    constructor() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupTableEnhancements();
        this.setupResponsiveHandling();
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
        document.getElementById('form1')?.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
            }
        });

        // Form reset confirmation
        document.querySelector('button[type="reset"]')?.addEventListener('click', (e) => {
            if (!this.confirmFormReset()) {
                e.preventDefault();
            }
        });

        // Export functionality
        document.querySelector('button[onclick="exportToExcel()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.exportToExcel();
        });

        // Refresh functionality
        document.querySelector('button[onclick="refreshPage()"]')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.refreshPage();
        });

        // Input enhancements
        this.setupInputEnhancements();
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
        const form = document.getElementById('form1');
        if (!form) return;

        const idInput = document.getElementById('id');
        const categoryInput = document.getElementById('category');
        const noofyearsInput = document.getElementById('noofyears');

        if (idInput) {
            idInput.addEventListener('blur', () => {
                this.validateId(idInput);
            });
        }

        if (categoryInput) {
            categoryInput.addEventListener('blur', () => {
                this.validateCategory(categoryInput);
            });
        }

        if (noofyearsInput) {
            noofyearsInput.addEventListener('blur', () => {
                this.validateYears(noofyearsInput);
            });
        }
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Validate ID
        const id = document.getElementById('id');
        if (!id || !id.value.trim()) {
            errors.push('Category ID is required');
            isValid = false;
            this.highlightError(id);
        } else {
            this.removeError(id);
        }

        // Validate category name
        const category = document.getElementById('category');
        if (!category || !category.value.trim()) {
            errors.push('Category name is required');
            isValid = false;
            this.highlightError(category);
        } else {
            this.removeError(category);
        }

        // Validate years
        const noofyears = document.getElementById('noofyears');
        if (!noofyears || !noofyears.value.trim()) {
            errors.push('Number of years is required');
            isValid = false;
            this.highlightError(noofyears);
        } else {
            this.removeError(noofyears);
        }

        if (!isValid) {
            this.showNotification('Please fix the validation errors before submitting.', 'error');
        }

        return isValid;
    }

    validateId(input) {
        const value = input.value.trim();
        
        if (!value) {
            this.showFieldError(input, 'Category ID is required');
            return false;
        }

        if (value.length < 2) {
            this.showFieldError(input, 'Category ID must be at least 2 characters');
            return false;
        }

        if (value.length > 20) {
            this.showFieldError(input, 'Category ID must be less than 20 characters');
            return false;
        }

        this.removeFieldError(input);
        return true;
    }

    validateCategory(input) {
        const value = input.value.trim();
        
        if (!value) {
            this.showFieldError(input, 'Category name is required');
            return false;
        }

        if (value.length < 2) {
            this.showFieldError(input, 'Category name must be at least 2 characters');
            return false;
        }

        if (value.length > 100) {
            this.showFieldError(input, 'Category name must be less than 100 characters');
            return false;
        }

        this.removeFieldError(input);
        return true;
    }

    validateYears(input) {
        const value = input.value.trim();
        
        if (!value) {
            this.showFieldError(input, 'Number of years is required');
            return false;
        }

        if (!/^\d+$/.test(value)) {
            this.showFieldError(input, 'Number of years must be a valid number');
            return false;
        }

        const years = parseInt(value);
        if (years < 1 || years > 100) {
            this.showFieldError(input, 'Number of years must be between 1 and 100');
            return false;
        }

        this.removeFieldError(input);
        return true;
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

    setupInputEnhancements() {
        const idInput = document.getElementById('id');
        const categoryInput = document.getElementById('category');
        const noofyearsInput = document.getElementById('noofyears');

        if (idInput) {
            idInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
                this.addCharacterCounter(e.target, 20);
            });
        }

        if (categoryInput) {
            categoryInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
                this.addCharacterCounter(e.target, 100);
            });
        }

        if (noofyearsInput) {
            noofyearsInput.addEventListener('input', (e) => {
                // Only allow numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                this.addCharacterCounter(e.target, 3);
            });
        }
    }

    addCharacterCounter(input, maxLength) {
        let counter = input.parentNode.querySelector('.char-counter');
        
        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'char-counter';
            counter.style.cssText = `
                font-size: 0.75rem;
                color: #64748b;
                margin-top: 0.25rem;
                text-align: right;
            `;
            input.parentNode.appendChild(counter);
        }
        
        const currentLength = input.value.length;
        const remaining = maxLength - currentLength;
        
        counter.textContent = `${currentLength}/${maxLength}`;
        counter.style.color = remaining < 5 ? '#dc2626' : '#64748b';
    }

    setupTableEnhancements() {
        // Add sorting functionality
        this.setupTableSorting();
        
        // Add search functionality
        this.setupTableSearch();
        
        // Add row actions
        this.setupRowActions();
    }

    setupTableSorting() {
        const tableHeaders = document.querySelectorAll('.data-table th');
        
        tableHeaders.forEach(header => {
            if (header.textContent !== 'Actions' && header.textContent !== 'Edit') {
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
        const tableSections = document.querySelectorAll('.data-table-section, .deleted-items-section');
        
        tableSections.forEach(section => {
            const header = section.querySelector('.data-table-header, .deleted-items-header');
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
            searchInput.placeholder = 'Search...';
            searchInput.className = 'search-input';
            searchInput.style.cssText = `
                padding: 0.5rem 0.75rem;
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
                font-size: 0.875rem;
                min-width: 200px;
            `;
            
            searchInput.addEventListener('input', (e) => {
                this.filterTableRows(section, e.target.value);
            });
            
            searchContainer.appendChild(searchInput);
            header.appendChild(searchContainer);
        });
    }

    filterTableRows(section, searchTerm) {
        const tbody = section.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        const searchLower = searchTerm.toLowerCase();
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchLower);
            row.style.display = isVisible ? '' : 'none';
        });
    }

    setupRowActions() {
        // Add hover effects and action tooltips
        const actionButtons = document.querySelectorAll('.action-btn');
        
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
        const tables = document.querySelectorAll('.data-table');
        
        tables.forEach(table => {
            if (window.innerWidth <= 768) {
                this.convertTableToCards(table);
            }
        });
    }

    convertTableToCards(table) {
        if (table.classList.contains('converted-to-cards')) return;
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const card = document.createElement('div');
            card.className = 'table-card';
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
                if (headers[index] && headers[index].textContent !== 'Actions' && headers[index].textContent !== 'Edit') {
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
            const actionsCell = row.querySelector('td:first-child');
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

    confirmFormReset() {
        return confirm('Are you sure you want to reset the form? All entered data will be lost.');
    }

    exportToExcel() {
        this.showNotification('Export functionality will be implemented here', 'info');
    }

    refreshPage() {
        if (confirm('Are you sure you want to refresh the page? All unsaved changes will be lost.')) {
            window.location.reload();
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
    window.assetCategoryManager = new AssetCategoryManager();
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
`;
document.head.appendChild(style);

// Global functions for legacy compatibility
function confirmDelete(categoryName, autoNumber) {
    if (confirm(`Are you sure you want to delete the asset category "${categoryName}"?`)) {
        window.location.href = `assetcategory.php?st=del&&anum=${autoNumber}`;
    }
}

function confirmActivate(categoryName, autoNumber) {
    if (confirm(`Are you sure you want to activate the asset category "${categoryName}"?`)) {
        window.location.href = `assetcategory.php?st=activate&&anum=${autoNumber}`;
    }
}

function addward1process1() {
    if (window.assetCategoryManager) {
        return window.assetCategoryManager.validateForm();
    }
    return true;
}

function funcDeletePaymentType(varPaymentTypeAutoNumber) {
    if (confirm(`Are you sure want to delete this asset category ${varPaymentTypeAutoNumber}?`)) {
        alert("Asset Category Entry Delete Completed.");
        return true;
    } else {
        alert("Asset Category Entry Delete Not Completed.");
        return false;
    }
}

function isOnlyNumber(evt, element) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode < 48 || charCode > 57))
        return false;
    return true;
}
