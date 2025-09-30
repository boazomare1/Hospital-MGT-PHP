// Doctors Upload - Modern JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize file upload functionality
    initializeFileUpload();
    
    // Initialize form functionality
    initializeForms();
    
    // Initialize responsive features
    initializeResponsive();
    
    // Initialize drag and drop
    initializeDragAndDrop();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
}

// File upload functionality
function initializeFileUpload() {
    const fileInput = document.getElementById('upload_file');
    const fileDisplay = document.querySelector('.file-input-display');
    const fileText = document.querySelector('.file-input-text');
    const fileHint = document.querySelector('.file-input-hint');
    
    if (fileInput && fileDisplay) {
        fileInput.addEventListener('change', function(event) {
            handleFileSelection(event.target.files[0]);
        });
        
        // Click to select file
        fileDisplay.addEventListener('click', function() {
            fileInput.click();
        });
    }
}

// Drag and drop functionality
function initializeDragAndDrop() {
    const fileDisplay = document.querySelector('.file-input-display');
    const fileInput = document.getElementById('upload_file');
    
    if (fileDisplay && fileInput) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileDisplay.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            fileDisplay.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            fileDisplay.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        fileDisplay.addEventListener('drop', handleDrop, false);
    }
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    const fileDisplay = document.querySelector('.file-input-display');
    fileDisplay.classList.add('drag-over');
}

function unhighlight(e) {
    const fileDisplay = document.querySelector('.file-input-display');
    fileDisplay.classList.remove('drag-over');
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        const fileInput = document.getElementById('upload_file');
        fileInput.files = files;
        handleFileSelection(files[0]);
    }
}

// Handle file selection
function handleFileSelection(file) {
    const fileDisplay = document.querySelector('.file-input-display');
    const fileText = document.querySelector('.file-input-text');
    const fileHint = document.querySelector('.file-input-hint');
    
    if (!file) return;
    
    // Validate file type
    const allowedTypes = ['.xls', '.xlsx'];
    const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
    
    if (!allowedTypes.includes(fileExtension)) {
        showFileError('Please select a valid Excel file (.xls or .xlsx)');
        return;
    }
    
    // Validate file size (10MB limit)
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        showFileError('File size must be less than 10MB');
        return;
    }
    
    // Show success state
    fileDisplay.classList.add('file-selected');
    fileDisplay.classList.remove('error');
    fileText.textContent = `Selected: ${file.name}`;
    fileHint.textContent = `Size: ${formatFileSize(file.size)}`;
    
    // Update icon
    const icon = fileDisplay.querySelector('i');
    icon.className = 'fas fa-file-excel';
    icon.style.color = '#10b981';
}

// Show file error
function showFileError(message) {
    const fileDisplay = document.querySelector('.file-input-display');
    const fileText = document.querySelector('.file-input-text');
    const fileHint = document.querySelector('.file-input-hint');
    const icon = fileDisplay.querySelector('i');
    
    fileDisplay.classList.add('error');
    fileDisplay.classList.remove('file-selected');
    fileText.textContent = message;
    fileHint.textContent = 'Please try again';
    icon.className = 'fas fa-exclamation-triangle';
    icon.style.color = '#ef4444';
    
    // Reset after 3 seconds
    setTimeout(() => {
        resetFileInput();
    }, 3000);
}

// Reset file input
function resetFileInput() {
    const fileInput = document.getElementById('upload_file');
    const fileDisplay = document.querySelector('.file-input-display');
    const fileText = document.querySelector('.file-input-text');
    const fileHint = document.querySelector('.file-input-hint');
    const icon = fileDisplay.querySelector('i');
    
    fileInput.value = '';
    fileDisplay.classList.remove('file-selected', 'error');
    fileText.textContent = 'Choose Excel file or drag and drop here';
    fileHint.textContent = 'Supports .xls and .xlsx files';
    icon.className = 'fas fa-cloud-upload-alt';
    icon.style.color = '';
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form functionality
function initializeForms() {
    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
            }
        });
    });
    
    // Real-time form validation
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            clearFieldError(this);
        });
    });
}

