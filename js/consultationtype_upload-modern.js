// Consultation Type Upload Modern JavaScript
let selectedFile = null;
let uploadProgress = 0;

// DOM Elements
let fileInput, submitBtn, form, fileInfo, progressContainer, progressFill, progressText;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFileUpload();
    setupFormValidation();
    setupKeyboardShortcuts();
    initializeDragAndDrop();
});

function initializeElements() {
    fileInput = document.getElementById('upload_file');
    submitBtn = document.querySelector('input[name="Submit"]');
    form = document.querySelector('form[name="form1"]');
    fileInfo = document.getElementById('fileInfo');
    progressContainer = document.getElementById('progressContainer');
    progressFill = document.getElementById('progressFill');
    progressText = document.getElementById('progressText');
}

function setupEventListeners() {
    if (submitBtn) {
        submitBtn.addEventListener('click', handleFormSubmit);
    }
    
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
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

function setupFileUpload() {
    const fileUploadArea = document.querySelector('.file-upload-area');
    const fileInputLabel = document.querySelector('.file-input-label');
    
    if (fileInputLabel && fileInput) {
        fileInputLabel.addEventListener('click', function() {
            fileInput.click();
        });
    }
}

function setupFormValidation() {
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                showAlert('Please select a valid Excel file to upload.', 'error');
            }
        });
    }
}

function validateForm() {
    let isValid = true;
    const errors = [];
    
    // Validate file selection
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        errors.push('Please select a file to upload');
        isValid = false;
    } else {
        const file = fileInput.files[0];
        
        // Validate file type
        const allowedTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv'
        ];
        
        if (!allowedTypes.includes(file.type) && !file.name.match(/\.(xls|xlsx|csv)$/i)) {
            errors.push('Please select a valid Excel file (.xls, .xlsx) or CSV file');
            isValid = false;
        }
        
        // Validate file size (max 10MB)
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            errors.push('File size must be less than 10MB');
            isValid = false;
        }
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
    showProgress();
    
    // Add loading state to submit button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.value = 'Uploading...';
    }
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        selectedFile = file;
        displayFileInfo(file);
        updateFileUploadArea(file);
    }
}

function displayFileInfo(file) {
    if (!fileInfo) {
        createFileInfoElement();
    }
    
    const fileInfoElement = document.getElementById('fileInfo');
    if (fileInfoElement) {
        const fileSize = formatFileSize(file.size);
        const fileType = getFileType(file.name);
        
        fileInfoElement.innerHTML = `
            <div class="file-info-header">
                <i class="fas fa-file-excel file-info-icon"></i>
                <span class="file-info-name">${file.name}</span>
            </div>
            <div class="file-info-details">
                <div><strong>Size:</strong> ${fileSize}</div>
                <div><strong>Type:</strong> ${fileType}</div>
                <div><strong>Last Modified:</strong> ${new Date(file.lastModified).toLocaleDateString()}</div>
            </div>
        `;
        fileInfoElement.style.display = 'block';
    }
}

function createFileInfoElement() {
    const fileInfoDiv = document.createElement('div');
    fileInfoDiv.id = 'fileInfo';
    fileInfoDiv.className = 'file-info';
    
    const formContainer = document.querySelector('.upload-form-container');
    if (formContainer) {
        formContainer.appendChild(fileInfoDiv);
    }
}

