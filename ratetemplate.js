/**
 * Modern JavaScript for Rate Template
 * Handles template selection, validation, and form submission
 */

class RateTemplateManager {
    constructor() {
        this.form = null;
        this.checkboxes = [];
        this.nameInputs = [];
        this.templateItems = [];
        this.selectedTemplates = new Set();
        
        this.init();
    }

    init() {
        this.initializeElements();
        this.setupEventListeners();
        this.setupFormValidation();
        this.initializeTemplateSelection();
    }

    initializeElements() {
        // Get form
        this.form = document.getElementById('form1');
        
        // Get checkboxes and their corresponding inputs
        this.checkboxes = [
            { checkbox: document.getElementById('labcheck'), input: document.getElementById('labname'), type: 'lab' },
            { checkbox: document.getElementById('radcheck'), input: document.getElementById('radname'), type: 'radiology' },
            { checkbox: document.getElementById('sercheck'), input: document.getElementById('sername'), type: 'services' },
            { checkbox: document.getElementById('ipcheck'), input: document.getElementById('ipname'), type: 'ippackage' },
            { checkbox: document.getElementById('bedcheck'), input: document.getElementById('bed'), type: 'bedcharge' }
        ];

        // Get template items for enhanced UI
        this.templateItems = document.querySelectorAll('.template-item');
        
        // Filter out null elements
        this.checkboxes = this.checkboxes.filter(item => item.checkbox && item.input);
    }