// Form validation
function validateForm(form) {
    let isValid = true;
    const fileInput = document.getElementById('upload_file');
    
    // Check if file is selected
    if (!fileInput.files || fileInput.files.length === 0) {
        showFileError('Please select a file to upload');
        isValid = false;
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldType = field.type;
    let isValid = true;
    let errorMessage = '';
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    }
    
    // File validation
    if (fieldType === 'file' && field.files.length > 0) {
        const file = field.files[0];
        const allowedTypes = ['.xls', '.xlsx'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        
        if (!allowedTypes.includes(fileExtension)) {
            isValid = false;
            errorMessage = 'Please select a valid Excel file';
        }
        
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            isValid = false;
            errorMessage = 'File size must be less than 10MB';
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc2626';
    errorDiv.style.fontSize = '0.8rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Responsive functionality
function initializeResponsive() {
    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('leftSidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
    
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('menuToggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('open');
        });
    }
}

// Global functions for form actions
function refreshPage() {
    if (confirm('Are you sure you want to refresh the page? Any unsaved changes will be lost.')) {
        window.location.reload();
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        const form = document.querySelector('form');
        if (form) {
            form.reset();
            resetFileInput();
            // Clear any error states
            const errorFields = form.querySelectorAll('.error');
            errorFields.forEach(field => clearFieldError(field));
        }
    }
}

function viewSampleFile() {
    // Open sample file in new tab
    window.open('sample_excels/doctors_upload_sample.xls', '_blank');
}

// Enhanced file upload with progress
function uploadFileWithProgress(form) {
    const fileInput = document.getElementById('upload_file');
    const file = fileInput.files[0];
    
    if (!file) {
        showFileError('Please select a file to upload');
        return false;
    }
    
    // Show loading overlay
    showLoadingOverlay();
    
    // Create progress bar
    createProgressBar();
    
    // Simulate progress (in real implementation, this would be actual upload progress)
    simulateProgress();
    
    return true;
}

function createProgressBar() {
    const form = document.querySelector('.upload-form');
    const progressHTML = `
        <div class="upload-progress" id="uploadProgress">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-text" id="progressText">Uploading file...</div>
        </div>
    `;
    
    form.insertAdjacentHTML('beforeend', progressHTML);
    document.getElementById('uploadProgress').style.display = 'block';
}

function simulateProgress() {
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');
    let progress = 0;
    
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;
        
        progressFill.style.width = progress + '%';
        
        if (progress < 30) {
            progressText.textContent = 'Reading file...';
        } else if (progress < 60) {
            progressText.textContent = 'Validating data...';
        } else if (progress < 90) {
            progressText.textContent = 'Processing records...';
        } else {
            progressText.textContent = 'Finalizing upload...';
        }
        
        if (progress >= 100) {
            clearInterval(interval);
            setTimeout(() => {
                hideLoadingOverlay();
                document.getElementById('uploadProgress').style.display = 'none';
            }, 500);
        }
    }, 200);
}

// Loading overlay functionality
function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'loadingOverlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    `;
    
    const content = document.createElement('div');
    content.style.cssText = `
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    `;
    
    content.innerHTML = `
        <div style="margin-bottom: 1rem;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1e40af;"></i>
        </div>
        <p style="margin: 0; font-weight: 600;">Processing File Upload...</p>
        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem; color: #666;">Please wait while we import the doctor data.</p>
    `;
    
    overlay.appendChild(content);
    document.body.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.remove();
    }
}

// Form submission with enhanced validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
                return false;
            }
            
            // Show loading overlay
            showLoadingOverlay();
            
            // Allow form to submit normally
            return true;
        });
    }
});

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

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    // Ctrl + R to refresh
    if (event.ctrlKey && event.key === 'r') {
        event.preventDefault();
        refreshPage();
    }
    
    // Escape to close sidebar on mobile
    if (event.key === 'Escape') {
        const sidebar = document.getElementById('leftSidebar');
        if (sidebar && window.innerWidth <= 768) {
            sidebar.classList.remove('open');
        }
    }
    
    // Ctrl + U to focus file input
    if (event.ctrlKey && event.key === 'u') {
        event.preventDefault();
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            fileInput.click();
        }
    }
});

// Add CSS for enhanced styling
const style = document.createElement('style');
style.textContent = `
    .form-input.error {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }
    
    .file-input-display.drag-over {
        border-color: #1e40af;
        background: rgba(30, 64, 175, 0.1);
        transform: scale(1.02);
    }
    
    .file-input-display.file-selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }
    
    .file-input-display.error {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }
    
    .upload-progress {
        margin-top: 1rem;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background: #f1f5f9;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #1e40af 0%, #3b82f6 100%);
        width: 0%;
        transition: width 0.3s ease;
    }
    
    .progress-text {
        text-align: center;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #64748b;
    }
`;
document.head.appendChild(style);






