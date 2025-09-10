/**
 * Modern JavaScript for consultationmasterwithdept.php
 * Enhanced functionality with modern ES6+ features
 */

class ConsultationMasterManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupAutocomplete();
        this.setupFormValidation();
        this.setupInfiniteScroll();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize tooltips and animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Consultation Master Manager initialized');
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
        const buttons = document.querySelectorAll('input[type="submit"], input[type="button"]');
        buttons.forEach(button => {
            if (button.value.toLowerCase().includes('submit')) {
                button.classList.add('btn', 'btn-primary');
            } else if (button.value.toLowerCase().includes('search')) {
                button.classList.add('btn', 'btn-secondary');
            } else {
                button.classList.add('btn', 'btn-success');
            }
        });

        // Enhance inputs
        const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
        inputs.forEach(input => {
            input.classList.add('form-input');
            if (input.name === 'consultationtype') {
                input.classList.add('uppercase-input');
            }
            if (input.name === 'consultationfees') {
                input.classList.add('currency-input');
            }
        });

        // Enhance selects
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.classList.add('form-select');
        });

        // Enhance checkboxes
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            const wrapper = document.createElement('div');
            wrapper.className = 'checkbox-group';
            checkbox.parentNode.insertBefore(wrapper, checkbox);
            wrapper.appendChild(checkbox);
            if (checkbox.nextSibling) {
                wrapper.appendChild(checkbox.nextSibling);
            }
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

        // Payment type change handler
        const paymentTypeSelect = document.getElementById('paymenttype');
        if (paymentTypeSelect) {
            paymentTypeSelect.addEventListener('change', (e) => {
                this.handlePaymentTypeChange(e.target.value);
            });
        }

        // Location change handler
        const locationSelect = document.getElementById('location');
        if (locationSelect) {
            locationSelect.addEventListener('change', (e) => {
                this.handleLocationChange(e.target.value);
            });
        }

        // Auto-save functionality
        this.setupAutoSave();
    }

    setupAutocomplete() {
        // Enhanced autocomplete for doctor names
        const doctorNameInput = document.getElementById('consultationdoctorname');
        if (doctorNameInput) {
            this.setupDoctorAutocomplete(doctorNameInput);
        }

        // Enhanced autocomplete for supplier names
        const supplierNameInput = document.getElementById('searchsuppliername');
        if (supplierNameInput) {
            this.setupSupplierAutocomplete(supplierNameInput);
        }

        // Enhanced autocomplete for department names
        const departmentNameInput = document.getElementById('searchdepartmentname');
        if (departmentNameInput) {
            this.setupDepartmentAutocomplete(departmentNameInput);
        }
    }

    setupDoctorAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchDoctorSuggestions(query, input);
            }, 300);
        });

        // Handle selection
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === 'Tab') {
                e.preventDefault();
                this.selectAutocompleteItem();
            }
        });
    }

    setupSupplierAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchSupplierSuggestions(query, input);
            }, 300);
        });
    }

    setupDepartmentAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchDepartmentSuggestions(query, input);
            }, 300);
        });
    }

    async fetchDoctorSuggestions(query, input) {
        try {
            const response = await fetch(`ajaxdoctornamesearch.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'doctor');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching doctor suggestions:', error);
        }
    }

    async fetchSupplierSuggestions(query, input) {
        try {
            const response = await fetch(`ajaxaccountsub_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'supplier');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching supplier suggestions:', error);
        }
    }

    async fetchDepartmentSuggestions(query, input) {
        try {
            const response = await fetch(`ajaxdepartment_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'department');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching department suggestions:', error);
        }
    }

    showAutocomplete(suggestions, input, type) {
        this.hideAutocomplete();
        
        const dropdown = document.createElement('div');
        dropdown.className = 'autocomplete-dropdown';
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        `;
        
        suggestions.forEach((item, index) => {
            const option = document.createElement('div');
            option.className = 'autocomplete-option';
            option.style.cssText = `
                padding: 12px 16px;
                cursor: pointer;
                border-bottom: 1px solid #f0f0f0;
                transition: background-color 0.2s;
            `;
            
            if (type === 'doctor') {
                option.textContent = item.value || item;
                option.dataset.doctorcode = item.doctorcode || '';
            } else if (type === 'supplier') {
                option.textContent = item.value || item;
                option.dataset.suppliercode = item.id || '';
                option.dataset.supplieranum = item.anum || '';
            } else if (type === 'department') {
                option.textContent = item.value || item;
                option.dataset.departmentcode = item.id || '';
                option.dataset.departmentanum = item.anum || '';
            }
            
            option.addEventListener('mouseenter', () => {
                option.style.backgroundColor = '#f8f9fa';
            });
            
            option.addEventListener('mouseleave', () => {
                option.style.backgroundColor = 'white';
            });
            
            option.addEventListener('click', () => {
                this.selectAutocompleteItem(option, input, type);
            });
            
            dropdown.appendChild(option);
        });
        
        input.parentNode.style.position = 'relative';
        input.parentNode.appendChild(dropdown);
    }

    hideAutocomplete() {
        const existing = document.querySelector('.autocomplete-dropdown');
        if (existing) {
            existing.remove();
        }
    }

    selectAutocompleteItem(option, input, type) {
        if (!option) return;
        
        input.value = option.textContent;
        
        if (type === 'doctor') {
            const doctorCodeInput = document.getElementById('consultationdoctorcode');
            if (doctorCodeInput) {
                doctorCodeInput.value = option.dataset.doctorcode || '';
            }
        } else if (type === 'supplier') {
            const supplierCodeInput = document.getElementById('searchsuppliercode');
            const supplierAnumInput = document.getElementById('searchsupplieranum');
            if (supplierCodeInput) supplierCodeInput.value = option.dataset.suppliercode || '';
            if (supplierAnumInput) supplierAnumInput.value = option.dataset.supplieranum || '';
        } else if (type === 'department') {
            const departmentCodeInput = document.getElementById('searchdepartmentcode');
            const departmentAnumInput = document.getElementById('searchdepartmentanum');
            if (departmentCodeInput) departmentCodeInput.value = option.dataset.departmentcode || '';
            if (departmentAnumInput) departmentAnumInput.value = option.dataset.departmentanum || '';
        }
        
        this.hideAutocomplete();
    }

    setupFormValidation() {
        // Custom validation rules
        this.validationRules = {
            consultationtype: {
                required: true,
                minLength: 2,
                maxLength: 100,
                pattern: /^[a-zA-Z\s]+$/,
                message: 'Consultation type must be 2-100 characters and contain only letters and spaces'
            },
            consultationfees: {
                required: true,
                pattern: /^\d+(\.\d{1,2})?$/,
                message: 'Please enter a valid consultation fee (numbers only)'
            },
            location: {
                required: true,
                message: 'Please select a location'
            },
            department: {
                required: true,
                message: 'Please select a department'
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
        }
        
        return true;
    }

    handlePaymentTypeChange(paymentTypeId) {
        if (!paymentTypeId) {
            this.clearSubtypeOptions();
            return;
        }
        
        // Fetch subtypes for the selected payment type
        this.fetchSubtypes(paymentTypeId);
    }

    async fetchSubtypes(paymentTypeId) {
        try {
            const response = await fetch(`ajax/get_subtypes.php?paymenttype=${paymentTypeId}`);
            const subtypes = await response.json();
            
            this.updateSubtypeOptions(subtypes);
        } catch (error) {
            console.error('Error fetching subtypes:', error);
            this.showNotification('Error loading subtypes', 'error');
        }
    }

    updateSubtypeOptions(subtypes) {
        const subtypeSelect = document.getElementById('subtype');
        if (!subtypeSelect) return;
        
        // Clear existing options
        subtypeSelect.innerHTML = '<option value="">Select Sub Type</option>';
        
        // Add new options
        subtypes.forEach(subtype => {
            const option = document.createElement('option');
            option.value = subtype.auto_number;
            option.textContent = subtype.subtype;
            subtypeSelect.appendChild(option);
        });
    }

    clearSubtypeOptions() {
        const subtypeSelect = document.getElementById('subtype');
        if (subtypeSelect) {
            subtypeSelect.innerHTML = '<option value="">Select Sub Type</option>';
        }
    }

    handleLocationChange(locationCode) {
        if (!locationCode) return;
        
        // Update location display via AJAX
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

    setupInfiniteScroll() {
        let isLoading = false;
        let currentPage = 1;
        
        window.addEventListener('scroll', () => {
            if (isLoading) return;
            
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                this.loadMoreData();
            }
        });
    }

    async loadMoreData() {
        if (isLoading) return;
        
        isLoading = true;
        currentPage++;
        
        try {
            const serialno = document.getElementById('serialno')?.value || '50';
            const searchDeptAnum = document.getElementById('searchdepartmentanum')?.value || '';
            const searchSupplrAnum = document.getElementById('searchsupplieranum')?.value || '';
            
            const formData = new FormData();
            formData.append('serialno', serialno);
            formData.append('action', 'scrollplanfunction');
            formData.append('searchdepartmentanum', searchDeptAnum);
            formData.append('searchsupplieranum', searchSupplrAnum);
            
            const response = await fetch('ajax/consultationtypedata.php', {
                method: 'POST',
                body: formData
            });
            
            const html = await response.text();
            
            if (html.trim()) {
                const insertPlan = document.getElementById('insertplan');
                if (insertPlan) {
                    insertPlan.insertAdjacentHTML('beforeend', html);
                    
                    // Update serial number
                    const newSerialNo = parseFloat(serialno) + 50;
                    const serialNoInput = document.getElementById('serialno');
                    if (serialNoInput) {
                        serialNoInput.value = newSerialNo;
                    }
                }
            }
        } catch (error) {
            console.error('Error loading more data:', error);
        } finally {
            isLoading = false;
        }
    }

    setupAutoSave() {
        const form = document.getElementById('form1');
        if (!form) return;
        
        const inputs = form.querySelectorAll('input, select');
        let saveTimeout;
        
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    this.autoSaveForm();
                }, 2000);
            });
        });
    }

    autoSaveForm() {
        const form = document.getElementById('form1');
        if (!form) return;
        
        const formData = new FormData(form);
        formData.append('action', 'autosave');
        
        fetch('ajax/autosave_consultation.php', {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                this.showNotification('Form auto-saved', 'success', 2000);
            }
        }).catch(error => {
            console.error('Auto-save error:', error);
        });
    }

    initializeAnimations() {
        // Add fade-in animation to elements
        const elements = document.querySelectorAll('.form-section, .data-table-container');
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
        // Add floating labels
        const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
        inputs.forEach(input => {
            if (input.placeholder) {
                input.classList.add('floating-label');
            }
        });
        
        // Add input formatting
        const currencyInputs = document.querySelectorAll('input[name="consultationfees"]');
        currencyInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/[^\d.]/g, '');
                if (value) {
                    value = parseFloat(value).toFixed(2);
                }
                e.target.value = value;
            });
        });
        
        // Add uppercase formatting
        const uppercaseInputs = document.querySelectorAll('input[name="consultationtype"]');
        uppercaseInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        });
    }

    showNotification(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';
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
function funcPaymentTypeChange1() {
    const paymentTypeSelect = document.getElementById('paymenttype');
    if (paymentTypeSelect) {
        consultationManager.handlePaymentTypeChange(paymentTypeSelect.value);
    }
}

function ajaxlocationfunction(val) {
    if (consultationManager) {
        consultationManager.handleLocationChange(val);
    }
}

function cleardepartmentcode() {
    const deptAnumInput = document.getElementById('searchdepartmentanum');
    if (deptAnumInput) {
        deptAnumInput.value = '';
    }
}

function clearsubtypecode() {
    const suppAnumInput = document.getElementById('searchsupplieranum');
    if (suppAnumInput) {
        suppAnumInput.value = '';
    }
}

function addward1process1() {
    const form = document.getElementById('form1');
    if (!form) return false;
    
    const requiredFields = [
        { name: 'location', message: 'Please Select Location.' },
        { name: 'department', message: 'Please Select Department.' },
        { name: 'consultationtype', message: 'Please Enter Consultation Type Name.' },
        { name: 'consultationfees', message: 'Please Enter Consultation Fees.' }
    ];
    
    for (const field of requiredFields) {
        const input = form.querySelector(`[name="${field.name}"]`);
        if (!input || !input.value.trim()) {
            consultationManager.showNotification(field.message, 'error');
            if (input) input.focus();
            return false;
        }
    }
    
    return true;
}

function funcDeleteconsultationtype1(consultationTypeAutoNumber) {
    const confirmed = confirm(`Are you sure you want to delete this Consultation Type ${consultationTypeAutoNumber}?`);
    
    if (confirmed) {
        consultationManager.showNotification('Consultation Type Entry Delete Completed.', 'success');
        return true;
    } else {
        consultationManager.showNotification('Consultation Type Entry Delete Not Completed.', 'info');
        return false;
    }
}

// Initialize the manager when DOM is ready
let consultationManager;

document.addEventListener('DOMContentLoaded', () => {
    consultationManager = new ConsultationMasterManager();
    
    // Add modern enhancements to existing jQuery functionality
    if (typeof $ !== 'undefined') {
        // Enhanced autocomplete for doctor names
        $('#consultationdoctorname').autocomplete({
            source: 'ajaxdoctornamesearch.php',
            html: true,
            select: function(event, ui) {
                const medicine = ui.item.value;
                const doctorcode = ui.item.doctorcode;
                $('#consultationdoctorcode').val(doctorcode);
                $('#consultationdoctorname').val(medicine);
            },
        });

        // Enhanced autocomplete for supplier names
        $('#searchsuppliername').autocomplete({
            source: "ajaxaccountsub_search.php",
            matchContains: true,
            minLength: 1,
            html: true,
            select: function(event, ui) {
                const accountname = ui.item.value;
                const accountid = ui.item.id;
                const accountanum = ui.item.anum;
                $("#searchsuppliercode").val(accountid);
                $("#searchsupplieranum").val(accountanum);
                $('#searchsuppliername').val(accountname);
            },
        });

        // Enhanced autocomplete for department names
        $('#searchdepartmentname').autocomplete({
            source: "ajaxdepartment_search.php",
            matchContains: true,
            minLength: 1,
            html: true,
            select: function(event, ui) {
                const accountname = ui.item.value;
                const accountid = ui.item.id;
                const accountanum = ui.item.anum;
                $("#searchdepartmentcode").val(accountid);
                $("#searchdepartmentanum").val(accountanum);
                $('#searchdepartmentname').val(accountname);
            },
        });
    }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConsultationMasterManager;
}


