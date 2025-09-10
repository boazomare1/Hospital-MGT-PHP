/**
 * Modern JavaScript for costcenter.php
 * Enhanced functionality with modern ES6+ features
 */

class CostCenterManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupLocationManagement();
        this.setupCostCenterManagement();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Cost Center Manager initialized');
    }

    addModernStyling() {
        // Add modern classes to existing elements
        const containers = document.querySelectorAll('table[width="101%"]');
        containers.forEach(container => {
            container.classList.add('main-container', 'fade-in');
        });

        // Enhance form sections
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.classList.add('form-section');
        });

        // Enhance tables
        const tables = document.querySelectorAll('table[style*="border-collapse"]');
        tables.forEach(table => {
            table.classList.add('data-table');
            const container = document.createElement('div');
            container.className = 'data-table-container';
            table.parentNode.insertBefore(container, table);
            container.appendChild(table);
        });

        // Enhance buttons
        const buttons = document.querySelectorAll('input[type="submit"]');
        buttons.forEach(button => {
            button.classList.add('btn', 'btn-success');
            button.innerHTML = '💾 Add Cost Center';
        });

        // Enhance inputs
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.classList.add('form-input');
            if (input.name === 'department') {
                input.classList.add('uppercase-input');
            }
        });

        // Enhance selects
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.classList.add('form-select');
        });

        // Enhance action links
        const deleteLinks = document.querySelectorAll('a[href*="st=del"]');
        deleteLinks.forEach(link => {
            link.classList.add('action-btn', 'delete');
            link.innerHTML = '🗑️ Delete';
        });

        const editLinks = document.querySelectorAll('a[href*="editcostcenter1.php"]');
        editLinks.forEach(link => {
            link.classList.add('action-btn', 'edit');
            link.innerHTML = '✏️ Edit';
        });

        const activateLinks = document.querySelectorAll('a[href*="st=activate"]');
        activateLinks.forEach(link => {
            link.classList.add('action-btn', 'activate');
            link.innerHTML = '✅ Activate';
        });
    }

    setupEventListeners() {
        // Form submission enhancement
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                this.handleFormSubmit(e);
            });
        });

        // Real-time validation
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
            });
        });

        // Location change handler
        const locationSelect = document.getElementById('location');
        if (locationSelect) {
            locationSelect.addEventListener('change', (e) => {
                this.handleLocationChange(e.target.value);
            });
        }

        // Cost center name input enhancement
        const costCenterInput = document.getElementById('department');
        if (costCenterInput) {
            costCenterInput.addEventListener('input', (e) => {
                this.handleCostCenterNameChange(e.target.value);
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });

        // Enhanced action handlers
        this.setupActionHandlers();
    }

    setupActionHandlers() {
        // Delete confirmation
        const deleteLinks = document.querySelectorAll('a[href*="st=del"]');
        deleteLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleDeleteCostCenter(link);
            });
        });

        // Activate confirmation
        const activateLinks = document.querySelectorAll('a[href*="st=activate"]');
        activateLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleActivateCostCenter(link);
            });
        });
    }

    handleDeleteCostCenter(link) {
        const href = link.getAttribute('href');
        const matches = href.match(/anum=(\d+)/);
        const costCenterId = matches ? matches[1] : 'Unknown';
        
        this.showDeleteModal(costCenterId, href);
    }

    handleActivateCostCenter(link) {
        const href = link.getAttribute('href');
        const matches = href.match(/anum=(\d+)/);
        const costCenterId = matches ? matches[1] : 'Unknown';
        
        this.showActivateModal(costCenterId, href);
    }

    showDeleteModal(costCenterId, href) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.id = 'deleteModal';
        
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>🗑️ Delete Cost Center</h3>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>⚠️ Confirmation Required</strong><br>
                        Are you sure you want to delete this cost center?
                    </div>
                    <div class="cost-center-details">
                        <p><strong>Cost Center ID:</strong> ${costCenterId}</p>
                        <p><strong>Action:</strong> This will mark the cost center as deleted</p>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 20px; text-align: right;">
                    <button class="btn btn-secondary" id="cancelDelete">Cancel</button>
                    <button class="btn btn-danger" id="confirmDelete">Delete Cost Center</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        modal.style.display = 'block';
        
        // Setup modal event listeners
        const closeBtn = modal.querySelector('.close');
        const cancelBtn = modal.querySelector('#cancelDelete');
        const confirmBtn = modal.querySelector('#confirmDelete');
        
        closeBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        cancelBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        confirmBtn.addEventListener('click', () => {
            window.location.href = href;
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeModal(modal);
            }
        });
    }

    showActivateModal(costCenterId, href) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.id = 'activateModal';
        
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>✅ Activate Cost Center</h3>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>ℹ️ Confirmation Required</strong><br>
                        Are you sure you want to activate this cost center?
                    </div>
                    <div class="cost-center-details">
                        <p><strong>Cost Center ID:</strong> ${costCenterId}</p>
                        <p><strong>Action:</strong> This will restore the cost center to active status</p>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 20px; text-align: right;">
                    <button class="btn btn-secondary" id="cancelActivate">Cancel</button>
                    <button class="btn btn-success" id="confirmActivate">Activate Cost Center</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        modal.style.display = 'block';
        
        // Setup modal event listeners
        const closeBtn = modal.querySelector('.close');
        const cancelBtn = modal.querySelector('#cancelActivate');
        const confirmBtn = modal.querySelector('#confirmActivate');
        
        closeBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        cancelBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        confirmBtn.addEventListener('click', () => {
            window.location.href = href;
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeModal(modal);
            }
        });
    }

    closeModal(modal) {
        modal.style.display = 'none';
        document.body.removeChild(modal);
    }

    setupFormValidation() {
        // Custom validation rules
        this.validationRules = {
            department: {
                required: true,
                minLength: 2,
                maxLength: 100,
                pattern: /^[A-Z0-9\s]+$/,
                message: 'Cost center name must be 2-100 characters and contain only letters, numbers, and spaces'
            },
            location: {
                required: true,
                message: 'Please select a location'
            }
        };
    }

    validateField(field) {
        const rules = this.validationRules[field.name];
        if (!rules) return true;
        
        let isValid = true;
        let errorMessage = '';
        
        // Required validation
        if (rules.required && !field.value.trim()) {
            isValid = false;
            errorMessage = rules.message || `${field.name} is required`;
        }
        
        // Length validation
        if (isValid && rules.minLength && field.value.length < rules.minLength) {
            isValid = false;
            errorMessage = rules.message || `${field.name} must be at least ${rules.minLength} characters`;
        }
        
        if (isValid && rules.maxLength && field.value.length > rules.maxLength) {
            isValid = false;
            errorMessage = rules.message || `${field.name} must be no more than ${rules.maxLength} characters`;
        }
        
        // Pattern validation
        if (isValid && rules.pattern && !rules.pattern.test(field.value)) {
            isValid = false;
            errorMessage = rules.message || `${field.name} format is invalid`;
        }
        
        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }
        
        return isValid;
    }

    showFieldError(field, message) {
        this.clearFieldError(field);
        
        field.classList.add('error');
        field.style.borderColor = '#dc3545';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = `
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        `;
        errorDiv.innerHTML = `⚠️ ${message}`;
        
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        field.classList.remove('error');
        field.style.borderColor = '';
        
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    handleFormSubmit(e) {
        const form = e.target;
        const inputs = form.querySelectorAll('input, select');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        if (!isFormValid) {
            e.preventDefault();
            this.showNotification('Please fix the errors before submitting', 'error');
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('input[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.value = '⏳ Adding...';
        }
        
        return true;
    }

    setupLocationManagement() {
        // Enhanced location management functionality
        this.initializeLocationDropdown();
    }

    initializeLocationDropdown() {
        const locationSelect = document.getElementById('location');
        if (locationSelect) {
            // Add change handler for location updates
            locationSelect.addEventListener('change', (e) => {
                this.updateLocationDisplay(e.target.value);
            });
        }
    }

    handleLocationChange(locationCode) {
        this.updateLocationDisplay(locationCode);
    }

    async updateLocationDisplay(locationCode) {
        try {
            const response = await fetch(`ajax/ajaxgetlocationname.php?loccode=${locationCode}`);
            const locationName = await response.text();
            
            const locationDisplay = document.getElementById('ajaxlocation');
            if (locationDisplay) {
                locationDisplay.innerHTML = `<strong>Location: ${locationName}</strong>`;
            }
        } catch (error) {
            console.error('Error updating location display:', error);
        }
    }

    setupCostCenterManagement() {
        // Enhanced cost center management functionality
        this.addCostCenterSummary();
        this.enhanceCostCenterList();
    }

    addCostCenterSummary() {
        const summarySection = document.createElement('div');
        summarySection.className = 'cost-center-management';
        summarySection.innerHTML = `
            <h3>Cost Center Summary</h3>
            <div class="summary-grid" id="costCenterSummary">
                <div class="summary-item">
                    <h4>Total Cost Centers</h4>
                    <div class="value" id="totalCostCenters">-</div>
                </div>
                <div class="summary-item">
                    <h4>Active Cost Centers</h4>
                    <div class="value" id="activeCostCenters">-</div>
                </div>
                <div class="summary-item">
                    <h4>Deleted Cost Centers</h4>
                    <div class="value" id="deletedCostCenters">-</div>
                </div>
                <div class="summary-item">
                    <h4>Locations</h4>
                    <div class="value" id="totalLocations">-</div>
                </div>
            </div>
        `;
        
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            formSection.parentNode.insertBefore(summarySection, formSection.nextSibling);
        }
        
        // Calculate summary after page load
        setTimeout(() => {
            this.calculateSummary();
        }, 1000);
    }

    calculateSummary() {
        const tables = document.querySelectorAll('.data-table tbody');
        let totalCostCenters = 0;
        let activeCostCenters = 0;
        let deletedCostCenters = 0;
        const locations = new Set();
        
        tables.forEach((table, index) => {
            const rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 0) {
                    totalCostCenters++;
                    
                    // Check if it's an active or deleted cost center
                    if (index === 0) { // Active cost centers table
                        activeCostCenters++;
                    } else if (index === 1) { // Deleted cost centers table
                        deletedCostCenters++;
                    }
                    
                    // Extract location name (assuming it's in the 4th column for active cost centers)
                    if (cells[3] && index === 0) {
                        locations.add(cells[3].textContent.trim());
                    }
                }
            });
        });
        
        // Update summary display
        document.getElementById('totalCostCenters').textContent = totalCostCenters;
        document.getElementById('activeCostCenters').textContent = activeCostCenters;
        document.getElementById('deletedCostCenters').textContent = deletedCostCenters;
        document.getElementById('totalLocations').textContent = locations.size;
    }

    enhanceCostCenterList() {
        // Add search functionality
        this.addSearchFunctionality();
        
        // Add bulk actions
        this.addBulkActions();
    }

    addSearchFunctionality() {
        const searchContainer = document.createElement('div');
        searchContainer.className = 'search-container';
        searchContainer.style.cssText = `
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        `;
        
        searchContainer.innerHTML = `
            <div style="display: flex; gap: 15px; align-items: center;">
                <div style="flex: 1;">
                    <input type="text" id="costCenterSearch" placeholder="Search cost centers..." 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <button class="btn btn-secondary" onclick="costCenterManager.clearSearch()">Clear</button>
            </div>
        `;
        
        const firstTable = document.querySelector('.data-table-container');
        if (firstTable) {
            firstTable.parentNode.insertBefore(searchContainer, firstTable);
        }
        
        // Setup search functionality
        const searchInput = document.getElementById('costCenterSearch');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterCostCenters(e.target.value);
            });
        }
    }

    filterCostCenters(searchTerm) {
        const tables = document.querySelectorAll('.data-table tbody');
        const term = searchTerm.toLowerCase();
        
        tables.forEach(table => {
            const rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let shouldShow = false;
                
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(term)) {
                        shouldShow = true;
                    }
                });
                
                row.style.display = shouldShow ? '' : 'none';
            });
        });
    }

    clearSearch() {
        const searchInput = document.getElementById('costCenterSearch');
        if (searchInput) {
            searchInput.value = '';
            this.filterCostCenters('');
        }
    }

    addBulkActions() {
        const bulkActionsContainer = document.createElement('div');
        bulkActionsContainer.className = 'bulk-actions';
        bulkActionsContainer.style.cssText = `
            margin-bottom: 20px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 8px;
            display: none;
        `;
        
        bulkActionsContainer.innerHTML = `
            <div style="display: flex; gap: 15px; align-items: center;">
                <span style="font-weight: 600;">Bulk Actions:</span>
                <button class="btn btn-danger" onclick="costCenterManager.bulkDelete()">Delete Selected</button>
                <button class="btn btn-warning" onclick="costCenterManager.bulkActivate()">Activate Selected</button>
                <button class="btn btn-secondary" onclick="costCenterManager.clearSelection()">Clear Selection</button>
            </div>
        `;
        
        const searchContainer = document.querySelector('.search-container');
        if (searchContainer) {
            searchContainer.parentNode.insertBefore(bulkActionsContainer, searchContainer.nextSibling);
        }
    }

    handleCostCenterNameChange(value) {
        // Auto-format cost center name
        const formattedValue = value.toUpperCase().replace(/[^A-Z0-9\s]/g, '');
        if (formattedValue !== value) {
            document.getElementById('department').value = formattedValue;
        }
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + Enter to submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            const form = document.querySelector('form[name="form1"]');
            if (form) {
                form.submit();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            const form = document.querySelector('form[name="form1"]');
            if (form) {
                form.reset();
                this.clearAllFieldErrors();
            }
        }
        
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById('costCenterSearch');
            if (searchInput) {
                searchInput.focus();
            }
        }
    }

    clearAllFieldErrors() {
        const errorFields = document.querySelectorAll('.field-error');
        errorFields.forEach(error => error.remove());
        
        const inputs = document.querySelectorAll('input.error, select.error');
        inputs.forEach(input => {
            input.classList.remove('error');
            input.style.borderColor = '';
        });
    }

    initializeAnimations() {
        // Add fade-in animation to elements
        const elements = document.querySelectorAll('.form-section, .data-table-container, .cost-center-management');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    enhanceFormElements() {
        // Add form tips
        this.addFormTips();
    }

    addFormTips() {
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            const tipsDiv = document.createElement('div');
            tipsDiv.className = 'form-tips';
            tipsDiv.style.cssText = `
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            `;
            
            tipsDiv.innerHTML = `
                <h4 style="margin-bottom: 10px; color: #495057;">💡 Cost Center Tips:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li>Cost center names are automatically converted to uppercase</li>
                    <li>Only letters, numbers, and spaces are allowed in cost center names</li>
                    <li>Maximum 100 characters allowed for cost center names</li>
                    <li>Press Ctrl+Enter to submit quickly</li>
                    <li>Press Ctrl+F to search cost centers</li>
                    <li>Press Escape to clear the form</li>
                </ul>
            `;
            
            formSection.appendChild(tipsDiv);
        }
    }

    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : type === 'warning' ? '#ffc107' : '#17a2b8'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : type === 'warning' ? '⚠️' : 'ℹ️';
        notification.innerHTML = `${icon} ${message}`;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, duration);
    }

    // Utility methods
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

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
}

// Enhanced legacy functions for backward compatibility
function addward1process1() {
    const form = document.querySelector('form[name="form1"]');
    if (form && costCenterManager) {
        return costCenterManager.handleFormSubmit({ target: form, preventDefault: () => {} });
    }
    return true;
}

function ajaxlocationfunction(val) {
    if (costCenterManager) {
        costCenterManager.handleLocationChange(val);
    }
}

function funcDeleteDepartment1(varDepartmentAutoNumber) {
    // Legacy function - now handled by the modern manager
    console.log('Delete function called for:', varDepartmentAutoNumber);
    return true;
}

function noDecimal(evt) {
    const charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}

// Initialize the manager when DOM is ready
let costCenterManager;

document.addEventListener('DOMContentLoaded', () => {
    costCenterManager = new CostCenterManager();
    
    // Initialize location display
    const locationSelect = document.getElementById('location');
    if (locationSelect && locationSelect.value) {
        costCenterManager.updateLocationDisplay(locationSelect.value);
    }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CostCenterManager;
}


