// Chart of Accounts Main Data Import Modern JavaScript

// Global variables
let selectedFile = null;
let importInProgress = false;

// DOM elements
let fileInput;
let fileDisplay;
let importBtn;
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
    fileInput = document.getElementById('uploadedfile');
    fileDisplay = document.getElementById('fileDisplay');
    importBtn = document.getElementById('importBtn');
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

    // Import button click
    if (importBtn) {
        importBtn.addEventListener('click', handleImport);
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
                <i class="fas fa-file-alt"></i>
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

    // Enable import button
    if (importBtn) {
        importBtn.disabled = false;
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
        fileInputDisplay.textContent = 'Drag and drop TAB delimited file here or click to browse';
    }

    // Disable import button
    if (importBtn) {
        importBtn.disabled = true;
    }
}

// Validate selected file
function validateFile(file) {
    const allowedTypes = [
        'text/plain',
        'text/tab-separated-values',
        'application/tab-separated-values'
    ];
    
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    // Check if it's a .txt file or has tab-separated content
    if (!allowedTypes.includes(file.type) && !file.name.match(/\.(txt|tab)$/i)) {
        showAlert('Please select a valid TAB delimited file (.txt) or .tab file.', 'error');
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

// Handle file import
function handleImport() {
    if (!selectedFile) {
        showAlert('Please select a file to import.', 'error');
        return;
    }

    if (importInProgress) {
        return;
    }

    importInProgress = true;
    
    // Show progress section
    if (progressSection) {
        progressSection.classList.add('show');
    }

    // Simulate progress (since we can't track actual import progress with PHP)
    simulateProgress();

    // Submit form
    const form = document.getElementById('importForm');
    if (form) {
        form.submit();
    }
}

// Simulate import progress
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
            progressText.textContent = `Importing data... ${Math.round(progress)}%`;
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
        progressText.textContent = 'Ready to import';
    }
    
    importInProgress = false;
}

// Download sample file
function downloadSampleFile() {
    const link = document.createElement('a');
    link.href = 'tab_file_dump/chartofaccountsmain.xlsx';
    link.download = 'chartofaccountsmain.xlsx';
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















