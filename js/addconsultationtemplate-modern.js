/**
 * Modern JavaScript for Add Consultation Template
 * Handles CKEditor integration, form validation, and modern interactions
 */

// Modern ES6+ JavaScript with enhanced functionality
class AddConsultationTemplate {
    constructor() {
        this.editor = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeCKEditor();
        this.setupFormValidation();
    }

    setupEventListeners() {
        // Form submission handler
        const form = document.querySelector('form[name="frmsales"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                }
            });
        }

        // Real-time validation
        this.setupRealTimeValidation();
    }

    initializeCKEditor() {
        // Initialize CKEditor if available
        if (typeof CKEDITOR !== 'undefined') {
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    this.setupCKEditor();
                });
            } else {
                this.setupCKEditor();
            }
        } else {
            console.warn('CKEditor not loaded. Please ensure ckeditor.js is included.');
        }
    }

    setupCKEditor() {
        const textarea = document.getElementById('consultation');
        if (textarea && typeof CKEDITOR !== 'undefined') {
            // Configure CKEditor with modern settings
            this.editor = CKEDITOR.replace('consultation', {
                height: 300,
                width: '100%',
                toolbar: [
                    { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                    { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                    { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                    { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                    '/',
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'ClearFormatting'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
                    { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                    { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                    '/',
                    { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
                ],
                language: 'en',
                uiColor: '#f8f9fa',
                removeDialogTabs: 'image:advanced;link:advanced',
                filebrowserBrowseUrl: '',
                filebrowserUploadUrl: '',
                filebrowserImageBrowseUrl: '',
                filebrowserImageUploadUrl: '',
                contentsCss: 'css/addconsultationtemplate-modern.css'
            });

            // Add event listeners for CKEditor
            this.editor.on('change', () => {
                this.validateEditorContent();
            });

            this.editor.on('blur', () => {
                this.validateEditorContent();
            });
        }
    }

    setupFormValidation() {
        // Add modern validation attributes
        const templateNameInput = document.getElementById('templatename');
        if (templateNameInput) {
            templateNameInput.setAttribute('maxlength', '100');
            templateNameInput.setAttribute('required', 'required');
        }
    }

    setupRealTimeValidation() {
        // Template name validation
        const templateNameInput = document.getElementById('templatename');
        if (templateNameInput) {
            templateNameInput.addEventListener('input', (e) => {
                this.validateTemplateName(e.target.value);
            });

            templateNameInput.addEventListener('blur', (e) => {
                this.validateTemplateName(e.target.value);
            });
        }
    }

    validateForm() {
        const errors = [];

        // Template name validation
        const templateName = document.getElementById('templatename');
        if (!templateName || !templateName.value.trim()) {
            errors.push('Please enter a template name.');
            this.showFieldError(templateName, 'Template name is required.');
        } else if (templateName.value.length > 100) {
            errors.push('Template name must be 100 characters or less.');
            this.showFieldError(templateName, 'Template name must be 100 characters or less.');
        } else {
            this.clearFieldError(templateName);
        }

        // Editor content validation
        if (!this.validateEditorContent()) {
            errors.push('Please enter template content.');
        }

        if (errors.length > 0) {
            this.showAlert(errors.join(' '), 'error');
            return false;
        }

        return true;
    }

    validateTemplateName(value) {
        const field = document.getElementById('templatename');
        if (!value.trim()) {
            this.showFieldError(field, 'Template name is required.');
        } else if (value.length > 100) {
            this.showFieldError(field, 'Template name must be 100 characters or less.');
        } else {
            this.clearFieldError(field);
        }
    }

    validateEditorContent() {
        let content = '';
        
        if (this.editor) {
            content = this.editor.getData();
        } else {
            // Fallback for when CKEditor is not available
            const textarea = document.getElementById('consultation');
            if (textarea) {
                content = textarea.value;
            }
        }

        // Remove HTML tags and check for actual content
        const textContent = content.replace(/<[^>]*>/g, '').trim();
        
        if (!textContent) {
            this.showEditorError('Please enter template content.');
            return false;
        } else {
            this.clearEditorError();
            return true;
        }
    }

    showFieldError(field, message) {
        if (!field) return;

        field.classList.add('error');
        field.style.borderColor = '#dc3545';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        if (!field) return;

        field.classList.remove('error');
        field.style.borderColor = '';
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    showEditorError(message) {
        // Show error for CKEditor
        const editorContainer = document.querySelector('.cke');
        if (editorContainer) {
            editorContainer.style.borderColor = '#dc3545';
        }

        // Remove existing error message
        const existingError = document.querySelector('.editor-error');
        if (existingError) {
            existingError.remove();
        }

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'editor-error field-error';
        errorDiv.textContent = message;
        errorDiv.style.marginTop = '5px';
        
        const editorWrapper = document.querySelector('.editor-container') || document.querySelector('.cke');
        if (editorWrapper) {
            editorWrapper.parentNode.insertBefore(errorDiv, editorWrapper.nextSibling);
        }
    }

    clearEditorError() {
        // Clear error for CKEditor
        const editorContainer = document.querySelector('.cke');
        if (editorContainer) {
            editorContainer.style.borderColor = '';
        }

        const errorDiv = document.querySelector('.editor-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    showAlert(message, type = 'info') {
        // Create modern alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'error' : 'success'}`;
        alertDiv.textContent = message;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.maxWidth = '400px';
        alertDiv.style.padding = '15px 20px';
        alertDiv.style.borderRadius = '4px';
        alertDiv.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';

        document.body.appendChild(alertDiv);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }

    // Save template with loading state
    saveTemplate() {
        if (this.validateForm()) {
            // Show loading state
            const submitButton = document.querySelector('input[name="Submit2223"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.value = 'Saving...';
                submitButton.classList.add('loading');
            }

            // Submit the form
            const form = document.querySelector('form[name="frmsales"]');
            if (form) {
                form.submit();
            }
        }
    }

    // Reset form
    resetForm() {
        const form = document.querySelector('form[name="frmsales"]');
        if (form) {
            form.reset();
            
            // Clear CKEditor content
            if (this.editor) {
                this.editor.setData('');
            }
            
            // Clear any error messages
            const errorMessages = form.querySelectorAll('.field-error');
            errorMessages.forEach(error => error.remove());
            
            // Reset field styles
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.style.borderColor = '';
                input.classList.remove('error');
            });
        }
    }
}

// Legacy function compatibility
window.textareacontentcheck = function() {
    const template = new AddConsultationTemplate();
    return template.validateForm();
};

window.disableEnterKey = function(event) {
    const key = event.keyCode || event.which;
    
    if (key === 13) { // Enter key
        return false;
    }
    
    return true;
};

window.funcOnLoadBodyFunctionCall = function() {
    // Initialize when body loads
    new AddConsultationTemplate();
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new AddConsultationTemplate();
});

// Initialize with jQuery if available
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        new AddConsultationTemplate();
    });
}
