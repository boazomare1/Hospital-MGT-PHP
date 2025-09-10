// Chart of Accounts Upload Modern JavaScript

// Global variables
let selectedFile = null;
let uploadInProgress = false;

// DOM elements
let fileInput;
let fileDisplay;
let uploadBtn;
let progressSection;
let progressFill;
let progressText;

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeElements();
    setupEventListeners();
    setupFileDragAndDrop();
});

// Initialize DOM elements
function initializeElements() {
    fileInput = document.getElementById('upload_file');
    fileDisplay = document.getElementById('fileDisplay');
    uploadBtn = document.getElementById('uploadBtn');
    progressSection = document.getElementById('progressSection');
    progressFill = document.getElementById('progressFill');
    progressText = document.getElementById('progressText');
}

// Setup event listeners
function setupEventListeners() {
    // File input change
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }

    // Upload button click
    if (uploadBtn) {
        uploadBtn.addEventListener('click', handleUpload);
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

// Setup drag and drop functionality
function setupFileDragAndDrop() {
    const dropZone = document.querySelector('.file-input');
    
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--medstar-primary)';
            dropZone.style.background = 'var(--background-accent)';
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--border-color)';
            dropZone.style.background = 'var(--background-secondary)';
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--border-color)';
            dropZone.style.background = 'var(--background-secondary)';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect({ target: { files: files } });
            }
        });
    }
}

// Handle file selection
function handleFileSelect(event) {
    const file = event.target.files[0];
    
    if (file) {
        selectedFile = file;
        displaySelectedFile(file);
        validateFile(file);
    }
}

// Display selected file information
function displaySelectedFile(file) {
    const fileDisplay = document.getElementById('fileDisplay');
    if (fileDisplay) {
        fileDisplay.innerHTML = `
            <div class="selected-file-info">
                <i class="fas fa-file-excel"></i>
                <div class="file-details">
                    <div class="file-name">${file.name}</div>
                    <div class="file-size">${formatFileSize(file.size)}</div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" onclick="removeFile()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        fileDisplay.style.display = 'block';
    }

    // Update file input styling
    const fileInput = document.querySelector('.file-input');
    if (fileInput) {
        fileInput.classList.add('has-file');
        fileInput.textContent = 'File selected: ' + file.name;
    }

    // Enable upload button
    if (uploadBtn) {
        uploadBtn.disabled = false;
    }
}

// Remove selected file
function removeFile() {
    selectedFile = null;
    
    // Clear file input
    if (fileInput) {
        fileInput.value = '';
    }

    // Hide file display
    const fileDisplay = document.getElementById('fileDisplay');
    if (fileDisplay) {
        fileDisplay.style.display = 'none';
    }

    // Reset file input styling
    const fileInputDisplay = document.querySelector('.file-input');
    if (fileInputDisplay) {
        fileInputDisplay.classList.remove('has-file');
        fileInputDisplay.textContent = 'Drag and drop Excel file here or click to browse';
    }

    // Disable upload button
    if (uploadBtn) {
        uploadBtn.disabled = true;
    }
}

// Validate selected file
function validateFile(file) {
    const allowedTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv'
    ];
    
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    if (!allowedTypes.includes(file.type) && !file.name.match(/\.(xls|xlsx|csv)$/i)) {
        showAlert('Please select a valid Excel file (.xls, .xlsx) or CSV file.', 'error');
        removeFile();
        return false;
    }
    
    if (file.size > maxSize) {
        showAlert('File size must be less than 10MB.', 'error');
        removeFile();
        return false;
    }
    
    return true;
}

// Handle file upload
function handleUpload() {
    if (!selectedFile) {
        showAlert('Please select a file to upload.', 'error');
        return;
    }

    if (uploadInProgress) {
        return;
    }

    uploadInProgress = true;
    
    // Show progress section
    if (progressSection) {
        progressSection.classList.add('show');
    }

    // Create FormData
    const formData = new FormData();
    formData.append('upload_file', selectedFile);
    formData.append('frmflag1', 'frmflag1');

    // Simulate progress (since we can't track actual upload progress with PHP)
    simulateProgress();

    // Submit form
    const form = document.getElementById('uploadForm');
    if (form) {
        form.submit();
    }
}

// Simulate upload progress
function simulateProgress() {
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 90) {
            progress = 90;
            clearInterval(interval);
        }
        
        if (progressFill) {
            progressFill.style.width = progress + '%';
        }
        
        if (progressText) {
            progressText.textContent = `Uploading... ${Math.round(progress)}%`;
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

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Reset form
function resetForm() {
    removeFile();
    
    // Hide progress section
    if (progressSection) {
        progressSection.classList.remove('show');
    }
    
    // Reset progress bar
    if (progressFill) {
        progressFill.style.width = '0%';
    }
    
    if (progressText) {
        progressText.textContent = 'Ready to upload';
    }
    
    uploadInProgress = false;
}

// Download sample file
function downloadSampleFile() {
    const link = document.createElement('a');
    link.href = 'sample_excels/master_chartofAccounts.xls';
    link.download = 'master_chartofAccounts.xls';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Utility function to escape HTML
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}















