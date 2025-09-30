// Package Upload Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('leftSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    // Sidebar toggle functionality
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    // Initialize upload functionality
    initializeUpload();
});

function initializeUpload() {
    // Initialize file upload area
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    
    if (uploadArea && fileInput) {
        // Drag and drop functionality
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });
        
        // Click to upload
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });
        
        // File input change
        fileInput.addEventListener('change', function(e) {
            handleFiles(e.target.files);
        });
    }
    
    // Initialize form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function handleFiles(files) {
    const fileList = document.getElementById('fileList');
    if (!fileList) return;
    
    Array.from(files).forEach(file => {
        if (validateFile(file)) {
            addFileToList(file);
        }
    });
}

function validateFile(file) {
    const allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'application/csv'];
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    if (!allowedTypes.includes(file.type)) {
        showAlert('Please upload only CSV files', 'error');
        return false;
    }
    
    if (file.size > maxSize) {
        showAlert('File size must be less than 10MB', 'error');
        return false;
    }
    
    return true;
}

function addFileToList(file) {
    const fileList = document.getElementById('fileList');
    if (!fileList) return;
    
    const fileItem = document.createElement('div');
    fileItem.className = 'file-item';
    fileItem.innerHTML = `
        <div class="file-info">
            <i class="fas fa-file-csv file-icon"></i>
            <div class="file-details">
                <h4>${file.name}</h4>
                <p>${formatFileSize(file.size)} • ${file.type}</p>
            </div>
        </div>
        <div class="file-actions">
            <button class="btn btn-outline" onclick="previewFile('${file.name}')">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button class="btn btn-outline" onclick="removeFile(this)">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
    `;
    
    fileList.appendChild(fileItem);
    updateUploadButton();
}

function removeFile(button) {
    const fileItem = button.closest('.file-item');
    fileItem.remove();
    updateUploadButton();
}

function previewFile(fileName) {
    showAlert(`Previewing file: ${fileName}`, 'info');
    // Add preview functionality here
}

function updateUploadButton() {
    const fileList = document.getElementById('fileList');
    const uploadBtn = document.getElementById('uploadBtn');
    
    if (fileList && uploadBtn) {
        const hasFiles = fileList.children.length > 0;
        uploadBtn.disabled = !hasFiles;
        uploadBtn.textContent = hasFiles ? 'Upload Files' : 'No Files Selected';
    }
}

function uploadFiles() {
    const fileList = document.getElementById('fileList');
    if (!fileList || fileList.children.length === 0) {
        showAlert('Please select files to upload', 'error');
        return;
    }
    
    showAlert('Uploading files...', 'info');
    updateProgress(0);
    
    // Simulate upload progress
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 20;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
            showAlert('Files uploaded successfully!', 'success');
        }
        updateProgress(progress);
    }, 200);
}

function updateProgress(percentage) {
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');
    
    if (progressFill) {
        progressFill.style.width = percentage + '%';
    }
    
    if (progressText) {
        progressText.textContent = `Uploading... ${Math.round(percentage)}%`;
    }
}

function validateForm() {
    const requiredFields = document.querySelectorAll('[required]');
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            showAlert(`Please fill in ${field.previousElementSibling.textContent}`, 'error');
            field.focus();
            return false;
        }
    }
    
    return true;
}

function clearUpload() {
    const fileList = document.getElementById('fileList');
    const fileInput = document.getElementById('fileInput');
    
    if (fileList) {
        fileList.innerHTML = '';
    }
    
    if (fileInput) {
        fileInput.value = '';
    }
    
    updateUploadButton();
    showAlert('Upload area cleared', 'info');
}

function downloadTemplate() {
    showAlert('Downloading CSV template...', 'info');
    // Add template download functionality here
}

function exportResults() {
    showAlert('Exporting results...', 'info');
    // Add export functionality here
}

// Utility functions
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function showAlert(message, type = 'info') {
    const alertContainer = document.querySelector('.alert-container');
    if (alertContainer) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} alert-icon"></i>
            ${message}
        `;
        alertContainer.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
}

// Export functions for global access
window.uploadFiles = uploadFiles;
window.clearUpload = clearUpload;
window.downloadTemplate = downloadTemplate;
window.exportResults = exportResults;
window.previewFile = previewFile;
window.removeFile = removeFile;
