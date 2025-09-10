/**
 * Modern JavaScript for consultationrefundrequestlist.php
 * Enhanced functionality with modern ES6+ features
 */

class ConsultationRefundRequestListManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupAutoComplete();
        this.setupDatePickers();
        this.setupModalHandlers();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Consultation Refund Request List Manager initialized');
    }

    addModernStyling() {
        // Add modern classes to existing elements
        const containers = document.querySelectorAll('table[width="100%"]');
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
        const buttons = document.querySelectorAll('input[type="submit"], input[type="reset"]');
        buttons.forEach(button => {
            if (button.value.toLowerCase().includes('search')) {
                button.classList.add('btn', 'btn-primary');
            } else if (button.value.toLowerCase().includes('reset')) {
                button.classList.add('btn', 'btn-secondary');
            } else {
                button.classList.add('btn', 'btn-success');
            }
        });

        // Enhance inputs
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.classList.add('form-input');
        });

        // Enhance textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.classList.add('form-textarea');
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

        // Enhance action links
        const actionLinks = document.querySelectorAll('a[onClick*="putRequest"]');
        actionLinks.forEach(link => {
            link.classList.add('action-btn', 'process');
            link.innerHTML = '🔄 Process';
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
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
            });
        });

        // Auto-submit on patient selection
        const patientInput = document.getElementById('patient');
        if (patientInput) {
            patientInput.addEventListener('change', () => {
                this.handlePatientSelection();
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });

        // Enhanced process button handlers
        this.setupProcessButtonHandlers();
    }

    setupProcessButtonHandlers() {
        const processLinks = document.querySelectorAll('a[onClick*="putRequest"]');
        processLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleProcessRefund(link);
            });
        });
    }

    handleProcessRefund(link) {
        const onClickAttr = link.getAttribute('onClick');
        const matches = onClickAttr.match(/putRequest\('([^']+)','([^']+)','([^']+)'\)/);
        
        if (matches) {
            const billnumber = matches[1];
            const visitcode = matches[2];
            const remarkId = matches[3];
            
            this.showRefundModal(billnumber, visitcode, remarkId);
        }
    }

    showRefundModal(billnumber, visitcode, remarkId) {
        const remarkTextarea = document.getElementById(`remark${remarkId}`);
        if (!remarkTextarea) {
            this.showNotification('Remark textarea not found', 'error');
            return;
        }

        const remarkValue = remarkTextarea.value.trim();
        if (!remarkValue) {
            this.showNotification('Please enter remarks before processing', 'warning');
            remarkTextarea.focus();
            return;
        }

        // Create modal
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.id = 'refundModal';
        
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>🔄 Process Refund Request</h3>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>⚠️ Confirmation Required</strong><br>
                        Are you sure you want to process this refund request?
                    </div>
                    <div class="refund-details">
                        <p><strong>Bill Number:</strong> ${billnumber}</p>
                        <p><strong>Visit Code:</strong> ${visitcode}</p>
                        <p><strong>Remarks:</strong> ${remarkValue}</p>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 20px; text-align: right;">
                    <button class="btn btn-secondary" id="cancelRefund">Cancel</button>
                    <button class="btn btn-warning" id="confirmRefund">Process Refund</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        modal.style.display = 'block';
        
        // Setup modal event listeners
        const closeBtn = modal.querySelector('.close');
        const cancelBtn = modal.querySelector('#cancelRefund');
        const confirmBtn = modal.querySelector('#confirmRefund');
        
        closeBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        cancelBtn.addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        confirmBtn.addEventListener('click', () => {
            this.processRefundRequest(billnumber, visitcode, remarkId, remarkValue);
            this.closeModal(modal);
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

    processRefundRequest(billnumber, visitcode, remarkId, remarks) {
        // Show loading state
        this.showNotification('Processing refund request...', 'info');
        
        // Create form data
        const formData = new FormData();
        formData.append('billnumber', billnumber);
        formData.append('visitcode', visitcode);
        formData.append('remarks', remarks);
        
        // Submit the request
        fetch('consultationrefundrequestlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                this.showNotification('Refund request processed successfully!', 'success');
                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                throw new Error('Failed to process refund request');
            }
        })
        .catch(error => {
            console.error('Error processing refund request:', error);
            this.showNotification('Error processing refund request. Please try again.', 'error');
        });
    }

    setupFormValidation() {
        // Custom validation rules
        this.validationRules = {
            patient: {
                required: false,
                minLength: 2,
                message: 'Patient name must be at least 2 characters'
            },
            patientcode: {
                required: false,
                pattern: /^[A-Z0-9]+$/,
                message: 'Patient code must contain only letters and numbers'
            },
            visitcode: {
                required: false,
                pattern: /^[A-Z0-9]+$/,
                message: 'Visit code must contain only letters and numbers'
            },
            billno: {
                required: false,
                pattern: /^[A-Z0-9]+$/,
                message: 'Bill number must contain only letters and numbers'
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
        
        // Length validation
        if (isValid && rules.minLength && field.value.length > 0 && field.value.length < rules.minLength) {
            isValid = false;
            errorMessage = rules.message || `${field.name} must be at least ${rules.minLength} characters`;
        }
        
        // Pattern validation
        if (isValid && rules.pattern && field.value.length > 0 && !rules.pattern.test(field.value)) {
            isValid = false;
            errorMessage = rules.message || `${field.name} format is invalid`;
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
        const inputs = form.querySelectorAll('input, select, textarea');
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

    setupAutoComplete() {
        // Enhanced autocomplete for patient names
        const patientInput = document.getElementById('patient');
        if (patientInput) {
            this.setupPatientAutocomplete(patientInput);
        }

        // Enhanced autocomplete for patient codes
        const patientCodeInput = document.querySelector('input[name="patientcode"]');
        if (patientCodeInput) {
            this.setupPatientCodeAutocomplete(patientCodeInput);
        }

        // Enhanced autocomplete for visit codes
        const visitCodeInput = document.querySelector('input[name="visitcode"]');
        if (visitCodeInput) {
            this.setupVisitCodeAutocomplete(visitCodeInput);
        }

        // Enhanced autocomplete for bill numbers
        const billNoInput = document.querySelector('input[name="billno"]');
        if (billNoInput) {
            this.setupBillNoAutocomplete(billNoInput);
        }
    }

    setupPatientAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchPatientSuggestions(query, input);
            }, 300);
        });
    }

    setupPatientCodeAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchPatientCodeSuggestions(query, input);
            }, 300);
        });
    }

    setupVisitCodeAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchVisitCodeSuggestions(query, input);
            }, 300);
        });
    }

    setupBillNoAutocomplete(input) {
        let timeout;
        
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            const query = e.target.value;
            
            if (query.length < 2) {
                this.hideAutocomplete();
                return;
            }
            
            timeout = setTimeout(() => {
                this.fetchBillNoSuggestions(query, input);
            }, 300);
        });
    }

    async fetchPatientSuggestions(query, input) {
        try {
            const response = await fetch(`ajax/patient_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'patient');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching patient suggestions:', error);
        }
    }

    async fetchPatientCodeSuggestions(query, input) {
        try {
            const response = await fetch(`ajax/patient_code_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'patientcode');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching patient code suggestions:', error);
        }
    }

    async fetchVisitCodeSuggestions(query, input) {
        try {
            const response = await fetch(`ajax/visit_code_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'visitcode');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching visit code suggestions:', error);
        }
    }

    async fetchBillNoSuggestions(query, input) {
        try {
            const response = await fetch(`ajax/bill_no_search.php?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data && data.length > 0) {
                this.showAutocomplete(data, input, 'billno');
            } else {
                this.hideAutocomplete();
            }
        } catch (error) {
            console.error('Error fetching bill number suggestions:', error);
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
            
            if (type === 'patient') {
                option.textContent = item.patientname || item;
                option.dataset.patientcode = item.patientcode || '';
                option.dataset.visitcode = item.visitcode || '';
                option.dataset.billnumber = item.billnumber || '';
            } else if (type === 'patientcode') {
                option.textContent = item.patientcode || item;
                option.dataset.patientname = item.patientname || '';
                option.dataset.visitcode = item.visitcode || '';
                option.dataset.billnumber = item.billnumber || '';
            } else if (type === 'visitcode') {
                option.textContent = item.visitcode || item;
                option.dataset.patientcode = item.patientcode || '';
                option.dataset.patientname = item.patientname || '';
                option.dataset.billnumber = item.billnumber || '';
            } else if (type === 'billno') {
                option.textContent = item.billnumber || item;
                option.dataset.patientcode = item.patientcode || '';
                option.dataset.patientname = item.patientname || '';
                option.dataset.visitcode = item.visitcode || '';
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
        
        // Auto-fill related fields
        if (type === 'patient') {
            const patientCodeInput = document.querySelector('input[name="patientcode"]');
            const visitCodeInput = document.querySelector('input[name="visitcode"]');
            const billNoInput = document.querySelector('input[name="billno"]');
            if (patientCodeInput && option.dataset.patientcode) {
                patientCodeInput.value = option.dataset.patientcode;
            }
            if (visitCodeInput && option.dataset.visitcode) {
                visitCodeInput.value = option.dataset.visitcode;
            }
            if (billNoInput && option.dataset.billnumber) {
                billNoInput.value = option.dataset.billnumber;
            }
        } else if (type === 'patientcode') {
            const patientInput = document.getElementById('patient');
            const visitCodeInput = document.querySelector('input[name="visitcode"]');
            const billNoInput = document.querySelector('input[name="billno"]');
            if (patientInput && option.dataset.patientname) {
                patientInput.value = option.dataset.patientname;
            }
            if (visitCodeInput && option.dataset.visitcode) {
                visitCodeInput.value = option.dataset.visitcode;
            }
            if (billNoInput && option.dataset.billnumber) {
                billNoInput.value = option.dataset.billnumber;
            }
        } else if (type === 'visitcode') {
            const patientInput = document.getElementById('patient');
            const patientCodeInput = document.querySelector('input[name="patientcode"]');
            const billNoInput = document.querySelector('input[name="billno"]');
            if (patientInput && option.dataset.patientname) {
                patientInput.value = option.dataset.patientname;
            }
            if (patientCodeInput && option.dataset.patientcode) {
                patientCodeInput.value = option.dataset.patientcode;
            }
            if (billNoInput && option.dataset.billnumber) {
                billNoInput.value = option.dataset.billnumber;
            }
        } else if (type === 'billno') {
            const patientInput = document.getElementById('patient');
            const patientCodeInput = document.querySelector('input[name="patientcode"]');
            const visitCodeInput = document.querySelector('input[name="visitcode"]');
            if (patientInput && option.dataset.patientname) {
                patientInput.value = option.dataset.patientname;
            }
            if (patientCodeInput && option.dataset.patientcode) {
                patientCodeInput.value = option.dataset.patientcode;
            }
            if (visitCodeInput && option.dataset.visitcode) {
                visitCodeInput.value = option.dataset.visitcode;
            }
        }
        
        this.hideAutocomplete();
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

    handlePatientSelection() {
        // Auto-submit form when patient is selected
        const form = document.querySelector('form[name="cbform1"]');
        if (form) {
            // Add a small delay to allow autocomplete to complete
            setTimeout(() => {
                form.submit();
            }, 500);
        }
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + Enter to submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            const form = document.querySelector('form[name="cbform1"]');
            if (form) {
                form.submit();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            const form = document.querySelector('form[name="cbform1"]');
            if (form) {
                form.reset();
                this.clearAllFieldErrors();
            }
        }
    }

    clearAllFieldErrors() {
        const errorFields = document.querySelectorAll('.field-error');
        errorFields.forEach(error => error.remove());
        
        const inputs = document.querySelectorAll('input.error, textarea.error');
        inputs.forEach(input => {
            input.classList.remove('error');
            input.style.borderColor = '';
        });
    }

    setupModalHandlers() {
        // Setup any additional modal functionality
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
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
        // Add input formatting
        const codeInputs = document.querySelectorAll('input[name="patientcode"], input[name="visitcode"], input[name="billno"]');
        codeInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        });
        
        // Add search suggestions
        this.setupSearchSuggestions();
        
        // Enhance textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', () => {
                this.validateTextarea(textarea);
            });
        });
    }

    validateTextarea(textarea) {
        const value = textarea.value.trim();
        if (value.length > 0 && value.length < 10) {
            this.showFieldError(textarea, 'Remarks must be at least 10 characters long');
            return false;
        } else {
            this.clearFieldError(textarea);
            return true;
        }
    }

    setupSearchSuggestions() {
        // Add quick search suggestions
        const searchContainer = document.querySelector('.form-section');
        if (searchContainer) {
            const suggestionsDiv = document.createElement('div');
            suggestionsDiv.className = 'search-suggestions';
            suggestionsDiv.style.cssText = `
                margin-top: 15px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 8px;
                border: 1px solid #e9ecef;
            `;
            
            suggestionsDiv.innerHTML = `
                <h4 style="margin-bottom: 10px; color: #495057;">💡 Search Tips:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li>Use patient name, code, visit code, or bill number to search</li>
                    <li>Select date range to filter results</li>
                    <li>Enter detailed remarks before processing refunds</li>
                    <li>Press Ctrl+Enter to submit quickly</li>
                    <li>Press Escape to clear the form</li>
                </ul>
            `;
            
            searchContainer.appendChild(suggestionsDiv);
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
function cbcustomername1() {
    const form = document.querySelector('form[name="cbform1"]');
    if (form) {
        form.submit();
    }
}

function disableEnterKey(varPassed) {
    if (event.keyCode === 8) {
        event.keyCode = 0;
        return event.keyCode;
    }
    
    const key = window.event ? window.event.keyCode : event.which;
    
    if (key === 13) {
        return false;
    } else {
        return true;
    }
}

function loadprintpage1(banum) {
    const banum = banum;
    window.open(`print_bill1_op1.php?billautonumber=${banum}`, `Window${banum}`, 
        'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
}

function putRequest(patientcode, patientvisitcode, remark_id) {
    if (consultationRefundRequestListManager) {
        const remarkTextarea = document.getElementById(`remark${remark_id}`);
        if (remarkTextarea && remarkTextarea.value.trim()) {
            consultationRefundRequestListManager.showRefundModal(patientcode, patientvisitcode, remark_id);
        } else {
            consultationRefundRequestListManager.showNotification('Please enter remarks before processing', 'warning');
            if (remarkTextarea) {
                remarkTextarea.focus();
            }
        }
    }
}

// Initialize the manager when DOM is ready
let consultationRefundRequestListManager;

document.addEventListener('DOMContentLoaded', () => {
    consultationRefundRequestListManager = new ConsultationRefundRequestListManager();
    
    // Enhanced autocomplete initialization
    if (typeof AutoSuggestControl !== 'undefined' && typeof StateSuggestions !== 'undefined') {
        const searchInput = document.getElementById("searchcustomername");
        if (searchInput) {
            const oTextbox = new AutoSuggestControl(searchInput, new StateSuggestions());
        }
    }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConsultationRefundRequestListManager;
}