    setupEventListeners() {
        // Checkbox change events
        this.checkboxes.forEach(item => {
            if (item.checkbox) {
                item.checkbox.addEventListener('change', (e) => {
                    this.handleCheckboxChange(item, e.target.checked);
                });
            }
        });

        // Input change events for validation
        this.checkboxes.forEach(item => {
            if (item.input) {
                item.input.addEventListener('input', (e) => {
                    this.validateTemplateName(item, e.target.value);
                });
                
                item.input.addEventListener('blur', (e) => {
                    this.validateTemplateName(item, e.target.value);
                });
            }
        });

        // Form submission
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                    return false;
                }
                this.showLoadingState();
            });
        }

        // Enhanced template item interactions
        this.templateItems.forEach(item => {
            item.addEventListener('click', (e) => {
                if (!e.target.closest('input, button')) {
                    this.handleTemplateItemClick(item);
                }
            });
        });
    }

    setupFormValidation() {
        // Add CSS for validation states
        const style = document.createElement('style');
        style.textContent = `
            .template-name-input.is-invalid {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgb(239 68 68 / 0.1);
            }
            
            .template-name-input.is-valid {
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgb(16 185 129 / 0.1);
            }
            
            .template-item.has-error {
                border-color: #ef4444;
                background-color: #fef2f2;
            }
            
            .template-item.has-success {
                border-color: #10b981;
                background-color: #f0fdf4;
            }
        `;
        document.head.appendChild(style);
    }

    initializeTemplateSelection() {
        // Set up initial state
        this.checkboxes.forEach(item => {
            this.updateTemplateItemState(item);
        });
    }

    handleCheckboxChange(item, isChecked) {
        // Update input state
        if (item.input) {
            item.input.disabled = !isChecked;
            if (isChecked) {
                item.input.focus();
                item.input.classList.remove('is-invalid');
            } else {
                item.input.value = '';
                item.input.classList.remove('is-valid', 'is-invalid');
            }
        }

        // Update template selection
        if (isChecked) {
            this.selectedTemplates.add(item.type);
        } else {
            this.selectedTemplates.delete(item.type);
        }

        // Update UI state
        this.updateTemplateItemState(item);
        this.updateFormState();
    }

    handleTemplateItemClick(templateItem) {
        // Find corresponding checkbox
        const checkbox = templateItem.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        }
    }

    updateTemplateItemState(item) {
        const isChecked = item.checkbox?.checked || false;
        const hasValue = item.input?.value.trim() !== '';
        
        // Find the template item container
        const templateItem = item.checkbox?.closest('.template-item') || 
                           item.checkbox?.closest('tr') || 
                           item.checkbox?.parentElement?.parentElement;
        
        if (templateItem) {
            // Remove existing state classes
            templateItem.classList.remove('selected', 'has-error', 'has-success', 'completed');
            
            if (isChecked) {
                templateItem.classList.add('selected');
                
                if (hasValue) {
                    if (this.isValidTemplateName(item.input.value)) {
                        templateItem.classList.add('has-success');
                    } else {
                        templateItem.classList.add('has-error');
                    }
                }
            }
        }
    }

    validateTemplateName(item, value) {
        if (!item.input) return false;

        const isValid = this.isValidTemplateName(value);
        
        // Update input validation state
        item.input.classList.remove('is-valid', 'is-invalid');
        if (value.trim() !== '') {
            item.input.classList.add(isValid ? 'is-valid' : 'is-invalid');
        }

        // Update template item state
        this.updateTemplateItemState(item);
        
        return isValid;
    }

    isValidTemplateName(name) {
        if (!name || name.trim() === '') return false;
        
        // Check for valid characters (alphanumeric and underscore only)
        const validPattern = /^[a-zA-Z0-9_]+$/;
        return validPattern.test(name.trim());
    }

    validateForm() {
        let isValid = true;
        const errors = [];

        // Check if at least one template is selected
        if (this.selectedTemplates.size === 0) {
            errors.push('Please select at least one template type');
            this.showAlert('Please select at least one template type', 'error');
            isValid = false;
        }

        // Validate selected template names
        this.checkboxes.forEach(item => {
            if (item.checkbox?.checked) {
                const name = item.input?.value.trim();
                
                if (!name) {
                    errors.push(`Please enter a name for ${item.type} template`);
                    this.showFieldError(item.input, `${item.type} template name is required`);
                    isValid = false;
                } else if (!this.isValidTemplateName(name)) {
                    errors.push(`Invalid characters in ${item.type} template name`);
                    this.showFieldError(item.input, 'Only letters, numbers, and underscores are allowed');
                    isValid = false;
                } else {
                    this.showFieldSuccess(item.input);
                }
            }
        });

        // Check for duplicate names
        const names = this.checkboxes
            .filter(item => item.checkbox?.checked && item.input?.value.trim())
            .map(item => item.input.value.trim().toLowerCase());
        
        const duplicates = names.filter((name, index) => names.indexOf(name) !== index);
        if (duplicates.length > 0) {
            errors.push('Template names must be unique');
            this.showAlert('Template names must be unique', 'error');
            isValid = false;
        }

        if (!isValid) {
            this.showAlert('Please correct the errors below', 'error');
        }

        return isValid;
    }

    showFieldError(input, message) {
        if (!input) return;

        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        
        // Remove existing error message
        const existingError = input.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
    }

    showFieldSuccess(input) {
        if (!input) return;

        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        
        // Remove existing error message
        const existingError = input.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    }

    updateFormState() {
        // Update submit button state
        const submitButton = document.getElementById('save');
        if (submitButton) {
            submitButton.disabled = this.selectedTemplates.size === 0;
        }

        // Update progress indicator if exists
        this.updateProgressIndicator();
    }

    updateProgressIndicator() {
        const progressIndicator = document.querySelector('.progress-indicator');
        if (progressIndicator) {
            const steps = progressIndicator.querySelectorAll('.progress-step');
            const selectedCount = this.selectedTemplates.size;
            const totalCount = this.checkboxes.length;

            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed', 'pending');
                
                if (index < selectedCount) {
                    step.classList.add('completed');
                } else if (index === selectedCount) {
                    step.classList.add('active');
                } else {
                    step.classList.add('pending');
                }
            });
        }
    }

    showLoadingState(message = 'Creating templates...') {
        // Create loading overlay
        const overlay = document.createElement('div');
        overlay.id = 'loading-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        `;
        
        const loadingDiv = document.createElement('div');
        loadingDiv.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        `;
        
        loadingDiv.innerHTML = `
            <div class="spinner" style="width: 2rem; height: 2rem; border: 3px solid #f3f4f6; border-top: 3px solid #2563eb; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
            <p style="margin: 0; color: #374151;">${message}</p>
        `;
        
        overlay.appendChild(loadingDiv);
        document.body.appendChild(overlay);
    }

    hideLoadingState() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    }

    showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        
        // Add icon based on type
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        
        alert.innerHTML = `
            <span class="alert-icon">${icons[type] || icons.info}</span>
            <span>${message}</span>
        `;
        
        // Insert at the top of the form container
        const formContainer = document.querySelector('.form-container') || document.body;
        formContainer.insertBefore(alert, formContainer.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Enhanced template management methods
    getSelectedTemplates() {
        return Array.from(this.selectedTemplates);
    }

    getTemplateData() {
        const data = {};
        this.checkboxes.forEach(item => {
            if (item.checkbox?.checked && item.input?.value.trim()) {
                data[item.type] = {
                    name: item.input.value.trim(),
                    enabled: true
                };
            }
        });
        return data;
    }

    resetForm() {
        // Uncheck all checkboxes
        this.checkboxes.forEach(item => {
            if (item.checkbox) {
                item.checkbox.checked = false;
            }
            if (item.input) {
                item.input.value = '';
                item.input.disabled = true;
                item.input.classList.remove('is-valid', 'is-invalid');
            }
        });

        // Clear selection
        this.selectedTemplates.clear();

        // Update UI state
        this.checkboxes.forEach(item => {
            this.updateTemplateItemState(item);
        });
        this.updateFormState();

        // Remove error messages
        document.querySelectorAll('.invalid-feedback').forEach(error => {
            error.remove();
        });

        // Remove alerts
        document.querySelectorAll('.alert').forEach(alert => {
            alert.remove();
        });
    }

    // Template name suggestions
    generateTemplateName(type) {
        const suggestions = {
            lab: 'lab_template',
            radiology: 'radiology_template',
            services: 'services_template',
            ippackage: 'ip_package_template',
            bedcharge: 'bed_charge_template'
        };
        
        return suggestions[type] || `${type}_template`;
    }

    // Auto-suggest names when checkboxes are checked
    setupAutoSuggestions() {
        this.checkboxes.forEach(item => {
            if (item.checkbox && item.input) {
                item.checkbox.addEventListener('change', (e) => {
                    if (e.target.checked && !item.input.value.trim()) {
                        item.input.value = this.generateTemplateName(item.type);
                        this.validateTemplateName(item, item.input.value);
                    }
                });
            }
        });
    }

    // Utility methods
    formatTemplateName(name) {
        return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
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

    // Initialize auto-suggestions
    initAutoSuggestions() {
        this.setupAutoSuggestions();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const rateTemplateManager = new RateTemplateManager();
    
    // Initialize auto-suggestions
    rateTemplateManager.initAutoSuggestions();
    
    // Make it globally available for debugging
    window.rateTemplateManager = rateTemplateManager;
});

// Export for potential external use
window.RateTemplateManager = RateTemplateManager;


