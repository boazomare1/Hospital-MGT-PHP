/**
 * Modern JavaScript for addconsultationtemplate.php
 * Enhanced functionality with modern ES6+ features
 */

class ConsultationTemplateManager {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupCKEditor();
        this.setupAutoSave();
        this.setupTemplateManagement();
    }

    init() {
        // Add modern styling classes
        this.addModernStyling();
        
        // Initialize animations
        this.initializeAnimations();
        
        // Setup form enhancements
        this.enhanceFormElements();
        
        console.log('Consultation Template Manager initialized');
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

        // Enhance inputs
        const inputs = document.querySelectorAll('input[type="text"]');
        inputs.forEach(input => {
            input.classList.add('form-input');
            if (input.name === 'templatename') {
                input.classList.add('uppercase-input');
            }
        });

        // Enhance buttons
        const buttons = document.querySelectorAll('input[type="submit"]');
        buttons.forEach(button => {
            button.classList.add('btn', 'btn-success');
            button.innerHTML = '💾 Save Template';
        });

        // Enhance CKEditor container
        const ckeditorContainer = document.querySelector('textarea[name="editor1"]');
        if (ckeditorContainer) {
            const wrapper = document.createElement('div');
            wrapper.className = 'ckeditor-container';
            ckeditorContainer.parentNode.insertBefore(wrapper, ckeditorContainer);
            wrapper.appendChild(ckeditorContainer);
        }
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
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
            });
        });

        // Template name input enhancement
        const templateNameInput = document.getElementById('templatename');
        if (templateNameInput) {
            templateNameInput.addEventListener('input', (e) => {
                this.handleTemplateNameChange(e.target.value);
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
            templatename: {
                required: true,
                minLength: 3,
                maxLength: 100,
                pattern: /^[A-Z0-9\s]+$/,
                message: 'Template name must be 3-100 characters and contain only letters, numbers, and spaces'
            },
            editor1: {
                required: true,
                minLength: 10,
                message: 'Template content must be at least 10 characters long'
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
        const inputs = form.querySelectorAll('input, textarea');
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });
        
        // Validate CKEditor content
        if (this.editor && this.editor.getData().trim().length < 10) {
            isFormValid = false;
            this.showNotification('Template content must be at least 10 characters long', 'error');
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
            submitBtn.value = '💾 Saving...';
        }
        
        return true;
    }

    setupCKEditor() {
        // Wait for CKEditor to be available
        if (typeof CKEDITOR !== 'undefined') {
            this.initializeCKEditor();
        } else {
            // Wait for CKEditor to load
            const checkCKEditor = setInterval(() => {
                if (typeof CKEDITOR !== 'undefined') {
                    clearInterval(checkCKEditor);
                    this.initializeCKEditor();
                }
            }, 100);
        }
    }

    initializeCKEditor() {
        const textarea = document.querySelector('textarea[name="editor1"]');
        if (textarea && !textarea.hasAttribute('data-ckeditor-initialized')) {
            textarea.setAttribute('data-ckeditor-initialized', 'true');
            
            this.editor = CKEDITOR.replace('editor1', {
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
                    { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                    { name: 'about', items: ['About'] }
                ],
                height: 400,
                width: '100%',
                resize_enabled: false,
                removePlugins: 'elementspath',
                extraPlugins: 'autogrow',
                autoGrow_minHeight: 400,
                autoGrow_maxHeight: 800,
                autoGrow_bottomSpace: 20,
                contentsCss: [
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
                ]
            });

            // Setup CKEditor event listeners
            this.editor.on('change', () => {
                this.handleEditorChange();
            });

            this.editor.on('focus', () => {
                this.handleEditorFocus();
            });

            this.editor.on('blur', () => {
                this.handleEditorBlur();
            });

            // Add custom styles
            this.addCustomEditorStyles();
        }
    }

    addCustomEditorStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .cke_editable {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
                line-height: 1.6 !important;
                color: #333 !important;
            }
            .cke_editable h1, .cke_editable h2, .cke_editable h3 {
                color: #667eea !important;
                margin-bottom: 15px !important;
            }
            .cke_editable p {
                margin-bottom: 10px !important;
            }
            .cke_editable ul, .cke_editable ol {
                margin-left: 20px !important;
                margin-bottom: 15px !important;
            }
            .cke_editable table {
                border-collapse: collapse !important;
                width: 100% !important;
                margin-bottom: 15px !important;
            }
            .cke_editable table th, .cke_editable table td {
                border: 1px solid #ddd !important;
                padding: 8px !important;
                text-align: left !important;
            }
            .cke_editable table th {
                background-color: #f8f9fa !important;
                font-weight: bold !important;
            }
        `;
        document.head.appendChild(style);
    }

    handleEditorChange() {
        // Trigger auto-save
        this.triggerAutoSave();
        
        // Update preview if available
        this.updatePreview();
    }

    handleEditorFocus() {
        // Add focus styling
        const container = document.querySelector('.ckeditor-container');
        if (container) {
            container.style.borderColor = '#667eea';
            container.style.boxShadow = '0 0 0 3px rgba(102, 126, 234, 0.1)';
        }
    }

    handleEditorBlur() {
        // Remove focus styling
        const container = document.querySelector('.ckeditor-container');
        if (container) {
            container.style.borderColor = '#e1e5e9';
            container.style.boxShadow = 'none';
        }
    }

    setupAutoSave() {
        this.autoSaveTimeout = null;
        this.autoSaveInterval = null;
        
        // Setup auto-save indicator
        this.createAutoSaveIndicator();
        
        // Start periodic auto-save
        this.startPeriodicAutoSave();
    }

    createAutoSaveIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'auto-save-indicator';
        indicator.id = 'autoSaveIndicator';
        indicator.innerHTML = '💾 Auto-saved';
        document.body.appendChild(indicator);
    }

    triggerAutoSave() {
        clearTimeout(this.autoSaveTimeout);
        this.autoSaveTimeout = setTimeout(() => {
            this.performAutoSave();
        }, 2000);
    }

    startPeriodicAutoSave() {
        this.autoSaveInterval = setInterval(() => {
            this.performAutoSave();
        }, 30000); // Auto-save every 30 seconds
    }

    performAutoSave() {
        const templateName = document.getElementById('templatename')?.value || '';
        const templateContent = this.editor ? this.editor.getData() : '';
        
        if (templateName.trim() && templateContent.trim()) {
            this.showAutoSaveIndicator('saving');
            
            // Simulate auto-save (in real implementation, this would save to localStorage or send to server)
            setTimeout(() => {
                localStorage.setItem('consultation_template_draft', JSON.stringify({
                    name: templateName,
                    content: templateContent,
                    timestamp: new Date().toISOString()
                }));
                
                this.showAutoSaveIndicator('saved');
            }, 1000);
        }
    }

    showAutoSaveIndicator(status) {
        const indicator = document.getElementById('autoSaveIndicator');
        if (indicator) {
            indicator.classList.add('show');
            
            switch (status) {
                case 'saving':
                    indicator.classList.add('saving');
                    indicator.innerHTML = '⏳ Saving...';
                    break;
                case 'saved':
                    indicator.classList.remove('saving');
                    indicator.innerHTML = '✅ Auto-saved';
                    setTimeout(() => {
                        indicator.classList.remove('show');
                    }, 2000);
                    break;
                case 'error':
                    indicator.classList.add('error');
                    indicator.innerHTML = '❌ Save failed';
                    setTimeout(() => {
                        indicator.classList.remove('show', 'error');
                    }, 3000);
                    break;
            }
        }
    }

    setupTemplateManagement() {
        // Load existing templates
        this.loadExistingTemplates();
        
        // Setup template preview
        this.setupTemplatePreview();
    }

    loadExistingTemplates() {
        // This would typically load from a server endpoint
        // For now, we'll create a placeholder
        const templateManagement = document.createElement('div');
        templateManagement.className = 'template-management';
        templateManagement.innerHTML = `
            <h3>Existing Templates</h3>
            <div class="template-list" id="templateList">
                <div class="template-item">
                    <h4>General Consultation</h4>
                    <p>Standard consultation template for general medical consultations</p>
                    <div class="template-actions">
                        <button class="btn btn-primary" onclick="templateManager.loadTemplate('general')">Load</button>
                        <button class="btn btn-secondary" onclick="templateManager.editTemplate('general')">Edit</button>
                        <button class="btn btn-danger" onclick="templateManager.deleteTemplate('general')">Delete</button>
                    </div>
                </div>
                <div class="template-item">
                    <h4>Follow-up Visit</h4>
                    <p>Template for follow-up consultations and check-ups</p>
                    <div class="template-actions">
                        <button class="btn btn-primary" onclick="templateManager.loadTemplate('followup')">Load</button>
                        <button class="btn btn-secondary" onclick="templateManager.editTemplate('followup')">Edit</button>
                        <button class="btn btn-danger" onclick="templateManager.deleteTemplate('followup')">Delete</button>
                    </div>
                </div>
            </div>
        `;
        
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            formSection.parentNode.insertBefore(templateManagement, formSection.nextSibling);
        }
    }

    setupTemplatePreview() {
        const preview = document.createElement('div');
        preview.className = 'template-preview';
        preview.innerHTML = `
            <h3>Template Preview</h3>
            <div class="preview-content" id="templatePreview">
                <p style="color: #6c757d; font-style: italic;">Start typing to see a preview of your template...</p>
            </div>
        `;
        
        const formSection = document.querySelector('.form-section');
        if (formSection) {
            formSection.parentNode.insertBefore(preview, formSection.nextSibling);
        }
    }

    updatePreview() {
        if (this.editor) {
            const preview = document.getElementById('templatePreview');
            if (preview) {
                const content = this.editor.getData();
                if (content.trim()) {
                    preview.innerHTML = content;
                } else {
                    preview.innerHTML = '<p style="color: #6c757d; font-style: italic;">Start typing to see a preview of your template...</p>';
                }
            }
        }
    }

    handleTemplateNameChange(value) {
        // Auto-format template name
        const formattedValue = value.toUpperCase().replace(/[^A-Z0-9\s]/g, '');
        if (formattedValue !== value) {
            document.getElementById('templatename').value = formattedValue;
        }
        
        // Update preview title
        const preview = document.getElementById('templatePreview');
        if (preview && value.trim()) {
            const title = document.createElement('h4');
            title.textContent = value;
            title.style.color = '#667eea';
            title.style.marginBottom = '15px';
            
            const existingTitle = preview.querySelector('h4');
            if (existingTitle) {
                existingTitle.remove();
            }
            
            preview.insertBefore(title, preview.firstChild);
        }
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const form = document.querySelector('form[name="frmsales"]');
            if (form) {
                form.submit();
            }
        }
        
        // Ctrl/Cmd + N to clear form
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            this.clearForm();
        }
        
        // Ctrl/Cmd + P to preview
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            this.showFullPreview();
        }
    }

    clearForm() {
        if (confirm('Are you sure you want to clear the form? All unsaved changes will be lost.')) {
            document.getElementById('templatename').value = '';
            if (this.editor) {
                this.editor.setData('');
            }
            this.clearAllFieldErrors();
            this.showNotification('Form cleared', 'info');
        }
    }

    showFullPreview() {
        if (this.editor) {
            const content = this.editor.getData();
            const templateName = document.getElementById('templatename').value || 'Untitled Template';
            
            if (content.trim()) {
                const previewWindow = window.open('', '_blank', 'width=800,height=600');
                previewWindow.document.write(`
                    <html>
                        <head>
                            <title>Template Preview: ${templateName}</title>
                            <style>
                                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; line-height: 1.6; }
                                h1 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
                            </style>
                        </head>
                        <body>
                            <h1>${templateName}</h1>
                            ${content}
                        </body>
                    </html>
                `);
                previewWindow.document.close();
            } else {
                this.showNotification('No content to preview', 'warning');
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

    initializeAnimations() {
        // Add fade-in animation to elements
        const elements = document.querySelectorAll('.form-section, .template-management, .template-preview');
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
        const templateNameInput = document.getElementById('templatename');
        if (templateNameInput) {
            templateNameInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        }
        
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
                <h4 style="margin-bottom: 10px; color: #495057;">💡 Template Tips:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #6c757d;">
                    <li>Use descriptive template names for easy identification</li>
                    <li>Include placeholders like [PATIENT_NAME] for dynamic content</li>
                    <li>Use formatting tools to structure your template</li>
                    <li>Press Ctrl+S to save quickly</li>
                    <li>Press Ctrl+P to preview your template</li>
                    <li>Press Ctrl+N to start a new template</li>
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

    // Template management methods
    loadTemplate(templateId) {
        // This would typically load from a server
        this.showNotification(`Loading template: ${templateId}`, 'info');
    }

    editTemplate(templateId) {
        // This would typically open an edit dialog
        this.showNotification(`Editing template: ${templateId}`, 'info');
    }

    deleteTemplate(templateId) {
        if (confirm(`Are you sure you want to delete the template: ${templateId}?`)) {
            // This would typically delete from server
            this.showNotification(`Template deleted: ${templateId}`, 'success');
        }
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
function textareacontentcheck() {
    if (templateManager && templateManager.editor) {
        const content = templateManager.editor.getData();
        if (!content.trim()) {
            templateManager.showNotification('Please enter template content', 'warning');
            templateManager.editor.focus();
            return false;
        }
    }
    return true;
}

function funcOnLoadBodyFunctionCall() {
    // Legacy function - now handled by the template manager
    console.log('Body loaded - template manager will handle initialization');
}

function disableEnterKey(event) {
    if (event.keyCode === 13) {
        return false;
    }
    return true;
}

// Initialize the manager when DOM is ready
let templateManager;

document.addEventListener('DOMContentLoaded', () => {
    templateManager = new ConsultationTemplateManager();
    
    // Load draft if available
    const draft = localStorage.getItem('consultation_template_draft');
    if (draft) {
        try {
            const draftData = JSON.parse(draft);
            if (draftData.name) {
                document.getElementById('templatename').value = draftData.name;
            }
            // Content will be loaded when CKEditor is ready
            setTimeout(() => {
                if (templateManager.editor && draftData.content) {
                    templateManager.editor.setData(draftData.content);
                }
            }, 1000);
        } catch (error) {
            console.error('Error loading draft:', error);
        }
    }
});

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ConsultationTemplateManager;
}


