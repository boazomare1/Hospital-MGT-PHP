// Lab Data Import Modern JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeSidebar();
    initializeFormValidation();
    initializeAlerts();
    initializeFileUpload();
    initializeDataTable();
});

// Sidebar functionality
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('leftSidebar');
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

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                mainContainer.classList.add('sidebar-collapsed');
            }
        }
    });
}

// Form validation
function initializeFormValidation() {
    const form = document.getElementById('form1');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });
    }
}

function validateForm() {
    const fileInput = document.getElementById('upload_file');

    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        showAlert('Please select a file to upload', 'error');
        if (fileInput) fileInput.focus();
        return false;
    }

    // Validate file type
    const file = fileInput.files[0];
    const allowedTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv'
    ];
    
    if (!allowedTypes.includes(file.type)) {
        showAlert('Please select a valid Excel or CSV file', 'error');
        return false;
    }

    // Validate file size (max 10MB)
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        showAlert('File size must be less than 10MB', 'error');
        return false;
    }

    return true;
}

// Alert system
function initializeAlerts() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    const icon = getAlertIcon(type);
    alert.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; margin-left: auto; cursor: pointer;">
            <i class="fas fa-times"></i>
        </button>
    `;

    alertContainer.appendChild(alert);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
}

function getAlertIcon(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

// File upload functionality
function initializeFileUpload() {
    const fileUploadContainer = document.querySelector('.file-upload-container');
    const fileInput = document.getElementById('upload_file');
    const fileUploadBtn = document.querySelector('.file-upload-btn');

    if (fileUploadContainer && fileInput && fileUploadBtn) {
        // Click to upload
        fileUploadBtn.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop
        fileUploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.add('dragover');
        });

        fileUploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
        });

        fileUploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });
    }
}

function handleFileSelect(file) {
    const fileInfo = document.querySelector('.file-info');
    if (fileInfo) {
        fileInfo.innerHTML = `
            <div class="file-name">${file.name}</div>
            <div class="file-size">${formatFileSize(file.size)}</div>
        `;
    }

    // Validate file
    const allowedTypes = [
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv'
    ];
    
    if (!allowedTypes.includes(file.type)) {
        showAlert('Please select a valid Excel or CSV file', 'error');
        return;
    }

    // Validate file size
    const maxSize = 10 * 1024 * 1024; // 10MB
    if (file.size > maxSize) {
        showAlert('File size must be less than 10MB', 'error');
        return;
    }

    showAlert('File selected successfully', 'success');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Data table functionality
function initializeDataTable() {
    // Add any data table specific initialization here
    console.log('Data table initialized');
}

// Progress tracking
function showProgress(percent, message) {
    const progressContainer = document.querySelector('.progress-container');
    if (!progressContainer) return;

    const progressFill = progressContainer.querySelector('.progress-fill');
    const progressText = progressContainer.querySelector('.progress-text');
    
    if (progressFill) {
        progressFill.style.width = percent + '%';
    }
    
    if (progressText) {
        progressText.textContent = message;
    }
}

function hideProgress() {
    const progressContainer = document.querySelector('.progress-container');
    if (progressContainer) {
        progressContainer.style.display = 'none';
    }
}

// Utility functions
function refreshData() {
    showAlert('Refreshing data...', 'info');
    location.reload();
}

function downloadTemplate() {
    showAlert('Downloading template...', 'info');
    
    // Create a simple CSV template
    const csvContent = 'Item Code,Item Name,Short Code,Display Name,Category Name,Sample Type,Sales Price,External Lab,Status,Radiology,Income Ledger Code\n' +
                      'LAB001,Blood Sugar Test,BS,Blood Sugar,Biochemistry,Blood,150.00,No,Active,No,4001\n' +
                      'LAB002,Complete Blood Count,CBC,Complete Blood Count,Hematology,Blood,200.00,No,Active,No,4002';
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'lab_data_template.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showAlert('Template downloaded successfully', 'success');
}

// Form submission with progress
$(document).ready(function() {
    $('#form1').on('submit', function(e) {
        const fileInput = document.getElementById('upload_file');
        if (fileInput && fileInput.files.length > 0) {
            // Show progress
            showProgress(0, 'Uploading file...');
            
            // Simulate progress (in real implementation, this would be handled by the server)
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                showProgress(progress, 'Processing file...');
                
                if (progress >= 100) {
                    clearInterval(interval);
                    showProgress(100, 'Import complete!');
                    setTimeout(() => {
                        hideProgress();
                    }, 2000);
                }
            }, 200);
        }
    });
});
