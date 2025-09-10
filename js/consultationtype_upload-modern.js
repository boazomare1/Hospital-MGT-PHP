/**
 * Modern JavaScript for Consultation Type Upload
 * Handles file upload, validation, progress tracking, and modern interactions
 */

// Modern ES6+ JavaScript with enhanced functionality
class ConsultationTypeUpload {
    constructor() {
        this.allowedFileTypes = ['.xls', '.xlsx', '.csv'];
        this.maxFileSize = 10 * 1024 * 1024; // 10MB
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupFileUpload();
        this.setupFormValidation();
    }

    setupEventListeners() {
        // Form submission handler
        const form = document.querySelector('form[name="form1"]');
        if (form) {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                }
            });
        }

        // File input change handler
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                this.handleFileSelect(e.target.files[0]);
            });
        }
    }

    setupFileUpload() {
        const uploadArea = this.createUploadArea();
        const fileInput = document.getElementById('upload_file');
        
        if (fileInput && uploadArea) {
            // Replace the file input with modern upload area
            fileInput.parentNode.insertBefore(uploadArea, fileInput);
            fileInput.style.display = 'none';
            
            // Connect the upload area to the file input
            uploadArea.addEventListener('click', () => {
                fileInput.click();
            });
            
            // Drag and drop functionality
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });
            
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('dragover');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    this.handleFileSelect(files[0]);
                    fileInput.files = files;
                }
            });
        }
    }

    createUploadArea() {
        const uploadArea = document.createElement('div');
        uploadArea.className = 'file-upload-area';
        uploadArea.innerHTML = `
            <div class="file-upload-icon">📁</div>
            <div class="file-upload-text">Click to select file or drag and drop</div>
            <div class="file-upload-hint">Supported formats: Excel (.xls, .xlsx), CSV (.csv)</div>
            <div class="file-upload-hint">Maximum file size: 10MB</div>
        `;
        return uploadArea;
    }

    setupFormValidation() {
        // Add modern validation attributes
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            fileInput.setAttribute('accept', '.xls,.xlsx,.csv');
        }
    }

    handleFileSelect(file) {
        if (!file) return;

        const validation = this.validateFile(file);
        const uploadArea = document.querySelector('.file-upload-area');
        
        if (validation.isValid) {
            this.showFileSelected(file, uploadArea);
            this.showAlert('File selected successfully!', 'success');
        } else {
            this.showAlert(validation.message, 'error');
            this.resetFileInput();
        }
    }

    validateFile(file) {
        // Check file size
        if (file.size > this.maxFileSize) {
            return {
                isValid: false,
                message: 'File size exceeds 10MB limit.'
            };
        }

        // Check file type
        const fileName = file.name.toLowerCase();
        const isValidType = this.allowedFileTypes.some(type => 
            fileName.endsWith(type)
        );

        if (!isValidType) {
            return {
                isValid: false,
                message: 'Invalid file type. Please select Excel (.xls, .xlsx) or CSV (.csv) file.'
            };
        }

        return { isValid: true };
    }

    showFileSelected(file, uploadArea) {
        const fileInfo = document.createElement('div');
        fileInfo.className = 'file-selected';
        fileInfo.innerHTML = `
            <strong>Selected File:</strong> ${file.name}<br>
            <small>Size: ${this.formatFileSize(file.size)}</small>
        `;
        
        // Remove existing file info
        const existingInfo = uploadArea.querySelector('.file-selected');
        if (existingInfo) {
            existingInfo.remove();
        }
        
        uploadArea.appendChild(fileInfo);
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    validateForm() {
        const fileInput = document.getElementById('upload_file');
        
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            this.showAlert('Please select a file to upload.', 'error');
            return false;
        }

        const file = fileInput.files[0];
        const validation = this.validateFile(file);
        
        if (!validation.isValid) {
            this.showAlert(validation.message, 'error');
            return false;
        }

        return true;
    }

    showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.textContent = message;
        
        // Insert at the top of the form
        const form = document.querySelector('form[name="form1"]');
        if (form) {
            form.insertBefore(alertDiv, form.firstChild);
        }

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }

    resetFileInput() {
        const fileInput = document.getElementById('upload_file');
        if (fileInput) {
            fileInput.value = '';
        }
        
        const uploadArea = document.querySelector('.file-upload-area');
        if (uploadArea) {
            const fileInfo = uploadArea.querySelector('.file-selected');
            if (fileInfo) {
                fileInfo.remove();
            }
        }
    }

    // Show upload progress
    showProgress(percent) {
        let progressContainer = document.querySelector('.upload-progress');
        if (!progressContainer) {
            progressContainer = document.createElement('div');
            progressContainer.className = 'upload-progress';
            progressContainer.innerHTML = '<div class="upload-progress-bar"></div>';
            
            const form = document.querySelector('form[name="form1"]');
            if (form) {
                form.appendChild(progressContainer);
            }
        }
        
        const progressBar = progressContainer.querySelector('.upload-progress-bar');
        if (progressBar) {
            progressBar.style.width = percent + '%';
        }
        
        progressContainer.style.display = 'block';
    }

    // Hide upload progress
    hideProgress() {
        const progressContainer = document.querySelector('.upload-progress');
        if (progressContainer) {
            progressContainer.style.display = 'none';
        }
    }

    // Simulate upload progress (for demonstration)
    simulateUpload() {
        let percent = 0;
        const interval = setInterval(() => {
            percent += 10;
            this.showProgress(percent);
            
            if (percent >= 100) {
                clearInterval(interval);
                setTimeout(() => {
                    this.hideProgress();
                    this.showAlert('File uploaded successfully!', 'success');
                }, 500);
            }
        }, 200);
    }
}

// Legacy function compatibility
window.dataimport1verify = function() {
    const upload = new ConsultationTypeUpload();
    return upload.validateForm();
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ConsultationTypeUpload();
});

// Initialize with jQuery if available
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        new ConsultationTypeUpload();
    });
}
