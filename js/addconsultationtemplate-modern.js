// Add Consultation Template Modern JavaScript
let editorInstance = null;

// DOM Elements
let templatenameInput, editor1Textarea, submitBtn, form;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeCKEditor();
    setupFormValidation();
    setupKeyboardShortcuts();
});

function initializeElements() {
    templatenameInput = document.getElementById('templatename');
    editor1Textarea = document.getElementById('editor1');
    submitBtn = document.querySelector('input[name="Submit2223"]');
    form = document.querySelector('form[name="frmsales"]');
}

function setupEventListeners() {
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (templatenameInput) {
        templatenameInput.addEventListener('input', handleTemplateNameChange);
    }
    
    if (form) {
        form.addEventListener('submit', handleFormValidation);
    }
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const leftSidebar = document.getElementById('leftSidebar');
    
    if (menuToggle && leftSidebar) {
        menuToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    }
    
    if (sidebarToggle && leftSidebar) {
        sidebarToggle.addEventListener('click', function() {
            leftSidebar.classList.toggle('collapsed');
            const icon = sidebarToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-chevron-left');
                icon.classList.toggle('fa-chevron-right');
            }
        });
    }
}

function initializeCKEditor() {
    if (typeof CKEDITOR !== 'undefined' && editor1Textarea) {
        editorInstance = CKEDITOR.replace('editor1', {
            height: 400,
            toolbar: [
                { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                '/',
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                '/',
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                { name: 'about', items: ['About'] }
            ],
            language: 'en',
            uiColor: '#f8f9fa',
            contentsCss: 'body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; line-height: 1.6; }'
        });
        
        editorInstance.on('change', function() {
            updateEditorContent();
        });
        
        editorInstance.on('focus', function() {
            showEditorFocus();
        });
        
        editorInstance.on('blur', function() {
            hideEditorFocus();
        });
    }
}

function setupFormValidation() {
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showAlert('Please fill in all required fields correctly.', 'error');
            }
        });
    }
}

function validateForm() {
    let isValid = true;
    const errors = [];
    
    // Validate template name
    if (templatenameInput && templatenameInput.value.trim() === '') {
        errors.push('Template name is required');
        isValid = false;
    }
    
    // Validate editor content
    let editorContent = '';
    if (editorInstance) {
        editorContent = editorInstance.getData();
    } else if (editor1Textarea) {
        editorContent = editor1Textarea.value;
    }
    
    if (editorContent.trim() === '') {
        errors.push('Template content is required');
        isValid = false;
    }
    
    if (!isValid) {
        showAlert(errors.join('<br>'), 'error');
    }
    
    return isValid;
}

function handleFormSubmit(e) {
    if (!validateForm()) {
        e.preventDefault();
        return;
    }
    
    showLoadingState();
    
    // Add loading state to submit button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Saving Template...';
    }
}

function handleTemplateNameChange() {
    if (templatenameInput) {
        // Auto-uppercase the template name
        templatenameInput.value = templatenameInput.value.toUpperCase();
        
        // Update character count or validation
        updateTemplateNameValidation();
    }
}

function updateTemplateNameValidation() {
    if (templatenameInput) {
        const value = templatenameInput.value.trim();
        const isValid = value.length >= 3;
        
        if (value.length > 0 && !isValid) {
            templatenameInput.style.borderColor = '#ef4444';
        } else {
            templatenameInput.style.borderColor = '';
        }
    }
}

function updateEditorContent() {
    if (editorInstance) {
        const content = editorInstance.getData();
        if (editor1Textarea) {
            editor1Textarea.value = content;
        }
    }
}

function showEditorFocus() {
    const editorContainer = document.querySelector('.editor-container');
    if (editorContainer) {
        editorContainer.style.borderColor = '#3b82f6';
        editorContainer.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
    }
}

function hideEditorFocus() {
    const editorContainer = document.querySelector('.editor-container');
    if (editorContainer) {
        editorContainer.style.borderColor = '';
        editorContainer.style.boxShadow = '';
    }
}

function showLoadingState() {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                Saving your consultation template, please wait...
            </div>
        `;
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        const alertClass = `alert-${type}`;
        const iconClass = getIconForAlertType(type);
        
        alertContainer.innerHTML = `
            <div class="alert ${alertClass}">
                <i class="${iconClass}"></i>
                ${message}
            </div>
        `;
        
        // Auto-hide success messages after 3 seconds
        if (type === 'success') {
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }
    }
}

function getIconForAlertType(type) {
    const icons = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    return icons[type] || icons['info'];
}

function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (submitBtn) {
                submitBtn.click();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            if (confirm('Are you sure you want to clear the form?')) {
                clearForm();
            }
        }
        
        // F5 to refresh
        if (e.key === 'F5') {
            e.preventDefault();
            refreshPage();
        }
    });
}

function clearForm() {
    if (templatenameInput) {
        templatenameInput.value = '';
    }
    
    if (editorInstance) {
        editorInstance.setData('');
    } else if (editor1Textarea) {
        editor1Textarea.value = '';
    }
    
    showAlert('Form cleared successfully.', 'success');
}

function refreshPage() {
    window.location.reload();
}

function exportTemplate() {
    if (editorInstance) {
        const content = editorInstance.getData();
        const templateName = templatenameInput ? templatenameInput.value : 'consultation_template';
        
        // Create a downloadable HTML file
        const htmlContent = `
<!DOCTYPE html>
<html>
<head>
    <title>${templateName}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        p { margin-bottom: 10px; }
    </style>
</head>
<body>
    ${content}
</body>
</html>`;
        
        const blob = new Blob([htmlContent], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${templateName}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        showAlert('Template exported successfully.', 'success');
    }
}

function importTemplate() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.html,.txt';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const content = e.target.result;
                if (editorInstance) {
                    editorInstance.setData(content);
                } else if (editor1Textarea) {
                    editor1Textarea.value = content;
                }
                showAlert('Template imported successfully.', 'success');
            };
            reader.readAsText(file);
        }
    };
    input.click();
}

// Backward compatibility functions
function textareacontentcheck() {
    let content = '';
    if (editorInstance) {
        content = editorInstance.getData();
    } else if (editor1Textarea) {
        content = editor1Textarea.value;
    }
    
    if (content.trim() === '') {
        showAlert('Please enter template content.', 'warning');
        if (editorInstance) {
            editorInstance.focus();
        } else if (editor1Textarea) {
            editor1Textarea.focus();
        }
        return false;
    }
    
    return true;
}

function disableEnterKey(event) {
    if (event.key === 'Enter' && event.ctrlKey) {
        return false;
    }
    return true;
}

function funcOnLoadBodyFunctionCall() {
    console.log('Add Consultation Template page loaded');
    
    // Initialize any additional functionality
    if (templatenameInput) {
        templatenameInput.focus();
    }
    
    // Show success message if redirected from successful save
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('st');
    if (status === 'success') {
        showAlert('Template saved successfully!', 'success');
    } else if (status === 'failed') {
        showAlert('Failed to save template. Please try again.', 'error');
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Add Consultation Template page initialized');
    
    // Set up auto-save functionality (optional)
    if (editorInstance) {
        setInterval(function() {
            if (editorInstance.checkDirty()) {
                updateEditorContent();
            }
        }, 30000); // Auto-save every 30 seconds
    }
});