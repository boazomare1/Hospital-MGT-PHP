// Rate Template Management Modern JavaScript
let allTemplates = [];
let filteredTemplates = [];

// DOM Elements
let templateForm, submitBtn, searchInput, templatesList;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    initializeTemplateSelection();
    initializeExistingTemplates();
});

function initializeElements() {
    templateForm = document.getElementById('templateForm');
    submitBtn = document.getElementById('submitBtn');
    searchInput = document.getElementById('searchInput');
    templatesList = document.getElementById('templatesList');
}

function setupEventListeners() {
    if (templateForm) {
        templateForm.addEventListener('submit', handleFormSubmit);
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce((e) => handleSearch(e.target.value), 300));
    }
    
    // Template item click handlers
    const templateItems = document.querySelectorAll('.template-item');
    templateItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (!e.target.closest('input, button')) {
                handleTemplateItemClick(this);
            }
        });
    });
}

function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

function initializeTemplateSelection() {
    const checkboxes = document.querySelectorAll('.template-item input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateTemplateItemState(this);
            validateForm();
        });
    });
}

function initializeExistingTemplates() {
    if (!templatesList) return;
    
    // Get all existing template cards
    const templateCards = templatesList.querySelectorAll('.template-card');
    
    // Convert existing cards to data objects
    allTemplates = Array.from(templateCards).map((card, index) => {
        const header = card.querySelector('.template-card-header');
        const body = card.querySelector('.template-card-body');
        const type = header?.querySelector('.template-type')?.textContent?.trim() || '';
        const date = header?.querySelector('.template-date')?.textContent?.trim() || '';
        const name = body?.querySelector('h4')?.textContent?.trim() || '';
        const creator = body?.querySelector('p')?.textContent?.trim() || '';
        
        return {
            type: type,
            date: date,
            name: name,
            creator: creator,
            index: index
        };
    });
    
    filteredTemplates = [...allTemplates];
}

function handleTemplateItemClick(templateItem) {
    const checkbox = templateItem.querySelector('input[type="checkbox"]');
    if (checkbox) {
        checkbox.checked = !checkbox.checked;
        checkbox.dispatchEvent(new Event('change'));
    }
}

function updateTemplateItemState(checkbox) {
    const templateItem = checkbox.closest('.template-item');
    const input = templateItem.querySelector('.template-name-input');
    
    if (checkbox.checked) {
        templateItem.classList.add('selected');
        if (input) {
            input.disabled = false;
            input.focus();
        }
    } else {
        templateItem.classList.remove('selected');
        if (input) {
            input.disabled = true;
            input.value = '';
        }
    }
}

function enableTemplateInput(checkbox, inputId) {
    const input = document.getElementById(inputId);
    if (input) {
        input.disabled = !checkbox.checked;
        if (checkbox.checked) {
            input.focus();
        } else {
            input.value = '';
        }
    }
    updateTemplateItemState(checkbox);
    validateForm();
}

function validateForm() {
    const checkboxes = document.querySelectorAll('.template-item input[type="checkbox"]:checked');
    const inputs = document.querySelectorAll('.template-item input[type="text"]:not([disabled])');
    
    let isValid = true;
    const errors = [];
    
    // Check if at least one template is selected
    if (checkboxes.length === 0) {
        errors.push('Please select at least one template type');
        isValid = false;
    }
    
    // Validate template names
    inputs.forEach(input => {
        const value = input.value.trim();
        if (!value) {
            errors.push(`Please enter a name for ${getTemplateType(input)} template`);
            showFieldError(input, 'Template name is required');
            isValid = false;
        } else if (!isValidTemplateName(value)) {
            errors.push(`Invalid characters in ${getTemplateType(input)} template name`);
            showFieldError(input, 'Only letters, numbers, and underscores are allowed');
            isValid = false;
        } else {
            showFieldSuccess(input);
        }
    });
    
    // Check for duplicate names
    const names = Array.from(inputs)
        .filter(input => input.value.trim())
        .map(input => input.value.trim().toLowerCase());
    
    const duplicates = names.filter((name, index) => names.indexOf(name) !== index);
    if (duplicates.length > 0) {
        errors.push('Template names must be unique');
        isValid = false;
    }
    
    // Update submit button state
    if (submitBtn) {
        submitBtn.disabled = !isValid;
        submitBtn.style.opacity = isValid ? '1' : '0.6';
    }
    
    return isValid;
}

function isValidTemplateName(name) {
    if (!name || name.trim() === '') return false;
    
    // Check for valid characters (alphanumeric and underscore only)
    const validPattern = /^[a-zA-Z0-9_]+$/;
    return validPattern.test(name.trim());
}

