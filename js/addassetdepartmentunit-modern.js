/**
 * Modern JavaScript for Asset Department & Unit Master
 */

class AssetDepartmentManager {
    constructor() {
        this.initializeEventListeners();
        this.setupSidebar();
        this.setupFormValidation();
        this.setupUnitManagement();
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

        // Add unit button
        document.getElementById('addunit')?.addEventListener('click', () => {
            this.addUnit();
        });

        // Unit input enter key
        document.getElementById('unit')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.addUnit();
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

        const departmentInput = document.getElementById('department');
        const unitInput = document.getElementById('unit');

        if (departmentInput) {
            departmentInput.addEventListener('blur', () => {
                this.validateDepartment(departmentInput);
            });
        }

        if (unitInput) {
            unitInput.addEventListener('blur', () => {
                this.validateUnit(unitInput);
            });
        }
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Validate department
        const department = document.getElementById('department');
        if (!department || !department.value.trim()) {
            errors.push('Department name is required');
            isValid = false;
            this.highlightError(department);
        } else {
            this.removeError(department);
        }

        // Validate units
        const units = document.querySelectorAll('[id^="unit"]');
        let hasUnits = false;
        
        units.forEach(unit => {
            if (unit.value && unit.value.trim()) {
                hasUnits = true;
            }
        });

        if (!hasUnits) {
            errors.push('At least one unit is required');
            isValid = false;
            this.highlightError(document.getElementById('unit'));
        } else {
            this.removeError(document.getElementById('unit'));
        }

        // Validate location
        const location = document.getElementById('location');
        if (!location || !location.value) {
            errors.push('Location is required');
            isValid = false;
            this.highlightError(location);
        } else {
            this.removeError(location);
        }

        if (!isValid) {
            this.showNotification('Please fix the validation errors before submitting.', 'error');
        }

        return isValid;
    }

    validateDepartment(input) {
        const value = input.value.trim();
        
        if (!value) {
            this.showFieldError(input, 'Department name is required');
            return false;
        }

        if (value.length < 2) {
            this.showFieldError(input, 'Department name must be at least 2 characters');
            return false;
        }

        if (value.length > 100) {
            this.showFieldError(input, 'Department name must be less than 100 characters');
            return false;
        }

        this.removeFieldError(input);
        return true;
    }

    validateUnit(input) {
        const value = input.value.trim();
        
        if (!value) {
            this.showFieldError(input, 'Unit name is required');
            return false;
        }

        if (value.length < 2) {
            this.showFieldError(input, 'Unit name must be at least 2 characters');
            return false;
        }

        if (value.length > 50) {
            this.showFieldError(input, 'Unit name must be less than 50 characters');
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

    setupUnitManagement() {
        const addUnitBtn = document.getElementById('addunit');
        const unitInput = document.getElementById('unit');

        if (addUnitBtn && unitInput) {
            unitInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        }
    }

    addUnit() {
        const unitInput = document.getElementById('unit');
        const unitadd = document.getElementById('unitadd');
        const serunit = document.getElementById('serunit');

        if (!unitInput || !unitadd || !serunit) return;

        const varunit = unitInput.value.trim().toUpperCase();
        
        if (!varunit) {
            this.showNotification('Please enter a unit name', 'warning');
            unitInput.focus();
            return;
        }

        if (varunit.length < 2) {
            this.showNotification('Unit name must be at least 2 characters', 'warning');
            unitInput.focus();
            return;
        }

        const sno = parseInt(serunit.value);
        
        // Check if unit already exists
        const existingUnits = document.querySelectorAll('[id^="unit"]');
        for (let unit of existingUnits) {
            if (unit.value && unit.value.toUpperCase() === varunit) {
                this.showNotification('Unit already exists', 'warning');
                unitInput.focus();
                return;
            }
        }

        // Create unit row
        const unitRow = document.createElement('tr');
        unitRow.id = `TR${sno}`;
        unitRow.className = 'unit-row';
        unitRow.style.cssText = `
            background: #f8fafc;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        `;

        unitRow.innerHTML = `
            <td class="unit-label" style="
                background: #e2e8f0;
                font-weight: 500;
                color: #475569;
                text-align: center;
                padding: 0.75rem;
                min-width: 80px;
                border-radius: 0.375rem 0 0 0.375rem;
            ">Unit</td>
            <td class="unit-input" style="padding: 0.75rem;">
                <input name="unit${sno}" id="unit${sno}" value="${varunit}" 
                       class="form-input" style="
                           text-transform: uppercase;
                           margin-right: 0.75rem;
                           border: 2px solid #e2e8f0;
                           border-radius: 0.5rem;
                           padding: 0.5rem 0.75rem;
                       " />
                <button type="button" id="delunit${sno}" class="btn btn-danger" 
                        onclick="assetDepartmentManager.deleteUnit(${sno})" style="
                            padding: 0.5rem 0.75rem;
                            border-radius: 0.5rem;
                            font-size: 0.875rem;
                        ">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;

        unitadd.appendChild(unitRow);
        unitInput.value = '';
        serunit.value = sno + 1;

        // Add animation
        unitRow.style.opacity = '0';
        unitRow.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            unitRow.style.transition = 'all 0.3s ease';
            unitRow.style.opacity = '1';
            unitRow.style.transform = 'translateY(0)';
        }, 10);

        this.showNotification(`Unit "${varunit}" added successfully`, 'success');
        unitInput.focus();
    }

    deleteUnit(id) {
        if (!id) return;

        const unitRow = document.getElementById(`TR${id}`);
        if (!unitRow) return;

        unitRow.style.transition = 'all 0.3s ease';
        unitRow.style.opacity = '0';
        unitRow.style.transform = 'translateX(-100%)';

        setTimeout(() => {
            if (unitRow.parentNode) {
                unitRow.parentNode.removeChild(unitRow);
            }
        }, 300);

        this.showNotification('Unit deleted successfully', 'success');
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
    window.assetDepartmentManager = new AssetDepartmentManager();
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
`;
document.head.appendChild(style);

// Global functions for legacy compatibility
function confirmDelete(departmentName, autoNumber) {
    if (confirm(`Are you sure you want to delete the department "${departmentName}"?`)) {
        window.location.href = `addassetdepartmentunit.php?st=del&&anum=${autoNumber}`;
    }
}

function confirmActivate(departmentName, autoNumber) {
    if (confirm(`Are you sure you want to activate the department "${departmentName}"?`)) {
        window.location.href = `addassetdepartmentunit.php?st=activate&&anum=${autoNumber}`;
    }
}

function DelUnit(id) {
    if (window.assetDepartmentManager) {
        window.assetDepartmentManager.deleteUnit(id);
    }
}

function ajaxlocationfunction(val) {
    // Legacy function - can be enhanced if needed
}

function addward1process1() {
    if (window.assetDepartmentManager) {
        return window.assetDepartmentManager.validateForm();
    }
    return true;
}

function funcDeleteDepartment1(varDepartmentAutoNumber) {
    if (confirm(`Are you sure want to delete this Department ${varDepartmentAutoNumber}?`)) {
        alert("Department Entry Delete Completed.");
        return true;
    } else {
        alert("Department Entry Delete Not Completed.");
        return false;
    }
}