function updateFileUploadArea(file) {
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (fileUploadArea) {
        fileUploadArea.classList.add('file-selected');
        fileUploadArea.innerHTML = `
            <i class="fas fa-file-excel file-upload-icon"></i>
            <div class="file-upload-text">File Selected: ${file.name}</div>
            <div class="file-upload-subtext">Click to select a different file</div>
            <label for="upload_file" class="file-input-label">
                <i class="fas fa-upload"></i>
                Choose Different File
            </label>
        `;
        
        // Re-attach event listener
        const newLabel = fileUploadArea.querySelector('.file-input-label');
        if (newLabel && fileInput) {
            newLabel.addEventListener('click', function() {
                fileInput.click();
            });
        }
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function getFileType(filename) {
    const extension = filename.split('.').pop().toLowerCase();
    const types = {
        'xls': 'Excel 97-2003',
        'xlsx': 'Excel 2007+',
        'csv': 'CSV File'
    };
    return types[extension] || 'Unknown';
}

function initializeDragAndDrop() {
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (!fileUploadArea) return;
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    fileUploadArea.addEventListener('drop', handleDrop, false);
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (fileUploadArea) {
        fileUploadArea.classList.add('dragover');
    }
}

function unhighlight(e) {
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (fileUploadArea) {
        fileUploadArea.classList.remove('dragover');
    }
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        const file = files[0];
        if (fileInput) {
            // Create a new FileList-like object
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }
}

function showLoadingState() {
    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        alertContainer.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-spinner fa-spin"></i>
                Uploading your file, please wait...
            </div>
        `;
    }
}

function showProgress() {
    if (progressContainer) {
        progressContainer.style.display = 'block';
        simulateProgress();
    }
}

function simulateProgress() {
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 90) {
            progress = 90;
        }
        
        if (progressFill) {
            progressFill.style.width = progress + '%';
        }
        
        if (progressText) {
            progressText.textContent = `Uploading... ${Math.round(progress)}%`;
        }
        
        if (progress >= 90) {
            clearInterval(interval);
        }
    }, 200);
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
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
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
        // Ctrl + U to focus file input
        if (e.ctrlKey && e.key === 'u') {
            e.preventDefault();
            if (fileInput) {
                fileInput.click();
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
    if (fileInput) {
        fileInput.value = '';
    }
    
    selectedFile = null;
    
    // Reset file upload area
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (fileUploadArea) {
        fileUploadArea.classList.remove('file-selected', 'dragover');
        fileUploadArea.innerHTML = `
            <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
            <div class="file-upload-text">Drag & Drop your Excel file here</div>
            <div class="file-upload-subtext">or click to browse</div>
            <label for="upload_file" class="file-input-label">
                <i class="fas fa-upload"></i>
                Choose File
            </label>
        `;
        
        // Re-attach event listener
        const newLabel = fileUploadArea.querySelector('.file-input-label');
        if (newLabel && fileInput) {
            newLabel.addEventListener('click', function() {
                fileInput.click();
            });
        }
    }
    
    // Hide file info
    const fileInfoElement = document.getElementById('fileInfo');
    if (fileInfoElement) {
        fileInfoElement.style.display = 'none';
    }
    
    // Hide progress
    if (progressContainer) {
        progressContainer.style.display = 'none';
    }
    
    showAlert('Form cleared successfully.', 'success');
}

function refreshPage() {
    window.location.reload();
}

function downloadSampleFile() {
    // This would typically trigger a download of the sample file
    showAlert('Sample file download started.', 'info');
}

// Backward compatibility functions
function dataimport1verify() {
    return validateForm();
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Consultation Type Upload page initialized');
    
    // Show success/error messages if redirected from upload
    const urlParams = new URLSearchParams(window.location.search);
    const upload = urlParams.get('upload');
    if (upload === 'success') {
        showAlert('File uploaded successfully!', 'success');
    } else if (upload === 'failed') {
        showAlert('File upload failed. Please try again.', 'error');
    }
    
    // Initialize file upload area
    const fileUploadArea = document.querySelector('.file-upload-area');
    if (fileUploadArea && !fileUploadArea.innerHTML.trim()) {
        fileUploadArea.innerHTML = `
            <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
            <div class="file-upload-text">Drag & Drop your Excel file here</div>
            <div class="file-upload-subtext">or click to browse</div>
            <label for="upload_file" class="file-input-label">
                <i class="fas fa-upload"></i>
                Choose File
            </label>
        `;
        
        // Attach event listener
        const label = fileUploadArea.querySelector('.file-input-label');
        if (label && fileInput) {
            label.addEventListener('click', function() {
                fileInput.click();
            });
        }
    }
});