function getTemplateType(input) {
    const templateItem = input.closest('.template-item');
    const title = templateItem?.querySelector('.template-title')?.textContent?.trim() || '';
    return title.replace('Template', '').trim();
}

function showFieldError(input, message) {
    input.classList.remove('valid');
    input.classList.add('invalid');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    
    input.parentNode.appendChild(errorDiv);
}

function showFieldSuccess(input) {
    input.classList.remove('invalid');
    input.classList.add('valid');
    
    // Remove existing error message
    const existingError = input.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function handleFormSubmit(event) {
    if (!validateForm()) {
        event.preventDefault();
        showAlert('Please correct the errors below', 'error');
        return false;
    }
    
    // Show loading state
    showLoadingState();
    
    // Add confirmation for template creation
    const checkboxes = document.querySelectorAll('.template-item input[type="checkbox"]:checked');
            if (checkboxes.length > 0) {
                const confirmed = confirm(
                    'WARNING: This action will create database tables and triggers directly. ' +
                    'This is a potentially dangerous operation. Are you sure you want to continue?'
                );
                
                if (!confirmed) {
            event.preventDefault();
            hideLoadingState();
                    return false;
                }
            }
    
    return true;
}

function handleSearch(searchTerm) {
    if (!searchTerm.trim()) {
        filteredTemplates = [...allTemplates];
    } else {
        const term = searchTerm.toLowerCase();
        filteredTemplates = allTemplates.filter(template => 
            template.name.toLowerCase().includes(term) ||
            template.type.toLowerCase().includes(term) ||
            template.creator.toLowerCase().includes(term)
        );
    }
    
    updateTemplatesDisplay();
}

function updateTemplatesDisplay() {
    if (!templatesList) return;
    
    const templateCards = templatesList.querySelectorAll('.template-card');
    
    templateCards.forEach((card, index) => {
        const template = allTemplates[index];
        const isVisible = filteredTemplates.includes(template);
        card.style.display = isVisible ? '' : 'none';
    });
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    filteredTemplates = [...allTemplates];
    updateTemplatesDisplay();
}

function resetForm() {
    // Uncheck all checkboxes
    const checkboxes = document.querySelectorAll('.template-item input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Clear all inputs
    const inputs = document.querySelectorAll('.template-item input[type="text"]');
    inputs.forEach(input => {
        input.value = '';
        input.disabled = true;
        input.classList.remove('valid', 'invalid');
    });
    
    // Remove selection states
    const templateItems = document.querySelectorAll('.template-item');
    templateItems.forEach(item => {
        item.classList.remove('selected');
    });
    
    // Remove error messages
    document.querySelectorAll('.field-error').forEach(error => {
        error.remove();
    });
    
    // Reset submit button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
    }
}

function refreshPage() {
    window.location.reload();
}

function exportTemplates() {
    if (filteredTemplates.length === 0) {
        showAlert('No templates to export', 'warning');
        return;
    }
    
    let csv = [];
    csv.push(['Template Name', 'Type', 'Created Date', 'Created By']);
    
    filteredTemplates.forEach(template => {
        csv.push([
            template.name,
            template.type,
            template.date,
            template.creator
        ]);
    });
    
    const csvContent = csv.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'rate_templates_export.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function viewTemplate(templateName) {
    showAlert(`Viewing template: ${templateName}`, 'info');
    // Add your view template logic here
}

function deleteTemplate(templateName) {
    if (confirm(`Are you sure you want to delete the template "${templateName}"?`)) {
        showAlert(`Deleting template: ${templateName}`, 'info');
        // Add your delete template logic here
    }
}

function showLoadingState(message = 'Creating templates...') {
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
        <div class="spinner" style="width: 2rem; height: 2rem; border: 3px solid #f3f4f6; border-top: 3px solid #1e40af; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
        <p style="margin: 0; color: #374151;">${message}</p>
    `;
    
    overlay.appendChild(loadingDiv);
    document.body.appendChild(overlay);
}

function hideLoadingState() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

function showAlert(message, type = 'info') {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    // Add icon based on type
    const icons = {
        success: 'check-circle',
        error: 'exclamation-triangle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    
    alert.innerHTML = `
        <i class="fas fa-${icons[type] || icons.info} alert-icon"></i>
        <span>${message}</span>
    `;
    
    // Insert at the top of the main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.insertBefore(alert, mainContent.firstChild);
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// Utility function for debouncing
function debounce(func, wait) {
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

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .field-error {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .template-name-input.valid {
        border-color: #10b981;
        background-color: #f0fdf4;
    }
    
    .template-name-input.invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
`;
document.head.appendChild(style);