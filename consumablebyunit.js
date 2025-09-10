/**
 * Modern JavaScript for consumablebyunit.php
 * Enhanced functionality with modern ES6+ features
 */

class ConsumableByUnitManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupDatePickers();
        this.setupStoreManagement();
        this.setupExportFeatures();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Consumable By Unit Manager initialized');
    }

    addModernStyling() {
        // Add modern classes to existing elements
        const containers = document.querySelectorAll('table[width="1500"]');
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
            if (button.value.toLowerCase().includes('search')) {
                button.classList.add('btn', 'btn-primary');
            } else {
                button.classList.add('btn', 'btn-success');
            }
        });

        // Enhance selects
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.classList.add('form-select');
        });

        // Enhance date inputs
        const dateInputs = document.querySelectorAll('input[readonly]');
        dateInputs.forEach(input => {
            input.classList.add('form-input');
            if (input.name.includes('Date')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'date-input-group';
                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(input);
                
                const icon = input.nextElementSibling;
                if (icon && icon.tagName === 'IMG') {
                    icon.classList.add('date-picker-icon');
                    wrapper.appendChild(icon);
                }
            }
        });

        // Enhance export links
        const exportLinks = document.querySelectorAll('a[href*="print_consumablebyunit.php"]');
        exportLinks.forEach(link => {
            link.classList.add('action-btn', 'export');
            link.innerHTML = '📊 Export to Excel';
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

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });
    }

    setupFormValidation() {
        // Custom validation rules
        this.validationRules = {
            location: {
                required: false,
                message: 'Please select a location'
            },
            fromstore: {
                required: false,
                message: 'Please select a store'
            },
            ADate1: {
                required: true,
                message: 'Please select a start date'
            },
            ADate2: {
                required: true,
                message: 'Please select an end date'
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
        
        // Date validation
        if (isValid && field.name.includes('Date') && field.value) {
            const date = new Date(field.value);
            if (isNaN(date.getTime())) {
                isValid = false;
                errorMessage = 'Please enter a valid date';
            }
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
        
        // Validate date range
        const startDate = form.querySelector('input[name="ADate1"]');
        const endDate = form.querySelector('input[name="ADate2"]');
        
        if (startDate && endDate && startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            
            if (start > end) {
                isFormValid = false;
                this.showFieldError(endDate, 'End date must be after start date');
            }
        }
        
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
        }
        
        return true;
    }

    setupDatePickers() {
        // Enhanced date picker functionality
        const dateInputs = document.querySelectorAll('input[name*="Date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', () => {
                this.validateDateRange();
            });
        });
    }

    validateDateRange() {
        const startDate = document.querySelector('input[name="ADate1"]');
        const endDate = document.querySelector('input[name="ADate2"]');
        
        if (startDate && endDate && startDate.value && endDate.value) {
            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            
            if (start > end) {
                this.showFieldError(endDate, 'End date must be after start date');
                return false;
            } else {
                this.clearFieldError(endDate);
            }
        }
        
        return true;
    }

    setupStoreManagement() {
        // Enhanced store management functionality
        this.initializeStoreDropdowns();
    }

    initializeStoreDropdowns() {
        // This would typically load stores based on location
        const locationSelect = document.getElementById('location');
        const storeSelect = document.getElementById('fromstore');
        
        if (locationSelect && storeSelect) {
            // Add loading state to store dropdown
            storeSelect.innerHTML = '<option value="">Loading stores...</option>';
        }
    }

    handleLocationChange(locationCode) {
        const storeSelect = document.getElementById('fromstore');
        if (storeSelect) {
            storeSelect.innerHTML = '<option value="">Loading stores...</option>';
            
            if (locationCode) {
                this.loadStoresForLocation(locationCode);
            } else {
                storeSelect.innerHTML = '<option value="">All Stores</option>';
            }
        }
    }

    async loadStoresForLocation(locationCode) {
        try {
            const response = await fetch(`ajax/ajaxstore.php?loc=${locationCode}&username=${this.getUsername()}`);
            const html = await response.text();
            
            const storeSelect = document.getElementById('fromstore');
            if (storeSelect) {
                storeSelect.innerHTML = html;
            }
        } catch (error) {
            console.error('Error loading stores:', error);
            this.showNotification('Error loading stores for selected location', 'error');
        }
    }

    getUsername() {
        const usernameInput = document.getElementById('username');
        return usernameInput ? usernameInput.value : '';
    }

    setupExportFeatures() {
        // Enhanced export functionality
        this.enhanceExportLinks();
        this.addExportButtons();
    }

    enhanceExportLinks() {
        const exportLinks = document.querySelectorAll('a[href*="print_consumablebyunit.php"]');
        exportLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                this.handleExportClick(e);
            });
        });
    }

    handleExportClick(e) {
        const link = e.target.closest('a');
        if (link) {
            // Add loading state
            const originalText = link.innerHTML;
            link.innerHTML = '⏳ Exporting...';
            link.style.pointerEvents = 'none';
            
            // Reset after a delay
            setTimeout(() => {
                link.innerHTML = originalText;
                link.style.pointerEvents = 'auto';
            }, 2000);
        }
    }

    addExportButtons() {
        // Add additional export options
        const exportSection = document.createElement('div');
        exportSection.className = 'export-section';
        exportSection.innerHTML = `
            <h3>Export Options</h3>
            <div class="export-actions">
                <button class="btn btn-success" onclick="consumableManager.exportToExcel()">
                    📊 Export to Excel
                </button>
                <button class="btn btn-info" onclick="consumableManager.exportToPDF()">
                    📄 Export to PDF
                </button>
                <button class="btn btn-warning" onclick="consumableManager.printReport()">
                    🖨️ Print Report
                </button>
            </div>
        `;
        
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            formSection.parentNode.insertBefore(exportSection, formSection.nextSibling);
        }
    }

    exportToExcel() {
        const form = document.querySelector('form[name="form1"]');
        if (form) {
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            
            const exportUrl = `print_consumablebyunit.php?${params.toString()}&frmflag1=frmflag1`;
            window.open(exportUrl, '_blank');
            
            this.showNotification('Excel export initiated', 'success');
        }
    }

    exportToPDF() {
        this.showNotification('PDF export feature coming soon', 'info');
    }

    printReport() {
        window.print();
        this.showNotification('Print dialog opened', 'info');
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
        
        // Ctrl/Cmd + E to export
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            this.exportToExcel();
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
        const elements = document.querySelectorAll('.form-section, .data-table-container, .export-section');
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
        
        // Add summary section
        this.addSummarySection();
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
                <h4 style="margin-bottom: 10px; color: #495057;">💡 Search Tips:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li>Select location and store to filter results</li>
                    <li>Choose date range to view consumption for specific period</li>
                    <li>Press Ctrl+Enter to submit quickly</li>
                    <li>Press Ctrl+E to export to Excel</li>
                    <li>Press Escape to clear the form</li>
                </ul>
            `;
            
            formSection.appendChild(tipsDiv);
        }
    }

    addSummarySection() {
        // Add summary statistics
        const summarySection = document.createElement('div');
        summarySection.className = 'summary-section';
        summarySection.innerHTML = `
            <h3>Report Summary</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <h4>Total Items</h4>
                    <div class="value" id="totalItems">-</div>
                </div>
                <div class="summary-item">
                    <h4>Total Quantity</h4>
                    <div class="value" id="totalQuantity">-</div>
                </div>
                <div class="summary-item">
                    <h4>Total Amount</h4>
                    <div class="value currency" id="totalAmount">-</div>
                </div>
                <div class="summary-item">
                    <h4>Unique Stores</h4>
                    <div class="value" id="uniqueStores">-</div>
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
        const table = document.querySelector('.data-table tbody');
        if (!table) return;
        
        const rows = table.querySelectorAll('tr');
        let totalItems = 0;
        let totalQuantity = 0;
        let totalAmount = 0;
        const uniqueStores = new Set();
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                totalItems++;
                
                // Extract quantity (assuming it's in the 9th column)
                if (cells[8]) {
                    const quantity = parseFloat(cells[8].textContent) || 0;
                    totalQuantity += quantity;
                }
                
                // Extract amount (assuming it's in the 11th column)
                if (cells[10]) {
                    const amount = parseFloat(cells[10].textContent.replace(/,/g, '')) || 0;
                    totalAmount += amount;
                }
                
                // Extract store name (assuming it's in the 3rd column)
                if (cells[2]) {
                    uniqueStores.add(cells[2].textContent.trim());
                }
            }
        });
        
        // Update summary display
        document.getElementById('totalItems').textContent = totalItems;
        document.getElementById('totalQuantity').textContent = totalQuantity.toLocaleString();
        document.getElementById('totalAmount').textContent = '₹' + totalAmount.toLocaleString();
        document.getElementById('uniqueStores').textContent = uniqueStores.size;
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
function process1() {
    const form = document.querySelector('form[name="form1"]');
    if (form && consumableManager) {
        return consumableManager.handleFormSubmit({ target: form, preventDefault: () => {} });
    }
    return true;
}

function funcSelectFromStore(id) {
    // Legacy function - now handled by the modern manager
    if (consumableManager) {
        consumableManager.handleLocationChange(id);
    }
}

function loadprintpage1(canum) {
    const varcanum = canum;
    window.open(`print_renewal1.php?canum=${varcanum}`, `Window${varcanum}`, 
        'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function storefunction(loc) {
    if (consumableManager) {
        consumableManager.handleLocationChange(loc);
    }
}

// Initialize the manager when DOM is ready
let consumableManager;

document.addEventListener('DOMContentLoaded', () => {
    consumableManager = new ConsumableByUnitManager();
    
    // Initialize store dropdown on page load
    const locationSelect = document.getElementById('location');
    if (locationSelect && locationSelect.value) {
        consumableManager.handleLocationChange(locationSelect.value);
    }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConsumableByUnitManager;
}


