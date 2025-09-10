// Stock Opening Entry Modern JavaScript

// DOM elements
let fileInput;
let fileUploadArea;
let selectedFileDiv;
let submitBtn;
let uploadProgress;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupSidebarToggle();
    setupFileUpload();
});

// Initialize DOM elements
function initializeElements() {
    fileInput = document.getElementById('uploadedfile');
    fileUploadArea = document.querySelector('.file-upload-area');
    selectedFileDiv = document.querySelector('.selected-file');
    submitBtn = document.querySelector('.submit-btn');
    uploadProgress = document.querySelector('.upload-progress');
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }

    // File input change
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }

    // Sidebar toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

// Setup sidebar toggle functionality
function setupSidebarToggle() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContainer = document.querySelector('.main-container-with-sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            mainContainer.classList.toggle('sidebar-collapsed');
        });
    }
}

// Setup file upload functionality
function setupFileUpload() {
    if (!fileUploadArea || !fileInput) return;

    // Click to select file
    fileUploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag and drop functionality
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });
}

// Handle file selection
function handleFileSelect() {
    const file = fileInput.files[0];
    if (!file) return;

    // Validate file type
    if (!isValidFileType(file)) {
        showAlert('Please select a valid TAB delimited file (.txt)', 'error');
        resetFileInput();
        return;
    }

    // Show selected file info
    showSelectedFile(file);
    
    // Enable submit button
    if (submitBtn) {
        submitBtn.disabled = false;
    }
}

// Validate file type
function isValidFileType(file) {
    const allowedTypes = ['text/plain', 'text/tab-separated-values'];
    const allowedExtensions = ['.txt', '.tab'];
    
    // Check MIME type
    if (allowedTypes.includes(file.type)) {
        return true;
    }
    
    // Check file extension
    const fileName = file.name.toLowerCase();
    return allowedExtensions.some(ext => fileName.endsWith(ext));
}

// Show selected file information
function showSelectedFile(file) {
    if (!selectedFileDiv) return;

    const fileName = file.name;
    const fileSize = formatFileSize(file.size);

    selectedFileDiv.innerHTML = `
        <div class="selected-file-name">
            <i class="fas fa-file-alt"></i>
            ${fileName}
        </div>
        <div class="selected-file-size">
            Size: ${fileSize}
        </div>
    `;

    selectedFileDiv.classList.add('show');
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Reset file input
function resetFileInput() {
    if (fileInput) {
        fileInput.value = '';
    }
    if (selectedFileDiv) {
        selectedFileDiv.classList.remove('show');
    }
    if (submitBtn) {
        submitBtn.disabled = true;
    }
}

// Handle form submission
function handleFormSubmit(event) {
    event.preventDefault();
    
    const file = fileInput.files[0];
    if (!file) {
        showAlert('Please select a file to upload.', 'error');
        return;
    }

    if (!isValidFileType(file)) {
        showAlert('Please select a valid TAB delimited file.', 'error');
        return;
    }

    // Show upload progress
    showUploadProgress();
    
    // Submit the form
    event.target.submit();
}

// Show upload progress
function showUploadProgress() {
    if (!uploadProgress) return;
    
    uploadProgress.classList.add('show');
    
    // Simulate progress (since we can't track actual upload progress with basic form submission)
    const progressFill = uploadProgress.querySelector('.progress-fill');
    const progressText = uploadProgress.querySelector('.progress-text');
    
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 90) progress = 90;
        
        if (progressFill) progressFill.style.width = progress + '%';
        if (progressText) progressText.textContent = `Uploading... ${Math.round(progress)}%`;
        
        if (progress >= 90) {
            clearInterval(interval);
        }
    }, 200);
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas fa-${getAlertIcon(type)} alert-icon"></i>
        <span>${message}</span>
    `;

    alertContainer.appendChild(alert);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Get alert icon based on type
function getAlertIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-triangle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

// Reset form
function resetForm() {
    resetFileInput();
    showAlert('Form has been reset.', 'info');
}

// Refresh page
function refreshPage() {
    window.location.reload();
}

// Download sample file
function downloadSampleFile() {
    const link = document.createElement('a');
    link.href = 'tab_file_dump/openingstockentry.xlsx';
    link.download = 'openingstockentry.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Sample file download started.', 'info');
}















